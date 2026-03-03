<?php

namespace App\Filament\Resources\Owners;

use App\Filament\Concerns\ReadOnlyOnViewerPanel;
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
    use ReadOnlyOnViewerPanel;

    protected static ?string $model = Owner::class;

    // ✅ فقط عنصر واحد بالنافبار
    protected static ?string $navigationLabel = 'إدارة المالكين';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user';
    protected static ?int $navigationSort = 10;

    protected static ?string $modelLabel = 'مالك';
    protected static ?string $pluralModelLabel = 'المالكون';

    protected static ?string $recordTitleAttribute = 'display_name';

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
                    TextEntry::make('display_name')->label('اسم المالك'),
                    TextEntry::make('owner_type')->label('نوع المالك'),
                    TextEntry::make('company_name')->label('اسم الشركة')->placeholder('—'),
                    TextEntry::make('commercial_register_number')->label('رقم السجل التجاري')->placeholder('—'),
                    TextEntry::make('birth_date')->label('تاريخ الميلاد')->date('d/m/Y'),
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
                    TextEntry::make('properties')
                        ->label('العقارات المملوكة (بيانات الملكية)')
                        ->formatStateUsing(function ($state, $record) {
                            return $record->properties->map(function ($property) {
                                $pivot = $property->pivot;
                                $ownershipPercentage = $pivot?->ownership_percentage;
                                $ownershipMetric = $pivot?->ownership_metric;
                                $isCurrent = $pivot?->is_current;
                                $purchaseDate = $pivot?->purchase_date;
                                $saleDate = $pivot?->sale_date;

                                $ownershipPercentageText = $ownershipPercentage !== null
                                    ? number_format((float) $ownershipPercentage, 2) . '%'
                                    : '—';

                                $ownershipMetricText = $ownershipMetric ?: '—';
                                $ownerStatusText = $isCurrent === null ? '—' : ($isCurrent ? 'حالي' : 'سابق');
                                $purchaseDateText = $purchaseDate ? $purchaseDate->format('d/m/Y') : '—';
                                $saleDateText = $saleDate ? $saleDate->format('d/m/Y') : '—';

                                return sprintf(
                                    'عقار %s — نسبة التملك: %s | معيار التملك: %s | حالة المالك: %s | شراء: %s | بيع: %s',
                                    $property->property_number,
                                    $ownershipPercentageText,
                                    $ownershipMetricText,
                                    $ownerStatusText,
                                    $purchaseDateText,
                                    $saleDateText
                                );
                            })->all();
                        })

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
            ->with(['creator', 'updater'])
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
