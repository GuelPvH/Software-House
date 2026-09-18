<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property array<string, mixed>|null $details
 */
final class AuditEvent extends Model
{
    protected $table = 'internal_audit_events';

    protected $guarded = ['id'];

    /** @return array<string, mixed> */
    protected function casts(): array
    {
        return ['details' => 'array'];
    }
}
