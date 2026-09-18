<?php

declare(strict_types=1);

use App\Enums\AccountRole;
use App\Jobs\SendInternalMail;
use App\Models\AccessRequest;
use App\Models\Board;
use App\Models\BoardColumn;
use App\Models\Client;
use App\Models\FinancialTransaction;
use App\Models\InternalSetting;
use App\Models\MailOutbox;
use App\Models\User;
use App\Support\Totp;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;

function internalUser(string $role = 'manager'): User
{
    return User::factory()->create(['account_role' => $role]);
}
function internalBoard(User $user): Board
{
    $board = Board::create(['name' => 'Projeto de teste', 'client_id' => Client::create(['name' => 'Cliente de teste'])->id, 'responsible_id' => $user->id]);
    $board->members()->attach($user);
    $board->columns()->create(['name' => 'A fazer', 'order_index' => 0]);
    $board->columns()->create(['name' => 'Concluído', 'order_index' => 1]);

    return $board->refresh();
}
it('enforces profile boundaries on direct requests', function (string $role, string $route, int $status): void {
    $this->actingAs(internalUser($role))->get(route($route))->assertStatus($status);
})->with([
    ['developer', 'admin.finance.index', 403], ['developer', 'admin.technical.index', 403], ['developer', 'admin.settings.company', 403], ['developer', 'admin.access.index', 403],
    ['finance', 'admin.projects.index', 403], ['finance', 'admin.finance.index', 200], ['finance', 'admin.settings.profile', 200], ['finance', 'admin.leads.index', 403],
    ['project_owner', 'admin.finance.index', 403], ['project_owner', 'admin.projects.index', 200], ['project_owner', 'admin.leads.index', 200],
    ['technical_admin', 'admin.technical.index', 200], ['technical_admin', 'admin.finance.index', 403], ['technical_admin', 'admin.projects.index', 403],
    ['manager', 'admin.finance.index', 200], ['manager', 'admin.access.index', 200], ['manager', 'admin.technical.index', 200],
]);
it('renders five distinct dashboard headers without financial leakage', function (string $role): void {
    $user = internalUser($role);
    $response = $this->actingAs($user)->get(route('admin.dashboard'))->assertOk()->assertSee(AccountRole::from($role)->label());
    if (! in_array($role, ['finance', 'manager'], true)) {
        $response->assertDontSee(route('admin.finance.index'), false)->assertDontSee('Saldo realizado');
    }
})->with(array_map(fn (AccountRole $r) => $r->value, AccountRole::cases()));
it('stores a request and requires verification before approval', function (): void {
    Bus::fake();
    $this->post(route('access.store'), ['name' => 'Novo usuário', 'email' => 'new@example.test', 'termos' => 'on'])->assertRedirect(route('access.index'));
    $access = AccessRequest::sole();
    expect(User::where('email', $access->email)->exists())->toBeFalse();
    expect(MailOutbox::count())->toBe(1);
    $manager = internalUser();
    $this->actingAs($manager)->post(route('admin.access.review', $access), ['decision' => 'approved', 'role' => 'developer'])->assertStatus(422);
    $access->update(['email_confirmed_at' => now()]);
    $this->post(route('admin.access.review', $access), ['decision' => 'approved', 'role' => 'developer'])->assertRedirect();
    expect(User::where('email', $access->email)->firstOrFail()->role())->toBe(AccountRole::Developer);
    expect(MailOutbox::count())->toBe(2);
    $this->post(route('admin.access.review', $access), ['decision' => 'approved', 'role' => 'manager'])->assertStatus(409);
});
it('verifies one time email confirmation links and rejects replay', function (): void {
    Bus::fake();
    $access = AccessRequest::create(['name' => 'New', 'email' => 'new@example.test', 'verification_hash' => hash('sha256', 'testtoken'), 'verification_expires_at' => now()->addHour()]);
    $this->get(route('access.verify', [$access, 'wrong']))->assertForbidden();
    $this->get(route('access.verify', [$access, 'testtoken']))->assertRedirect(route('login'));
    expect($access->refresh()->email_confirmed_at)->not->toBeNull();
    $this->get(route('access.verify', [$access, 'testtoken']))->assertForbidden();
});
it('moves a card in both directions and rejects stale writes and foreign card injection', function (): void {
    Bus::fake();
    $user = internalUser('developer');
    $board = internalBoard($user);
    $columns = $board->columns;
    assert($columns->last() instanceof BoardColumn);
    $card = $board->cards()->create(['stage_id' => $columns->firstOrFail()->id, 'title' => 'Tarefa real']);
    $this->actingAs($user);
    $payload = ['version' => 1, 'columns' => [['id' => $columns->firstOrFail()->id, 'cards' => []], ['id' => $columns->last()->id, 'cards' => [$card->id]]]];
    $this->postJson(route('admin.projects.move', $board), $payload)->assertOk();
    expect($card->refresh()->stage_id)->toBe($columns->last()->id);
    $this->postJson(route('admin.projects.move', $board), $payload)->assertStatus(409);
    $payload['version'] = 2;
    $payload['columns'][0]['cards'] = [$card->id];
    $payload['columns'][1]['cards'] = [];
    $this->postJson(route('admin.projects.move', $board), $payload)->assertOk();
    expect($card->refresh()->stage_id)->toBe($columns->firstOrFail()->id);
    $payload['version'] = 3;
    $payload['columns'][0]['cards'] = [99999];
    $this->postJson(route('admin.projects.move', $board), $payload)->assertStatus(422);
});
it('prevents developers from accessing another project or changing memberships', function (): void {
    $owner = internalUser();
    $board = internalBoard($owner);
    $other = internalUser('developer');
    $this->actingAs($other)->get(route('admin.projects.index', ['board' => $board->id]))->assertForbidden();
    $this->patch(route('admin.projects.update', $board), ['name' => 'Stolen', 'client_name' => 'x', 'members' => [$other->id]])->assertForbidden();
    $this->postJson(route('admin.projects.move', $board), ['version' => 1, 'columns' => []])->assertForbidden();
});
it('persists comments checklist and card edits with no finance data', function (): void {
    Bus::fake();
    $user = internalUser('developer');
    $board = internalBoard($user);
    $stage = $board->columns->firstOrFail();
    $card = $board->cards()->create(['stage_id' => $stage->id, 'title' => 'Original']);
    $this->actingAs($user)->patch(route('admin.projects.cards.update', [$board, $card]), ['title' => 'Editado', 'description' => 'Detalhes', 'stage_id' => $stage->id, 'priority' => 'high', 'version' => 1])->assertRedirect();
    $this->post(route('admin.projects.comments', [$board, $card]), ['body' => 'Comentário real'])->assertRedirect();
    $this->post(route('admin.projects.checklist', [$board, $card]), ['title' => 'Validar entrega'])->assertRedirect();
    $item = $card->checklist()->firstOrFail();
    $this->patch(route('admin.projects.checklist.toggle', [$board, $card, $item]), ['completed' => true])->assertRedirect();
    expect($item->refresh()->completed)->toBeTrue();
    $this->get(route('admin.projects.index', ['board' => $board->id]))->assertOk()->assertSee('Editado')->assertSee('Comentário real')->assertSee('Validar entrega');
});
it('does not let a personal settings request change privileges', function (): void {
    $user = internalUser('developer');
    $this->actingAs($user)->post(route('admin.settings.profile.save'), ['name' => 'Updated', 'email' => $user->email, 'timezone' => 'America/Manaus', 'theme' => 'dark', 'account_role' => 'manager', 'is_admin' => true])->assertRedirect();
    expect($user->refresh()->name)->toBe('Updated');
    expect($user->refresh()->role())->toBe(AccountRole::Developer);
    expect(($user->refresh()->preferences['theme'] ?? null))->toBe('dark');
});
it('persists notifications and company settings with role protection', function (): void {
    $user = internalUser();
    $this->actingAs($user)->post(route('admin.settings.notifications.save'), ['email_enabled' => 1, 'project_alerts' => 1, 'digest_frequency' => 'weekly'])->assertRedirect();
    expect(($user->refresh()->preferences['digest_frequency'] ?? null))->toBe('weekly');
    $this->post(route('admin.settings.company.save'), ['legal_name' => 'Minha Empresa', 'trade_name' => 'Deploy'])->assertRedirect();
    expect((InternalSetting::findOrFail('company')->value['legal_name'] ?? null))->toBe('Minha Empresa');
});
it('revokes old sessions and rejects inactive users', function (): void {
    $user = internalUser();
    $user->session_version = 2;
    $user->save();
    $this->actingAs($user)->withSession(['session_version' => 1])->get(route('admin.dashboard'))->assertRedirect(route('login'));
    $user->access_active = false;
    $user->save();
    $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password'])->assertSessionHasErrors('email');
    $this->assertGuest();
});
it('changes passwords only with the current password and invalidates other access', function (): void {
    Bus::fake();
    $user = internalUser();
    $this->actingAs($user)->post(route('admin.settings.security.save'), ['current_password' => 'wrong', 'password' => 'StrongPassword123', 'password_confirmation' => 'StrongPassword123'])->assertSessionHasErrors('current_password');
    $this->post(route('admin.settings.security.save'), ['current_password' => 'password', 'password' => 'StrongPassword123', 'password_confirmation' => 'StrongPassword123'])->assertRedirect();
    expect(Hash::check('StrongPassword123', $user->refresh()->password))->toBeTrue();
    expect($user->refresh()->session_version)->toBe(1);
});
it('validates two factor codes and prevents replay', function (): void {
    $secret = 'GEZDGNBVGY3TQOJQGEZDGNBVGY3TQOJQ';
    expect(Totp::code($secret, 1))->toBe('287082');
    $step = intdiv(time(), 30);
    $code = Totp::code($secret, $step);
    expect(Totp::verify($secret, $code))->toBe($step);
    expect(Totp::verify($secret, $code, $step))->toBeNull();
});
it('records real financial transactions and displays real aggregates', function (): void {
    $user = internalUser('finance');
    $this->actingAs($user)->post(route('admin.finance.store'), ['description' => 'Receita de teste', 'type' => 'income', 'amount' => '1250.50', 'due_date' => today()->toDateString(), 'status' => 'paid'])->assertRedirect();
    expect(FinancialTransaction::sole()->amount)->toBe('1250.50');
    $this->get(route('admin.dashboard'))->assertOk()->assertSee('1.250,50');
});
it('delivers a persisted email once through the mail transport', function (): void {
    Mail::fake();
    $mail = MailOutbox::create(['recipient' => 'qa@example.test', 'subject' => 'Teste', 'body' => 'Corpo de teste']);
    $job = new SendInternalMail($mail->id);
    $job->handle();
    $job->handle();
    expect($mail->refresh()->status)->toBe('sent');
    expect($mail->refresh()->attempts)->toBe(1);
});

it('requires the current password to change an email and confirms the signed link once', function (): void {
    Bus::fake();
    $user = internalUser();
    $payload = ['name' => $user->name, 'email' => 'changed@example.test', 'timezone' => 'America/Manaus', 'theme' => 'light'];
    $this->actingAs($user)->post(route('admin.settings.profile.save'), $payload)->assertSessionHasErrors('current_password');
    $this->post(route('admin.settings.profile.save'), [...$payload, 'current_password' => 'password'])->assertRedirect();
    expect($user->refresh()->email)->not->toBe('changed@example.test');
    $url = URL::temporarySignedRoute('admin.settings.email.verify', now()->addHour(), ['user' => $user->id, 'email' => 'changed@example.test']);
    $this->get($url)->assertRedirect(route('admin.settings.profile'));
    expect($user->refresh()->email)->toBe('changed@example.test');
    $this->get($url)->assertForbidden();
});
it('resets a password with a single use token and revokes previous tokens', function (): void {
    Bus::fake();
    $user = internalUser();
    $user->createToken('old');
    $token = Password::createToken($user);
    $payload = ['email' => $user->email, 'token' => $token, 'password' => 'Replacement12345', 'password_confirmation' => 'Replacement12345'];
    $this->post(route('password.update'), $payload)->assertRedirect(route('login'));
    expect(Hash::check('Replacement12345', $user->refresh()->password))->toBeTrue();
    expect($user->tokens()->count())->toBe(0);
    $this->post(route('password.update'), $payload)->assertSessionHasErrors('email');
});
it('completes second factor login and consumes recovery codes once', function (): void {
    $user = internalUser();
    $user->totp_secret = Totp::secret();
    $user->totp_confirmed_at = now();
    $user->recovery_codes = [hash('sha256', 'one-use-recovery')];
    $user->save();
    $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password'])->assertRedirect(route('two-factor.challenge'));
    $this->assertGuest();
    $this->post(route('two-factor.verify'), ['code' => 'wrong'])->assertSessionHasErrors('code');
    $this->post(route('two-factor.verify'), ['code' => 'one-use-recovery'])->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($user);
    expect($user->refresh()->recovery_codes)->toBe([]);
});
it('rejects a pending second factor challenge after access revocation', function (): void {
    $user = internalUser();
    $user->totp_secret = Totp::secret();
    $user->totp_confirmed_at = now();
    $user->save();
    $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password']);
    $user->session_version++;
    $user->save();
    $this->post(route('two-factor.verify'), ['code' => Totp::code($user->totp_secret, intdiv(time(), 30))])->assertSessionHasErrors('code');
    $this->assertGuest();
});
it('tracks completion when moving cards forward and backward and restores archived cards', function (): void {
    Bus::fake();
    $user = internalUser();
    $board = internalBoard($user);
    $todo = $board->columns->firstOrFail();
    $done = $board->columns()->whereKeyNot($todo->id)->firstOrFail();
    $done->update(['is_done' => true]);
    $card = $board->cards()->create(['stage_id' => $todo->id, 'title' => 'Entrega']);
    $this->actingAs($user)->postJson(route('admin.projects.move', $board), ['version' => 1, 'columns' => [['id' => $todo->id, 'cards' => []], ['id' => $done->id, 'cards' => [$card->id]]]])->assertOk();
    expect($card->refresh()->completed_at)->not->toBeNull();
    $this->postJson(route('admin.projects.move', $board), ['version' => 2, 'columns' => [['id' => $todo->id, 'cards' => [$card->id]], ['id' => $done->id, 'cards' => []]]])->assertOk();
    expect($card->refresh()->completed_at)->toBeNull();
    $this->delete(route('admin.projects.cards.archive', [$board, $card]))->assertRedirect();
    expect($card->refresh()->deleted_at)->not->toBeNull();
    $this->post(route('admin.projects.cards.restore', [$board, $card->id]))->assertRedirect();
    expect($card->refresh()->deleted_at)->toBeNull();
});
it('records transport failures without claiming delivery and supports retry', function (): void {
    $mail = MailOutbox::create(['recipient' => 'qa@example.test', 'subject' => 'Failure', 'body' => 'Body']);
    Mail::shouldReceive('raw')->once()->andThrow(new RuntimeException('smtp down'));
    try {
        new SendInternalMail($mail->id)->handle();
    } catch (RuntimeException) {
    }
    expect($mail->refresh()->status)->toBe('failed');
    expect($mail->sent_at)->toBeNull();
    Mail::shouldReceive('raw')->once()->andReturnNull();
    new SendInternalMail($mail->id)->handle();
    expect($mail->refresh()->status)->toBe('sent');
    expect($mail->attempts)->toBe(2);
});
it('limits generated profile tokens and rejects disabled accounts in the API', function (): void {
    $user = internalUser('technical_admin');
    $token = $user->createToken('internal-profile', ['profile:read'])->plainTextToken;
    $this->withToken($token)->getJson('/api/user')->assertOk();
    $this->withToken($token)->postJson('/api/vehicles', [])->assertForbidden();
    $user->access_active = false;
    $user->save();
    resolve('auth')->forgetGuards();
    $this->withToken($token)->getJson('/api/user')->assertForbidden();
});
it('protects monitoring pages against nontechnical profiles', function (): void {
    $this->actingAs(internalUser('developer'))->get('/horizon')->assertForbidden();
});
