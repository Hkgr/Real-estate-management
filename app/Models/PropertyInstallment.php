<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyInstallment extends Model
{
    protected $fillable = [
        'property_card_id',
        'amount',
        'payment_date',
        'remaining_after_payment',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'remaining_after_payment' => 'decimal:2',
    ];

    public function propertyCard(): BelongsTo
    {
        return $this->belongsTo(PropertyCard::class);
    }
}
