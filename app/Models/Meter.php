<?php

namespace App\Models;

use App\Enums\Meter\Status as StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['code', 'industry_id', 'name', 'location', 'status', 'last_reading_at'])]
class Meter extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'status' => StatusEnum::class
        ];
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
