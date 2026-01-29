<?php

namespace App\Filament\Resources\ReservationNotices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReservationNoticeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الإشارة')
                    ->schema([
                        TextInput::make('notice_number')
                            ->label('رقم الإشارة')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true),

                        DatePicker::make('notice_date')
                            ->label('تاريخ الإشارة')
                            ->required(),

                        TextInput::make('property_number')
                            ->label('رقم العقار')
                            ->required()
                            ->maxLength(50),

                        Select::make('status')
                            ->label('الحالة')
                            ->options([
                                'active' => 'فعّالة',
                                'released' => 'مفكوكة',
                                'canceled' => 'ملغاة',
                            ])
                            ->native(false)
                            ->required()
                            ->default('active'),

                        DatePicker::make('release_date')
                            ->label('تاريخ فك الحجز')
                            ->nullable(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->columnSpanFull(),

                Section::make('تفاصيل إضافية')
                    ->schema([
                        TextInput::make('issued_by')
                            ->label('الجهة المُصدِرة')
                            ->maxLength(150)
                            ->nullable(),

                        TextInput::make('party_name')
                            ->label('صاحب العلاقة')
                            ->maxLength(150)
                            ->nullable(),

                        Textarea::make('reason')
                            ->label('السبب/الوصف')
                            ->rows(3)
                            ->nullable()
                            ->columnSpanFull(),

                        Textarea::make('notes')
                            ->label('ملاحظات')
                            ->rows(3)
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
