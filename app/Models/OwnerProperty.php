<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OwnerProperty extends Pivot
{
    protected $table = 'owner_property';

    protected $casts = [
        'ownership_percentage' => 'decimal:2',
        'is_current' => 'boolean',
        'purchase_date' => 'date',
        'sale_date' => 'date',
    ];
}
