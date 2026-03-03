<?php

namespace App\Http\Controllers;

use App\Models\PropertyCardFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PropertyCardFileDownloadController extends Controller
{
    public function download(Request $request, PropertyCardFile $propertyCardFile): StreamedResponse
    {
        $disk = $propertyCardFile->storage_disk;
        $path = $propertyCardFile->storage_path;
        $diskRoot = filled($disk) ? config("filesystems.disks.{$disk}.root") : null;
        $fileExists = filled($disk) && filled($path)
            ? Storage::disk($disk)->exists($path)
            : false;

        if (! $fileExists) {
            Log::warning('Property card file read failed.', [
                'property_card_file_id' => $propertyCardFile->id,
                'disk' => $disk,
                'path' => $path,
                'disk_root' => $diskRoot,
                'download_mode' => $request->boolean('preview') ? 'preview' : 'download',
            ]);

            abort(404);
        }

        $fileName = $this->resolveDownloadFileName($propertyCardFile);

        if ($request->boolean('preview')) {
            return Storage::disk($disk)->response($path, $fileName, [
                'Content-Disposition' => sprintf('inline; filename="%s"', addslashes($fileName)),
            ]);
        }

        return Storage::disk($disk)->download($path, $fileName);
    }
   protected function resolveDownloadFileName(PropertyCardFile $propertyCardFile): string
    {
        $path = (string) $propertyCardFile->storage_path;
        $storedBaseName = pathinfo($path, PATHINFO_BASENAME);
        $storedExtension = (string) pathinfo($path, PATHINFO_EXTENSION);

        $fileName = trim((string) ($propertyCardFile->file_name ?: ''));
        if ($fileName === '') {
            return $storedBaseName;
        }

        if ($storedExtension === '' || Str::contains(pathinfo($fileName, PATHINFO_BASENAME), '.')) {
            return $fileName;
        }

        return "{$fileName}.{$storedExtension}";
    }

}
