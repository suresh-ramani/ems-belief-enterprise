<?php

namespace App\Enums\User;

enum Role : string
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case USER = 'user';

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            self::USER => 'User',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'bg-emerald-400',
            self::ADMIN => 'bg-amber-400',
            self::USER => 'bg-gray-400',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => "<span class='badge badge-success'>".$this->label()."</span>",
            self::ADMIN => "<span class='badge badge-warning'>".$this->label()."</span>",
            self::USER => "<span class='badge badge-primary'>".$this->label()."</span>",
        };
    }

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }
}
