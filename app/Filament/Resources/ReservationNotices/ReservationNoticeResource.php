<?php

namespace App\Filament\Resources\ReservationNotices;

use App\Filament\Concerns\ReadOnlyOnViewerPanel;
use App\Filament\Resources\ReservationNotices\Pages\CreateReservationNotice;
use App\Filament\Resources\ReservationNotices\Pages\EditReservationNotice;
use App\Filament\Resources\ReservationNotices\Pages\ListReservationNotices;
use App\Filament\Resources\ReservationNotices\Pages\ViewReservationNotice;
use App\Filament\Resources\ReservationNotices\Schemas\ReservationNoticeForm;
use App\Filament\Resources\ReservationNotices\Schemas\ReservationNoticeInfolist;
use App\Filament\Resources\ReservationNotices\Tables\ReservationNoticesTable;
use App\Models\ReservationNotice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReservationNoticeResource extends Resource
{
    use ReadOnlyOnViewerPanel;

    protected static ?string $navigationLabel = 'إدارة إشارات الحجز';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-bookmark-square';
    protected static ?int $navigationSort = 20;
    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $modelLabel = 'إشارة حجز';
    protected static ?string $pluralModelLabel = 'إشارات الحجز';

    protected static ?string $recordTitleAttribute = 'notice_number';


    public static function form(Schema $schema): Schema
    {
    return ReservationNoticeForm::configure($schema);   
     }

    public static function infolist(Schema $schema): Schema
    {
        return ReservationNoticeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReservationNoticesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['creator', 'updater']);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReservationNotices::route('/'),
            'create' => CreateReservationNotice::route('/create'),
            'view' => ViewReservationNotice::route('/{record}'),
            'edit' => EditReservationNotice::route('/{record}/edit'),
        ];
    }
}
