<?php

namespace App\Filament\Pages;

use App\Models\PropertyCard;
use App\Models\Owner;
use App\Models\PropertyOperation;
use BackedEnum;
use Filament\Actions\Action;
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
use Illuminate\Support\Facades\Hash;
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



class PropertyCardPage2 extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected const TOTAL_SHARES_REFERENCE = 2400.0;

    protected bool $isSyncingOperationDetails = false;
    protected bool $isSyncingOwnedPropertyValue = false;
    protected static ?string $title = 'بطاقة العقار';
    protected static ?string $navigationLabel = 'بطاقة العقار (الإصدار الثاني)';
    protected static UnitEnum|string|null $navigationGroup = 'العقارات';
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $slug = 'property-card-2';

    public ?int $currentRecordId = null;

    public array $data = [];

    public function getView(): string
    {
        return 'filament.pages.property-card-page-2';
    }

    public function mount(): void
    {
        $this->resetCardForm();
    }

public function updated(string $propertyName): void
{
    if ($this->isSyncingOperationDetails) {
        return;
    }

    $this->removeOperationConversionDetailsLines();

    // تغيير مساحة العقار → حدّث كل التحويلات
    if ($propertyName === 'data.card_total_area') {
        $this->recalculateOperationsTotalShares();
        $this->syncSpecialSharesDetailsLine('abdulqader_sankari_total_shares', 'الحصة الكلية للدكتور عبد القادر السنكري');
        $this->syncSpecialSharesDetailsLine('riyad_asali_total_shares', 'الحصة الكاملة لرياض عسلي');
    }

    if ($propertyName === 'data.abdulqader_sankari_total_shares') {
        $this->syncSpecialSharesDetailsLine('abdulqader_sankari_total_shares', 'الحصة الكلية للدكتور عبد القادر السنكري');
    }

    if ($propertyName === 'data.riyad_asali_total_shares') {
        $this->syncSpecialSharesDetailsLine('riyad_asali_total_shares', 'الحصة الكاملة لرياض عسلي');
    }

    // أي تعديل داخل العمليات على amount أو unit → حدّث مجموع الأسهم
    if (preg_match('/^data\.operations\.([^.]+)\.(transaction_amount|transaction_unit)$/u', $propertyName) === 1) {
        $this->recalculateOperationsTotalShares();
    }

    // إضافة/حذف/إعادة ترتيب ضمن operations غالباً يطلق updated على مسارات مختلفة → حدّث المجموع
    if (str_starts_with($propertyName, 'data.operations') && ! str_contains($propertyName, '.transaction_')) {
        $this->recalculateOperationsTotalShares();
    }

    if ($propertyName === 'data.owned_property_value_usd' && ! $this->isSyncingOwnedPropertyValue) {
        data_set($this->data, 'owned_value_manually_overridden', true);
    }

    if (in_array($propertyName, [
        'data.total_property_value_usd',
        'data.abdulqader_sankari_total_shares',
    ], true)) {
        $this->recalculateOwnedPropertyValueFromShares();
    }

    if (! str_starts_with($propertyName, 'data.')) {
        return;
    }

    try {
        $this->form->validate();
    } catch (ValidationException) {
        // Filament/Livewire سيعرض الأخطاء
    }
}

protected function recalculateOperationsTotalShares(): void
{
    $operations = data_get($this->data, 'operations', []);

    if (! is_array($operations)) {
        data_set($this->data, 'operations_total_shares', 0);
        return;
    }

    $totalArea = (float) data_get($this->data, 'card_total_area', 0);
    $sqmPerShare = $totalArea > 0 ? $totalArea / static::TOTAL_SHARES_REFERENCE : 0;

    $sum = 0.0;

    foreach ($operations as $row) {
        if (! is_array($row)) {
            continue;
        }

        $amount = (float) ($row['transaction_amount'] ?? 0);
        $unit = $this->normalizeTransactionUnit($row['transaction_unit'] ?? null);

        if ($amount <= 0 || ! filled($unit)) {
            continue;
        }

        if ($unit === 'shares') {
            $sum += $amount;
            continue;
        }

        if ($unit === 'square_meter' && $sqmPerShare > 0) {
            $sum += $amount / $sqmPerShare;
            continue;
        }

        if ($unit === 'percentage') {
            $sum += static::TOTAL_SHARES_REFERENCE * ($amount / 100);
        }
    }

    data_set($this->data, 'operations_total_shares', round($sum, 2));
}

protected function removeOperationConversionDetailsLines(): void
{
    $details = (string) data_get($this->data, 'card_property_details', '');

    if ($details === '') {
        return;
    }

    $lines = preg_split('/\R/u', $details) ?: [];

    $filtered = array_values(array_filter(
        $lines,
        fn (string $line): bool => ! str_starts_with(trim($line), 'تحويل مقدار التصرّف (')
    ));

    if (count($filtered) === count($lines)) {
        return;
    }

    $this->isSyncingOperationDetails = true;
    data_set($this->data, 'card_property_details', implode(PHP_EOL, $filtered));
    $this->isSyncingOperationDetails = false;
}

protected function recalculateOwnedPropertyValueFromShares(bool $force = false): void
{
    $isManuallyOverridden = (bool) data_get($this->data, 'owned_value_manually_overridden', false);

    if (! $force && $isManuallyOverridden) {
        return;
    }

    $calculatedValue = $this->calculateOwnedPropertyValueUsd(
        (float) data_get($this->data, 'total_property_value_usd', 0),
        (float) data_get($this->data, 'abdulqader_sankari_total_shares', 0),
    );

    $this->isSyncingOwnedPropertyValue = true;
    data_set($this->data, 'owned_property_value_usd', $calculatedValue);
    data_set($this->data, 'owned_value_manually_overridden', false);
    $this->isSyncingOwnedPropertyValue = false;
}

protected function calculateOwnedPropertyValueUsd(float $totalPropertyValueUsd, float $abdulqaderShares): float
{
    if ($totalPropertyValueUsd <= 0 || $abdulqaderShares <= 0 || static::TOTAL_SHARES_REFERENCE <= 0) {
        return 0.0;
    }

    return round(
        $totalPropertyValueUsd * ($abdulqaderShares / static::TOTAL_SHARES_REFERENCE),
        2,
    );
}

protected function syncSpecialSharesDetailsLine(string $field, string $label): void
{
    $shares = (float) data_get($this->data, $field, 0);
    $totalArea = (float) data_get($this->data, 'card_total_area', 0);

    $line = null;

    if ($shares > 0 && $totalArea > 0) {
        $sqmPerShare = $totalArea / 2400;
        $sharesPretty = $this->normalizeNumericValue($shares);
        $sqmPretty = $this->normalizeNumericValue($shares * $sqmPerShare);
        $sqmPerSharePretty = $this->normalizeNumericValue($sqmPerShare);

        $line = $label . ': '
            . $sharesPretty . ' سهم ≈ ' . $sqmPretty . ' م²'
            . ' (1 سهم = ' . $sqmPerSharePretty . ' م²).';
    }

    $this->upsertSpecialSharesDetailsLine($label, $line);
}

protected function upsertSpecialSharesDetailsLine(string $label, ?string $line): void
{
    $prefix = $label . ':';
    $details = (string) data_get($this->data, 'card_property_details', '');

    $lines = array_values(array_filter(
        preg_split('/\R/u', $details) ?: [],
        fn (string $existingLine): bool => ! str_starts_with(trim($existingLine), $prefix)
    ));

    if (filled($line)) {
        $lines[] = $line;
    }

    $this->isSyncingOperationDetails = true;
    data_set($this->data, 'card_property_details', implode(PHP_EOL, $lines));
    $this->isSyncingOperationDetails = false;
}

    protected function normalizeNumericValue(float $value): string
    {
        return rtrim(rtrim(number_format($value, 4, '.', ''), '0'), '.');
    }

    protected function normalizeTransactionUnit(mixed $unit): ?string
    {
        $unit = is_string($unit) ? trim($unit) : null;

        if ($unit === 'share') {
            return 'shares';
        }

        return filled($unit) ? $unit : null;
    }

    protected function formatDateForDisplay(mixed $date): string
    {
        if (! filled($date)) {
            return '';
        }

        try {
            return Carbon::parse((string) $date)->format('d/m/Y');
        } catch (\Throwable) {
            return (string) $date;
        }
    }

    protected function formatDateTimeForDisplay(mixed $date): string
    {
        if (! filled($date)) {
            return '-';
        }

        try {
            return Carbon::parse((string) $date)->format('d/m/Y');
        } catch (\Throwable) {
            return (string) $date;
        }
    }

    protected function dmyDateInput(string $name, string $label): TextInput
    {
        return TextInput::make($name)
            ->label($label)
            ->placeholder('dd-mm-yyyy')
            ->helperText('اكتب 8 أرقام: يوم(2) ثم شهر(2) ثم سنة(4) — مثال: 05032026')
            ->extraInputAttributes([
                'inputmode' => 'numeric',
                'dir' => 'ltr',
                'maxlength' => 10,
                'x-on:input' => <<<'JS'
                    const digits = ($el.value ?? '').replace(/\D/g, '').slice(0, 8);
                    let out = '';

                    if (digits.length <= 2) {
                        out = digits;
                    } else if (digits.length <= 4) {
                        out = digits.slice(0, 2) + '-' + digits.slice(2);
                    } else {
                        out = digits.slice(0, 2) + '-' + digits.slice(2, 4) + '-' + digits.slice(4);
                    }

                    $el.value = out;
                JS,
            ], merge: true)
            ->formatStateUsing(function ($state) {
                if (! filled($state)) {
                    return null;
                }

                try {
                    return Carbon::parse((string) $state)->format('d-m-Y');
                } catch (\Throwable) {
                    return (string) $state;
                }
            })
            ->dehydrateStateUsing(function ($state) {
                $state = is_string($state) ? trim($state) : $state;

                if (! filled($state)) {
                    return null;
                }

                try {
                    $dt = Carbon::createFromFormat('d-m-Y', (string) $state);

                    if ($dt->format('d-m-Y') !== $state) {
                        return $state;
                    }

                    return $dt->format('Y-m-d');
                } catch (\Throwable) {
                    return $state;
                }
            })
            ->rule(function (): \Closure {
                return function (string $attribute, mixed $value, \Closure $fail): void {
                    if (! filled($value)) {
                        return;
                    }

                    $value = trim((string) $value);

                    try {
                        $dt = Carbon::createFromFormat('d-m-Y', $value);

                        if ($dt->format('d-m-Y') !== $value) {
                            $fail('صيغة التاريخ يجب أن تكون dd-mm-yyyy مثل 31-12-2026.');
                        }
                    } catch (\Throwable) {
                        $fail('صيغة التاريخ يجب أن تكون dd-mm-yyyy مثل 31-12-2026.');
                    }
                };
            })
            ->live(onBlur: true);
    }


    // =========================
    // Form
    // =========================

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([


                // 2) ملخص سريع (مفيد أثناء الإدخال)
                Section::make('ملخص سريع')
                    ->visible(fn () => filled($this->currentRecordId))
                    ->schema([
                        Grid::make(12)->schema([
                            Placeholder::make('summary_operations')
                                ->label('عدد العمليات')
                                ->content(function (Get $get): string {
                                    $operations = $get('operations') ?? [];
                                    if (! is_array($operations)) {
                                        return '0';
                                    }

                                    return (string) count(array_filter(
                                        $operations,
                                        fn ($operation) => is_array($operation) && ! blank($operation['operation_type'] ?? null)

                                    ));
                                })
                                ->columnSpan(['default' => 6, 'md' => 2]),

                            Placeholder::make('summary_signals')
                                ->label('الإشارات')
                                ->content(function (Get $get): string {
                                    $signals = $get('signals') ?? [];

                                    if (! is_array($signals)) {
                                        return '0';
                                    }

                                    return (string) count(array_filter(
                                        $signals,
                                        fn ($signal) => is_array($signal) && ! blank($signal['signal_type'] ?? null)
                                    ));
                                })
                                ->columnSpan(['default' => 6, 'md' => 2]),

                            Placeholder::make('summary_files')
                                ->label('الملحقات')
                                ->content(fn () => $this->currentRecordId
                                    ? (string) PropertyCardFile::where('property_card_id', $this->currentRecordId)->count()
                                    : '0'
                                )
                                ->columnSpan(['default' => 6, 'md' => 2]),

                            Placeholder::make('summary_installments')
                                ->label('الدفعات')
                                ->content(function (Get $get): string {
                                    $installments = $get('installments') ?? [];

                                    if (! is_array($installments)) {
                                        return '0';
                                    }

                                    return (string) count(array_filter(
                                        $installments,
                                        fn ($installment) => is_array($installment)
                                            && (! blank($installment['payment_date'] ?? null) || (float) ($installment['amount'] ?? 0) > 0)
                                    ));
                                })
                               ->columnSpan(['default' => 6, 'md' => 2]),

                            Placeholder::make('summary_balance')
                                ->label('ملخص الرصيد')
                                ->content(function (Get $get): string {
                                    $balance = (float) ($get('final_balance') ?? 0);

                                    return '$ ' . number_format($balance, 2, '.', ',');
                                })
                                ->columnSpan(['default' => 12, 'md' => 4]),

                            Placeholder::make('summary_created_by')
                                ->label('أُدخلت بواسطة')
                                ->content(fn (Get $get): string => (string) ($get('created_by_name') ?: '-'))
                                ->columnSpan(['default' => 6, 'md' => 3]),

                            Placeholder::make('summary_updated_by')
                                ->label('آخر تعديل بواسطة')
                                ->content(fn (Get $get): string => (string) ($get('updated_by_name') ?: '-'))
                                ->columnSpan(['default' => 6, 'md' => 3]),

                            Placeholder::make('summary_created_at')
                                ->label('تاريخ الإدخال')
                                ->content(fn (Get $get): string => (string) ($get('created_at_label') ?: '-'))
                                ->columnSpan(['default' => 6, 'md' => 3]),

                            Placeholder::make('summary_updated_at')
                                ->label('تاريخ آخر تعديل')
                                ->content(fn (Get $get): string => (string) ($get('updated_at_label') ?: '-'))
                                ->columnSpan(['default' => 6, 'md' => 3]),

                        ]),
                    ]),

                // 3) البيانات الأساسية (Grid 12 منطقي)
                Section::make('البيانات الأساسية')
                    ->schema([
                        Grid::make(12)->schema([
                            Hidden::make('card_status')
                                ->default('active')
                                ->dehydrated(true),

                            TextInput::make('card_governorate')
                                ->label('المحافظة')
                                ->prefixIcon('heroicon-o-map')
                                ->maxLength(100)
                                ->required()
                                ->live(onBlur: true)
                                ->placeholder('مثال: حلب')
                                ->columnSpan(['default' => 12, 'md' => 4]),

                            TextInput::make('card_region_name')
                                ->label('المنطقة العقارية')
                                ->prefixIcon('heroicon-o-map-pin')
                                ->maxLength(255)
                                ->required()
                                ->live(onBlur: true)
                                ->placeholder('مثال: الحمدانية')
                                ->columnSpan(['default' => 12, 'md' => 4]),


                            TextInput::make('card_record_number')
                                ->label('المحضر')
                                ->prefixIcon('heroicon-o-key')
                                ->maxLength(50)
                                ->required()
                                ->placeholder('مثال: 2024/105')
                                ->columnSpan(['default' => 12, 'md' => 4]),

                            TextInput::make('card_subdivision')
                                ->label('المقسم')
                                ->prefixIcon('heroicon-o-squares-2x2')
                                ->maxLength(100)
                                ->nullable()
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                ->placeholder('مثال: المقسم 22')
                                ->columnSpan(['default' => 12, 'md' => 6]),
                            TextInput::make('card_google_maps_url')
                                ->label('رابط موقع العقار')
                            ->prefixIcon('heroicon-o-globe-alt')
                                ->url()
                                ->maxLength(2048)
                                ->nullable()
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                ->helperText('ألصق رابط الموقع من Google Maps.')
                                ->placeholder('https://maps.google.com/?q=...')
                                ->columnSpan(['default' => 12, 'md' => 6]),

                            Textarea::make('card_property_details')
                                ->label('بيانات تفصيلية')
                                ->rows(3)
                                ->nullable()
                                ->live(onBlur: true)
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                                ->columnSpan(12)
                                ->placeholder('اختياري'),

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
                                ->columnSpan(['default' => 12, 'md' => 6]),
                            TextInput::make('total_property_value_usd')
                                ->label('قيمة العقار الكلية بالدولار الأمريكي')
                                ->numeric()
                                ->minValue(0)
                                ->live(onBlur: true)
                                ->suffix('$')
                                ->columnSpan(['default' => 12, 'md' => 6]),
                        ]),
                    ]),

                // 5) الملاك
                Section::make('الملاك')
                    ->description('إدخال سريع ومريح: اسم المالك + معيار التملك + طريقة الشراء، مع حقول تظهر حسب الاختيار.')
                    ->hidden()
                    ->collapsible()
                    ->schema([
                        $this->ownershipsRepeater(),
                    ]),

                Section::make('عمليات العقار')
                    ->collapsible()
                    ->schema([
                        Grid::make(12)
                            ->schema([
                                TextInput::make('operations_total_shares')
                                    ->label('مجموع الأسهم للعمليات')
                                    ->numeric()
                                    ->minValue(0)
                                    ->dehydrated(true)
                                    ->live(onBlur: true)
                                    ->suffix('سهم')
                                    ->columnSpan(['default' => 12, 'md' => 4]),
                                TextInput::make('abdulqader_sankari_total_shares')
                                    ->label('الحصة الكلية للدكتور عبد القادر السنكري')
                                    ->numeric()
                                    ->minValue(0)
                                    ->dehydrated(true)
                                    ->live(onBlur: true)
                                    ->suffix('سهم')
                                    ->extraAttributes([
                                        'class' => 'bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-200 dark:border-indigo-400/40 rounded-lg px-3 py-2',
                                    ])
                                    ->columnSpan(['default' => 12, 'md' => 4]),
                                TextInput::make('riyad_asali_total_shares')
                                    ->label('الحصة الكاملة لرياض عسلي')
                                    ->numeric()
                                    ->minValue(0)
                                    ->dehydrated(true)
                                    ->live(onBlur: true)
                                    ->suffix('سهم')
                                    ->extraAttributes([
                                        'class' => 'bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-400/40 rounded-lg px-3 py-2',
                                    ])
                                    ->columnSpan(['default' => 12, 'md' => 4]),
                            ]),
                        $this->operationsRepeater(),
                    ]),

                // 6) الإشارات
                Section::make('الإشارات')
                    ->collapsible()
                    ->schema([
                        $this->signalsRepeater(),
                    ]),

                // 7) ملفات البطاقة
                Section::make('ملحقات البطاقة')
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

                                    $this->dmyDateInput('file_issued_at', 'تاريخ الإصدار')
                                        ->nullable()
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
                            TextInput::make('owned_property_value_usd')
                                ->label('قيمة العقار المملوكة بالدولار')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(9999999999.99)
                                ->live(onBlur: true)
                                ->helperText('تُحتسب تلقائياً وفق المعادلة: قيمة العقار الكلية × (حصة عبد القادر ÷ 2400)، ويمكن تعديلها يدوياً عند الحاجة.')
                                ->columnSpan(['default' => 12, 'md' => 4]),

                            TextInput::make('installments_total_paid')
                                ->label('مجموع الدفعات')
                                ->hint('قراءة فقط')
                                ->disabled()
                                ->dehydrated(false)
                                ->formatStateUsing(fn (Get $get) => (string) collect($get('installments') ?? [])
                                    ->sum(fn ($row) => (float) ($row['amount'] ?? 0)))
                                ->extraAttributes([
                                    'class' => 'bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 rounded-md px-3 py-2',
                                ])
                                ->columnSpan(['default' => 12, 'md' => 4]),

                            TextInput::make('installments_total_remaining')
                                ->label('المتبقي')
                                ->hint('قراءة فقط')
                                ->disabled()
                                ->dehydrated(false)
                                ->formatStateUsing(fn (Get $get) => (string) ((float) ($get('owned_property_value_usd') ?? 0)
                                    - collect($get('installments') ?? [])->sum(fn ($row) => (float) ($row['amount'] ?? 0))))
                                ->extraAttributes([
                                    'class' => 'bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 rounded-md px-3 py-2',
                                ])
                                ->columnSpan(['default' => 12, 'md' => 4]),
                        ]),



                        $this->installmentsRepeater(),
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
                $this->ownerSelectField('owner_id', 'المالك')
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

                $this->dmyDateInput('purchase_date', 'تاريخ الشراء')
                    ->nullable()
                    ->columnSpan(['default' => 6, 'md' => 3]),

                Select::make('purchase_method')
                    ->label('طريقة الشراء')
                    ->prefixIcon('heroicon-o-document-text')
                    ->native(false)
                    ->options([
                        'court_judgment' => 'حكم قضائي',
                        'regular_contract' => 'عقد عادي',
                    ])
                    ->nullable()
                    ->live()
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                    ->columnSpan(['default' => 12, 'md' => 6]),

                $this->dmyDateInput('sale_date', 'تاريخ البيع')
                    ->nullable()
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

                        $this->dmyDateInput('judgment_date', 'تاريخ الحكم')
                            ->required(fn (Get $get) => $get('purchase_method') === 'court_judgment')
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
                        $this->dmyDateInput('regular_contract_date', 'تاريخ العقد')
                            ->required(fn (Get $get) => $get('purchase_method') === 'regular_contract')
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

                        $this->dmyDateInput('commercial_contract_date', 'تاريخ عقد السجل')
                            ->required(fn (Get $get) => $get('purchase_method') === 'commercial_register_contract')
                            ->dehydrateStateUsing(fn ($state, Get $get) => $get('purchase_method') === 'commercial_register_contract' ? (filled($state) ? $state : null) : null)
                            ->columnSpan(['default' => 12, 'md' => 6]),
                    ])
                    ->visible(fn (Get $get) => $get('purchase_method') === 'commercial_register_contract')
                    ->columnSpanFull(),
            ]),
        ]);
}

protected function operationsRepeater(): Repeater
{
    return Repeater::make('operations')
        ->label('عمليات العقار')
        ->default([])
        ->dehydrateStateUsing(fn ($state) => array_values($state ?? []))
        ->addActionLabel('إضافة عملية')
        ->reorderable()
        ->schema([
            Hidden::make('id')->dehydrated(),
            Grid::make(12)->schema([
                Select::make('operation_type')
                    ->label('نوع العملية')
                    ->native(false)
                    ->options([
                        'sale' => 'بيع',
                        'purchase' => 'شراء',
                    ])
                    ->required()
                    ->columnSpan(['default' => 12, 'md' => 4]),

                $this->ownerSelectField('old_owners', 'المالكون السابقون', true)
                    ->columnSpan(['default' => 12, 'md' => 4]),

                $this->ownerSelectField('new_owners', 'المالكون الجدد', true)
                    ->columnSpan(['default' => 12, 'md' => 4]),


                $this->ownerSelectField('team_one_members', 'أعضاء الفريق الأول', true)
                    ->columnSpan(['default' => 12, 'md' => 6]),

                $this->ownerSelectField('team_two_members', 'أعضاء الفريق الثاني', true)
                    ->columnSpan(['default' => 12, 'md' => 6]),

                TextInput::make('transaction_amount')
                    ->label('مقدار التصرّف')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(9999999999.99)
                    ->live(onBlur: true)
                    ->required()
                    ->columnSpan(['default' => 12, 'md' => 4]),

                Select::make('transaction_unit')
                    ->label('وحدة التصرّف')
                    ->native(false)
                    ->live()
                    ->options([
                        'shares' => 'سهم',
                        'square_meter' => 'متر مربع',
                        'percentage' => 'نسبة مئوية',
                    ])
                    ->required()
                    ->columnSpan(['default' => 12, 'md' => 4]),

                Select::make('operation_method')
                    ->label('طريقة العملية')
                    ->native(false)
                    ->options([
                        'court_judgment' => 'حكم محكمة',
                        'regular_contract' => 'عقد عادي',
                        'commercial_register_contract' => 'عقد سجل عقاري',
                    ])
                    ->live()
                    ->required()
                    ->in(['court_judgment', 'regular_contract', 'commercial_register_contract'])
                    ->columnSpan(['default' => 12, 'md' => 4]),

                Grid::make(12)
                    ->schema([
                        TextInput::make('case_number')
                            ->label('رقم الأساس')
                            ->required(fn (Get $get) => $get('operation_method') === 'court_judgment')
                            ->columnSpan(['default' => 12, 'md' => 3]),
                        TextInput::make('decision_number')
                            ->label('رقم القرار')
                            ->required(fn (Get $get) => $get('operation_method') === 'court_judgment')
                            ->columnSpan(['default' => 12, 'md' => 3]),
                        TextInput::make('authority')
                            ->label('الجهة')
                            ->required(fn (Get $get) => $get('operation_method') === 'court_judgment')
                            ->columnSpan(['default' => 12, 'md' => 3]),
                        $this->dmyDateInput('judgment_date', 'تاريخ الحكم')
                            ->required(fn (Get $get) => $get('operation_method') === 'court_judgment')
                            ->columnSpan(['default' => 12, 'md' => 3]),
                        Textarea::make('judgment_notes')
                            ->label('ملاحظات الحكم')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->visible(fn (Get $get) => $get('operation_method') === 'court_judgment')
                    ->columnSpanFull(),

                Grid::make(12)
                    ->schema([
                        TextInput::make('regular_contract_number')
                            ->label('رقم العقد')
                            ->required(fn (Get $get) => $get('operation_method') === 'regular_contract')
                            ->columnSpan(['default' => 12, 'md' => 6]),
                        $this->dmyDateInput('regular_contract_date', 'تاريخ العقد')
                            ->required(fn (Get $get) => $get('operation_method') === 'regular_contract')
                            ->columnSpan(['default' => 12, 'md' => 6]),
                        Textarea::make('contract_notes')
                            ->label('ملاحظات العقد')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->visible(fn (Get $get) => $get('operation_method') === 'regular_contract')
                    ->columnSpanFull(),

                Grid::make(12)
                    ->schema([
                        TextInput::make('commercial_contract_number')
                            ->label('رقم العقد')
                            ->required(fn (Get $get) => $get('operation_method') === 'commercial_register_contract')
                            ->columnSpan(['default' => 12, 'md' => 6]),
                        $this->dmyDateInput('commercial_contract_date', 'تاريخ العقد')
                            ->required(fn (Get $get) => $get('operation_method') === 'commercial_register_contract')
                            ->columnSpan(['default' => 12, 'md' => 6]),
                        Textarea::make('commercial_contract_notes')
                            ->label('ملاحظات العقد')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->visible(fn (Get $get) => $get('operation_method') === 'commercial_register_contract')
                    ->columnSpanFull(),

                Repeater::make('witnesses')
                    ->label('الشهود')
                    ->default([])
                    ->schema([
                        TextInput::make('name')
                            ->label('اسم الشاهد')
                            ->required()
                            ->maxLength(200),
                    ])
                    ->rules([
                        function () {
                            return function (string $attribute, mixed $value, \Closure $fail): void {
                                $items = is_array($value) ? array_values($value) : [];

                                if (count($items) === 0) {
                                    return;
                                }

                                if (count($items) < 2 || count($items) > 4) {
                                    $fail('عدد الشهود يجب أن يكون بين 2 و4 عند إدخال شهود.');
                                }
                            };
                        },
                    ])
                    ->columnSpanFull(),
            ]),
        ]);
}

protected function ownerSelectField(string $name, string $label, bool $multiple = false): Select
{
    $field = Select::make($name)
        ->label($label)
        ->prefixIcon('heroicon-o-user')
        ->native(false)
        ->searchable()
        ->searchPrompt('ابدأ الكتابة ليظهر الاقتراح تلقائياً، ثم اضغط Tab للاختيار السريع')
        ->noSearchResultsMessage('لا توجد نتائج مطابقة، يمكنك إنشاء مالك جديد')
        ->preload()
        ->options(fn () => $this->getAllOwnerOptions())
        ->getSearchResultsUsing(function (string $search): array {
            $search = trim($search);

            if (mb_strlen($search) < 1) {
                return [];
            }

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
                ->afterStateUpdated(function ($state, callable $set, Get $get): void {
                    $owner = $this->findOwnerForAutofill([
                        'owner_type' => $get('owner_type'),
                        'full_name' => $state,
                    ]);

                    if ($owner) {
                        $this->fillOwnerCreateFormFromExistingOwner($owner, $set);
                    }
                })
                ->columnSpanFull(),

            TextInput::make('company_name')
                ->label('اسم الشركة')
                ->prefixIcon('heroicon-o-building-office')
                ->maxLength(200)
                ->visible(fn (Get $get) => $get('owner_type') === 'company')
                ->required(fn (Get $get) => $get('owner_type') === 'company')
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, callable $set, Get $get): void {
                    $owner = $this->findOwnerForAutofill([
                        'owner_type' => $get('owner_type'),
                        'company_name' => $state,
                    ]);

                    if ($owner) {
                        $this->fillOwnerCreateFormFromExistingOwner($owner, $set);
                    }
                })
                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

            TextInput::make('commercial_register_number')
                ->label('رقم السجل التجاري')
                ->prefixIcon('heroicon-o-clipboard-document-list')
                ->maxLength(100)
                ->visible(fn (Get $get) => $get('owner_type') === 'company')
                ->required(fn (Get $get) => $get('owner_type') === 'company')
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, callable $set): void {
                    $owner = $this->findOwnerForAutofill([
                        'commercial_register_number' => $state,
                    ]);

                    if ($owner) {
                        $this->fillOwnerCreateFormFromExistingOwner($owner, $set);
                    }
                })
                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

            $this->dmyDateInput('birth_date', 'تاريخ الميلاد')
                ->visible(fn (Get $get) => $get('owner_type') === 'individual')
                ->nullable(),

            TextInput::make('national_id')
                ->label('الرقم الوطني')
                ->prefixIcon('heroicon-o-finger-print')
                ->visible(fn (Get $get) => $get('owner_type') === 'individual')
                ->required(fn (Get $get) => $get('owner_type') === 'individual')
                ->maxLength(50)
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, callable $set): void {
                    $owner = $this->findOwnerForAutofill([
                        'national_id' => $state,
                    ]);

                    if ($owner) {
                        $this->fillOwnerCreateFormFromExistingOwner($owner, $set);
                    }
                })
                ->unique(Owner::class, 'national_id'),

            TextInput::make('phone')
                ->label('رقم الهاتف')
                ->prefixIcon('heroicon-o-phone')
                ->tel()
                ->maxLength(50)
                ->nullable()
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, callable $set): void {
                    $owner = $this->findOwnerForAutofill([
                        'phone' => $state,
                    ]);

                    if ($owner) {
                        $this->fillOwnerCreateFormFromExistingOwner($owner, $set);
                    }
                })
                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

            TextInput::make('email')
                ->label('البريد الإلكتروني')
                ->prefixIcon('heroicon-o-envelope')
                ->email()
                ->maxLength(150)
                ->nullable()
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, callable $set): void {
                    $owner = $this->findOwnerForAutofill([
                        'email' => $state,
                    ]);

                    if ($owner) {
                        $this->fillOwnerCreateFormFromExistingOwner($owner, $set);
                    }
                })
                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),

            Toggle::make('is_active')
                ->label('فعّال')
                ->default(true)
                ->live(),
        ])
        ->createOptionUsing(fn (array $data): int => Owner::create($data)->id);

    if ($multiple) {
        $field->multiple();
    }

    return $field;
}

private function findOwnerForAutofill(array $lookup): ?Owner
{
    $ownerType = $lookup['owner_type'] ?? null;
    $nationalId = trim((string) ($lookup['national_id'] ?? ''));
    $commercialRegister = trim((string) ($lookup['commercial_register_number'] ?? ''));
    $phone = trim((string) ($lookup['phone'] ?? ''));
    $email = trim((string) ($lookup['email'] ?? ''));
    $fullName = trim((string) ($lookup['full_name'] ?? ''));
    $companyName = trim((string) ($lookup['company_name'] ?? ''));

    if ($nationalId !== '') {
        return Owner::query()->where('national_id', $nationalId)->first();
    }

    if ($commercialRegister !== '') {
        return Owner::query()->where('commercial_register_number', $commercialRegister)->first();
    }

    if ($email !== '') {
        return Owner::query()->where('email', $email)->first();
    }

    if ($phone !== '') {
        return Owner::query()->where('phone', $phone)->first();
    }

    if ($ownerType === 'individual' && $fullName !== '' && mb_strlen($fullName) >= 3) {
        return Owner::query()
            ->where('owner_type', 'individual')
            ->where('full_name', $fullName)
            ->first();
    }

    if ($ownerType === 'company' && $companyName !== '' && mb_strlen($companyName) >= 3) {
        return Owner::query()
            ->where('owner_type', 'company')
            ->where('company_name', $companyName)
            ->first();
    }

    return null;
}

private function fillOwnerCreateFormFromExistingOwner(Owner $owner, callable $set): void
{
    $set('owner_type', $owner->owner_type ?: 'individual');
    $set('full_name', $owner->full_name);
    $set('company_name', $owner->company_name);
    $set('commercial_register_number', $owner->commercial_register_number);
    $set('birth_date', $owner->birth_date ? Carbon::parse($owner->birth_date)->format('Y-m-d') : null);
    $set('national_id', $owner->national_id);
    $set('phone', $owner->phone);
    $set('email', $owner->email);
    $set('is_active', (bool) $owner->is_active);
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

                $this->dmyDateInput('signal_date', 'تاريخ الإشارة')
                    ->required()
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
                        'تأمين' => 'تأمين',
                        'استملاك' => 'استملاك',
                        'أخرى' => 'أخرى',
                    ])
                    ->required()
                    ->columnSpan(['default' => 12, 'md' => 6]),
            ]),

            Section::make('ملاحظات الإشارة')
                ->schema([
                    Textarea::make('signal_notes')
                        ->label('الملاحظات')
                        ->rows(3)
                        ->maxLength(1000)
                        ->nullable()
                        ->live(onBlur: true)
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? trim((string) $state) : null)
                        ->columnSpanFull(),
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



    protected function installmentsRepeater(): Repeater
    {
        // ترتيب الحقول بصرياً: (قيمة + تاريخ) ثم (المتبقي)
        return Repeater::make('installments')
            ->label('الدفعات')
            ->default([])
            ->dehydrateStateUsing(fn ($state) => array_values($state ?? []))
            ->live()
            ->addActionLabel('إضافة دفعة')
            ->reorderable()
            ->itemLabel(fn (array $state) => filled($state['payment_date'] ?? null) ? ('دفعة بتاريخ ' . $this->formatDateForDisplay($state['payment_date'])) : 'دفعة')
            ->schema([
                Hidden::make('id')
                    ->dehydrated(),

                TextInput::make('amount')
                    ->label('قيمة الدفعة')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->live(onBlur: true),

                $this->dmyDateInput('payment_date', 'التاريخ')
                    ->required()
                    ->live(debounce: 300),

                TextInput::make('remaining')
                    ->label('المتبقي')
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(function (Get $get): string {
                        $installments = $get('../../installments') ?? [];
                        if (! is_array($installments)) {
                            return '0';
                        }

                        $currentAmount = (float) ($get('amount') ?? 0);
                        $ownedValue = (float) ($get('../../owned_property_value_usd') ?? 0);
                        $cumulative = 0.0;

                        foreach ($installments as $row) {
                            if (! is_array($row)) {
                                continue;
                            }

                            $amount = (float) ($row['amount'] ?? 0);
                            $cumulative += $amount;

                            if ((float) ($row['amount'] ?? 0) === $currentAmount
                                && ($row['payment_date'] ?? null) === ($get('payment_date') ?? null)) {
                                break;
                            }
                        }

                        return (string) ($ownedValue - $cumulative);
                    })
                    ->helperText('المتبقي = قيمة العقار المملوكة - مجموع الدفعات حتى هذه الدفعة.'),
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
            'owned_property_value_usd' => 0,
            'operations_total_shares' => 0,
            'abdulqader_sankari_total_shares' => null,
            'riyad_asali_total_shares' => null,
            'remaining_balance' => 0,
            'owned_value_manually_overridden' => false,
            'ownerships' => [],
            'signals' => [],
            'operations' => [],
            'installments' => [],
            'files' => [],
            'created_by_name' => null,
            'updated_by_name' => null,
            'created_at_label' => null,
            'updated_at_label' => null,
        ];

        $this->form->fill($this->data);
    }



    // =========================
    // Actions
    // =========================

    public function createAction(): Action
    {
        $action = Action::make('create')
            ->label('جديد')
            ->icon('heroicon-o-plus')
            ->color('success')
            ->action(function () {
                try {
                    $record = $this->persistNewRecordFromForm();

                    if (! $record) {
                        return;
                    }

                    $this->loadRecordIntoForm($record);

                    Notification::make()->title('تمت الإضافة بنجاح')->success()->send();
                } catch (\Throwable $exception) {
                    report($exception);

                    Notification::make()
                        ->title('فشل إنشاء البطاقة')
                        ->body($this->formatCreateCardFailureReason($exception))              
                        ->danger()
                        ->send();
                }

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
            ->modalDescription('يمكن البحث ضمن السجلات النشطة والمحذوفة، وعند العثور على سجل محذوف يمكنك استعادته بعد إدخال كلمة المرور.')
            ->modalSubmitActionLabel('تحميل')
            ->form([
                TextInput::make('card_record_number')
                    ->label('رقم المحضر')
                    ->prefixIcon('heroicon-o-key')
                    ->maxLength(50)
                    ->required(),
                TextInput::make('card_subdivision')
                    ->label('المقسم')
                    ->prefixIcon('heroicon-o-squares-2x2')
                    ->maxLength(100)
            ])
            ->action(function (array $data) {
                $recordNumber = trim((string) ($data['card_record_number'] ?? ''));
                $subdivision = trim((string) ($data['card_subdivision'] ?? ''));

                if ($recordNumber === '' && $subdivision === '') {
                    Notification::make()->title('يرجى إدخال رقم المحضر أو المقسم')->warning()->send();
                    return;
                }

                $recordQuery = PropertyCard::withTrashed()

                    ->orderByDesc('id')
                    ->when($recordNumber !== '', fn ($query) => $query->where('card_record_number', $recordNumber))
                    ->when($subdivision !== '', fn ($query) => $query->where('card_subdivision', $subdivision));

                $record = $recordQuery->first();


                if (! $record) {
                    $this->currentRecordId = null;
                    Notification::make()->title('لا يوجد سجل مطابق للبحث المدخل')->warning()->send();
                    return;

                }

                if ($record->trashed()) {
                    $this->currentRecordId = $record->id;

                    Notification::make()
                        ->title('تم العثور على بطاقة محذوفة')
                        ->body('هذه البطاقة محذوفة منطقياً. استخدم زر "استعادة بطاقة محذوفة" وأدخل كلمة المرور للمتابعة.')
                        ->warning()
                        ->send();

                    return;
                }


                $this->loadRecordIntoForm($record);

                Notification::make()->title('تم تحميل البطاقة')->success()->send();
            });

        return $this->uniformAction($action);
    }
    public function restoreActionForTrashedCard(): Action
    {
        $action = Action::make('restore_trashed_card')
            ->label('استعادة بطاقة محذوفة')
            ->icon('heroicon-o-arrow-path')
            ->color('warning')
            ->disabled(function (): bool {
                if (! $this->currentRecordId) {
                    return true;
                }

                $record = PropertyCard::withTrashed()->find($this->currentRecordId);

                return ! $record || ! $record->trashed();
            })
            ->modalHeading('استعادة بطاقة محذوفة')
            ->modalDescription('أدخل كلمة المرور لاستعادة البطاقة المحذوفة.')
            ->modalSubmitActionLabel('استعادة')
            ->form([
                Hidden::make('record_id')
                    ->default(fn (): ?int => $this->currentRecordId)
                    ->required(),
                TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    ->required(),
            ])
            ->action(function (array $data): void {
                $recordId = (int) ($data['record_id'] ?? $this->currentRecordId);

                $record = PropertyCard::withTrashed()->find($recordId);

                if (! $record || ! $record->trashed()) {
                    Notification::make()
                        ->title('لا يوجد سجل محذوف مطابق للاستعادة')
                        ->warning()
                        ->send();

                    return;
                }

                if (! Hash::check($data['password'] ?? '', auth()->user()?->password ?? '')) {
                    Notification::make()
                        ->title('كلمة المرور غير صحيحة')
                        ->danger()
                        ->send();

                    return;
                }

                $record->restore();
                $this->loadRecordIntoForm($record->refresh());

                Notification::make()
                    ->title('تمت استعادة البطاقة بنجاح')
                    ->success()
                    ->send();
            });

        return $this->uniformAction($action);
    }

        public function duplicateCardAction(): Action
    {
        $action = Action::make('copy_card_modal')
            ->label('نسخ بطاقة')
            ->icon('heroicon-o-document-duplicate')
            ->color('info')
            ->modalHeading('نسخ بطاقة عقار')
            ->modalDescription('أدخل رقم محضر البطاقة الأصلية ورقم المحضر الجديد لإنشاء نسخة والانتقال مباشرةً لتعديلها.')
            ->modalSubmitActionLabel('نسخ وفتح')
            ->modalCancelActionLabel('إلغاء')
            ->modalWidth('lg')
            ->schema([
                TextInput::make('source_card_record_number')
                    ->label('رقم محضر العقار الأصلي')
                    ->prefixIcon('heroicon-o-document-text')
                    ->maxLength(50)
                    ->required(),
                TextInput::make('new_card_record_number')
                    ->label('رقم المحضر الجديد')
                    ->prefixIcon('heroicon-o-key')
                    ->maxLength(50)
                    ->required(),
            ])
            ->action(function (array $data): void {
                $sourceRecordNumber = trim((string) ($data['source_card_record_number'] ?? ''));
                $newRecordNumber = trim((string) ($data['new_card_record_number'] ?? ''));

                if ($sourceRecordNumber === '' || $newRecordNumber === '') {
                    Notification::make()->title('يرجى إدخال رقم المحضر الأصلي والجديد')->warning()->send();
                    return;
                }

                if ($sourceRecordNumber === $newRecordNumber) {
                    Notification::make()->title('رقم المحضر الجديد يجب أن يكون مختلفاً عن الأصلي')->warning()->send();
                    return;
                }

                $sourceRecord = PropertyCard::query()
                    ->where('card_record_number', $sourceRecordNumber)
                    ->first();

                if (! $sourceRecord) {
                    Notification::make()->title('لم يتم العثور على بطاقة بالمحضر الأصلي المدخل')->danger()->send();
                    return;
                }

                $exists = PropertyCard::withTrashed()
                    ->where('card_record_number', $newRecordNumber)
                    ->exists();

                if ($exists) {
                    Notification::make()->title('رقم المحضر الجديد مستخدم مسبقاً')->danger()->send();
                    return;
                }

                $this->loadRecordIntoForm($sourceRecord);
                data_set($this->data, 'card_record_number', $newRecordNumber);
                data_set($this->data, 'files', []);
                $this->currentRecordId = null;
                $this->bindFormToRecord(null);
                $this->form->fill($this->data);

                $record = $this->persistNewRecordFromForm();

                if (! $record) {
                    return;
                }

                $this->loadRecordIntoForm($record->fresh());

                Notification::make()
                    ->title('تم نسخ البطاقة وفتح المحضر الجديد للتعديل')
                    ->success()
                    ->send();
            });

        return $this->uniformAction($action);
    }

    public function toggleCardStatusAction(): Action
    {
        $action = Action::make('toggle_card_status')
            ->label('تفعيل/تجميد')
            ->icon(fn (): string => (($this->data['card_status'] ?? 'active') === 'active')
                ? 'heroicon-o-pause-circle'
                : 'heroicon-o-check-circle')
            ->color(fn (): string => (($this->data['card_status'] ?? 'active') === 'active') ? 'warning' : 'success')
            ->disabled(fn () => blank($this->currentRecordId))
            ->action(function (): void {
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

                $currentStatus = in_array($record->card_status, ['active', 'frozen'], true)
                    ? $record->card_status
                    : 'active';

                $nextStatus = $currentStatus === 'active' ? 'frozen' : 'active';
                $record->update(['card_status' => $nextStatus]);

                $this->data['card_status'] = $nextStatus;

                $this->loadRecordIntoForm($record->refresh());

                Notification::make()
                    ->title($nextStatus === 'active' ? 'تم تفعيل العقار' : 'تم تجميد العقار')
                    ->success()
                    ->send();
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
                            'operations',
                            'signals',
                            'installments',
                            'files',
                            'owned_value_manually_overridden',
                        ]);

                        // ✅ DB transaction (مثل باقي الأقسام)
                        try {
                            DB::transaction(function () use ($record, $attributes, $state) {
                                $record->update($attributes);

                                $this->persistOwnerships($record, $state['ownerships'] ?? []);
                                $this->persistOperations($record, (array) ($state['operations'] ?? []));
                                $this->persistInstallments($record, $state['installments'] ?? []);
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
           ->modalDescription('افتراضيًا سيتم حذف البطاقة حذفًا منطقيًا. يمكنك اختيار الحذف النهائي غير القابل للاسترجاع من الخيارات أدناه.')
            ->modalSubmitActionLabel('تنفيذ الحذف')
            ->form([
                Toggle::make('force_delete')
                    ->label('حذف نهائي (غير قابل للاسترجاع)')
                    ->helperText('عند التفعيل سيتم حذف البطاقة نهائيًا ولن يمكن استرجاعها.')
                    ->default(false),
                TextInput::make('password')
                    ->label('كلمة المرور لتأكيد الحذف النهائي')
                    ->password()
                    ->visible(fn (Get $get): bool => (bool) $get('force_delete'))
                    ->required(fn (Get $get): bool => (bool) $get('force_delete')),
            ])
            ->action(function (array $data): void {

                if (! $this->currentRecordId) {
                    Notification::make()->title('لا يوجد سجل محمّل للحذف')->warning()->send();
                    return;
                }


                $forceDelete = (bool) ($data['force_delete'] ?? false);

                $record = $forceDelete
                    ? PropertyCard::withTrashed()->find($this->currentRecordId)
                    : PropertyCard::find($this->currentRecordId);

                if (! $record) {
                    $this->currentRecordId = null;
                    Notification::make()->title('السجل غير موجود')->danger()->send();
                    return;
                }
                                if ($forceDelete) {
                    $user = auth()->user();
                    $password = (string) ($data['password'] ?? '');

                    if (! $user || ! Hash::check($password, (string) $user->password)) {
                        Notification::make()
                            ->title('فشل التحقق من كلمة المرور')
                            ->body('كلمة المرور غير صحيحة. لا يمكن تنفيذ الحذف النهائي دون التحقق الصحيح.')
                            ->danger()
                            ->send();
                        return;
                    }

                    $record->forceDelete();
                    $this->resetCardForm();

                    Notification::make()
                        ->title('تم الحذف النهائي بنجاح')
                        ->body('تم حذف البطاقة نهائيًا بشكل غير قابل للاسترجاع.')
                        ->success()
                        ->send();

                    return;
                }


                $record->delete();
                $this->resetCardForm();

                Notification::make()->title('تم الحذف بنجاح (حذف منطقي)')->success()->send();            });

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
        'operations',
        'signals',
        'installments',
        'files',
        'owned_value_manually_overridden',
    ]);

    // 7) DB transaction
    try {
        $record = DB::transaction(function () use ($attributes, $state) {
            $record = PropertyCard::create($attributes);

            $this->persistOwnerships($record, $state['ownerships'] ?? []);
            $this->persistOperations($record, (array) ($state['operations'] ?? []));
            $this->persistInstallments($record, $state['installments'] ?? []);
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
            $payload = $payload['data'];
        }

        if (blank($payload['card_status'] ?? null)) {
            $payload['card_status'] = 'active';

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


    $record->load('creator', 'updater', 'ownerships.owner', 'operations.oldOwners', 'operations.newOwners', 'operations.witnesses', 'signals.owners', 'installments');

    $payload = $record->attributesToArray();
    $payload['created_by_name'] = $record->creator?->name ?? '-';
    $payload['updated_by_name'] = $record->updater?->name ?? '-';
    $payload['created_at_label'] = $this->formatDateTimeForDisplay($record->created_at);
    $payload['updated_at_label'] = $this->formatDateTimeForDisplay($record->updated_at);

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
   $payload['operations'] = $record->operations
        ->mapWithKeys(function (PropertyOperation $operation): array {
            $row = Arr::except($operation->toArray(), ['old_owners', 'new_owners', 'witnesses', 'created_at', 'updated_at']);
            $row['id'] = $operation->getKey();
            $row['old_owners'] = $operation->oldOwners->pluck('id')->map(fn ($id) => (int) $id)->values()->all();
            $row['new_owners'] = $operation->newOwners->pluck('id')->map(fn ($id) => (int) $id)->values()->all();

            if ($operation->operation_method === 'regular_contract') {
                $row['regular_contract_number'] = $operation->contract_number;
                $row['regular_contract_date'] = $operation->contract_date;
            }

            if ($operation->operation_method === 'commercial_register_contract') {
                $row['commercial_contract_number'] = $operation->contract_number;
                $row['commercial_contract_date'] = $operation->contract_date;
                $row['commercial_contract_notes'] = $operation->contract_notes;
            }

            $row['witnesses'] = $operation->witnesses
                ->mapWithKeys(fn ($witness): array => [Str::uuid()->toString() => ['name' => $witness->witness_name]])
                ->all();

            return [Str::uuid()->toString() => $row];
        })
        ->all();



    // =========================
    // installments (UUID keyed + keep id)
    // =========================
    $payload['installments'] = $record->installments
        ->mapWithKeys(function ($p) {
            $row = Arr::except($p->toArray(), ['created_at', 'updated_at', 'deleted_at']);
            $row['id'] = $p->getKey();
            return [Str::uuid()->toString() => $row];
        })
        ->all();


    $ownedPropertyValueUsd = (float) ($record->owned_property_value_usd ?? 0);
    $totalPaid = (float) $record->installments->sum(fn ($installment) => (float) ($installment->amount ?? 0));
    $payload['remaining_balance'] = $ownedPropertyValueUsd - $totalPaid;
    // للإبقاء على التوافق مع أي استخدامات قديمة لـ final_balance.
    $payload['final_balance'] = $payload['remaining_balance'];
    $payload['owned_value_manually_overridden'] = false;


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

    $this->data = $payload;
    $this->recalculateOperationsTotalShares();
    $payload['operations_total_shares'] = data_get($this->data, 'operations_total_shares', 0);

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
       $record->loadMissing('ownerships', 'operations.oldOwners', 'operations.newOwners', 'operations.witnesses', 'installments', 'signals.owners');
        $currentAttributes = Arr::only($record->getAttributes(), array_keys($attributes));

        if ($this->normalizeForComparison($attributes) !== $this->normalizeForComparison($currentAttributes)) {
            return true;
        }

        if ($this->normalizeOwnershipsForComparison($state['ownerships'] ?? [])
            !== $this->normalizeOwnershipsForComparison($record->ownerships->toArray())) {
            return true;
        }

        if ($this->normalizeInstallmentsForComparison($state['installments'] ?? [])
            !== $this->normalizeInstallmentsForComparison($record->installments->toArray())) {
            return true;
        }

        if ($this->normalizeOperationsForComparison($state['operations'] ?? [])
            !== $this->normalizeOperationsForComparison($record->operations->toArray())) {
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

    protected function normalizeInstallmentsForComparison(mixed $rows): array
    {
        $rows = $this->decodeJsonToArray($rows);

        if (! is_array($rows)) {
            return [];
        }

        $rows = array_is_list($rows) ? $rows : array_values($rows);

        $normalized = collect($rows)
            ->filter(fn ($row) => is_array($row))
            ->map(fn (array $row) => $this->normalizeForComparison(Arr::only($row, [
                'amount',
                'payment_date',
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
                    'signal_notes' => $row['signal_notes'] ?? null,
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
  protected function normalizeOperationsForComparison(mixed $rows): array
    {
        $rows = $this->decodeJsonToArray($rows);

        if (! is_array($rows)) {
            return [];
        }

        $rows = array_is_list($rows) ? $rows : array_values($rows);

        return collect($rows)
            ->filter(fn ($row) => is_array($row))
            ->map(function (array $row): array {
                $oldOwners = $row['old_owners'] ?? [];
                $newOwners = $row['new_owners'] ?? [];
                $witnesses = $row['witnesses'] ?? [];

                if (isset($row['old_owners']) && is_array($row['old_owners']) && ! array_is_list($row['old_owners'])) {
                    $oldOwners = array_values($row['old_owners']);
                }

                if (isset($row['new_owners']) && is_array($row['new_owners']) && ! array_is_list($row['new_owners'])) {
                    $newOwners = array_values($row['new_owners']);
                }

                if (isset($row['witnesses']) && is_array($row['witnesses']) && ! array_is_list($row['witnesses'])) {
                    $witnesses = array_values($row['witnesses']);
                }

                $method = (string) ($row['operation_method'] ?? '');

                $normalized = [
                    'operation_type' => $row['operation_type'] ?? null,
                    'transaction_amount' => $row['transaction_amount'] ?? null,
                    'transaction_unit' => $row['transaction_unit'] ?? null,
                    'operation_method' => $row['operation_method'] ?? null,
                    'case_number' => $method === 'court_judgment' ? ($row['case_number'] ?? null) : null,
                    'decision_number' => $method === 'court_judgment' ? ($row['decision_number'] ?? null) : null,
                    'authority' => $method === 'court_judgment' ? ($row['authority'] ?? null) : null,
                    'judgment_date' => $method === 'court_judgment' ? ($row['judgment_date'] ?? null) : null,
                    'judgment_notes' => $method === 'court_judgment' ? ($row['judgment_notes'] ?? null) : null,
                    'contract_number' => in_array($method, ['regular_contract', 'commercial_register_contract'], true)
                        ? ($row['contract_number']
                            ?? $row['regular_contract_number']
                            ?? $row['commercial_contract_number']
                            ?? null)
                        : null,
                    'contract_date' => in_array($method, ['regular_contract', 'commercial_register_contract'], true)
                        ? ($row['contract_date']
                            ?? $row['regular_contract_date']
                            ?? $row['commercial_contract_date']
                            ?? null)

                        : null,
                    'contract_notes' => in_array($method, ['regular_contract', 'commercial_register_contract'], true)
                        ? ($row['contract_notes'] ?? $row['commercial_contract_notes'] ?? null)
                        : null,
                    'old_owners' => collect($oldOwners)
                        ->map(function ($item): int {
                            if (is_array($item)) {
                                return (int) ($item['id'] ?? $item['owner_id'] ?? 0);
                            }

                            return (int) $item;
                        })
                        ->filter()
                        ->unique()
                        ->sort()
                        ->values()
                        ->all(),
                    'new_owners' => collect($newOwners)
                        ->map(function ($item): int {
                            if (is_array($item)) {
                                return (int) ($item['id'] ?? $item['owner_id'] ?? 0);
                            }

                            return (int) $item;
                        })
                        ->filter()
                        ->unique()
                        ->sort()
                        ->values()
                        ->all(),
                    'witnesses' => collect($witnesses)
                        ->map(function ($item): ?string {
                            if (is_array($item)) {
                                $name = $item['name'] ?? $item['witness_name'] ?? null;
                            } else {
                                $name = $item;
                            }

                            return is_string($name) ? trim($name) : null;
                        })
                        ->filter()
                        ->unique()
                        ->sort()
                        ->values()
                        ->all(),
                ];

                return $this->normalizeForComparison($normalized);
            })
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
    
    protected function formatCreateCardFailureReason(\Throwable $exception): string
    {
        if ($exception instanceof ValidationException) {
            return "تعذر إنشاء البطاقة بسبب أخطاء في الحقول:\n" . $this->formatValidationErrors($exception);
        }

        if ($exception instanceof QueryException) {
            return "تعذر إنشاء البطاقة بسبب خطأ في قاعدة البيانات:\n" . $this->formatQueryExceptionMessage($exception);
        }

        $message = trim($exception->getMessage());

        if ($message === '') {
            return 'تعذر إنشاء البطاقة بسبب خطأ غير معروف. يرجى المحاولة مرة أخرى أو التواصل مع الدعم التقني.';
        }

        return "تعذر إنشاء البطاقة بسبب: {$message}";
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
protected function persistInstallments(PropertyCard $record, mixed $rows): void
{
    $rows = $this->decodeJsonToArray($rows);

    if (! is_array($rows)) {
        $rows = [];
    }

    $rows = array_is_list($rows) ? $rows : array_values($rows);
    $totalPaid = 0.0;
    $ownedValue = (float) ($record->owned_property_value_usd ?? 0);

    $allowed = [
        'amount',
        'payment_date',
        'remaining_after_payment',
    ];

    $incomingIds = collect($rows)
        ->pluck('id')
        ->filter()
        ->map(fn ($id) => (int) $id)
        ->unique()
        ->values()
        ->all();

    $record->installments()
        ->when(count($incomingIds) > 0, fn ($q) => $q->whereNotIn('id', $incomingIds))
        ->when(count($incomingIds) === 0, fn ($q) => $q)
        ->delete();

    foreach ($rows as $row) {
        if (! is_array($row)) continue;

        $id = isset($row['id']) ? (int) $row['id'] : null;

        $data = Arr::only($row, $allowed);
        $data = $this->nullifyEmptyStrings($data);

        if (! filled($data['payment_date'] ?? null)) continue;
        if (! isset($data['amount'])) continue;

        $totalPaid += (float) ($data['amount'] ?? 0);
        $data['remaining_after_payment'] = $ownedValue - $totalPaid;

        if ($id) {
            $existing = $record->installments()->whereKey($id)->first();
            if ($existing) {
                $existing->update($data);
                continue;
            }
        }

        $record->installments()->create($data);
    }
    $remainingBalance = $ownedValue - $totalPaid;

    $record->update([
        // إعادة تعريف final_balance ليعبّر عن المتبقي.
        'final_balance' => $remainingBalance,
    ]);

}
protected function persistOperations(PropertyCard $record, array $rows): void
{
    $rows = $this->decodeJsonToArray($rows);

    if (! is_array($rows)) {
        $rows = [];
    }

    $rows = array_is_list($rows) ? $rows : array_values($rows);

    $allowed = [
        'operation_type',
        'transaction_amount',
        'transaction_unit',
        'operation_method',
        'case_number',
        'decision_number',
        'authority',
        'judgment_date',
        'judgment_notes',
        'contract_notes',
        'contract_number',
        'contract_date',
        'regular_contract_number',
        'regular_contract_date',
        'commercial_contract_number',
        'commercial_contract_date',
        'commercial_contract_notes',
        'old_owners',
        'new_owners',
        'witnesses',
    ];

    $incomingIds = collect($rows)
        ->pluck('id')
        ->filter()
        ->map(fn ($id) => (int) $id)
        ->unique()
        ->values()
        ->all();

    $record->operations()
        ->when(count($incomingIds) > 0, fn ($q) => $q->whereNotIn('id', $incomingIds))
        ->when(count($incomingIds) === 0, fn ($q) => $q)
        ->delete();

    foreach ($rows as $row) {
        if (! is_array($row)) {
            continue;
        }

        $id = isset($row['id']) ? (int) $row['id'] : null;

        $data = Arr::only($row, $allowed);
        $data = $this->nullifyEmptyStrings($data);

        $method = (string) ($data['operation_method'] ?? '');

        if (! in_array($method, ['court_judgment', 'regular_contract', 'commercial_register_contract'], true)) {
            continue;
        }


        if ($method === 'regular_contract') {
            $data['contract_number'] = $data['regular_contract_number'] ?? $data['contract_number'] ?? null;
            $data['contract_date'] = $data['regular_contract_date'] ?? $data['contract_date'] ?? null;
            $data['contract_notes'] = $data['contract_notes'] ?? null;
            $data['case_number'] = null;
            $data['decision_number'] = null;
            $data['authority'] = null;
            $data['judgment_date'] = null;
            $data['judgment_notes'] = null;
        }

        if ($method === 'commercial_register_contract') {
            $data['contract_number'] = $data['commercial_contract_number'] ?? $data['contract_number'] ?? null;
            $data['contract_date'] = $data['commercial_contract_date'] ?? $data['contract_date'] ?? null;
            $data['contract_notes'] = $data['commercial_contract_notes'] ?? $data['contract_notes'] ?? null;
            $data['case_number'] = null;
            $data['decision_number'] = null;
            $data['authority'] = null;
            $data['judgment_date'] = null;
            $data['judgment_notes'] = null;
        }

        if ($method === 'court_judgment') {
            $data['contract_number'] = null;
            $data['contract_date'] = null;
            $data['contract_notes'] = null;
        }

        $oldOwners = collect($data['old_owners'] ?? [])
            ->map(function ($ownerId): int {
                if (is_array($ownerId)) {
                    return (int) ($ownerId['id'] ?? $ownerId['owner_id'] ?? 0);
                }

                return (int) $ownerId;
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
        $newOwners = collect($data['new_owners'] ?? [])
            ->map(function ($ownerId): int {
                if (is_array($ownerId)) {
                    return (int) ($ownerId['id'] ?? $ownerId['owner_id'] ?? 0);
                }

                return (int) $ownerId;
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
        $witnesses = collect($data['witnesses'] ?? [])
            ->map(function ($witness): ?string {
                if (is_array($witness)) {
                    $witness = $witness['name'] ?? null;
                }

                return is_string($witness) ? trim($witness) : null;
            })
            ->filter()
            ->values()
            ->all();

        unset(
            $data['regular_contract_number'],
            $data['regular_contract_date'],
            $data['commercial_contract_number'],
            $data['commercial_contract_date'],
            $data['commercial_contract_notes'],
            $data['old_owners'],
            $data['new_owners'],
            $data['witnesses']
        );

        $data['transaction_unit'] = $this->normalizeTransactionUnit($data['transaction_unit'] ?? null);

        if (! filled($data['operation_type'] ?? null) || ! filled($data['operation_method'] ?? null) || ! filled($data['transaction_amount'] ?? null) || ! filled($data['transaction_unit'] ?? null)) {
            continue;
        }

        $operation = null;

        if ($id) {
            $operation = $record->operations()->whereKey($id)->first();
            if ($operation) {
                $operation->update($data);
            }
        }

        if (! $operation) {
            $operation = $record->operations()->create($data);
        }

        $operation->oldOwners()->sync($oldOwners);
        $operation->newOwners()->sync($newOwners);
        $operation->syncWitnesses($witnesses);
    }
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
        'signal_notes',
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
