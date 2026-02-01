<?php

namespace App\Filament\Pages;

use App\Models\Owner;
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
use Filament\Forms\Components\DatePicker;

use Illuminate\Database\QueryException;

class OwnerCardPage extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static ?string $title = 'بطاقة المالك';
    protected static ?string $navigationLabel = 'بطاقة المالك (جديدة)';
    protected static UnitEnum|string|null $navigationGroup = 'المالكون';
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-identification';
    protected static ?string $slug = 'owner-card';

    public function getView(): string
    {
        return 'filament.pages.owner-card-page';
    }

    public ?int $currentRecordId = null;

    public array $data = [];

    public function mount(): void
    {
        $this->resetCardForm();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('المفتاح (رقم الهوية)')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('national_id')
                                ->label('الرقم الوطني')
                                ->maxLength(50)
                                ->required()
                                ->lazy()
                                ->afterStateUpdated(fn () => $this->tryAutoSearch())
                                ->placeholder('مثال: 123456789'),
                        ]),
                    ])
                    ->description('عند إدخال الرقم الوطني والخروج من الحقل سيتم تحميل بيانات المالك إن وُجدت.'),

                Section::make('البيانات الشخصية')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('full_name')
                                ->label('الاسم الرباعي')
                                ->maxLength(200)
                                ->required()
                                ->placeholder('مثال: أحمد محمد علي حسن'),

                            DatePicker::make('birth_date')
                                ->label('تاريخ الميلاد')
                                ->nullable(),
                        ]),
                    ]),

                Section::make('بيانات التواصل')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('phone')
                                ->label('رقم الهاتف')
                                ->tel()
                                ->maxLength(50)
                                ->nullable(),

                            TextInput::make('email')
                                ->label('البريد الإلكتروني')
                                ->email()
                                ->maxLength(150)
                                ->nullable(),
                        ]),
                    ]),
            ])
            ->statePath('data')
            ->model(Owner::class);
    }

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
        $this->form->fill([]);
    }

    public function tryAutoSearch(): void
    {
        $nationalId = $this->data['national_id'] ?? null;

        if (! filled($nationalId)) {
            return;
        }

        $record = Owner::query()
            ->where('national_id', $nationalId)
            ->first();

        if (! $record) {
            $this->currentRecordId = null;
            Notification::make()->title('لا يوجد سجل مطابق لهذا الرقم')->warning()->send();
            return;
        }

        $this->currentRecordId = $record->id;
        $this->form->fill($record->attributesToArray());

        Notification::make()->title('تم تحميل بطاقة المالك تلقائياً')->success()->send();
    }

    public function createAction(): Action
    {
        $action = Action::make('create')
            ->label('إضافة')
            ->icon('heroicon-o-plus')
            ->action(function () {
                $payload = $this->form->getState();

                $exists = Owner::query()
                    ->where('national_id', $payload['national_id'])
                    ->exists();

                if ($exists) {
                    Notification::make()->title('هذا المالك موجود مسبقًا بنفس الرقم')->danger()->send();
                    return;
                }

                try {
                    $record = Owner::create($payload);
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
            ->modalHeading('بحث عن بطاقة مالك')
            ->modalSubmitActionLabel('تحميل')
            ->form([
                TextInput::make('national_id')
                    ->label('الرقم الوطني')
                    ->maxLength(50)
                    ->required(),
            ])
            ->action(function (array $data) {
                $nationalId = $data['national_id'] ?? null;

                $record = Owner::query()
                    ->where('national_id', $nationalId)
                    ->first();

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

                $record = Owner::find($this->currentRecordId);
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

                $record = Owner::find($this->currentRecordId);
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
