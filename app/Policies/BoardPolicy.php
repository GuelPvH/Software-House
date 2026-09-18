<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\AccountRole;
use App\Models\Board;
use App\Models\User;

final readonly class BoardPolicy
{
    public function view(User $user, Board $board): bool
    {
        return $user->canModule('projects') && ($user->role() !== AccountRole::Developer || $board->members()->where('users.id', $user->id)->exists());
    }

    public function update(User $user, Board $board): bool
    {
        return $this->view($user, $board);
    }

    public function manage(User $user, Board $board): bool
    {
        return $user->canModule('projects') && in_array($user->role(), [AccountRole::Manager, AccountRole::Owner], true);
    }

    public function create(User $user): bool
    {
        return $user->canModule('projects') && in_array($user->role(), [AccountRole::Manager, AccountRole::Owner], true);
    }
}
