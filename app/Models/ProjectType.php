<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class ProjectType extends Model
{
    protected $table = 'project_types';

    protected $fillable = [
        'name',
        'color',
        'description',
        'is_active',
    ];
}
