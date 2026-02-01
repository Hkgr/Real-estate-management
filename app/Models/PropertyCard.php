<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyCard extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'card_governorate',
        'card_subdivision',
        'card_region_name',
        'card_cadastral_zone_number',
        'card_property_number',
        'card_total_area',
        'card_purchase_date',
        'card_status',
        'card_property_details',
        'card_location',
        'card_latitude',
        'card_longitude',
    ];

    protected $casts = [
        'card_purchase_date' => 'date',
        'card_total_area' => 'decimal:2',
        'card_latitude' => 'decimal:7',
        'card_longitude' => 'decimal:7',
    ];
        public function owners()
    {
        return $this->belongsToMany(Owner::class, 'owner_property_card')
            ->using(OwnerPropertyCard::class)
            ->withPivot([
                'ownership_percentage',
                'ownership_metric',
                'is_current',
                'purchase_date',
                'sale_date',
            ])
            ->withTimestamps();
    }

}
