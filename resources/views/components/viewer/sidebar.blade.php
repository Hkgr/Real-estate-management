@props([
    'active' => null,
    'activeLeaf' => null,
])

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-title-row">
            <div class="logo-title">عقارات</div>
            <button class="sidebar-toggle-top" type="button" aria-label="تصغير الشريط الجانبي" onclick="toggleSidebar()">‹</button>
        </div>
        <div class="logo-sub">نظام إدارة الحصص العقارية</div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-group">
            <a href="/viewer/reports" class="nav-item {{ $active === 'reports' ? 'active' : '' }}"><span class="nav-text">التقارير</span></a>
            <div class="nav-submenu" role="group" aria-label="قوائم التقارير">
                <a href="/viewer/reports/properties" class="nav-subitem {{ $activeLeaf === 'properties' ? 'active' : '' }}">تقرير العقارات</a>
                <a href="/viewer/reports/owners" class="nav-subitem {{ $activeLeaf === 'owners' ? 'active' : '' }}">تقرير المالك</a>
                <a href="/viewer/reports/signals" class="nav-subitem {{ $activeLeaf === 'signals' ? 'active' : '' }}">تقرير الإشارات</a>
                <a href="/viewer/reports/attachments" class="nav-subitem {{ $activeLeaf === 'attachments' ? 'active' : '' }}">تقرير الملحقات</a>
            </div>
        </div>

        <div class="nav-group">
            <a href="/viewer/statistics" class="nav-item {{ $active === 'statistics' ? 'active' : '' }}"><span class="nav-text">الإحصاءات</span></a>
            <div class="nav-submenu" role="group" aria-label="أقسام الإحصاءات">
                <a href="/viewer/statistics/financial" class="nav-subitem {{ $activeLeaf === 'financial' ? 'active' : '' }}">مالية</a>
                <a href="/viewer/statistics/administrative" class="nav-subitem {{ $activeLeaf === 'administrative' ? 'active' : '' }}">إدارية</a>
                <a href="/viewer/statistics/general" class="nav-subitem {{ $activeLeaf === 'general' ? 'active' : '' }}">عامة</a>
                <a href="/viewer/statistics/generator" class="nav-subitem {{ $activeLeaf === 'generator' ? 'active' : '' }}">مولد الاحصاءات</a>
            </div>
        </div>

        <a href="/viewer/tracking" class="nav-item {{ $active === 'tracking' ? 'active' : '' }}"><span class="nav-text">تقرير التتبع</span></a>
        <a href="/viewer/hub" class="nav-item {{ $active === 'hub' ? 'active' : '' }}"><span class="nav-text">المحور الرئيسي</span></a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">م</div>
            <div>
                <div class="user-name">{{ auth()->user()?->name ?? 'مستخدم' }}</div>
                <div class="user-role">عارض</div>
            </div>
        </div>
    </div>
</aside>
