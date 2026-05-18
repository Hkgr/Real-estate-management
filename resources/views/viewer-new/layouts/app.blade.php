<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title', 'viewer-new')</title>
    @vite(['resources/css/viewer-new/app.css', 'resources/js/viewer-new/app.js'])
</head>
<body class="viewer-new" dir="rtl">
    <div class="viewer-new__shell" data-sidebar-state="expanded">
        @include('viewer-new.partials.sidebar', ['active' => trim($__env->yieldContent('active')) ?: 'hub'])

        <div class="viewer-new__content-wrap">
            @include('viewer-new.partials.topbar', [
                'title' => trim($__env->yieldContent('topbar_title')) ?: trim($__env->yieldContent('page_title')),
                'backUrl' => trim($__env->yieldContent('back_url')) ?: route('viewer-new.hub'),
                'backLabel' => trim($__env->yieldContent('back_label')) ?: 'العودة إلى البوابة',
                'version' => trim($__env->yieldContent('topbar_version')) ?: 'v0.2.1',
            ])

            <main class="viewer-new__main">
                @yield('content')
            </main>
        </div>

        @include('viewer-new.partials.quick-settings')
    </div>
</body>
</html>
