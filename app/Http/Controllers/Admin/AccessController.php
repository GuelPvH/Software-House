<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\AccountRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccessFormRequest;
use App\Models\AccessRequest;
use App\Models\AuditEvent;
use App\Models\MailOutbox;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

final class AccessController extends Controller
{
    public function index(): View
    {
        return view('pages.admin.access', ['requests' => AccessRequest::latest()->paginate(20), 'roles' => AccountRole::cases()]);
    }

    public function review(AccessFormRequest $request, AccessRequest $access): RedirectResponse
    {
        DB::transaction(function () use ($request, $access): void {
            $access = AccessRequest::lockForUpdate()->findOrFail($access->id);
            abort_unless($access->status === 'pending', 409, 'Solicitação já analisada.');
            abort_unless($access->email_confirmed_at !== null, 422, 'O solicitante precisa confirmar o e-mail.');
            $data = $request->validated();
            $access->update(['status' => $data['decision'], 'assigned_role' => $data['role'], 'review_note' => $data['note'] ?? null, 'reviewed_by' => $request->user()?->id, 'reviewed_at' => now()]);
            if ($data['decision'] === 'approved') {
                abort_if(User::where('email', $access->email)->exists(), 409, 'E-mail já cadastrado.');
                $user = new User(['name' => $access->name, 'email' => $access->email, 'password' => Str::random(64)]);
                $user->account_role = $data['role'];
                $user->access_active = true;
                $user->email_verified_at = $access->email_confirmed_at;
                $user->save();
                $token = Password::createToken($user);
                MailOutbox::enqueue($user->email, 'Acesso aprovado — defina sua senha', 'Seu acesso foi aprovado. Defina sua senha: '.route('password.reset', ['token' => $token, 'email' => $user->email])."\nLink válido por 60 minutos. Se expirar, use Esqueceu a senha.");
            } else {
                MailOutbox::enqueue($access->email, 'Atualização da solicitação de acesso', 'Sua solicitação não foi aprovada. '.($data['note'] ?? 'Entre em contato com o gestor.'));
            }
            AuditEvent::create(['user_id' => $request->user()?->id, 'action' => 'access.'.$data['decision'], 'entity' => 'access_request', 'entity_id' => $access->id, 'details' => ['role' => $data['role']]]);
        });

        return back()->with('success', 'Solicitação analisada. E-mail adicionado à fila de envio.');
    }
}
