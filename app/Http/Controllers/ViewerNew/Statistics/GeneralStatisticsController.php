<?php

namespace App\Http\Controllers\ViewerNew\Statistics;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\PropertyCard;
use App\Models\PropertyCardFile;
use App\Models\Signal;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class GeneralStatisticsController extends Controller
{
    public function __invoke(): View
    {
        $overviewMetrics = $this->buildOverviewMetrics();

        return view('viewer-new.statistics.general', [
            'overviewMetrics' => $overviewMetrics,
            'distributionSections' => $this->buildDistributionSections(),
            'recentProperties' => $this->buildRecentProperties(),
            'completenessMetrics' => $this->buildCompletenessMetrics(),
            'generatedAt' => now()->format('Y-m-d H:i'),
        ]);
    }

    private function buildOverviewMetrics(): array
    {
        $propertyTableExists = Schema::hasTable('property_cards');
        $ownerTableExists = Schema::hasTable('owners');
        $signalTableExists = Schema::hasTable('signals');
        $fileTableExists = Schema::hasTable('property_card_files');

        $latestUpdates = collect();

        if ($propertyTableExists && Schema::hasColumn('property_cards', 'updated_at')) {
            $latestUpdates->push(PropertyCard::query()->max('updated_at'));
        }

        if ($ownerTableExists && Schema::hasColumn('owners', 'updated_at')) {
            $latestUpdates->push(Owner::query()->max('updated_at'));
        }

        if ($signalTableExists && Schema::hasColumn('signals', 'updated_at')) {
            $latestUpdates->push(Signal::query()->max('updated_at'));
        }

        if ($fileTableExists && Schema::hasColumn('property_card_files', 'updated_at')) {
            $latestUpdates->push(PropertyCardFile::query()->max('updated_at'));
        }

        $lastGlobalUpdate = $latestUpdates
            ->filter()
            ->map(fn ($value) => Carbon::parse($value))
            ->sortDesc()
            ->first();

        return [
            ['label' => 'إجمالي العقارات', 'value' => $propertyTableExists ? number_format(PropertyCard::query()->count()) : 'غير متوفر'],
            ['label' => 'إجمالي المالكين', 'value' => $ownerTableExists ? number_format(Owner::query()->count()) : 'غير متوفر'],
            ['label' => 'إجمالي الإشارات', 'value' => $signalTableExists ? number_format(Signal::query()->count()) : 'غير متوفر'],
            ['label' => 'إجمالي الملفات', 'value' => $fileTableExists ? number_format(PropertyCardFile::query()->count()) : 'غير متوفر'],
            ['label' => 'آخر تحديث عام', 'value' => $lastGlobalUpdate?->format('Y-m-d H:i') ?? '—'],
        ];
    }

    private function buildDistributionSections(): array
    {
        if (! Schema::hasTable('property_cards')) {
            return [];
        }

        return [
            $this->buildDistributionSection('card_governorate', 'حسب المحافظة'),
            $this->buildDistributionSection('card_region_name', 'حسب المنطقة'),
            $this->buildDistributionSection('card_status', 'حسب الحالة'),
        ];
    }

    private function buildDistributionSection(string $column, string $title): array
    {
        if (! Schema::hasColumn('property_cards', $column)) {
            return [
                'title' => $title,
                'available' => false,
                'rows' => [],
                'message' => 'غير متوفر',
            ];
        }

        $rows = PropertyCard::query()
            ->selectRaw("COALESCE(NULLIF(TRIM($column), ''), '—') as label")
            ->selectRaw('COUNT(*) as total')
            ->groupBy('label')
            ->orderByDesc('total')
            ->limit(8)
            ->get()
            ->map(fn ($row) => [
                'label' => $row->label,
                'total' => number_format((int) $row->total),
            ])
            ->all();

        return [
            'title' => $title,
            'available' => true,
            'rows' => $rows,
            'message' => empty($rows) ? 'لا توجد بيانات حالياً.' : null,
        ];
    }

    private function buildRecentProperties(): array
    {
        if (! Schema::hasTable('property_cards') || ! Schema::hasColumn('property_cards', 'updated_at')) {
            return [];
        }

        $fields = [
            'card_record_number' => Schema::hasColumn('property_cards', 'card_record_number'),
            'card_governorate' => Schema::hasColumn('property_cards', 'card_governorate'),
            'card_region_name' => Schema::hasColumn('property_cards', 'card_region_name'),
            'card_status' => Schema::hasColumn('property_cards', 'card_status'),
        ];

        $selectColumns = ['id', 'updated_at'];
        foreach ($fields as $field => $available) {
            if ($available) {
                $selectColumns[] = $field;
            }
        }

        return PropertyCard::query()
            ->select($selectColumns)
            ->latest('updated_at')
            ->limit(8)
            ->get()
            ->map(fn (PropertyCard $propertyCard) => [
                'card_record_number' => $fields['card_record_number'] ? ($propertyCard->card_record_number ?: '—') : 'غير متوفر',
                'card_governorate' => $fields['card_governorate'] ? ($propertyCard->card_governorate ?: '—') : 'غير متوفر',
                'card_region_name' => $fields['card_region_name'] ? ($propertyCard->card_region_name ?: '—') : 'غير متوفر',
                'card_status' => $fields['card_status'] ? ($propertyCard->card_status ?: '—') : 'غير متوفر',
                'updated_at' => $propertyCard->updated_at?->format('Y-m-d H:i') ?? '—',
            ])
            ->all();
    }

    private function buildCompletenessMetrics(): array
    {
        $metrics = [];

        if (! Schema::hasTable('property_cards')) {
            return [
                ['label' => 'عقارات بدون مساحة', 'value' => 'غير متوفر'],
                ['label' => 'عقارات بدون حالة', 'value' => 'غير متوفر'],
                ['label' => 'عقارات بدون ملفات', 'value' => 'غير متوفر'],
            ];
        }

        $metrics[] = [
            'label' => 'عقارات بدون مساحة',
            'value' => Schema::hasColumn('property_cards', 'card_total_area')
                ? number_format(PropertyCard::query()->whereNull('card_total_area')->orWhere('card_total_area', '<=', 0)->count())
                : 'غير متوفر',
        ];

        $metrics[] = [
            'label' => 'عقارات بدون حالة',
            'value' => Schema::hasColumn('property_cards', 'card_status')
                ? number_format(PropertyCard::query()->whereNull('card_status')->orWhere('card_status', '')->count())
                : 'غير متوفر',
        ];

        $hasFilesTable = Schema::hasTable('property_card_files');
        $hasPropertyCardId = $hasFilesTable && Schema::hasColumn('property_card_files', 'property_card_id');

        $metrics[] = [
            'label' => 'عقارات بدون ملفات',
            'value' => $hasPropertyCardId
                ? number_format(PropertyCard::query()->whereDoesntHave('files')->count())
                : 'غير متوفر',
        ];

        return $metrics;
    }
}
