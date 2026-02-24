<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class PropertyOperation extends Model
{
    protected $fillable = [
        'property_card_id',
        'operation_type',
        'transaction_amount',
        'transaction_unit',
        'operation_method',
        'case_number',
        'decision_number',
        'authority',
        'judgment_date',
        'judgment_notes',
        'contract_number',
        'contract_date',
        'contract_notes',
    ];

    protected $casts = [
        'transaction_amount' => 'decimal:2',
        'judgment_date' => 'date',
        'contract_date' => 'date',
    ];

    public function propertyCard(): BelongsTo
    {
        return $this->belongsTo(PropertyCard::class);
    }

    public function oldOwners(): BelongsToMany
    {
        return $this->belongsToMany(Owner::class, 'property_operation_old_owner')
            ->withTimestamps();
    }

    public function newOwners(): BelongsToMany
    {
        return $this->belongsToMany(Owner::class, 'property_operation_new_owner')
            ->withTimestamps();
    }

    public function witnesses(): HasMany
    {
        return $this->hasMany(PropertyOperationWitness::class);
    }

    public function syncWitnesses(array|Collection $witnessNames): void
    {
        $witnessNames = collect($witnessNames)
            ->map(fn (string $name): string => trim($name))
            ->filter()
            ->values();

        $count = $witnessNames->count();

        if ($count !== 0 && ($count < 2 || $count > 4)) {
            throw new InvalidArgumentException('Witnesses count must be between 2 and 4 when provided.');
        }

        $this->witnesses()->delete();
        $this->witnesses()->createMany($witnessNames->map(fn (string $name): array => ['witness_name' => $name])->all());
    }
}
