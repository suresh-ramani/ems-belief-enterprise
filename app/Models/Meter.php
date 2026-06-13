<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['industry_id', 'name', 'location', 'status', 'last_reading_at'])]
class Meter extends Model
{
    use SoftDeletes;

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
