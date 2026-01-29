<?php

namespace App\Filament\Widgets;

use App\Models\Owner;
use App\Models\Property;
use App\Models\ReservationNotice;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
//hi

class AppStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $thisMonthStart = Carbon::now()->startOfMonth();

        return [
            Stat::make(' العقارات', Property::query()->count())
                ->icon('heroicon-o-home-modern'),

            Stat::make(' المالكين', Owner::query()->count())
                ->icon('heroicon-o-user-group'),

            Stat::make(' إشارات الحجز', ReservationNotice::query()->count())
                ->icon('heroicon-o-document-text'),

            Stat::make('إضافات هذا الشهر', ReservationNotice::query()->where('created_at', '>=', $thisMonthStart)->count())
                ->description('عدد إشارات الحجز الجديدة هذا الشهر')
                ->icon('heroicon-o-chart-bar'),
        ];
    }
}
