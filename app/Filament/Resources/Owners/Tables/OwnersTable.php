<?php

namespace App\Filament\Resources\Owners\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class OwnersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('display_name')
                    ->label('اسم المالك')
                    ->searchable(['full_name', 'company_name'])
                    ->sortable(query: fn ($query, string $direction): mixed => $query->orderByRaw(
                        "coalesce(company_name, full_name) {$direction}"
                    )),

                TextColumn::make('owner_type')
                    ->label('النوع')
                    ->toggleable(),

                TextColumn::make('commercial_register_number')
                    ->label('رقم السجل التجاري')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('national_id')
                    ->label('الرقم الوطني')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('الهاتف')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('email')
                    ->label('البريد')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_active')
                    ->label('فعّال')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()->label('عرض'),
                EditAction::make()->label('تعديل'),
                DeleteAction::make()->label('حذف'),
                RestoreAction::make()->label('استعادة'),
                ForceDeleteAction::make()->label('حذف نهائي'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
