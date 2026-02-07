<?php

use App\Models\PropertyCardFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/property-card-files/{propertyCardFile}/download', function (PropertyCardFile $propertyCardFile) {
    $disk = $propertyCardFile->storage_disk;
    $path = $propertyCardFile->storage_path;

    if (! Storage::disk($disk)->exists($path)) {
        abort(Response::HTTP_NOT_FOUND);
    }

    $fileName = $propertyCardFile->file_name ?: basename($path);

    if (request()->boolean('preview')) {
        return Storage::disk($disk)->response($path, $fileName, [
            'Content-Type' => $propertyCardFile->mime_type,
        ], 'inline');
    }

    return Storage::disk($disk)->download($path, $fileName);
})->name('property-card-files.download');
