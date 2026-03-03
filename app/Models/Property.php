<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    protected static function booted(): void
    {
        static::creating(function (Property $property): void {
            if (auth()->check()) {
                $property->created_by = auth()->id();
                $property->updated_by = auth()->id();
            }
        });

        static::updating(function (Property $property): void {
            if (auth()->check()) {
                $property->updated_by = auth()->id();
            }
        });
    }

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
        'created_by',
        'updated_by',
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
        return $this->belongsToMany(Owner::class)
            ->using(OwnerProperty::class)
            ->withPivot([
                'ownership_percentage',
                'ownership_metric',
                'is_current',
                'purchase_date',
                'sale_date',
            ])
            ->withTimestamps();
    }

    public function signals(): HasMany
    {
        return $this->hasMany(Signal::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


}
