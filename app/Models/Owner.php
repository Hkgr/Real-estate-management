<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        return $this->belongsToMany(Property::class)
            ->using(OwnerProperty::class)
            ->withPivot([
                'ownership_percentage',
                'ownership_metric',
                'is_current',
                'purchase_date',
                'sale_date',
                'purchase_method',
            ])
            ->withTimestamps();
    }

    public function propertyCards()
    {
        return $this->belongsToMany(PropertyCard::class, 'owner_property_card')
            ->using(OwnerPropertyCard::class)
            ->withPivot([
                'ownership_percentage',
                'ownership_metric',
                'is_current',
                'purchase_date',
                'sale_date',
                'purchase_method',
            ])
            ->withTimestamps();
    }
    public function signals(): BelongsToMany
    {
        return $this->belongsToMany(Signal::class, 'owner_signal')
            ->withTimestamps();

    }



}
