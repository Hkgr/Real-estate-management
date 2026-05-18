<?php

namespace App\Http\Controllers\ViewerNew\Statistics;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\PropertyCard;
use App\Models\PropertyCardFile;
use App\Models\Signal;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
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
        $period = $filters['period'];

        return [
            'metrics' => [
                ['label' => 'إجمالي العقارات', 'value' => $this->countForScope('properties', $scope, 'property_cards', PropertyCard::query(), $period)],
                ['label' => 'إجمالي المالكين', 'value' => $this->countForScope('owners', $scope, 'owners', Owner::query(), $period)],
                ['label' => 'إجمالي الإشارات', 'value' => $this->countForScope('signals', $scope, 'signals', Signal::query(), $period)],
                ['label' => 'إجمالي الملفات', 'value' => $this->countForScope('files', $scope, 'property_card_files', PropertyCardFile::query(), $period)],
                ['label' => 'تحديثات حديثة حسب الفترة', 'value' => $this->recentUpdatesCount($scope, $period)],
            ],
            'sections' => [[
                'title' => 'ملخص عام',
                'rows' => [
                    ['الحقل' => 'نوع التقرير', 'القيمة' => 'عام'],
                    ['الحقل' => 'النطاق', 'القيمة' => $this->scopeLabel($scope)],
                    ['الحقل' => 'الفترة', 'القيمة' => $this->periodLabel($period)],
                ],
                'message' => null,
            ]],
        ];
    }

    private function buildFinancialSummary(array $filters): array
    {
        $scope = $filters['scope'];
        $period = $filters['period'];

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

        $baseQuery = $this->applyPeriod(PropertyCard::query(), 'property_cards', $period);
        $hasTotal = Schema::hasColumn('property_cards', 'total_property_value_usd');
        $hasOwned = Schema::hasColumn('property_cards', 'owned_property_value_usd');

        return [
            'metrics' => [
                ['label' => 'إجمالي قيمة العقارات (USD)', 'value' => $hasTotal ? $this->aggregateMoney($baseQuery, 'total_property_value_usd', 'sum') : 'غير متوفر'],
                ['label' => 'إجمالي القيمة المملوكة (USD)', 'value' => $hasOwned ? $this->aggregateMoney($baseQuery, 'owned_property_value_usd', 'sum') : 'غير متوفر'],
                ['label' => 'متوسط قيمة العقار (USD)', 'value' => $hasTotal ? $this->aggregateMoney($baseQuery, 'total_property_value_usd', 'avg', true) : 'غير متوفر'],
                ['label' => 'عقارات بدون قيمة', 'value' => $hasTotal ? $this->whereNullCount($baseQuery, 'total_property_value_usd') : 'غير متوفر'],
            ],
            'sections' => [],
        ];
    }

    private function buildAdministrativeSummary(array $filters): array
    {
        $period = $filters['period'];

        return [
            'metrics' => [
                ['label' => 'عقارات بدون مساحة', 'value' => $this->nullableOrZero('properties', $filters['scope'], 'property_cards', 'card_total_area', PropertyCard::query(), $period)],
                ['label' => 'عقارات بدون حالة', 'value' => $this->nullableOrBlank('properties', $filters['scope'], 'property_cards', 'card_status', PropertyCard::query(), $period)],
                ['label' => 'مالكون بدون هاتف', 'value' => $this->nullableOrBlank('owners', $filters['scope'], 'owners', 'phone', Owner::query(), $period)],
                ['label' => 'إشارات بدون عقار', 'value' => $this->nullableOrZero('signals', $filters['scope'], 'signals', 'property_card_id', Signal::query(), $period)],
                ['label' => 'ملفات بدون عقار', 'value' => $this->nullableOrZero('files', $filters['scope'], 'property_card_files', 'property_card_id', PropertyCardFile::query(), $period)],
            ],
            'sections' => [],
        ];
    }

    private function recentUpdatesCount(string $scope, string $period): string
    {
        if ($period === 'all') {
            return '—';
        }

        $targets = [
            'properties' => ['table' => 'property_cards', 'query' => PropertyCard::query()],
            'owners' => ['table' => 'owners', 'query' => Owner::query()],
            'signals' => ['table' => 'signals', 'query' => Signal::query()],
            'files' => ['table' => 'property_card_files', 'query' => PropertyCardFile::query()],
        ];

        $sum = 0;
        $hasAny = false;

        foreach ($targets as $key => $target) {
            if ($scope !== 'all' && $scope !== $key) {
                continue;
            }

            $periodQuery = $this->applyPeriod($target['query'], $target['table'], $period);
            if ($periodQuery === null) {
                continue;
            }

            $hasAny = true;
            $sum += $periodQuery->count();
        }

        return $hasAny ? number_format($sum) : 'غير متوفر';
    }

    private function countForScope(string $target, string $scope, string $table, Builder $query, string $period): string
    {
        if ($scope !== 'all' && $scope !== $target) {
            return '—';
        }

        if (! Schema::hasTable($table)) {
            return 'غير متوفر';
        }

        $periodQuery = $this->applyPeriod($query, $table, $period);
        if ($periodQuery === null) {
            return 'غير متوفر';
        }

        return number_format($periodQuery->count());
    }

    private function nullableOrBlank(string $target, string $scope, string $table, string $column, Builder $query, string $period): string
    {
        if ($scope !== 'all' && $scope !== $target) {
            return '—';
        }

        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) {
            return 'غير متوفر';
        }

        $periodQuery = $this->applyPeriod($query, $table, $period);
        if ($periodQuery === null) {
            return 'غير متوفر';
        }

        return number_format($periodQuery->where(function ($q) use ($column): void {
            $q->whereNull($column)->orWhere($column, '');
        })->count());
    }

    private function nullableOrZero(string $target, string $scope, string $table, string $column, Builder $query, string $period): string
    {
        if ($scope !== 'all' && $scope !== $target) {
            return '—';
        }

        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) {
            return 'غير متوفر';
        }

        $periodQuery = $this->applyPeriod($query, $table, $period);
        if ($periodQuery === null) {
            return 'غير متوفر';
        }

        return number_format($periodQuery->where(function ($q) use ($column): void {
            $q->whereNull($column)->orWhere($column, 0);
        })->count());
    }

    private function applyPeriod(Builder $query, string $table, string $period): ?Builder
    {
        $days = $this->periodDays($period);

        if ($days === null) {
            return $period === 'all' ? $query : null;
        }

        if (! Schema::hasTable($table)) {
            return null;
        }

        $timeColumn = Schema::hasColumn($table, 'updated_at')
            ? 'updated_at'
            : (Schema::hasColumn($table, 'created_at') ? 'created_at' : null);

        if ($timeColumn === null) {
            return null;
        }

        return $query->where($timeColumn, '>=', now()->subDays($days));
    }

    private function periodDays(string $period): ?int
    {
        return match ($period) {
            'all' => null,
            'last_7_days' => 7,
            'last_30_days' => 30,
            'last_90_days' => 90,
            default => null,
        };
    }

    private function aggregateMoney(?Builder $baseQuery, string $column, string $method, bool $excludeNull = false): string
    {
        if ($baseQuery === null) {
            return 'غير متوفر';
        }

        $query = clone $baseQuery;
        if ($excludeNull) {
            $query->whereNotNull($column);
        }

        return $this->money($query->{$method}($column));
    }

    private function whereNullCount(?Builder $baseQuery, string $column): string
    {
        if ($baseQuery === null) {
            return 'غير متوفر';
        }

        return number_format((clone $baseQuery)->whereNull($column)->count());
    }

    private function money(float|int|string|null $value): string
    {
        return $value === null ? '—' : number_format((float) $value, 2);
    }

    private function scopeLabel(string $scope): string
    {
        return ['all' => 'الكل', 'properties' => 'العقارات', 'owners' => 'المالكون', 'signals' => 'الإشارات', 'files' => 'الملفات'][$scope] ?? 'الكل';
    }

    private function periodLabel(string $period): string
    {
        return ['all' => 'كل الفترات', 'last_7_days' => 'آخر 7 أيام', 'last_30_days' => 'آخر 30 يوماً', 'last_90_days' => 'آخر 90 يوماً'][$period] ?? 'كل الفترات';
    }
}
