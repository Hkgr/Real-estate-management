<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title', 'viewer-new')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Noto+Naskh+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/viewer-new/app.css', 'resources/js/viewer-new/app.js'])
    @yield('extra_styles')
    @stack('styles')
    <style>
        .viewer-new .vn-sidebar{width:230px;background:#18191f;border-left:1px solid rgba(255,255,255,.08);padding:18px;gap:14px}
        .viewer-new .vn-sidebar__logo{padding:6px 4px;border:0;background:transparent;gap:10px}
        .viewer-new .vn-sidebar__brand-icon{width:26px;height:26px;flex:0 0 26px}
        .viewer-new .vn-sidebar__brand-content h2{margin:0;font-size:1rem;line-height:1.25}
        .viewer-new .vn-sidebar__brand-content p{margin:2px 0 0;font-size:.74rem;color:#7f838d}
        .viewer-new .vn-nav-group+.vn-nav-group{padding-top:8px;border-top:1px solid rgba(255,255,255,.06)}
        .viewer-new .vn-nav-link{min-height:40px;padding:9px 11px;border-radius:9px;gap:8px}
        .viewer-new .vn-nav-link.is-active{color:#d4af37;background:rgba(212,175,55,.12);border:1px solid rgba(212,175,55,.45)}
        .viewer-new .vn-nav-link.is-active::before{content:"";position:absolute;right:-1px;top:8px;bottom:8px;width:2px;background:#d4af37;border-radius:2px}
        .viewer-new .vn-sidebar__user{padding:8px 10px;min-height:54px;background:rgba(255,255,255,.04)}


        .viewer-new .vn-breadcrumb{display:flex;align-items:center}
        .viewer-new .vn-breadcrumb__list{display:flex;align-items:center;gap:6px;list-style:none;margin:0;padding:0;flex-wrap:wrap}
        .viewer-new .vn-breadcrumb__item{display:inline-flex;align-items:center;gap:6px;font-size:12px;color:#8f949f}
        .viewer-new .vn-breadcrumb__link{color:#a8adb7;text-decoration:none}
        .viewer-new .vn-breadcrumb__current{color:#d9dde4}

        .viewer-new .vn-nav-link__icon,.viewer-new .vn-nav-link__icon svg{width:18px;height:18px;max-width:18px;max-height:18px}
        .viewer-new .vn-nav-link__icon svg path{fill:currentColor}
        .viewer-new .vn-pagination-wrap svg{width:20px;height:20px;max-width:20px;max-height:20px}

        .viewer-new__shell.is-collapsed .vn-sidebar{width:80px}
        .viewer-new__shell.is-collapsed .vn-sidebar__brand-content,
        .viewer-new__shell.is-collapsed .vn-nav-group__label,
        .viewer-new__shell.is-collapsed .vn-nav-link__label,
        .viewer-new__shell.is-collapsed .vn-sidebar__user-copy,
        .viewer-new__shell.is-collapsed .vn-sidebar__user-action{display:none}
        .viewer-new__shell.is-collapsed .vn-nav-link{justify-content:center}
        .viewer-new__shell.is-collapsed .vn-sidebar__toggle{display:inline-flex}

    </style>
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
