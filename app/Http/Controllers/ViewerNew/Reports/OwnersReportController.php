<?php

namespace App\Http\Controllers\ViewerNew\Reports;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\OwnerPropertyCard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

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

        $owners->setCollection($owners->getCollection()->map(function (Owner $owner) use ($ownerHas, $pivotHas, $hasCurrentColumn): array {
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
                'birth_date' => $ownerHas('birth_date') ? ($owner->birth_date?->format('Y-m-d') ?? '—') : '—',
                'properties_linked_count' => $owner->properties_linked_count ?? '—',
                'ownership_percentage' => $ownershipPercentage,
                'current_ownerships_count' => $hasCurrentColumn ? ($owner->current_ownerships_count ?? 0) : '—',
                'created_at' => $ownerHas('created_at') ? ($owner->created_at?->format('Y-m-d H:i') ?? '—') : '—',
                'last_update' => $ownerHas('updated_at') ? ($owner->updated_at?->format('Y-m-d H:i') ?? '—') : '—',
                'status_or_notes' => $ownerHas('notes')
                    ? ($owner->notes ?: '—')
                    : ($ownerHas('is_active') ? ((bool) $owner->is_active ? 'نشط' : 'غير نشط') : '—'),
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
}
