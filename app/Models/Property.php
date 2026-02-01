<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'region_name',
        'cadastral_zone_number',
        'property_number',
        'total_area',
        'owned_area',
        'purchase_date',
        'ownership_percentage',
        'location',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'total_area' => 'decimal:2',
        'owned_area' => 'decimal:2',
        'ownership_percentage' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    // عنوان لطيف للسجل داخل Filament (اختياري):
    public function getDisplayNameAttribute(): string
    {
        return "{$this->region_name} - عقار {$this->property_number}";
    }
        public function owners()
    {
        return $this->belongsToMany(Owner::class)->withTimestamps();
    }

}
