<?php

namespace Tests\Feature;

use App\Filament\Pages\PropertyCardPage;
use App\Models\Owner;
use App\Models\PropertyCard;
use App\Models\Signal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyCardSignalOwnerSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_change_update_keeps_signal_owners_count_stable(): void
    {
        $card = PropertyCard::create([
            'card_governorate' => 'دمشق',
            'card_region_name' => 'المزة',
            'card_subdivision' => 'المقسم 1',
            'card_record_number' => 'RC-100',
            'card_total_area' => 100,
            'card_status' => 'active',
            'card_purchase_method' => 'regular_contract',
        ]);

        $ownerA = Owner::create([
            'full_name' => 'مالك أول',
            'owner_type' => 'person',
            'national_id' => 'NID-1',
            'is_active' => true,
        ]);

        $ownerB = Owner::create([
            'full_name' => 'مالك ثان',
            'owner_type' => 'person',
            'national_id' => 'NID-2',
            'is_active' => true,
        ]);

        $signal = Signal::create([
            'signal_id' => 'S-1',
            'signal_date' => '2025-01-01',
            'type' => 'حجز',
            'signal_owners' => [
                ['is_owner' => true, 'owner_id' => $ownerA->id, 'name' => $ownerA->display_name],
                ['is_owner' => true, 'owner_id' => $ownerB->id, 'name' => $ownerB->display_name],
            ],
            'property_card_id' => $card->id,
        ]);

        $signal->owners()->sync([$ownerA->id, $ownerB->id]);

        $page = new class extends PropertyCardPage {
            public function hasPendingChangesPublic(PropertyCard $record, array $attributes, array $state): bool
            {
                return $this->hasPendingChanges($record, $attributes, $state);
            }
        };

        $state = [
            'ownerships' => [],
            'payments' => [],
            'signals' => [[
                'id' => $signal->id,
                'signal_id' => 'S-1',
                'signal_date' => '2025-01-01',
                'type' => 'حجز',
                'signal_owners' => [
                    ['owner_from_owner' => true, 'owner_id' => $ownerA->id, 'owner_name' => $ownerA->display_name],
                    ['owner_from_owner' => true, 'owner_id' => $ownerB->id, 'owner_name' => $ownerB->display_name],
                ],
                'signal_victims' => [],
            ]],
        ];

        $attributes = [
            'card_governorate' => 'دمشق',
            'card_region_name' => 'المزة',
            'card_subdivision' => 'المقسم 1',
            'card_record_number' => 'RC-100',
            'card_total_area' => 100,
            'card_status' => 'active',
            'card_purchase_method' => 'regular_contract',
            'card_investment_type' => null,
            'card_google_maps_url' => null,
            'card_property_details' => null,
            'card_sale_date' => null,
        ];

        $this->assertFalse($page->hasPendingChangesPublic($card, $attributes, $state));

        $this->assertDatabaseCount('owner_signal', 2);
        $this->assertDatabaseHas('owner_signal', ['signal_id' => $signal->id, 'owner_id' => $ownerA->id]);
        $this->assertDatabaseHas('owner_signal', ['signal_id' => $signal->id, 'owner_id' => $ownerB->id]);
    }
}
