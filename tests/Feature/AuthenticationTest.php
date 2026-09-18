<?php

declare(strict_types=1);

use App\Models\User;

it('requires authentication for the dashboard', function (): void {
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
});

it('renders the login screen', function (): void {
    $this->get(route('login'))
        ->assertOk()
        ->assertSee('Bem-vindo de volta');
});

it('authenticates a user and redirects to the intended admin page', function (): void {
    $admin = User::factory()->create([
        'email' => 'admin@example.test',
        'password' => 'secret-password',
        'is_admin' => true,
    ]);

    $this->get(route('admin.dashboard'));

    $this->post(route('login.store'), [
        'email' => $admin->email,
        'password' => 'secret-password',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($admin);
});

it('rejects invalid credentials', function (): void {
    $user = User::factory()->create();

    $this->from(route('login'))
        ->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'incorrect-password',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('logs out an authenticated user', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->delete(route('logout'))
        ->assertRedirectToRoute('login');

    $this->assertGuest();
});
