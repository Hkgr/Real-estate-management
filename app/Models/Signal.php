<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Signal extends Model
{
      protected $fillable = [
        'signal_id',
        'signal_year',
        'signal_date',
        'type',
        'signal_owner',
        'signal_owners',
        'signal_source',
        'signal_source_number',
        'signal_source_date',
        'signal_victims',
        'signal_victim',
        'property_id',
        'property_card_id',
    ];
    protected $casts = [
        'signal_owners' => 'array',
        'signal_victims' => 'array',
        'signal_source_date' => 'date',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
    public function propertyCard(): BelongsTo
    {
        return $this->belongsTo(PropertyCard::class);
    }

        public function owners(): BelongsToMany
    {
        return $this->belongsToMany(Owner::class, 'owner_signal')
            ->withTimestamps();
    }
    public function getSignalOwnersLabelAttribute(): string
    {
        $owners = $this->signal_owners ?? [];

        if (is_string($owners)) {
            $owners = json_decode($owners, true) ?? [];
        }

        if (is_array($owners) && count($owners) > 0) {
            $labels = collect($owners)->map(function (array $owner): ?string {
                $name = $owner['name'] ?? null;
                $ownerId = $owner['owner_id'] ?? null;

                if (filled($name)) {
                    return $name;
                }

                if (filled($ownerId)) {
                    return "مالك #{$ownerId}";
                }

                return null;
            })->filter();

            if ($labels->isNotEmpty()) {
                return $labels->implode('، ');
            }
        }

        return $this->signal_owner ?? '-';
    }

    public function getSignalVictimsLabelAttribute(): string
    {
        $victims = $this->signal_victims ?? [];

        if (is_string($victims)) {
            $victims = json_decode($victims, true) ?? [];
        }

        if (is_array($victims) && count($victims) > 0) {
            $labels = collect($victims)->map(function (array $victim): ?string {
                $name = $victim['name'] ?? null;
                $ownerId = $victim['owner_id'] ?? null;

                if (filled($name)) {
                    return $name;
                }

                if (filled($ownerId)) {
                    return "مالك #{$ownerId}";
                }

                return null;
            })->filter();

            if ($labels->isNotEmpty()) {
                return $labels->implode('، ');
            }
        }

        return $this->signal_victim ?? '-';
    }

}
