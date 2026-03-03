<?php

namespace Tests\Feature;

use App\Filament\Pages\PropertyCardPage2;
use App\Models\PropertyCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyCardOwnedValueCalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_calculates_owned_value_automatically_and_persists_it(): void
    {
        $page = $this->makePage();
        $page->data = [
            'total_property_value_usd' => 100000,
            'abdulqader_sankari_total_shares' => 1200,
            'owned_property_value_usd' => 0,
            'owned_value_manually_overridden' => false,
        ];

        $page->callUpdated('data.total_property_value_usd');

        $this->assertSame(50000.0, (float) $page->data['owned_property_value_usd']);

        $record = PropertyCard::create([
            'card_governorate' => 'دمشق',
            'card_region_name' => 'المزة',
            'card_subdivision' => 'المقسم 7',
            'card_record_number' => 'AUTO-100',
            'card_total_area' => 100,
            'card_status' => 'active',
            'owned_property_value_usd' => $page->data['owned_property_value_usd'],
            'total_property_value_usd' => $page->data['total_property_value_usd'],
            'abdulqader_sankari_total_shares' => $page->data['abdulqader_sankari_total_shares'],
        ]);

        $this->assertDatabaseHas('property_cards', [
            'id' => $record->id,
            'owned_property_value_usd' => 50000.00,
        ]);
    }

    public function test_manual_override_is_not_lost_when_base_inputs_change(): void
    {
        $page = $this->makePage();
        $page->data = [
            'total_property_value_usd' => 100000,
            'abdulqader_sankari_total_shares' => 1200,
            'owned_property_value_usd' => 11111,
            'owned_value_manually_overridden' => false,
        ];

        $page->callUpdated('data.owned_property_value_usd');
        $this->assertTrue((bool) $page->data['owned_value_manually_overridden']);

        $page->data['total_property_value_usd'] = 200000;
        $page->callUpdated('data.total_property_value_usd');

        $this->assertSame(11111.0, (float) $page->data['owned_property_value_usd']);
        $this->assertTrue((bool) $page->data['owned_value_manually_overridden']);
    }

    public function test_force_recalculation_resyncs_after_manual_override(): void
    {
        $page = $this->makePage();
        $page->data = [
            'total_property_value_usd' => 300000,
            'abdulqader_sankari_total_shares' => 600,
            'owned_property_value_usd' => 12000,
            'owned_value_manually_overridden' => true,
        ];

        $page->forceRecalculateOwnedValue();

        $this->assertSame(75000.0, (float) $page->data['owned_property_value_usd']);
        $this->assertFalse((bool) $page->data['owned_value_manually_overridden']);
    }

    private function makePage(): PropertyCardPage2
    {
        return new class extends PropertyCardPage2 {
            public function __construct()
            {
                $this->form = new class {
                    public function validate(): array
                    {
                        return [];
                    }
                };
            }

            public function callUpdated(string $propertyName): void
            {
                $this->updated($propertyName);
            }

            public function forceRecalculateOwnedValue(): void
            {
                $this->recalculateOwnedPropertyValueFromShares(true);
            }
        };
    }
}
