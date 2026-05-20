<?php

namespace App\Http\Controllers\ViewerNew\Reports;

use App\Http\Controllers\Controller;
use App\Models\PropertyCard;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\PropertyOperation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PropertiesReportController extends Controller
{
    private const TOTAL_SHARES_REFERENCE = 2400;

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

        $propertyIds = $properties->getCollection()->pluck('id')->filter()->values()->all();
        $operationOwnersByProperty = $this->buildOperationOwnersForProperties($propertyIds);
        $operationsByProperty = $this->buildOperationsForProperties($propertyIds);
        $signalsByProperty = $this->buildSignalsForProperties($propertyIds);

        return view('viewer-new.reports.properties', [
            'metrics' => $this->buildMetrics($baseQuery, $property, $fieldAvailability),
            'properties' => $properties,
            'filters' => $filters,
            'statusOptions' => $this->buildDistinctOptions($fieldAvailability, 'card_status'),
            'governorateOptions' => $this->buildDistinctOptions($fieldAvailability, 'card_governorate'),
            'regionOptions' => $this->buildDistinctOptions($fieldAvailability, 'card_region_name'),
            'investmentTypeOptions' => $this->buildDistinctOptions($fieldAvailability, 'card_investment_type'),
            'purchaseMethodOptions' => $this->buildDistinctOptions($fieldAvailability, 'card_purchase_method'),
            'countryOptions' => $this->buildDistinctOptions($fieldAvailability, 'property_country'),
            'columns' => $fieldAvailability,
            'operationOwnersByProperty' => $operationOwnersByProperty,
            'operationsByProperty' => $operationsByProperty,
            'signalsByProperty' => $signalsByProperty,
        ]);
    }


    private function buildOperationsForProperties(array $propertyIds): array
    {
        if ($propertyIds === [] || ! $this->canLoadOperations()) {
            return [];
        }

        $operations = PropertyOperation::query()
            ->with(['oldOwners', 'newOwners', 'propertyCard'])
            ->whereIn('property_card_id', $propertyIds)
            ->orderByDesc('id')
            ->get();

        $optionalOperationColumns = $this->resolveTableColumns('property_operations', [
            'operation_type',
            'operation_method',
            'case_number',
            'decision_number',
            'authority',
            'judgment_date',
            'judgment_notes',
            'contract_number',
            'contract_date',
            'contract_notes',
        ]);

        $grouped = [];

        foreach ($operations as $operation) {
            $propertyCardId = (int) ($operation->property_card_id ?? 0);
            if ($propertyCardId <= 0) {
                continue;
            }

            $transactionAmount = is_numeric($operation->transaction_amount) ? (float) $operation->transaction_amount : null;
            $transactionUnit = is_string($operation->transaction_unit) ? strtolower(trim($operation->transaction_unit)) : null;
            $cardArea = is_numeric(optional($operation->propertyCard)->card_total_area) ? (float) optional($operation->propertyCard)->card_total_area : null;

            $sharesEquivalent = match ($transactionUnit) {
                'shares' => $transactionAmount,
                'percentage' => $transactionAmount !== null ? (self::TOTAL_SHARES_REFERENCE * $transactionAmount / 100) : null,
                'square_meter', 'meters' => ($transactionAmount !== null && $cardArea && $cardArea > 0)
                    ? (($transactionAmount / $cardArea) * self::TOTAL_SHARES_REFERENCE)
                    : null,
                default => null,
            };

            $grouped[$propertyCardId][] = [
                'id' => (int) $operation->id,
                'operation_type' => $optionalOperationColumns['operation_type'] ? ($operation->operation_type ?? null) : null,
                'transaction_amount' => $transactionAmount,
                'transaction_unit' => $transactionUnit,
                'shares_equivalent' => $sharesEquivalent !== null ? round($sharesEquivalent, 2) : null,
                'operation_method' => $optionalOperationColumns['operation_method'] ? ($operation->operation_method ?? null) : null,
                'old_owners' => $operation->oldOwners->map(fn ($owner) => $this->resolveOwnerDisplayName($owner))->filter()->values()->all(),
                'new_owners' => $operation->newOwners->map(fn ($owner) => $this->resolveOwnerDisplayName($owner))->filter()->values()->all(),
                'case_number' => $optionalOperationColumns['case_number'] ? ($operation->case_number ?? null) : null,
                'decision_number' => $optionalOperationColumns['decision_number'] ? ($operation->decision_number ?? null) : null,
                'authority' => $optionalOperationColumns['authority'] ? ($operation->authority ?? null) : null,
                'judgment_date' => $optionalOperationColumns['judgment_date'] ? ($operation->judgment_date ?? null) : null,
                'contract_number' => $optionalOperationColumns['contract_number'] ? ($operation->contract_number ?? null) : null,
                'contract_date' => $optionalOperationColumns['contract_date'] ? ($operation->contract_date ?? null) : null,
                'notes' => $optionalOperationColumns['judgment_notes']
                    ? ($operation->judgment_notes ?? null)
                    : ($optionalOperationColumns['contract_notes'] ? ($operation->contract_notes ?? null) : null),
            ];
        }

        return $grouped;
    }

    private function canLoadOperations(): bool
    {
        $requiredSchema = [
            'property_operations' => ['id', 'property_card_id', 'transaction_amount', 'transaction_unit'],
            'property_operation_old_owner' => ['property_operation_id', 'owner_id'],
            'property_operation_new_owner' => ['property_operation_id', 'owner_id'],
            'owners' => ['id'],
            'property_cards' => ['id', 'card_total_area'],
        ];

        foreach ($requiredSchema as $table => $columns) {
            if (! Schema::hasTable($table)) {
                return false;
            }

            foreach ($columns as $column) {
                if (! Schema::hasColumn($table, $column)) {
                    return false;
                }
            }
        }

        return true;
    }

    private function resolveTableColumns(string $table, array $columns): array
    {
        if (! Schema::hasTable($table)) {
            return array_fill_keys($columns, false);
        }

        $availability = [];
        foreach ($columns as $column) {
            $availability[$column] = Schema::hasColumn($table, $column);
        }

        return $availability;
    }

    private function resolveOwnerDisplayName(object $owner): string
    {
        $name = trim((string) ($owner->display_name ?? $owner->company_name ?? $owner->full_name ?? ''));

        return $name !== '' ? $name : 'مالك غير محدد';
    }
    private function buildOperationOwnersForProperties(array $propertyIds): array
    {
        if ($propertyIds === [] || ! $this->canCalculateOperationOwners()) {
            return [];
        }

        $totalShares = self::TOTAL_SHARES_REFERENCE;
        $sharesExpression = "CASE
            WHEN po.transaction_unit = 'shares' THEN po.transaction_amount
            WHEN po.transaction_unit = 'percentage' THEN ({$totalShares} * po.transaction_amount / 100)
            WHEN po.transaction_unit = 'square_meter' THEN CASE
                WHEN pc.card_total_area IS NULL OR pc.card_total_area = 0 THEN 0
                ELSE (po.transaction_amount / pc.card_total_area) * {$totalShares}
            END
            ELSE 0
        END";
        $ownerNameExpression = "CASE
            WHEN o.owner_type = 'company' THEN COALESCE(o.company_name, o.full_name)
            ELSE o.full_name
        END";

        $newOwners = DB::table('property_operations as po')
            ->join('property_cards as pc', 'pc.id', '=', 'po.property_card_id')
            ->join('property_operation_new_owner as pno', 'pno.property_operation_id', '=', 'po.id')
            ->join('owners as o', 'o.id', '=', 'pno.owner_id')
            ->whereIn('po.property_card_id', $propertyIds)
            ->whereNull('pc.deleted_at')
            ->whereNull('o.deleted_at')
            ->selectRaw("po.property_card_id, o.id as owner_id, {$ownerNameExpression} as owner_name, {$sharesExpression} as shares_delta");

        $oldOwners = DB::table('property_operations as po')
            ->join('property_cards as pc', 'pc.id', '=', 'po.property_card_id')
            ->join('property_operation_old_owner as poo', 'poo.property_operation_id', '=', 'po.id')
            ->join('owners as o', 'o.id', '=', 'poo.owner_id')
            ->whereIn('po.property_card_id', $propertyIds)
            ->whereNull('pc.deleted_at')
            ->whereNull('o.deleted_at')
            ->selectRaw("po.property_card_id, o.id as owner_id, {$ownerNameExpression} as owner_name, (-1 * ({$sharesExpression})) as shares_delta");

        $rows = DB::query()
            ->fromSub($newOwners->unionAll($oldOwners), 'x')
            ->selectRaw("x.property_card_id, x.owner_id, x.owner_name, ROUND(SUM(x.shares_delta), 2) as owner_shares, ROUND((SUM(x.shares_delta) / {$totalShares}) * 100, 2) as ownership_percentage")
            ->groupBy('x.property_card_id', 'x.owner_id', 'x.owner_name')
            ->havingRaw('ROUND(SUM(x.shares_delta), 2) > 0')
            ->orderByDesc('owner_shares')
            ->get();

        $grouped = [];
        foreach ($rows as $row) {
            $propertyCardId = (int) $row->property_card_id;

            $grouped[$propertyCardId][] = [
                'owner_id' => (int) $row->owner_id,
                'owner_name' => (string) ($row->owner_name ?? ''),
                'owner_shares' => round((float) $row->owner_shares, 2),
                'ownership_percentage' => round((float) $row->ownership_percentage, 2),
            ];
        }

        return $grouped;
    }

    private function canCalculateOperationOwners(): bool
    {
        $requiredSchema = [
            'property_operations' => ['property_card_id', 'transaction_unit', 'transaction_amount'],
            'property_cards' => ['id', 'card_total_area'],
            'property_operation_new_owner' => ['property_operation_id', 'owner_id'],
            'property_operation_old_owner' => ['property_operation_id', 'owner_id'],
            'owners' => ['id', 'owner_type', 'full_name', 'company_name'],
        ];

        foreach ($requiredSchema as $table => $columns) {
            if (! Schema::hasTable($table)) {
                return false;
            }

            foreach ($columns as $column) {
                if (! Schema::hasColumn($table, $column)) {
                    return false;
                }
            }
        }

        return true;
    }


    private function buildSignalsForProperties(array $propertyIds): array
    {
        if ($propertyIds === []) {
            return [];
        }

        $requiredTables = ['property_cards', 'signals'];
        foreach ($requiredTables as $table) {
            if (! Schema::hasTable($table)) {
                return [];
            }
        }

        if (! Schema::hasColumn('property_cards', 'id')
            || ! Schema::hasColumn('signals', 'property_card_id')
            || ! Schema::hasColumn('signals', 'id')) {
            return [];
        }

        $propertyCardColumns = $this->resolveTableColumns('property_cards', [
            'deleted_at',
            'card_record_number',
            'card_governorate',
            'card_region_name',
        ]);

        $signalColumns = $this->resolveTableColumns('signals', [
            'deleted_at',
            'signal_id',
            'signal_date',
            'type',
            'signal_owner',
            'signal_owners',
            'signal_source',
            'signal_sources',
            'signal_source_number',
            'signal_source_date',
            'signal_victim',
            'signal_victims',
            'signal_notes',
            'created_at',
            'updated_at',
        ]);

        $query = DB::table('property_cards as pc')
            ->leftJoin('signals as s', function ($join) use ($signalColumns): void {
                $join->on('s.property_card_id', '=', 'pc.id');
                if ($signalColumns['deleted_at']) {
                    $join->whereNull('s.deleted_at');
                }
            })
            ->whereIn('pc.id', $propertyIds);

        if ($propertyCardColumns['deleted_at']) {
            $query->whereNull('pc.deleted_at');
        }

        $selectColumns = ['pc.id as property_card_id', 's.id as signal_db_id'];
        $optionalSelectMap = [
            'card_record_number' => 'pc.card_record_number as record_number',
            'card_governorate' => 'pc.card_governorate as governorate',
            'card_region_name' => 'pc.card_region_name as region_name',
            'signal_id' => 's.signal_id as signal_number',
            'signal_date' => 's.signal_date',
            'type' => 's.type as signal_type',
            'signal_owner' => 's.signal_owner',
            'signal_owners' => 's.signal_owners',
            'signal_source' => 's.signal_source',
            'signal_sources' => 's.signal_sources',
            'signal_source_number' => 's.signal_source_number',
            'signal_source_date' => 's.signal_source_date',
            'signal_victim' => 's.signal_victim',
            'signal_victims' => 's.signal_victims',
            'signal_notes' => 's.signal_notes',
            'created_at' => 's.created_at',
            'updated_at' => 's.updated_at',
        ];

        foreach ($optionalSelectMap as $column => $selectExpression) {
            $isPcColumn = str_starts_with($column, 'card_');
            $isAvailable = $isPcColumn
                ? ($propertyCardColumns[$column] ?? false)
                : ($signalColumns[$column] ?? false);

            if ($isAvailable) {
                $selectColumns[] = $selectExpression;
            }
        }

        $rows = $query
            ->orderBy('pc.id')
            ->orderByRaw(($signalColumns['signal_date'] ? 's.signal_date DESC, ' : '') . 's.id DESC')
            ->get($selectColumns);

        $grouped = [];
        foreach ($rows as $row) {
            $propertyCardId = (int) ($row->property_card_id ?? 0);
            if ($propertyCardId <= 0 || ! isset($row->signal_db_id) || $row->signal_db_id === null) {
                continue;
            }

            $signalOwner = $this->normalizeDisplayValue($row->signal_owner ?? null);
            $signalSource = $this->normalizeDisplayValue($row->signal_source ?? null);
            $signalVictim = $this->normalizeDisplayValue($row->signal_victim ?? null);

            $grouped[$propertyCardId][] = [
                'signal_db_id' => (int) $row->signal_db_id,
                'signal_number' => $this->normalizeDisplayValue($row->signal_number ?? null),
                'signal_date' => $this->normalizeDisplayValue($row->signal_date ?? null),
                'signal_type' => $this->normalizeDisplayValue($row->signal_type ?? null),
                'signal_owner' => $signalOwner,
                'signal_owners_label' => $this->buildJsonNamesLabel($row->signal_owners ?? null) ?? $signalOwner,
                'signal_source' => $signalSource,
                'signal_sources_label' => $this->buildJsonNamesLabel($row->signal_sources ?? null) ?? $signalSource,
                'signal_source_number' => $this->normalizeDisplayValue($row->signal_source_number ?? null),
                'signal_source_date' => $this->normalizeDisplayValue($row->signal_source_date ?? null),
                'signal_victim' => $signalVictim,
                'signal_victims_label' => $this->buildJsonNamesLabel($row->signal_victims ?? null) ?? $signalVictim,
                'signal_notes' => $this->normalizeDisplayValue($row->signal_notes ?? null),
                'created_at' => $this->normalizeDisplayValue($row->created_at ?? null),
                'updated_at' => $this->normalizeDisplayValue($row->updated_at ?? null),
            ];
        }

        return $grouped;
    }

    private function buildJsonNamesLabel(mixed $value): ?string
    {
        if (! is_string($value) || trim($value) === '') {
            return null;
        }

        $decoded = json_decode($value, true);
        if (! is_array($decoded)) {
            return null;
        }

        $names = [];
        foreach ($decoded as $item) {
            if (is_array($item)) {
                $candidate = trim((string) ($item['name'] ?? $item['full_name'] ?? $item['label'] ?? ''));

                if ($candidate === '' && isset($item['owner_id']) && is_numeric($item['owner_id'])) {
                    $candidate = 'مالك #' . (string) ((int) $item['owner_id']);
                }
            } else {
                $candidate = trim((string) $item);
            }

            if ($candidate !== '') {
                $names[] = $candidate;
            }
        }

        if ($names === []) {
            return null;
        }

        return implode('، ', array_values(array_unique($names)));
    }

    private function normalizeDisplayValue(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = trim((string) $value);

        return $normalized !== '' ? $normalized : null;
    }

    private function resolveFieldAvailability(string $table): array
    {
        if (! Schema::hasTable($table)) {
            return [];
        }

        $fields = [
            'property_name',
            'property_country',
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
            'actual_price_usd',
            'estimated_price_usd',
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
            'country' => trim((string) $request->query('country', '')),
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
        $this->applyExactFilter($query, $filters['country'], 'property_country', $columns);

        $this->applyRangeFilter($query, $filters['min_area'], $filters['max_area'], 'card_total_area', $columns);

        $valueColumn = $this->resolveValueColumn($columns);
        if ($valueColumn !== null) {
            $this->applyRangeFilter($query, $filters['min_value'], $filters['max_value'], $valueColumn, $columns);
        }

        $dateColumn = $this->resolveDateFilterColumn($columns);
        $dateFrom = $this->normalizeDateFilterValue($filters['date_from']);
        $dateTo = $this->normalizeDateFilterValue($filters['date_to']);

        if ($dateColumn !== null && $dateFrom !== null) {
            $query->whereDate($dateColumn, '>=', $dateFrom);
        }

        if ($dateColumn !== null && $dateTo !== null) {
            $query->whereDate($dateColumn, '<=', $dateTo);
        }

        $property = new PropertyCard();
        $this->applyHasRelationFilter($query, $property, 'owners', $filters['has_owners']);
        $this->applyHasRelationFilter($query, $property, 'signals', $filters['has_signals']);
        $this->applyHasRelationFilter($query, $property, 'files', $filters['has_files']);
    }

    private function applySafeCounts(Builder $query, PropertyCard $property): void
    {
        $relations = [
            'owners', 'ownerships', 'operations', 'signals', 'files', 'installments', 'payments',
        ];

        $counts = [];
        foreach ($relations as $relation) {
            if ($this->relationIsAvailable($property, $relation)) {
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

    private function applyHasRelationFilter(Builder $query, PropertyCard $property, string $relation, ?bool $value): void
    {
        if ($value === null || ! $this->relationIsAvailable($property, $relation)) {
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
            'linked_owners_count' => $this->relationIsAvailable($property, 'owners')
                ? number_format((int) (clone $query)->has('owners')->count())
                : 'غير متوفر',
            'properties_with_signals' => $this->relationIsAvailable($property, 'signals')
                ? number_format((int) (clone $query)->has('signals')->count())
                : 'غير متوفر',
            'properties_with_files' => $this->relationIsAvailable($property, 'files')
                ? number_format((int) (clone $query)->has('files')->count())
                : 'غير متوفر',
            'last_update' => ($columns['updated_at'] ?? false)
                ? optional((clone $query)->latest('updated_at')->value('updated_at'))?->format('Y-m-d H:i') ?? '—'
                : 'غير متوفر',
        ];
    }



    private function relationIsAvailable(PropertyCard $property, string $relation): bool
    {
        $config = $this->relationConfig();

        if (! isset($config[$relation])) {
            return false;
        }

        $method = $config[$relation]['method'];
        if (! method_exists($property, $method)) {
            return false;
        }

        foreach ($config[$relation]['required_tables'] as $table) {
            if (! Schema::hasTable($table)) {
                return false;
            }
        }

        return true;
    }

    private function relationConfig(): array
    {
        return [
            'owners' => [
                'method' => 'owners',
                'required_tables' => ['owners', 'owner_property_card'],
            ],
            'ownerships' => [
                'method' => 'ownerships',
                'required_tables' => ['owner_property_card'],
            ],
            'operations' => [
                'method' => 'operations',
                'required_tables' => ['property_operations'],
            ],
            'signals' => [
                'method' => 'signals',
                'required_tables' => ['signals'],
            ],
            'files' => [
                'method' => 'files',
                'required_tables' => ['property_card_files'],
            ],
            'installments' => [
                'method' => 'installments',
                'required_tables' => ['property_installments'],
            ],
            'payments' => [
                'method' => 'payments',
                'required_tables' => ['property_owner_payments'],
            ],
        ];
    }

    private function resolveDateFilterColumn(array $columns): ?string
    {
        if (($columns['card_sale_date'] ?? false) === true) {
            return 'card_sale_date';
        }

        if (($columns['created_at'] ?? false) === true) {
            return 'created_at';
        }

        return null;
    }

    private function normalizeDateFilterValue(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $date = trim($value);
        if ($date === '' || ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return null;
        }

        $parsed = date_create_from_format('Y-m-d', $date);

        if ($parsed === false || $parsed->format('Y-m-d') !== $date) {
            return null;
        }

        return $date;
    }

    private function resolveValueColumn(array $columns): ?string
    {
        foreach (['total_property_value_usd', 'owned_property_value_usd', 'estimated_price_usd', 'actual_price_usd'] as $column) {
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
