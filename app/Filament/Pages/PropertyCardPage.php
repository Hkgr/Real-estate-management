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
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;



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
                                       ->acceptedFileTypes([
                                            'application/pdf',
                                            'image/*',
                                            'application/vnd.ms-excel',
                                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                            'application/msword',
                                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                        ])
                                        ->maxSize(51200)
                                        ->helperText('مسموح: PDF، صور، Excel، Word حتى 50MB.')
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
                    ->description('جميع القيم بالدولار الأمريكي.')
                    ->collapsible()
                    ->schema([
                        Grid::make(12)->schema([
                            TextInput::make('payments_total_debit')
                                ->label('مجمل المدين')
                                ->hint('قراءة فقط')
                                ->disabled()
                                ->dehydrated(false)
                                ->formatStateUsing(fn (Get $get) => (string) collect($get('payments') ?? [])
                                    ->sum(fn ($row) => (float) ($row['debit'] ?? 0)))
                                ->extraAttributes([
                                    'class' => 'bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 rounded-md px-3 py-2',
                                ])
                                ->columnSpan(['default' => 12, 'md' => 4]),

                            TextInput::make('payments_total_credit')
                                ->label('مجمل الدائن')
                                ->hint('قراءة فقط')
                                ->disabled()
                                ->dehydrated(false)
                                ->formatStateUsing(fn (Get $get) => (string) collect($get('payments') ?? [])
                                    ->sum(fn ($row) => (float) ($row['credit'] ?? 0)))
                                ->extraAttributes([
                                    'class' => 'bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 rounded-md px-3 py-2',
                                ])
                                ->columnSpan(['default' => 12, 'md' => 4]),

                            TextInput::make('payments_total_balance')
                                ->label('مجموع الرصيد')
                                ->hint('قراءة فقط')
                                ->disabled()
                                ->dehydrated(false)
                                ->formatStateUsing(fn (Get $get) => (string) (collect($get('payments') ?? [])
                                    ->sum(fn ($row) => (float) ($row['debit'] ?? 0))
                                    - collect($get('payments') ?? [])
                                        ->sum(fn ($row) => (float) ($row['credit'] ?? 0))))
                                ->extraAttributes([
                                    'class' => 'bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 rounded-md px-3 py-2',
                                ])
                                ->columnSpan(['default' => 12, 'md' => 4]),
                        ]),



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
        // ✅ لأن الحفظ يدوي عندك — لا تستخدم relationship هنا
        // ->relationship('ownerships')
        ->addActionLabel('إضافة مالك')
        ->reorderable()

        // ✅ ضروري لأنك تعمل UUID keys عند التحميل، بينما الحفظ اليدوي يحتاج list
        ->dehydrateStateUsing(fn ($state) => array_values($state ?? []))

        ->itemLabel(function (array $state): string {
            $name = $this->resolveOwnerNameFromAllOwners($state['owner_id'] ?? null);
            return filled($name) ? $name : 'مالك';
        })

        ->schema([
            // ✅ نحتاجه للحفظ اليدوي (update/delete by id) لكن لن يذهب للـ DB لأنك لا تحفظه ضمن allowed
            Hidden::make('id'),

            Grid::make(12)->schema([
                // =========================
                // المالك
                // =========================
                Select::make('owner_id')
                    ->label('المالك')
                    ->prefixIcon('heroicon-o-user')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->options(fn () => $this->getAllOwnerOptions())
                    ->getSearchResultsUsing(function (string $search): array {
                        return Owner::query()
                            ->where(function ($q) use ($search) {
                                $q->where('full_name', 'like', "%{$search}%")
                                  ->orWhere('company_name', 'like', "%{$search}%");
                            })
                            ->orderByRaw('coalesce(company_name, full_name)')
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(fn (Owner $o) => [$o->getKey() => $o->display_name])
                            ->all();
                    })
                    ->getOptionLabelUsing(fn ($value): ?string => Owner::find($value)?->display_name)
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

                        Toggle::make('is_active')
                            ->label('فعّال')
                            ->default(true)
                            ->live(),
                    ])
                    ->createOptionUsing(fn (array $data): int => Owner::create($data)->id)
                    ->required()
                    ->columnSpan(['default' => 12, 'md' => 6]),

                // =========================
                // معيار + قيمة
                // =========================
                Select::make('ownership_metric')
                    ->label('معيار التملك')
                    ->prefixIcon('heroicon-o-scale')
                    ->native(false)
                    ->options(['أسهم' => 'أسهم', 'نسبة مئوية' => 'نسبة مئوية', 'م²' => 'م²'])
                    ->required()
                    ->live()
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

                // =========================
                // حالات + تواريخ
                // =========================
                Toggle::make('is_current')
                    ->label('مالك حالي')
                    ->default(true)
                    ->live()
                    ->columnSpan(['default' => 6, 'md' => 3]),

                DatePicker::make('purchase_date')
                    ->label('تاريخ الشراء')
                    ->nullable()
                    ->live(onBlur: true)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
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
                    ->live()
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                    ->columnSpan(['default' => 12, 'md' => 6]),

                DatePicker::make('sale_date')
                    ->label('تاريخ البيع')
                    ->nullable()
                    ->live(onBlur: true)
                    ->visible(fn (Get $get) => ! (bool) $get('is_current'))
                    ->dehydrateStateUsing(fn ($state, Get $get) => (bool) $get('is_current') ? null : (filled($state) ? $state : null))
                    ->columnSpan(['default' => 12, 'md' => 3]),

                // =========================
                // تفاصيل حكم قضائي
                // =========================
                Grid::make(12)
                    ->schema([
                        TextInput::make('case_number')
                            ->label('رقم الأساس')
                            ->prefixIcon('heroicon-o-hashtag')
                            ->maxLength(100)
                            ->required(fn (Get $get) => $get('purchase_method') === 'court_judgment')
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state, Get $get) => $get('purchase_method') === 'court_judgment' ? (filled($state) ? $state : null) : null)
                            ->columnSpan(['default' => 12, 'md' => 3]),

                        TextInput::make('decision_number')
                            ->label('رقم القرار')
                            ->prefixIcon('heroicon-o-hashtag')
                            ->maxLength(100)
                            ->required(fn (Get $get) => $get('purchase_method') === 'court_judgment')
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state, Get $get) => $get('purchase_method') === 'court_judgment' ? (filled($state) ? $state : null) : null)
                            ->columnSpan(['default' => 12, 'md' => 3]),

                        TextInput::make('authority')
                            ->label('الجهة')
                            ->prefixIcon('heroicon-o-building-library')
                            ->maxLength(150)
                            ->required(fn (Get $get) => $get('purchase_method') === 'court_judgment')
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state, Get $get) => $get('purchase_method') === 'court_judgment' ? (filled($state) ? $state : null) : null)
                            ->columnSpan(['default' => 12, 'md' => 4]),

                        DatePicker::make('judgment_date')
                            ->label('تاريخ الحكم')
                            ->required(fn (Get $get) => $get('purchase_method') === 'court_judgment')
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state, Get $get) => $get('purchase_method') === 'court_judgment' ? (filled($state) ? $state : null) : null)
                            ->columnSpan(['default' => 12, 'md' => 2]),
                    ])
                    ->visible(fn (Get $get) => $get('purchase_method') === 'court_judgment')
                    ->columnSpanFull(),

                // =========================
                // تفاصيل عقد عادي
                // =========================
                Grid::make(12)
                    ->schema([
                        DatePicker::make('regular_contract_date')
                            ->label('تاريخ العقد')
                            ->required(fn (Get $get) => $get('purchase_method') === 'regular_contract')
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state, Get $get) => $get('purchase_method') === 'regular_contract' ? (filled($state) ? $state : null) : null)
                            ->columnSpan(['default' => 12, 'md' => 6]),
                    ])
                    ->visible(fn (Get $get) => $get('purchase_method') === 'regular_contract')
                    ->columnSpanFull(),

                // =========================
                // تفاصيل عقد سجل تجاري
                // =========================
                Grid::make(12)
                    ->schema([
                        TextInput::make('contract_number')
                            ->label('رقم العقد')
                            ->prefixIcon('heroicon-o-document-duplicate')
                            ->maxLength(100)
                            ->required(fn (Get $get) => $get('purchase_method') === 'commercial_register_contract')
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state, Get $get) => $get('purchase_method') === 'commercial_register_contract' ? (filled($state) ? $state : null) : null)
                            ->columnSpan(['default' => 12, 'md' => 6]),

                        DatePicker::make('commercial_contract_date')
                            ->label('تاريخ عقد السجل')
                            ->required(fn (Get $get) => $get('purchase_method') === 'commercial_register_contract')
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state, Get $get) => $get('purchase_method') === 'commercial_register_contract' ? (filled($state) ? $state : null) : null)
                            ->columnSpan(['default' => 12, 'md' => 6]),
                    ])
                    ->visible(fn (Get $get) => $get('purchase_method') === 'commercial_register_contract')
                    ->columnSpanFull(),
            ]),
        ]);
}

protected function signalsRepeater(): Repeater
{
    // تحويل أي شكل (UUID keyed / list / JSON string) إلى list نظيف
    $toList = function (mixed $state): array {
        $state = $this->decodeJsonToArray($state);

        if (! is_array($state)) {
            return [];
        }

        return array_is_list($state) ? $state : array_values($state);
    };

    // إعادة keying للواجهة (Repeater يفضل مفاتيح ثابتة)
    $uuidKeyed = function (array $rows): array {
        return collect($rows)
            ->mapWithKeys(fn (array $row) => [Str::uuid()->toString() => $row])
            ->all();
    };

    return Repeater::make('signals')
        ->label('الإشارات')
        ->default([])
        ->dehydrateStateUsing(fn ($state) => array_values($state ?? []))
        ->addActionLabel('إضافة إشارة')
        ->reorderable()
        ->itemLabel(fn (array $state) => filled($state['signal_id'] ?? null) ? ('إشارة #' . $state['signal_id']) : 'إشارة')

        // ✅ التطبيع قبل الحفظ (JSON owners/victims)
        ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
            $data['signal_owners']  = $this->normalizeSignalOwnersForStorage($data['signal_owners'] ?? []);
            $data['signal_victims'] = $this->normalizeSignalVictimsForStorage($data['signal_victims'] ?? []);

            return Arr::except($data, [
                // حقول قد تصل من toArray() أو علاقات
                'owners',
                'signal_victim_id',
                'signal_victim_from_owner',
                'signal_victim',
            ]);
        })

        ->schema([
            // ✅ مهم جداً لتحديث/عدم تكرار السجلات
            Hidden::make('id')->dehydrated(),

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
                ->defaultItems(0)
                // ✅ ضمان أن قيمة هذا الـ repeater تُرسل دائماً كـ list (بدون UUID keys)
                ->dehydrateStateUsing(fn ($state) => $toList($state))
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
                            ->required(fn (Get $get) => (bool) $get('owner_from_owner'))      // ✅
                            ->dehydrated(fn (Get $get) => (bool) $get('owner_from_owner'))    // ✅
                            ->placeholder('اختر مالكًا')
                            ->columnSpan(['default' => 12, 'md' => 5]),

                        TextInput::make('owner_name')
                            ->label('اسم صاحب الإشارة')
                            ->prefixIcon('heroicon-o-identification')
                            ->maxLength(150)
                            ->visible(fn (Get $get) => ! (bool) $get('owner_from_owner'))
                            ->required(fn (Get $get) => ! (bool) $get('owner_from_owner'))    // ✅
                            ->dehydrated(fn (Get $get) => ! (bool) $get('owner_from_owner'))  // ✅
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? trim((string) $state) : null)
                            ->placeholder('اكتب الاسم يدوياً')
                            ->columnSpan(['default' => 12, 'md' => 5]),
                    ]),
                ])
                // ✅ تحميل: stored(list/object/JSON) -> UI -> UUID keyed
                ->afterStateHydrated(function ($state, $set, Get $get) use ($toList, $uuidKeyed): void {
                    $values = $toList($state);

                    $rows = [];

                    if (count($values) > 0 && is_array($values[0] ?? null)) {
                        $first = $values[0];

                        // UI already
                        if (array_key_exists('owner_from_owner', $first)) {
                            $rows = $values;
                        }
                        // stored shape
                        elseif (array_key_exists('is_owner', $first)) {
                            $rows = collect($values)->map(function (array $item): array {
                                return [
                                    'owner_from_owner' => (bool) ($item['is_owner'] ?? false),
                                    'owner_id'         => $item['owner_id'] ?? null,
                                    'owner_name'       => $item['name'] ?? null,
                                ];
                            })->all();
                        }
                    }

                    // fallback من علاقة owners pivot إن كانت موجودة بالـ state
                    if (count($rows) === 0) {
                        $owners = $get('owners') ?? [];
                        if (is_array($owners) && count($owners) > 0) {
                            $rows = collect($owners)->map(function (array $owner): array {
                                return [
                                    'owner_from_owner' => true,
                                    'owner_id'         => $owner['id'] ?? null,
                                    'owner_name'       => $owner['display_name'] ?? $owner['full_name'] ?? null,
                                ];
                            })->all();
                        }
                    }

                    // fallback من legacy signal_owner
                    if (count($rows) === 0) {
                        $legacy = $get('signal_owner');
                        if (filled($legacy)) {
                            $rows = [[
                                'owner_from_owner' => false,
                                'owner_id'         => null,
                                'owner_name'       => (string) $legacy,
                            ]];
                        }
                    }

                    $rows = $this->deduplicateSignalOwnerUiRows($rows);

                    // نثبتها كمفاتيح UUID للواجهة
                    $set('signal_owners', $uuidKeyed($rows));
                }),

            // =========================
            // المدعى عليهم في الإشارة
            // =========================
            Repeater::make('signal_victims')
                ->label('المدعى عليهم في الإشارة')
                ->addActionLabel('إضافة مدعى عليه')
                ->default([])
                ->defaultItems(0)
                // ✅ ضمان list
                ->dehydrateStateUsing(fn ($state) => $toList($state))
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
                            ->columnSpan(['default' => 12, 'md' => 2]),

                        Select::make('victim_owner_id')
                            ->label('المالك')
                            ->prefixIcon('heroicon-o-user')
                            ->native(false)
                            ->searchable()
                            ->options(fn () => $this->getAllOwnerOptions())
                            ->visible(fn (Get $get) => (bool) $get('victim_from_owner'))
                            ->required(fn (Get $get) => (bool) $get('victim_from_owner'))      // ✅
                            ->dehydrated(fn (Get $get) => (bool) $get('victim_from_owner'))    // ✅
                            ->placeholder('اختر من المالكين')
                            ->columnSpan(['default' => 12, 'md' => 5]),

                        TextInput::make('victim_name')
                            ->label('اسم المدعى عليه')
                            ->prefixIcon('heroicon-o-identification')
                            ->maxLength(150)
                            ->visible(fn (Get $get) => ! (bool) $get('victim_from_owner'))
                            ->required(fn (Get $get) => ! (bool) $get('victim_from_owner'))    // ✅
                            ->dehydrated(fn (Get $get) => ! (bool) $get('victim_from_owner'))  // ✅
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? trim((string) $state) : null)
                            ->placeholder('اكتب الاسم يدوياً')
                            ->columnSpan(['default' => 12, 'md' => 5]),
                    ]),
                ])
                // ✅ تحميل: stored(list/object/JSON) -> UI -> UUID keyed
                ->afterStateHydrated(function ($state, $set, Get $get) use ($toList, $uuidKeyed): void {
                    $values = $toList($state);

                    $rows = [];

                    if (count($values) > 0 && is_array($values[0] ?? null)) {
                        $first = $values[0];

                        // UI already
                        if (array_key_exists('victim_from_owner', $first)) {
                            $rows = $values;
                        }
                        // stored shape
                        elseif (array_key_exists('is_owner', $first)) {
                            $rows = collect($values)->map(function (array $item): array {
                                return [
                                    'victim_from_owner' => (bool) ($item['is_owner'] ?? false),
                                    'victim_owner_id'   => $item['owner_id'] ?? null,
                                    'victim_name'       => $item['name'] ?? null,
                                ];
                            })->all();
                        }
                    }

                    // fallback من legacy signal_victim
                    if (count($rows) === 0) {
                        $legacy = $get('signal_victim');
                        if (filled($legacy)) {
                            $rows = [[
                                'victim_from_owner' => false,
                                'victim_owner_id'   => null,
                                'victim_name'       => (string) $legacy,
                            ]];
                        }
                    }

                    $rows = $this->deduplicateSignalVictimUiRows($rows);

                    $set('signal_victims', $uuidKeyed($rows));
                }),
        ])
        ->columns(['default' => 1, 'md' => 2]);
}

private function deduplicateSignalOwnerUiRows(array $rows): array
{
    return collect($rows)
        ->filter(fn ($row) => is_array($row))
        ->map(function (array $row): array {
            return [
                'owner_from_owner' => (bool) ($row['owner_from_owner'] ?? false),
                'owner_id' => $row['owner_id'] ?? null,
                'owner_name' => isset($row['owner_name']) && is_string($row['owner_name'])
                    ? trim($row['owner_name'])
                    : ($row['owner_name'] ?? null),
            ];
        })
        ->unique(fn (array $row) => json_encode($row, JSON_UNESCAPED_UNICODE))
        ->values()
        ->all();
}

private function deduplicateSignalVictimUiRows(array $rows): array
{
    return collect($rows)
        ->filter(fn ($row) => is_array($row))
        ->map(function (array $row): array {
            return [
                'victim_from_owner' => (bool) ($row['victim_from_owner'] ?? false),
                'victim_owner_id' => $row['victim_owner_id'] ?? null,
                'victim_name' => isset($row['victim_name']) && is_string($row['victim_name'])
                    ? trim($row['victim_name'])
                    : ($row['victim_name'] ?? null),
            ];
        })
        ->unique(fn (array $row) => json_encode($row, JSON_UNESCAPED_UNICODE))
        ->values()
        ->all();
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
            ->dehydrateStateUsing(fn ($state) => array_values($state ?? []))
            ->live()
            ->addActionLabel('إضافة حركة')
            ->reorderable()
            ->itemLabel(fn (array $state) => filled($state['payment_date'] ?? null) ? ('حركة بتاريخ ' . $state['payment_date']) : 'حركة')
            ->schema([
                Hidden::make('id')
                    ->dehydrated(),

                DatePicker::make('payment_date')
                    ->label('التاريخ')
                    ->required()
                    ->live(debounce: 300),

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
                    ->live(debounce: 300)
                    ->helperText('القيمة بالدولار الأمريكي بتاريخ الحركة.')
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
            return $this->uniformAction(
                Action::make('update')
                    ->label('تعديل')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary')
                    ->disabled(fn () => blank($this->currentRecordId))
                    ->action(function () {

                        // ✅ تعريفه دائماً (حل نهائي للـ Undefined variable)
                        $validatedFiles = [];

                        if (! $this->currentRecordId) {
                            Notification::make()->title('ابحث/حمّل بطاقة أولاً')->warning()->send();
                            return;
                        }

                        $record = PropertyCard::find($this->currentRecordId);

                        if (! $record) {
                            $this->currentRecordId = null;
                            Notification::make()->title('السجل غير موجود')->danger()->send();
                            return;
                        }

                        // اربط الفورم بالسجل
                        $this->bindFormToRecord($record);

                        // ✅ Validate الفورم
                        try {
                            $this->form->validate();
                        } catch (ValidationException $exception) {
                            Notification::make()
                                ->title('يرجى تصحيح أخطاء الحقول')
                                ->body($this->formatValidationErrors($exception))
                                ->danger()
                                ->send();
                            return;
                        }

                        // ✅ payload
                        $state = $this->getFormPayload($this->form->getState());

                        // ✅ Validate الملفات (اختياري)
                        $tmp = $this->validateFileUploads($state['files'] ?? []);
                        if ($tmp === null) {
                            return; // الدالة نفسها سترسل Notification
                        }
                        $validatedFiles = $tmp; // الآن مضمون أنه array

                        // ✅ attributes
                        $attributes = Arr::except($state, [
                            'owners',
                            'ownerships',
                            'signals',
                            'payments',
                            'files',
                        ]);

                        // ✅ DB transaction (مثل باقي الأقسام)
                        try {
                            DB::transaction(function () use ($record, $attributes, $state) {
                                $record->update($attributes);

                                $this->persistOwnerships($record, $state['ownerships'] ?? []);
                                $this->persistPayments($record, $state['payments'] ?? []);
                                $this->persistSignals($record, $state['signals'] ?? []);
                            });
                        } catch (QueryException $exception) {
                            report($exception);
                            Notification::make()
                                ->title('فشل التعديل')
                                ->body($this->formatQueryExceptionMessage($exception))
                                ->danger()
                                ->send();
                            return;
                        } catch (\Throwable $exception) {
                            report($exception);
                            Notification::make()
                                ->title('فشل التعديل')
                                ->body($exception->getMessage())
                                ->danger()
                                ->send();
                            return;
                        }

                        // ✅ حفظ الملفات (خارج transaction)
                        try {
                            if (! empty($validatedFiles)) {
                                $this->storeValidatedFileUploads($record->refresh(), $validatedFiles);
                            }
                        } catch (\Throwable $exception) {
                            report($exception);
                            Notification::make()
                                ->title('تم حفظ البيانات لكن فشل رفع الملفات')
                                ->body($exception->getMessage())
                                ->danger()
                                ->send();
                            return;
                        }

                        // ✅ Reload UI
                        $this->loadRecordIntoForm($record->refresh());

                        Notification::make()->title('تم التعديل بنجاح')->success()->send();
                    })
            );
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
    // ✅ دائماً عرّفها لتفادي أي Undefined لاحقاً
    $validatedFiles = [];

    // 1) Validate form
    try {
        $this->form->validate();
    } catch (ValidationException $exception) {
        Notification::make()
            ->title('يرجى تصحيح أخطاء الحقول')
            ->body($this->formatValidationErrors($exception))
            ->danger()
            ->send();

        return null;
    }

    // 2) Payload
    $state = $this->getFormPayload($this->form->getState());

    // 3) Validate files (اختياري أثناء الإنشاء)
    $tmp = $this->validateFileUploads($state['files'] ?? []);
    if ($tmp === null) {
        return null; // الدالة نفسها تعرض Notification
    }
    $validatedFiles = $tmp;

    // 4) Key check
    $recordNumber = $state['card_record_number'] ?? null;
    if ($this->isMissingKeyValue($recordNumber)) {
        Notification::make()
            ->title('يرجى إدخال رقم المحضر')
            ->danger()
            ->send();

        return null;
    }

    // 5) Uniqueness (حتى مع soft delete)
    $existingRecord = PropertyCard::withTrashed()
        ->where('card_record_number', $recordNumber)
        ->first();

    if ($existingRecord) {
        Notification::make()
            ->title($existingRecord->trashed()
                ? 'هذا العقار موجود مسبقًا لكنه محذوف (Soft Delete). يرجى استعادته بدلًا من الإضافة.'
                : 'هذا العقار موجود مسبقًا بنفس المفتاح'
            )
            ->danger()
            ->send();

        return null;
    }

    // 6) Attributes فقط
    $attributes = Arr::except($state, [
        'owners',
        'ownerships',
        'signals',
        'payments',
        'files',
    ]);

    // 7) DB transaction
    try {
        $record = DB::transaction(function () use ($attributes, $state) {
            $record = PropertyCard::create($attributes);

            $this->persistOwnerships($record, $state['ownerships'] ?? []);
            $this->persistPayments($record, $state['payments'] ?? []);
            $this->persistSignals($record, $state['signals'] ?? []);

            return $record;
        });
    } catch (QueryException $exception) {
        report($exception);

        Notification::make()
            ->title('فشل الحفظ')
            ->body($this->formatQueryExceptionMessage($exception))
            ->danger()
            ->send();

        return null;
    } catch (\Throwable $exception) {
        report($exception);

        Notification::make()
            ->title('فشل الحفظ')
            ->body($exception->getMessage())
            ->danger()
            ->send();

        return null;
    }

    // 8) Files خارج transaction
    try {
        if (! empty($validatedFiles)) {
            $this->storeValidatedFileUploads($record, $validatedFiles);
        }
    } catch (\Throwable $exception) {
        report($exception);

        Notification::make()
            ->title('تم حفظ البطاقة لكن فشل رفع الملفات')
            ->body($exception->getMessage())
            ->danger()
            ->send();

        // لا نرجّع null لأن السجل انحفظ فعلاً
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

    $record->load('ownerships.owner', 'signals.owners', 'payments');

    $payload = $record->attributesToArray();

    // =========================
    // ownerships (UUID keyed + keep id)
    // =========================
    $payload['ownerships'] = $record->ownerships
        ->mapWithKeys(function ($o) {
            $row = Arr::except($o->toArray(), ['owner', 'created_at', 'updated_at', 'deleted_at']);
            $row['id'] = $o->getKey();
            return [Str::uuid()->toString() => $row];
        })
        ->all();

    // =========================
    // payments (UUID keyed + keep id)
    // =========================
    $payload['payments'] = $record->payments
        ->mapWithKeys(function ($p) {
            $row = Arr::except($p->toArray(), ['created_at', 'updated_at', 'deleted_at']);
            $row['id'] = $p->getKey();
            return [Str::uuid()->toString() => $row];
        })
        ->all();

    // =========================
    // signals (UUID keyed + convert owners/victims to UI shape + UUID keyed)
    // =========================
    $payload['signals'] = $record->signals
        ->mapWithKeys(function ($signal) {
            $signalPayload = Arr::except($signal->toArray(), ['owners', 'created_at', 'updated_at', 'deleted_at']);
            $signalPayload['id'] = $signal->getKey();

            // ---------
            // Owners: stored -> UI -> UUID keyed
            // ---------
            $ownersStored = $signalPayload['signal_owners'] ?? [];
            $ownersStored = $this->decodeJsonToArray($ownersStored);

            if (! is_array($ownersStored)) {
                $ownersStored = [];
            }

            $ownersValues = array_is_list($ownersStored) ? $ownersStored : array_values($ownersStored);
            $ownersUi = [];

            if (count($ownersValues) > 0) {
                $first = $ownersValues[0];

                // UI already
                if (is_array($first) && array_key_exists('owner_from_owner', $first)) {
                    $ownersUi = $ownersValues;
                }
                // stored shape: is_owner/owner_id/name
                elseif (is_array($first) && array_key_exists('is_owner', $first)) {
                    $ownersUi = collect($ownersValues)->map(function (array $item): array {
                        $isOwner = (bool) ($item['is_owner'] ?? false);

                        return [
                            'owner_from_owner' => $isOwner,
                            'owner_id'   => $isOwner ? ($item['owner_id'] ?? null) : null,
                            'owner_name' => $item['name'] ?? null,
                        ];
                    })->all();
                }
            }

            // fallback من علاقة owners pivot إذا JSON فارغ
            if (count($ownersUi) === 0 && $signal->relationLoaded('owners') && $signal->owners->count()) {
                $ownersUi = $signal->owners->map(function (Owner $owner): array {
                    return [
                        'owner_from_owner' => true,
                        'owner_id'   => $owner->getKey(),
                        'owner_name' => $owner->display_name,
                    ];
                })->all();
            }

            $ownersUi = $this->deduplicateSignalOwnerUiRows($ownersUi);

            $signalPayload['signal_owners'] = collect($ownersUi)
                ->mapWithKeys(fn (array $row) => [Str::uuid()->toString() => $row])
                ->all();

            // ---------
            // Victims: stored -> UI -> UUID keyed
            // ---------
            $victimsStored = $signalPayload['signal_victims'] ?? [];
            $victimsStored = $this->decodeJsonToArray($victimsStored);

            if (! is_array($victimsStored)) {
                $victimsStored = [];
            }

            $victimsValues = array_is_list($victimsStored) ? $victimsStored : array_values($victimsStored);
            $victimsUi = [];

            if (count($victimsValues) > 0) {
                $first = $victimsValues[0];

                // UI already
                if (is_array($first) && array_key_exists('victim_from_owner', $first)) {
                    $victimsUi = $victimsValues;
                }
                // stored shape: is_owner/owner_id/name
                elseif (is_array($first) && array_key_exists('is_owner', $first)) {
                    $victimsUi = collect($victimsValues)->map(function (array $item): array {
                        $isOwner = (bool) ($item['is_owner'] ?? false);

                        return [
                            'victim_from_owner' => $isOwner,
                            'victim_owner_id' => $isOwner ? ($item['owner_id'] ?? null) : null,
                            'victim_name'     => $item['name'] ?? null,
                        ];
                    })->all();
                }
            }

            $victimsUi = $this->deduplicateSignalVictimUiRows($victimsUi);

            $signalPayload['signal_victims'] = collect($victimsUi)
                ->mapWithKeys(fn (array $row) => [Str::uuid()->toString() => $row])
                ->all();

            return [Str::uuid()->toString() => $signalPayload];
        })
        ->all();

    // الملفات لا نملؤها من DB (واجهة فقط)
    $payload['files'] = [[]];

    $this->form->model($record)->fill($payload);
}


    protected function resetFileInputs(): void
    {
        $state = $this->form->getState();
        $state['files'] = [[]];
    $this->form->fill([
        'files' => [[]],
    ]);    }

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
        $downloadUrl = route('property-card-files.download', $file);
        $previewUrl  = route('property-card-files.download', ['propertyCardFile' => $file->id, 'preview' => 1]);

        $name = e($file->file_name ?? '—');

        $issuedAt = $file->issued_at?->format('d/m/Y');
        $issuedLabel = $issuedAt
            ? " <span class=\"text-xs text-gray-500\">({$issuedAt})</span>"
            : '';

        $downloadLink = "<a href=\"{$downloadUrl}\" class=\"text-primary-600 hover:underline\" download>تنزيل</a>";

        $previewLink = (is_string($file->mime_type) && (str_starts_with($file->mime_type, 'image/') || $file->mime_type === 'application/pdf'))
            ? " | <a href=\"{$previewUrl}\" class=\"text-primary-600 hover:underline\" target=\"_blank\" rel=\"noopener\">معاينة</a>"
            : '';

        // ✅ حذف مع تأكيد (Alpine موجود داخل Filament)
        $deleteButton = " | <button type=\"button\" class=\"text-danger-600 hover:underline\"
            x-on:click.prevent=\"if(confirm('هل أنت متأكد من حذف هذا الملف؟')) { \$wire.deleteUploadedFile({$file->id}) }\">
            حذف
        </button>";

        return "<li class=\"text-sm flex items-center justify-between gap-3\">
                    <div class=\"min-w-0\">
                        <span class=\"font-medium break-words\">{$name}</span>{$issuedLabel}
                    </div>
                    <div class=\"shrink-0 whitespace-nowrap\">
                        {$downloadLink}{$previewLink}{$deleteButton}
                    </div>
                </li>";
    });

    return new HtmlString('<ul class="space-y-2">' . $items->implode('') . '</ul>');
}


public function deleteUploadedFile(int $fileId): void
{
    if (! $this->currentRecordId) {
        Notification::make()->title('حمّل بطاقة أولاً')->warning()->send();
        return;
    }

    $file = PropertyCardFile::query()
        ->where('property_card_id', $this->currentRecordId)
        ->whereKey($fileId)
        ->first();

    if (! $file) {
        Notification::make()->title('الملف غير موجود')->warning()->send();
        return;
    }

    try {
        $disk = $file->storage_disk;
        $path = $file->storage_path;

        if (filled($disk) && filled($path) && Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }

        $file->delete();

        Notification::make()->title('تم حذف الملف')->success()->send();

        // يجبر Livewire يعيد رسم الـ Placeholder فوراً
        $this->dispatch('$refresh');
    } catch (\Throwable $e) {
        report($e);
        Notification::make()->title('فشل حذف الملف')->body($e->getMessage())->danger()->send();
    }
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
                        'mimetypes:application/pdf,image/jpeg,image/png,image/webp,image/gif,image/bmp,image/svg+xml,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'max:51200',
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

    protected function hasPendingChanges(PropertyCard $record, array $attributes, array $state): bool
    {
        $record->loadMissing('ownerships', 'payments', 'signals.owners');

        $currentAttributes = Arr::only($record->getAttributes(), array_keys($attributes));

        if ($this->normalizeForComparison($attributes) !== $this->normalizeForComparison($currentAttributes)) {
            return true;
        }

        if ($this->normalizeOwnershipsForComparison($state['ownerships'] ?? [])
            !== $this->normalizeOwnershipsForComparison($record->ownerships->toArray())) {
            return true;
        }

        if ($this->normalizePaymentsForComparison($state['payments'] ?? [])
            !== $this->normalizePaymentsForComparison($record->payments->toArray())) {
            return true;
        }

        if ($this->normalizeSignalsForComparison($state['signals'] ?? [])
            !== $this->normalizeSignalsForComparison($record->signals->toArray(), $record->signals->pluck('owners')->all())) {
            return true;
        }

        return false;
    }

    protected function normalizeOwnershipsForComparison(mixed $rows): array
    {
        $rows = $this->decodeJsonToArray($rows);

        if (! is_array($rows)) {
            return [];
        }

        $rows = array_is_list($rows) ? $rows : array_values($rows);

        $normalized = collect($rows)
            ->filter(fn ($row) => is_array($row))
            ->map(fn (array $row) => $this->normalizeForComparison(Arr::only($row, [
                'owner_id',
                'ownership_percentage',
                'ownership_metric',
                'is_current',
                'purchase_date',
                'sale_date',
                'purchase_method',
                'case_number',
                'decision_number',
                'authority',
                'judgment_date',
                'regular_contract_date',
                'contract_number',
                'commercial_contract_date',
            ])))
            ->map(fn (array $row) => array_filter($row, fn ($value) => $value !== null && $value !== ''))
            ->values();

        return $normalized
            ->sortBy(fn (array $row) => json_encode($row, JSON_UNESCAPED_UNICODE))
            ->values()
            ->all();
    }

    protected function normalizePaymentsForComparison(mixed $rows): array
    {
        $rows = $this->decodeJsonToArray($rows);

        if (! is_array($rows)) {
            return [];
        }

        $rows = array_is_list($rows) ? $rows : array_values($rows);

        $normalized = collect($rows)
            ->filter(fn ($row) => is_array($row))
            ->map(fn (array $row) => $this->normalizeForComparison(Arr::only($row, [
                'owner_id',
                'debit',
                'credit',
                'statement',
                'voucher',
                'payment_date',
                'balance_movement',
            ])))
            ->values();

        return $normalized
            ->sortBy(fn (array $row) => json_encode($row, JSON_UNESCAPED_UNICODE))
            ->values()
            ->all();
    }

    protected function normalizeSignalsForComparison(mixed $rows, array $signalOwners = []): array
    {
        $rows = $this->decodeJsonToArray($rows);

        if (! is_array($rows)) {
            return [];
        }

        $rows = array_is_list($rows) ? $rows : array_values($rows);

        $normalized = collect($rows)
            ->filter(fn ($row) => is_array($row))
            ->map(function (array $row, int $index) use ($signalOwners): array {
                $ownersFromRelation = $signalOwners[$index] ?? [];

                if ($ownersFromRelation instanceof \Illuminate\Support\Collection) {
                    $ownersFromRelation = $ownersFromRelation->pluck('id')->all();
                }

                $ownerIds = collect($this->normalizeSignalOwnersForStorage($row['signal_owners'] ?? []))
                    ->filter(fn (array $owner) => (bool) ($owner['is_owner'] ?? false) && filled($owner['owner_id'] ?? null))
                    ->pluck('owner_id')
                    ->map(fn ($ownerId) => (int) $ownerId)
                    ->merge(collect($ownersFromRelation)->map(fn ($ownerId) => (int) $ownerId))
                    ->unique()
                    ->sort()
                    ->values()
                    ->all();

                return [
                    'signal_id' => $row['signal_id'] ?? null,
                    'signal_date' => $this->normalizeForComparison($row['signal_date'] ?? null),
                    'type' => $row['type'] ?? null,
                    'signal_source' => $row['signal_source'] ?? null,
                    'signal_source_number' => $row['signal_source_number'] ?? null,
                    'signal_source_date' => $this->normalizeForComparison($row['signal_source_date'] ?? null),
                    'signal_owners' => collect($this->normalizeSignalOwnersForStorage($row['signal_owners'] ?? []))
                        ->sortBy(fn (array $owner) => json_encode($this->normalizeForComparison($owner), JSON_UNESCAPED_UNICODE))
                        ->values()
                        ->all(),
                    'signal_victims' => collect($this->normalizeSignalVictimsForStorage($row['signal_victims'] ?? []))
                        ->sortBy(fn (array $victim) => json_encode($this->normalizeForComparison($victim), JSON_UNESCAPED_UNICODE))
                        ->values()
                        ->all(),
                    'owner_ids' => $ownerIds,
                ];
            })
            ->map(fn (array $row) => $this->normalizeForComparison($row))
            ->values();

        return $normalized
            ->sortBy(fn (array $row) => json_encode($row, JSON_UNESCAPED_UNICODE))
            ->values()
            ->all();
    }

    protected function normalizeForComparison(mixed $value): mixed
    {
        if ($value instanceof Carbon) {
            return $value->toDateString();
        }

        if (is_array($value)) {
            if (! array_is_list($value)) {
                ksort($value);
            }

            foreach ($value as $key => $item) {
                $value[$key] = $this->normalizeForComparison($item);
            }

            return $value;
        }

        if (is_bool($value)) {
            return (int) $value;
        }

        return $value;
    }

    protected function formatValidationErrors(ValidationException $exception): string
    {
    $errors = $exception->errors();

    if (! is_array($errors) || empty($errors)) {
        return 'يرجى مراجعة الأخطاء.';
    }

    $lines = [];

    foreach ($errors as $field => $messages) {
        foreach ((array) $messages as $msg) {
            $lines[] = "• {$msg}";
        }
    }

    return implode("\n", $lines);
    }
protected function formatQueryExceptionMessage(QueryException $exception): string
{
    $sqlState  = $exception->errorInfo[0] ?? (string) $exception->getCode();
    $errno     = $exception->errorInfo[1] ?? null;
    $driverMsg = $exception->errorInfo[2] ?? $exception->getMessage();

    $sql = method_exists($exception, 'getSql') ? (string) $exception->getSql() : null;
    $bindings = method_exists($exception, 'getBindings') ? (array) $exception->getBindings() : [];

    // قصّ النصوص الطويلة
    $driverMsg = is_string($driverMsg) ? trim($driverMsg) : '—';

    if ($sql && mb_strlen($sql) > 900) {
        $sql = mb_substr($sql, 0, 900) . ' ...';
    }

    $bindingsJson = ! empty($bindings)
        ? json_encode($bindings, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        : null;

    if ($bindingsJson && mb_strlen($bindingsJson) > 900) {
        $bindingsJson = mb_substr($bindingsJson, 0, 900) . ' ...';
    }

    $hint = $this->mysqlHintFromException($errno, $driverMsg);

    $lines = [];
    $lines[] = "SQLSTATE: {$sqlState}";
    if ($errno !== null) $lines[] = "Errno: {$errno}";
    $lines[] = "Message: {$driverMsg}";
    if ($hint) $lines[] = "Hint: {$hint}";
    if ($sql) $lines[] = "SQL: {$sql}";
    if ($bindingsJson) $lines[] = "Bindings: {$bindingsJson}";

    return implode("\n", $lines);
}

    private function mysqlHintFromException(mixed $errno, string $message): string
{
    $errno = is_numeric($errno) ? (int) $errno : null;

    // 1062 Duplicate entry
    if ($errno === 1062) {
        $key = null;
        $entry = null;

        if (preg_match("/Duplicate entry '([^']+)'/u", $message, $m)) {
            $entry = $m[1] ?? null;
        }
        if (preg_match("/for key '([^']+)'/u", $message, $m)) {
            $key = $m[1] ?? null;
        }

        $parts = [];
        $parts[] = "تكرار قيمة ضمن فهرس UNIQUE.";
        if ($key)   $parts[] = "الـ Key: {$key}";
        if ($entry) $parts[] = "القيمة: {$entry}";

        // تلميح خاص بمشكلتك (pivot + NULL)
        $parts[] = "إذا كان التكرار على جدول pivot مثل owner_property_card: انتبه أن UNIQUE مع أعمدة Nullable يسمح بتكرار NULL في MySQL، وقد تحتاج جعل الحقول غير Nullable أو تعديل الـ unique index.";

        return implode(' ', $parts);
    }

    // 1452 Foreign key fails
    if ($errno === 1452) {
        return "فشل قيد Foreign Key: يوجد owner_id / property_card_id يشير لسجل غير موجود، أو ترتيب الحفظ غير صحيح.";
    }

    // 1048 Column cannot be null
    if ($errno === 1048) {
        if (preg_match("/Column '([^']+)' cannot be null/u", $message, $m)) {
            return "الحقل '{$m[1]}' لا يقبل NULL. تأكد أنه مُعبّأ أو غيّر المايغريشن ليكون nullable.";
        }
        return "حقل لا يقبل NULL تم تمريره فارغاً.";
    }

    // 1364 Field doesn't have a default value
    if ($errno === 1364) {
        if (preg_match("/Field '([^']+)' doesn't have a default value/u", $message, $m)) {
            return "الحقل '{$m[1]}' مطلوب ولا يوجد Default. إمّا تملؤه أو تجعله nullable/Default في المايغريشن.";
        }
        return "حقل مطلوب بدون Default.";
    }

    // 1406 Data too long
    if ($errno === 1406) {
        if (preg_match("/Data too long for column '([^']+)'/u", $message, $m)) {
            return "القيمة أطول من طول العمود '{$m[1]}'.";
        }
        return "قيمة أطول من طول العمود.";
    }

    // 1265 Data truncated
    if ($errno === 1265) {
        return "تم اقتطاع البيانات (Data truncated) غالباً بسبب نوع enum/decimal أو تاريخ غير صالح.";
    }

    // fallback
    return "";
}
private function nullifyEmptyStrings(array $data): array
{
    foreach ($data as $k => $v) {
        if (is_string($v) && trim($v) === '') {
            $data[$k] = null;
        }
    }
    return $data;
}
protected function persistOwnerships(PropertyCard $record, mixed $rows): void
{
    $rows = $this->decodeJsonToArray($rows);

    if (! is_array($rows)) {
        $rows = [];
    }

    // يدعم UUID keyed أو list
    $rows = array_is_list($rows) ? $rows : array_values($rows);

    $allowed = [
        'owner_id',
        'ownership_metric',
        'ownership_percentage',
        'is_current',
        'purchase_date',
        'sale_date',
        'purchase_method',
        'case_number',
        'decision_number',
        'authority',
        'judgment_date',
        'regular_contract_date',
        'contract_number',
        'commercial_contract_date',
    ];

    $incomingIds = collect($rows)
        ->pluck('id')
        ->filter()
        ->map(fn ($id) => (int) $id)
        ->unique()
        ->values()
        ->all();

    // احذف ما تم إزالته من الواجهة
    $record->ownerships()
        ->when(count($incomingIds) > 0, fn ($q) => $q->whereNotIn('id', $incomingIds))
        ->when(count($incomingIds) === 0, fn ($q) => $q) // لو ما في أي id incoming احذف الكل
        ->delete();

    foreach ($rows as $row) {
        if (! is_array($row)) continue;

        $id = isset($row['id']) ? (int) $row['id'] : null;

        $data = Arr::only($row, $allowed);
        $data = $this->nullifyEmptyStrings($data);

        // تجاهل صف ناقص
        if (! filled($data['owner_id'] ?? null)) continue;
        if (! filled($data['ownership_metric'] ?? null)) continue;
        if (! isset($data['ownership_percentage'])) continue;

        if ($id) {
            $existing = $record->ownerships()->whereKey($id)->first();
            if ($existing) {
                $existing->update($data);
                continue;
            }
        }

        // create جديد (بدون id)
        $record->ownerships()->create($data);
    }
}
protected function persistPayments(PropertyCard $record, mixed $rows): void
{
    $rows = $this->decodeJsonToArray($rows);

    if (! is_array($rows)) {
        $rows = [];
    }

    $rows = array_is_list($rows) ? $rows : array_values($rows);
    $totalDebit = 0.0;
    $totalCredit = 0.0;

    $allowed = [
        'debit',
        'credit',
        'statement',
        'voucher',
        'payment_date',
        'balance_movement',
    ];

    $incomingIds = collect($rows)
        ->pluck('id')
        ->filter()
        ->map(fn ($id) => (int) $id)
        ->unique()
        ->values()
        ->all();

    $record->payments()
        ->when(count($incomingIds) > 0, fn ($q) => $q->whereNotIn('id', $incomingIds))
        ->when(count($incomingIds) === 0, fn ($q) => $q)
        ->delete();

    foreach ($rows as $row) {
        if (! is_array($row)) continue;

        $id = isset($row['id']) ? (int) $row['id'] : null;

        $data = Arr::only($row, $allowed);
        $data = $this->nullifyEmptyStrings($data);

        $totalDebit += (float) ($data['debit'] ?? 0);
        $totalCredit += (float) ($data['credit'] ?? 0);


        if (! filled($data['payment_date'] ?? null)) continue;

        if ($id) {
            $existing = $record->payments()->whereKey($id)->first();
            if ($existing) {
                $existing->update($data);
                continue;
            }
        }

        $record->payments()->create($data);
    }
        $record->update([
        'final_balance' => $totalDebit - $totalCredit,
    ]);

}

protected function persistSignals(PropertyCard $record, mixed $rows): void
{
    $rows = $this->decodeJsonToArray($rows);

    if (! is_array($rows)) {
        $rows = [];
    }

    $rows = array_is_list($rows) ? $rows : array_values($rows);

    $allowed = [
        'signal_id',
        'signal_date',
        'type',
        'signal_source',
        'signal_source_number',
        'signal_source_date',
        'signal_owners',
        'signal_victims',
        'signal_owner',   // legacy إن وجد
        'signal_victim',  // legacy إن وجد
    ];

    $incomingIds = collect($rows)
        ->pluck('id')
        ->filter()
        ->map(fn ($id) => (int) $id)
        ->unique()
        ->values()
        ->all();

    // soft delete لمن تم حذفه من الواجهة
    $record->signals()
        ->when(count($incomingIds) > 0, fn ($q) => $q->whereNotIn('id', $incomingIds))
        ->when(count($incomingIds) === 0, fn ($q) => $q)
        ->delete();

    foreach ($rows as $row) {
        if (! is_array($row)) continue;

        $id = isset($row['id']) ? (int) $row['id'] : null;

        $data = Arr::only($row, $allowed);
        $data = $this->nullifyEmptyStrings($data);

        // تطبيع JSON owners/victims قبل التخزين
        $data['signal_owners']  = $this->normalizeSignalOwnersForStorage($data['signal_owners'] ?? []);
        $data['signal_victims'] = $this->normalizeSignalVictimsForStorage($data['signal_victims'] ?? []);

        if (! filled($data['signal_id'] ?? null)) continue;
        if (! filled($data['type'] ?? null)) continue;

        if ($id) {
            $signal = $record->signals()->whereKey($id)->first();
            if ($signal) {
                $signal->update($data);
            } else {
                $signal = $record->signals()->create($data);
            }
        } else {
            $signal = $record->signals()->create($data);
        }

        // sync pivot owners
        $ownerIds = collect($data['signal_owners'])
            ->filter(fn (array $o) => (bool) ($o['is_owner'] ?? false) && filled($o['owner_id'] ?? null))
            ->pluck('owner_id')
            ->map(fn ($x) => (int) $x)
            ->unique()
            ->values()
            ->all();

        $signal->owners()->sync($ownerIds);
    }
}

private function signalOwnersToUiKeyed(mixed $stored, $ownersRelation = null): array
{
    $stored = $this->decodeJsonToArray($stored);

    $rows = [];

    if (is_array($stored) && count($stored) > 0) {
        $values = array_is_list($stored) ? $stored : array_values($stored);
        $first  = $values[0] ?? null;

        // إذا كانت UI already (owner_from_owner)
        if (is_array($first) && array_key_exists('owner_from_owner', $first)) {
            $rows = $values;
        }
        // إذا كانت stored shape (is_owner)
        elseif (is_array($first) && array_key_exists('is_owner', $first)) {
            foreach ($values as $item) {
                if (! is_array($item)) continue;

                $isOwner = (bool) ($item['is_owner'] ?? false);

                $rows[] = [
                    'owner_from_owner' => $isOwner,
                    'owner_id'   => $isOwner ? ($item['owner_id'] ?? null) : null,
                    'owner_name' => $isOwner ? ($item['name'] ?? null) : ($item['name'] ?? null),
                ];
            }
        }
    }

    // fallback من علاقة owners pivot إن كان JSON فارغ
    if (count($rows) === 0 && $ownersRelation && $ownersRelation instanceof \Illuminate\Support\Collection && $ownersRelation->count()) {
        $rows = $ownersRelation->map(fn ($o) => [
            'owner_from_owner' => true,
            'owner_id'   => $o->getKey(),
            'owner_name' => $o->display_name ?? $o->full_name ?? null,
        ])->all();
    }

    $rows = $this->deduplicateSignalOwnerUiRows($rows);

    return collect($rows)
        ->mapWithKeys(fn (array $row) => [Str::uuid()->toString() => $row])
        ->all();
}

private function signalVictimsToUiKeyed(mixed $stored): array
{
    $stored = $this->decodeJsonToArray($stored);

    $rows = [];

    if (is_array($stored) && count($stored) > 0) {
        $values = array_is_list($stored) ? $stored : array_values($stored);
        $first  = $values[0] ?? null;

        // UI already (victim_from_owner)
        if (is_array($first) && array_key_exists('victim_from_owner', $first)) {
            $rows = $values;
        }
        // stored shape (is_owner)
        elseif (is_array($first) && array_key_exists('is_owner', $first)) {
            foreach ($values as $item) {
                if (! is_array($item)) continue;

                $isOwner = (bool) ($item['is_owner'] ?? false);

                $rows[] = [
                    'victim_from_owner' => $isOwner,
                    'victim_owner_id' => $isOwner ? ($item['owner_id'] ?? null) : null,
                    'victim_name'     => $isOwner ? ($item['name'] ?? null) : ($item['name'] ?? null),
                ];
            }
        }
    }

    $rows = $this->deduplicateSignalVictimUiRows($rows);

    return collect($rows)
        ->mapWithKeys(fn (array $row) => [Str::uuid()->toString() => $row])
        ->all();
}


}


