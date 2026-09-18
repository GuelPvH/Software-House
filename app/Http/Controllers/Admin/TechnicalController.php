<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\AccountRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\TechnicalFormRequest;
use App\Models\AuditEvent;
use App\Models\DeveloperProfile;
use App\Models\RouteRegistry;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

final class TechnicalController extends Controller
{
    public function index(): View
    {
        $routes = collect(Route::getRoutes()->getRoutes())->filter(fn ($r): bool => str_starts_with($r->getName() ?? '', 'admin.') && in_array('GET', $r->methods(), true))->map(fn ($r): array => ['name' => $r->getName(), 'uri' => $r->uri()]);

        return view('pages.admin.technical', ['users' => User::orderBy('name')->get(), 'roles' => AccountRole::cases(), 'events' => AuditEvent::latest()->paginate(30), 'registered' => RouteRegistry::all(), 'routes' => $routes, 'profiles' => DeveloperProfile::all()->keyBy('user_id')]);
    }

    public function user(TechnicalFormRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        DB::transaction(function () use ($request, $user, $data): void {
            // Serialize role changes to preserve at least one active manager.
            $all = User::lockForUpdate()->get();
            $current = $all->firstWhere('id', $user->id) ?? abort(404);
            if ($current->role() === AccountRole::Manager && ($data['account_role'] !== 'manager' || ! $data['access_active'])) {
                abort_unless($all->filter(fn ($u): bool => $u->role() === AccountRole::Manager && $u->access_active)->count() > 1, 422, 'Mantenha pelo menos um gestor ativo.');
            }
            abort_if($request->user()?->id === $user->id && (! $data['access_active'] || $data['account_role'] !== $user->role()->value), 422, 'Altere o próprio perfil por outro administrador.');
            $user->account_role = $data['account_role'];
            $user->access_active = (bool) $data['access_active'];
            $user->session_version++;
            $user->save();
            $user->tokens()->delete();
            DeveloperProfile::updateOrCreate(['user_id' => $user->id], ['specialty' => $data['specialty'] ?? null, 'skills' => $data['skills'] ?? null]);
            AuditEvent::create(['user_id' => $request->user()?->id, 'action' => 'user.access_updated', 'entity' => 'user', 'entity_id' => $user->id, 'details' => ['role' => $user->account_role, 'active' => $user->access_active]]);
        });

        return back()->with('success', 'Perfil e acesso atualizados.');
    }

    public function routes(TechnicalFormRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $route = Route::getRoutes()->getByName($data['route_name']);
        abort_unless($route && str_starts_with($data['route_name'], 'admin.') && ! str_starts_with($data['route_name'], 'admin.technical'), 422, 'Selecione uma rota administrativa existente fora da área técnica.');
        RouteRegistry::updateOrCreate(['route_name' => $data['route_name']], ['label' => $data['label'], 'roles' => $data['roles']]);
        AuditEvent::create(['user_id' => $request->user()?->id, 'action' => 'route.permissions_updated', 'entity' => 'route', 'entity_id' => $data['route_name']]);

        return back()->with('success', 'Permissão de rota registrada. As restrições do perfil continuam obrigatórias.');
    }
}
