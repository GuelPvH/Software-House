<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\AccountRole;
use App\Models\Board;
use App\Models\Card;
use App\Models\MailOutbox;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

final class SendInternalDigests extends Command
{
    protected $signature = 'internal:digests';

    protected $description = 'Envia resumos conforme preferências e permissões de cada conta.';

    public function handle(): int
    {
        User::where('access_active', true)->each(function ($user): void {
            $prefs = $user->preferences ?? [];
            $frequency = $prefs['digest_frequency'] ?? 'off';
            if (! ($prefs['email_enabled'] ?? true) || $frequency === 'off') {
                return;
            }
            $local = now()->timezone($prefs['timezone'] ?? 'America/Manaus');
            if ($local->hour !== 8 || ($frequency === 'weekly' && ! $local->isMonday()) || ($frequency === 'monthly' && $local->day !== 1)) {
                return;
            }
            $key = 'digest:'.$user->id.':'.$local->format('Y-m-d');
            Cache::lock($key.':lock', 60)->get(function () use ($user, $key): void {
                if (Cache::has($key)) {
                    return;
                }
                $body = 'Resumo do perfil '.$user->role()->label()."\n";
                if ($user->canModule('projects')) {
                    $cards = Card::whereIn('project_id', Board::visibleTo($user)->select('id'));
                    if ($user->role() === AccountRole::Developer) {
                        $cards->where('assigned_to', $user->id);
                    }$body .= 'Tarefas abertas: '.$cards->whereNull('completed_at')->count()."\n";
                }
                $body .= 'Acesse seu dashboard: '.route('admin.dashboard');
                MailOutbox::enqueue($user->email, 'Seu resumo Deploy', $body);
                Cache::put($key, true, now()->addDays(2));
            });
        });

        return self::SUCCESS;
    }
}
