<?php

namespace App\Filament\Resources\Properties\Pages;

use App\Filament\Resources\Properties\PropertyResource;
use App\Models\Property;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;

class ViewProperty extends ViewRecord
{
    protected static string $resource = PropertyResource::class;

    protected static ?string $title = 'عرض العقار';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('switchProperty')
                ->label('عرض عقار آخر')
                ->icon('heroicon-o-magnifying-glass')
                ->color('gray')
                ->modalHeading('بحث فوري برقم العقار')
                ->modalSubmitActionLabel('عرض')
                ->modalCancelActionLabel('إلغاء')
                // ✅ يملأ الحقل بالقيمة الحالية عند فتح المودال
                ->fillForm(fn (): array => [
                    'property_id' => $this->record?->getKey(),
                ])
                ->form([
                    Select::make('property_id')
                        ->label('رقم العقار')
                        ->placeholder('اكتب رقم العقار...')
                        ->native(false)
                        ->searchable()
                        ->required()
                        ->loadingMessage('جاري البحث...')
                        ->noSearchResultsMessage('لا توجد نتائج.')
                        ->getSearchResultsUsing(function (string $search): array {
                            return Property::query()
                                ->where('property_number', 'like', "%{$search}%")
                                ->orderBy('property_number')
                                ->limit(10)
                                ->get()
                                ->mapWithKeys(fn (Property $p) => [
                                    $p->getKey() => "{$p->property_number} — {$p->region_name}",
                                ])
                                ->all();
                        })
                        // ✅ هذا السطر يحل خطأ التحقق (selected options)
                        ->getOptionLabelUsing(function ($value): ?string {
                            $p = Property::query()->find($value);

                            return $p
                                ? "{$p->property_number} — {$p->region_name}"
                                : null;
                        }),
                ])
                ->action(function (array $data): void {
                    $this->redirect(
                        PropertyResource::getUrl('view', ['record' => $data['property_id']])
                    );
                }),

            EditAction::make()->label('تعديل'),
            DeleteAction::make()->label('حذف'),
        ];
    }
}
