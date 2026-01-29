<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationNotice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'notice_number',
        'notice_date',
        'property_number',
        'issued_by',
        'party_name',
        'reason',
        'notes',
        'status',
        'release_date',
    ];

    protected $casts = [
        'notice_date' => 'date',
        'release_date' => 'date',
    ];
}
