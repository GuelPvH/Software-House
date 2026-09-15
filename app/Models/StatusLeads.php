<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class StatusLeads extends Model
{
    protected $table = 'status_leads';

    protected $fillable = [
        'name',
    ];
}
