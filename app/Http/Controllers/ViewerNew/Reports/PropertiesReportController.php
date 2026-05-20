<?php

namespace App\Http\Controllers\ViewerNew\Reports;

use App\Http\Controllers\Controller;
use App\Models\PropertyCard;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

class PropertiesReportController extends Controller
{
    public function __invoke(Request $request): View
    {
        $property = new PropertyCard();
        $table = $property->getTable();

        $fieldAvailability = $this->resolveFieldAvailability($table);
        $filters = $this->resolveFilters($request);

        $baseQuery = PropertyCard::query();
        $this->applyFilters($baseQuery, $filters, $fieldAvailability);

        $reportQuery = PropertyCard::query();
        $this->applyFilters($reportQuery, $filters, $fieldAvailability);

        $this->applySafeCounts($reportQuery, $property);

        $properties = $reportQuery
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('viewer-new.reports.properties', [
            'metrics' => $this->buildMetrics($baseQuery, $property, $fieldAvailability),
            'properties' => $properties,
            'filters' => $filters,
            'statusOptions' => $this->buildDistinctOptions($fieldAvailability, 'card_status'),
            'governorateOptions' => $this->buildDistinctOptions($fieldAvailability, 'card_governorate'),
            'regionOptions' => $this->buildDistinctOptions($fieldAvailability, 'card_region_name'),
            'investmentTypeOptions' => $this->buildDistinctOptions($fieldAvailability, 'card_investment_type'),
            'purchaseMethodOptions' => $this->buildDistinctOptions($fieldAvailability, 'card_purchase_method'),
            'columns' => $fieldAvailability,
        ]);
    }

    private function resolveFieldAvailability(string $table): array
    {
        if (! Schema::hasTable($table)) {
            return [];
        }

        $fields = [
            'property_name',
            'card_country',
            'card_governorate',
            'card_region_name',
            'card_subdivision',
            'card_record_number',
            'card_property_number',
            'card_total_area',
            'card_area_unit',
            'card_status',
            'card_investment_type',
            'card_purchase_method',
            'card_sale_date',
            'total_property_value_usd',
            'owned_property_value_usd',
            'actual_price',
            'approximate_price',
            'final_balance',
            'card_property_details',
            'card_google_maps_url',
            'created_at',
            'updated_at',
        ];

        $availability = [];
        foreach ($fields as $field) {
            $availability[$field] = Schema::hasColumn($table, $field);
        }

        return $availability;
    }

    private function resolveFilters(Request $request): array
    {
        return [
            'q' => trim((string) $request->query('q', '')),
            'status' => trim((string) $request->query('status', '')),
            'governorate' => trim((string) $request->query('governorate', '')),
            'region' => trim((string) $request->query('region', '')),
            'investment_type' => trim((string) $request->query('investment_type', '')),
            'purchase_method' => trim((string) $request->query('purchase_method', '')),
            'min_area' => $request->query('min_area'),
            'max_area' => $request->query('max_area'),
            'min_value' => $request->query('min_value'),
            'max_value' => $request->query('max_value'),
            'has_owners' => $this->normalizeBooleanFilter($request->query('has_owners')),
            'has_signals' => $this->normalizeBooleanFilter($request->query('has_signals')),
            'has_files' => $this->normalizeBooleanFilter($request->query('has_files')),
            'date_from' => trim((string) $request->query('date_from', '')),
            'date_to' => trim((string) $request->query('date_to', '')),
        ];
    }

    private function applyFilters(Builder $query, array $filters, array $columns): void
    {
        $this->applySearchFilter($query, $filters['q'], $columns);
        $this->applyExactFilter($query, $filters['status'], 'card_status', $columns);
        $this->applyExactFilter($query, $filters['governorate'], 'card_governorate', $columns);
        $this->applyExactFilter($query, $filters['region'], 'card_region_name', $columns);
        $this->applyExactFilter($query, $filters['investment_type'], 'card_investment_type', $columns);
        $this->applyExactFilter($query, $filters['purchase_method'], 'card_purchase_method', $columns);

        $this->applyRangeFilter($query, $filters['min_area'], $filters['max_area'], 'card_total_area', $columns);

        $valueColumn = $this->resolveValueColumn($columns);
        if ($valueColumn !== null) {
            $this->applyRangeFilter($query, $filters['min_value'], $filters['max_value'], $valueColumn, $columns);
        }

        if (($columns['created_at'] ?? false) && $filters['date_from'] !== '') {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (($columns['created_at'] ?? false) && $filters['date_to'] !== '') {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        $this->applyHasRelationFilter($query, 'owners', $filters['has_owners']);
        $this->applyHasRelationFilter($query, 'signals', $filters['has_signals']);
        $this->applyHasRelationFilter($query, 'files', $filters['has_files']);
    }

    private function applySafeCounts(Builder $query, PropertyCard $property): void
    {
        $relations = [
            'owners', 'ownerships', 'operations', 'signals', 'files', 'installments', 'payments',
        ];

        $counts = [];
        foreach ($relations as $relation) {
            if (method_exists($property, $relation)) {
                $counts[] = $relation;
            }
        }

        if ($counts !== []) {
            $query->withCount($counts);
        }
    }

    private function applySearchFilter(Builder $query, string $search, array $columns): void
    {
        if ($search === '') {
            return;
        }

        $searchable = [
            'property_name',
            'card_record_number',
            'card_property_number',
            'card_governorate',
            'card_region_name',
            'card_subdivision',
            'card_property_details',
        ];

        $availableSearchable = array_values(array_filter($searchable, fn (string $column): bool => ($columns[$column] ?? false)));

        if ($availableSearchable === []) {
            return;
        }

        $query->where(function (Builder $builder) use ($availableSearchable, $search): void {
            foreach ($availableSearchable as $column) {
                $builder->orWhere($column, 'like', '%' . $search . '%');
            }
        });
    }

    private function applyExactFilter(Builder $query, string $value, string $column, array $columns): void
    {
        if ($value !== '' && ($columns[$column] ?? false)) {
            $query->where($column, $value);
        }
    }

    private function applyRangeFilter(Builder $query, mixed $min, mixed $max, string $column, array $columns): void
    {
        if (! ($columns[$column] ?? false)) {
            return;
        }

        if (is_numeric($min)) {
            $query->where($column, '>=', (float) $min);
        }

        if (is_numeric($max)) {
            $query->where($column, '<=', (float) $max);
        }
    }

    private function applyHasRelationFilter(Builder $query, string $relation, ?bool $value): void
    {
        if ($value === null || ! method_exists(new PropertyCard(), $relation)) {
            return;
        }

        if ($value === true) {
            $query->has($relation);

            return;
        }

        $query->doesntHave($relation);
    }

    private function buildDistinctOptions(array $columns, string $column): array
    {
        if (! ($columns[$column] ?? false)) {
            return [];
        }

        return PropertyCard::query()
            ->whereNotNull($column)
            ->select($column)
            ->distinct()
            ->orderBy($column)
            ->pluck($column)
            ->filter(fn ($value): bool => filled((string) $value))
            ->values()
            ->all();
    }

    private function buildMetrics(Builder $query, PropertyCard $property, array $columns): array
    {
        $valueColumn = $this->resolveValueColumn($columns);

        return [
            'total_properties' => number_format((int) (clone $query)->count()),
            'total_area' => ($columns['card_total_area'] ?? false)
                ? number_format((float) ((clone $query)->sum('card_total_area') ?? 0), 2) . ' م²'
                : 'غير متوفر',
            'total_estimated_value' => $valueColumn
                ? number_format((float) ((clone $query)->sum($valueColumn) ?? 0), 2) . ' $'
                : 'غير متوفر',
            'linked_owners_count' => method_exists($property, 'owners')
                ? number_format((int) (clone $query)->has('owners')->count())
                : 'غير متوفر',
            'properties_with_signals' => method_exists($property, 'signals')
                ? number_format((int) (clone $query)->has('signals')->count())
                : 'غير متوفر',
            'properties_with_files' => method_exists($property, 'files')
                ? number_format((int) (clone $query)->has('files')->count())
                : 'غير متوفر',
            'last_update' => ($columns['updated_at'] ?? false)
                ? optional((clone $query)->latest('updated_at')->value('updated_at'))?->format('Y-m-d H:i') ?? '—'
                : 'غير متوفر',
        ];
    }

    private function resolveValueColumn(array $columns): ?string
    {
        foreach (['total_property_value_usd', 'owned_property_value_usd', 'approximate_price', 'actual_price'] as $column) {
            if (($columns[$column] ?? false) === true) {
                return $column;
            }
        }

        return null;
    }

    private function normalizeBooleanFilter(mixed $value): ?bool
    {
        if ($value === null || $value === '') {
            return null;
        }

        $normalized = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        return $normalized;
    }
}
