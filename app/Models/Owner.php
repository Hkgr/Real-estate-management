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
        'owner_type',
        'company_name',
        'commercial_register_number',
        'birth_date',
        'national_id',
        'phone',
        'email',
        'is_active',
    ];
    protected $casts = [
        'birth_date' => 'date',
        'owner_type' => 'string',
        'is_active' => 'boolean',
    ];

    public function getDisplayNameAttribute(): string
    {
        if ($this->owner_type === 'company') {
            return $this->company_name ?: $this->full_name;
        }

        return $this->full_name;
    }

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
                'case_number',
                'decision_number',
                'authority',
                'judgment_date',
                'regular_contract_date',
                'contract_number',
                'commercial_contract_date',

            ])
            ->withTimestamps();
    }
    public function signals(): BelongsToMany
    {
        return $this->belongsToMany(Signal::class, 'owner_signal')
            ->withTimestamps();

    }



}
