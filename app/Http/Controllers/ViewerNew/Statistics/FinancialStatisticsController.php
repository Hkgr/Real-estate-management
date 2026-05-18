<?php

namespace App\Http\Controllers\ViewerNew\Statistics;

use App\Http\Controllers\Controller;
use App\Models\PropertyCard;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

class FinancialStatisticsController extends Controller
{
    public function __invoke(): View
    {
        return view('viewer-new.statistics.financial', [
            'overviewMetrics' => $this->buildOverviewMetrics(),
            'distributionSections' => $this->buildDistributionSections(),
            'topProperties' => $this->buildTopProperties(),
            'financialHealthMetrics' => $this->buildFinancialHealthMetrics(),
            'generatedAt' => now()->format('Y-m-d H:i'),
        ]);
    }

    private function buildOverviewMetrics(): array
    {
        if (! Schema::hasTable('property_cards')) {
            return $this->unavailableOverviewMetrics();
        }

        $hasTotalValue = Schema::hasColumn('property_cards', 'total_property_value_usd');
        $hasOwnedValue = Schema::hasColumn('property_cards', 'owned_property_value_usd');

        return [
            ['label' => 'إجمالي قيمة العقارات (USD)', 'value' => $hasTotalValue ? $this->formatMoney(PropertyCard::query()->sum('total_property_value_usd')) : 'غير متوفر'],
            ['label' => 'إجمالي القيمة المملوكة (USD)', 'value' => $hasOwnedValue ? $this->formatMoney(PropertyCard::query()->sum('owned_property_value_usd')) : 'غير متوفر'],
            ['label' => 'متوسط قيمة العقار (USD)', 'value' => $hasTotalValue ? $this->formatMoney(PropertyCard::query()->whereNotNull('total_property_value_usd')->avg('total_property_value_usd')) : 'غير متوفر'],
            ['label' => 'أعلى قيمة عقار (USD)', 'value' => $hasTotalValue ? $this->formatMoney(PropertyCard::query()->max('total_property_value_usd')) : 'غير متوفر'],
            ['label' => 'أقل قيمة عقار (USD)', 'value' => $hasTotalValue ? $this->formatMoney(PropertyCard::query()->whereNotNull('total_property_value_usd')->min('total_property_value_usd')) : 'غير متوفر'],
            ['label' => 'عقارات بدون قيمة إجمالية', 'value' => $hasTotalValue ? number_format(PropertyCard::query()->whereNull('total_property_value_usd')->count()) : 'غير متوفر'],
        ];
    }

    private function unavailableOverviewMetrics(): array
    {
        return [
            ['label' => 'إجمالي قيمة العقارات (USD)', 'value' => 'غير متوفر'],
            ['label' => 'إجمالي القيمة المملوكة (USD)', 'value' => 'غير متوفر'],
            ['label' => 'متوسط قيمة العقار (USD)', 'value' => 'غير متوفر'],
            ['label' => 'أعلى قيمة عقار (USD)', 'value' => 'غير متوفر'],
            ['label' => 'أقل قيمة عقار (USD)', 'value' => 'غير متوفر'],
            ['label' => 'عقارات بدون قيمة إجمالية', 'value' => 'غير متوفر'],
        ];
    }

    private function buildDistributionSections(): array
    {
        if (! Schema::hasTable('property_cards')) {
            return [];
        }

        return [
            $this->buildValueDistribution('card_status', 'توزيع القيمة حسب الحالة'),
            $this->buildValueDistribution('card_governorate', 'توزيع القيمة حسب المحافظة'),
            $this->buildValueDistribution('card_region_name', 'توزيع القيمة حسب المنطقة'),
        ];
    }

    private function buildValueDistribution(string $groupColumn, string $title): array
    {
        $hasValueColumn = Schema::hasColumn('property_cards', 'total_property_value_usd');

        if (! $hasValueColumn || ! Schema::hasColumn('property_cards', $groupColumn)) {
            return [
                'title' => $title,
                'available' => false,
                'rows' => [],
                'message' => 'غير متوفر',
            ];
        }

        $rows = PropertyCard::query()
            ->selectRaw("COALESCE(NULLIF(TRIM($groupColumn), ''), '—') as label")
            ->selectRaw('SUM(COALESCE(total_property_value_usd, 0)) as total_value')
            ->groupBy('label')
            ->orderByDesc('total_value')
            ->limit(8)
            ->get()
            ->map(fn ($row) => [
                'label' => $row->label,
                'value' => $this->formatMoney($row->total_value),
            ])
            ->all();

        return [
            'title' => $title,
            'available' => true,
            'rows' => $rows,
            'message' => empty($rows) ? 'لا توجد بيانات حالياً.' : null,
        ];
    }

    private function buildTopProperties(): array
    {
        if (! Schema::hasTable('property_cards') || ! Schema::hasColumn('property_cards', 'total_property_value_usd')) {
            return [];
        }

        $fields = [
            'card_record_number' => Schema::hasColumn('property_cards', 'card_record_number'),
            'card_governorate' => Schema::hasColumn('property_cards', 'card_governorate'),
            'card_region_name' => Schema::hasColumn('property_cards', 'card_region_name'),
            'card_status' => Schema::hasColumn('property_cards', 'card_status'),
            'owned_property_value_usd' => Schema::hasColumn('property_cards', 'owned_property_value_usd'),
            'updated_at' => Schema::hasColumn('property_cards', 'updated_at'),
        ];

        $selectColumns = ['id', 'total_property_value_usd'];
        foreach ($fields as $field => $available) {
            if ($available) {
                $selectColumns[] = $field;
            }
        }

        return PropertyCard::query()
            ->select($selectColumns)
            ->orderByDesc('total_property_value_usd')
            ->limit(8)
            ->get()
            ->map(fn (PropertyCard $propertyCard) => [
                'card_record_number' => $fields['card_record_number'] ? ($propertyCard->card_record_number ?: '—') : 'غير متوفر',
                'card_governorate' => $fields['card_governorate'] ? ($propertyCard->card_governorate ?: '—') : 'غير متوفر',
                'card_region_name' => $fields['card_region_name'] ? ($propertyCard->card_region_name ?: '—') : 'غير متوفر',
                'card_status' => $fields['card_status'] ? ($propertyCard->card_status ?: '—') : 'غير متوفر',
                'total_property_value_usd' => $this->formatMoney($propertyCard->total_property_value_usd),
                'owned_property_value_usd' => $fields['owned_property_value_usd'] ? $this->formatMoney($propertyCard->owned_property_value_usd) : 'غير متوفر',
                'updated_at' => $fields['updated_at'] ? ($propertyCard->updated_at?->format('Y-m-d H:i') ?? '—') : 'غير متوفر',
            ])
            ->all();
    }

    private function buildFinancialHealthMetrics(): array
    {
        if (! Schema::hasTable('property_cards')) {
            return [
                ['label' => 'عقارات بدون قيمة إجمالية', 'value' => 'غير متوفر'],
                ['label' => 'عقارات بدون قيمة مملوكة', 'value' => 'غير متوفر'],
                ['label' => 'عقارات بدون مساحة', 'value' => 'غير متوفر'],
                ['label' => 'عقارات بقيمة صفرية أو سالبة', 'value' => 'غير متوفر'],
            ];
        }

        return [
            ['label' => 'عقارات بدون قيمة إجمالية', 'value' => Schema::hasColumn('property_cards', 'total_property_value_usd') ? number_format(PropertyCard::query()->whereNull('total_property_value_usd')->count()) : 'غير متوفر'],
            ['label' => 'عقارات بدون قيمة مملوكة', 'value' => Schema::hasColumn('property_cards', 'owned_property_value_usd') ? number_format(PropertyCard::query()->whereNull('owned_property_value_usd')->count()) : 'غير متوفر'],
            ['label' => 'عقارات بدون مساحة', 'value' => Schema::hasColumn('property_cards', 'card_total_area') ? number_format(PropertyCard::query()->where(function ($query): void {
                $query->whereNull('card_total_area')
                    ->orWhere('card_total_area', '<=', 0);
            })->count()) : 'غير متوفر'],
            ['label' => 'عقارات بقيمة صفرية أو سالبة', 'value' => Schema::hasColumn('property_cards', 'total_property_value_usd') ? number_format(PropertyCard::query()->whereNotNull('total_property_value_usd')->where('total_property_value_usd', '<=', 0)->count()) : 'غير متوفر'],
        ];
    }

    private function formatMoney(float|int|string|null $value): string
    {
        if ($value === null) {
            return '—';
        }

        return number_format((float) $value, 2);
    }
}
