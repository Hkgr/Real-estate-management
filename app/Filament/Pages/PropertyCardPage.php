<?php

namespace App\Filament\Pages;

use App\Models\Owner;
use App\Models\PropertyCard;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid as FormGrid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Spatie\Browsershot\Browsershot;
use UnitEnum;

class PropertyCardPage extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static ?string $title = 'بطاقة العقار';
    protected static ?string $navigationLabel = 'بطاقة العقار (جديدة)';
    protected static UnitEnum|string|null $navigationGroup = 'العقارات';
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $slug = 'property-card';

    public ?int $currentRecordId = null;

    public array $data = [];

    public function getView(): string
    {
        return 'filament.pages.property-card-page';
    }

    public function mount(): void
    {
        $this->resetCardForm();
    }

    /**
     * تحقق لطيف عند الخروج من الحقول (onBlur) بدون كسر التجربة.
     */
    public function updated(string $propertyName): void
    {
        if (! str_starts_with($propertyName, 'data.')) {
            return;
        }

        try {
            $this->form->validate();
        } catch (ValidationException) {
            // Filament/Livewire سيعرض الأخطاء في الـ error bag.
        }
    }

    // =========================
    // Form
    // =========================

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('المفتاح (اكتب وسيتم البحث تلقائياً)')
                    ->description('عند إدخال الرقمين والخروج من الحقل سيتم تحميل بيانات العقار إن وُجد.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('card_cadastral_zone_number')
                                ->label('رقم المنطقة العقارية')
                                ->maxLength(50)
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn () => $this->tryAutoSearch())
                                ->placeholder('مثال: 12A'),

                            TextInput::make('card_property_number')
                                ->label('رقم العقار')
                                ->maxLength(50)
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn () => $this->tryAutoSearch())
                                ->placeholder('مثال: 105'),
                        ]),
                    ]),

                Section::make('البيانات الأساسية')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('card_governorate')
                                ->label('المحافظة')
                                ->maxLength(100)
                                ->required()
                                ->live(onBlur: true)
                                ->placeholder('مثال: حلب'),

                            TextInput::make('card_region_name')
                                ->label('اسم المنطقة')
                                ->maxLength(255)
                                ->required()
                                ->live(onBlur: true)
                                ->placeholder('مثال: الحمدانية'),

                            TextInput::make('card_subdivision')
                                ->label('المقسم')
                                ->maxLength(100)
                                ->live(onBlur: true)
                                ->nullable()
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                ->placeholder('مثال: المقسم 22'),

                            Select::make('card_status')
                                ->label('حالة العقار')
                                ->native(false)
                                ->options([
                                    'active' => 'فاعل',
                                    'frozen' => 'مجمد',
                                ])
                                ->required()
                                ->live(onBlur: true),
                        ]),

                        Grid::make(1)->schema([
                           TextInput::make('card_google_maps_url')
                                ->label('رابط خريطة Google')
                                ->url()
                                ->maxLength(2048)
                                ->nullable()
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                ->helperText('ألصق رابط الموقع من Google Maps لمساعدتنا في الوصول بدقة.')
                                ->placeholder('https://maps.google.com/?q=...'),
                        ]),

                        Textarea::make('card_property_details')
                            ->label('تفصيل العقار')
                            ->rows(3)
                            ->nullable()
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                            ->placeholder('اختياري'),
                    ]),

                Section::make('المساحات والملكية')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('card_area_unit')
                                ->label('وحدة المساحة')
                                ->native(false)
                                ->options([
                                    'percentage' => 'نسبة مئوية (%)',
                                    'shares' => 'عدد الأسهم',
                                    'meters' => 'عدد الأمتار (م²)',
                                ])
                                ->default('meters')
                                ->required()
                                ->live(onBlur: true),

                            TextInput::make('card_total_area')
                                ->label('مساحة العقار الكلية')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(9999999999.99)
                                ->required()
                                ->live(onBlur: true)
                                ->suffix(fn (Get $get) => match ($get('card_area_unit')) {
                                    'percentage' => '%',
                                    'shares' => 'سهم',
                                    'meters' => 'م²',
                                    default => null,
                                })
                                ->placeholder('مثال: 400'),
                        ]),
                    ]),

                /**
                 * ✅ مهم:
                 * إذا كنت تعمل بعلاقة M:N مع حقول Pivot (نسبة/معيار/تواريخ...) فلا تستخدم relationship('owners') مباشرة.
                 * استخدم Pivot Model + HasMany مثل: ownerships()
                 * (PropertyCardOwner) + العلاقة owner() داخل Pivot.
                 */
                Section::make('الملاك')
                    ->schema([
                        Repeater::make('ownerships')
                            ->label('الملاك')
                            ->relationship('ownerships') // HasMany على Pivot Model: PropertyCardOwner
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('owner_id')
                                            ->label('المالك')
                                            ->relationship('owner', 'full_name') // belongsTo داخل Pivot
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                TextInput::make('full_name')
                                                    ->label('الاسم الرباعي')
                                                    ->required()
                                                    ->maxLength(200)
                                                    ->live(onBlur: true)
                                                    ->columnSpanFull(),

                                                DatePicker::make('birth_date')
                                                    ->label('تاريخ الميلاد')
                                                    ->nullable()
                                                    ->live(onBlur: true)
                                                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                                                TextInput::make('national_id')
                                                    ->label('الرقم الوطني')
                                                    ->required()
                                                    ->maxLength(50)
                                                    ->live(onBlur: true)
                                                    ->unique(Owner::class, 'national_id'),

                                                TextInput::make('phone')
                                                    ->label('رقم الهاتف')
                                                    ->tel()
                                                    ->maxLength(50)
                                                    ->nullable()
                                                    ->live(onBlur: true)
                                                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                                                TextInput::make('email')
                                                    ->label('البريد الإلكتروني')
                                                    ->email()
                                                    ->maxLength(150)
                                                    ->nullable()
                                                    ->live(onBlur: true)
                                                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                                                Toggle::make('is_active')
                                                    ->label('فعّال')
                                                    ->default(false)
                                                    ->live(),

                                            ])
                                            ->createOptionUsing(fn (array $data): int => Owner::create($data)->id)
                                            ->required(),

                                        Select::make('ownership_metric')
                                            ->label('معيار التملك')
                                            ->native(false)
                                            ->options([
                                                'percentage' => 'نسبة مئوية (%)',
                                                'shares' => 'عدد الأسهم',
                                                'meters' => 'عدد الأمتار (م²)',
                                            ])
                                            ->required()
                                            ->live(onBlur: true),

                                        TextInput::make('ownership_percentage')
                                            ->label('قيمة التملك')
                                            ->numeric()
                                            ->minValue(0)
                                            ->maxValue(fn (Get $get) => $get('ownership_metric') === 'percentage' ? 100 : 9999999999.99)
                                            ->required()
                                            ->live(onBlur: true)
                                            ->suffix(fn (Get $get) => match ($get('ownership_metric')) {
                                                'percentage' => '%',
                                                'shares' => 'سهم',
                                                'meters' => 'م²',
                                                default => null,
                                            }),

                                        Toggle::make('is_current')
                                            ->label('مالك حالي')
                                            ->default(false)
                                            ->live(),

                                        DatePicker::make('purchase_date')
                                            ->label('تاريخ الشراء')
                                            ->nullable()
                                            ->live(onBlur: true),

                                        DatePicker::make('sale_date')
                                            ->label('تاريخ البيع')
                                            ->nullable()
                                            ->live(onBlur: true)
                                            ->visible(fn (Get $get) => ! (bool) $get('is_current')),

                                        Select::make('purchase_method')
                                            ->label('طريقة الشراء')
                                            ->native(false)
                                            ->options([
                                                'sale_contract' => 'عقد بيع',
                                                'court_judgment' => 'حكم قضائي',
                                            ])
                                            ->nullable()
                                            ->live(onBlur: true),
                                    ]),
                            ]),
                    ]),
                Section::make('الإشارات')
                    ->schema([
                        Repeater::make('signals')
                            ->label('الإشارات')
                            ->relationship('signals')
                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                                if (isset($data['signal_owners'])) {
                                    $data['signal_owners'] = collect($data['signal_owners'])
                                        ->map(fn (array $item): array => Arr::only($item, ['is_owner', 'owner_id', 'name']))
                                        ->values()
                                        ->all();
                                }

                                if (isset($data['signal_victims'])) {
                                    $data['signal_victims'] = collect($data['signal_victims'])
                                        ->map(fn (array $item): array => Arr::only($item, ['is_owner', 'owner_id', 'name']))
                                        ->values()
                                        ->all();
                                }

                                return Arr::except($data, [
                                    'signal_victim_id',
                                    'signal_victim_from_owner',
                                    'signal_victim',
                                    'owners',
                                ]);
                            })

                            ->schema([
                                TextInput::make('signal_id')
                                    ->label('رقم الإشارة')
                                    ->maxLength(50)
                                    ->required()
                                    ->live(onBlur: true)
                                    ->placeholder('مثال: 125'),

                                DatePicker::make('signal_date')
                                    ->label('تاريخ الإشارة')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->placeholder('مثال: 2024-01-01')
                                    ->helperText('أدخل تاريخ الإشارة لتسهيل البحث.'),

                                Select::make('type')
                                    ->label('نوع الإشارة')
                                    ->native(false)
                                    ->searchable()
                                    ->options([
                                        'حجز' => 'حجز',
                                        'دعوة' => 'دعوة',
                                        'استيفاء رسوم' => 'استيفاء رسوم',
                                        'إنذار' => 'إنذار',
                                        'استملاك' => 'استملاك',
                                    ])
                                    ->required()
                                    ->placeholder('اختر نوع الإشارة'),

                                TextInput::make('signal_source')
                                    ->label('الجهة/المصدر')
                                    ->maxLength(150)
                                    ->nullable()
                                    ->live(onBlur: true)
                                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                    ->placeholder('مثال: جهة إصدار الإشارة'),

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
                                            ->options(fn (Get $get) => $this->getOwnerOptionsFromOwnerships($get('../../ownerships')))
                                            ->visible(fn (Get $get) => (bool) $get('owner_from_owner'))
                                            ->placeholder('اختر مالكًا من بطاقة العقار'),

                                        TextInput::make('owner_name')
                                            ->label('اسم المالك')
                                            ->maxLength(150)
                                            ->nullable()
                                            ->live(onBlur: true)
                                            ->visible(fn (Get $get) => ! (bool) $get('owner_from_owner'))
                                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                            ->placeholder('اسم المالك إن وُجد'),
                                    ])
                                    ->columns([
                                        'default' => 1,
                                        'md' => 2,
                                    ])
                                    ->defaultItems(0)
                                    ->afterStateHydrated(function ($state, $set, Get $get): void {
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

                                        $owners = $get('owners') ?? [];
                                        if (is_array($owners) && count($owners) > 0) {
                                            $set('signal_owners', collect($owners)->map(function (array $owner): array {
                                                return [
                                                    'owner_from_owner' => true,
                                                    'owner_id' => $owner['id'] ?? null,
                                                    'owner_name' => $owner['full_name'] ?? null,
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
                                    ->dehydrateStateUsing(function ($state, Get $get): array {
                                        return collect($state ?? [])
                                            ->map(function (array $row) use ($get): ?array {
                                                $fromOwner = (bool) ($row['owner_from_owner'] ?? false);
                                                $ownerId = $row['owner_id'] ?? null;

                                                $name = $fromOwner
                                                    ? $this->resolveOwnerNameFromOwnerships($get('../../ownerships'), $ownerId)
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

                                Repeater::make('signal_victims')
                                    ->label('المتضرّرون')
                                    ->schema([
                                        Toggle::make('victim_from_owner')
                                            ->label('من المالكين')
                                            ->default(true)
                                            ->live()
                                            ->reactive(),

                                        Select::make('victim_owner_id')
                                            ->label('المالك')
                                            ->native(false)
                                            ->searchable()
                                            ->options(fn (Get $get) => $this->getOwnerOptionsFromOwnerships($get('../../ownerships')))
                                            ->live()
                                            ->reactive()
                                            ->visible(fn (Get $get) => (bool) $get('victim_from_owner'))
                                            ->placeholder('اختر متضرّرًا من بطاقة العقار'),

                                        TextInput::make('victim_name')
                                            ->label('اسم المتضرّر')
                                            ->maxLength(150)
                                            ->nullable()
                                            ->live(onBlur: true)
                                            ->visible(fn (Get $get) => ! (bool) $get('victim_from_owner'))
                                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                            ->placeholder('اسم المتضرّر إن وُجد'),
                                    ])
                                    ->columns([
                                        'default' => 1,
                                        'md' => 2,
                                    ])
                                    ->defaultItems(0)
                                    ->afterStateHydrated(function ($state, $set, Get $get): void {
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
                                    ->dehydrateStateUsing(function ($state, Get $get): array {
                                        return collect($state ?? [])
                                            ->map(function (array $row) use ($get): ?array {
                                                $fromOwner = (bool) ($row['victim_from_owner'] ?? false);
                                                $ownerId = $row['victim_owner_id'] ?? null;

                                                $name = $fromOwner
                                                    ? $this->resolveOwnerNameFromOwnerships($get('../../ownerships'), $ownerId)
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
                            ])
                            ->columns([
                                'default' => 1,
                                'md' => 2,
                            ]),
                    ]),

            ])
            ->statePath('data')
            ->model(PropertyCard::class);
    }

    // =========================
    // UI Helpers
    // =========================

    protected function uniformAction(Action $action): Action
    {
        return $action
            ->button()
            ->color('gray')
            ->outlined()
            ->size('sm')
            ->extraAttributes([
                'style' => 'min-width: 112px; white-space: nowrap;',
            ]);
    }

    protected function resetCardForm(): void
    {
        $this->currentRecordId = null;

        $this->form->fill([
            'card_status' => 'active',
            // ممكن تضيف defaults أخرى هنا
        ]);
    }

    // =========================
    // Auto Search
    // =========================

    public function tryAutoSearch(): void
    {
        $zone = $this->data['card_cadastral_zone_number'] ?? null;
        $num  = $this->data['card_property_number'] ?? null;

        if (! filled($zone) || ! filled($num)) {
            return;
        }

        $record = PropertyCard::query()
            ->where('card_cadastral_zone_number', $zone)
            ->where('card_property_number', $num)
            ->first();

        if (! $record) {
            $this->currentRecordId = null;
            Notification::make()->title('لا يوجد سجل مطابق لهذا المفتاح')->warning()->send();
            return;
        }

        $this->currentRecordId = $record->id;

        // ✅ تحميل Pivot + المالك داخلها
        $this->form->fill($record->load('ownerships.owner', 'signals.owners')->toArray());

        Notification::make()->title('تم تحميل البطاقة تلقائياً')->success()->send();
    }

    // =========================
    // Actions
    // =========================

    public function createAction(): Action
    {
        $action = Action::make('create')
            ->label('إضافة')
            ->icon('heroicon-o-plus')
            ->action(function () {
                try {
                    $validated = $this->form->validate();
                } catch (ValidationException $exception) {
                    Notification::make()
                        ->title('يرجى تصحيح أخطاء الحقول')
                        ->body($this->formatValidationErrors($exception))
                        ->danger()
                        ->send();
                    return;
                }

                $state = $this->getFormPayload($validated);

                $zone = $state['card_cadastral_zone_number'] ?? null;
                $num  = $state['card_property_number'] ?? null;

                if ($this->isMissingKeyValue($zone) || $this->isMissingKeyValue($num)) {
                    Notification::make()
                        ->title('يرجى إدخال رقم المنطقة العقارية ورقم العقار')
                        ->danger()
                        ->send();
                    return;
                }

                $existingRecord = PropertyCard::withTrashed()
                    ->where('card_cadastral_zone_number', $zone)
                    ->where('card_property_number', $num)
                    ->first();

                if ($existingRecord) {
                    $message = $existingRecord->trashed()
                        ? 'هذا العقار موجود مسبقًا لكنه محذوف (Soft Delete). يرجى استعادته بدلًا من الإضافة.'
                        : 'هذا العقار موجود مسبقًا بنفس المفتاح';

                    Notification::make()->title($message)->danger()->send();
                    return;
                }

                // ✅ لا تمرّر العلاقات كأعمدة
                $attributes = Arr::except($state, ['owners', 'ownerships', 'signals']);

                try {
                    $record = PropertyCard::create($attributes);
                    $this->form->model($record)->saveRelationships();
                    $this->syncSignalOwners($record, $state);
                } catch (QueryException $exception) {
                    Notification::make()
                        ->title('فشل الحفظ')
                        ->body($this->formatQueryExceptionMessage($exception))
                        ->danger()
                        ->send();
                    return;
                }

                $this->currentRecordId = $record->id;
                $this->form->fill($record->load('ownerships.owner', 'signals.owners')->toArray());

                Notification::make()->title('تمت الإضافة بنجاح')->success()->send();
            });

        return $this->uniformAction($action);
    }

    public function searchAction(): Action
    {
        $action = Action::make('search')
            ->label('بحث')
            ->icon('heroicon-o-magnifying-glass')
            ->modalHeading('بحث عن بطاقة عقار')
            ->modalSubmitActionLabel('تحميل')
            ->form([
                TextInput::make('card_cadastral_zone_number')
                    ->label('رقم المنطقة العقارية')
                    ->maxLength(50)
                    ->nullable(),

                TextInput::make('card_property_number')
                    ->label('رقم العقار')
                    ->maxLength(50)
                    ->required(),
            ])
            ->action(function (array $data) {
                $zone = $data['card_cadastral_zone_number'] ?? null;
                $num  = $data['card_property_number'] ?? null;

                $query = PropertyCard::query()->where('card_property_number', $num);

                if (filled($zone)) {
                    $query->where('card_cadastral_zone_number', $zone);
                }

                $record = $query->first();

                if (! $record) {
                    $this->currentRecordId = null;
                    Notification::make()->title('لا يوجد سجل مطابق')->warning()->send();
                    return;
                }

                $this->currentRecordId = $record->id;
                $this->form->fill($record->load('ownerships.owner', 'signals.owners')->toArray());

                Notification::make()->title('تم تحميل البطاقة')->success()->send();
            });

        return $this->uniformAction($action);
    }

    public function updateAction(): Action
    {
        $action = Action::make('update')
            ->label('تعديل')
            ->icon('heroicon-o-pencil-square')
            ->disabled(fn () => blank($this->currentRecordId))
            ->action(function () {
                if (! $this->currentRecordId) {
                    Notification::make()->title('ابحث/حمّل بطاقة أولاً')->warning()->send();
                    return;
                }

                try {
                    $validated = $this->form->validate();
                } catch (ValidationException $exception) {
                    Notification::make()
                        ->title('يرجى تصحيح أخطاء الحقول')
                        ->body($this->formatValidationErrors($exception))
                        ->danger()
                        ->send();
                    return;
                }

                $record = PropertyCard::find($this->currentRecordId);

                if (! $record) {
                    $this->currentRecordId = null;
                    Notification::make()->title('السجل لم يعد موجودًا')->danger()->send();
                    return;
                }

                $state = $this->getFormPayload($validated);
                $attributes = Arr::except($state, ['owners', 'ownerships', 'signals']);

                try {
                    $record->update($attributes);
                    $this->form->model($record)->saveRelationships();
                    $this->syncSignalOwners($record, $state);
                } catch (QueryException $exception) {
                    Notification::make()
                        ->title('فشل التعديل')
                        ->body($this->formatQueryExceptionMessage($exception))
                        ->danger()
                        ->send();
                    return;
                }

                Notification::make()->title('تم التعديل بنجاح')->success()->send();
            });

        return $this->uniformAction($action);
    }

    public function deleteAction(): Action
    {
        $action = Action::make('delete')
            ->label('حذف')
            ->icon('heroicon-o-trash')
            ->disabled(fn () => blank($this->currentRecordId))
            ->requiresConfirmation()
            ->modalHeading('تأكيد الحذف')
            ->modalDescription('سيتم حذف البطاقة الحالية (حذف منطقي Soft Delete).')
            ->action(function () {
                if (! $this->currentRecordId) {
                    Notification::make()->title('لا يوجد سجل محمّل للحذف')->warning()->send();
                    return;
                }

                $record = PropertyCard::find($this->currentRecordId);

                if (! $record) {
                    $this->currentRecordId = null;
                    Notification::make()->title('السجل غير موجود')->danger()->send();
                    return;
                }

                $record->delete();
                $this->resetCardForm();

                Notification::make()->title('تم الحذف بنجاح')->success()->send();
            });

        return $this->uniformAction($action);
    }

    public function pdfBrowserAction(): Action
    {
        $action = Action::make('pdf_browser')
            ->label('تحميل PDF (Chrome)')
            ->icon('heroicon-o-document-arrow-down')
            ->disabled(fn () => blank($this->currentRecordId))
            ->action(function () {
                if (! $this->currentRecordId) {
                    Notification::make()->title('حمّل بطاقة أولاً ثم حمّل PDF')->warning()->send();
                    return;
                }

                $record = PropertyCard::find($this->currentRecordId);

                if (! $record) {
                    $this->currentRecordId = null;
                    Notification::make()->title('السجل غير موجود')->danger()->send();
                    return;
                }

                $filename = 'property-card-' .
                    ($record->card_cadastral_zone_number ?? 'zone') . '-' .
                    ($record->card_property_number ?? 'no') . '.pdf';

                $html = view('pdf.property-card-browser', [
                    'record' => $record->load('ownerships.owner'),
                ])->render();

                $pdf = Browsershot::html($html)
                    ->setChromePath($this->resolveChromePath())
                    ->format('A4')
                    ->margins(12, 10, 12, 10)
                    ->showBackground()
                    ->pdf();

                return response()->streamDownload(
                    fn () => print($pdf),
                    $filename,
                    ['Content-Type' => 'application/pdf']
                );
            });

        return $this->uniformAction($action);
    }

    // =========================
    // Helpers
    // =========================

    private function getFormPayload(?array $payload = null): array
    {
        $payload = $payload ?? $this->form->getState();

        if (array_key_exists('data', $payload) && is_array($payload['data'])) {
            return $payload['data'];
        }

        return $payload;
    }

    private function isMissingKeyValue(mixed $value): bool
    {
        if ($value === null) {
            return true;
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        return false;
    }

    protected function resolveChromePath(): string
    {
        // 1) جرّب مسار puppeteer
        $cmd = 'node -e "console.log(require(\'puppeteer\').executablePath())"';
        $path = trim((string) @shell_exec($cmd));

        if ($path && file_exists($path)) {
            return $path;
        }

        // 2) جرّب Chrome النظام (Windows)
        $candidates = [
            'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
            'C:\\Program Files (x86)\\Google\\Chrome\\Application\\chrome.exe',
        ];

        foreach ($candidates as $candidate) {
            if (file_exists($candidate)) {
                return $candidate;
            }
        }

        // 3) آخر حل: أعد ما حصلنا عليه (قد يكون فارغاً ويظهر خطأ واضح)
        return $path;
    }

    protected function formatValidationErrors(ValidationException $exception): string
    {
        $errors = $exception->errors();

        if ($errors === []) {
            return 'حدثت أخطاء تحقق غير معروفة.';
        }

        return collect($errors)
            ->map(function (array $messages, string $field): string {
                $message = implode('، ', $messages);
                return "{$field}: {$message}";
            })
            ->implode("\n");
    }

    protected function getOwnerOptionsFromOwnerships(?array $ownerships): array
    {
        return collect($ownerships ?? [])
            ->mapWithKeys(function (array $ownership): array {
                $owner = $ownership['owner'] ?? [];
                $ownerId = $ownership['owner_id'] ?? $owner['id'] ?? null;
                $fullName = $owner['full_name'] ?? null;

                if (! filled($ownerId) || ! filled($fullName)) {
                    return [];
                }


    // FK

                return [$ownerId => $fullName];
            })
            ->all();

    }

    // Unknown column
    protected function resolveOwnerNameFromOwnerships(?array $ownerships, mixed $ownerId): ?string
    {
        if (! filled($ownerId)) {
            return null;

        }

        // لإعطاءك اسم العمود المفقود مباشرة
        $options = $this->getOwnerOptionsFromOwnerships($ownerships);

        return $options[$ownerId] ?? null;

    }

    protected function syncSignalOwners(PropertyCard $record, array $state): void
    {
        $signals = $state['signals'] ?? [];

        foreach ($signals as $signalData) {
            $ownersPayload = $signalData['signal_owners'] ?? [];
            $signal = null;

            if (filled($signalData['id'] ?? null)) {
                $signal = $record->signals()->find($signalData['id']);
            }

            if (! $signal && filled($signalData['signal_id'] ?? null) && filled($signalData['signal_date'] ?? null)) {
                    $signal = $record->signals()
                    ->where('signal_id', $signalData['signal_id'])
                    ->whereDate('signal_date', $signalData['signal_date'])
                    ->first();
            }

            if (! $signal) {
                continue;
            }

            $ownerIds = collect($ownersPayload)
                ->filter(fn (array $item): bool => (bool) ($item['is_owner'] ?? false) && filled($item['owner_id'] ?? null))
                ->pluck('owner_id')
                ->unique()
                ->values()
                ->all();

            $signal->owners()->sync($ownerIds);
        }

    }

 protected function formatQueryExceptionMessage(QueryException $exception): string
    {
        $sqlState   = $exception->errorInfo[0] ?? null;
        $driverCode = $exception->errorInfo[1] ?? null;
        $message    = $exception->errorInfo[2] ?? $exception->getMessage();

        // Duplicate
        if ($driverCode === 1062 || $sqlState === '23505' || str_contains($message, 'Duplicate entry')) {
            return 'تم رفض العملية بسبب مفتاح مكرر. يرجى التأكد من أن المفتاح فريد.';
        }

        // FK
        if (in_array($driverCode, [1451, 1452], true) || $sqlState === '23503') {
            return 'تم رفض العملية بسبب قيد مرجعي (مفتاح خارجي). يرجى التحقق من العلاقات.';
        }

        // Unknown column
        if ($driverCode === 1054 || $sqlState === '42S22' || str_contains($message, 'Unknown column')) {
            $col = null;
            if (preg_match("/Unknown column '([^']+)'/i", $message, $m)) {
                $col = $m[1];
            }

            // لإعطاءك اسم العمود المفقود مباشرة
            return $col
                ? "حقل غير موجود في قاعدة البيانات: {$col}. إمّا أن العمود غير موجود في الجدول، أو أنك تمرّر مفتاحًا ليس من أعمدة الجدول ضمن بيانات الحفظ."
                : "يوجد حقل غير معروف أثناء الحفظ. راجع أن أسماء الحقول تطابق أعمدة الجداول.";
        }

        // NOT NULL / no default
        if (in_array($driverCode, [1048, 1364], true)) {
            return 'تعذر تنفيذ العملية بسبب حقل إلزامي فارغ أو لا يملك قيمة افتراضية. راجع القيم المدخلة.';
        }

        return 'تعذر تنفيذ العملية بسبب قيد في قاعدة البيانات. يرجى مراجعة القيم المدخلة.';
    }


}
