<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccessFormRequest;
use App\Models\AccessRequest;
use App\Models\MailOutbox;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class RequestAccessController extends Controller
{
    public function index(): View
    {
        return view('auth.request-access');
    }

    public function store(AccessFormRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $email = Str::lower($data['email']);
        if (! User::where('email', $email)->exists()) {
            Cache::lock('request-access:'.hash('sha256', $email), 10)->block(3, function () use ($data, $email): void {
                DB::transaction(function () use ($data, $email): void {
                    $access = AccessRequest::firstOrCreate(['email' => $email], ['name' => $data['name']]);
                    if ($access->status !== 'pending' || $access->email_confirmed_at || $access->verification_expires_at?->isFuture()) {
                        return;
                    }
                    $token = Str::random(64);
                    $access->update(['verification_hash' => hash('sha256', $token), 'verification_expires_at' => now()->addHours(24)]);
                    MailOutbox::enqueue($email, 'Confirme sua solicitação de acesso', 'Confirme seu e-mail em até 24 horas: '.route('access.verify', ['access' => $access->id, 'token' => $token])."\nApós a confirmação, um gestor analisará sua solicitação.");
                });
            });
        }

        return to_route('access.index')->with('sucesso', true);
    }

    public function verify(AccessRequest $access, string $token): RedirectResponse
    {
        abort_unless($access->verification_hash && $access->verification_expires_at?->isFuture() && hash_equals($access->verification_hash, hash('sha256', $token)), 403, 'Link inválido ou expirado.');
        DB::transaction(function () use ($access): void {
            $access->update(['email_confirmed_at' => now(), 'verification_hash' => null]);
            foreach (User::where('access_active', true)->get()->filter(fn ($u) => $u->canModule('access')) as $reviewer) {
                MailOutbox::enqueue($reviewer->email, 'Solicitação de acesso aguardando análise', $access->name.' confirmou o e-mail. Analise em '.route('admin.access.index'));
            }
        });

        return to_route('login')->with('success', 'E-mail confirmado. Aguarde a aprovação do gestor.');
    }
}
