<?php

namespace App\Filament\Pages;

use App\Models\Owner;
use App\Models\PropertyCard;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\PropertyCardFile;
use App\Services\PropertyCardFileStorage;
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
                    ->description('عند إدخال رقم المحضر والخروج من الحقل سيتم تحميل بيانات العقار إن وُجد.')
                    ->schema([
                        Grid::make(1)->schema([
                            TextInput::make('card_record_number')
                                ->label('رقم المحضر')
                                ->maxLength(50)
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn () => $this->tryAutoSearch())
                                ->placeholder('مثال: 2024/105'),
                        ]),
                    ]),

                Section::make('البيانات الأساسية')
                    ->schema([
                        Grid::make(4)->schema([
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

                            TextInput::make('card_record_number')
                                ->label('رقم المحضر')
                                ->maxLength(50)
                                ->required()
                                ->live(onBlur: true)
                                ->placeholder('مثال: 2024/105'),

                            TextInput::make('card_subdivision')
                                ->label('المقسم')
                                ->maxLength(100)
                                ->live(onBlur: true)
                                ->nullable()
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                ->placeholder('مثال: المقسم 22'),
                        ]),

                        Grid::make(1)->schema([
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
                            Select::make('card_investment_type')
                                ->label('نوع الاستثمار')
                                ->native(false)
                                ->options([
                                    'سكني' => 'سكني',
                                    'تجاري' => 'تجاري',
                                    'أرض زراعية' => 'أرض زراعية',
                                    'صناعي' => 'صناعي',
                                ])
                                ->nullable()
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
                        Grid::make(1)->schema([
                            TextInput::make('card_total_area')
                                ->label('مساحة العقار الكلية')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(9999999999.99)
                                ->required()
                                ->live(onBlur: true)
                                ->suffix('م²')
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
                        $this->ownershipsRepeater(),
                    ]),
                Section::make('الإشارات')
                    ->schema([
                        $this->signalsRepeater(),
                    ]),
                Section::make('ملفات البطاقة')
                    ->description('يمكنك رفع الملفات أثناء إنشاء البطاقة، وسيتم حفظها تلقائياً عند أول رفع.')
                    ->schema([
                        Repeater::make('files')
                            ->label('الملفات')
                            ->schema([
                                Grid::make(3)->schema([
                                    TextInput::make('file_name')
                                        ->label('اسم الملف')
                                        ->maxLength(255)
                                        ->nullable()
                                        ->live(onBlur: true)
                                        ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                        ->placeholder('مثال: سند الملكية'),

                                    DatePicker::make('file_issued_at')
                                        ->label('تاريخ الإصدار')
                                        ->nullable()
                                        ->live(onBlur: true)
                                        ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                                    FileUpload::make('file_upload')
                                        ->label('رفع الملف')
                                        ->multiple()
                                        ->storeFiles(false)
                                        ->live()
                                        ->acceptedFileTypes(['application/pdf', 'image/*'])
                                        ->helperText('مسموح: PDF أو صور فقط.'),
                                ]),
                            ])
                            ->defaultItems(1)
                            ->columns([
                                'default' => 1,
                                'md' => 1,
                            ]),
                        Placeholder::make('uploaded_files')
                            ->label('الملفات المرفوعة')
                            ->content(fn () => $this->renderUploadedFiles())
                            ->visible(fn () => filled($this->currentRecordId))
                            ->columnSpanFull(),
                    ]),
                Section::make('الدفعات')
                    ->schema([
                        $this->paymentsRepeater(),
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

        $this->bindFormToRecord(null);

        $this->data = [
            'card_status' => 'active',
            'ownerships' => [],
            'signals' => [],
            'payments' => [],
            'files' => [],
        ];

        $this->form->fill($this->data);
    }

    protected function ownershipsRepeater(): Repeater
    {
        return Repeater::make('ownerships')
            ->label('الملاك')
            ->default([])
            ->relationship('ownerships')
            ->schema([
                Grid::make(2)
                    ->schema([
                        Select::make('owner_id')
                            ->label('المالك')
                            ->relationship('owner', 'display_name') // belongsTo داخل Pivot
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
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
                                    ->live(onBlur: true)
                                    ->columnSpanFull(),

                                TextInput::make('company_name')
                                    ->label('اسم الشركة')
                                    ->maxLength(200)
                                    ->nullable()
                                    ->visible(fn (Get $get) => $get('owner_type') === 'company')
                                    ->required(fn (Get $get) => $get('owner_type') === 'company')
                                    ->live(onBlur: true)
                                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                                TextInput::make('commercial_register_number')
                                    ->label('رقم السجل التجاري')
                                    ->maxLength(100)
                                    ->nullable()
                                    ->visible(fn (Get $get) => $get('owner_type') === 'company')
                                    ->live(onBlur: true)
                                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

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
                                'أسهم' => 'أسهم',
                                'نسبة مئوية' => 'نسبة مئوية',
                                'م²' => 'م²',
                            ])
                            ->required()
                            ->live(onBlur: true),

                        TextInput::make('ownership_percentage')
                            ->label('قيمة التملك')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(9999999999.99)
                            ->required()
                            ->live(onBlur: true)
                            ->suffix(fn (Get $get) => match ($get('ownership_metric')) {
                                'أسهم' => 'سهم',
                                'نسبة مئوية' => '%',
                                'م²' => 'م²',
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

                        Select::make('purchase_method')
                            ->label('طريقة الشراء')
                            ->native(false)
                            ->options([
                                'court_judgment' => 'حكم قضائي',
                                'regular_contract' => 'عقد عادي',
                                'commercial_register_contract' => 'عقد سجل تجاري',

                            ])
                            ->nullable()
                            ->live(onBlur: true),
                        TextInput::make('case_number')
                            ->label('رقم الأساس')
                            ->maxLength(100)
                            ->visible(fn (Get $get) => $get('purchase_method') === 'court_judgment')
                            ->required(fn (Get $get) => $get('purchase_method') === 'court_judgment')
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                        TextInput::make('decision_number')
                            ->label('رقم القرار')
                            ->maxLength(100)
                            ->visible(fn (Get $get) => $get('purchase_method') === 'court_judgment')
                            ->required(fn (Get $get) => $get('purchase_method') === 'court_judgment')
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                        TextInput::make('authority')
                            ->label('الجهة')
                            ->maxLength(150)
                            ->visible(fn (Get $get) => $get('purchase_method') === 'court_judgment')
                            ->required(fn (Get $get) => $get('purchase_method') === 'court_judgment')
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                        DatePicker::make('judgment_date')
                            ->label('التاريخ')
                            ->visible(fn (Get $get) => $get('purchase_method') === 'court_judgment')
                            ->required(fn (Get $get) => $get('purchase_method') === 'court_judgment')
                            ->live(onBlur: true),

                        DatePicker::make('regular_contract_date')
                            ->label('التاريخ')
                            ->visible(fn (Get $get) => $get('purchase_method') === 'regular_contract')
                            ->required(fn (Get $get) => $get('purchase_method') === 'regular_contract')
                            ->live(onBlur: true),

                        TextInput::make('contract_number')
                            ->label('رقم العقد')
                            ->maxLength(100)
                            ->visible(fn (Get $get) => $get('purchase_method') === 'commercial_register_contract')
                            ->required(fn (Get $get) => $get('purchase_method') === 'commercial_register_contract')
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                        DatePicker::make('commercial_contract_date')
                            ->label('التاريخ')
                            ->visible(fn (Get $get) => $get('purchase_method') === 'commercial_register_contract')
                            ->required(fn (Get $get) => $get('purchase_method') === 'commercial_register_contract')
                            ->live(onBlur: true),

                
                        DatePicker::make('sale_date')
                            ->label('تاريخ البيع')
                            ->nullable()
                            ->live(onBlur: true)
                            ->visible(fn (Get $get) => ! (bool) $get('is_current')),
                    ]),
            ]);
    }

    protected function signalsRepeater(): Repeater
    {
        return Repeater::make('signals')
            ->label('الإشارات')
            ->default([])
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
                        'دعوى' => 'دعوى',
                        'استيفاء رسوم' => 'استيفاء رسوم',
                        'أخرى' => 'أخرى',
                        'استملاك' => 'استملاك',
                    ])
                    ->required()
                    ->placeholder('اختر نوع الإشارة'),

                Grid::make(3)
                    ->schema([
                        TextInput::make('signal_source')
                            ->label('الجهة/المصدر')
                            ->maxLength(150)
                            ->nullable()
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                            ->placeholder('مثال: جهة إصدار الإشارة'),

                        TextInput::make('signal_source_number')
                            ->label('رقم الجهة')
                            ->maxLength(50)
                            ->nullable()
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                            ->placeholder('مثال: 2024/55'),

                        DatePicker::make('signal_source_date')
                            ->label('تاريخ الجهة')
                            ->nullable()
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                            ->placeholder('مثال: 2024-01-01'),
                    ]),

                Repeater::make('signal_owners')
                    ->label('أصحاب الإشارة')
                    ->default([])
                    ->schema([
                        Toggle::make('owner_from_owner')
                            ->label('من المالكين')
                            ->default(true)
                            ->live(),

                        Select::make('owner_id')
                            ->label('المالك')
                            ->native(false)
                            ->searchable()
                            ->options(fn () => $this->getAllOwnerOptions())
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
                        if (is_array($state) && ! array_is_list($state)) {
                            return;
                        }

                        $uuidKeyed = function (array $rows): array {
                            return collect($rows)
                                ->mapWithKeys(fn (array $row) => [\Illuminate\Support\Str::uuid()->toString() => $row])
                                ->all();
                        };

                        if (is_array($state) && count($state) > 0) {
                            $first = $state[0] ?? null;

                            if (is_array($first) && array_key_exists('owner_from_owner', $first)) {
                                $set('signal_owners', $uuidKeyed($state));
                                return;
                            }

                            $rows = collect($state)->map(function (array $item): array {
                                return [
                                    'owner_from_owner' => (bool) ($item['is_owner'] ?? false),
                                    'owner_id' => $item['owner_id'] ?? null,
                                    'owner_name' => $item['name'] ?? null,
                                ];
                            })->all();

                            $set('signal_owners', $uuidKeyed($rows));
                            return;
                        }

                        $owners = $get('owners') ?? [];
                        if (is_array($owners) && count($owners) > 0) {
                            $rows = collect($owners)->map(function (array $owner): array {
                                return [
                                    'owner_from_owner' => true,
                                    'owner_id' => $owner['id'] ?? null,
                                    'owner_name' => $owner['display_name'] ?? $owner['full_name'] ?? null,
                                ];
                            })->all();

                            $set('signal_owners', $uuidKeyed($rows));
                            return;
                        }

                        $legacyOwner = $get('signal_owner');
                        if (filled($legacyOwner)) {
                            $set('signal_owners', $uuidKeyed([[
                                'owner_from_owner' => false,
                                'owner_id' => null,
                                'owner_name' => $legacyOwner,
                            ]]));
                        }
                    })
                    ->dehydrateStateUsing(function ($state, Get $get): array {
                        return collect($state ?? [])
                            ->map(function (array $row) use ($get): ?array {
                                $fromOwner = (bool) ($row['owner_from_owner'] ?? false);
                                $ownerId = $row['owner_id'] ?? null;

                                $name = $fromOwner
                                    ? $this->resolveOwnerNameFromAllOwners($ownerId)
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
                    ->label('المدعى عليهم في الإشارة')
                    ->default([])
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
                            ->options(fn () => $this->getAllOwnerOptions())
                            ->live()
                            ->reactive()
                            ->visible(fn (Get $get) => (bool) $get('victim_from_owner'))
                            ->placeholder('اختر متضرّرًا من بطاقة العقار'),

                        TextInput::make('victim_name')
                            ->label('اسم المدعى عليه')
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
                        if (is_array($state) && ! array_is_list($state)) {
                            return;
                        }

                        $uuidKeyed = function (array $rows): array {
                            return collect($rows)
                                ->mapWithKeys(fn (array $row) => [\Illuminate\Support\Str::uuid()->toString() => $row])
                                ->all();
                        };

                        if (is_array($state) && count($state) > 0) {
                            $first = $state[0] ?? null;

                            if (is_array($first) && array_key_exists('victim_from_owner', $first)) {
                                $set('signal_victims', $uuidKeyed($state));
                                return;
                            }

                            $rows = collect($state)->map(function (array $item): array {
                                return [
                                    'victim_from_owner' => (bool) ($item['is_owner'] ?? false),
                                    'victim_owner_id' => $item['owner_id'] ?? null,
                                    'victim_name' => $item['name'] ?? null,
                                ];
                            })->all();

                            $set('signal_victims', $uuidKeyed($rows));
                            return;
                        }

                        $legacyVictim = $get('signal_victim');

                        if (filled($legacyVictim)) {
                            $set('signal_victims', $uuidKeyed([[
                                'victim_from_owner' => false,
                                'victim_owner_id' => null,
                                'victim_name' => $legacyVictim,
                            ]]));
                        }
                    })
                    ->dehydrateStateUsing(function ($state, Get $get): array {
                        return collect($state ?? [])
                            ->map(function (array $row) use ($get): ?array {
                                $fromOwner = (bool) ($row['victim_from_owner'] ?? false);
                                $ownerId = $row['victim_owner_id'] ?? null;

                                $name = $fromOwner
                                    ? $this->resolveOwnerNameFromAllOwners($ownerId)
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
            ]);
    }

    protected function paymentsRepeater(): Repeater
    {
        return Repeater::make('payments')
            ->label('الدفعات')
            ->default([])
            ->relationship('payments')
            ->schema([


                TextInput::make('debit')
                    ->label('مدين')
                    ->numeric()
                    ->minValue(0)
                    ->live(onBlur: true),

                TextInput::make('credit')
                    ->label('دائن')
                    ->numeric()
                    ->minValue(0)
                    ->live(onBlur: true),

                TextInput::make('statement')
                    ->label('البيان')
                    ->maxLength(255)
                    ->nullable()
                    ->live(onBlur: true)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                TextInput::make('voucher')
                    ->label('سند')
                    ->maxLength(150)
                    ->nullable()
                    ->live(onBlur: true)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                DatePicker::make('payment_date')
                    ->label('التاريخ')
                    ->required()
                    ->live(onBlur: true),

                TextInput::make('balance_movement')
                    ->label('حركة الرصيد')
                    ->maxLength(255)
                    ->nullable()
                    ->live(onBlur: true)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                Select::make('currency')
                    ->label('العملة')
                    ->native(false)
                    ->options([
                        'syp_new' => 'ليرة سورية جديدة',
                        'syp_old' => 'ليرة سورية قديمة',
                        'usd' => 'دولار أمريكي',
                    ])
                    ->nullable()
                    ->live(onBlur: true),
            ])
            ->columns([
                'default' => 1,
                'md' => 6,
            ]);
    }

    // =========================
    // Auto Search
    // =========================

    public function tryAutoSearch(): void
    {
        $recordNumber = $this->data['card_record_number'] ?? null;

        if (! filled($recordNumber)) {
            return;
        }

        $record = PropertyCard::query()
            ->where('card_record_number', $recordNumber)
            ->first();

        if (! $record) {
            $this->currentRecordId = null;
            Notification::make()->title('لا يوجد سجل مطابق لهذا المفتاح')->warning()->send();
            return;
        }

        $this->loadRecordIntoForm($record);

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
                $record = $this->persistNewRecordFromForm();

                if (! $record) {
                    return;
                }

                $this->loadRecordIntoForm($record);

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
                TextInput::make('card_record_number')
                    ->label('رقم المحضر')
                    ->maxLength(50)
                    ->required(),
            ])
            ->action(function (array $data) {
                $recordNumber = $data['card_record_number'] ?? null;

                $query = PropertyCard::query()->where('card_record_number', $recordNumber);

                $record = $query->first();

                if (! $record) {
                    $this->currentRecordId = null;
                    Notification::make()->title('لا يوجد سجل مطابق')->warning()->send();
                    return;
                }

                $this->loadRecordIntoForm($record);

                Notification::make()->title('تم تحميل البطاقة')->success()->send();
            });

        return $this->uniformAction($action);
    }

    public function uploadFileAction(): Action
    {
        $action = Action::make('upload_file')
            ->label('رفع ملف')
            ->icon('heroicon-o-arrow-up-tray')
            ->action(function () {
                $record = $this->resolveRecordForFileUpload();

                if (! $record) {
                    return;
                }

                $files = $this->data['files'] ?? [];
                $validatedFiles = $this->validateFileUploads($files, true);

                if ($validatedFiles === null) {
                    return;
                }

                if (! $this->storeValidatedFileUploads($record, $validatedFiles)) {
                    return;
                }

                Notification::make()->title('تم رفع الملف بنجاح')->success()->send();
            });

        return $this->uniformAction($action);
    }

    protected function persistNewRecordFromForm(): ?PropertyCard
    {
        try {
            $validated = $this->form->validate();
        } catch (ValidationException $exception) {
            Notification::make()
                ->title('يرجى تصحيح أخطاء الحقول')
                ->body($this->formatValidationErrors($exception))
                ->danger()
                ->send();
            return null;
        }

        $state = $this->getFormPayload($validated);
        $validatedFiles = $this->validateFileUploads($state['files'] ?? []);

        if ($validatedFiles === null) {
            return null;
        }

        $recordNumber = $state['card_record_number'] ?? null;

        if ($this->isMissingKeyValue($recordNumber)) {
            Notification::make()
                ->title('يرجى إدخال رقم المحضر')
                ->danger()
                ->send();
            return null;
        }

        $existingRecord = PropertyCard::withTrashed()
            ->where('card_record_number', $recordNumber)
            ->first();

        if ($existingRecord) {
            $message = $existingRecord->trashed()
                ? 'هذا العقار موجود مسبقًا لكنه محذوف (Soft Delete). يرجى استعادته بدلًا من الإضافة.'
                : 'هذا العقار موجود مسبقًا بنفس المفتاح';

            Notification::make()->title($message)->danger()->send();
            return null;
        }

        $attributes = Arr::except($state, [
            'owners',
            'ownerships',
            'signals',
            'payments',
            'files',
        ]);

        try {
            $record = PropertyCard::create($attributes);
            $this->form->model($record)->saveRelationships();
            $this->syncSignalOwners($record, $state);
            $this->storeValidatedFileUploads($record, $validatedFiles);
        } catch (QueryException $exception) {
            Notification::make()
                ->title('فشل الحفظ')
                ->body($this->formatQueryExceptionMessage($exception))
                ->danger()
                ->send();
            return null;
        }

        return $record;
    }

    protected function resolveRecordForFileUpload(): ?PropertyCard
    {
        if ($this->currentRecordId) {
            $record = PropertyCard::find($this->currentRecordId);

            if (! $record) {
                $this->currentRecordId = null;
                Notification::make()->title('السجل غير موجود')->danger()->send();
                return null;
            }

            $this->bindFormToRecord($record);

            return $record;
        }

        $record = $this->persistNewRecordFromForm();

        if (! $record) {
            return null;
        }

        $this->loadRecordIntoForm($record);

        return $record;
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

                $this->bindFormToRecord($record);

                $state = $this->getFormPayload($validated);
                $validatedFiles = $this->validateFileUploads($state['files'] ?? []);

                if ($validatedFiles === null) {
                    return;
                }
                $attributes = Arr::except($state, [
                    'owners',
                    'ownerships',
                    'signals',
                    'payments',
                    'files',
                ]);

                try {
                    $record->update($attributes);
                    $this->form->model($record)->saveRelationships();
                    $this->syncSignalOwners($record, $state);
                    $this->storeValidatedFileUploads($record, $validatedFiles);
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
                    ($record->card_record_number ?? 'record') . '.pdf';

                $html = view('pdf.property-card', [
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

    protected function bindFormToRecord(?PropertyCard $record): void
    {
        $this->form->model($record ?? new PropertyCard());
    }

    protected function loadRecordIntoForm(PropertyCard $record): void
    {
        $this->currentRecordId = $record->id;

        $record->load('ownerships.owner', 'signals.owners', 'payments', 'files');

        $payload = $record->toArray();
        $payload['ownerships'] = $record->ownerships
            ->map(fn ($ownership) => $ownership->toArray())
            ->values()
            ->all();
        $payload['signals'] = $record->signals
            ->map(function ($signal): array {
                $data = $signal->toArray();
                $data['signal_owners'] = $this->normalizeSignalOwnersForForm(
                    $signal->signal_owners ?? [],
                    $signal->signal_owner ?? null,
                    $signal->owners ?? collect()
                );
                $data['signal_victims'] = $this->normalizeSignalVictimsForForm(
                    $signal->signal_victims ?? [],
                    $signal->signal_victim ?? null
                );

                return $data;
            })
            ->values()
            ->all();
        $payload['payments'] = $record->payments
            ->map(fn ($payment) => $payment->toArray())
            ->values()
            ->all();
        $payload['files'] = [];

        $this->bindFormToRecord($record);
        $this->form->fill($payload);
        $this->resetFileInputs();
    }
    private function normalizeSignalOwnersForForm(array $owners, ?string $legacyOwner, $ownersRelation): array
    {
        if (count($owners) > 0) {
            $first = $owners[0] ?? null;

            if (is_array($first) && array_key_exists('owner_from_owner', $first)) {
                return $owners;
            }

            return collect($owners)->map(function (array $owner): array {
                return [
                    'owner_from_owner' => (bool) ($owner['is_owner'] ?? false),
                    'owner_id' => $owner['owner_id'] ?? null,
                    'owner_name' => $owner['name'] ?? null,
                ];
            })->values()->all();
        }

        if ($ownersRelation instanceof \Illuminate\Support\Collection && $ownersRelation->isNotEmpty()) {
            return $ownersRelation->map(function ($owner): array {
                return [
                    'owner_from_owner' => true,
                    'owner_id' => $owner->id ?? null,
                    'owner_name' => $owner->display_name ?? $owner->full_name ?? null,
                ];
            })->values()->all();
        }

        if (filled($legacyOwner)) {
            return [[
                'owner_from_owner' => false,
                'owner_id' => null,
                'owner_name' => $legacyOwner,
            ]];
        }

        return [];
    }

    private function normalizeSignalVictimsForForm(array $victims, ?string $legacyVictim): array
    {
        if (count($victims) > 0) {
            $first = $victims[0] ?? null;

            if (is_array($first) && array_key_exists('victim_from_owner', $first)) {
                return $victims;
            }

            return collect($victims)->map(function (array $victim): array {
                return [
                    'victim_from_owner' => (bool) ($victim['is_owner'] ?? false),
                    'victim_owner_id' => $victim['owner_id'] ?? null,
                    'victim_name' => $victim['name'] ?? null,
                ];
            })->values()->all();
        }

        if (filled($legacyVictim)) {
            return [[
                'victim_from_owner' => false,
                'victim_owner_id' => null,
                'victim_name' => $legacyVictim,
            ]];
        }

        return [];
    }


protected function resetFileInputs(): void
{
    // خذ الحالة الحالية للفورم (بدون تدمير باقي الحقول)
    $state = $this->form->getState(); // بسبب statePath('data') هذا يرجع محتوى data مباشرة

    // صفّر فقط جزء الملفات
    $state['files'] = [[]]; // حتى يظهر سطر رفع واحد (اختياري). أو [] إذا لا تريده.

    // أعد تعبئة الفورم بنفس الحالة الكاملة بعد التعديل
    $this->form->fill($state);
}

    protected function renderUploadedFiles(): HtmlString
    {
        if (! $this->currentRecordId) {
            return new HtmlString('<span class="text-sm text-gray-500">حمّل بطاقة لعرض الملفات.</span>');
        }

        $files = PropertyCardFile::query()
            ->where('property_card_id', $this->currentRecordId)
            ->orderByDesc('issued_at')
            ->get();

        if ($files->isEmpty()) {
            return new HtmlString('<span class="text-sm text-gray-500">لا توجد ملفات مرفوعة بعد.</span>');
        }

        $items = $files->map(function (PropertyCardFile $file): string {
            $url = Storage::disk($file->storage_disk)->url($file->storage_path);
            $name = e($file->file_name);
            $issuedAt = $file->issued_at?->format('Y-m-d');
            $issuedLabel = $issuedAt ? " <span class=\"text-xs text-gray-500\">({$issuedAt})</span>" : '';
            $downloadLink = "<a href=\"{$url}\" class=\"text-primary-600 hover:underline\" download>تنزيل</a>";
            $previewLink = $this->canPreviewFile($file->mime_type)
                ? " | <a href=\"{$url}\" class=\"text-primary-600 hover:underline\" target=\"_blank\" rel=\"noopener\">معاينة</a>"
                : '';

            return "<li class=\"text-sm\"><span class=\"font-medium\">{$name}</span>{$issuedLabel} — {$downloadLink}{$previewLink}</li>";
        });

        return new HtmlString('<ul class="space-y-1">' . $items->implode('') . '</ul>');
    }

    protected function canPreviewFile(?string $mimeType): bool
    {
        if (! is_string($mimeType)) {
            return false;
        }

        return str_starts_with($mimeType, 'image/') || $mimeType === 'application/pdf';
    }

    protected function normalizeUploadedFileName(?string $fileName, UploadedFile $file): ?string
    {
        $fileName = $fileName ? trim($fileName) : null;

        if (! $fileName) {
            return null;
        }

        $extension = $file->getClientOriginalExtension();
        $hasExtension = pathinfo($fileName, PATHINFO_EXTENSION) !== '';

        if (! $hasExtension && $extension !== '') {
            $fileName .= '.' . $extension;
        }

        return $fileName;
    }

    protected function validateFileUploads(array $files, bool $requireFiles = false): ?array
    {
        if (! $this->shouldHandleFileUploads($files)) {
            if ($requireFiles) {
                $exception = ValidationException::withMessages([
                    'files' => ['يرجى إضافة ملف واحد على الأقل.'],
                ]);
                Notification::make()
                    ->title('يرجى تصحيح أخطاء الحقول')
                    ->body($this->formatValidationErrors($exception))
                    ->danger()
                    ->send();
                return null;
            }

            return [];
        }

        $payload = [
            'files' => $files,
        ];

        $validator = Validator::make($payload, [
            'files' => ['required', 'array', 'min:1'],
            'files.*.file_upload' => ['required', 'array', 'min:1'],
            'files.*.file_upload.*' => ['file', 'max:10240'],
            'files.*.file_name' => ['nullable', 'string', 'max:255'],
            'files.*.file_issued_at' => ['nullable', 'date'],
        ], [
            'files.required' => 'يرجى إضافة ملف واحد على الأقل.',
            'files.*.file_upload.required' => 'يرجى اختيار ملف للرفع.',
            'files.*.file_upload.*.max' => 'حجم الملف يجب ألا يتجاوز :max كيلوبايت.',
            'files.*.file_upload.*.mimes' => 'صيغة الملف غير مدعومة. الصيغ المسموحة: :values.',
            'files.*.file_upload.*.mimetypes' => 'نوع الملف غير مدعوم. الأنواع المسموحة: :values.',
        ]);

        if ($validator->fails()) {
            $exception = ValidationException::withMessages($validator->errors()->toArray());
            Notification::make()
                ->title('يرجى تصحيح أخطاء الحقول')
                ->body($this->formatValidationErrors($exception))
                ->danger()
                ->send();
            return null;
        }

        return $payload['files'];
    }

    protected function storeValidatedFileUploads(PropertyCard $record, array $files): bool
    {
        if ($files === []) {
            return true;
        }

        foreach ($files as $fileRow) {
            $uploadedFiles = Arr::wrap($fileRow['file_upload'] ?? []);

            foreach ($uploadedFiles as $uploadedFile) {
                if (! $uploadedFile instanceof UploadedFile) {
                    Notification::make()->title('الملف غير صالح')->danger()->send();
                    return false;
                }

                $fileName = $this->normalizeUploadedFileName($fileRow['file_name'] ?? null, $uploadedFile);
                $issuedAt = filled($fileRow['file_issued_at'] ?? null)
                    ? \Illuminate\Support\Carbon::parse($fileRow['file_issued_at'])
                    : null;

                app(PropertyCardFileStorage::class)->store(
                    $record,
                    $uploadedFile,
                    $issuedAt,
                    null,
                    $fileName
                );
            }
        }

        $this->resetFileInputs();

        return true;
    }

    protected function shouldHandleFileUploads(array $files): bool
    {
        foreach ($files as $row) {
            if (! is_array($row)) {
                continue;
            }

            if (! $this->isFileRowEmpty($row)) {
                return true;
            }
        }

        return false;
    }

    protected function isFileRowEmpty(array $row): bool
    {
        $fileUploads = Arr::wrap($row['file_upload'] ?? []);
        $hasUploads = collect($fileUploads)->contains(fn ($file): bool => $file instanceof UploadedFile);
        $hasMeta = filled($row['file_name'] ?? null) || filled($row['file_issued_at'] ?? null);

        return ! $hasUploads && ! $hasMeta;
    }

    protected function formatValidationErrors(ValidationException $exception): string
    {
        $errors = $exception->errors();

        if ($errors === []) {
            return 'حدثت أخطاء تحقق غير معروفة.';
        }

        $fieldLabels = [
            'card_record_number' => 'رقم المحضر',
            'card_governorate' => 'المحافظة',
            'card_region_name' => 'اسم المنطقة',
            'card_subdivision' => 'المقسم',
            'card_status' => 'حالة العقار',
            'card_investment_type' => 'نوع الاستثمار',
            'card_google_maps_url' => 'رابط خريطة Google',
            'card_property_details' => 'وصف العقار',
            'card_total_area' => 'مساحة العقار الكلية',
            'ownerships' => 'الملاك',
            'owner_id' => 'المالك',
            'ownership_metric' => 'معيار التملك',
            'ownership_percentage' => 'نسبة التملك',
            'is_current' => 'الملكية الحالية',
            'purchase_date' => 'تاريخ الشراء',
            'purchase_method' => 'طريقة الشراء',
            'sale_date' => 'تاريخ البيع',
            'full_name' => 'اسم المالك',
            'birth_date' => 'تاريخ الميلاد',
            'national_id' => 'الرقم الوطني',
            'phone' => 'رقم الهاتف',
            'email' => 'البريد الإلكتروني',
            'is_active' => 'نشط',
            'signals' => 'الإشارات',
            'signal_id' => 'رقم عقد الإشارة',
            'signal_date' => 'تاريخ الإشارة',
            'type' => 'نوع الإشارة',
            'signal_source' => 'الجهة',
            'signal_source_number' => 'رقم الكتاب',
            'signal_source_date' => 'تاريخ الكتاب',
            'signal_owners' => 'أصحاب الإشارة',
            'owner_from_owner' => 'من المالكين',
            'owner_name' => 'اسم المالك',
            'signal_victims' => 'المتضررون',
            'victim_from_owner' => 'من المالكين',
            'victim_owner_id' => 'المالك المتضرر',
            'victim_name' => 'اسم المتضرر',
            'files' => 'الملفات',
            'file_upload' => 'رفع الملف',
            'file_name' => 'اسم الملف',
            'file_issued_at' => 'تاريخ الإصدار',
            'payments' => 'الحركات المالية',
            'debit' => 'مدين',
            'credit' => 'دائن',
            'statement' => 'البيان',
            'voucher' => 'رقم السند',
            'payment_date' => 'تاريخ الحركة',
            'balance_movement' => 'حركة الرصيد',
            'currency' => 'العملة',
        ];

        return collect($errors)
            ->map(function (array $messages, string $field): string {
                $normalizedField = collect(explode('.', $field))
                    ->reject(fn (string $segment): bool => is_numeric($segment))
                    ->implode('.');
                $segments = explode('.', $normalizedField);
                $lastSegment = end($segments) ?: $normalizedField;
                $label = $fieldLabels[$normalizedField]
                    ?? $fieldLabels[$lastSegment]
                    ?? $normalizedField;
                $message = implode('، ', $messages);
                return "{$label}: {$message}";
            })
            ->implode("\n");
    }

    protected function getAllOwnerOptions(): array
    {
        return Owner::query()
            ->orderByRaw('coalesce(company_name, full_name)')
            ->get()
            ->mapWithKeys(fn (Owner $owner) => [$owner->getKey() => $owner->display_name])
            ->all();
    }

    protected function resolveOwnerNameFromAllOwners(mixed $ownerId): ?string
    {
        if (! filled($ownerId)) {
            return null;
        }

        $options = $this->getAllOwnerOptions();

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
            $column = null;

            if (preg_match("/Column '([^']+)' cannot be null/i", $message, $match)) {
                $column = $match[1];
            }

            if (! $column && preg_match("/Field '([^']+)' doesn't have a default value/i", $message, $match)) {
                $column = $match[1];
            }

            if (! $column && preg_match('/null value in column \"([^\"]+)\"/i', $message, $match)) {
                $column = $match[1];
            }

            if (! $column && preg_match('/fails? to satisfy NOT NULL constraint/i', $message)) {
                if (preg_match('/column \"([^\"]+)\"/i', $message, $match)) {
                    $column = $match[1];
                }
            }

            return $column
                ? "تعذر تنفيذ العملية لأن الحقل \"{$column}\" إلزامي أو لا يملك قيمة افتراضية. يرجى تعبئته."
                : 'تعذر تنفيذ العملية بسبب حقل إلزامي فارغ أو لا يملك قيمة افتراضية. راجع القيم المدخلة.';
        }

        return 'تعذر تنفيذ العملية بسبب قيد في قاعدة البيانات. يرجى مراجعة القيم المدخلة.';
    }


}
