<?php

namespace App\Filament\Resources\Properties\Pages;

use App\Filament\Resources\Properties\PropertyResource;
use App\Models\Property;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\Action;


class EditPropertyByNumber extends Page implements HasSchemas
{
    
    use InteractsWithSchemas;

    protected static string $resource = PropertyResource::class;

    // ملاحظة: في v5 ليست static
    protected string $view = 'filament.resources.properties.pages.edit-property-by-number';
   public function getTitle(): string
{
    return 'تعديل عقار برقم العقار';
}

public function getHeading(): string
{
    return 'تعديل عقار برقم العقار';
}
protected function getHeaderActions(): array
{
    return [
        Action::make('deleteProperty')
            ->label('حذف العقار')
            ->icon('heroicon-o-trash')
            ->color('danger')
            ->visible(fn (): bool => filled($this->record))
            ->requiresConfirmation()
            ->modalIcon('heroicon-o-exclamation-triangle')
            ->modalHeading('تأكيد حذف العقار')
            ->modalDescription(fn (): string => $this->record
                ? "تحذير: سيتم حذف العقار رقم ({$this->record->property_number}) حذفاً منطقياً (Soft Delete). يمكنك استعادته لاحقاً من صفحة العقارات إذا أضفت خيار الاستعادة، لكنه سيختفي من النتائج الافتراضية."
                : 'اختر عقاراً أولاً.')
            ->modalSubmitActionLabel('نعم، احذف')
            ->modalCancelActionLabel('إلغاء')
            ->action(fn () => $this->deleteRecord()),
    ];
}
public function deleteRecord(): void
{
    if (! $this->record) {
        Notification::make()
            ->danger()
            ->title('لا يوجد عقار محدد')
            ->body('اختر عقاراً من البحث أولاً.')
            ->send();

        return;
    }

    $propertyNumber = $this->record->property_number;

    // Soft delete (لأن جدولك فيه softDeletes)
    $this->record->delete();

    // تفريغ الصفحة
    $this->record = null;

    $this->form->fill([
        'selected_property_id' => null,
        'region_name' => null,
        'cadastral_zone_number' => null,
        'property_number' => null,
        'total_area' => null,
        'owned_area' => null,
        'purchase_date' => null,
        'ownership_percentage' => null,
        'location' => null,
        'latitude' => null,
        'longitude' => null,
    ]);

    Notification::make()
        ->success()
        ->title('تم حذف العقار')
        ->body("تم حذف العقار رقم: {$propertyNumber}")
        ->send();
}

    public ?Property $record = null;

    public ?array $data = [
        'selected_property_id' => null,

        // حقول العقار
        'region_name' => null,
        'cadastral_zone_number' => null,
        'property_number' => null,
        'total_area' => null,
        'owned_area' => null,
        'purchase_date' => null,
        'ownership_percentage' => null,
        'location' => null,
        'latitude' => null,
        'longitude' => null,
    ];

    public function mount(): void
    {
        $this->form->fill($this->data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بحث فوري حسب رقم العقار')
                    ->description('ابدأ بكتابة رقم العقار وستظهر الاقتراحات فوراً. اختر نتيجة ليتم تعبئة الحقول تلقائياً.')
                    ->icon(Heroicon::MagnifyingGlass)
                    ->schema([
                        Select::make('selected_property_id')
                            ->label('رقم العقار')
                            ->placeholder('اكتب رقم العقار...')
                            ->native(false)
                            ->searchable()
                            ->searchPrompt('اكتب رقم العقار للبحث...')
                            ->loadingMessage('جاري البحث...')
                            ->noSearchResultsMessage('لا يوجد عقار مطابق لهذا الرقم.')
                            ->getSearchResultsUsing(function (string $search): array {
                                return Property::query()
                                    ->where('property_number', 'like', "%{$search}%")
                                    ->orderBy('property_number')
                                    ->limit(10)
                                    ->get()
                                    ->mapWithKeys(fn (Property $p) => [
                                        $p->getKey() => "{$p->property_number} — {$p->region_name} (منطقة: {$p->cadastral_zone_number})",
                                    ])
                                    ->all();
                            })
                            ->getOptionLabelUsing(function ($value): ?string {
                                $p = Property::find($value);
                                return $p ? "{$p->property_number} — {$p->region_name}" : null;
                            })
                            ->live()
                            ->afterStateUpdated(function ($state): void {
                                if (blank($state)) {
                                    $this->record = null;

                                    // تفريغ كل الحقول
                                    $this->form->fill([
                                        'selected_property_id' => null,
                                        'region_name' => null,
                                        'cadastral_zone_number' => null,
                                        'property_number' => null,
                                        'total_area' => null,
                                        'owned_area' => null,
                                        'purchase_date' => null,
                                        'ownership_percentage' => null,
                                        'location' => null,
                                        'latitude' => null,
                                        'longitude' => null,
                                    ]);

                                    return;
                                }

                                $property = Property::find($state);

                                if (! $property) {
                                    $this->record = null;

                                    Notification::make()
                                        ->danger()
                                        ->title('لم يتم العثور على العقار')
                                        ->body('قد يكون تم حذف السجل أو تغيّرت بياناته.')
                                        ->send();

                                    $this->form->fill(['selected_property_id' => null]);

                                    return;
                                }

                                $this->record = $property;

                                $payload = [
                                    'selected_property_id' => $property->getKey(),

                                    'region_name' => $property->region_name,
                                    'cadastral_zone_number' => $property->cadastral_zone_number,
                                    'property_number' => $property->property_number,

                                    'total_area' => $property->total_area,
                                    'owned_area' => $property->owned_area,
                                    'purchase_date' => $property->purchase_date,
                                    'ownership_percentage' => $property->ownership_percentage,

                                    'location' => $property->location,
                                    'latitude' => $property->latitude,
                                    'longitude' => $property->longitude,
                                ];

                                $this->form->model($property)->fill($payload);

                                Notification::make()
                                    ->success()
                                    ->title('تم تحميل بيانات العقار')
                                    ->body("تم تحميل العقار رقم: {$property->property_number}")
                                    ->send();
                            })
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),

                Section::make('بيانات العقار')
                    ->description('عدّل الحقول ثم اضغط حفظ التعديلات.')
                    ->icon(Heroicon::Home)
                    ->schema([
                        Section::make('التعريف')
                            ->compact()
                            ->icon(Heroicon::Identification)
                            ->schema([
                                TextInput::make('region_name')
                                    ->label('اسم المنطقة')
                                    ->required()
                                    ->maxLength(150),

                                TextInput::make('cadastral_zone_number')
                                    ->label('رقم المنطقة العقارية')
                                    ->required()
                                    ->maxLength(50),

                                TextInput::make('property_number')
                                    ->label('رقم العقار')
                                    ->required()
                                    ->maxLength(50)
                                    ->unique(ignoreRecord: true),
                            ])
                            ->columns(['default' => 1, 'md' => 3])
                            ->columnSpanFull(),

                        Section::make('المساحات والملكية')
                            ->compact()
                            ->icon(Heroicon::Scale)
                            ->schema([
                                TextInput::make('total_area')
                                    ->label('مساحة العقار الكلية')
                                    ->numeric()
                                    ->suffix('م²')
                                    ->required(),

                                TextInput::make('owned_area')
                                    ->label('المساحة المملوكة')
                                    ->numeric()
                                    ->suffix('م²')
                                    ->required(),

                                TextInput::make('ownership_percentage')
                                    ->label('نسبة الملكية')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->suffix('%')
                                    ->required(),

                                DatePicker::make('purchase_date')
                                    ->label('تاريخ الشراء')
                                    ->required(),
                            ])
                            ->columns(['default' => 1, 'md' => 4])
                            ->columnSpanFull(),

                        Section::make('موقع العقار')
                            ->compact()
                            ->icon(Heroicon::MapPin)
                            ->schema([
                                Textarea::make('location')
                                    ->label('موقع العقار')
                                    ->rows(3)
                                    ->placeholder('رابط خرائط / وصف عنوان / إحداثيات...')
                                    ->columnSpanFull(),

                                TextInput::make('latitude')
                                    ->label('خط العرض (اختياري)')
                                    ->numeric()
                                    ->step(0.0000001)
                                    ->nullable(),

                                TextInput::make('longitude')
                                    ->label('خط الطول (اختياري)')
                                    ->numeric()
                                    ->step(0.0000001)
                                    ->nullable(),
                            ])
                            ->columns(['default' => 1, 'md' => 2])
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
            ])
            ->statePath('data')
            ->columns(1);
    }

    public function save(): void
    {
        if (! $this->record) {
            Notification::make()
                ->danger()
                ->title('لا يوجد عقار محدد')
                ->body('اختر عقاراً من البحث أولاً ثم عدّل البيانات.')
                ->send();

            return;
        }

        $state = $this->form->getState();

        // لا نرسل selected_property_id إلى قاعدة البيانات
        unset($state['selected_property_id']);

        // تحديث السجل
        $this->record->update($state);

        Notification::make()
            ->success()
            ->title('تم حفظ التعديلات')
            ->send();
    }
}
