<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bool $completed
 */
final class ChecklistItem extends Model
{
    protected $table = 'internal_checklist_items';

    protected $guarded = ['id'];

    /** @return array<string, mixed> */
    protected function casts(): array
    {
        return ['completed' => 'boolean'];
    }
}
