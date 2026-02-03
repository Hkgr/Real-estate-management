<?php

namespace App\Filament\Resources\Signals\Schemas;

use App\Models\Owner;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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
                Select::make('owners')
                    ->label('المالكون')
                    ->relationship('owners', 'full_name')
                    ->searchable()
                    ->preload()
                    ->multiple(),

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
                Repeater::make('signal_owners')
                    ->label('أصحاب الإشارة')
                    ->schema([
                        Toggle::make('owner_from_owner')
                            ->label('من المالكين')
                            ->default(true)
                            ->live(),

                        Select::make('owner_id')
                            ->label('المالك')
                            ->native(false)
                            ->searchable()
                            ->options(fn () => Owner::query()->orderBy('full_name')->pluck('full_name', 'id')->all())
                            ->visible(fn ($get) => (bool) $get('owner_from_owner'))
                            ->placeholder('اختر مالكًا'),

                        TextInput::make('owner_name')
                            ->label('اسم المالك')
                            ->maxLength(150)
                            ->nullable()
                            ->live(onBlur: true)
                            ->visible(fn ($get) => ! (bool) $get('owner_from_owner'))
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                            ->placeholder('اسم المالك إن وُجد'),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->defaultItems(0)
                    ->afterStateHydrated(function ($state, $set, $get): void {
                        if (is_array($state) && count($state) > 0) {
                            $set('signal_owners', collect($state)->map(function (array $item): array {
                                return [
                                    'owner_from_owner' => (bool) ($item['is_owner'] ?? false),
                                    'owner_id' => $item['owner_id'] ?? null,
                                    'owner_name' => $item['name'] ?? null,
                                ];
                            })->all());
                            return;
                        }

                        $legacyOwner = $get('signal_owner');
                        if (filled($legacyOwner)) {
                            $set('signal_owners', [[
                                'owner_from_owner' => false,
                                'owner_id' => null,
                                'owner_name' => $legacyOwner,
                            ]]);
                        }
                    })
                    ->dehydrateStateUsing(function ($state, $get): array {
                        return collect($state ?? [])
                            ->map(function (array $row) use ($get): ?array {
                                $fromOwner = (bool) ($row['owner_from_owner'] ?? false);
                                $ownerId = $row['owner_id'] ?? null;
                                $name = $fromOwner
                                    ? Owner::query()->whereKey($ownerId)->value('full_name')
                                    : ($row['owner_name'] ?? null);

                                if ($fromOwner && ! filled($ownerId)) {
                                    return null;
                                }

                                if (! $fromOwner && ! filled($name)) {
                                    return null;
                                }

                                return [
                                    'is_owner' => $fromOwner,
                                    'owner_id' => $fromOwner ? $ownerId : null,
                                    'name' => filled($name) ? $name : null,
                                ];
                            })
                            ->filter()
                            ->values()
                            ->all();
                    }),
                TextInput::make('signal_source')
                    ->default(null),
                Repeater::make('signal_victims')
                    ->label('المتضرّرون')
                    ->schema([
                        Toggle::make('victim_from_owner')
                            ->label('من المالكين')
                            ->default(true)
                            ->live(),

                        Select::make('victim_owner_id')
                            ->label('المالك')
                            ->native(false)
                            ->searchable()
                            ->options(fn () => Owner::query()->orderBy('full_name')->pluck('full_name', 'id')->all())
                            ->visible(fn ($get) => (bool) $get('victim_from_owner'))
                            ->placeholder('اختر متضرّرًا'),

                        TextInput::make('victim_name')
                            ->label('اسم المتضرّر')
                            ->maxLength(150)
                            ->nullable()
                            ->live(onBlur: true)
                            ->visible(fn ($get) => ! (bool) $get('victim_from_owner'))
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                            ->placeholder('اسم المتضرّر إن وُجد'),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->defaultItems(0)
                    ->afterStateHydrated(function ($state, $set, $get): void {
                        if (is_array($state) && count($state) > 0) {
                            $set('signal_victims', collect($state)->map(function (array $item): array {
                                return [
                                    'victim_from_owner' => (bool) ($item['is_owner'] ?? false),
                                    'victim_owner_id' => $item['owner_id'] ?? null,
                                    'victim_name' => $item['name'] ?? null,
                                ];
                            })->all());
                            return;
                        }

                        $legacyVictim = $get('signal_victim');
                        if (filled($legacyVictim)) {
                            $set('signal_victims', [[
                                'victim_from_owner' => false,
                                'victim_owner_id' => null,
                                'victim_name' => $legacyVictim,
                            ]]);
                        }
                    })
                    ->dehydrateStateUsing(function ($state): array {
                        return collect($state ?? [])
                            ->map(function (array $row): ?array {
                                $fromOwner = (bool) ($row['victim_from_owner'] ?? false);
                                $ownerId = $row['victim_owner_id'] ?? null;
                                $name = $fromOwner
                                    ? Owner::query()->whereKey($ownerId)->value('full_name')
                                    : ($row['victim_name'] ?? null);

                                if ($fromOwner && ! filled($ownerId)) {
                                    return null;
                                }

                                if (! $fromOwner && ! filled($name)) {
                                    return null;
                                }

                                return [
                                    'is_owner' => $fromOwner,
                                    'owner_id' => $fromOwner ? $ownerId : null,
                                    'name' => filled($name) ? $name : null,
                                ];
                            })
                            ->filter()
                            ->values()
                            ->all();
                    }),
            ]);
    }
}
