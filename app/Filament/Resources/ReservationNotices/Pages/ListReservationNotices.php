<?php

namespace App\Filament\Resources\ReservationNotices\Pages;

use App\Filament\Resources\ReservationNotices\ReservationNoticeResource;
use App\Models\ReservationNotice;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;

class ListReservationNotices extends ListRecords
{
    protected static string $resource = ReservationNoticeResource::class;

    public function getTitle(): string
    {
        return 'إشارات الحجز';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('إضافة إشارة حجز')
                ->icon('heroicon-o-plus'),

            Action::make('searchAndEdit')
                ->label('بحث وتعديل')
                ->icon('heroicon-o-magnifying-glass')
                ->color('gray')
                ->modalHeading('بحث فوري عن إشارة حجز')
                ->modalSubmitActionLabel('فتح التعديل')
                ->modalCancelActionLabel('إلغاء')
                ->form([
                    Select::make('notice_id')
                        ->label('رقم الإشارة')
                        ->placeholder('اكتب رقم الإشارة...')
                        ->native(false)
                        ->searchable()
                        ->required()
                        ->loadingMessage('جاري البحث...')
                        ->noSearchResultsMessage('لا توجد نتائج.')
                        ->getSearchResultsUsing(function (string $search): array {
                            return ReservationNotice::query()
                                ->where('notice_number', 'like', "%{$search}%") // غيّر اسم الحقل إذا لزم
                                ->orderBy('notice_number')
                                ->limit(10)
                                ->get()
                                ->mapWithKeys(fn (ReservationNotice $n) => [
                                    $n->getKey() => "إشارة #{$n->notice_number}",
                                ])
                                ->all();
                        })
                        // مهم جداً لمنع خطأ التحقق (LogicException) الذي ظهر عندك
                        ->getOptionLabelUsing(function ($value): ?string {
                            $n = ReservationNotice::find($value);
                            return $n ? "إشارة #{$n->notice_number}" : null;
                        }),
                ])
                ->action(function (array $data): void {
                    $this->redirect(
                        ReservationNoticeResource::getUrl('edit', ['record' => $data['notice_id']])
                    );
                }),
        ];
    }
}
