<?php

namespace App\Http\Controllers\ViewerNew\Reports;

use App\Http\Controllers\Controller;
use App\Models\Signal;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SignalsReportController extends Controller
{
    public function __invoke(Request $request): View
    {
        $table = (new Signal())->getTable();
        $propertyCardsTable = 'property_cards';

        $hasTable = Schema::hasTable($table);
        $columns = $hasTable ? Schema::getColumnListing($table) : [];
        $has = fn (string $column): bool => in_array($column, $columns, true);

        $hasPropertyCardsTable = Schema::hasTable($propertyCardsTable);
        $propertyCardColumns = $hasPropertyCardsTable ? Schema::getColumnListing($propertyCardsTable) : [];
        $hasPropertyCardColumn = fn (string $column): bool => in_array($column, $propertyCardColumns, true);

        $fieldAvailability = [
            'id' => $has('id'), 'signal_id' => $has('signal_id'), 'signal_date' => $has('signal_date'), 'type' => $has('type'),
            'signal_owners' => $has('signal_owners'), 'signal_sources' => $has('signal_sources'), 'signal_notes' => $has('signal_notes'),
            'signal_source_date' => $has('signal_source_date'), 'signal_victims' => $has('signal_victims'), 'property_id' => $has('property_id'),
            'property_card_id' => $has('property_card_id'), 'created_at' => $has('created_at'), 'updated_at' => $has('updated_at'),
            'deleted_at' => $has('deleted_at'),
        ];

        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'type' => trim((string) $request->query('type', '')),
            'signal_date_from' => $this->normalizeDateFilter($request->query('signal_date_from')),
            'signal_date_to' => $this->normalizeDateFilter($request->query('signal_date_to')),
            'source_date_from' => $this->normalizeDateFilter($request->query('source_date_from')),
            'source_date_to' => $this->normalizeDateFilter($request->query('source_date_to')),
        ];

        $baseQuery = Signal::query();
        if ($fieldAvailability['deleted_at']) {
            $baseQuery->whereNull('deleted_at');
        }

        if ($fieldAvailability['signal_id']) {
            $baseQuery->whereNotNull('signal_id')->whereRaw("TRIM(CAST(signal_id AS CHAR)) <> ''");
        }

        $searchableColumns = array_values(array_filter([
            $fieldAvailability['signal_id'] ? 'signal_id' : null, $fieldAvailability['type'] ? 'type' : null,
            $fieldAvailability['signal_notes'] ? 'signal_notes' : null, $fieldAvailability['signal_owners'] ? 'signal_owners' : null,
            $fieldAvailability['signal_sources'] ? 'signal_sources' : null, $fieldAvailability['signal_victims'] ? 'signal_victims' : null,
        ]));

        if ($filters['q'] !== '' && $searchableColumns !== []) {
            $term = $filters['q'];
            $baseQuery->where(function (Builder $builder) use ($searchableColumns, $term): void {
                foreach ($searchableColumns as $index => $column) {
                    $builder->{$index === 0 ? 'where' : 'orWhere'}($column, 'like', "%{$term}%");
                }
            });
        }

        $typeOptions = [];
        if ($fieldAvailability['type']) {
            $typeOptions = Signal::query()->whereNotNull('type')->where('type', '!=', '')->distinct()->orderBy('type')->pluck('type')->values()->all();
            if ($filters['type'] !== '' && in_array($filters['type'], $typeOptions, true)) {
                $baseQuery->where('type', $filters['type']);
            }
        }

        if ($fieldAvailability['signal_date']) {
            if ($filters['signal_date_from'] !== '') $baseQuery->whereDate('signal_date', '>=', $filters['signal_date_from']);
            if ($filters['signal_date_to'] !== '') $baseQuery->whereDate('signal_date', '<=', $filters['signal_date_to']);
        }
        if ($fieldAvailability['signal_source_date']) {
            if ($filters['source_date_from'] !== '') $baseQuery->whereDate('signal_source_date', '>=', $filters['source_date_from']);
            if ($filters['source_date_to'] !== '') $baseQuery->whereDate('signal_source_date', '<=', $filters['source_date_to']);
        }

        $groupQuery = (clone $baseQuery)->select('signal_id')->groupBy('signal_id');
        if ($fieldAvailability['updated_at']) {
            $groupQuery->orderByRaw('MAX(updated_at) DESC');
        } elseif ($fieldAvailability['id']) {
            $groupQuery->orderByRaw('MAX(id) DESC');
        }

        $signals = $groupQuery->paginate(15)->withQueryString();
        $pageSignalNumbers = $signals->pluck('signal_id')->map(fn ($v) => (string) $v)->filter()->values();

        $rowsBySignalId = collect();
        if ($pageSignalNumbers->isNotEmpty()) {
            $detailQuery = (clone $baseQuery)->with('propertyCard')->whereIn(DB::raw('CAST(signal_id AS CHAR)'), $pageSignalNumbers->all());
            $rowsBySignalId = $detailQuery->get()->groupBy(fn (Signal $s) => (string) $s->signal_id);
        }

        $signals->setCollection($signals->getCollection()->map(function ($groupRow) use ($rowsBySignalId, $fieldAvailability, $hasPropertyCardsTable, $hasPropertyCardColumn): array {
            $signalNumber = (string) ($groupRow->signal_id ?? '');
            $rows = $rowsBySignalId->get($signalNumber, collect());

            $types = $rows->pluck('type')->map(fn ($v) => trim((string) $v))->filter()->unique()->values();
            $signalDates = $rows->pluck('signal_date')->map(fn ($v) => $this->formatDateValue($v, 'Y-m-d'))->filter(fn ($v) => $v !== '—')->unique()->values();
            $sourceDates = $rows->pluck('signal_source_date')->map(fn ($v) => $this->formatDateValue($v, 'Y-m-d'))->filter(fn ($v) => $v !== '—')->unique()->values();

            $owners = $rows->flatMap(fn (Signal $row) => $this->decodeJsonItems($row->getAttribute('signal_owners'), 'owner'))->unique()->values();
            $victims = $rows->flatMap(fn (Signal $row) => $this->decodeJsonItems($row->getAttribute('signal_victims'), 'victim'))->unique()->values();
            $sources = $rows->flatMap(fn (Signal $row) => $this->decodeJsonItems($row->getAttribute('signal_sources'), 'source'))->unique()->values();
            $notes = $rows->pluck('signal_notes')->map(fn ($v) => trim((string) $v))->filter()->unique()->values();

            $relatedProperties = $this->buildRelatedProperties($rows, $hasPropertyCardsTable, $hasPropertyCardColumn);

            $lastUpdated = $fieldAvailability['updated_at']
                ? $rows->max(fn (Signal $row) => optional($row->updated_at)->getTimestamp() ?? strtotime((string) $row->updated_at) ?: 0)
                : null;

            return [
                'signal_number' => $signalNumber !== '' ? $signalNumber : '—',
                'signal_type_label' => $types->isNotEmpty() ? $types->implode('، ') : '—',
                'signal_date_label' => $signalDates->isNotEmpty() ? $signalDates->implode('، ') : '—',
                'source_date_label' => $sourceDates->isNotEmpty() ? $sourceDates->implode('، ') : '—',
                'properties_count' => $relatedProperties->count(),
                'owners_count' => $owners->count(),
                'victims_count' => $victims->count(),
                'sources_count' => $sources->count(),
                'owners_summary' => $this->buildSummary($owners, 'أصحاب'),
                'victims_summary' => $this->buildSummary($victims, 'متضررون'),
                'sources_summary' => $this->buildSummary($sources, 'مصادر'),
                'notes_summary' => $notes->isNotEmpty() ? mb_strimwidth($notes->first(), 0, 80, '…') : '—',
                'created_at' => $fieldAvailability['created_at'] ? $this->formatDateValue($rows->min('created_at'), 'Y-m-d H:i') : '—',
                'last_update' => $lastUpdated ? date('Y-m-d H:i', $lastUpdated) : '—',
                'related_properties' => $relatedProperties->values()->all(),
                'related_owners' => $owners->all(),
                'related_victims' => $victims->all(),
                'related_sources' => $sources->all(),
            ];
        }));

        $metrics = [
            'total_unique_signals' => $fieldAvailability['signal_id'] ? number_format((int) (clone $baseQuery)->distinct('signal_id')->count('signal_id')) : 'غير متوفر',
            'total_raw_signal_rows' => $hasTable ? number_format((int) (clone $baseQuery)->count()) : 'غير متوفر',
            'linked_property_cards' => $fieldAvailability['property_card_id'] ? number_format((int) (clone $baseQuery)->whereNotNull('property_card_id')->distinct('property_card_id')->count('property_card_id')) : 'غير متوفر',
            'last_update' => $fieldAvailability['updated_at'] ? ((clone $baseQuery)->latest('updated_at')->value('updated_at')?->format('Y-m-d H:i') ?? '—') : 'غير متوفر',
        ];

        return view('viewer-new.reports.signals', compact('metrics', 'signals', 'filters', 'typeOptions', 'fieldAvailability'));
    }

    private function decodeJsonItems(mixed $value, string $mode): array
    {
        $items = is_array($value) ? $value : (is_string($value) ? (json_decode($value, true) ?: []) : []);
        if (!is_array($items)) return [];
        $result = [];
        foreach ($items as $item) {
            if (is_array($item)) {
                if ($mode !== 'source') {
                    $name = trim((string) ($item['name'] ?? ''));
                    $label = trim((string) ($item['label'] ?? ''));
                    if ($name !== '') { $result[] = $name; continue; }
                    if ($label !== '') { $result[] = $label; continue; }
                    $ownerId = trim((string) ($item['owner_id'] ?? ''));
                    if ($ownerId !== '') { $result[] = 'مالك #'.$ownerId; continue; }
                } else {
                    foreach (['source', 'source_name', 'name', 'label', 'title', 'value'] as $key) {
                        $val = trim((string) ($item[$key] ?? ''));
                        if ($val !== '') { $result[] = $val; break; }
                    }
                }
            } elseif (is_scalar($item)) {
                $scalar = trim((string) $item);
                if ($scalar !== '') $result[] = $scalar;
            }
        }
        return array_values(array_unique(array_filter($result)));
    }

    private function buildSummary(Collection $items, string $label): string
    {
        if ($items->isEmpty()) return '—';
        if ($items->count() === 1) return $items->first();
        return $items->first() . ' +' . ($items->count() - 1) . ' ' . $label;
    }

    private function buildRelatedProperties(Collection $rows, bool $hasPropertyCardsTable, callable $hasPropertyCardColumn): Collection
    {
        $properties = $rows->map(function (Signal $row) use ($hasPropertyCardsTable, $hasPropertyCardColumn) {
            $pc = $row->propertyCard;

            if ($pc && $hasPropertyCardsTable && $hasPropertyCardColumn('deleted_at') && ! blank($pc->deleted_at)) {
                return null;
            }

            return [
                'property_card_id' => $pc->id ?? $row->property_card_id,
                'record_number' => $pc->card_record_number ?? '—',
                'governorate' => $pc->card_governorate ?? '—',
                'region_name' => $pc->card_region_name ?? '—',
                'subdivision' => $pc->card_subdivision ?? '—',
                'total_area_m2' => $pc->card_total_area ?? '—',
                'card_area_unit' => $pc->card_area_unit ?? '—',
                'card_status' => $pc->card_status ?? '—',
                'card_investment_type' => $pc->card_investment_type ?? '—',
                'card_purchase_method' => $pc->card_purchase_method ?? '—',
                'total_property_value_usd' => $pc->total_property_value_usd ?? '—',
                'owned_property_value_usd' => $pc->owned_property_value_usd ?? '—',
                'final_balance' => $pc->final_balance ?? '—',
                'created_at' => $this->formatDateValue($pc->created_at ?? null, 'Y-m-d H:i'),
                'updated_at' => $this->formatDateValue($pc->updated_at ?? null, 'Y-m-d H:i'),
            ];
        })->filter(fn ($item) => is_array($item) && ! blank($item['property_card_id']))
            ->unique('property_card_id')
            ->values();

        return $properties;
    }

    private function normalizeDateFilter(mixed $value): string { if (! is_string($value)) return ''; $value = trim($value); if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) return ''; $date = \DateTime::createFromFormat('Y-m-d', $value); return $date && $date->format('Y-m-d') === $value ? $value : ''; }
    private function formatDateValue(mixed $value, string $format): string { if (blank($value)) return '—'; if ($value instanceof \DateTimeInterface) return $value->format($format); $timestamp = strtotime((string) $value); return $timestamp !== false ? date($format, $timestamp) : '—'; }
}
