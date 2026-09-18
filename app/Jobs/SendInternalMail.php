<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\MailOutbox;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Throwable;

final class SendInternalMail implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 45;

    public function __construct(public int $outboxId) {}

    /** @return list<int> */
    public function backoff(): array
    {
        return [60, 300, 900];
    }

    public function handle(): void
    {
        Cache::lock('outbox:'.$this->outboxId, 60)->get(function (): void {
            $mail = MailOutbox::find($this->outboxId);
            if (! $mail || $mail->status === 'sent') {
                return;
            }
            $mail->increment('attempts');
            try {
                Mail::raw($mail->body, function ($message) use ($mail): void {
                    $message->to($mail->recipient)->subject($mail->subject);
                });
                $mail->update(['status' => 'sent', 'sent_at' => now(), 'last_error' => null]);
            } catch (Throwable $error) {
                $mail->update(['status' => 'failed', 'last_error' => 'Falha no transporte SMTP. Verifique a conexão e as credenciais.']);
                throw $error;
            }
        });
    }
}
