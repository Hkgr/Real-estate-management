<?php

namespace App\Filament\Resources\Signals;

use App\Filament\Resources\Signals\Pages\CreateSignal;
use App\Filament\Resources\Signals\Pages\EditSignal;
use App\Filament\Resources\Signals\Pages\ListSignals;
use App\Filament\Resources\Signals\Pages\ViewSignal;
use App\Filament\Resources\Signals\Schemas\SignalForm;
use App\Filament\Resources\Signals\Schemas\SignalInfolist;
use App\Filament\Resources\Signals\Tables\SignalsTable;
use App\Models\Signal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SignalResource extends Resource
{
    protected static ?string $model = Signal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'signal';

    public static function form(Schema $schema): Schema
    {
        return SignalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SignalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SignalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSignals::route('/'),
            'create' => CreateSignal::route('/create'),
            'view' => ViewSignal::route('/{record}'),
            'edit' => EditSignal::route('/{record}/edit'),
        ];
    }
}
