<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\AccountRole;
use App\Models\RouteRegistry;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class InternalAccess
{
    public function handle(Request $request, Closure $next, string $module = 'dashboard'): Response
    {
        // Internal pages must not expose SQL results or credentials through developer tooling.
        if (app()->bound('debugbar')) {
            resolve('debugbar')->disable();
        }
        $user = $request->user();
        abort_unless($user && $user->access_active, 403, 'Acesso desativado.');
        if ($request->session()->get('session_version', 0) !== $user->session_version) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return to_route('login');
        }
        abort_unless($user->canModule($module), 403, 'Seu perfil não tem acesso a esta área.');
        $rule = RouteRegistry::where('route_name', $request->route()?->getName())->first();
        if ($rule && $user->role() !== AccountRole::Manager) {
            abort_unless(in_array($user->role()->value, $rule->roles, true), 403);
        }

        return $next($request);
    }
}
