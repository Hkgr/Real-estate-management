<?php

namespace App\Filament\Pages;

use App\Models\PropertyCard;
use App\Models\PropertyCardFile;
use App\Models\PropertyInstallment;
use App\Models\PropertyOperation;
use App\Models\Signal;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class PropertyCardsTablePage2 extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $title = 'بطاقات العقار 2';
    protected static ?string $navigationLabel = 'بطاقات العقار 2';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-table-cells';
    protected static ?string $slug = 'property-cards-2';

    protected string $view = 'filament.pages.property-cards-table-page-2';

    public function table(Table $table): Table
    {
        return $table
            ->query(PropertyCard::query()->with(['operations', 'signals', 'files', 'installments'])->latest('id'))
            ->columns([
                                TextColumn::make('row_number')
                    ->label('تسلسل')
                    ->state(function (mixed $record, mixed $rowLoop, HasTable $livewire): int {
                        $currentPage = (int) ($livewire->getTablePage() ?? 1);
                        $perPage = (int) ($livewire->getTableRecordsPerPage() ?? 10);

                        return (($currentPage - 1) * $perPage) + $rowLoop->iteration;
                    }),

                TextColumn::make('id')
                    ->label('#')
                    ->sortable(),
                TextColumn::make('card_record_number')
                    ->label('المحضر')
                    ->searchable(),
                TextColumn::make('card_governorate')
                    ->label('المحافظة')
                    ->searchable(),
                TextColumn::make('card_region_name')
                    ->label('المنطقة العقارية')
                    ->searchable(),
                TextColumn::make('card_subdivision')
                    ->label('المقسم')
                    ->toggleable(),
                TextColumn::make('card_total_area')
                    ->label('مساحة العقار الكلية')
                    ->formatStateUsing(fn ($state): string => filled($state) ? number_format((float) $state, 2) : '—'),
                TextColumn::make('card_google_maps_url')
                    ->label('رابط موقع العقار')
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? $state : '—')
                    ->url(fn (?string $state): ?string => filled($state) ? $state : null, shouldOpenInNewTab: true)
                    ->limit(30)
                    ->tooltip(fn (?string $state): ?string => filled($state) ? $state : null),
                TextColumn::make('card_property_details')
                    ->label('بيانات تفصيلية')
                    ->wrap()
                    ->limit(60)
                    ->tooltip(fn (?string $state): ?string => filled($state) ? $state : null),
                TextColumn::make('operations_summary')
                    ->label('العمليات')
                    ->html()
                    ->state(function (PropertyCard $record): HtmlString {
                        if ($record->operations->isEmpty()) {
                            return new HtmlString('<span class="text-gray-500">—</span>');
                        }

                        $rows = $record->operations
                            ->map(fn (PropertyOperation $operation): string => $this->formatOperationRow($operation))
                            ->implode('');

                        return new HtmlString('<div class="min-w-[24rem] space-y-2">' . $rows . '</div>');
                    }),
                TextColumn::make('signals_summary')
                    ->label('الإشارات')
                    ->html()
                    ->state(function (PropertyCard $record): HtmlString {
                        if ($record->signals->isEmpty()) {
                            return new HtmlString('<span class="text-gray-500">—</span>');
                        }

                        $rows = $record->signals
                            ->map(fn (Signal $signal): string => $this->formatSignalRow($signal))
                            ->implode('');

                        return new HtmlString('<div class="min-w-[20rem] space-y-2">' . $rows . '</div>');
                    }),
                TextColumn::make('files_summary')
                    ->label('ملحقات البطاقة')
                    ->html()
                    ->state(function (PropertyCard $record): HtmlString {
                        if ($record->files->isEmpty()) {
                            return new HtmlString('<span class="text-gray-500">—</span>');
                        }

                        $rows = $record->files
                            ->map(fn (PropertyCardFile $file): string => $this->formatFileRow($file))
                            ->implode('');

                        return new HtmlString('<ul class="min-w-[18rem] list-disc space-y-1 pr-4">' . $rows . '</ul>');
                    }),
                TextColumn::make('installments_summary')
                    ->label('الدفعات')
                    ->html()
                    ->state(function (PropertyCard $record): HtmlString {
                        if ($record->installments->isEmpty()) {
                            return new HtmlString('<span class="text-gray-500">—</span>');
                        }

                        $rows = $record->installments
                            ->map(fn (PropertyInstallment $installment): string => $this->formatInstallmentRow($installment))
                            ->implode('');

                        return new HtmlString('<div class="min-w-[20rem] space-y-2">' . $rows . '</div>');
                    }),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50]);
    }

    protected function formatSignalRow(Signal $signal): string
    {
        $signalNumber = e($signal->signal_id ?: '—');
        $signalType = e($signal->type ?: '—');
        $signalDate = e($signal->signal_date?->format('Y-m-d') ?: '—');

        return <<<HTML
<div class="rounded-md border border-gray-200 bg-gray-50 p-2 text-right leading-6">
    <div><span class="font-semibold">رقم الإشارة:</span> {$signalNumber}</div>
    <div><span class="font-semibold">النوع:</span> {$signalType}</div>
    <div><span class="font-semibold">التاريخ:</span> {$signalDate}</div>
</div>
HTML;
    }

    protected function formatFileRow(PropertyCardFile $file): string
    {
        $name = e($file->file_name ?: '—');
        $downloadUrl = e(route('property-card-files.download', $file));

        return <<<HTML
<li>
    <a href="{$downloadUrl}" class="text-primary-600 hover:underline" download>{$name}</a>
</li>
HTML;
    }

    protected function formatInstallmentRow(PropertyInstallment $installment): string
    {
        $amount = e(number_format((float) ($installment->amount ?? 0), 2));
        $date = e($installment->payment_date?->format('Y-m-d') ?: '—');
        $remaining = e(number_format((float) ($installment->remaining_after_payment ?? 0), 2));

        return <<<HTML
<div class="rounded-md border border-gray-200 bg-gray-50 p-2 text-right leading-6">
    <div><span class="font-semibold">المبلغ:</span> {$amount}</div>
    <div><span class="font-semibold">التاريخ:</span> {$date}</div>
    <div><span class="font-semibold">المتبقي:</span> {$remaining}</div>
</div>
HTML;
    }

    protected function formatOperationRow(PropertyOperation $operation): string
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

        $type = e($typeLabel);
        $amountText = e($amount);
        $methodText = e($methodDetails);

        return <<<HTML
<div class="rounded-md border border-gray-200 bg-gray-50 p-2 text-right leading-6">
    <div><span class="font-semibold">نوع العملية:</span> {$type}</div>
    <div><span class="font-semibold">مقدار التصرّف:</span> {$amountText}</div>
    <div><span class="font-semibold">طريقة العملية:</span> {$methodText}</div>
</div>
HTML;
    }
}
