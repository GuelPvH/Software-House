<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccessFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

final class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('pages.admin.login.index');
    }

    /**
     * @throws ValidationException
     */
    public function store(AccessFormRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $credentials['email'] = strtolower($credentials['email']);
        $credentials['access_active'] = true;
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => 'E-mail ou senha inválidos, ou acesso desativado.']);
        }
        $user = $request->user() ?? abort(401);
        if ($user->totp_confirmed_at) {
            Auth::logout();
            $request->session()->regenerate();
            $request->session()->put('two_factor_user', $user->id);
            $request->session()->put('two_factor_version', $user->session_version);
            $request->session()->put('two_factor_expires', now()->addMinutes(5)->timestamp);

            return to_route('two-factor.challenge');
        }
        $request->session()->regenerate();
        $request->session()->put('session_version', $user->session_version);
        $user->last_login_at = now();
        $user->save();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }
}
