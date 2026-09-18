<?php

declare(strict_types=1);

namespace App\Models;

use App\Jobs\SendInternalMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @property Carbon|null $sent_at
 */
final class MailOutbox extends Model
{
    public static function enqueue(string $recipient, string $subject, string $body): self
    {
        $mail = self::create(['recipient' => $recipient, 'subject' => $subject, 'body' => $body]);
        DB::afterCommit(function () use ($mail): void {
            try {
                Bus::dispatch(new SendInternalMail($mail->id));
            } catch (Throwable) {
                $mail->update(['last_error' => 'Fila temporariamente indisponível. O agendador tentará novamente.']);
            }
        });

        return $mail;
    }

    protected $table = 'internal_mail_outbox';

    protected $guarded = ['id'];

    /** @return array<string, mixed> */
    protected function casts(): array
    {
        return ['body' => 'encrypted', 'sent_at' => 'datetime'];
    }
}
