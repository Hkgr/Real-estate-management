<?php

namespace App\Filament\Widgets;

use App\Models\PropertyCard;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AppStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $cardsQuery = PropertyCard::query();
        $cardsCount = (clone $cardsQuery)->count();

        $totalFinalBalance = (float) ((clone $cardsQuery)->sum('final_balance') ?? 0);
        $avgOwnedValue = (float) ((clone $cardsQuery)->avg('owned_property_value_usd') ?? 0);
        $abdulqaderShares = (float) ((clone $cardsQuery)->sum('abdulqader_sankari_total_shares') ?? 0);
        $riyadShares = (float) ((clone $cardsQuery)->sum('riyad_asali_total_shares') ?? 0);
        $operationsShares = (float) ((clone $cardsQuery)->sum('operations_total_shares') ?? 0);

        $abdulqaderRatio = $operationsShares > 0 ? ($abdulqaderShares / $operationsShares) * 100 : 0;
        $riyadRatio = $operationsShares > 0 ? ($riyadShares / $operationsShares) * 100 : 0;

        $months = collect(range(5, 0))
            ->map(fn (int $offset) => Carbon::now()->subMonths($offset)->startOfMonth())
            ->push(Carbon::now()->startOfMonth())
            ->values();

        $cardsChart = $months->map(function (Carbon $month): int {
            return PropertyCard::query()
                ->whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                ->count();
        })->all();

        $balanceChart = $months->map(function (Carbon $month): float {
            return (float) (PropertyCard::query()
                ->whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                ->sum('final_balance') ?? 0);
        })->all();

        return [
            Stat::make('بطاقات العقار 2', number_format($cardsCount))
            ->icon('heroicon-o-home-modern'),

            Stat::make('صافي الرصيد الإجمالي', '$ ' . number_format($totalFinalBalance, 2))
                ->description('مجموع الحقل final_balance لكافة البطاقات')
                ->descriptionIcon('heroicon-o-banknotes')
                ->chart($balanceChart)
                ->color($totalFinalBalance >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-currency-dollar'),

            Stat::make('متوسط قيمة الملكية (USD)', '$ ' . number_format($avgOwnedValue, 2))
                ->description('متوسط owned_property_value_usd')
                ->chart($cardsChart)
                ->color('info')
                ->icon('heroicon-o-calculator'),



            Stat::make('حصة عبد القادر السنكري', number_format($abdulqaderShares, 2))
                ->description('نسبة من مجموع الأسهم: ' . number_format($abdulqaderRatio, 2) . '%')
                ->descriptionIcon('heroicon-o-chart-pie')
                ->color('warning')
                ->icon('heroicon-o-user'),


          Stat::make('حصة رياض عسلي', number_format($riyadShares, 2))
                ->description('نسبة من مجموع الأسهم: ' . number_format($riyadRatio, 2) . '%')
                ->descriptionIcon('heroicon-o-chart-pie')
                ->color('primary')
                ->icon('heroicon-o-user-circle'),

        ];
    }
}
