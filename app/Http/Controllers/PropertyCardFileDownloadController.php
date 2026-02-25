<?php

namespace App\Http\Controllers;

use App\Models\PropertyCardFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PropertyCardFileDownloadController extends Controller
{
    public function download(Request $request, PropertyCardFile $propertyCardFile): StreamedResponse
    {
        $disk = $propertyCardFile->storage_disk;
        $path = $propertyCardFile->storage_path;

        abort_unless(
            filled($disk) && filled($path) && Storage::disk($disk)->exists($path),
            404,
        );

        $fileName = $propertyCardFile->file_name ?: basename($path);

        if ($request->boolean('preview')) {
            return Storage::disk($disk)->response($path, $fileName, [
                'Content-Disposition' => sprintf('inline; filename="%s"', addslashes($fileName)),
            ]);
        }

        return Storage::disk($disk)->download($path, $fileName);
    }
}
