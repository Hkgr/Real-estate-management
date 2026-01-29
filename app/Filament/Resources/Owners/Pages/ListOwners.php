<?php

namespace App\Filament\Resources\Owners\Pages;

use App\Filament\Resources\Owners\OwnerResource;
use App\Models\Owner;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;

class ListOwners extends ListRecords
{
    protected static string $resource = OwnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('إضافة مالك'),

            Action::make('quickEditBySearch')
                ->label('بحث وتعديل سريع')
                ->icon('heroicon-o-magnifying-glass')
                ->color('gray')
                ->modalHeading('بحث فوري عن مالك')
                ->modalSubmitActionLabel('فتح التعديل')
                ->modalCancelActionLabel('إلغاء')
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
                                ->orderBy('full_name')
                                ->limit(10)
                                ->get()
                                ->mapWithKeys(fn (Owner $o) => [
                                    $o->getKey() => "{$o->full_name} — {$o->national_id}",
                                ])
                                ->all();
                        })
                        ->getOptionLabelUsing(function ($value): ?string {
                            $o = Owner::query()->find($value);
                            return $o ? "{$o->full_name} — {$o->national_id}" : null;
                        }),
                ])
                ->action(function (array $data): void {
                    $this->redirect(OwnerResource::getUrl('edit', ['record' => $data['owner_id']]));
                }),
        ];
    }
}
