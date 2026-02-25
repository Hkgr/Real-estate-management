<?php

namespace App\Filament\Resources\Signals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SignalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('signal_id')
                    ->searchable(),
                TextColumn::make('signal_year')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('property.display_name')
                    ->label('العقار')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('signal_owners_label')
                    ->label('أصحاب الإشارة'),
                TextColumn::make('signal_source')
                    ->searchable(),
                TextColumn::make('signal_source_number')
                    ->label('رقم الجهة')
                    ->searchable(),
                TextColumn::make('signal_source_date')
                    ->label('تاريخ الجهة')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('signal_victims_label')
                    ->label('المتضرّرون')
                    ->searchable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
