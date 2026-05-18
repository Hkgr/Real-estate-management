<!DOCTYPE html>
<html lang="ar">
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
<body dir="rtl" class="viewer-shell">
    @include('viewer-new.partials.navbar', ['activeNavbarKey' => trim($__env->yieldContent('active_navbar_key')) ?: 'hub'])

    @yield('content')
</body>
</html>
