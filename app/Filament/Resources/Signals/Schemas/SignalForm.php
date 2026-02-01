<?php

namespace App\Filament\Resources\Signals\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SignalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('property_id')
                    ->label('العقار')
                    ->relationship('property', 'display_name')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                TextInput::make('signal_id')
                    ->required(),
                TextInput::make('signal_year')
                    ->required(),
                Select::make('type')
                    ->options([
            'حجز' => 'حجز',
            'دعوة' => 'دعوة',
            'استيفاء رسوم' => 'استيفاءرسوم',
            'إنذار' => 'إنذار',
            'استملاك' => 'استملاك',
        ])
                    ->required(),
                TextInput::make('signal_owner')
                    ->default(null),
                TextInput::make('signal_source')
                    ->default(null),
                TextInput::make('signal_victim')
                    ->default(null),
            ]);
    }
}
