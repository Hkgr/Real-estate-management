<?php

namespace App\Filament\Resources\ReservationNotices\Pages;

use App\Filament\Resources\ReservationNotices\ReservationNoticeResource;
use App\Models\ReservationNotice;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;

class ViewReservationNotice extends ViewRecord
{
    protected static string $resource = ReservationNoticeResource::class;

    public function getTitle(): string
    {
        return 'عرض إشارة الحجز';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('switchNotice')
                ->label('عرض إشارة أخرى')
                ->icon('heroicon-o-magnifying-glass')
                ->color('gray')
                ->modalHeading('بحث فوري برقم الإشارة')
                ->modalSubmitActionLabel('عرض')
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
                                ->where('notice_number', 'like', "%{$search}%")
                                ->orderBy('notice_number')
                                ->limit(10)
                                ->get()
                                ->mapWithKeys(fn (ReservationNotice $n) => [
                                    $n->id => "{$n->notice_number} — عقار {$n->property_number}",
                                ])
                                ->all();
                        })
                        // مهم جداً لتفادي خطأ: "failed to validate selected options"
                        ->getOptionLabelUsing(fn ($value): ?string => ReservationNotice::find($value)?->display_name),
                ])
                ->action(function (array $data): void {
                    $this->redirect(ReservationNoticeResource::getUrl('view', ['record' => $data['notice_id']]));
                }),

            EditAction::make()->label('تعديل'),
            DeleteAction::make()
                ->label('حذف')
                ->requiresConfirmation()
                ->modalHeading('تأكيد الحذف')
                ->modalDescription('هل أنت متأكد أنك تريد حذف هذه الإشارة؟ يمكن استعادتها لاحقاً من سلة المحذوفات.'),
        ];
    }
}
