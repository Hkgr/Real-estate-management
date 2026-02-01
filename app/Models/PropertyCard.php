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
                'card_area_unit',
        'card_status',
        'card_sale_date',
        'card_property_details',
        'card_google_maps_url',
    ];

    protected $casts = [
        'card_total_area' => 'decimal:2',
        'card_sale_date' => 'date',

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
