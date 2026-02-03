<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'card_record_number',
        'card_total_area',
        'card_status',
        'card_investment_type',
        'card_purchase_method',
        'card_sale_date',
        'card_property_details',
        'card_google_maps_url',
    ];

    protected $casts = [
        'card_total_area' => 'decimal:2',
        'card_sale_date' => 'date',
        'card_purchase_method' => 'string',

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
                'purchase_method',
            ])
            ->withTimestamps();
    }
    public function ownerships(): HasMany
    {
        return $this->hasMany(OwnerPropertyCard::class);
    }

    public function signals(): HasMany
    {
        return $this->hasMany(Signal::class);
    }

      public function files(): HasMany
    {
        return $this->hasMany(PropertyCardFile::class);
    }

    public function propertyOwnerPayments(): HasMany
    {
        return $this->hasMany(PropertyOwnerPayment::class);
    }
   public function payments(): HasMany
    {
        return $this->hasMany(PropertyOwnerPayment::class);
    }



}
