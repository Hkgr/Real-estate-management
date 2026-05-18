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

class AdministrativeStatisticsController extends Controller
{
    public function __invoke(): View
    {
        return view('viewer-new.statistics.administrative', [
            'overviewMetrics' => $this->buildOverviewMetrics(),
            'dataQualityMetrics' => $this->buildDataQualityMetrics(),
            'followUpMetrics' => $this->buildFollowUpMetrics(),
            'recentSections' => $this->buildRecentSections(),
            'generatedAt' => now()->format('Y-m-d H:i'),
        ]);
    }

    private function buildOverviewMetrics(): array
    {
        return [
            ['label' => 'عقارات محدثة خلال 30 يوماً', 'value' => $this->recentCount('property_cards', PropertyCard::query(), 'updated_at')],
            ['label' => 'مالكون محدثون خلال 30 يوماً', 'value' => $this->recentCount('owners', Owner::query(), 'updated_at')],
            ['label' => 'إشارات محدثة خلال 30 يوماً', 'value' => $this->recentCount('signals', Signal::query(), 'updated_at')],
            ['label' => 'ملفات حديثة خلال 30 يوماً', 'value' => $this->recentFilesCount()],
        ];
    }

    private function buildDataQualityMetrics(): array
    {
        $hasPropertyCards = Schema::hasTable('property_cards');
        $hasFiles = Schema::hasTable('property_card_files');

        return [
            ['label' => 'عقارات بدون مساحة', 'value' => $this->nullableOrZeroCount($hasPropertyCards, 'property_cards', 'card_total_area', PropertyCard::query())],
            ['label' => 'عقارات بدون حالة', 'value' => $this->nullableOrBlankCount($hasPropertyCards, 'property_cards', 'card_status', PropertyCard::query())],
            ['label' => 'عقارات بدون ملفات', 'value' => ($hasPropertyCards && $hasFiles && Schema::hasColumn('property_card_files', 'property_card_id')) ? number_format(PropertyCard::query()->whereDoesntHave('files')->count()) : 'غير متوفر'],
            ['label' => 'مالكون بدون هاتف', 'value' => $this->nullableOrBlankCount(Schema::hasTable('owners'), 'owners', 'phone', Owner::query())],
            ['label' => 'مالكون بدون بريد إلكتروني', 'value' => $this->nullableOrBlankCount(Schema::hasTable('owners'), 'owners', 'email', Owner::query())],
            ['label' => 'إشارات بدون ارتباط بعقار', 'value' => $this->nullableOrZeroCount(Schema::hasTable('signals'), 'signals', 'property_card_id', Signal::query())],
        ];
    }

    private function buildFollowUpMetrics(): array
    {
        $hasSignals = Schema::hasTable('signals');
        $hasFiles = Schema::hasTable('property_card_files');

        return [
            ['label' => 'إشارات نشطة', 'value' => $this->activeSignalsCount($hasSignals)],
            ['label' => 'إشارات بدون تاريخ', 'value' => $this->nullableOrBlankCount($hasSignals, 'signals', 'signal_date', Signal::query())],
            ['label' => 'ملفات بدون عقار', 'value' => $this->nullableOrZeroCount($hasFiles, 'property_card_files', 'property_card_id', PropertyCardFile::query())],
            ['label' => 'ملفات بدون اسم', 'value' => $this->nullableOrBlankCount($hasFiles, 'property_card_files', 'file_name', PropertyCardFile::query())],
        ];
    }

    private function buildRecentSections(): array
    {
        return [
            $this->buildRecentPropertiesSection(),
            $this->buildRecentOwnersSection(),
            $this->buildRecentSignalsSection(),
            $this->buildRecentFilesSection(),
        ];
    }

    private function buildRecentPropertiesSection(): array
    {
        if (! Schema::hasTable('property_cards') || ! Schema::hasColumn('property_cards', 'updated_at')) {
            return $this->emptySection('آخر العقارات', 'غير متوفر');
        }

        $rows = PropertyCard::query()
            ->select(['id', 'updated_at', 'card_record_number', 'card_governorate', 'card_region_name', 'card_status'])
            ->latest('updated_at')
            ->limit(8)
            ->get()
            ->map(fn (PropertyCard $item) => [
                'رقم السجل' => $item->card_record_number ?: '—',
                'المحافظة' => $item->card_governorate ?: '—',
                'المنطقة' => $item->card_region_name ?: '—',
                'الحالة' => $item->card_status ?: '—',
                'آخر تحديث' => $item->updated_at?->format('Y-m-d H:i') ?? '—',
            ])->all();

        return $this->tableSection('آخر العقارات', $rows);
    }

    private function buildRecentOwnersSection(): array
    {
        if (! Schema::hasTable('owners') || ! Schema::hasColumn('owners', 'updated_at')) {
            return $this->emptySection('آخر المالكين', 'غير متوفر');
        }

        $rows = Owner::query()->latest('updated_at')->limit(8)->get()->map(fn (Owner $item) => [
            'الاسم' => $item->display_name ?: ($item->full_name ?: ($item->company_name ?: '—')),
            'الهاتف' => Schema::hasColumn('owners', 'phone') ? ($item->phone ?: '—') : 'غير متوفر',
            'نشط' => Schema::hasColumn('owners', 'is_active') ? ($item->is_active ? 'نعم' : 'لا') : 'غير متوفر',
            'آخر تحديث' => $item->updated_at?->format('Y-m-d H:i') ?? '—',
        ])->all();

        return $this->tableSection('آخر المالكين', $rows);
    }

    private function buildRecentSignalsSection(): array
    {
        if (! Schema::hasTable('signals') || ! Schema::hasColumn('signals', 'updated_at')) {
            return $this->emptySection('آخر الإشارات', 'غير متوفر');
        }

        $rows = Signal::query()->select(['id', 'signal_id', 'type', 'signal_date', 'updated_at'])->latest('updated_at')->limit(8)->get()->map(fn (Signal $item) => [
            'رقم الإشارة' => $item->signal_id ?: '—',
            'النوع' => $item->type ?: '—',
            'تاريخ الإشارة' => $item->signal_date ? Carbon::parse($item->signal_date)->format('Y-m-d') : '—',
            'آخر تحديث' => $item->updated_at?->format('Y-m-d H:i') ?? '—',
        ])->all();

        return $this->tableSection('آخر الإشارات', $rows);
    }

    private function buildRecentFilesSection(): array
    {
        if (! Schema::hasTable('property_card_files')) {
            return $this->emptySection('آخر الملفات', 'غير متوفر');
        }

        $hasUpdatedAt = Schema::hasColumn('property_card_files', 'updated_at');
        $hasCreatedAt = Schema::hasColumn('property_card_files', 'created_at');
        $timeColumn = $hasUpdatedAt ? 'updated_at' : ($hasCreatedAt ? 'created_at' : null);

        if ($timeColumn === null) {
            return $this->emptySection('آخر الملفات', 'غير متوفر');
        }

        $rows = PropertyCardFile::query()->select(['id', 'file_name', 'mime_type', 'property_card_id', $timeColumn])->latest($timeColumn)->limit(8)->get()->map(fn (PropertyCardFile $item) => [
            'اسم الملف' => $item->file_name ?: '—',
            'النوع' => $item->mime_type ?: '—',
            'رقم العقار' => $item->property_card_id ? (string) $item->property_card_id : '—',
            'آخر تحديث' => $item->{$timeColumn}?->format('Y-m-d H:i') ?? '—',
        ])->all();

        return $this->tableSection('آخر الملفات', $rows);
    }

    private function recentCount(string $table, $query, string $column): string
    {
        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) {
            return 'غير متوفر';
        }

        return number_format($query->where($column, '>=', now()->subDays(30))->count());
    }

    private function recentFilesCount(): string
    {
        if (! Schema::hasTable('property_card_files')) {
            return 'غير متوفر';
        }

        $hasCreatedAt = Schema::hasColumn('property_card_files', 'created_at');
        $hasUpdatedAt = Schema::hasColumn('property_card_files', 'updated_at');

        if (! $hasCreatedAt && ! $hasUpdatedAt) {
            return 'غير متوفر';
        }

        return number_format(PropertyCardFile::query()->where(function ($query) use ($hasCreatedAt, $hasUpdatedAt): void {
            if ($hasUpdatedAt) {
                $query->where('updated_at', '>=', now()->subDays(30));
            }

            if ($hasCreatedAt) {
                $hasUpdatedAt
                    ? $query->orWhere('created_at', '>=', now()->subDays(30))
                    : $query->where('created_at', '>=', now()->subDays(30));
            }
        })->count());
    }

    private function activeSignalsCount(bool $hasSignals): string
    {
        if (! $hasSignals || ! Schema::hasColumn('signals', 'status')) {
            return 'غير متوفر';
        }

        return number_format(Signal::query()->whereIn('status', ['active', 'نشط', 'مفتوح'])->count());
    }

    private function nullableOrBlankCount(bool $hasTable, string $table, string $column, $query): string
    {
        if (! $hasTable || ! Schema::hasColumn($table, $column)) {
            return 'غير متوفر';
        }

        return number_format($query->whereNull($column)->orWhere($column, '')->count());
    }

    private function nullableOrZeroCount(bool $hasTable, string $table, string $column, $query): string
    {
        if (! $hasTable || ! Schema::hasColumn($table, $column)) {
            return 'غير متوفر';
        }

        return number_format($query->whereNull($column)->orWhere($column, 0)->count());
    }

    private function tableSection(string $title, array $rows): array
    {
        if (empty($rows)) {
            return $this->emptySection($title, 'لا توجد بيانات حالياً.');
        }

        return ['title' => $title, 'rows' => $rows, 'message' => null];
    }

    private function emptySection(string $title, string $message): array
    {
        return ['title' => $title, 'rows' => [], 'message' => $message];
    }
}
