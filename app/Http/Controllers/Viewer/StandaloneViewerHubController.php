<?php

namespace App\Http\Controllers\Viewer;

use Illuminate\View\View;

class StandaloneViewerHubController
{
    public function __invoke(): View
    {
        return view('viewer.pages.hub');
    }
}
