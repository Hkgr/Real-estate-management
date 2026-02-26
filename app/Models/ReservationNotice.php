<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationNotice extends Model
{
    use SoftDeletes;

    protected static function booted(): void
    {
        static::creating(function (ReservationNotice $reservationNotice): void {
            if (auth()->check()) {
                $reservationNotice->created_by = auth()->id();
                $reservationNotice->updated_by = auth()->id();
            }
        });

        static::updating(function (ReservationNotice $reservationNotice): void {
            if (auth()->check()) {
                $reservationNotice->updated_by = auth()->id();
            }
        });
    }

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
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'notice_date' => 'date',
        'release_date' => 'date',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
