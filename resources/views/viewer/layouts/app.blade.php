<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Viewer New')</title>

    @vite(['resources/css/viewer/app.css', 'resources/js/viewer/app.js'])
    @if (request()->routeIs('viewer-new.hub'))
        @vite(['resources/css/viewer/hub.css', 'resources/js/viewer/hub.js'])
    @endif

    @if (request()->routeIs('viewer-new.reports'))
        @vite(['resources/css/viewer/reports.css', 'resources/js/viewer/reports.js'])
    @endif
    @stack('viewer-vite')
</head>
<body dir="rtl">
    @yield('content')
</body>
</html>
