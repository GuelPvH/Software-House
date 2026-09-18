<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccessFormRequest;
use App\Models\MailOutbox;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

final class PasswordController extends Controller
{
    public function forgot(): View
    {
        return view('auth.password', ['reset' => false]);
    }

    public function reset(Request $request, string $token): View
    {
        return view('auth.password', ['reset' => true, 'token' => $token, 'email' => $request->query('email')]);
    }

    public function email(AccessFormRequest $request): RedirectResponse
    {
        Password::sendResetLink($request->validated(), function ($user, $token): void {
            MailOutbox::enqueue($user->email, 'Defina sua senha de acesso', 'Defina sua senha pelo link: '.route('password.reset', ['token' => $token, 'email' => $user->email])."\nO link expira em 60 minutos.");
        });

        return back()->with('success', 'Se o e-mail estiver cadastrado, você receberá as instruções.');
    }

    public function update(AccessFormRequest $request): RedirectResponse
    {
        $status = Password::reset($request->validated(), function ($user, $password): void {
            $user->password = $password;
            $user->remember_token = Str::random(60);
            $user->session_version++;
            $user->save();
            $user->tokens()->delete();
        });

        return $status === Password::PASSWORD_RESET
            ? to_route('login')->with('success', 'Senha definida. Faça login.')
            : back()->withErrors(['email' => 'O link expirou ou é inválido. Solicite outro.']);
    }
}
