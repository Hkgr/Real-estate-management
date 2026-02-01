<?php

namespace App\Filament\Pages;

use App\Models\PropertyCard;
use BackedEnum;
use UnitEnum;
use App\Models\Owner;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Spatie\Browsershot\Browsershot;

use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\HTMLParserMode;

class PropertyCardPage extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static ?string $title = 'بطاقة العقار';
    protected static ?string $navigationLabel = 'بطاقة العقار (جديدة)';
    protected static UnitEnum|string|null $navigationGroup = 'العقارات';
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $slug = 'property-card';

    public function getView(): string
    {
        return 'filament.pages.property-card-page';
    }

    public ?int $currentRecordId = null;

    public array $data = [];

    public function mount(): void
    {
        $this->resetCardForm();
    }

    // =========================
    // Form
    // =========================

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('المفتاح (اكتب وسيتم البحث تلقائياً)')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('card_cadastral_zone_number')
                                ->label('رقم المنطقة العقارية')
                                ->maxLength(50)
                                ->required()
                                ->lazy()
                                ->afterStateUpdated(fn () => $this->tryAutoSearch())
                                ->placeholder('مثال: 12A'),

                            TextInput::make('card_property_number')
                                ->label('رقم العقار')
                                ->maxLength(50)
                                ->required()
                                ->lazy()
                                ->afterStateUpdated(fn () => $this->tryAutoSearch())
                                ->placeholder('مثال: 105'),
                        ]),
                    ])
                    ->description('عند إدخال الرقمين والخروج من الحقل سيتم تحميل بيانات العقار إن وُجد.'),

                Section::make('البيانات الأساسية')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('card_governorate')
                                ->label('المحافظة')
                                ->maxLength(100)
                                ->required()
                                ->placeholder('مثال: حلب'),

                            TextInput::make('card_region_name')
                                ->label('اسم المنطقة')
                                ->required()
                                ->placeholder('مثال: الحمدانية'),

                            TextInput::make('card_subdivision')
                                ->label('المقسم')
                                ->maxLength(100)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                ->nullable()
                                ->placeholder('مثال: المقسم 22 '),

                            Select::make('card_status')
                                ->label('حالة العقار')
                                ->native(false)
                                ->options([
                                    'active' => 'فاعل',
                                    'frozen' => 'مجمد',
                                ])
                                ->required(),

                        ]),
                        DatePicker::make('card_sale_date')
                            ->label('تاريخ البيع')
                            ->nullable(),
                        Textarea::make('card_property_details')
                            ->label('تفصيل العقار')
                            ->rows(3)
                            ->nullable()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                            ->placeholder('اختياري'),

                    ]),

                Section::make('المساحات والملكية')
                    ->schema([
                        Grid::make(1)->schema([
                                                        Select::make('card_area_unit')
                                ->label('وحدة المساحة')
                                ->native(false)
                                ->options([
                                    'percentage' => 'نسبة مئوية (%)',
                                    'shares' => 'عدد الأسهم',
                                    'meters' => 'عدد الأمتار (م²)',
                                ])
                                ->default('meters')
                                ->required(),

                            TextInput::make('card_total_area')
                                ->label('مساحة العقار الكلية')
                                ->numeric()
                                ->minValue(0)
                                ->suffix(fn (Get $get) => match ($get('card_area_unit')) {
                                    'percentage' => '%',
                                    'shares' => 'سهم',
                                    'meters' => 'م²',
                                    default => null,
                                })

                                ->required()
                                ->placeholder('مثال: 400'),


                        ]),
                    ]),

  
                Section::make('المالكون')
                    ->schema([
                        Repeater::make('owners')
                            ->label('المالكون')
                            ->relationship('owners')
                            ->schema([
                                Select::make('owner_id')
                                    ->label('المالك')
                                    ->options(fn () => Owner::query()->pluck('full_name', 'id'))
                                    ->searchable()
                                    ->preload()
                                                                        ->createOptionForm([
                                        TextInput::make('full_name')
                                            ->label('الاسم الرباعي')
                                            ->required()
                                            ->maxLength(200)
                                            ->columnSpanFull(),
                                        DatePicker::make('birth_date')
                                            ->label('تاريخ الميلاد')
                                            ->nullable()
                                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),
                                        TextInput::make('national_id')
                                            ->label('الرقم الوطني')
                                            ->required()
                                            ->maxLength(50)
                                            ->unique(Owner::class, 'national_id'),
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
                                    ->createOptionUsing(function (array $data): int {
                                        return Owner::create($data)->id;
                                    })

                                    ->required(),
                                TextInput::make('ownership_percentage')
                                    ->label('قيمة التملك')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0)
                                    ->maxValue(fn (Get $get) => $get('ownership_metric') === 'percentage' ? 100 : null)
                                    ->suffix(fn (Get $get) => match ($get('ownership_metric')) {
                                        'percentage' => '%',
                                        'shares' => 'سهم',
                                        'meters' => 'م²',
                                        default => null,
                                    }),
                                Select::make('ownership_metric')

                                    ->label('معيار التملك')
                                                                        ->native(false)
                                    ->options([
                                        'percentage' => 'نسبة مئوية (%)',
                                        'shares' => 'عدد الأسهم',
                                        'meters' => 'عدد الأمتار (م²)',
                                    ])

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
                    ]),

                    Section::make('الموقع')
                    ->schema([
                        TextInput::make('card_google_maps_url')
                            ->label('رابط خريطة Google')
                            ->url()
                            ->nullable()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                            ->helperText('ألصق رابط الموقع من Google Maps لمساعدتنا في الوصول بدقة.')
                            ->placeholder('https://maps.google.com/?q=...'),

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
        $this->form->fill($record->load('owners')->toArray());
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
                    $this->form->validate();
                } catch (ValidationException $exception) {
                    Notification::make()
                        ->title('يرجى تصحيح أخطاء الحقول')
                        ->body($this->formatValidationErrors($exception))
                        ->danger()
                        ->send();
                    return;
                }

                $payload = $this->form->validate();
                $exists = PropertyCard::query()
                    ->where('card_cadastral_zone_number', $payload['card_cadastral_zone_number'])
                    ->where('card_property_number', $payload['card_property_number'])
                    ->exists();

                if ($exists) {
                    Notification::make()->title('هذا العقار موجود مسبقًا بنفس المفتاح')->danger()->send();
                    return;
                }

                try {
                    $record = PropertyCard::create($payload);
                    $this->form->model($record)->saveRelationships();
                } catch (QueryException $exception) {
                    Notification::make()
                        ->title('فشل الحفظ')
                        ->body($this->formatQueryExceptionMessage($exception))
                        ->danger()
                        ->send();

                    return;
                }

                $this->currentRecordId = $record->id;
                $this->form->fill($record->load('owners')->toArray());
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
                $this->form->fill($record->load('owners')->toArray());
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
                    $this->form->validate();
                } catch (ValidationException $exception) {
                    Notification::make()
                        ->title('يرجى تصحيح أخطاء الحقول')
                        ->body($this->formatValidationErrors($exception))
                        ->danger()
                        ->send();
                    return;
                }

                $payload = $this->form->validate();
                $record = PropertyCard::find($this->currentRecordId);
                if (! $record) {
                    $this->currentRecordId = null;
                    Notification::make()->title('السجل لم يعد موجودًا')->danger()->send();
                    return;
                }

                try {
                    $record->update($payload);
                    $this->form->model($record)->saveRelationships();
                } catch (QueryException $exception) {
                    Notification::make()
                        ->title('فشل التعديل')
                        ->body($this->formatQueryExceptionMessage($exception))
                        ->danger()
                        ->send();

                    return;
                }

                $this->form->fill($record->fresh()->load('owners')->toArray());
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
                'record' => $record,
            ])->render();

            // ✅ على ويندوز: استخدم Chromium الذي جاء مع puppeteer
            $chromePath = base_path('node_modules/puppeteer/.local-chromium/win64-*/chrome-win/chrome.exe');

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

protected function resolveChromePath(): string
{
    // 1) جرّب المسار الذي يحدده puppeteer تلقائياً
    $cmd = 'node -e "console.log(require(\'puppeteer\').executablePath())"';
    $path = trim((string) shell_exec($cmd));

    if ($path && file_exists($path)) {
        return $path;
    }

    // 2) جرّب Chrome النظام إن كان مثبتاً
    $candidates = [
        'C:\Program Files\Google\Chrome\Application\chrome.exe',
        'C:\Program Files (x86)\Google\Chrome\Application\chrome.exe',
    ];

    foreach ($candidates as $candidate) {
        if (file_exists($candidate)) {
            return $candidate;
        }
    }

    // 3) آخر حل: اتركه (سيعطي خطأ واضح)
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

protected function formatQueryExceptionMessage(QueryException $exception): string
{
    $sqlState = $exception->errorInfo[0] ?? null;
    $driverCode = $exception->errorInfo[1] ?? null;
    $message = $exception->errorInfo[2] ?? $exception->getMessage();

    if ($driverCode === 1062 || $sqlState === '23505' || str_contains($message, 'Duplicate entry')) {
        return 'تم رفض العملية بسبب مفتاح مكرر. يرجى التأكد من أن المفتاح فريد.';
    }

    if (in_array($driverCode, [1451, 1452], true) || $sqlState === '23503') {
        return 'تم رفض العملية بسبب قيد مرجعي (مفتاح خارجي). يرجى التحقق من العلاقات.';
    }

    return 'تعذر تنفيذ العملية بسبب قيد في قاعدة البيانات. يرجى مراجعة القيم المدخلة.';
}

}
