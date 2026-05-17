<?php
use App\Http\Controllers\PropertyCardFileDownloadController;
use App\Http\Controllers\Viewer\StandaloneViewerHubController;
use Illuminate\Support\Facades\Route;
Route::get('/login', fn () => redirect('/viewer/login'))->name('login');
Route::get('/__probe_cookie', function () {
    return response('ok')->cookie('probe_cookie', '1', 5);
});

Route::get('/__probe_session', function () {
    session(['probe' => 1]); // يلمس الـ session لتجبر Laravel إرسال session cookie
    return response('ok');

    
});
Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/viewer/login');
})->name('logout');
Route::get('/__headers_sent', function () {
    $sent = headers_sent($file, $line);

    return "sent=" . ($sent ? '1' : '0')
        . " file=" . ($file ?? '-')
        . " line=" . ($line ?? '-')
        . PHP_EOL;
});

Route::middleware(['auth', 'viewer.access'])->group(function (): void {
    Route::prefix('viewer-new')->name('viewer-new.')->group(function (): void {
        Route::get('/', StandaloneViewerHubController::class)->name('index');
        Route::get('/properties', fn () => view('viewer-new.properties', ['active' => 'properties']))->name('properties.index');
        Route::get('/owners', fn () => view('viewer-new.owners', ['active' => 'owners']))->name('owners.index');
        Route::get('/signals', fn () => view('viewer-new.signals', ['active' => 'signals']))->name('signals.index');
        Route::get('/reports', fn () => view('viewer-new.reports', ['active' => 'reports']))->name('reports.index');
    });

});
Route::middleware('auth')->group(function (): void {
    Route::get('/property-card-files/{propertyCardFile}/download', [PropertyCardFileDownloadController::class, 'download'])
        ->name('property-card-files.download');
});
