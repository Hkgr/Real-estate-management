<?php

namespace App\Http\Controllers\ViewerNew\Reports;

use App\Http\Controllers\Controller;
use App\Models\PropertyCardFile;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class AttachmentsReportController extends Controller
{
    public function __invoke(Request $request): View
    {
        $table = (new PropertyCardFile())->getTable();

        $fieldAvailability = [
            'file_name' => Schema::hasColumn($table, 'file_name'),
            'mime_type' => Schema::hasColumn($table, 'mime_type'),
            'file_size' => Schema::hasColumn($table, 'file_size'),
            'property_card_id' => Schema::hasColumn($table, 'property_card_id'),
            'issued_at' => Schema::hasColumn($table, 'issued_at'),
            'created_at' => Schema::hasColumn($table, 'created_at'),
            'updated_at' => Schema::hasColumn($table, 'updated_at'),
        ];

        $query = PropertyCardFile::query();

        if ($fieldAvailability['property_card_id']) {
            $query->with('propertyCard:id,card_record_number,card_region_name,card_subdivision,card_property_number');
        }

        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'type' => trim((string) $request->query('type', '')),
            'property' => trim((string) $request->query('property', '')),
        ];

        if ($filters['q'] !== '') {
            $query->where(function (Builder $builder) use ($filters, $fieldAvailability): void {
                if ($fieldAvailability['file_name']) {
                    $builder->orWhere('file_name', 'like', '%' . $filters['q'] . '%');
                }

                if ($fieldAvailability['mime_type']) {
                    $builder->orWhere('mime_type', 'like', '%' . $filters['q'] . '%');
                }
            });
        }

        $typeOptions = [];
        if ($fieldAvailability['mime_type']) {
            $typeOptions = PropertyCardFile::query()
                ->select('mime_type')
                ->whereNotNull('mime_type')
                ->distinct()
                ->orderBy('mime_type')
                ->pluck('mime_type')
                ->filter()
                ->values()
                ->all();

            if ($filters['type'] !== '' && in_array($filters['type'], $typeOptions, true)) {
                $query->where('mime_type', $filters['type']);
            }
        }

        if ($filters['property'] !== '' && $fieldAvailability['property_card_id']) {
            if (ctype_digit($filters['property'])) {
                $query->where('property_card_id', (int) $filters['property']);
            } else {
                $query->whereHas('propertyCard', function (Builder $builder) use ($filters): void {
                    $builder->where(function (Builder $nested) use ($filters): void {
                        foreach (['card_record_number', 'card_region_name', 'card_subdivision', 'card_property_number'] as $propertyField) {
                            $nested->orWhere($propertyField, 'like', '%' . $filters['property'] . '%');
                        }
                    });
                });
            }
        }

        $attachments = $query
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $downloadRouteExists = Route::has('property-card-files.download');

        $attachments->getCollection()->transform(function (PropertyCardFile $file) use ($fieldAvailability, $downloadRouteExists): array {
            $propertyTitle = '—';

            if ($fieldAvailability['property_card_id']) {
                $property = $file->propertyCard;
                if ($property) {
                    $parts = array_filter([
                        $property->card_record_number ? 'محضر: ' . $property->card_record_number : null,
                        $property->card_region_name,
                        $property->card_subdivision,
                        $property->card_property_number ? 'عقار #' . $property->card_property_number : null,
                    ]);

                    $propertyTitle = $parts !== [] ? implode(' — ', $parts) : 'العقار #' . $property->id;
                }
            }

            return [
                'id' => $file->id,
                'file_name' => $fieldAvailability['file_name'] ? ($file->file_name ?: '—') : '—',
                'mime_type' => $fieldAvailability['mime_type'] ? ($file->mime_type ?: '—') : '—',
                'property_title' => $propertyTitle,
                'property_card_id' => $fieldAvailability['property_card_id'] ? ($file->property_card_id ?: '—') : '—',
                'issued_at' => $fieldAvailability['issued_at'] ? optional($file->issued_at)?->format('Y-m-d') ?? '—' : '—',
                'created_or_updated_at' => $fieldAvailability['updated_at']
                    ? optional($file->updated_at)?->format('Y-m-d H:i') ?? '—'
                    : ($fieldAvailability['created_at'] ? optional($file->created_at)?->format('Y-m-d H:i') ?? '—' : '—'),
                'file_size_human' => $fieldAvailability['file_size'] ? $this->formatBytes($file->file_size) : 'غير متوفر',
                'download_url' => $downloadRouteExists ? route('property-card-files.download', $file) : null,
            ];
        });

        $metrics = [
            'total_files' => number_format((int) PropertyCardFile::query()->count()),
            'linked_properties' => $fieldAvailability['property_card_id']
                ? number_format((int) PropertyCardFile::query()->whereNotNull('property_card_id')->distinct('property_card_id')->count('property_card_id'))
                : 'غير متوفر',
            'file_types_count' => $fieldAvailability['mime_type']
                ? number_format((int) PropertyCardFile::query()->whereNotNull('mime_type')->distinct('mime_type')->count('mime_type'))
                : 'غير متوفر',
            'latest_upload_or_update' => $this->latestMetric($fieldAvailability),
            'total_storage_size' => $fieldAvailability['file_size']
                ? $this->formatBytes((int) (PropertyCardFile::query()->sum('file_size') ?? 0))
                : 'غير متوفر',
        ];

        return view('viewer-new.reports.attachments', compact('metrics', 'attachments', 'filters', 'typeOptions', 'fieldAvailability'));
    }

    private function latestMetric(array $fieldAvailability): string
    {
        if ($fieldAvailability['updated_at']) {
            return optional(PropertyCardFile::query()->latest('updated_at')->value('updated_at'))?->format('Y-m-d H:i') ?? '—';
        }

        if ($fieldAvailability['created_at']) {
            return optional(PropertyCardFile::query()->latest('created_at')->value('created_at'))?->format('Y-m-d H:i') ?? '—';
        }

        return 'غير متوفر';
    }

    private function formatBytes(mixed $bytes): string
    {
        if (! is_numeric($bytes)) {
            return '—';
        }

        $bytes = (float) $bytes;

        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = min((int) floor(log($bytes, 1024)), count($units) - 1);

        return number_format($bytes / (1024 ** $power), 2) . ' ' . $units[$power];
    }
}
