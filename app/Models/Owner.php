<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'full_name',
        'birth_date',
        'national_id',
        'phone',
        'email',
        'is_active',
    ];
        protected $casts = [
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function properties()
    {
        return $this->belongsToMany(Property::class)->withTimestamps();
    }

}
