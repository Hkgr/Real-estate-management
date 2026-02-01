<?php

namespace App\Filament\Pages;

use App\Models\Signal;
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

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

use Illuminate\Database\QueryException;

class SignalCardPage extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static ?string $title = 'بطاقة الإشارة';
    protected static ?string $navigationLabel = 'بطاقة الإشارة (جديدة)';
    protected static UnitEnum|string|null $navigationGroup = 'الإشارات';
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-bell-alert';
    protected static ?string $slug = 'signal-card';

    public function getView(): string
    {
        return 'filament.pages.signal-card-page';
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
                Section::make('المفتاح (رقم الإشارة + السنة)')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('signal_id')
                                ->label('رقم الإشارة')
                                ->maxLength(50)
                                ->required()
                                ->lazy()
                                ->afterStateUpdated(fn () => $this->tryAutoSearch())
                                ->placeholder('مثال: 125'),

                            TextInput::make('signal_year')
                                ->label('السنة')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue((int) date('Y') + 1)
                                ->required()
                                ->lazy()
                                ->afterStateUpdated(fn () => $this->tryAutoSearch())
                                ->placeholder('مثال: 2024')
                                ->helperText('أدخل سنة الإشارة لتسهيل البحث التلقائي.'),
                        ]),
                    ])
                    ->description('عند إدخال الرقم والسنة سيتم تحميل بيانات الإشارة إن وُجدت.'),

                Section::make('بيانات الإشارة')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('type')
                                ->label('نوع الإشارة')
                                ->native(false)
                                ->searchable()
                                ->options([
                                    'حجز' => 'حجز',
                                    'دعوة' => 'دعوة',
                                    'استيفاء رسوم' => 'استيفاء رسوم',
                                    'إنذار' => 'إنذار',
                                    'استملاك' => 'استملاك',
                                ])
                                ->required()
                                ->placeholder('اختر نوع الإشارة'),
                        ]),
                    ]),

                Section::make('أطراف الإشارة')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('signal_owner')
                                ->label('المالك')
                                ->maxLength(150)
                                ->nullable()
                                ->placeholder('اسم المالك إن وُجد'),

                            TextInput::make('signal_source')
                                ->label('الجهة/المصدر')
                                ->maxLength(150)
                                ->nullable()
                                ->placeholder('مثال: جهة إصدار الإشارة'),

                            TextInput::make('signal_victim')
                                ->label('المتضرّر')
                                ->maxLength(150)
                                ->nullable()
                                ->placeholder('اسم المتضرّر إن وُجد'),
                        ]),
                    ]),
            ])
            ->statePath('data')
            ->model(Signal::class);
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

        $this->form->fill([
            'type' => 'حجز',
        ]);
    }

    public function tryAutoSearch(): void
    {
        $signalId = $this->data['signal_id'] ?? null;
        $signalYear = $this->data['signal_year'] ?? null;

        if (! filled($signalId) || ! filled($signalYear)) {
            return;
        }

        $record = Signal::query()
            ->where('signal_id', $signalId)
            ->where('signal_year', $signalYear)
            ->first();

        if (! $record) {
            $this->currentRecordId = null;
            Notification::make()->title('لا يوجد سجل مطابق لهذا المفتاح')->warning()->send();
            return;
        }

        $this->currentRecordId = $record->id;
        $this->form->fill($record->attributesToArray());

        Notification::make()->title('تم تحميل بطاقة الإشارة تلقائياً')->success()->send();
    }

    public function createAction(): Action
    {
        $action = Action::make('create')
            ->label('إضافة')
            ->icon('heroicon-o-plus')
            ->action(function () {
                $payload = $this->form->getState();

                $exists = Signal::query()
                    ->where('signal_id', $payload['signal_id'])
                    ->where('signal_year', $payload['signal_year'])
                    ->exists();

                if ($exists) {
                    Notification::make()->title('هذه الإشارة موجودة مسبقًا بنفس المفتاح')->danger()->send();
                    return;
                }

                try {
                    $record = Signal::create($payload);
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
            ->modalHeading('بحث عن بطاقة إشارة')
            ->modalSubmitActionLabel('تحميل')
            ->form([
                TextInput::make('signal_id')
                    ->label('رقم الإشارة')
                    ->maxLength(50)
                    ->required(),

                TextInput::make('signal_year')
                    ->label('السنة')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue((int) date('Y') + 1)
                    ->required(),
            ])
            ->action(function (array $data) {
                $signalId = $data['signal_id'] ?? null;
                $signalYear = $data['signal_year'] ?? null;

                $record = Signal::query()
                    ->where('signal_id', $signalId)
                    ->where('signal_year', $signalYear)
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

                $record = Signal::find($this->currentRecordId);
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

                $record = Signal::find($this->currentRecordId);
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
