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
            @php
                $viewerNewTitle = trim($__env->yieldContent('topbar_title')) ?: trim($__env->yieldContent('page_title')) ?: 'البوابة';
                $viewerNewVersion = trim($__env->yieldContent('topbar_version')) ?: 'v0.2.1';
                $viewerNewRouteName = request()->route()?->getName();

                $viewerNewBreadcrumbMap = [
                    'viewer-new.hub' => [
                        ['label' => 'الرئيسية', 'url' => null],
                    ],
                    'viewer-new.reports' => [
                        ['label' => 'الرئيسية', 'url' => route('viewer-new.hub')],
                        ['label' => 'التقارير', 'url' => null],
                    ],
                    'viewer-new.reports.properties' => [
                        ['label' => 'الرئيسية', 'url' => route('viewer-new.hub')],
                        ['label' => 'التقارير', 'url' => route('viewer-new.reports')],
                        ['label' => 'تقرير العقارات', 'url' => null],
                    ],
                    'viewer-new.reports.owners' => [
                        ['label' => 'الرئيسية', 'url' => route('viewer-new.hub')],
                        ['label' => 'التقارير', 'url' => route('viewer-new.reports')],
                        ['label' => 'تقرير المالك', 'url' => null],
                    ],
                    'viewer-new.reports.signals' => [
                        ['label' => 'الرئيسية', 'url' => route('viewer-new.hub')],
                        ['label' => 'التقارير', 'url' => route('viewer-new.reports')],
                        ['label' => 'تقرير الإشارات', 'url' => null],
                    ],
                    'viewer-new.reports.attachments' => [
                        ['label' => 'الرئيسية', 'url' => route('viewer-new.hub')],
                        ['label' => 'التقارير', 'url' => route('viewer-new.reports')],
                        ['label' => 'تقرير الملحقات', 'url' => null],
                    ],
                    'viewer-new.statistics' => [
                        ['label' => 'الرئيسية', 'url' => route('viewer-new.hub')],
                        ['label' => 'الإحصاءات', 'url' => null],
                    ],
                    'viewer-new.statistics.general' => [
                        ['label' => 'الرئيسية', 'url' => route('viewer-new.hub')],
                        ['label' => 'الإحصاءات', 'url' => route('viewer-new.statistics')],
                        ['label' => 'عامة', 'url' => null],
                    ],
                    'viewer-new.statistics.financial' => [
                        ['label' => 'الرئيسية', 'url' => route('viewer-new.hub')],
                        ['label' => 'الإحصاءات', 'url' => route('viewer-new.statistics')],
                        ['label' => 'مالية', 'url' => null],
                    ],
                    'viewer-new.statistics.administrative' => [
                        ['label' => 'الرئيسية', 'url' => route('viewer-new.hub')],
                        ['label' => 'الإحصاءات', 'url' => route('viewer-new.statistics')],
                        ['label' => 'إدارية', 'url' => null],
                    ],
                    'viewer-new.statistics.generator' => [
                        ['label' => 'الرئيسية', 'url' => route('viewer-new.hub')],
                        ['label' => 'الإحصاءات', 'url' => route('viewer-new.statistics')],
                        ['label' => 'سجل الإحصاءات', 'url' => null],
                    ],
                ];

                $sectionBreadcrumbs = trim($__env->yieldContent('breadcrumbs'));
                $viewerNewBreadcrumbs = !empty($breadcrumbs ?? null)
                    ? $breadcrumbs
                    : (!empty($sectionBreadcrumbs)
                        ? json_decode($sectionBreadcrumbs, true)
                        : ($viewerNewBreadcrumbMap[$viewerNewRouteName] ?? [
                            ['label' => 'الرئيسية', 'url' => route('viewer-new.hub')],
                            ['label' => $viewerNewTitle, 'url' => null],
                        ]));
            @endphp

            @include('viewer-new.partials.topbar', [
                'title' => $viewerNewTitle,
                'version' => $viewerNewVersion,
                'breadcrumbs' => $viewerNewBreadcrumbs,
            ])

            <main class="viewer-new__main">
                @yield('content')
            </main>
        </div>

        @include('viewer-new.partials.quick-settings')
    </div>
</body>
</html>
