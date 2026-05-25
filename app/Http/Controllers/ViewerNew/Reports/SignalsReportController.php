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
            'id' => $has('id'),
            'signal_id' => $has('signal_id'),
            'signal_date' => $has('signal_date'),
            'type' => $has('type'),
            'signal_owners' => $has('signal_owners'),
            'signal_sources' => $has('signal_sources'),
            'signal_notes' => $has('signal_notes'),
            'signal_source_date' => $has('signal_source_date'),
            'signal_victims' => $has('signal_victims'),
            'property_id' => $has('property_id'),
            'property_card_id' => $has('property_card_id'),
            'created_at' => $has('created_at'),
            'updated_at' => $has('updated_at'),
        ];

        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'type' => trim((string) $request->query('type', '')),
            'signal_date_from' => $this->normalizeDateFilter($request->query('signal_date_from')),
            'signal_date_to' => $this->normalizeDateFilter($request->query('signal_date_to')),
            'source_date_from' => $this->normalizeDateFilter($request->query('source_date_from')),
            'source_date_to' => $this->normalizeDateFilter($request->query('source_date_to')),
        ];

        $query = Signal::query()->with(['propertyCard']);

        $searchableColumns = array_values(array_filter([
            $fieldAvailability['signal_id'] ? 'signal_id' : null,
            $fieldAvailability['type'] ? 'type' : null,
            $fieldAvailability['signal_notes'] ? 'signal_notes' : null,
            $fieldAvailability['signal_owners'] ? 'signal_owners' : null,
            $fieldAvailability['signal_sources'] ? 'signal_sources' : null,
            $fieldAvailability['signal_victims'] ? 'signal_victims' : null,
        ]));

        if ($filters['q'] !== '' && $searchableColumns !== []) {
            $term = $filters['q'];
            $query->where(function (Builder $builder) use ($searchableColumns, $term): void {
                foreach ($searchableColumns as $index => $column) {
                    $builder->{$index === 0 ? 'where' : 'orWhere'}($column, 'like', "%{$term}%");
                }
            });
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

        if ($fieldAvailability['signal_date']) {
            if ($filters['signal_date_from'] !== '') {
                $query->whereDate('signal_date', '>=', $filters['signal_date_from']);
            }

            if ($filters['signal_date_to'] !== '') {
                $query->whereDate('signal_date', '<=', $filters['signal_date_to']);
            }
        }

        if ($fieldAvailability['signal_source_date']) {
            if ($filters['source_date_from'] !== '') {
                $query->whereDate('signal_source_date', '>=', $filters['source_date_from']);
            }

            if ($filters['source_date_to'] !== '') {
                $query->whereDate('signal_source_date', '<=', $filters['source_date_to']);
            }
        }

        $signals = $query
            ->latest($fieldAvailability['updated_at'] ? 'updated_at' : 'id')
            ->paginate(15)
            ->withQueryString();

        $signals->setCollection($signals->getCollection()->map(function (Signal $signal) use ($fieldAvailability): array {
            return [
                'id' => $fieldAvailability['id'] ? ($signal->getAttribute('id') ?? '—') : '—',
                'signal_id' => $fieldAvailability['signal_id'] ? (trim((string) ($signal->signal_id ?? '')) ?: '—') : '—',
                'signal_type' => $fieldAvailability['type'] ? (trim((string) ($signal->type ?? '')) ?: '—') : '—',
                'property_label' => $this->resolvePropertyLabel($signal, $fieldAvailability),
                'owners_label' => $this->decodeJsonLabel($fieldAvailability['signal_owners'] ? $signal->getAttribute('signal_owners') : null),
                'victims_label' => $this->decodeJsonLabel($fieldAvailability['signal_victims'] ? $signal->getAttribute('signal_victims') : null),
                'sources_label' => $this->decodeJsonLabel($fieldAvailability['signal_sources'] ? $signal->getAttribute('signal_sources') : null),
                'signal_date' => $fieldAvailability['signal_date'] ? $this->formatDateValue($signal->getAttribute('signal_date'), 'Y-m-d') : '—',
                'signal_source_date' => $fieldAvailability['signal_source_date'] ? $this->formatDateValue($signal->getAttribute('signal_source_date'), 'Y-m-d') : '—',
                'created_at' => $fieldAvailability['created_at'] ? $this->formatDateValue($signal->getAttribute('created_at'), 'Y-m-d H:i') : '—',
                'last_update' => $fieldAvailability['updated_at'] ? $this->formatDateValue($signal->getAttribute('updated_at'), 'Y-m-d H:i') : '—',
                'notes' => $fieldAvailability['signal_notes'] ? (trim((string) ($signal->signal_notes ?? '')) ?: '—') : '—',
            ];
        }));

        $metrics = [
            'total_signals' => $hasTable ? number_format((int) Signal::query()->count()) : 'غير متوفر',
            'linked_property_cards' => $fieldAvailability['property_card_id']
                ? number_format((int) Signal::query()->whereNotNull('property_card_id')->count())
                : 'غير متوفر',
            'linked_properties' => $fieldAvailability['property_id']
                ? number_format((int) Signal::query()->whereNotNull('property_id')->count())
                : 'غير متوفر',
            'last_update' => $fieldAvailability['updated_at']
                ? (Signal::query()->latest('updated_at')->value('updated_at')?->format('Y-m-d H:i') ?? '—')
                : 'غير متوفر',
        ];

        return view('viewer-new.reports.signals', compact('metrics', 'signals', 'filters', 'typeOptions', 'fieldAvailability'));
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

    private function decodeJsonLabel(mixed $value): string
    {
        if (is_array($value)) {
            $items = $value;
        } elseif (is_string($value)) {
            $decoded = json_decode($value, true);
            $items = is_array($decoded) ? $decoded : [];
        } else {
            $items = [];
        }

        $flat = $this->flattenJsonItems($items);

        return $flat !== [] ? implode('، ', $flat) : '—';
    }

    private function flattenJsonItems(array $items): array
    {
        $flat = [];

        array_walk_recursive($items, function ($item) use (&$flat): void {
            if (is_scalar($item)) {
                $value = trim((string) $item);
                if ($value !== '') {
                    $flat[] = $value;
                }
            }
        });

        return array_values(array_unique($flat));
    }

    private function resolvePropertyLabel(Signal $signal, array $fieldAvailability): string
    {
        if ($signal->propertyCard) {
            $cardLabel = trim((string) (
                $signal->propertyCard->card_record_number
                ?? $signal->propertyCard->property_number
                ?? $signal->propertyCard->id
                ?? ''
            ));

            if ($cardLabel !== '') {
                return $cardLabel;
            }
        }

        if ($fieldAvailability['property_card_id']) {
            $propertyCardId = trim((string) ($signal->getAttribute('property_card_id') ?? ''));
            if ($propertyCardId !== '') {
                return $propertyCardId;
            }
        }

        if ($fieldAvailability['property_id']) {
            $propertyId = trim((string) ($signal->getAttribute('property_id') ?? ''));
            if ($propertyId !== '') {
                return $propertyId;
            }
        }

        return '—';
    }

    private function formatDateValue(mixed $value, string $format): string
    {
        if (blank($value)) {
            return '—';
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format($format);
        }

        $timestamp = strtotime((string) $value);

        return $timestamp !== false ? date($format, $timestamp) : '—';
    }
}
