<?php

namespace App\Models;

use App\Enums\Industry\Status as StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'owner_name', 'owner_email', 'owner_phone', 'address'])]
class Industry extends Model
{
    use SoftDeletes;

    public function casts()
    {
        return [
            'status' => StatusEnum::class
        ];
    }

    public function meters()
    {
        return $this->hasMany(Meter::class);
    }
}
