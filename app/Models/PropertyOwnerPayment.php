<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyOwnerPayment extends Model
{
    protected $fillable = [
        'property_card_id',
        'owner_id',
        'debit',
        'credit',
        'statement',
        'voucher',
        'payment_date',
        'balance_movement',
        'currency',
    ];

    protected $casts = [
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
        'payment_date' => 'date',
        'balance_movement' => 'decimal:2',
    ];

    public function propertyCard(): BelongsTo
    {
        return $this->belongsTo(PropertyCard::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }
}
