<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property array<string, mixed>|null $value
 */
final class InternalSetting extends Model
{
    protected $table = 'internal_settings';

    protected $guarded = ['id'];

    /** @return array<string, mixed> */
    protected function casts(): array
    {
        return ['value' => 'encrypted:array'];
    }

    public $incrementing = false;

    protected $primaryKey = 'key';

    protected $keyType = 'string';
}
