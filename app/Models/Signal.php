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
        'type',
        'signal_owner',
        'signal_source',
        'signal_victim',
        'property_id',
    ];
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
        public function owners(): BelongsToMany
    {
        return $this->belongsToMany(Owner::class, 'owner_signal')
            ->withTimestamps();
    }


}
