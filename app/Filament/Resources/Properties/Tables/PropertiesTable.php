<?php

namespace App\Filament\Resources\Properties\Tables;

use App\Filament\Resources\Properties\PropertyResource;
use App\Models\Property;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PropertiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('region_name')
                    ->label('المنطقة')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('cadastral_zone_number')
                    ->label('رقم المنطقة العقارية')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('property_number')
                    ->label('رقم العقار')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('total_area')
                    ->label('المساحة الكلية')
                    ->numeric(decimalPlaces: 2)
                    ->suffix(' م²')
                    ->sortable(),

                TextColumn::make('owned_area')
                    ->label('المساحة المملوكة')
                    ->numeric(decimalPlaces: 2)
                    ->suffix(' م²')
                    ->sortable(),

                TextColumn::make('ownership_percentage')
                    ->label('نسبة الملكية')
                    ->numeric(decimalPlaces: 2)
                    ->suffix(' %')
                    ->sortable(),

                TextColumn::make('purchase_date')
                    ->label('تاريخ الشراء')
                    ->date('Y-m-d')
                    ->sortable(),

                TextColumn::make('location')
                    ->label('الموقع')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                // عرض بصفحة مستقلة (التي سننشئها بالأسفل)


Action::make('view')
    ->label('عرض')
    ->icon('heroicon-o-eye')
    ->color('gray')
    ->url(fn (Property $record) => PropertyResource::getUrl('view', ['record' => $record])),


                EditAction::make()->label('تعديل'),

                DeleteAction::make()->label('حذف'),
                RestoreAction::make()->label('استعادة'),
                ForceDeleteAction::make()->label('حذف نهائي'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('حذف جماعي'),
                    RestoreBulkAction::make()->label('استعادة جماعية'),
                    ForceDeleteBulkAction::make()->label('حذف نهائي جماعي'),
                ]),
            ]);
    }
}
