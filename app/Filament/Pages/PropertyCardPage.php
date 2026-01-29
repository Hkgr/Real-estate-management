<?php

namespace App\Filament\Pages;

use App\Models\PropertyCard;
use BackedEnum;
use UnitEnum;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

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
                                ->lazy() // البحث عند الخروج من الحقل
                                ->afterStateUpdated(fn () => $this->tryAutoSearch())
                                ->placeholder('مثال: 12A'),

                            TextInput::make('card_property_number')
                                ->label('رقم العقار')
                                ->maxLength(50)
                                ->required()
                                ->lazy() // البحث عند الخروج من الحقل
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

                            TextInput::make('card_previous_owner')
                                ->label('المالك السابق')
                                ->nullable()
                                ->placeholder('اختياري'),

                            Select::make('card_status')
                                ->label('حالة العقار')
                                ->native(false)
                                ->options([
                                    'active' => 'فاعل',
                                    'frozen' => 'مجمد',
                                ])
                                ->required(),

                            DatePicker::make('card_purchase_date')
                                ->label('تاريخ الشراء')
                                ->nullable(),
                        ]),
                    ]),

                Section::make('المساحات والملكية')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('card_total_area')
                                ->label('مساحة العقار الكلية')
                                ->numeric()
                                ->minValue(0)
                                ->suffix('م²')
                                ->required()
                                ->placeholder('مثال: 400'),

                            TextInput::make('card_owned_area')
                                ->label('المساحة المملوكة')
                                ->numeric()
                                ->minValue(0)
                                ->suffix('م²')
                                ->required()
                                ->placeholder('مثال: 200'),
                        ]),

                        Grid::make(2)->schema([
                            Select::make('card_ownership_metric')
                                ->label('مقياس الملكية')
                                ->native(false)
                                ->options([
                                    'percentage' => 'النسبة المئوية (%)',
                                    'shares'     => 'عدد الأسهم',
                                    'meters'     => 'عدد الأمتار (م²)',
                                ])
                                ->live()
                                ->required()
                                ->placeholder('اختر مقياس الملكية'),

                            TextInput::make('card_ownership_value')
                                ->label('قيمة الملكية')
                                ->numeric()
                                ->minValue(0)
                                ->suffix(fn (callable $get) => match ($get('card_ownership_metric')) {
                                    'shares' => 'سهم',
                                    'meters' => 'م²',
                                    default  => '%',
                                })
                                ->helperText(fn (callable $get) => match ($get('card_ownership_metric')) {
                                    'percentage' => 'يجب أن تكون بين 0 و 100',
                                    'shares'     => 'رقم صحيح (مثال: 120)',
                                    'meters'     => 'قيمة بالمتر المربع (مثال: 125.5)',
                                    default      => 'اختر المقياس أولاً',
                                })
                                // ✅ FIX: rules() + array rules (بدون integer|min:0 كسلسلة واحدة)
                                ->rules(fn (callable $get) => match ($get('card_ownership_metric')) {
                                    'percentage' => ['numeric', 'between:0,100'],
                                    'shares'     => ['integer', 'min:0'],
                                    'meters'     => ['numeric', 'min:0'],
                                    default      => ['numeric', 'min:0'],
                                })
                                ->required()
                                ->placeholder(fn (callable $get) => match ($get('card_ownership_metric')) {
                                    'shares' => 'مثال: 120',
                                    'meters' => 'مثال: 150',
                                    default  => 'مثال: 50',
                                }),
                        ]),
                    ]),

                Section::make('الموقع')
                    ->schema([
                        Textarea::make('card_location')
                            ->label('موقع العقار (عنوان/وصف)')
                            ->rows(3)
                            ->required()
                            ->placeholder('مثال: حلب - الحمدانية - شارع ...'),

                        Grid::make(2)->schema([
                            TextInput::make('card_latitude')
                                ->label('Latitude')
                                ->numeric()
                                ->nullable(),

                            TextInput::make('card_longitude')
                                ->label('Longitude')
                                ->numeric()
                                ->nullable(),
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
            // ✅ FIX: لا تستخدم Tailwind داخل PHP (لن يُولد CSS)
            ->extraAttributes([
                'style' => 'min-width: 112px; white-space: nowrap;',
            ]);
    }

    protected function resetCardForm(): void
    {
        $this->currentRecordId = null;

        $this->form->fill([
            'card_status' => 'active',
            'card_ownership_metric' => 'percentage',
            'card_ownership_value' => null,
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
        $this->form->fill($record->attributesToArray());

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
                $payload = $this->form->getState();

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
                } catch (QueryException) {
                    Notification::make()->title('فشل الحفظ (تحقق من القيود/القيم)')->danger()->send();
                    return;
                }

                $this->currentRecordId = $record->id;
                $this->form->fill($record->attributesToArray());

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

                $query = PropertyCard::query()
                    ->where('card_property_number', $num);

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
                $this->form->fill($record->attributesToArray());

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

                $payload = $this->form->getState();

                $record = PropertyCard::find($this->currentRecordId);
                if (! $record) {
                    $this->currentRecordId = null;
                    Notification::make()->title('السجل لم يعد موجودًا')->danger()->send();
                    return;
                }

                try {
                    $record->update($payload);
                } catch (QueryException) {
                    Notification::make()->title('فشل التعديل (قد يكون مفتاح مكرر)')->danger()->send();
                    return;
                }

                $this->form->fill($record->fresh()->attributesToArray());
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
}
