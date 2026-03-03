<?php

namespace Tests\Feature;

use App\Models\PropertyCard;
use App\Models\PropertyCardFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PropertyCardFileDownloadControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_logs_disk_and_path_when_file_read_fails(): void
    {
        Storage::fake('local');
        Log::spy();

        $propertyCard = PropertyCard::query()->create([
            'card_governorate' => 'دمشق',
            'card_region_name' => 'المزة',
            'card_total_area' => 100,
        ]);

        $file = PropertyCardFile::query()->create([
            'property_card_id' => $propertyCard->id,
            'file_name' => 'contract.pdf',
            'issued_at' => now()->toDateString(),
            'storage_disk' => 'local',
            'storage_path' => 'property-cards/missing-contract.pdf',
            'mime_type' => 'application/pdf',
        ]);

        $response = $this
            ->withoutMiddleware()
            ->get(route('property-card-files.download', $file));

        $response->assertNotFound();

        Log::shouldHaveReceived('warning')
            ->once()
            ->withArgs(function (string $message, array $context) use ($file): bool {
                return $message === 'Property card file read failed.'
                    && $context['property_card_file_id'] === $file->id
                    && $context['disk'] === 'local'
                    && $context['path'] === 'property-cards/missing-contract.pdf'
                    && $context['disk_root'] === storage_path('app/private')
                    && $context['download_mode'] === 'download';
            });
    }
}
