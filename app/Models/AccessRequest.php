<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property Carbon|null $email_confirmed_at
 * @property Carbon|null $verification_expires_at
 * @property Carbon|null $reviewed_at
 */
final class AccessRequest extends Model
{
    protected $attributes = ['status' => 'pending'];

    protected $table = 'access_requests';

    protected $guarded = ['id'];

    /** @return array<string, mixed> */
    protected function casts(): array
    {
        return ['email_confirmed_at' => 'datetime', 'verification_expires_at' => 'datetime', 'reviewed_at' => 'datetime'];
    }
}
