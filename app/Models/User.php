<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\AccountRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property Carbon|null $email_verified_at
 * @property string|null $account_role
 * @property bool $access_active
 * @property int $session_version
 * @property array<string, mixed>|null $preferences
 * @property string|null $avatar_path
 * @property Carbon|null $last_login_at
 * @property string|null $totp_secret
 * @property Carbon|null $totp_confirmed_at
 * @property list<string>|null $recovery_codes
 * @property string|null $pending_email
 * @property int $totp_last_step
 */
#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token', 'totp_secret', 'recovery_codes'])]
class User extends Authenticatable
{
    protected $attributes = ['access_active' => true, 'session_version' => 0, 'totp_last_step' => -1];

    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected static function booted(): void
    {
        static::saved(function (self $user): void {
            if (! $user->wasChanged('account_role') && ! $user->wasRecentlyCreated) {
                return;
            }
            if (! $user->account_role) {
                return;
            }
            $name = match ($user->role()) {
                AccountRole::Technical => 'super_admin',
                AccountRole::Owner => 'product_owner',
                default => $user->role()->value,
            };
            $role = DB::table('roles')->where('name', $name)->first();
            if (! $role) {
                return;
            }
            // Expire previous assignments, preserving role history.
            DB::table('user_roles')->where('user_id', $user->id)->where('role_id', '!=', $role->id)->update(['expires_at' => now(), 'updated_at' => now()]);
            DB::table('user_roles')->updateOrInsert(['user_id' => $user->id, 'role_id' => $role->id], ['expires_at' => null, 'updated_at' => now(), 'created_at' => now()]);
        });
    }

    public function role(): AccountRole
    {
        return AccountRole::tryFrom($this->account_role ?? '')
            ?? ($this->is_admin ? AccountRole::Manager : AccountRole::Developer);
    }

    public function canModule(string $module): bool
    {
        return $this->access_active && in_array($module, $this->role()->modules(), true);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_admin' => 'boolean',
            'password' => 'hashed',
            'access_active' => 'boolean', 'preferences' => 'array', 'last_login_at' => 'datetime',
            'totp_secret' => 'encrypted', 'recovery_codes' => 'encrypted:array', 'totp_confirmed_at' => 'datetime',
        ];
    }
}
