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
use Filament\Forms\Components\ToggleButtons;
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
use Illuminate\Support\Carbon;
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

    public function updated(string $propertyName): void
    {
        if (! str_starts_with($propertyName, 'data.')) {
            return;
        }

        try {
            $this->form->validate();
        } catch (ValidationException) {
            // Filament/Livewire سيعرض الأخطاء
        }
    }

    // =========================
    // Form
    // =========================

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                // 1) المفتاح + الحالة (توزيع مريح)
                Section::make('المفتاح (بحث تلقائي)')
                    ->description('اكتب رقم المحضر ثم اخرج من الحقل ليتم تحميل بطاقة العقار تلقائياً إن وُجد.')
                    ->schema([
                        Grid::make(12)->schema([
                            TextInput::make('card_record_number')
                                ->label('رقم المحضر')
                                ->prefixIcon('heroicon-o-key')
                                ->maxLength(50)
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn () => $this->tryAutoSearch())
                                ->placeholder('مثال: 2024/105')
                                ->columnSpan(['default' => 12, 'md' => 8]),

                            Select::make('card_status')
                                ->label('حالة العقار')
                                ->prefixIcon('heroicon-o-check-badge')
                                ->native(false)
                                ->options([
                                    'active' => 'فاعل',
                                    'frozen' => 'مجمد',
                                ])
                                ->required()
                                ->live(onBlur: true)
                                ->columnSpan(['default' => 12, 'md' => 4]),
                        ]),
                    ]),

                // 2) ملخص سريع (مفيد أثناء الإدخال)
                Section::make('ملخص سريع')
                    ->visible(fn () => filled($this->currentRecordId))
                    ->schema([
                        Grid::make(12)->schema([
                            Placeholder::make('summary_owners')
                                ->label('الملاك')
                                ->content(fn (Get $get) => (string) count($get('ownerships') ?? []))
                                ->columnSpan(['default' => 6, 'md' => 3]),

                            Placeholder::make('summary_signals')
                                ->label('الإشارات')
                                ->content(fn (Get $get) => (string) count($get('signals') ?? []))
                                ->columnSpan(['default' => 6, 'md' => 3]),

                            Placeholder::make('summary_files')
                                ->label('الملفات')
                                ->content(fn () => $this->currentRecordId
                                    ? (string) PropertyCardFile::where('property_card_id', $this->currentRecordId)->count()
                                    : '0'
                                )
                                ->columnSpan(['default' => 6, 'md' => 3]),

                            Placeholder::make('summary_payments')
                                ->label('الحركات')
                                ->content(fn (Get $get) => (string) count($get('payments') ?? []))
                                ->columnSpan(['default' => 6, 'md' => 3]),
                        ]),
                    ]),

                // 3) البيانات الأساسية (Grid 12 منطقي)
                Section::make('البيانات الأساسية')
                    ->schema([
                        Grid::make(12)->schema([
                            TextInput::make('card_governorate')
                                ->label('المحافظة')
                                ->prefixIcon('heroicon-o-map')
                                ->maxLength(100)
                                ->required()
                                ->live(onBlur: true)
                                ->placeholder('مثال: حلب')
                                ->columnSpan(['default' => 12, 'md' => 3]),

                            TextInput::make('card_region_name')
                                ->label('اسم المنطقة')
                                ->prefixIcon('heroicon-o-map-pin')
                                ->maxLength(255)
                                ->required()
                                ->live(onBlur: true)
                                ->placeholder('مثال: الحمدانية')
                                ->columnSpan(['default' => 12, 'md' => 5]),

                            TextInput::make('card_subdivision')
                                ->label('المقسم')
                                ->prefixIcon('heroicon-o-squares-2x2')
                                ->maxLength(100)
                                ->nullable()
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                ->placeholder('مثال: المقسم 22')
                                ->columnSpan(['default' => 12, 'md' => 2]),

                            Select::make('card_investment_type')
                                ->label('نوع الاستثمار')
                                ->prefixIcon('heroicon-o-building-office-2')
                                ->native(false)
                                ->options([
                                    'سكني' => 'سكني',
                                    'تجاري' => 'تجاري',
                                    'أرض زراعية' => 'أرض زراعية',
                                    'صناعي' => 'صناعي',
                                ])
                                ->nullable()
                                ->live(onBlur: true)
                                ->columnSpan(['default' => 12, 'md' => 2]),

                            TextInput::make('card_google_maps_url')
                                ->label('رابط خريطة Google')
                                ->prefixIcon('heroicon-o-globe-alt')
                                ->url()
                                ->maxLength(2048)
                                ->nullable()
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                ->helperText('ألصق رابط الموقع من Google Maps.')
                                ->placeholder('https://maps.google.com/?q=...')
                                ->columnSpan(['default' => 12, 'md' => 8]),

                            Textarea::make('card_property_details')
                                ->label('تفصيل العقار')
                                ->rows(3)
                                ->nullable()
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                ->columnSpan(12)
                                ->placeholder('اختياري'),
                        ]),
                    ]),

                // 4) المساحات + مؤشر مجموع التملك (مريح بصرياً)
                Section::make('المساحات والملكية')
                    ->schema([
                        Grid::make(12)->schema([
                            TextInput::make('card_total_area')
                                ->label('مساحة العقار الكلية')
                                ->prefixIcon('heroicon-o-arrows-pointing-out')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(9999999999.99)
                                ->required()
                                ->live(onBlur: true)
                                ->suffix('م²')
                                ->placeholder('مثال: 400')
                                ->columnSpan(['default' => 12, 'md' => 4]),

                            Placeholder::make('ownership_total_hint')
                                ->label('إجمالي التملك (حسب المعيار)')
                                ->content(function (Get $get): string {
                                    $rows = $get('ownerships') ?? [];
                                    if (! is_array($rows) || count($rows) === 0) {
                                        return '—';
                                    }

                                    $metrics = collect($rows)
                                        ->pluck('ownership_metric')
                                        ->filter()
                                        ->unique()
                                        ->values();

                                    if ($metrics->count() !== 1) {
                                        return '—';
                                    }

                                    $metric = $metrics->first();
                                    $sum = collect($rows)->sum(fn ($r) => (float) ($r['ownership_percentage'] ?? 0));

                                    $suffix = match ($metric) {
                                        'أسهم' => 'سهم',
                                        'نسبة مئوية' => '%',
                                        'م²' => 'م²',
                                        default => '',
                                    };

                                    $pretty = rtrim(rtrim(number_format($sum, 2, '.', ''), '0'), '.');

                                    return $pretty === '' ? '—' : ($pretty . ' ' . $suffix);
                                })
                                ->columnSpan(['default' => 12, 'md' => 8]),
                        ]),
                    ]),

                // 5) الملاك
                Section::make('الملاك')
                    ->description('إدخال سريع ومريح: اسم المالك + معيار التملك + طريقة الشراء، مع حقول تظهر حسب الاختيار.')
                    ->collapsible()
                    ->schema([
                        $this->ownershipsRepeater(),
                    ]),

                // 6) الإشارات
                Section::make('الإشارات')
                    ->collapsible()
                    ->schema([
                        $this->signalsRepeater(),
                    ]),

                // 7) ملفات البطاقة
                Section::make('ملفات البطاقة')
                    ->description('يمكنك رفع الملفات أثناء إنشاء البطاقة، وسيتم حفظها تلقائياً عند أول رفع.')
                    ->collapsible()
                    ->schema([
                        Repeater::make('files')
                            ->label('الملفات')
                            ->schema([
                                Grid::make(12)->schema([
                                    TextInput::make('file_name')
                                        ->label('اسم الملف')
                                        ->prefixIcon('heroicon-o-document-text')
                                        ->maxLength(255)
                                        ->nullable()
                                        ->live(onBlur: true)
                                        ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                        ->placeholder('مثال: سند الملكية')
                                        ->columnSpan(['default' => 12, 'md' => 5]),

                                    DatePicker::make('file_issued_at')
                                        ->label('تاريخ الإصدار')
                                        ->nullable()
                                        ->live(onBlur: true)
                                        ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                        ->columnSpan(['default' => 12, 'md' => 3]),

                                    FileUpload::make('file_upload')
                                        ->label('رفع الملف')
                                        ->multiple()
                                        ->storeFiles(false)
                                        ->live()
                                        ->acceptedFileTypes(['application/pdf', 'image/*'])
                                        ->helperText('مسموح: PDF أو صور فقط.')
                                        ->columnSpan(['default' => 12, 'md' => 4]),
                                ]),
                            ])
                            ->defaultItems(1),

                        Placeholder::make('uploaded_files')
                            ->label('الملفات المرفوعة')
                            ->content(fn () => $this->renderUploadedFiles())
                            ->visible(fn () => filled($this->currentRecordId))
                            ->columnSpanFull(),
                    ]),

                // 8) الدفعات
                Section::make('الدفعات')
                    ->collapsible()
                    ->schema([
                        $this->paymentsRepeater(),
                    ]),
            ])
            ->statePath('data')
            ->model(PropertyCard::class);
    }

    // =========================
    // Repeaters (توزيع مريح)
    // =========================

    protected function ownershipsRepeater(): Repeater
    {
        return Repeater::make('ownerships')
            ->label('الملاك')
            ->default([])
            ->relationship('ownerships')
            ->addActionLabel('إضافة مالك')
            ->reorderable()
            ->itemLabel(function (array $state): string {
                $name = $this->resolveOwnerNameFromAllOwners($state['owner_id'] ?? null);
                $metric = $state['ownership_metric'] ?? null;
                $value = $state['ownership_percentage'] ?? null;

                $suffix = match ($metric) {
                    'أسهم' => 'سهم',
                    'نسبة مئوية' => '%',
                    'م²' => 'م²',
                    default => '',
                };

                $left = $name ?: 'مالك';
                $right = ($value !== null && $value !== '') ? ($value . ' ' . $suffix) : '';

                return trim($left . ($right ? (' — ' . $right) : ''));
            })
            ->schema([
                Grid::make(12)->schema([

                    // Row 1: المالك + معيار + قيمة
                    Select::make('owner_id')
                        ->label('المالك')
                        ->prefixIcon('heroicon-o-user')
                        ->relationship('owner', 'full_name')
                        ->getOptionLabelFromRecordUsing(fn ($record) => $record->display_name)
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            ToggleButtons::make('owner_type')
                                ->label('نوع المالك')
                                ->options(['individual' => 'فرد', 'company' => 'شركة'])
                                ->required()
                                ->default('individual')
                                ->live()
                                ->inline(),

                            TextInput::make('full_name')
                                ->label('اسم المالك (للفرد) أو اسم المفوض')
                                ->prefixIcon('heroicon-o-identification')
                                ->required(fn (Get $get) => $get('owner_type') === 'individual')
                                ->maxLength(200)
                                ->live(onBlur: true)
                                ->columnSpanFull(),

                            TextInput::make('company_name')
                                ->label('اسم الشركة')
                                ->prefixIcon('heroicon-o-building-office')
                                ->maxLength(200)
                                ->visible(fn (Get $get) => $get('owner_type') === 'company')
                                ->required(fn (Get $get) => $get('owner_type') === 'company')
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                            TextInput::make('commercial_register_number')
                                ->label('رقم السجل التجاري')
                                ->prefixIcon('heroicon-o-clipboard-document-list')
                                ->maxLength(100)
                                ->visible(fn (Get $get) => $get('owner_type') === 'company')
                                ->required(fn (Get $get) => $get('owner_type') === 'company')
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                            DatePicker::make('birth_date')
                                ->label('تاريخ الميلاد')
                                ->visible(fn (Get $get) => $get('owner_type') === 'individual')
                                ->nullable()
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                            TextInput::make('national_id')
                                ->label('الرقم الوطني')
                                ->prefixIcon('heroicon-o-finger-print')
                                ->visible(fn (Get $get) => $get('owner_type') === 'individual')
                                ->required(fn (Get $get) => $get('owner_type') === 'individual')
                                ->maxLength(50)
                                ->live(onBlur: true)
                                ->unique(Owner::class, 'national_id'),

                            TextInput::make('phone')
                                ->label('رقم الهاتف')
                                ->prefixIcon('heroicon-o-phone')
                                ->tel()
                                ->maxLength(50)
                                ->nullable()
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                            TextInput::make('email')
                                ->label('البريد الإلكتروني')
                                ->prefixIcon('heroicon-o-envelope')
                                ->email()
                                ->maxLength(150)
                                ->nullable()
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                            Toggle::make('is_active')->label('فعّال')->default(false)->live(),
                        ])
                        ->createOptionUsing(fn (array $data): int => Owner::create($data)->id)
                        ->required()
                        ->columnSpan(['default' => 12, 'md' => 6]),

                    Select::make('ownership_metric')
                        ->label('معيار التملك')
                        ->prefixIcon('heroicon-o-scale')
                        ->native(false)
                        ->options(['أسهم' => 'أسهم', 'نسبة مئوية' => 'نسبة مئوية', 'م²' => 'م²'])
                        ->required()
                        ->live(onBlur: true)
                        ->columnSpan(['default' => 6, 'md' => 3]),

                    TextInput::make('ownership_percentage')
                        ->label('قيمة التملك')
                        ->prefixIcon('heroicon-o-calculator')
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
                        })
                        ->columnSpan(['default' => 6, 'md' => 3]),

                    // Row 2: حالات + تواريخ أساسية
                    Toggle::make('is_current')
                        ->label('مالك حالي')
                        ->default(false)
                        ->live()
                        ->columnSpan(['default' => 6, 'md' => 3]),

                    DatePicker::make('purchase_date')
                        ->label('تاريخ الشراء')
                        ->nullable()
                        ->live(onBlur: true)
                        ->columnSpan(['default' => 6, 'md' => 3]),

                    Select::make('purchase_method')
                        ->label('طريقة الشراء')
                        ->prefixIcon('heroicon-o-document-text')
                        ->native(false)
                        ->options([
                            'court_judgment' => 'حكم قضائي',
                            'regular_contract' => 'عقد عادي',
                            'commercial_register_contract' => 'عقد سجل تجاري',
                        ])
                        ->nullable()
                        ->live(onBlur: true)
                        ->columnSpan(['default' => 12, 'md' => 6]),

                    DatePicker::make('sale_date')
                        ->label('تاريخ البيع')
                        ->nullable()
                        ->live(onBlur: true)
                        ->visible(fn (Get $get) => ! (bool) $get('is_current'))
                        ->columnSpan(['default' => 12, 'md' => 3]),

                    // Blocks: تفاصيل حسب الطريقة (تظهر بانسيابية)
                    Grid::make(12)
                        ->schema([
                            TextInput::make('case_number')
                                ->label('رقم الأساس')
                                ->prefixIcon('heroicon-o-hashtag')
                                ->maxLength(100)
                                ->required()
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                ->columnSpan(['default' => 12, 'md' => 3]),

                            TextInput::make('decision_number')
                                ->label('رقم القرار')
                                ->prefixIcon('heroicon-o-hashtag')
                                ->maxLength(100)
                                ->required()
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                ->columnSpan(['default' => 12, 'md' => 3]),

                            TextInput::make('authority')
                                ->label('الجهة')
                                ->prefixIcon('heroicon-o-building-library')
                                ->maxLength(150)
                                ->required()
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                ->columnSpan(['default' => 12, 'md' => 4]),

                            DatePicker::make('judgment_date')
                                ->label('تاريخ الحكم')
                                ->required()
                                ->live(onBlur: true)
                                ->columnSpan(['default' => 12, 'md' => 2]),
                        ])
                        ->visible(fn (Get $get) => $get('purchase_method') === 'court_judgment')
                        ->columnSpanFull(),

                    Grid::make(12)
                        ->schema([
                            DatePicker::make('regular_contract_date')
                                ->label('تاريخ العقد')
                                ->required()
                                ->live(onBlur: true)
                                ->columnSpan(['default' => 12, 'md' => 6]),
                        ])
                        ->visible(fn (Get $get) => $get('purchase_method') === 'regular_contract')
                        ->columnSpanFull(),

                    Grid::make(12)
                        ->schema([
                            TextInput::make('contract_number')
                                ->label('رقم العقد')
                                ->prefixIcon('heroicon-o-document-duplicate')
                                ->maxLength(100)
                                ->required()
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                ->columnSpan(['default' => 12, 'md' => 6]),

                            DatePicker::make('commercial_contract_date')
                                ->label('تاريخ عقد السجل')
                                ->required()
                                ->live(onBlur: true)
                                ->columnSpan(['default' => 12, 'md' => 6]),
                        ])
                        ->visible(fn (Get $get) => $get('purchase_method') === 'commercial_register_contract')
                        ->columnSpanFull(),
                ]),
            ]);
    }

protected function signalsRepeater(): Repeater
{
    return Repeater::make('signals')
        ->label('الإشارات')
        ->default([])
        ->relationship('signals')
        ->addActionLabel('إضافة إشارة')
        ->reorderable()
        ->itemLabel(fn (array $state) => filled($state['signal_id'] ?? null) ? ('إشارة #' . $state['signal_id']) : 'إشارة')

        // ✅ أهم تعديل: التطبيع النهائي قبل الحفظ (يدعم UI-shape و stored-shape و UUID-keyed و JSON string)
        ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
            $data['signal_owners']  = $this->normalizeSignalOwnersForStorage($data['signal_owners'] ?? []);
            $data['signal_victims'] = $this->normalizeSignalVictimsForStorage($data['signal_victims'] ?? []);

            return Arr::except($data, [
                // قد تأتي من toArray() أو علاقات أو حقول قديمة
                'owners',
                'signal_victim_id',
                'signal_victim_from_owner',
                'signal_victim',
            ]);
        })

        ->schema([

            // =========================
            // معلومات الإشارة الأساسية
            // =========================
            Grid::make(12)->schema([
                TextInput::make('signal_id')
                    ->label('رقم الإشارة')
                    ->prefixIcon('heroicon-o-hashtag')
                    ->maxLength(50)
                    ->required()
                    ->live(onBlur: true)
                    ->columnSpan(['default' => 12, 'md' => 3]),

                DatePicker::make('signal_date')
                    ->label('تاريخ الإشارة')
                    ->required()
                    ->live(onBlur: true)
                    ->columnSpan(['default' => 12, 'md' => 3]),

                Select::make('type')
                    ->label('نوع الإشارة')
                    ->prefixIcon('heroicon-o-tag')
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
                    ->columnSpan(['default' => 12, 'md' => 6]),
            ]),

            Grid::make(12)->schema([
                TextInput::make('signal_source')
                    ->label('الجهة/المصدر')
                    ->prefixIcon('heroicon-o-building-library')
                    ->maxLength(150)
                    ->nullable()
                    ->live(onBlur: true)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                    ->columnSpan(['default' => 12, 'md' => 5]),

                TextInput::make('signal_source_number')
                    ->label('رقم الجهة')
                    ->prefixIcon('heroicon-o-hashtag')
                    ->maxLength(50)
                    ->nullable()
                    ->live(onBlur: true)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                    ->columnSpan(['default' => 12, 'md' => 3]),

                DatePicker::make('signal_source_date')
                    ->label('تاريخ الجهة')
                    ->nullable()
                    ->live(onBlur: true)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                    ->columnSpan(['default' => 12, 'md' => 4]),
            ]),

            // =========================
            // أصحاب الإشارة
            // =========================
            Repeater::make('signal_owners')
                ->label('أصحاب الإشارة')
                ->addActionLabel('إضافة صاحب إشارة')
                ->default([])
                ->itemLabel(function (array $state): string {
                    $fromOwner = (bool) ($state['owner_from_owner'] ?? false);
                    $name = $fromOwner
                        ? $this->resolveOwnerNameFromAllOwners($state['owner_id'] ?? null)
                        : ($state['owner_name'] ?? null);

                    return filled($name) ? $name : 'صاحب إشارة';
                })
                ->schema([
                    Grid::make(12)->schema([
                        Toggle::make('owner_from_owner')
                            ->label('من المالكين')
                            ->default(true)
                            ->live()
                            ->columnSpan(['default' => 12, 'md' => 2]),

                        Select::make('owner_id')
                            ->label('المالك')
                            ->prefixIcon('heroicon-o-user')
                            ->native(false)
                            ->searchable()
                            ->options(fn () => $this->getAllOwnerOptions())
                            ->visible(fn (Get $get) => (bool) $get('owner_from_owner'))
                            ->placeholder('اختر مالكًا')
                            ->columnSpan(['default' => 12, 'md' => 5]),

                        TextInput::make('owner_name')
                            ->label('اسم صاحب الإشارة')
                            ->prefixIcon('heroicon-o-identification')
                            ->maxLength(150)
                            ->nullable()
                            ->live(onBlur: true)
                            ->visible(fn (Get $get) => ! (bool) $get('owner_from_owner'))
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                            ->placeholder('اكتب الاسم يدوياً')
                            ->columnSpan(['default' => 12, 'md' => 5]),
                    ]),
                ])
                ->defaultItems(0)

                // ✅ تعديل التحميل: يدعم stored list + stored object(UUID) + JSON string
                ->afterStateHydrated(function ($state, $set, Get $get): void {
                    $state = $this->decodeJsonToArray($state);

                    // إذا state associative و بصيغة الواجهة (owner_from_owner) لا تعيد keying
                    if (is_array($state) && ! array_is_list($state)) {
                        $firstVal = reset($state);
                        if (is_array($firstVal) && array_key_exists('owner_from_owner', $firstVal)) {
                            return;
                        }
                    }

                    $uuidKeyed = function (array $rows): array {
                        return collect($rows)
                            ->mapWithKeys(fn (array $row) => [\Illuminate\Support\Str::uuid()->toString() => $row])
                            ->all();
                    };

                    // إذا الداتا موجودة (سواء list أو associative) نحولها لصيغة UI
                    if (is_array($state) && count($state) > 0) {
                        $values = array_is_list($state) ? $state : array_values($state);
                        $first = $values[0] ?? null;

                        // إن كانت UI already
                        if (is_array($first) && array_key_exists('owner_from_owner', $first)) {
                            $set('signal_owners', $uuidKeyed($values));
                            return;
                        }

                        // stored shape: is_owner/owner_id/name
                        if (is_array($first) && array_key_exists('is_owner', $first)) {
                            $rows = collect($values)->map(function (array $item): array {
                                return [
                                    'owner_from_owner' => (bool) ($item['is_owner'] ?? false),
                                    'owner_id' => $item['owner_id'] ?? null,
                                    'owner_name' => $item['name'] ?? null,
                                ];
                            })->all();

                            $set('signal_owners', $uuidKeyed($rows));
                            return;
                        }
                    }

                    // fallback من علاقة owners (إن وجدت)
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

                    // fallback من حقل قديم signal_owner
                    $legacyOwner = $get('signal_owner');
                    if (filled($legacyOwner)) {
                        $set('signal_owners', $uuidKeyed([[
                            'owner_from_owner' => false,
                            'owner_id' => null,
                            'owner_name' => $legacyOwner,
                        ]]));
                    }
                }),

            // =========================
            // المدعى عليهم في الإشارة
            // =========================
            Repeater::make('signal_victims')
                ->label('المدعى عليهم في الإشارة')
                ->addActionLabel('إضافة مدعى عليه')
                ->default([])
                ->itemLabel(function (array $state): string {
                    $fromOwner = (bool) ($state['victim_from_owner'] ?? false);
                    $name = $fromOwner
                        ? $this->resolveOwnerNameFromAllOwners($state['victim_owner_id'] ?? null)
                        : ($state['victim_name'] ?? null);

                    return filled($name) ? $name : 'مدعى عليه';
                })
                ->schema([
                    Grid::make(12)->schema([
                        Toggle::make('victim_from_owner')
                            ->label('من المالكين')
                            ->default(true)
                            ->live()
                            ->reactive()
                            ->columnSpan(['default' => 12, 'md' => 2]),

                        Select::make('victim_owner_id')
                            ->label('المالك')
                            ->prefixIcon('heroicon-o-user')
                            ->native(false)
                            ->searchable()
                            ->options(fn () => $this->getAllOwnerOptions())
                            ->visible(fn (Get $get) => (bool) $get('victim_from_owner'))
                            ->placeholder('اختر من المالكين')
                            ->columnSpan(['default' => 12, 'md' => 5]),

                        TextInput::make('victim_name')
                            ->label('اسم المدعى عليه')
                            ->prefixIcon('heroicon-o-identification')
                            ->maxLength(150)
                            ->nullable()
                            ->live(onBlur: true)
                            ->visible(fn (Get $get) => ! (bool) $get('victim_from_owner'))
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                            ->placeholder('اكتب الاسم يدوياً')
                            ->columnSpan(['default' => 12, 'md' => 5]),
                    ]),
                ])
                ->defaultItems(0)

                // ✅ تعديل التحميل: يدعم stored list + stored object(UUID) + JSON string
                ->afterStateHydrated(function ($state, $set, Get $get): void {
                    $state = $this->decodeJsonToArray($state);

                    // إذا state associative و بصيغة الواجهة (victim_from_owner) لا تعيد keying
                    if (is_array($state) && ! array_is_list($state)) {
                        $firstVal = reset($state);
                        if (is_array($firstVal) && array_key_exists('victim_from_owner', $firstVal)) {
                            return;
                        }
                    }

                    $uuidKeyed = function (array $rows): array {
                        return collect($rows)
                            ->mapWithKeys(fn (array $row) => [\Illuminate\Support\Str::uuid()->toString() => $row])
                            ->all();
                    };

                    if (is_array($state) && count($state) > 0) {
                        $values = array_is_list($state) ? $state : array_values($state);
                        $first = $values[0] ?? null;

                        // UI already
                        if (is_array($first) && array_key_exists('victim_from_owner', $first)) {
                            $set('signal_victims', $uuidKeyed($values));
                            return;
                        }

                        // stored shape
                        if (is_array($first) && array_key_exists('is_owner', $first)) {
                            $rows = collect($values)->map(function (array $item): array {
                                return [
                                    'victim_from_owner' => (bool) ($item['is_owner'] ?? false),
                                    'victim_owner_id' => $item['owner_id'] ?? null,
                                    'victim_name' => $item['name'] ?? null,
                                ];
                            })->all();

                            $set('signal_victims', $uuidKeyed($rows));
                            return;
                        }
                    }

                    // fallback من حقل قديم signal_victim
                    $legacyVictim = $get('signal_victim');
                    if (filled($legacyVictim)) {
                        $set('signal_victims', $uuidKeyed([[
                            'victim_from_owner' => false,
                            'victim_owner_id' => null,
                            'victim_name' => $legacyVictim,
                        ]]));
                    }
                }),
        ])
        ->columns(['default' => 1, 'md' => 2]);
}
private function decodeJsonToArray(mixed $value): mixed
{
    if (! is_string($value)) {
        return $value;
    }

    $trimmed = trim($value);
    if ($trimmed === '' || ($trimmed[0] !== '[' && $trimmed[0] !== '{')) {
        return $value;
    }

    $decoded = json_decode($trimmed, true);
    return (json_last_error() === JSON_ERROR_NONE) ? $decoded : $value;
}

private function normalizeSignalOwnersForStorage(mixed $rows): array
{
    $rows = $this->decodeJsonToArray($rows);

    if (! is_array($rows)) {
        return [];
    }

    // إزالة UUID keys إن وجدت
    $rows = array_is_list($rows) ? $rows : array_values($rows);

    $out = [];

    foreach ($rows as $row) {
        if (! is_array($row)) {
            continue;
        }

        // حالة: stored shape موجودة أصلاً
        if (array_key_exists('is_owner', $row)) {
            $isOwner = (bool) ($row['is_owner'] ?? false);
            $ownerId = $row['owner_id'] ?? null;
            $name    = is_string($row['name'] ?? null) ? trim((string) $row['name']) : null;

            if ($isOwner) {
                if (! filled($ownerId)) {
                    continue;
                }
                $name = filled($name) ? $name : $this->resolveOwnerNameFromAllOwners($ownerId);

                $out[] = [
                    'is_owner' => true,
                    'owner_id' => $ownerId,
                    'name'     => filled($name) ? $name : null,
                ];
            } else {
                if (! filled($name)) {
                    continue;
                }
                $out[] = [
                    'is_owner' => false,
                    'owner_id' => null,
                    'name'     => $name,
                ];
            }

            continue;
        }

        // حالة: UI shape (owner_from_owner / owner_id / owner_name)
        $fromOwner = (bool) ($row['owner_from_owner'] ?? false);
        $ownerId   = $row['owner_id'] ?? null;
        $name      = is_string($row['owner_name'] ?? null) ? trim((string) $row['owner_name']) : null;

        if ($fromOwner) {
            if (! filled($ownerId)) {
                continue;
            }
            $resolved = $this->resolveOwnerNameFromAllOwners($ownerId);

            $out[] = [
                'is_owner' => true,
                'owner_id' => $ownerId,
                'name'     => filled($resolved) ? $resolved : null,
            ];
        } else {
            if (! filled($name)) {
                continue;
            }
            $out[] = [
                'is_owner' => false,
                'owner_id' => null,
                'name'     => $name,
            ];
        }
    }

    return $out;
}

private function normalizeSignalVictimsForStorage(mixed $rows): array
{
    $rows = $this->decodeJsonToArray($rows);

    if (! is_array($rows)) {
        return [];
    }

    // إزالة UUID keys إن وجدت
    $rows = array_is_list($rows) ? $rows : array_values($rows);

    $out = [];

    foreach ($rows as $row) {
        if (! is_array($row)) {
            continue;
        }

        // stored shape
        if (array_key_exists('is_owner', $row)) {
            $isOwner = (bool) ($row['is_owner'] ?? false);
            $ownerId = $row['owner_id'] ?? null;
            $name    = is_string($row['name'] ?? null) ? trim((string) $row['name']) : null;

            if ($isOwner) {
                if (! filled($ownerId)) {
                    continue;
                }
                $name = filled($name) ? $name : $this->resolveOwnerNameFromAllOwners($ownerId);

                $out[] = [
                    'is_owner' => true,
                    'owner_id' => $ownerId,
                    'name'     => filled($name) ? $name : null,
                ];
            } else {
                if (! filled($name)) {
                    continue;
                }
                $out[] = [
                    'is_owner' => false,
                    'owner_id' => null,
                    'name'     => $name,
                ];
            }

            continue;
        }

        // UI shape (victim_from_owner / victim_owner_id / victim_name)
        $fromOwner = (bool) ($row['victim_from_owner'] ?? false);
        $ownerId   = $row['victim_owner_id'] ?? null;
        $name      = is_string($row['victim_name'] ?? null) ? trim((string) $row['victim_name']) : null;

        if ($fromOwner) {
            if (! filled($ownerId)) {
                continue;
            }
            $resolved = $this->resolveOwnerNameFromAllOwners($ownerId);

            $out[] = [
                'is_owner' => true,
                'owner_id' => $ownerId,
                'name'     => filled($resolved) ? $resolved : null,
            ];
        } else {
            if (! filled($name)) {
                continue;
            }
            $out[] = [
                'is_owner' => false,
                'owner_id' => null,
                'name'     => $name,
            ];
        }
    }

    return $out;
}



    protected function paymentsRepeater(): Repeater
    {
        // ترتيب الحقول بصرياً: (تاريخ+عملة) ثم (مدين/دائن) ثم (سند/بيان) ثم (حركة الرصيد)
        return Repeater::make('payments')
            ->label('الدفعات')
            ->default([])
            ->relationship('payments')
            ->addActionLabel('إضافة حركة')
            ->reorderable()
            ->itemLabel(fn (array $state) => filled($state['payment_date'] ?? null) ? ('حركة بتاريخ ' . $state['payment_date']) : 'حركة')
            ->schema([
                DatePicker::make('payment_date')
                    ->label('التاريخ')
                    ->required()
                    ->live(onBlur: true),

                Select::make('currency')
                    ->label('العملة')
                    ->prefixIcon('heroicon-o-banknotes')
                    ->native(false)
                    ->options([
                        'syp_new' => 'ليرة سورية جديدة',
                        'syp_old' => 'ليرة سورية قديمة',
                        'usd' => 'دولار أمريكي',
                    ])
                    ->nullable()
                    ->live(onBlur: true),

                TextInput::make('debit')
                    ->label('مدين')
                    ->prefixIcon('heroicon-o-arrow-trending-down')
                    ->numeric()
                    ->minValue(0)
                    ->live(onBlur: true),

                TextInput::make('credit')
                    ->label('دائن')
                    ->prefixIcon('heroicon-o-arrow-trending-up')
                    ->numeric()
                    ->minValue(0)
                    ->live(onBlur: true),

                TextInput::make('voucher')
                    ->label('سند')
                    ->prefixIcon('heroicon-o-receipt-refund')
                    ->maxLength(150)
                    ->nullable()
                    ->live(onBlur: true)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                TextInput::make('statement')
                    ->label('البيان')
                    ->prefixIcon('heroicon-o-chat-bubble-left-right')
                    ->maxLength(255)
                    ->nullable()
                    ->live(onBlur: true)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

                TextInput::make('balance_movement')
                    ->label('حركة الرصيد')
                    ->prefixIcon('heroicon-o-arrows-right-left')
                    ->maxLength(255)
                    ->nullable()
                    ->live(onBlur: true)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),
            ])
            ->columns(['default' => 1, 'md' => 6]);
    }

    // =========================
    // Actions + UI
    // =========================

    protected function uniformAction(Action $action): Action
    {
        return $action
            ->button()
            ->outlined()
            ->size('sm')
            ->extraAttributes([
                'class' => 'transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0',
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
            ->color('success')
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
            ->color('gray')
            ->modalHeading('بحث عن بطاقة عقار')
            ->modalSubmitActionLabel('تحميل')
            ->form([
                TextInput::make('card_record_number')
                    ->label('رقم المحضر')
                    ->prefixIcon('heroicon-o-key')
                    ->maxLength(50)
                    ->required(),
            ])
            ->action(function (array $data) {
                $recordNumber = $data['card_record_number'] ?? null;

                $record = PropertyCard::query()
                    ->where('card_record_number', $recordNumber)
                    ->first();

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
            ->color('primary')
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

    public function updateAction(): Action
    {
        $action = Action::make('update')
            ->label('تعديل')
            ->icon('heroicon-o-pencil-square')
            ->color('primary')
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
            ->color('danger')
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
            ->label('تحميل PDF')
            ->icon('heroicon-o-document-arrow-down')
            ->color('warning')
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

                $filename = 'property-card-' . ($record->card_record_number ?? 'record') . '.pdf';

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
    // Helpers (باقي كودك كما هو: حفظ، ملفات، تهيئة..)
    // =========================

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
            Notification::make()->title('يرجى إدخال رقم المحضر')->danger()->send();
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

        $attributes = Arr::except($state, ['owners','ownerships','signals','payments','files']);

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
        if ($value === null) return true;
        if (is_string($value)) return trim($value) === '';
        return false;
    }

    protected function resolveChromePath(): string
    {
        $cmd = 'node -e "console.log(require(\'puppeteer\').executablePath())"';
        $path = trim((string) @shell_exec($cmd));

        if ($path && file_exists($path)) {
            return $path;
        }

        $candidates = [
            'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
            'C:\\Program Files (x86)\\Google\\Chrome\\Application\\chrome.exe',
        ];

        foreach ($candidates as $candidate) {
            if (file_exists($candidate)) return $candidate;
        }

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
        $payload['ownerships'] = $record->ownerships->map(fn ($o) => $o->toArray())->values()->all();

        $payload['signals'] = $record->signals->map(function ($signal) {
            $signalPayload = $signal->toArray();

            $normalizedOwners = $this->normalizeSignalOwnersForStorage($signalPayload['signal_owners'] ?? []);

            if (empty($normalizedOwners)) {
                $normalizedOwners = $signal->owners
                    ->map(fn (Owner $owner) => [
                        'is_owner' => true,
                        'owner_id' => $owner->getKey(),
                        'name' => $owner->display_name,
                    ])
                    ->values()
                    ->all();
            }

            $signalPayload['signal_owners'] = $normalizedOwners;
            $signalPayload['signal_victims'] = $this->normalizeSignalVictimsForStorage($signalPayload['signal_victims'] ?? []);
            unset($signalPayload['owners']);

            return $signalPayload;
        })->values()->all();


        $payload['payments'] = $record->payments->map(fn ($p) => $p->toArray())->values()->all();
        $payload['files'] = [];

        $this->bindFormToRecord($record);
        $this->form->fill($payload);
        $this->resetFileInputs();
    }

    protected function resetFileInputs(): void
    {
        $state = $this->form->getState();
        $state['files'] = [[]];
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
            $previewLink = (is_string($file->mime_type) && (str_starts_with($file->mime_type, 'image/') || $file->mime_type === 'application/pdf'))
                ? " | <a href=\"{$url}\" class=\"text-primary-600 hover:underline\" target=\"_blank\" rel=\"noopener\">معاينة</a>"
                : '';

            return "<li class=\"text-sm\"><span class=\"font-medium\">{$name}</span>{$issuedLabel} — {$downloadLink}{$previewLink}</li>";
        });

        return new HtmlString('<ul class="space-y-1">' . $items->implode('') . '</ul>');
    }

    protected function validateFileUploads(array $files, bool $requireFiles = false): ?array
    {
       $normalizedFiles = [];

        foreach (array_values($files) as $fileRow) {
            if (! is_array($fileRow)) {
                continue;
            }

            $inputName = isset($fileRow['file_name']) && is_string($fileRow['file_name'])
                ? trim($fileRow['file_name'])
                : null;
            $issuedAt = $fileRow['file_issued_at'] ?? null;
            $rawUploads = $fileRow['file_upload'] ?? [];

            if ($rawUploads instanceof UploadedFile) {
                $rawUploads = [$rawUploads];
            }

            if (! is_array($rawUploads)) {
                $rawUploads = [];
            }

            $uploads = collect($rawUploads)
                ->filter(fn (mixed $upload): bool => $upload instanceof UploadedFile)
                ->values();

            if ($uploads->isEmpty()) {
                continue;
            }

            foreach ($uploads as $upload) {
                $entry = [
                    'file_name' => filled($inputName) ? $inputName : $upload->getClientOriginalName(),
                    'file_issued_at' => filled($issuedAt) ? $issuedAt : null,
                    'file_upload' => $upload,
                ];

                $validator = Validator::make($entry, [
                    'file_name' => ['required', 'string', 'max:255'],
                    'file_issued_at' => ['nullable', 'date'],
                    'file_upload' => [
                        'required',
                        'file',
                        'mimetypes:application/pdf,image/jpeg,image/png,image/webp,image/gif,image/bmp,image/svg+xml',
                        'max:10240',
                    ],
                ]);

                if ($validator->fails()) {
                    Notification::make()
                        ->title('ملف غير صالح')
                        ->body($validator->errors()->first())
                        ->danger()
                        ->send();

                    return null;
                }

                $normalizedFiles[] = $entry;
            }
        }

        if ($requireFiles && count($normalizedFiles) === 0) {
            Notification::make()
                ->title('يرجى اختيار ملف واحد على الأقل')
                ->danger()
                ->send();

            return null;
        }

        return $normalizedFiles;

    }

    protected function storeValidatedFileUploads(PropertyCard $record, array $files): bool
    {
        if (count($files) === 0) {
            return true;
        }

        $storage = app(PropertyCardFileStorage::class);

        try {
            foreach ($files as $file) {
                if (! isset($file['file_upload']) || ! ($file['file_upload'] instanceof UploadedFile)) {
                    continue;
                }

                $issuedAt = filled($file['file_issued_at'] ?? null)
                    ? Carbon::parse((string) $file['file_issued_at'])
                    : null;

                $storage->store(
                    propertyCard: $record,
                    file: $file['file_upload'],
                    issuedAt: $issuedAt,
                    fileName: $file['file_name'] ?? null,
                );
            }
        } catch (\Throwable $exception) {
            Notification::make()
                ->title('تعذر حفظ الملفات')
                ->body($exception->getMessage())
                ->danger()
                ->send();

            return false;
        }

        $this->resetFileInputs();
        return true;
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
        if (! filled($ownerId)) return null;
        $options = $this->getAllOwnerOptions();
        return $options[$ownerId] ?? null;
    }

    protected function syncSignalOwners(PropertyCard $record, array $state): void
    {
        $signalsState = $state['signals'] ?? [];

        if (! is_array($signalsState)) {
            return;
        }

        $signalsState = array_is_list($signalsState) ? $signalsState : array_values($signalsState);

        $signalsById = collect($signalsState)
            ->filter(fn ($signal) => is_array($signal) && filled($signal['id'] ?? null))
            ->keyBy(fn ($signal) => (int) $signal['id']);

        $record->loadMissing('signals');

        foreach ($record->signals as $index => $signal) {
            $signalState = $signalsById->get($signal->getKey(), $signalsState[$index] ?? []);

            if (! is_array($signalState)) {
                $signal->owners()->sync([]);
                continue;
            }

            $normalizedOwners = $this->normalizeSignalOwnersForStorage($signalState['signal_owners'] ?? []);

            $ownerIds = collect($normalizedOwners)
                ->filter(fn (array $owner) => (bool) ($owner['is_owner'] ?? false) && filled($owner['owner_id'] ?? null))
                ->pluck('owner_id')
                ->map(fn ($ownerId) => (int) $ownerId)
                ->unique()
                ->values()
                ->all();

            $signal->owners()->sync($ownerIds);
        }
    }

    protected function formatValidationErrors(ValidationException $exception): string
    {
        // استخدم كودك الحالي كما هو (لم أغيّره)
        return 'يرجى مراجعة الأخطاء.';
    }

    protected function formatQueryExceptionMessage(QueryException $exception): string
    {
        // استخدم كودك الحالي كما هو (لم أغيّره)
        return 'تعذر تنفيذ العملية بسبب قيد في قاعدة البيانات.';
    }
}
