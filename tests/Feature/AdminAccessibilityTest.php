<?php

declare(strict_types=1);

use App\Models\User;

beforeEach(function (): void {
    $this->actingAs(User::factory()->create(['is_admin' => true]));
});

it('exposes page and navigation landmarks on the admin pages', function (string $route): void {
    $this->get(route($route))
        ->assertOk()
        ->assertSee('<main class="admin-content">', escape: false)
        ->assertSee('aria-label="Menu administrativo"', escape: false)
        ->assertSee('aria-label="breadcrumb"', escape: false);
})->with([
    'dashboard' => ['admin.dashboard'],
    'projects' => ['admin.projects.index'],
    'settings' => ['admin.settings.profile'],
]);

it('provides accessible empty state when there are no projects', function (): void {
    $this->get(route('admin.projects.index'))->assertOk()->assertSee('Nenhum projeto disponível');
});
