<?php

namespace App\Filament\Resources\Signals\Schemas;

use App\Models\Signal;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SignalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('signal_id'),
                TextEntry::make('signal_year'),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('property.display_name')
                    ->label('العقار')
                    ->placeholder('-'),

                TextEntry::make('signal_owners_label')
                    ->label('أصحاب الإشارة')
                    ->placeholder('-'),
                TextEntry::make('signal_source')
                    ->placeholder('-'),
                TextEntry::make('signal_source_number')
                    ->label('رقم الجهة')
                    ->placeholder('-'),
                TextEntry::make('signal_source_date')
                    ->label('تاريخ الجهة')
                    ->date('d/m/Y')
                    ->placeholder('-'),
                TextEntry::make('signal_victims_label')
                    ->label('المتضرّرون')
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Signal $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
