<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyOperationWitness extends Model
{
    protected $fillable = [
        'property_operation_id',
        'witness_name',
    ];

    public function propertyOperation(): BelongsTo
    {
        return $this->belongsTo(PropertyOperation::class);
    }
}
