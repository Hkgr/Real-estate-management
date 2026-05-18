@include('viewer-new.partials.navigation-data')

<aside class="vn-sidebar" id="vnSidebar">
    <div class="vn-sidebar__logo">
        <span class="vn-sidebar__badge">REAL ESTATE</span>
        <h2>محفظة العقارات</h2>
        <p>بوابة العرض الجديدة</p>
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
                    >
                        <span class="vn-nav-link__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" focusable="false">
                                <path d="{{ $item['icon_svg'] }}"></path>
                            </svg>
                        </span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        @endforeach
    </nav>

    <button class="vn-sidebar__toggle" type="button" data-toggle-sidebar>طي القائمة</button>
</aside>
