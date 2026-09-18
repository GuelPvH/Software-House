<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property list<string> $roles
 */
final class RouteRegistry extends Model
{
    protected $table = 'internal_route_registry';

    protected $guarded = ['id'];

    /** @return array<string, mixed> */
    protected function casts(): array
    {
        return ['roles' => 'array'];
    }
}
