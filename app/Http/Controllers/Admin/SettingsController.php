<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsFormRequest;
use App\Jobs\SendInternalMail;
use App\Models\InternalSetting;
use App\Models\MailOutbox;
use App\Models\User;
use App\Support\Totp;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class SettingsController extends Controller
{
    public function show(Request $request): View
    {
        $section = match ($request->route()?->getName()) {
            'admin.settings.profile' => 'pages.admin.settings.profile',
            'admin.settings.company' => 'pages.admin.settings.company',
            'admin.settings.notifications' => 'pages.admin.settings.notifications',
            'admin.settings.security' => 'pages.admin.settings.security',
            'admin.settings.integrations' => 'pages.admin.settings.integrations',
            default => abort(404),
        };

        return view($section, ['user' => $request->user(), 'company' => InternalSetting::find('company')->value ?? [], 'outbox' => ($request->user() ?? abort(401))->canModule('integrations') ? MailOutbox::latest()->limit(20)->get(['id', 'recipient', 'subject', 'status', 'attempts', 'last_error', 'sent_at']) : collect()]);
    }

    public function profile(SettingsFormRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $request->user() ?? abort(401);
        $user->name = $data['name'];
        $prefs = $user->preferences ?? [];
        foreach (['phone', 'timezone', 'theme'] as $key) {
            $prefs[$key] = $data[$key] ?? null;
        } $user->preferences = $prefs;
        if ($request->boolean('remove_photo')) {
            $user->avatar_path = null;
        }
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('avatars', 'local');
            abort_if($path === false, 500, 'Não foi possível salvar a foto.');
            $user->avatar_path = $path;
        }
        if (strtolower($data['email']) !== $user->email) {
            $user->pending_email = strtolower($data['email']);
            $url = URL::temporarySignedRoute('admin.settings.email.verify', now()->addHour(), ['email' => $user->pending_email, 'user' => $user->id]);
            MailOutbox::enqueue($user->pending_email, 'Confirme seu novo e-mail', 'Confirme a alteração: '.$url);
        }
        $user->save();

        return back()->with('success', 'Perfil salvo. Alterações de e-mail exigem confirmação no novo endereço.');
    }

    public function verifyEmail(Request $request): RedirectResponse
    {
        $user = $request->user() ?? abort(401);
        abort_unless((int) $request->query('user') === $user->id && $user->pending_email === $request->query('email'), 403);
        abort_if(User::where('email', $user->pending_email)->whereKeyNot($user->id)->exists(), 422, 'E-mail já utilizado.');
        $user->email = $user->pending_email;
        $user->pending_email = null;
        $user->email_verified_at = now();
        $user->save();

        return to_route('admin.settings.profile')->with('success', 'Novo e-mail confirmado.');
    }

    public function company(SettingsFormRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('logo');
        $previous = InternalSetting::find('company')->value ?? [];
        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('company', 'local');
        } else {
            $data['logo_path'] = $previous['logo_path'] ?? null;
        }
        InternalSetting::updateOrCreate(['key' => 'company'], ['value' => $data]);

        return back()->with('success', 'Dados da empresa salvos.');
    }

    public function notifications(SettingsFormRequest $request): RedirectResponse
    {
        $user = $request->user() ?? abort(401);
        $prefs = $user->preferences ?? [];
        $prefs['email_enabled'] = $request->boolean('email_enabled');
        $prefs['project_alerts'] = $request->boolean('project_alerts');
        $prefs['digest_frequency'] = $request->validated('digest_frequency');
        $user->preferences = $prefs;
        $user->save();

        return back()->with('success', 'Preferências salvas.');
    }

    public function security(SettingsFormRequest $request): RedirectResponse
    {
        $user = $request->user() ?? abort(401);
        $user->password = $request->validated('password');
        $user->session_version++;
        $user->remember_token = Str::random(60);
        $user->save();
        $user->tokens()->delete();
        $request->session()->put('session_version', $user->session_version);
        $request->session()->regenerate();
        MailOutbox::enqueue($user->email, 'Senha alterada', 'A senha da sua conta foi alterada. Se não foi você, contate o gestor imediatamente.');

        return back()->with('success', 'Senha atualizada. Outros acessos foram encerrados.');
    }

    public function sessions(SettingsFormRequest $request): RedirectResponse
    {
        $user = $request->user() ?? abort(401);
        $user->session_version++;
        $user->remember_token = Str::random(60);
        $user->save();
        $user->tokens()->delete();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }

    public function photo(Request $request, User $user): StreamedResponse
    {
        abort_unless($request->user()?->id === $user->id || ($request->user() ?? abort(401))->canModule('access'), 403);
        abort_unless($user->avatar_path && Storage::disk('local')->exists($user->avatar_path), 404);

        return Storage::disk('local')->response($user->avatar_path);
    }

    public function logo(): StreamedResponse
    {
        $path = InternalSetting::find('company')->value['logo_path'] ?? null;
        abort_unless(is_string($path) && Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->response($path);
    }

    public function setupTwoFactor(Request $request): RedirectResponse
    {
        abort_if(($request->user() ?? abort(401))->totp_confirmed_at !== null, 409);
        $request->session()->put('totp_setup', Totp::secret());

        return back()->with('success', 'Cadastre a chave no aplicativo autenticador e confirme o código.');
    }

    public function confirmTwoFactor(SettingsFormRequest $request): RedirectResponse
    {
        $secret = $request->session()->get('totp_setup');
        $step = $secret ? Totp::verify($secret, $request->validated('code')) : null;
        if ($step === null) {
            return back()->withErrors(['code' => 'Código inválido.']);
        }
        $user = $request->user() ?? abort(401);
        $user->totp_secret = $secret;
        $user->totp_confirmed_at = now();
        $user->totp_last_step = $step;
        $user->session_version++;
        $user->remember_token = Str::random(60);
        $user->tokens()->delete();
        $codes = $this->recovery($user);
        $request->session()->put('session_version', $user->session_version);
        $request->session()->forget('totp_setup');

        return back()->with('recovery_codes', $codes)->with('success', 'Autenticação em duas etapas ativada. Guarde os códigos de recuperação.');
    }

    /** @return list<string> */
    private function recovery(User $user): array
    {
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = Str::random(16);
        }
        $user->recovery_codes = array_map(fn ($c): string => hash('sha256', $c), $codes);
        $user->save();

        return $codes;
    }

    public function recoveryCodes(SettingsFormRequest $request): RedirectResponse
    {
        abort_unless(($request->user() ?? abort(401))->totp_confirmed_at !== null, 422);

        return back()->with('recovery_codes', $this->recovery($request->user()));
    }

    public function disableTwoFactor(SettingsFormRequest $request): RedirectResponse
    {
        $user = $request->user() ?? abort(401);
        $user->totp_secret = null;
        $user->totp_confirmed_at = null;
        $user->recovery_codes = null;
        $user->session_version++;
        $user->remember_token = Str::random(60);
        $user->save();
        $user->tokens()->delete();
        $request->session()->put('session_version', $user->session_version);

        return back()->with('success', 'Autenticação em duas etapas desativada.');
    }

    public function testMail(Request $request): RedirectResponse
    {
        MailOutbox::enqueue(($request->user() ?? abort(401))->email, 'Teste de e-mail Deploy', 'O transporte de e-mail do sistema está funcionando.');

        return back()->with('success', 'Teste colocado na fila. Consulte o status de entrega abaixo.');
    }

    public function retryMail(Request $request, MailOutbox $mail): RedirectResponse
    {
        abort_if($mail->status === 'sent', 422, 'Mensagem já enviada.');
        $mail->update(['status' => 'pending', 'last_error' => null]);
        SendInternalMail::dispatch($mail->id);

        return back()->with('success', 'Nova tentativa agendada.');
    }

    public function token(SettingsFormRequest $request): RedirectResponse
    {
        $user = $request->user() ?? abort(401);
        $user->tokens()->where('name', 'internal-profile')->delete();
        $token = $user->createToken('internal-profile', ['profile:read'], now()->addDays(30))->plainTextToken;

        return back()->with('api_token', $token)->with('success', 'Chave criada por 30 dias para leitura do próprio perfil. Copie agora.');
    }
}
