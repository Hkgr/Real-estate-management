<?php

namespace Tests\Feature;

use App\Models\PropertyCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyCardPersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_property_card_persists_and_retrieves_data(): void
    {
        $payload = [
            'card_governorate' => 'دمشق',
            'card_region_name' => 'برزة',
            'card_subdivision' => 'المقسم 12',
            'card_record_number' => 'محضر-100',
            'card_total_area' => 120.50,
            'card_status' => 'active',
            'card_investment_type' => 'سكني',
            'card_purchase_method' => 'regular_contract',
            'card_google_maps_url' => 'https://maps.google.com/?q=Damascus',
            'card_property_details' => 'تفاصيل تجريبية للعقار.',
        ];

        $card = PropertyCard::create($payload);

        $this->assertDatabaseHas('property_cards', [
            'id' => $card->id,
            'card_governorate' => 'دمشق',
            'card_region_name' => 'برزة',
            'card_subdivision' => 'المقسم 12',
            'card_record_number' => 'محضر-100',
            'card_status' => 'active',
            'card_investment_type' => 'سكني',
            'card_purchase_method' => 'regular_contract',
            'card_google_maps_url' => 'https://maps.google.com/?q=Damascus',
            'card_property_details' => 'تفاصيل تجريبية للعقار.',
        ]);

        $card->refresh();

        $this->assertSame('دمشق', $card->card_governorate);
        $this->assertSame('برزة', $card->card_region_name);
        $this->assertSame('المقسم 12', $card->card_subdivision);
        $this->assertSame('محضر-100', $card->card_record_number);
        $this->assertSame('active', $card->card_status);
        $this->assertSame('سكني', $card->card_investment_type);
        $this->assertSame('regular_contract', $card->card_purchase_method);
        $this->assertSame('https://maps.google.com/?q=Damascus', $card->card_google_maps_url);
        $this->assertSame('تفاصيل تجريبية للعقار.', $card->card_property_details);

        $card->update([
            'card_region_name' => 'المزة',
            'card_total_area' => 140.75,
            'card_status' => 'frozen',
        ]);

        $this->assertDatabaseHas('property_cards', [
            'id' => $card->id,
            'card_region_name' => 'المزة',
            'card_status' => 'frozen',
        ]);
    }
}
