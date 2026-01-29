<?php

namespace App\Filament\Resources\ReservationNotices\Pages;

use App\Filament\Resources\ReservationNotices\ReservationNoticeResource;
use App\Models\ReservationNotice;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\EditRecord;

class EditReservationNotice extends EditRecord
{
    protected static string $resource = ReservationNoticeResource::class;

    public function getTitle(): string
    {
        return 'تعديل إشارة الحجز';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('switchNotice')
                ->label('بحث عن إشارة أخرى')
                ->icon('heroicon-o-magnifying-glass')
                ->color('gray')
                ->modalHeading('بحث فوري عن إشارة حجز')
                ->modalDescription('اكتب رقم الإشارة وسيظهر اقتراح فوري. اختيار إشارة أخرى سينقلك لتعديلها (قد تفقد تعديلات غير محفوظة).')
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
                        // هذا السطر هو اللي يمنع خطأ: "failed to validate selected options"
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

            ViewAction::make()->label('عرض'),
            DeleteAction::make()->label('حذف'),
        ];
    }
}
