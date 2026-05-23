<?php

namespace App\Http\Controllers\ViewerNew\Reports;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\OwnerPropertyCard;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\JoinClause;
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

        if ($hasPivotTable && in_array($filters['has_properties'], ['1', '0'], true)) {
            $method = $filters['has_properties'] === '1' ? 'whereHas' : 'whereDoesntHave';
            $ownersQuery->{$method}('propertyCards');
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

        $owners->setCollection($owners->getCollection()->map(function (Owner $owner) use ($ownerHas, $pivotHas, $hasCurrentColumn): array {
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
                'properties_linked_count' => $owner->properties_linked_count ?? '—',
                'ownership_percentage' => $ownershipPercentage,
                'current_ownerships_count' => $hasCurrentColumn ? ($owner->current_ownerships_count ?? 0) : '—',
                'created_at' => $ownerHas('created_at') ? $formatDate($owner->getAttribute('created_at'), 'Y-m-d H:i') : '—',
                'last_update' => $ownerHas('updated_at') ? $formatDate($owner->getAttribute('updated_at'), 'Y-m-d H:i') : '—',
                'status_or_notes' => $ownerHas('notes')
                    ? ($owner->notes ?: '—')
                    : ($ownerHas('is_active') ? ((bool) $owner->is_active ? 'نشط' : 'غير نشط') : '—'),
                'related_properties' => $relatedPropertiesByOwner[(int) $owner->id] ?? [],
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

    private function buildRelatedPropertiesByOwner(array $ownerIds): array
    {
        $ownerIds = array_values(array_unique(array_filter(array_map('intval', $ownerIds), static fn (int $id): bool => $id > 0)));
        if ($ownerIds === []) {
            return [];
        }

        $pivotTable = (new OwnerPropertyCard())->getTable();
        $propertyCardsTable = (new \App\Models\PropertyCard())->getTable();
        $propertiesTable = (new \App\Models\Property())->getTable();

        if (! Schema::hasTable($pivotTable) || ! Schema::hasTable($propertyCardsTable)) {
            return [];
        }

        $pivotColumns = Schema::getColumnListing($pivotTable);
        $propertyCardColumns = Schema::getColumnListing($propertyCardsTable);

        $pivotHas = static fn (string $column): bool => in_array($column, $pivotColumns, true);
        $propertyCardHas = static fn (string $column): bool => in_array($column, $propertyCardColumns, true);

        if (! $pivotHas('owner_id')) {
            return [];
        }

        $hasPropertiesTable = Schema::hasTable($propertiesTable);
        $propertyColumns = $hasPropertiesTable ? Schema::getColumnListing($propertiesTable) : [];
        $propertyHas = static fn (string $column): bool => in_array($column, $propertyColumns, true);

        $query = DB::table($pivotTable . ' as opc')->whereIn('opc.owner_id', $ownerIds);

        if ($pivotHas('property_card_id')) {
            $query->leftJoin($propertyCardsTable . ' as pc', 'pc.id', '=', 'opc.property_card_id');
        }

        if ($hasPropertiesTable && $propertyCardHas('property_id')) {
            $query->leftJoin($propertiesTable . ' as p', function (JoinClause $join) use ($propertyHas): void {
                $join->on('p.id', '=', 'pc.property_id');
                if ($propertyHas('deleted_at')) {
                    $join->whereNull('p.deleted_at');
                }
            });
        }

        $rows = $query->select([
            'opc.owner_id',
            DB::raw($pivotHas('property_card_id') ? 'opc.property_card_id as property_id' : 'NULL as property_id'),
            DB::raw($hasPropertiesTable && $propertyHas('property_name') ? 'p.property_name as property_name' : 'NULL as property_name'),
            DB::raw($hasPropertiesTable && $propertyHas('property_country') ? 'p.property_country as country' : 'NULL as country'),
            DB::raw($propertyCardHas('card_governorate') ? 'pc.card_governorate as governorate' : 'NULL as governorate'),
            DB::raw($propertyCardHas('card_region_name') ? 'pc.card_region_name as region' : 'NULL as region'),
            DB::raw($propertyCardHas('card_record_number') ? 'pc.card_record_number as record_number' : 'NULL as record_number'),
            DB::raw($propertyCardHas('card_property_number') ? 'pc.card_property_number as property_number' : 'NULL as property_number'),
            DB::raw($pivotHas('ownership_percentage') ? 'opc.ownership_percentage as ownership_percentage' : 'NULL as ownership_percentage'),
            DB::raw($pivotHas('ownership_metric') ? 'opc.ownership_metric as shares' : 'NULL as shares'),
            DB::raw($pivotHas('is_current') ? 'opc.is_current as is_current' : 'NULL as is_current'),
            DB::raw($pivotHas('updated_at') ? 'opc.updated_at as updated_at' : 'NULL as updated_at'),
        ])->get();

        $formatValue = static fn (mixed $value): string => blank($value) ? '—' : (string) $value;

        $relatedByOwner = [];
        foreach ($rows as $row) {
            $ownerId = (int) ($row->owner_id ?? 0);
            if ($ownerId <= 0) {
                continue;
            }

            $relatedByOwner[$ownerId][] = [
                'property_id' => $formatValue($row->property_id ?? null),
                'property_name' => $formatValue($row->property_name ?? null),
                'country' => $formatValue($row->country ?? null),
                'governorate' => $formatValue($row->governorate ?? null),
                'region' => $formatValue($row->region ?? null),
                'record_number' => $formatValue($row->record_number ?? null),
                'property_number' => $formatValue($row->property_number ?? null),
                'ownership_percentage' => $row->ownership_percentage !== null
                    ? rtrim(rtrim(number_format((float) $row->ownership_percentage, 2, '.', ''), '0'), '.') . '%'
                    : '—',
                'shares' => $formatValue($row->shares ?? null),
                'is_current' => $row->is_current === null ? '—' : ((bool) $row->is_current ? 'نعم' : 'لا'),
                'updated_at' => blank($row->updated_at) ? '—' : (string) $row->updated_at,
            ];
        }

        return $relatedByOwner;
    }
}
