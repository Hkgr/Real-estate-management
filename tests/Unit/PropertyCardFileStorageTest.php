<?php

namespace Tests\Unit;

use App\Models\PropertyCard;
use App\Services\PropertyCardFileStorage;
use PHPUnit\Framework\TestCase;

class PropertyCardFileStorageTest extends TestCase
{
    public function test_build_directory_uses_id_when_available(): void
    {
        $propertyCard = new PropertyCard();
        $propertyCard->id = 101;
        $propertyCard->card_governorate = 'دمشق';
        $propertyCard->card_record_number = 'محضر ١٢';

        $storage = new PropertyCardFileStorage();

        $this->assertSame('property_cards/101', $storage->buildDirectory($propertyCard));
    }

    public function test_build_directory_preserves_arabic_record_number_when_id_missing(): void
    {
        $propertyCard = new PropertyCard();
        $propertyCard->card_record_number = 'محضر ٥٤';

        $storage = new PropertyCardFileStorage();

        $this->assertSame('property_cards/محضر-٥٤', $storage->buildDirectory($propertyCard));
    }

    public function test_build_directory_separates_cards_with_arabic_metadata(): void
    {
        $firstCard = new PropertyCard();
        $firstCard->id = 201;
        $firstCard->card_governorate = 'حلب';
        $firstCard->card_record_number = 'محضر ٧';

        $secondCard = new PropertyCard();
        $secondCard->id = 202;
        $secondCard->card_governorate = 'حلب';
        $secondCard->card_record_number = 'محضر ٧';

        $storage = new PropertyCardFileStorage();

        $this->assertSame('property_cards/201', $storage->buildDirectory($firstCard));
        $this->assertSame('property_cards/202', $storage->buildDirectory($secondCard));
    }
}
