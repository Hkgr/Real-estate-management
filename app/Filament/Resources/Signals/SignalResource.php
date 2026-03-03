<?php

namespace App\Filament\Resources\Signals;

use App\Filament\Concerns\ReadOnlyOnViewerPanel;
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
use Illuminate\Database\Eloquent\Builder;

class SignalResource extends Resource
{
    use ReadOnlyOnViewerPanel;


    protected static ?string $title = 'بطاقة الإشارة';
    protected static ?string $navigationLabel = 'بطاقة الإشارة (جديدة)';
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $slug = 'signal-card';


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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['creator', 'updater']);
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
