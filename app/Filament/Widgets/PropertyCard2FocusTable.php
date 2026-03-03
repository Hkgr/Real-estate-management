<?php

namespace App\Filament\Widgets;

use App\Models\PropertyCard;
use Filament\Widgets\Widget;

class PropertyCard2FocusTable extends Widget
{
    protected string $view = 'filament.widgets.property-card-two-focus-table';

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $cards = PropertyCard::query()
            ->select([
                'id',
                'card_property_number',
                'card_region_name',
                'operations_total_shares',
                'abdulqader_sankari_total_shares',
                'riyad_asali_total_shares',
                'owned_property_value_usd',
                'final_balance',
            ])
            ->latest('updated_at')
            ->limit(10)
            ->get();

        return [
            'rows' => $cards,
        ];
    }
}
