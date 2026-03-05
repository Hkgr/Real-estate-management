<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\PropertyCard;
use App\Models\PropertyInstallment;
use App\Models\PropertyOperation;
use App\Models\Signal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PropertyCardsPdfExporter
{
    /**
     * @param  array<int>  $selectedIds
     */
    public function __construct(
        protected ?Builder $query = null,
        protected array $selectedIds = [],
    ) {}

    public function download(string $filename): BinaryFileResponse
    {
        $pdf = Pdf::loadView('pdf.property-cards-table', [
            'headings' => $this->headings(),
            'rows' => $this->rows(),
        ])->setPaper('a4', 'landscape');

        // ✅ إنشاء ملف مؤقت وإرجاعه كـ BinaryFileResponse (أفضل توافق مع Filament/Livewire)
        $disk = Storage::disk('local');
        $tmpDir = 'exports/tmp';
        $tmpName = 'property-cards-' . now()->format('Ymd-His') . '-' . Str::random(10) . '.pdf';
        $relativePath = $tmpDir . '/' . $tmpName;

        $disk->put($relativePath, $pdf->output());

        return response()
            ->download($disk->path($relativePath), $filename, [
                'Content-Type' => 'application/pdf',
            ])
            ->deleteFileAfterSend(true);
    }

    /**
     * @return array<int, string>
     */
    protected function headings(): array
    {
        return [
            '#',
            'المحضر',
            'المحافظة',
            'المنطقة العقارية',
            'المقسم',
            'مساحة العقار الكلية',
            'رابط موقع العقار',
            'بيانات تفصيلية',
            'العمليات',
            'الإشارات',
            'ملحقات البطاقة',
            'الدفعات',
        ];
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function rows(): array
    {
        return $this->query()
            ->get()
            ->map(fn (PropertyCard $propertyCard): array => [
                $propertyCard->id,
                $propertyCard->card_record_number,
                $propertyCard->card_governorate,
                $propertyCard->card_region_name,
                $propertyCard->card_subdivision,
                filled($propertyCard->card_total_area) ? number_format((float) $propertyCard->card_total_area, 2) : '—',
                $propertyCard->card_google_maps_url ?: '—',
                $propertyCard->card_property_details ?: '—',
                $this->operationsText($propertyCard),
                $this->signalsText($propertyCard),
                $this->filesText($propertyCard),
                $this->installmentsText($propertyCard),
            ])
            ->all();
    }

    protected function query(): Builder
    {
        // ✅ نفس منطق الإكسل: إذا في Query نستخدمها، وإلا نستخدم selectedIds إن وجدت
        $baseQuery = $this->query instanceof Builder
            ? (clone $this->query)
            : PropertyCard::query();

        if ($this->query === null && $this->selectedIds !== []) {
            $ids = array_values(array_map('intval', $this->selectedIds));

            $baseQuery->whereIn('id', $ids);

            // ✅ اختياري: يحافظ على ترتيب التحديد (MySQL)
            $baseQuery->orderByRaw('FIELD(id,' . implode(',', $ids) . ')');
        }

        return $baseQuery
            ->with([
                'operations.oldOwners',
                'operations.newOwners',
                'operations.witnesses',
                'signals',
                'files',
                'installments',
            ])
            ->select([
                'id',
                'card_record_number',
                'card_governorate',
                'card_region_name',
                'card_subdivision',
                'card_total_area',
                'card_google_maps_url',
                'card_property_details',
            ]);
    }

    protected function operationsText(PropertyCard $propertyCard): string
    {
        if ($propertyCard->operations->isEmpty()) {
            return '—';
        }

        return $propertyCard->operations
            ->map(fn (PropertyOperation $operation): string => $this->formatOperation($operation))
            ->implode("\n----------------\n");
    }

    protected function signalsText(PropertyCard $propertyCard): string
    {
        if ($propertyCard->signals->isEmpty()) {
            return '—';
        }

        return $propertyCard->signals
            ->map(fn (Signal $signal): string => sprintf(
                'رقم الإشارة: %s | النوع: %s | التاريخ: %s',
                $signal->signal_id ?: '—',
                $signal->type ?: '—',
                $signal->signal_date?->format('d/m/Y') ?: '—',
            ))
            ->implode("\n");
    }

    protected function filesText(PropertyCard $propertyCard): string
    {
        if ($propertyCard->files->isEmpty()) {
            return '—';
        }

        return $propertyCard->files
            ->pluck('file_name')
            ->filter()
            ->join("\n");
    }

    protected function installmentsText(PropertyCard $propertyCard): string
    {
        if ($propertyCard->installments->isEmpty()) {
            return '—';
        }

        return $propertyCard->installments
            ->map(fn (PropertyInstallment $installment): string => sprintf(
                'المبلغ: %s | التاريخ: %s | المتبقي: %s',
                number_format((float) ($installment->amount ?? 0), 2),
                $installment->payment_date?->format('d/m/Y') ?: '—',
                number_format((float) ($installment->remaining_after_payment ?? 0), 2),
            ))
            ->implode("\n");
    }

    protected function formatOperation(PropertyOperation $operation): string
    {
        $typeLabel = match ($operation->operation_type) {
            'sale' => 'بيع',
            'purchase' => 'شراء',
            default => '—',
        };

        $unitLabel = match ($operation->transaction_unit) {
            'shares' => 'سهم',
            'square_meter' => 'م²',
            'percentage' => '%',
            default => '',
        };

        $amount = filled($operation->transaction_amount)
            ? number_format((float) $operation->transaction_amount, 2) . ($unitLabel !== '' ? " {$unitLabel}" : '')
            : '—';

        $methodDetails = match ($operation->operation_method) {
            'court_judgment' => 'حكم محكمة' . (filled($operation->case_number) ? " — رقم الأساس: {$operation->case_number}" : ''),
            'regular_contract' => 'عقد عادي' . (filled($operation->contract_number) ? " — رقم العقد: {$operation->contract_number}" : ''),
            default => '—',
        };

        $oldOwners = $operation->oldOwners->pluck('owner_name')->filter()->join('، ');
        $newOwners = $operation->newOwners->pluck('owner_name')->filter()->join('، ');
        $witnesses = $operation->witnesses->pluck('witness_name')->filter()->join('، ');

        return sprintf(
            'نوع العملية: %s | مقدار التصرّف: %s | طريقة العملية: %s | رقم القرار: %s | المرجع/الجهة: %s | تاريخ الحكم: %s | ملاحظات الحكم: %s | تاريخ العقد: %s | ملاحظات العقد: %s | المالكون السابقون: %s | المالكون الجدد: %s | الشهود: %s',
            $typeLabel,
            $amount,
            $methodDetails,
            $operation->decision_number ?: '—',
            $operation->authority ?: '—',
            $operation->judgment_date?->format('d/m/Y') ?: '—',
            $operation->judgment_notes ?: '—',
            $operation->contract_date?->format('d/m/Y') ?: '—',
            $operation->contract_notes ?: '—',
            $oldOwners !== '' ? $oldOwners : '—',
            $newOwners !== '' ? $newOwners : '—',
            $witnesses !== '' ? $witnesses : '—',
        );
    }
}