<?php
use App\Http\Controllers\PropertyCardFileDownloadController;
use App\Http\Controllers\Viewer\StandaloneViewerHubController;
use App\Http\Controllers\Viewer\StandaloneViewerReportsController;
use Illuminate\Support\Facades\Route;

Route::get('/__probe_cookie', function () {
    return response('ok')->cookie('probe_cookie', '1', 5);
});

Route::get('/__probe_session', function () {
    session(['probe' => 1]); // يلمس الـ session لتجبر Laravel إرسال session cookie
    return response('ok');

    
});
Route::get('/__headers_sent', function () {
    $sent = headers_sent($file, $line);

    return "sent=" . ($sent ? '1' : '0')
        . " file=" . ($file ?? '-')
        . " line=" . ($line ?? '-')
        . PHP_EOL;
});

Route::get('/viewer-new', StandaloneViewerHubController::class)->name('viewer-new.hub');
Route::get('/viewer-new/reports', StandaloneViewerReportsController::class)->name('viewer-new.reports');
Route::middleware('auth')->group(function (): void {
    Route::get('/property-card-files/{propertyCardFile}/download', [PropertyCardFileDownloadController::class, 'download'])
        ->name('property-card-files.download');
});
