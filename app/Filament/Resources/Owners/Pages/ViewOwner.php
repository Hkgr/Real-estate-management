<?php

namespace App\Filament\Resources\Owners\Pages;

use App\Filament\Resources\Owners\OwnerResource;
use App\Models\Owner;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;

class ViewOwner extends ViewRecord
{
    protected static string $resource = OwnerResource::class;

    protected static ?string $title = 'عرض المالك';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('switchOwner')
                ->label('عرض مالك آخر')
                ->icon('heroicon-o-magnifying-glass')
                ->color('gray')
                ->modalHeading('بحث فوري عن مالك')
                ->modalSubmitActionLabel('عرض')
                ->modalCancelActionLabel('إلغاء')
                ->fillForm(fn (): array => [
                    'owner_id' => $this->record?->getKey(),
                ])
                ->form([
                    Select::make('owner_id')
                        ->label('ابحث بالرقم الوطني أو الاسم')
                        ->placeholder('اكتب...')
                        ->native(false)
                        ->searchable()
                        ->required()
                        ->loadingMessage('جاري البحث...')
                        ->noSearchResultsMessage('لا توجد نتائج.')
                        ->getSearchResultsUsing(function (string $search): array {
                            return Owner::query()
                                ->where('national_id', 'like', "%{$search}%")
                                ->orWhere('full_name', 'like', "%{$search}%")
                                ->orWhere('company_name', 'like', "%{$search}%")
                                ->orderByRaw('coalesce(company_name, full_name)')
                                ->limit(10)
                                ->get()
                                ->mapWithKeys(fn (Owner $o) => [
                                    $o->getKey() => "{$o->display_name} — {$o->national_id}",
                                ])
                                ->all();
                        })
                        ->getOptionLabelUsing(function ($value): ?string {
                            $o = Owner::query()->find($value);
                            return $o ? "{$o->display_name} — {$o->national_id}" : null;
                        }),
                ])
                ->action(function (array $data): void {
                    $this->redirect(OwnerResource::getUrl('view', ['record' => $data['owner_id']]));
                }),

            EditAction::make()->label('تعديل'),
            DeleteAction::make()->label('حذف'),
        ];
    }
}
