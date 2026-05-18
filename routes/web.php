<?php
use App\Http\Controllers\PropertyCardFileDownloadController;
use App\Http\Controllers\Viewer\StandaloneViewerHubController;
use App\Http\Controllers\Viewer\StandaloneViewerReportsController;
use App\Http\Controllers\ViewerNew\Reports\OwnersReportController;
use App\Http\Controllers\ViewerNew\Reports\PropertiesReportController;
use App\Http\Controllers\ViewerNew\Reports\SignalsReportController;
use App\Http\Controllers\ViewerNew\Reports\AttachmentsReportController;
use App\Http\Controllers\ViewerNew\Statistics\FinancialStatisticsController;
use App\Http\Controllers\ViewerNew\Statistics\GeneralStatisticsController;
use App\Http\Controllers\ViewerNew\Statistics\StatisticsGatewayController;
use App\Http\Controllers\ViewerNew\Statistics\AdministrativeStatisticsController;
use App\Http\Controllers\ViewerNew\Statistics\StatisticsGeneratorController;
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
    Route::get('/viewer-new', StandaloneViewerHubController::class)->name('viewer-new.hub');
    Route::get('/viewer-new/reports', StandaloneViewerReportsController::class)->name('viewer-new.reports');
    Route::get('/viewer-new/statistics', StatisticsGatewayController::class)->name('viewer-new.statistics');
    Route::get('/viewer-new/statistics/general', GeneralStatisticsController::class)->name('viewer-new.statistics.general');
    Route::get('/viewer-new/statistics/financial', FinancialStatisticsController::class)->name('viewer-new.statistics.financial');
    Route::get('/viewer-new/statistics/administrative', AdministrativeStatisticsController::class)->name('viewer-new.statistics.administrative');
    Route::get('/viewer-new/statistics/generator', StatisticsGeneratorController::class)->name('viewer-new.statistics.generator');
    Route::get('/viewer-new/reports/properties', PropertiesReportController::class)->name('viewer-new.reports.properties');
    Route::get('/viewer-new/reports/owners', OwnersReportController::class)->name('viewer-new.reports.owners');
    Route::get('/viewer-new/reports/signals', SignalsReportController::class)->name('viewer-new.reports.signals');
    Route::get('/viewer-new/reports/attachments', AttachmentsReportController::class)->name('viewer-new.reports.attachments');
});
Route::middleware('auth')->group(function (): void {
    Route::get('/property-card-files/{propertyCardFile}/download', [PropertyCardFileDownloadController::class, 'download'])
        ->name('property-card-files.download');
});
