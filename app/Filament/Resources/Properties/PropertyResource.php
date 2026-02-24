<?php

namespace App\Filament\Resources\Properties;

use App\Filament\Concerns\ReadOnlyOnViewerPanel;
use App\Filament\Resources\Properties\Pages\CreateProperty;
use App\Filament\Resources\Properties\Pages\EditProperty;
use App\Filament\Resources\Properties\Pages\ListProperties;
use App\Filament\Resources\Properties\Schemas\PropertyForm;
use App\Filament\Resources\Properties\Tables\PropertiesTable;
use App\Models\Property;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class PropertyResource extends Resource
{
    use ReadOnlyOnViewerPanel;

protected static ?string $model = Property::class;

protected static ?string $navigationLabel = 'إدارة العقارات';
protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';
protected static ?int $navigationSort = 10;
protected static ?string $modelLabel = 'عقار';
protected static ?string $pluralModelLabel = 'العقارات';

protected static ?string $recordTitleAttribute = 'property_number';




    public static function form(Schema $schema): Schema
    {
        return PropertyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PropertiesTable::configure($table);
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
        'index' => Pages\ListProperties::route('/'),
        'create' => Pages\CreateProperty::route('/create'),
        'edit' => Pages\EditProperty::route('/{record}/edit'),

        'edit-by-number' => Pages\EditPropertyByNumber::route('/edit-by-number'),

        // NEW:
        'view' => Pages\ViewProperty::route('/{record}/view'),
    ];
}

public static function infolist(Schema $schema): Schema
{
    return $schema->components([
        Section::make('التعريف')
            ->columns(['default' => 1, 'md' => 3])
            ->schema([
                TextEntry::make('region_name')->label('اسم المنطقة'),
                TextEntry::make('cadastral_zone_number')->label('رقم المنطقة العقارية'),
                TextEntry::make('property_number')->label('رقم العقار'),
            ])
            ->columnSpanFull(),

        Section::make('المساحات والملكية')
            ->columns(['default' => 1, 'md' => 4])
            ->schema([
                TextEntry::make('total_area')->label('مساحة العقار الكلية')->numeric(decimalPlaces: 2)->suffix(' م²'),
                TextEntry::make('owned_area')->label('المساحة المملوكة')->numeric(decimalPlaces: 2)->suffix(' م²'),
                TextEntry::make('ownership_percentage')->label('نسبة الملكية')->numeric(decimalPlaces: 2)->suffix(' %'),
                TextEntry::make('purchase_date')->label('تاريخ الشراء')->date('Y-m-d'),
            ])
            ->columnSpanFull(),

        Section::make('الموقع')
            ->columns(['default' => 1, 'md' => 2])
            ->schema([
                TextEntry::make('location')->label('موقع العقار')->columnSpanFull(),
                TextEntry::make('latitude')->label('Latitude')->numeric(decimalPlaces: 7),
                TextEntry::make('longitude')->label('Longitude')->numeric(decimalPlaces: 7),
            ])
            ->columnSpanFull(),
                    Section::make('المالكون')
            ->columns(['default' => 1, 'md' => 2])
            ->schema([
                TextEntry::make('owners')
                    ->label('المالكون (بيانات الملكية)')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->owners->map(function ($owner) {
                            $pivot = $owner->pivot;
                            $ownershipPercentage = $pivot?->ownership_percentage;
                            $ownershipMetric = $pivot?->ownership_metric;
                            $isCurrent = $pivot?->is_current;
                            $purchaseDate = $pivot?->purchase_date;
                            $saleDate = $pivot?->sale_date;

                            $ownershipPercentageText = $ownershipPercentage !== null
                                ? number_format((float) $ownershipPercentage, 2) . '%'
                                : '—';

                            $ownershipMetricText = $ownershipMetric ?: '—';
                            $ownerStatusText = $isCurrent === null ? '—' : ($isCurrent ? 'حالي' : 'سابق');
                            $purchaseDateText = $purchaseDate ? $purchaseDate->format('Y-m-d') : '—';
                            $saleDateText = $saleDate ? $saleDate->format('Y-m-d') : '—';

                            return sprintf(
                                '%s — نسبة التملك: %s | معيار التملك: %s | حالة المالك: %s | شراء: %s | بيع: %s',
                                $owner->display_name,
                                $ownershipPercentageText,
                                $ownershipMetricText,
                                $ownerStatusText,
                                $purchaseDateText,
                                $saleDateText
                            );
                        })->all();
                    })

                    ->listWithLineBreaks()
                    ->placeholder('—'),
            ])
            ->columnSpanFull(),

    ]);
}


    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
