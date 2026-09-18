<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AccountRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $version
 * @property string $client_name
 * @property Client|null $client
 */
final class Board extends Model
{
    protected $table = 'projects';

    protected $guarded = ['id'];

    /** @return array<string, mixed> */
    protected function casts(): array
    {
        return [];
    }

    use SoftDeletes;

    /** @return BelongsTo<Client, $this> */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    protected function getClientNameAttribute(): string
    {
        return $this->client->name ?? 'Sem cliente vinculado';
    }

    /** @return BelongsToMany<User, $this> */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members', 'project_id', 'user_id');
    }

    /** @return HasMany<BoardColumn, $this> */
    public function columns(): HasMany
    {
        return $this->hasMany(BoardColumn::class, 'project_id')->orderBy('order_index')->orderBy('id');
    }

    /** @return HasMany<Card, $this> */
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'project_id');
    }

    /**
     * @param Builder<Board> $query
     * @return Builder<Board>
     */
    protected function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return $user->role() === AccountRole::Developer
            ? $query->whereHas('members', fn ($q) => $q->where('users.id', $user->id)) : $query;
    }
}
