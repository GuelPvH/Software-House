<?php

declare(strict_types=1);

use App\Models\User;

beforeEach(function (): void {
    $this->actingAs(User::factory()->create(['is_admin' => true]));
});

it('renders the administrative dashboard sections', function (): void {
    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Visão do Gestor')
        ->assertSee('Projetos acessíveis')
        ->assertSee('Registros recentes');
});

it('marks the dashboard navigation item as current', function (): void {
    $response = $this->get(route('admin.dashboard'))->assertOk();

    $response->assertSee('href="'.route('admin.dashboard').'"', escape: false)
        ->assertSee('class="nav-link active"', escape: false)
        ->assertSee('aria-current="page"', escape: false);
});
