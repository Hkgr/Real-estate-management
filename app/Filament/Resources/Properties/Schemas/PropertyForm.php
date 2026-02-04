<?php

namespace App\Filament\Resources\Properties\Schemas;


use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات العقار')
                    ->schema([
                        TextInput::make('region_name')
                            ->label('اسم المنطقة')
                            ->required()
                            ->maxLength(150),

                        TextInput::make('cadastral_zone_number')
                            ->label('رقم المنطقة العقارية')
                            ->required()
                            ->maxLength(50),

                        TextInput::make('property_number')
                            ->label('رقم العقار')
                            ->required()
                            ->maxLength(50),

                        TextInput::make('total_area')
                            ->label('مساحة العقار الكلية')
                            ->numeric()
                            ->required()
                            ->suffix('م²'),

                        TextInput::make('owned_area')
                            ->label('المساحة المملوكة')
                            ->numeric()
                            ->required()
                            ->suffix('م²'),

                        DatePicker::make('purchase_date')
                            ->label('تاريخ الشراء')
                            ->nullable(),

                        TextInput::make('ownership_percentage')
                            ->label('نسبة الملكية')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%'),

                        Textarea::make('location')
                            ->label('موقع العقار')
                            ->rows(3)
                            ->placeholder('مثال: رابط Google Maps أو وصف مختصر للموقع')
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->columnSpanFull(),
                    
                Repeater::make('المالكون')
                    ->schema([
                        Select::make('owners')
                            ->label('المالكون')
                            ->relationship('owners')
                            ->schema([
                                Select::make('owner_id')
                                    ->label('المالك')
                                    ->relationship('owner', 'display_name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                TextInput::make('ownership_percentage')
                                    ->label('نسبة التملك')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->suffix('%'),
                                TextInput::make('ownership_metric')
                                    ->label('معيار التملك')
                                    ->required(),
                                Toggle::make('is_current')
                                    ->label('مالك حالي')
                                    ->default(true),
                                DatePicker::make('purchase_date')
                                    ->label('تاريخ الشراء')
                                    ->nullable(),
                                DatePicker::make('sale_date')
                                    ->label('تاريخ البيع')
                                    ->visible(fn (Get $get) => ! $get('is_current'))
                                    ->nullable(),
                            ])
                            ->columns([
                                'default' => 1,
                                'md' => 2,
                            ]),

                    ])
                    ->columnSpanFull(),

            ])
            ->columns(1);
    }
}
