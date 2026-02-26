<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyCard extends Model
{
    use SoftDeletes;

    protected static function booted(): void
    {
        static::creating(function (PropertyCard $propertyCard): void {
            if (auth()->check()) {
                $propertyCard->created_by = auth()->id();
                $propertyCard->updated_by = auth()->id();
            }
        });

        static::updating(function (PropertyCard $propertyCard): void {
            if (auth()->check()) {
                $propertyCard->updated_by = auth()->id();
            }
        });
    }

    protected $fillable = [
        'card_governorate',
        'card_subdivision',
        'card_region_name',
        'card_record_number',
        'card_property_number',
        'card_total_area',
        'owned_property_value_usd',
        'total_property_value_usd',
        'abdulqader_sankari_total_shares',
        'riyad_asali_total_shares',
        'card_status',
        'card_investment_type',
        'card_purchase_method',
        'card_sale_date',
        'card_property_details',
        'card_google_maps_url',
        'final_balance',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'card_total_area' => 'decimal:2',
        'owned_property_value_usd' => 'decimal:2',
        'total_property_value_usd' => 'decimal:2',
        'abdulqader_sankari_total_shares' => 'decimal:2',
        'riyad_asali_total_shares' => 'decimal:2',
        'card_sale_date' => 'date',
        'card_purchase_method' => 'string',
        'card_record_number' => 'string',
        'final_balance' => 'decimal:2',

    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

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
    public function installments(): HasMany
    {
        return $this->hasMany(PropertyInstallment::class);
    }


    public function propertyOwnerPayments(): HasMany
    {
        return $this->hasMany(PropertyOwnerPayment::class);
    }
   public function payments(): HasMany
    {
        return $this->hasMany(PropertyOwnerPayment::class);
    }
    public function operations(): HasMany
    {
        return $this->hasMany(PropertyOperation::class);
    }





}
