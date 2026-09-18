<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\SendInternalMail;
use App\Models\MailOutbox;
use Illuminate\Console\Command;

final class ProcessInternalMail extends Command
{
    protected $signature = 'internal:mail-reconcile';

    protected $description = 'Recoloca mensagens pendentes na fila sem perder solicitações.';

    public function handle(): int
    {
        MailOutbox::whereIn('status', ['pending', 'failed'])->where('attempts', '<', 3)->where('updated_at', '<', now()->subMinutes(5))->each(function ($mail): void {
            SendInternalMail::dispatch($mail->id);
        });

        return self::SUCCESS;
    }
}
