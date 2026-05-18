<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title', 'Viewer New')</title>

    @vite([
        'resources/css/viewer/app.css',
        'resources/js/viewer/app.js',
        'resources/css/viewer/hub.css',
        'resources/js/viewer/hub.js',
        'resources/css/viewer/reports.css',
        'resources/js/viewer/reports.js',
    ])
</head>
<body class="viewer-shell viewer-reports">
    <div class="app-wrapper">
        @include('viewer-new.partials.sidebar')
        <div class="sidebar-overlay"></div>

        <div class="main-content">
            @include('viewer-new.partials.topbar')
            @include('viewer-new.partials.mobile-nav')
            @yield('content')
        </div>
    </div>

    <button type="button" class="qs-fab" aria-label="الإعدادات السريعة">
        <span>⚙</span>
    </button>
</body>
</html>
