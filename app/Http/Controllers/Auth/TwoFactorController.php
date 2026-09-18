<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccessFormRequest;
use App\Models\User;
use App\Support\Totp;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class TwoFactorController extends Controller
{
    public function challenge(): View
    {
        abort_unless(session('two_factor_user'), 403);

        return view('auth.two-factor');
    }

    public function verify(AccessFormRequest $request): RedirectResponse
    {
        abort_unless($request->session()->get('two_factor_expires', 0) > time(), 403, 'Desafio expirado. Faça login novamente.');
        $id = (int) $request->session()->get('two_factor_user');
        $valid = DB::transaction(function () use ($id, $request): bool {
            $user = User::lockForUpdate()->findOrFail($id);
            if ($request->session()->get('two_factor_version') !== $user->session_version || ! $user->access_active || ! $user->totp_confirmed_at || ! $user->totp_secret) {
                return false;
            }
            $code = $request->validated('code');
            $step = Totp::verify($user->totp_secret, $code, (int) $user->totp_last_step);
            if ($step !== null) {
                $user->totp_last_step = $step;
                $user->save();

                return true;
            }
            $codes = $user->recovery_codes ?? [];
            foreach ($codes as $index => $hash) {
                if (hash_equals($hash, hash('sha256', $code))) {
                    unset($codes[$index]);
                    $user->recovery_codes = array_values($codes);
                    $user->save();

                    return true;
                }
            }

            return false;
        });
        if (! $valid) {
            return back()->withErrors(['code' => 'Código inválido ou já utilizado.']);
        }
        $user = User::findOrFail($id);
        Auth::login($user);
        $request->session()->forget(['two_factor_user', 'two_factor_expires', 'two_factor_version']);
        $request->session()->regenerate();
        $request->session()->put('session_version', $user->session_version);
        $user->last_login_at = now();
        $user->save();

        return redirect()->intended(route('admin.dashboard'));
    }
}
