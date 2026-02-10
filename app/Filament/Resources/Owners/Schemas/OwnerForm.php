<?php

namespace App\Filament\Resources\Owners\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Get;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OwnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('البيانات الأساسية')
                    ->schema([
                        Select::make('owner_type')
                            ->label('نوع المالك')
                            ->options([
                                'individual' => 'فرد',
                                'company' => 'شركة',
                            ])
                            ->native(false)
                            ->required()
                            ->default('individual')
                            ->live(),

                        TextInput::make('full_name')
                            ->label('اسم المالك (للفرد) أو اسم المفوض')
                            ->required()
                            ->maxLength(200)
                            ->columnSpanFull(),

                        TextInput::make('company_name')
                            ->label('اسم الشركة')
                            ->maxLength(200)
                            ->nullable()
                            ->visible(fn (Get $get) => $get('owner_type') === 'company')
                            ->required(fn (Get $get) => $get('owner_type') === 'company')
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                        TextInput::make('commercial_register_number')
                            ->label('رقم السجل التجاري')
                            ->maxLength(100)
                            ->nullable()
                            ->visible(fn (Get $get) => $get('owner_type') === 'company')
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                        DatePicker::make('birth_date')
                            ->label('تاريخ الميلاد')
                            ->nullable()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                        TextInput::make('national_id')
                            ->label('الرقم الوطني')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true),

                        TextInput::make('phone')
                            ->label('رقم الهاتف')
                            ->tel()
                            ->maxLength(50)
                          ->nullable()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                        TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->maxLength(150)
                            ->nullable()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                        Toggle::make('is_active')
                            ->label('فعّال')
                            ->default(true),
                    ])
                    ->columns(['default' => 1, 'md' => 2])
                    ->columnSpanFull(),

                Section::make('العقارات المملوكة')
                    ->schema([
                        Select::make('properties')
                            ->label('العقارات')
                            ->relationship('properties', 'property_number')
                            ->searchable()
                            ->preload()
                            ->multiple(),
                    ])
                    ->columnSpanFull(),

                    Section::make('العنوان والملاحظات')
                    ->schema([
                        Textarea::make('address')
                            ->label('العنوان')
                            ->rows(3)
                            ->nullable()
                                                        ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                            ->columnSpanFull(),

                        Textarea::make('notes')
                            ->label('ملاحظات')
                            ->rows(3)
                            ->nullable()
                                                        ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
