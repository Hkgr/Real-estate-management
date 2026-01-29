<?php
// app/Filament/Resources/Properties/Pages/ListProperties.php

namespace App\Filament\Resources\Properties\Pages;

use App\Filament\Resources\Properties\PropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProperties extends ListRecords
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('editByNumber')
                ->label('تعديل العقار')
                ->icon('heroicon-o-magnifying-glass')
                ->color('gray')
                ->url(PropertyResource::getUrl('edit-by-number')),
        ];
    }
}
