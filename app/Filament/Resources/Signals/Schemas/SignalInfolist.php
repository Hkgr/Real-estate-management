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
                TextEntry::make('signal_owner')
                    ->placeholder('-'),
                TextEntry::make('signal_source')
                    ->placeholder('-'),
                TextEntry::make('signal_victim')
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
