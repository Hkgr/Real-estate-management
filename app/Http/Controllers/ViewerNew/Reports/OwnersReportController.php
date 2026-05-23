<?php

namespace App\Http\Controllers\ViewerNew\Reports;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\OwnerPropertyCard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class OwnersReportController extends Controller
{
    public function __invoke(Request $request): View
    {
        $ownersTable = (new Owner())->getTable();
        $pivotTable = (new OwnerPropertyCard())->getTable();

        $hasOwnersTable = Schema::hasTable($ownersTable);
        $hasPivotTable = Schema::hasTable($pivotTable);

        $ownerColumns = $hasOwnersTable ? Schema::getColumnListing($ownersTable) : [];
        $pivotColumns = $hasPivotTable ? Schema::getColumnListing($pivotTable) : [];

        $ownerHas = fn (string $column): bool => in_array($column, $ownerColumns, true);
        $pivotHas = fn (string $column): bool => in_array($column, $pivotColumns, true);

        $searchableColumns = array_values(array_filter([
            $ownerHas('full_name') ? 'full_name' : null,
            $ownerHas('company_name') ? 'company_name' : null,
            $ownerHas('phone') ? 'phone' : null,
            $ownerHas('email') ? 'email' : null,
            $ownerHas('commercial_register_number') ? 'commercial_register_number' : null,
            $ownerHas('national_id') ? 'national_id' : null,
        ]));

        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'current' => (string) $request->query('current', ''),
            'owner_type' => trim((string) $request->query('owner_type', '')),
            'registry' => trim((string) $request->query('registry', '')),
            'birth_date_from' => $this->normalizeDateFilter($request->query('birth_date_from')),
            'birth_date_to' => $this->normalizeDateFilter($request->query('birth_date_to')),
            'has_properties' => (string) $request->query('has_properties', ''),
        ];

        $hasCurrentColumn = $pivotHas('is_current');

        $ownersQuery = Owner::query();

        if ($filters['q'] !== '' && $searchableColumns !== []) {
            $term = $filters['q'];
            $ownersQuery->where(function ($query) use ($searchableColumns, $term, $ownersTable): void {
                foreach ($searchableColumns as $index => $column) {
                    $query->{$index === 0 ? 'where' : 'orWhere'}("{$ownersTable}.{$column}", 'like', "%{$term}%");
                }
            });
        }

        if ($hasPivotTable && $hasCurrentColumn && in_array($filters['current'], ['1', '0'], true)) {
            $ownersQuery->whereHas('propertyCards', function ($query) use ($filters): void {
                $query->where('owner_property_card.is_current', $filters['current'] === '1');
            });
        }

        if ($ownerHas('owner_type') && $filters['owner_type'] !== '') {
            $ownerTypeMap = [
                'individual' => ['individual', 'person', 'فرد'],
                'person' => ['individual', 'person', 'فرد'],
                'فرد' => ['individual', 'person', 'فرد'],
                'company' => ['company', 'شركة'],
                'شركة' => ['company', 'شركة'],
            ];

            $ownerTypeKey = Str::lower($filters['owner_type']);
            $ownersQuery->whereIn("{$ownersTable}.owner_type", $ownerTypeMap[$ownerTypeKey] ?? [$filters['owner_type']]);
        }

        if ($filters['registry'] !== '') {
            if ($ownerHas('real_estate_registry_number')) {
                $ownersQuery->where("{$ownersTable}.real_estate_registry_number", 'like', "%{$filters['registry']}%");
            } elseif ($ownerHas('real_estate_record_number')) {
                $ownersQuery->where("{$ownersTable}.real_estate_record_number", 'like', "%{$filters['registry']}%");
            }
        }

        if ($ownerHas('birth_date')) {
            if ($filters['birth_date_from'] !== '') {
                $ownersQuery->whereDate("{$ownersTable}.birth_date", '>=', $filters['birth_date_from']);
            }

            if ($filters['birth_date_to'] !== '') {
                $ownersQuery->whereDate("{$ownersTable}.birth_date", '<=', $filters['birth_date_to']);
            }
        }

        $operationOwnedOwnerIds = [];
        if (in_array($filters['has_properties'], ['1', '0'], true)) {
            $operationOwnedOwnerIds = $this->operationOwnedOwnerIds();
            if ($operationOwnedOwnerIds !== null) {
                if ($filters['has_properties'] === '1') {
                    if ($operationOwnedOwnerIds === []) {
                        $ownersQuery->whereRaw('1 = 0');
                    } else {
                        $ownersQuery->whereIn("{$ownersTable}.id", $operationOwnedOwnerIds);
                    }
                } else {
                    if ($operationOwnedOwnerIds !== []) {
                        $ownersQuery->whereNotIn("{$ownersTable}.id", $operationOwnedOwnerIds);
                    }
                }
            }
        }

        if ($hasPivotTable) {
            $ownersQuery->withCount(['propertyCards as properties_linked_count']);

            if ($hasCurrentColumn) {
                $ownersQuery->withCount([
                    'propertyCards as current_ownerships_count' => fn ($query) => $query->where('owner_property_card.is_current', true),
                ]);
            }

            if ($pivotHas('ownership_percentage')) {
                $ownersQuery->withMax('propertyCards as ownership_percentage_max', 'owner_property_card.ownership_percentage');
            }
        }

        $ownersQuery->latest($ownerHas('updated_at') ? "{$ownersTable}.updated_at" : "{$ownersTable}.id");

        $owners = $ownersQuery->paginate(15)->withQueryString();
        $relatedPropertiesByOwner = $this->buildRelatedPropertiesByOwner(
            $owners->getCollection()
                ->pluck('id')
                ->filter()
                ->map(static fn (mixed $id): int => (int) $id)
                ->values()
                ->all()
        );

        $owners->setCollection($owners->getCollection()->map(function (Owner $owner) use ($ownerHas, $pivotHas, $hasCurrentColumn, $relatedPropertiesByOwner): array {
            $formatDate = static function (mixed $value, string $format): string {
                if (blank($value)) {
                    return '—';
                }

                if ($value instanceof \DateTimeInterface) {
                    return $value->format($format);
                }

                $timestamp = strtotime((string) $value);

                return $timestamp !== false ? date($format, $timestamp) : '—';
            };

            $ownershipPercentage = $pivotHas('ownership_percentage') && $owner->ownership_percentage_max !== null
                ? rtrim(rtrim(number_format((float) $owner->ownership_percentage_max, 2, '.', ''), '0'), '.') . '%'
                : '—';

            $ownerTypeRaw = $ownerHas('owner_type') ? trim((string) ($owner->owner_type ?? '')) : '';
            $ownerType = match ($ownerTypeRaw) {
                'individual', 'person', 'فرد' => 'فرد',
                'company', 'شركة' => 'شركة',
                default => $ownerTypeRaw !== '' ? $ownerTypeRaw : '—',
            };

            $registryNumber = '—';
            if ($ownerHas('real_estate_registry_number')) {
                $registryNumber = trim((string) ($owner->real_estate_registry_number ?? '')) ?: '—';
            } elseif ($ownerHas('real_estate_record_number')) {
                $registryNumber = trim((string) ($owner->real_estate_record_number ?? '')) ?: '—';
            }

            $ownerRelatedProperties = $relatedPropertiesByOwner[(int) $owner->id] ?? [];

            return [
                'id' => $ownerHas('id') ? ($owner->getAttribute('id') ?? '—') : '—',
                'name' => $owner->display_name ?: '—',
                'owner_type' => $ownerType,
                'father_name' => $ownerHas('father_name') ? (trim((string) ($owner->father_name ?? '')) ?: '—') : '—',
                'phone' => $ownerHas('phone') ? ($owner->phone ?: '—') : '—',
                'email' => $ownerHas('email') ? (trim((string) ($owner->email ?? '')) ?: '—') : '—',
                'national_id' => $ownerHas('national_id') ? (trim((string) ($owner->national_id ?? '')) ?: '—') : '—',
                'commercial_register_number' => $ownerHas('commercial_register_number') ? (trim((string) ($owner->commercial_register_number ?? '')) ?: '—') : '—',
                'real_estate_registry_number' => $registryNumber,
                'birth_date' => $ownerHas('birth_date') ? $formatDate($owner->getAttribute('birth_date'), 'Y-m-d') : '—',
                'properties_linked_count' => count($ownerRelatedProperties),
                'ownership_percentage' => $ownershipPercentage,
                'current_ownerships_count' => count($ownerRelatedProperties),
                'created_at' => $ownerHas('created_at') ? $formatDate($owner->getAttribute('created_at'), 'Y-m-d H:i') : '—',
                'last_update' => $ownerHas('updated_at') ? $formatDate($owner->getAttribute('updated_at'), 'Y-m-d H:i') : '—',
                'status_or_notes' => $ownerHas('notes')
                    ? ($owner->notes ?: '—')
                    : ($ownerHas('is_active') ? ((bool) $owner->is_active ? 'نشط' : 'غير نشط') : '—'),
                'related_properties' => $ownerRelatedProperties,
            ];
        }));

        $metrics = [
            'total_owners' => $hasOwnersTable ? Owner::query()->count() : 'غير متوفر',
            'total_ownership_links' => $hasPivotTable ? OwnerPropertyCard::query()->count() : 'غير متوفر',
            'current_ownerships' => ($hasPivotTable && $hasCurrentColumn)
                ? OwnerPropertyCard::query()->where('is_current', true)->count()
                : 'غير متوفر',
            'total_properties_linked' => $hasPivotTable && $pivotHas('property_card_id')
                ? OwnerPropertyCard::query()->distinct('property_card_id')->count('property_card_id')
                : 'غير متوفر',
            'last_update' => $ownerHas('updated_at')
                ? (Owner::query()->latest('updated_at')->value('updated_at')?->format('Y-m-d H:i') ?? '—')
                : 'غير متوفر',
        ];

        return view('viewer-new.reports.owners', [
            'metrics' => $metrics,
            'owners' => $owners,
            'filters' => $filters,
            'fieldAvailability' => [
                'is_current' => $hasCurrentColumn,
                'filters_q' => $searchableColumns !== [],
            ],
        ]);
    }

    private function normalizeDateFilter(mixed $value): string
    {
        if (! is_string($value)) {
            return '';
        }

        $value = trim($value);

        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return '';
        }

        $date = \DateTime::createFromFormat('Y-m-d', $value);

        return $date && $date->format('Y-m-d') === $value ? $value : '';
    }

    private function operationOwnedOwnerIds(): ?array
    {
        $requiredTables = [
            'property_operations',
            'property_operation_new_owner',
            'property_operation_old_owner',
            'owners',
            'property_cards',
        ];

        foreach ($requiredTables as $table) {
            if (! Schema::hasTable($table)) {
                return null;
            }
        }

        $requiredColumns = [
            'property_operations' => ['id', 'property_card_id', 'transaction_unit', 'transaction_amount'],
            'property_operation_new_owner' => ['property_operation_id', 'owner_id'],
            'property_operation_old_owner' => ['property_operation_id', 'owner_id'],
            'owners' => ['id'],
            'property_cards' => ['id', 'card_total_area'],
        ];

        foreach ($requiredColumns as $table => $columns) {
            foreach ($columns as $column) {
                if (! Schema::hasColumn($table, $column)) {
                    return null;
                }
            }
        }

        $ownersHasDeletedAt = Schema::hasColumn('owners', 'deleted_at');
        $propertyCardsHasDeletedAt = Schema::hasColumn('property_cards', 'deleted_at');
        $totalSharesReference = 2400;
        $sharesExpression = "CASE WHEN po.transaction_unit = 'shares' THEN po.transaction_amount WHEN po.transaction_unit = 'percentage' THEN ({$totalSharesReference} * po.transaction_amount / 100) WHEN po.transaction_unit = 'square_meter' THEN (po.transaction_amount / NULLIF(pc.card_total_area, 0)) * {$totalSharesReference} ELSE 0 END";

        $newOwnersQuery = DB::table('property_operation_new_owner as pono')
            ->join('property_operations as po', 'po.id', '=', 'pono.property_operation_id')
            ->join('property_cards as pc', 'pc.id', '=', 'po.property_card_id')
            ->join('owners as o', 'o.id', '=', 'pono.owner_id')
            ->selectRaw("po.property_card_id, pono.owner_id, {$sharesExpression} as shares_delta");

        if ($propertyCardsHasDeletedAt) {
            $newOwnersQuery->whereNull('pc.deleted_at');
        }
        if ($ownersHasDeletedAt) {
            $newOwnersQuery->whereNull('o.deleted_at');
        }

        $oldOwnersQuery = DB::table('property_operation_old_owner as pooo')
            ->join('property_operations as po', 'po.id', '=', 'pooo.property_operation_id')
            ->join('property_cards as pc', 'pc.id', '=', 'po.property_card_id')
            ->join('owners as o', 'o.id', '=', 'pooo.owner_id')
            ->selectRaw("po.property_card_id, pooo.owner_id, (-1 * ({$sharesExpression})) as shares_delta");

        if ($propertyCardsHasDeletedAt) {
            $oldOwnersQuery->whereNull('pc.deleted_at');
        }
        if ($ownersHasDeletedAt) {
            $oldOwnersQuery->whereNull('o.deleted_at');
        }

        $unionQuery = $newOwnersQuery->unionAll($oldOwnersQuery);

        return DB::query()
            ->fromSub($unionQuery, 'x')
            ->selectRaw('x.owner_id')
            ->groupBy('x.owner_id', 'x.property_card_id')
            ->havingRaw('ROUND(SUM(x.shares_delta), 2) > 0')
            ->pluck('x.owner_id')
            ->map(static fn (mixed $id): int => (int) $id)
            ->filter(static fn (int $id): bool => $id > 0)
            ->unique()
            ->values()
            ->all();
    }


    private function buildRelatedPropertiesByOwner(array $ownerIds): array
    {
        $ownerIds = array_values(array_unique(array_filter(array_map('intval', $ownerIds), static fn (int $id): bool => $id > 0)));
        if ($ownerIds === []) {
            return [];
        }

        $requiredTables = [
            'property_operations',
            'property_operation_new_owner',
            'property_operation_old_owner',
            'owners',
            'property_cards',
        ];

        foreach ($requiredTables as $table) {
            if (! Schema::hasTable($table)) {
                return [];
            }
        }

        $requiredColumns = [
            'property_operations' => ['id', 'property_card_id', 'transaction_unit', 'transaction_amount'],
            'property_operation_new_owner' => ['property_operation_id', 'owner_id'],
            'property_operation_old_owner' => ['property_operation_id', 'owner_id'],
            'owners' => ['id'],
            'property_cards' => ['id', 'card_record_number', 'card_governorate', 'card_region_name', 'card_total_area'],
        ];

        foreach ($requiredColumns as $table => $columns) {
            foreach ($columns as $column) {
                if (! Schema::hasColumn($table, $column)) {
                    return [];
                }
            }
        }

        $ownersHasDeletedAt = Schema::hasColumn('owners', 'deleted_at');
        $ownersHasOwnerType = Schema::hasColumn('owners', 'owner_type');
        $ownersHasCompanyName = Schema::hasColumn('owners', 'company_name');
        $ownersHasFullName = Schema::hasColumn('owners', 'full_name');
        $propertyCardsHasDeletedAt = Schema::hasColumn('property_cards', 'deleted_at');

        $totalSharesReference = 2400;

        $ownerNameExpression = $ownersHasOwnerType && $ownersHasCompanyName && $ownersHasFullName
            ? "CASE WHEN o.owner_type IN ('company', 'شركة') THEN COALESCE(NULLIF(TRIM(o.company_name), ''), NULLIF(TRIM(o.full_name), ''), '—') ELSE COALESCE(NULLIF(TRIM(o.full_name), ''), NULLIF(TRIM(o.company_name), ''), '—') END"
            : ($ownersHasCompanyName && $ownersHasFullName
                ? "COALESCE(NULLIF(TRIM(o.full_name), ''), NULLIF(TRIM(o.company_name), ''), '—')"
                : ($ownersHasFullName
                    ? "COALESCE(NULLIF(TRIM(o.full_name), ''), '—')"
                    : ($ownersHasCompanyName
                        ? "COALESCE(NULLIF(TRIM(o.company_name), ''), '—')"
                        : "'—'")));

        $sharesExpression = "CASE WHEN po.transaction_unit = 'shares' THEN po.transaction_amount WHEN po.transaction_unit = 'percentage' THEN ({$totalSharesReference} * po.transaction_amount / 100) WHEN po.transaction_unit = 'square_meter' THEN (po.transaction_amount / NULLIF(pc.card_total_area, 0)) * {$totalSharesReference} ELSE 0 END";

        $newOwnersQuery = DB::table('property_operation_new_owner as pono')
            ->join('property_operations as po', 'po.id', '=', 'pono.property_operation_id')
            ->join('property_cards as pc', 'pc.id', '=', 'po.property_card_id')
            ->join('owners as o', 'o.id', '=', 'pono.owner_id')
            ->selectRaw("po.property_card_id,
                pc.card_record_number as record_number,
                pc.card_governorate as governorate,
                pc.card_region_name as region_name,
                pc.card_total_area as total_area_m2,
                pono.owner_id,
                {$ownerNameExpression} as owner_name,
                {$sharesExpression} as shares_delta");

        if ($propertyCardsHasDeletedAt) {
            $newOwnersQuery->whereNull('pc.deleted_at');
        }
        if ($ownersHasDeletedAt) {
            $newOwnersQuery->whereNull('o.deleted_at');
        }

        $oldOwnersQuery = DB::table('property_operation_old_owner as pooo')
            ->join('property_operations as po', 'po.id', '=', 'pooo.property_operation_id')
            ->join('property_cards as pc', 'pc.id', '=', 'po.property_card_id')
            ->join('owners as o', 'o.id', '=', 'pooo.owner_id')
            ->selectRaw("po.property_card_id,
                pc.card_record_number as record_number,
                pc.card_governorate as governorate,
                pc.card_region_name as region_name,
                pc.card_total_area as total_area_m2,
                pooo.owner_id,
                {$ownerNameExpression} as owner_name,
                (-1 * ({$sharesExpression})) as shares_delta");

        if ($propertyCardsHasDeletedAt) {
            $oldOwnersQuery->whereNull('pc.deleted_at');
        }
        if ($ownersHasDeletedAt) {
            $oldOwnersQuery->whereNull('o.deleted_at');
        }

        $unionQuery = $newOwnersQuery->unionAll($oldOwnersQuery);

        $rows = DB::query()
            ->fromSub($unionQuery, 'x')
            ->selectRaw("x.property_card_id,
                x.record_number,
                x.governorate,
                x.region_name,
                x.total_area_m2,
                x.owner_id,
                x.owner_name,
                ROUND(SUM(x.shares_delta), 2) as owner_shares,
                ROUND((SUM(x.shares_delta) / {$totalSharesReference}) * 100, 2) as ownership_percentage")
            ->whereIn('x.owner_id', $ownerIds)
            ->groupBy('x.property_card_id', 'x.record_number', 'x.governorate', 'x.region_name', 'x.total_area_m2', 'x.owner_id', 'x.owner_name')
            ->havingRaw('ROUND(SUM(x.shares_delta), 2) > 0')
            ->get();

        $formatValue = static fn (mixed $value): string => blank($value) ? '—' : (string) $value;

        $relatedByOwner = [];
        foreach ($rows as $row) {
            $ownerId = (int) ($row->owner_id ?? 0);
            if ($ownerId <= 0) {
                continue;
            }

            $propertyId = blank($row->property_card_id ?? null) ? null : (int) $row->property_card_id;
            $propertyName = $propertyId !== null ? "عقار #{$propertyId}" : '—';

            $relatedByOwner[$ownerId][] = [
                'property_id' => $propertyId !== null ? (string) $propertyId : '—',
                'property_name' => $propertyName,
                'country' => '—',
                'governorate' => $formatValue($row->governorate ?? null),
                'region' => $formatValue($row->region_name ?? null),
                'record_number' => $formatValue($row->record_number ?? null),
                'property_number' => '—',
                'ownership_percentage' => $row->ownership_percentage !== null
                    ? rtrim(rtrim(number_format((float) $row->ownership_percentage, 2, '.', ''), '0'), '.') . '%'
                    : '—',
                'shares' => $formatValue($row->owner_shares ?? null),
                'is_current' => 'نعم',
                'updated_at' => '—',
            ];
        }

        return $relatedByOwner;
    }

}
