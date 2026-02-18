<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Owner extends Model
{
    use SoftDeletes;
    protected static function booted(): void
    {
        static::saving(function (Owner $owner): void {
            if ($owner->owner_type === 'company' && blank($owner->full_name)) {
                $owner->full_name = (string) ($owner->company_name ?? '');
            }
        });
    }


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
    protected $appends = [
        'display_name',
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
   public function oldPropertyOperations(): BelongsToMany
    {
        return $this->belongsToMany(PropertyOperation::class, 'property_operation_old_owner')
            ->withTimestamps();
    }

    public function newPropertyOperations(): BelongsToMany
    {
        return $this->belongsToMany(PropertyOperation::class, 'property_operation_new_owner')
            ->withTimestamps();
    }

    public function signals(): BelongsToMany
    {
        return $this->belongsToMany(Signal::class, 'owner_signal')
            ->withTimestamps();

    }



}
