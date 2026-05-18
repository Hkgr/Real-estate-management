<?php

namespace App\Http\Controllers\ViewerNew\Statistics;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\PropertyCard;
use App\Models\PropertyCardFile;
use App\Models\Signal;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class StatisticsGeneratorController extends Controller
{
    public function __invoke(Request $request): View
    {
        $reportTypeOptions = [
            'general' => 'عام',
            'financial' => 'مالي',
            'administrative' => 'إداري',
        ];

        $scopeOptions = [
            'all' => 'الكل',
            'properties' => 'العقارات',
            'owners' => 'المالكون',
            'signals' => 'الإشارات',
            'files' => 'الملفات',
        ];

        $periodOptions = [
            'all' => 'كل الفترات',
            'last_7_days' => 'آخر 7 أيام',
            'last_30_days' => 'آخر 30 يوماً',
            'last_90_days' => 'آخر 90 يوماً',
        ];

        $filters = [
            'report_type' => array_key_exists((string) $request->query('report_type'), $reportTypeOptions) ? (string) $request->query('report_type') : 'general',
            'scope' => array_key_exists((string) $request->query('scope'), $scopeOptions) ? (string) $request->query('scope') : 'all',
            'period' => array_key_exists((string) $request->query('period'), $periodOptions) ? (string) $request->query('period') : 'all',
        ];

        $hasGenerated = $request->query->has('report_type') || $request->query->has('scope') || $request->query->has('period');

        $summaryMetrics = [];
        $summarySections = [];

        if ($hasGenerated) {
            ['metrics' => $summaryMetrics, 'sections' => $summarySections] = match ($filters['report_type']) {
                'financial' => $this->buildFinancialSummary($filters),
                'administrative' => $this->buildAdministrativeSummary($filters),
                default => $this->buildGeneralSummary($filters),
            };
        }

        return view('viewer-new.statistics.generator', [
            'filters' => $filters,
            'reportTypeOptions' => $reportTypeOptions,
            'scopeOptions' => $scopeOptions,
            'periodOptions' => $periodOptions,
            'summaryMetrics' => $summaryMetrics,
            'summarySections' => $summarySections,
            'generatedAt' => now()->format('Y-m-d H:i'),
            'hasGenerated' => $hasGenerated,
        ]);
    }

    private function buildGeneralSummary(array $filters): array
    {
        $scope = $filters['scope'];
        $metrics = [];

        $metrics[] = ['label' => 'إجمالي العقارات', 'value' => $this->countForScope('properties', $scope, 'property_cards', PropertyCard::query())];
        $metrics[] = ['label' => 'إجمالي المالكين', 'value' => $this->countForScope('owners', $scope, 'owners', Owner::query())];
        $metrics[] = ['label' => 'إجمالي الإشارات', 'value' => $this->countForScope('signals', $scope, 'signals', Signal::query())];
        $metrics[] = ['label' => 'إجمالي الملفات', 'value' => $this->countForScope('files', $scope, 'property_card_files', PropertyCardFile::query())];
        $metrics[] = ['label' => 'تحديثات حديثة حسب الفترة', 'value' => $this->recentUpdatesCount($scope, $filters['period'])];

        return [
            'metrics' => $metrics,
            'sections' => [[
                'title' => 'ملخص عام',
                'rows' => [
                    ['الحقل' => 'نوع التقرير', 'القيمة' => 'عام'],
                    ['الحقل' => 'النطاق', 'القيمة' => $this->scopeLabel($scope)],
                    ['الحقل' => 'الفترة', 'القيمة' => $this->periodLabel($filters['period'])],
                ],
                'message' => null,
            ]],
        ];
    }

    private function buildFinancialSummary(array $filters): array
    {
        $scope = $filters['scope'];
        if (! in_array($scope, ['all', 'properties'], true)) {
            return ['metrics' => [], 'sections' => [[
                'title' => 'ملخص مالي',
                'rows' => [],
                'message' => 'النطاق المختار لا يحتوي مؤشرات مالية. يرجى اختيار "الكل" أو "العقارات".',
            ]]];
        }

        if (! Schema::hasTable('property_cards')) {
            return ['metrics' => [
                ['label' => 'إجمالي قيمة العقارات (USD)', 'value' => 'غير متوفر'],
                ['label' => 'إجمالي القيمة المملوكة (USD)', 'value' => 'غير متوفر'],
                ['label' => 'متوسط قيمة العقار (USD)', 'value' => 'غير متوفر'],
                ['label' => 'عقارات بدون قيمة', 'value' => 'غير متوفر'],
            ], 'sections' => []];
        }

        $hasTotal = Schema::hasColumn('property_cards', 'total_property_value_usd');
        $hasOwned = Schema::hasColumn('property_cards', 'owned_property_value_usd');

        return [
            'metrics' => [
                ['label' => 'إجمالي قيمة العقارات (USD)', 'value' => $hasTotal ? $this->money(PropertyCard::query()->sum('total_property_value_usd')) : 'غير متوفر'],
                ['label' => 'إجمالي القيمة المملوكة (USD)', 'value' => $hasOwned ? $this->money(PropertyCard::query()->sum('owned_property_value_usd')) : 'غير متوفر'],
                ['label' => 'متوسط قيمة العقار (USD)', 'value' => $hasTotal ? $this->money(PropertyCard::query()->whereNotNull('total_property_value_usd')->avg('total_property_value_usd')) : 'غير متوفر'],
                ['label' => 'عقارات بدون قيمة', 'value' => $hasTotal ? number_format(PropertyCard::query()->whereNull('total_property_value_usd')->count()) : 'غير متوفر'],
            ],
            'sections' => [],
        ];
    }

    private function buildAdministrativeSummary(array $filters): array
    {
        return [
            'metrics' => [
                ['label' => 'عقارات بدون مساحة', 'value' => $this->nullableOrZero('properties', $filters['scope'], 'property_cards', 'card_total_area', PropertyCard::query())],
                ['label' => 'عقارات بدون حالة', 'value' => $this->nullableOrBlank('properties', $filters['scope'], 'property_cards', 'card_status', PropertyCard::query())],
                ['label' => 'مالكون بدون هاتف', 'value' => $this->nullableOrBlank('owners', $filters['scope'], 'owners', 'phone', Owner::query())],
                ['label' => 'إشارات بدون عقار', 'value' => $this->nullableOrZero('signals', $filters['scope'], 'signals', 'property_card_id', Signal::query())],
                ['label' => 'ملفات بدون عقار', 'value' => $this->nullableOrZero('files', $filters['scope'], 'property_card_files', 'property_card_id', PropertyCardFile::query())],
            ],
            'sections' => [],
        ];
    }

    private function recentUpdatesCount(string $scope, string $period): string
    {
        if ($period === 'all') {
            return '—';
        }

        $days = match ($period) { 'last_7_days' => 7, 'last_30_days' => 30, 'last_90_days' => 90, default => null };
        if ($days === null) {
            return '—';
        }

        $targets = [
            'properties' => ['table' => 'property_cards', 'query' => PropertyCard::query()],
            'owners' => ['table' => 'owners', 'query' => Owner::query()],
            'signals' => ['table' => 'signals', 'query' => Signal::query()],
            'files' => ['table' => 'property_card_files', 'query' => PropertyCardFile::query()],
        ];

        $sum = 0; $hasAny = false;
        foreach ($targets as $key => $target) {
            if ($scope !== 'all' && $scope !== $key) continue;
            if (! Schema::hasTable($target['table'])) continue;
            $timeColumn = Schema::hasColumn($target['table'], 'updated_at') ? 'updated_at' : (Schema::hasColumn($target['table'], 'created_at') ? 'created_at' : null);
            if (! $timeColumn) continue;
            $hasAny = true;
            $sum += $target['query']->where($timeColumn, '>=', now()->subDays($days))->count();
        }

        return $hasAny ? number_format($sum) : 'غير متوفر';
    }

    private function countForScope(string $target, string $scope, string $table, $query): string
    {
        if ($scope !== 'all' && $scope !== $target) return '—';
        if (! Schema::hasTable($table)) return 'غير متوفر';
        return number_format($query->count());
    }

    private function nullableOrBlank(string $target, string $scope, string $table, string $column, $query): string
    {
        if ($scope !== 'all' && $scope !== $target) return '—';
        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) return 'غير متوفر';
        return number_format($query->where(function ($q) use ($column): void { $q->whereNull($column)->orWhere($column, ''); })->count());
    }

    private function nullableOrZero(string $target, string $scope, string $table, string $column, $query): string
    {
        if ($scope !== 'all' && $scope !== $target) return '—';
        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) return 'غير متوفر';
        return number_format($query->where(function ($q) use ($column): void { $q->whereNull($column)->orWhere($column, 0); })->count());
    }

    private function money(float|int|string|null $value): string { return $value === null ? '—' : number_format((float) $value, 2); }
    private function scopeLabel(string $scope): string { return ['all'=>'الكل','properties'=>'العقارات','owners'=>'المالكون','signals'=>'الإشارات','files'=>'الملفات'][$scope] ?? 'الكل'; }
    private function periodLabel(string $period): string { return ['all'=>'كل الفترات','last_7_days'=>'آخر 7 أيام','last_30_days'=>'آخر 30 يوماً','last_90_days'=>'آخر 90 يوماً'][$period] ?? 'كل الفترات'; }
}
