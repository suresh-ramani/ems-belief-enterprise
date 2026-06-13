<?php

namespace App\Enums\Meter;

enum Status : string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'bg-emerald-400',
            self::INACTIVE => 'bg-amber-400',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::ACTIVE => '<span class="badge badge-success">Active</span>',
            self::INACTIVE => '<span class="badge badge-danger">Inactive</span>',
        };
    }

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function asOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $status) => [
                $status->value => $status->label(),
            ])
            ->toArray();
    }
}
