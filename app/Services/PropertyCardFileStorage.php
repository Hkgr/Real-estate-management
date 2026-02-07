<?php

namespace App\Services;

use App\Models\PropertyCard;
use App\Models\PropertyCardFile;
use Carbon\CarbonInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class PropertyCardFileStorage
{
    public function store(
        PropertyCard $propertyCard,
        UploadedFile $file,
        ?CarbonInterface $issuedAt = null,
        ?string $diskName = null,
        ?string $fileName = null
    ): PropertyCardFile {
        $diskName = $diskName ?? config('filesystems.default');
        $disk = Storage::disk($diskName);

        $directory = $this->buildDirectory($propertyCard);

        $disk->makeDirectory($directory);

        $originalName = $this->normalizeFileName($fileName ?: $file->getClientOriginalName());
        $storedPath = $disk->putFileAs($directory, $file, $originalName);

        if ($storedPath === false) {
            throw new RuntimeException('Failed to store property card file.');
        }

        return PropertyCardFile::create([
            'property_card_id' => $propertyCard->id,
            'file_name' => $originalName,
            'issued_at' => $issuedAt?->toDateString() ?? now()->toDateString(),
            'storage_disk' => $diskName,
            'storage_path' => $storedPath,
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ]);
    }

    public function buildDirectory(PropertyCard $propertyCard): string
    {
        $identifier = $propertyCard->getKey();
        if ($identifier) {
            return "property_cards/{$identifier}";
        }

        $recordNumber = $this->sanitizeSegment((string) ($propertyCard->card_record_number ?? ''));
        if ($recordNumber !== 'unknown') {
            return "property_cards/{$recordNumber}";
        }

        $fallbackSource = trim(implode('|', array_filter([
            $propertyCard->card_governorate,
            $propertyCard->card_subdivision,
            $propertyCard->card_region_name,
            $propertyCard->card_property_number,
        ])));

        if ($fallbackSource !== '') {
            $safeFallback = $this->sanitizeSegment($fallbackSource);
            $hash = substr(sha1($fallbackSource), 0, 12);

            return "property_cards/{$safeFallback}-{$hash}";
        }

        return 'property_cards/unknown';
    }

    private function sanitizeSegment(string $value): string
    {
        $value = trim($value);

        $value = preg_replace('/[^\p{L}\p{N}\s\-_]/u', '', $value);
        $value = preg_replace('/[\s\-_]+/u', '-', $value);
        $value = trim($value, '-');

        return $value !== '' ? $value : 'unknown';
    }

    private function normalizeFileName(string $originalName): string
    {
        $originalName = trim($originalName);
        $originalName = str_replace(["\0", "\r", "\n"], '', $originalName);
        $originalName = basename($originalName);
        $originalName = preg_replace('/[\/\\\\]+/u', '-', $originalName);
        $originalName = preg_replace('/[\\x00-\\x1F\\x7F]/u', '', $originalName);

        return $originalName !== '' ? $originalName : 'file';

    }
}
