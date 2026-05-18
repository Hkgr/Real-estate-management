<?php

namespace App\Http\Controllers\ViewerNew\Statistics;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\PropertyCard;
use App\Models\PropertyCardFile;
use App\Models\Signal;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StatisticsGatewayController extends Controller
{
    public function __invoke(): View
    {
        $primaryMetrics = [
            ['label' => 'إجمالي العقارات', 'value' => $this->formatNumber($this->safeCount(new PropertyCard()))],
            ['label' => 'إجمالي المالكين', 'value' => $this->formatNumber($this->safeCount(new Owner()))],
            ['label' => 'إجمالي الإشارات', 'value' => $this->formatNumber($this->safeCount(new Signal()))],
            ['label' => 'إجمالي الملفات', 'value' => $this->formatNumber($this->safeCount(new PropertyCardFile()))],
        ];

        $secondaryMetrics = [
            ['label' => 'إجمالي المساحة', 'value' => $this->sumIfColumnExists('property_cards', 'card_total_area', 2)],
            ['label' => 'إجمالي قيمة العقارات (USD)', 'value' => $this->sumIfColumnExists('property_cards', 'total_property_value_usd', 2)],
            ['label' => 'القيمة المملوكة (USD)', 'value' => $this->sumIfColumnExists('property_cards', 'owned_property_value_usd', 2)],
            ['label' => 'المالكون النشطون', 'value' => $this->activeOwnersCount()],
            ['label' => 'الملفات المرتبطة بعقارات', 'value' => $this->linkedFilesCount()],
            ['label' => 'آخر تحديث عام', 'value' => $this->lastGlobalUpdate()],
        ];

        $dataHealthMetrics = [
            ['label' => 'عقارات بدون ملفات', 'value' => $this->propertiesWithoutFiles()],
            ['label' => 'إشارات مرتبطة بعقارات', 'value' => $this->signalsLinkedToProperties()],
            ['label' => 'ملاك مرتبطون ببطاقات عقارية', 'value' => $this->ownersWithPropertyCards()],
        ];

        return view('viewer-new.statistics', [
            'primaryMetrics' => $primaryMetrics,
            'secondaryMetrics' => $secondaryMetrics,
            'dataHealthMetrics' => $dataHealthMetrics,
            'generatedAt' => now()->format('Y-m-d H:i'),
        ]);
    }

    private function safeCount(object $model): string
    {
        $table = $model->getTable();

        if (! Schema::hasTable($table)) {
            return 'غير متوفر';
        }

        return (string) $model->newQuery()->count();
    }

    private function sumIfColumnExists(string $table, string $column, int $decimals = 0): string
    {
        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) {
            return 'غير متوفر';
        }

        $value = (float) DB::table($table)->sum($column);

        return number_format($value, $decimals);
    }

    private function activeOwnersCount(): string
    {
        if (! Schema::hasTable('owners') || ! Schema::hasColumn('owners', 'is_active')) {
            return 'غير متوفر';
        }

        return $this->formatNumber((string) DB::table('owners')->where('is_active', true)->count());
    }

    private function linkedFilesCount(): string
    {
        if (! Schema::hasTable('property_card_files') || ! Schema::hasColumn('property_card_files', 'property_card_id')) {
            return 'غير متوفر';
        }

        return $this->formatNumber((string) DB::table('property_card_files')->whereNotNull('property_card_id')->count());
    }

    private function propertiesWithoutFiles(): string
    {
        if (! Schema::hasTable('property_cards') || ! Schema::hasTable('property_card_files')) {
            return 'غير متوفر';
        }

        if (! Schema::hasColumn('property_card_files', 'property_card_id')) {
            return 'غير متوفر';
        }

        $count = DB::table('property_cards')
            ->leftJoin('property_card_files', 'property_cards.id', '=', 'property_card_files.property_card_id')
            ->whereNull('property_card_files.id')
            ->count('property_cards.id');

        return $this->formatNumber((string) $count);
    }

    private function signalsLinkedToProperties(): string
    {
        if (! Schema::hasTable('signals') || ! Schema::hasColumn('signals', 'property_card_id')) {
            return 'غير متوفر';
        }

        return $this->formatNumber((string) DB::table('signals')->whereNotNull('property_card_id')->count());
    }

    private function ownersWithPropertyCards(): string
    {
        if (! Schema::hasTable('owner_property_card') || ! Schema::hasColumn('owner_property_card', 'owner_id')) {
            return 'غير متوفر';
        }

        $count = DB::table('owner_property_card')->distinct()->count('owner_id');

        return $this->formatNumber((string) $count);
    }

    private function lastGlobalUpdate(): string
    {
        $tables = ['property_cards', 'owners', 'signals', 'property_card_files'];
        $latest = null;

        foreach ($tables as $table) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'updated_at')) {
                continue;
            }

            $maxDate = DB::table($table)->max('updated_at');
            if ($maxDate === null) {
                continue;
            }

            $candidate = Carbon::parse($maxDate);
            if ($latest === null || $candidate->greaterThan($latest)) {
                $latest = $candidate;
            }
        }

        return $latest?->format('Y-m-d H:i') ?? '—';
    }

    private function formatNumber(string $number): string
    {
        if (! is_numeric($number)) {
            return $number;
        }

        return number_format((float) $number, 0);
    }
}
