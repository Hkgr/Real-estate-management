<?php

namespace App\Filament\Resources\Owners;

use App\Filament\Resources\Owners\Pages;
use App\Filament\Resources\Owners\Schemas\OwnerForm;
use App\Filament\Resources\Owners\Tables\OwnersTable;
use App\Models\Owner;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OwnerResource extends Resource
{
    protected static ?string $model = Owner::class;

    // ✅ فقط عنصر واحد بالنافبار
    protected static ?string $navigationLabel = 'إدارة المالكين';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user';
    protected static ?int $navigationSort = 10;

    protected static ?string $modelLabel = 'مالك';
    protected static ?string $pluralModelLabel = 'المالكون';

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function form(Schema $schema): Schema
    {
        return OwnerForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return OwnersTable::configure($table);
    }

    // ✅ صفحة عرض طبيعية (بدون Blade)
    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('بيانات المالك')
                ->columns(['default' => 1, 'md' => 3])
                ->schema([
                    TextEntry::make('full_name')->label('الاسم الرباعي'),
                    TextEntry::make('birth_date')->label('تاريخ الميلاد')->date(),
                    TextEntry::make('national_id')->label('الرقم الوطني'),
                    TextEntry::make('phone')->label('الهاتف')->placeholder('—'),
                    TextEntry::make('email')->label('البريد')->placeholder('—'),
                ])
                ->columnSpanFull(),

            Section::make('العنوان والملاحظات')
                ->columns(['default' => 1, 'md' => 2])
                ->schema([
                    TextEntry::make('address')->label('العنوان')->placeholder('—')->columnSpanFull(),
                    TextEntry::make('notes')->label('ملاحظات')->placeholder('—')->columnSpanFull(),
                    TextEntry::make('is_active')->label('الحالة')
                        ->formatStateUsing(fn ($state) => $state ? 'فعّال' : 'غير فعّال'),
                ])
                ->columnSpanFull(),
                
            Section::make('العقارات')
                ->columns(['default' => 1, 'md' => 2])
                ->schema([
                    TextEntry::make('properties.property_number')
                        ->label('العقارات المملوكة')
                        ->listWithLineBreaks()
                        ->placeholder('—'),
                ])
                ->columnSpanFull(),

        ]);
    }

    // لدعم Restore/ForceDelete مع SoftDeletes
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOwners::route('/'),
            'create' => Pages\CreateOwner::route('/create'),
            'edit' => Pages\EditOwner::route('/{record}/edit'),
            'view' => Pages\ViewOwner::route('/{record}/view'),
        ];
    }
}
