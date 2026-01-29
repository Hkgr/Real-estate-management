<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'full_name',
        'national_id',
        'phone',
        'email',
        'address',
        'notes',
        'is_active',
    ];
}
