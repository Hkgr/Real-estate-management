<?php

namespace App\Exports;

use App\Models\PropertyCard;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PropertyCardsExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping
{
    /**
     * @param  array<int>  $selectedIds
     */
    public function __construct(
        protected ?Builder $query = null,
        protected array $selectedIds = [],
    ) {}

    public function query(): Builder
    {
        if ($this->query instanceof Builder) {
            return (clone $this->query)->select($this->exportColumns());
        }

        return PropertyCard::query()
            ->select($this->exportColumns())
            ->when($this->selectedIds !== [], fn (Builder $query) => $query->whereIn('id', $this->selectedIds));
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return [
            'ID',
            'رقم المحضر',
            'المحافظة',
            'المنطقة العقارية',
            'المقسم',
            'رقم العقار',
            'المساحة الكلية',
            'القيمة المملوكة (USD)',
            'القيمة الكلية (USD)',
            'الرصيد النهائي',
            'تاريخ الإضافة',
            'تاريخ آخر تعديل',
        ];
    }

    /**
     * @return array<int, mixed>
     */
    public function map($propertyCard): array
    {
        return [
            $propertyCard->id,
            $propertyCard->card_record_number,
            $propertyCard->card_governorate,
            $propertyCard->card_region_name,
            $propertyCard->card_subdivision,
            $propertyCard->card_property_number,
            $propertyCard->card_total_area,
            $propertyCard->owned_property_value_usd,
            $propertyCard->total_property_value_usd,
            $propertyCard->final_balance,
            $propertyCard->created_at?->format('Y-m-d H:i:s'),
            $propertyCard->updated_at?->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @return array<int, string>
     */
    protected function exportColumns(): array
    {
        return [
            'id',
            'card_record_number',
            'card_governorate',
            'card_region_name',
            'card_subdivision',
            'card_property_number',
            'card_total_area',
            'owned_property_value_usd',
            'total_property_value_usd',
            'final_balance',
            'created_at',
            'updated_at',
        ];
    }
}
