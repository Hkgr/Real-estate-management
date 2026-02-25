<?php

namespace App\Filament\Pages;

use App\Models\PropertyCard;
use App\Models\PropertyOperation;
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
            ->query(PropertyCard::query()->with('operations')->latest('id'))
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
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50]);
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
