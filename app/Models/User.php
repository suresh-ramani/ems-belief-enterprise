<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\User\Role as RoleEnum;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => RoleEnum::class,
        ];
    }

    public function scopeNotSuperAdmin($query)
    {
        return $query->where('role', '!=', RoleEnum::SUPER_ADMIN->value);
    }

    public function scopeSuperAdmin($query)
    {
        return $query->where('role', RoleEnum::SUPER_ADMIN->value);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === RoleEnum::SUPER_ADMIN;
    }
    
    public function meters()
    {
        return $this->belongsToMany(Meter::class)->withTimestamps();
    }
}
