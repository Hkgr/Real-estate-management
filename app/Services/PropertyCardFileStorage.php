<?php

namespace App\Services;

use App\Models\PropertyCard;
use App\Models\PropertyCardFile;
use Carbon\CarbonInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class PropertyCardFileStorage
{
    public function store(
        PropertyCard $propertyCard,
        UploadedFile $file,
        ?CarbonInterface $issuedAt = null,
        ?string $diskName = null
    ): PropertyCardFile {
        $diskName = $diskName ?? config('filesystems.default');
        $disk = Storage::disk($diskName);

        $directory = $this->buildDirectory(
            $propertyCard->card_governorate,
            $propertyCard->card_record_number
        );

        $disk->makeDirectory($directory);

        $originalName = $this->normalizeFileName($file->getClientOriginalName());
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

    public function buildDirectory(?string $governorate, ?string $recordNumber): string
    {
        $safeGovernorate = $this->sanitizeSegment($governorate ?: 'unknown');
        $safeRecordNumber = $this->sanitizeSegment($recordNumber ?: 'record');

        return "property-cards/{$safeGovernorate}/{$safeRecordNumber}";
    }

    private function sanitizeSegment(string $value): string
    {
        $value = trim($value);

        $slug = Str::slug($value, '-');

        return $slug !== '' ? $slug : 'unknown';
    }

    private function normalizeFileName(string $originalName): string
    {
        $originalName = trim($originalName);
        $originalName = basename($originalName);

        return str_replace(['\\', '/'], '-', $originalName);
    }
}
