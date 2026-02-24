<?php

namespace App\Filament\Pages;

use App\Models\PropertyCard;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

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
            ->query(PropertyCard::query()->latest('id'))
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
                    ->label('رقم المحضر')
                    ->searchable(),
                TextColumn::make('card_governorate')
                    ->label('المحافظة')
                    ->searchable(),
                TextColumn::make('card_region_name')
                    ->label('المنطقة')
                    ->searchable(),
                TextColumn::make('card_subdivision')
                    ->label('المقسم')
                    ->toggleable(),
                TextColumn::make('card_status')
                    ->label('الحالة')
                    ->badge(),
                TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->since(),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50]);
    }
}
