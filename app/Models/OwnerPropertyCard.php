<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OwnerPropertyCard extends Pivot
{
    protected $table = 'owner_property_card';

    protected $casts = [
        'ownership_percentage' => 'decimal:2',
        'is_current' => 'boolean',
        'purchase_date' => 'date',
        'sale_date' => 'date',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function propertyCard()
    {
        return $this->belongsTo(PropertyCard::class);
    }
}
