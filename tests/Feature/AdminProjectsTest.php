<?php

declare(strict_types=1);
use App\Models\Board;
use App\Models\Client;
use App\Models\User;

it('renders real projects instead of sample projects', function (): void {
    $user = User::factory()->create(['is_admin' => true]);
    Board::create(['name' => 'Projeto persistido', 'client_id' => Client::create(['name' => 'Cliente real'])->id, 'responsible_id' => $user->id]);
    $this->actingAs($user)->get(route('admin.projects.index'))->assertOk()->assertSee('Projeto persistido')->assertDontSee('Sistema ERP Industrial');
});
it('requires authentication for projects', function (): void {
    $this->get(route('admin.projects.index'))->assertRedirect(route('login'));
});
