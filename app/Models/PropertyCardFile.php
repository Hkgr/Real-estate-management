<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyCardFile extends Model
{
    protected $fillable = [
        'property_card_id',
        'file_name',
        'issued_at',
        'storage_disk',
        'storage_path',
        'mime_type',
        'file_size',
    ];

    protected $casts = [
        'issued_at' => 'date',
    ];

    public function propertyCard(): BelongsTo
    {
        return $this->belongsTo(PropertyCard::class);
    }
}
