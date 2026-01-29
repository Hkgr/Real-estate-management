<?php

namespace App\Filament\Resources\ReservationNotices\Pages;

use App\Filament\Resources\ReservationNotices\ReservationNoticeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReservationNotice extends CreateRecord
{
    protected static string $resource = ReservationNoticeResource::class;

    public function getTitle(): string
    {
        return 'إضافة إشارة حجز';
    }
}
