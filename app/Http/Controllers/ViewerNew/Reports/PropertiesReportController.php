<?php

namespace App\Http\Controllers\ViewerNew\Reports;

use App\Http\Controllers\Controller;
use App\Models\PropertyCard;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PropertiesReportController extends Controller
{
    public function __invoke(Request $request): View
    {
        $table = (new PropertyCard())->getTable();

        $columns = [
            'card_record_number' => Schema::hasColumn($table, 'card_record_number'),
            'card_governorate' => Schema::hasColumn($table, 'card_governorate'),
            'card_region_name' => Schema::hasColumn($table, 'card_region_name'),
            'card_subdivision' => Schema::hasColumn($table, 'card_subdivision'),
            'card_total_area' => Schema::hasColumn($table, 'card_total_area'),
            'card_status' => Schema::hasColumn($table, 'card_status'),
            'owned_property_value_usd' => Schema::hasColumn($table, 'owned_property_value_usd'),
            'total_property_value_usd' => Schema::hasColumn($table, 'total_property_value_usd'),
            'card_property_details' => Schema::hasColumn($table, 'card_property_details'),
            'updated_at' => Schema::hasColumn($table, 'updated_at'),
        ];

        $query = PropertyCard::query()->withCount(['owners', 'operations']);

        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'status' => trim((string) $request->query('status', '')),
        ];

        if ($filters['q'] !== '') {
            $query->where(function (Builder $builder) use ($filters, $columns): void {
                foreach (['card_record_number', 'card_governorate', 'card_region_name', 'card_subdivision', 'card_property_details'] as $searchableColumn) {
                    if ($columns[$searchableColumn] ?? false) {
                        $builder->orWhere($searchableColumn, 'like', '%' . $filters['q'] . '%');
                    }
                }
            });
        }

        $statusOptions = [];
        if ($columns['card_status']) {
            $statusOptions = PropertyCard::query()
                ->select('card_status')
                ->whereNotNull('card_status')
                ->distinct()
                ->orderBy('card_status')
                ->pluck('card_status')
                ->filter()
                ->values()
                ->all();

            if ($filters['status'] !== '' && in_array($filters['status'], $statusOptions, true)) {
                $query->where('card_status', $filters['status']);
            }
        }

        $paginator = $query
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $metrics = [
            'total_properties' => number_format((int) PropertyCard::query()->count()),
            'total_area' => $columns['card_total_area']
                ? number_format((float) (PropertyCard::query()->sum('card_total_area') ?? 0), 2) . ' م²'
                : 'غير متوفر',
            'total_estimated_value' => $this->resolveEstimatedValueMetric($columns),
            'last_update' => $columns['updated_at']
                ? optional(PropertyCard::query()->latest('updated_at')->value('updated_at'))?->format('Y-m-d H:i') ?? '—'
                : 'غير متوفر',
        ];

        return view('viewer-new.reports.properties', [
            'metrics' => $metrics,
            'properties' => $paginator,
            'filters' => $filters,
            'statusOptions' => $statusOptions,
            'columns' => $columns,
        ]);
    }

    private function resolveEstimatedValueMetric(array $columns): string
    {
        $valueColumn = null;

        if (($columns['total_property_value_usd'] ?? false) === true) {
            $valueColumn = 'total_property_value_usd';
        } elseif (($columns['owned_property_value_usd'] ?? false) === true) {
            $valueColumn = 'owned_property_value_usd';
        }

        if ($valueColumn === null) {
            return 'غير متوفر';
        }

        $sum = (float) (PropertyCard::query()->sum($valueColumn) ?? 0);

        return number_format($sum, 2) . ' $';
    }
}
