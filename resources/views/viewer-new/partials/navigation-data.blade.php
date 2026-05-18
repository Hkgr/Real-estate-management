@php
    $viewerNewNavigation = [
        [
            'group_label' => 'الرئيسية',
            'items' => [
                [
                    'label' => 'البوابة',
                    'route' => 'viewer-new.hub',
                    'active_key' => 'hub',
                    'icon_key' => 'home',
                    'icon_svg' => 'M12 3l8 7h-2v9h-4v-6H10v6H6v-9H4l8-7z',
                    'route_is' => ['viewer-new.hub'],
                ],
            ],
        ],
        [
            'group_label' => 'التقارير',
            'items' => [
                [
                    'label' => 'التقارير',
                    'route' => 'viewer-new.reports',
                    'active_key' => 'reports',
                    'icon_key' => 'reports',
                    'icon_svg' => 'M5 4h14v2H5V4zm0 5h14v2H5V9zm0 5h9v2H5v-2zm11 0h3v6h-3v-6z',
                    'route_is' => ['viewer-new.reports', 'viewer-new.reports.*'],
                ],
            ],
        ],
        [
            'group_label' => 'الإحصاءات',
            'items' => [
                [
                    'label' => 'الإحصاءات',
                    'route' => 'viewer-new.statistics',
                    'active_key' => 'statistics',
                    'icon_key' => 'statistics',
                    'icon_svg' => 'M5 18h3V9H5v9zm5 0h3V4h-3v14zm5 0h3v-6h-3v6z',
                    'route_is' => ['viewer-new.statistics', 'viewer-new.statistics.*'],
                ],
            ],
        ],
    ];
@endphp
