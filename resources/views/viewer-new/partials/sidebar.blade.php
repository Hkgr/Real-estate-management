@php
    $viewerNewNavigation = config('viewer-new-navigation', []);
@endphp

<aside class="vn-sidebar" id="vnSidebar">
    <div class="vn-sidebar__logo">
        <div class="vn-sidebar__brand-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" focusable="false">
                <path d="M12 3l8 7h-2v9h-4v-6H10v6H6v-9H4l8-7z"></path>
            </svg>
        </div>
        <div class="vn-sidebar__brand-content">
            <span class="vn-sidebar__badge">REAL ESTATE</span>
            <h2>عقارات</h2>
            <p>نظام إدارة التخصيص العقارية</p>
        </div>
    </div>

    <nav class="vn-sidebar__nav" aria-label="التنقل الرئيسي">
        @foreach($viewerNewNavigation as $group)
            @php
                $groupIsActive = false;

                foreach (($group['items'] ?? []) as $groupItem) {
                    $matchesActiveSection = ($active ?? '') === ($groupItem['active_key'] ?? '');
                    $matchesExactRoute = request()->routeIs(...($groupItem['route_is'] ?? [$groupItem['route']]));
                    $matchesGroupRoute = !empty($groupItem['route_is_group']) && request()->routeIs(...$groupItem['route_is_group']);

                    if ($matchesActiveSection || $matchesExactRoute || $matchesGroupRoute) {
                        $groupIsActive = true;
                        break;
                    }
                }
            @endphp

            <div class="vn-nav-group {{ $groupIsActive ? 'is-active' : '' }}" data-nav-group="{{ $group['group_label'] }}">
                <p class="vn-nav-group__label">{{ $group['group_label'] }}</p>

                @foreach($group['items'] as $item)
                    @php
                        $isActive = ($active ?? '') === $item['active_key'] || request()->routeIs(...($item['route_is'] ?? [$item['route']]));
                    @endphp
                    <a
                        href="{{ route($item['route']) }}"
                        class="vn-nav-link {{ $isActive ? 'is-active' : '' }}"
                        data-active-key="{{ $item['active_key'] }}"
                        data-icon-key="{{ $item['icon_key'] }}"
                        @if($isActive) aria-current="page" @endif
                    >
                        <span class="vn-nav-link__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" focusable="false">
                                <path d="{{ $item['icon_svg'] }}"></path>
                            </svg>
                        </span>
                        <span class="vn-nav-link__label">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        @endforeach
    </nav>

    <div class="vn-sidebar__user" aria-label="معلومات المستخدم">
        <div class="vn-sidebar__avatar" aria-hidden="true">م</div>
        <div class="vn-sidebar__user-copy">
            <strong>مستخدم</strong>
            <span>مستخدم رئيسي</span>
        </div>
        <button class="vn-sidebar__user-action" type="button" aria-label="إعدادات المستخدم">
            <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true">
                <path d="M19.4 12.9a7.9 7.9 0 000-1.8l2-1.6-2-3.4-2.4 1a7.1 7.1 0 00-1.5-.9L15 3h-6l-.5 3.2a7.1 7.1 0 00-1.5.9l-2.4-1-2 3.4 2 1.6a7.9 7.9 0 000 1.8l-2 1.6 2 3.4 2.4-1c.5.4 1 .7 1.5.9L9 21h6l.5-3.2c.5-.2 1-.5 1.5-.9l2.4 1 2-3.4-2-1.6zM12 15.5a3.5 3.5 0 110-7 3.5 3.5 0 010 7z"></path>
            </svg>
        </button>
    </div>

    <button class="vn-sidebar__toggle" type="button" data-toggle-sidebar>طي القائمة</button>
</aside>
