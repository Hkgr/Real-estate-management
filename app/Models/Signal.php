<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Signal extends Model
{
      protected $fillable = [
        'signal_id',
        'signal_date',
        'type',
        'signal_owner',
        'signal_source',
        'signal_sources',
        'signal_victim',
        'property_id',
        'property_card_id',
    ];
    protected $casts = [
        'signal_sources' => 'array',
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
    public function getSignalSourcesLabelAttribute(): string
    {
        $sources = $this->signal_sources ?? [];

        if (is_string($sources)) {
            $sources = json_decode($sources, true) ?? [];
        }

        if (is_array($sources) && count($sources) > 0) {
            $labels = collect($sources)->map(function (array $source): ?string {
                $name = $source['name'] ?? null;
                $ownerId = $source['owner_id'] ?? null;

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

        return $this->signal_source ?? '-';
    }


}
