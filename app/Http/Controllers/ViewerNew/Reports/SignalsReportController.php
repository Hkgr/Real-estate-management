<?php

namespace App\Http\Controllers\ViewerNew\Reports;

use App\Http\Controllers\Controller;
use App\Models\Signal;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SignalsReportController extends Controller
{
    public function __invoke(Request $request): View
    {
        $table = (new Signal())->getTable();

        $hasTable = Schema::hasTable($table);
        $columns = $hasTable ? Schema::getColumnListing($table) : [];
        $has = fn (string $column): bool => in_array($column, $columns, true);

        $fieldAvailability = [
            'signal_id' => $has('signal_id'),
            'type' => $has('type'),
            'signal_date' => $has('signal_date'),
            'signal_notes' => $has('signal_notes'),
            'signal_owner' => $has('signal_owner'),
            'signal_owners' => $has('signal_owners'),
            'property_card_id' => $has('property_card_id'),
            'updated_at' => $has('updated_at'),
            'status' => $has('status'),
        ];

        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'status' => trim((string) $request->query('status', '')),
            'type' => trim((string) $request->query('type', '')),
        ];

        $query = Signal::query()->with(['propertyCard', 'owners']);

        $searchableColumns = array_values(array_filter([
            $fieldAvailability['signal_id'] ? 'signal_id' : null,
            $fieldAvailability['type'] ? 'type' : null,
            $fieldAvailability['signal_notes'] ? 'signal_notes' : null,
            $fieldAvailability['signal_owner'] ? 'signal_owner' : null,
        ]));

        if ($filters['q'] !== '' && $searchableColumns !== []) {
            $term = $filters['q'];
            $query->where(function (Builder $builder) use ($searchableColumns, $term): void {
                foreach ($searchableColumns as $index => $column) {
                    $builder->{$index === 0 ? 'where' : 'orWhere'}($column, 'like', "%{$term}%");
                }
            });
        }

        $statusOptions = [];
        if ($fieldAvailability['status']) {
            $statusOptions = Signal::query()
                ->select('status')
                ->whereNotNull('status')
                ->distinct()
                ->orderBy('status')
                ->pluck('status')
                ->filter()
                ->values()
                ->all();

            if ($filters['status'] !== '' && in_array($filters['status'], $statusOptions, true)) {
                $query->where('status', $filters['status']);
            }
        }

        $typeOptions = [];
        if ($fieldAvailability['type']) {
            $typeOptions = Signal::query()
                ->select('type')
                ->whereNotNull('type')
                ->distinct()
                ->orderBy('type')
                ->pluck('type')
                ->filter()
                ->values()
                ->all();

            if ($filters['type'] !== '' && in_array($filters['type'], $typeOptions, true)) {
                $query->where('type', $filters['type']);
            }
        }

        $signals = $query
            ->latest($fieldAvailability['updated_at'] ? 'updated_at' : 'id')
            ->paginate(15)
            ->withQueryString();

        $signals->setCollection($signals->getCollection()->map(function (Signal $signal) use ($fieldAvailability): array {
            $ownersLabel = $signal->owners->pluck('display_name')->filter()->implode('، ');
            if ($ownersLabel === '' && $fieldAvailability['signal_owners']) {
                $ownersLabel = $signal->signal_owners_label;
            }

            return [
                'signal_type' => $fieldAvailability['type'] ? ($signal->type ?: '—') : '—',
                'property_label' => $signal->propertyCard?->card_record_number ?: '—',
                'owner_label' => $ownersLabel !== '' ? $ownersLabel : ($fieldAvailability['signal_owner'] ? ($signal->signal_owner ?: '—') : '—'),
                'signal_date' => $fieldAvailability['signal_date'] ? ($signal->signal_date?->format('Y-m-d') ?: '—') : '—',
                'status' => $fieldAvailability['status'] ? ($signal->status ?: '—') : '—',
                'last_update' => $fieldAvailability['updated_at'] ? ($signal->updated_at?->format('Y-m-d H:i') ?: '—') : '—',
                'notes' => $fieldAvailability['signal_notes'] ? ($signal->signal_notes ?: '—') : '—',
            ];
        }));

        $metrics = [
            'total_signals' => $hasTable ? number_format((int) Signal::query()->count()) : 'غير متوفر',
            'active_signals' => $this->resolveActiveSignals($fieldAvailability),
            'closed_signals' => $this->resolveClosedSignals($fieldAvailability),
            'linked_properties' => $fieldAvailability['property_card_id']
                ? number_format((int) Signal::query()->whereNotNull('property_card_id')->count())
                : 'غير متوفر',
            'last_update' => $fieldAvailability['updated_at']
                ? (Signal::query()->latest('updated_at')->value('updated_at')?->format('Y-m-d H:i') ?? '—')
                : 'غير متوفر',
        ];

        return view('viewer-new.reports.signals', compact('metrics', 'signals', 'filters', 'statusOptions', 'typeOptions', 'fieldAvailability'));
    }

    private function resolveActiveSignals(array $fieldAvailability): string
    {
        if ($fieldAvailability['status']) {
            return (string) Signal::query()->whereIn('status', ['active', 'نشط', 'مفتوح'])->count();
        }

        return 'غير متوفر';
    }

    private function resolveClosedSignals(array $fieldAvailability): string
    {
        if ($fieldAvailability['status']) {
            return (string) Signal::query()->whereIn('status', ['closed', 'منتهي', 'مغلق'])->count();
        }

        return 'غير متوفر';
    }
}
