<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;

final class Services extends Model
{
    use SoftDeletes;

    protected $table = 'services';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'features',
        'tags',
        'base_price',
        'status',
        'sort_order',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'features' => 'array',
        'tags' => 'array',
    ];

    /**
     * @return LengthAwarePaginator<int, Services>
     */
    public function findAll(): LengthAwarePaginator
    {
        return self::query()->paginate(10);
    }
}
