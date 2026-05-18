<?php

namespace App\Http\Controllers\Viewer;

use Illuminate\View\View;

class StandaloneViewerReportsController
{
    public function __invoke(): View
    {
        return view('viewer-new.reports');
    }
}
