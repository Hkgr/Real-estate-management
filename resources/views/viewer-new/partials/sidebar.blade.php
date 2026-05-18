<aside class="vn-sidebar" id="vnSidebar">
    <div class="vn-sidebar__logo">
        <span class="vn-sidebar__badge">REAL ESTATE</span>
        <h2>محفظة العقارات</h2>
        <p>بوابة العرض الجديدة</p>
    </div>

    <nav class="vn-sidebar__nav">
        <a href="{{ route('viewer-new.hub') }}" class="vn-nav-link {{ ($active ?? '') === 'hub' ? 'is-active' : '' }}">البوابة</a>
        <a href="{{ route('viewer-new.reports') }}" class="vn-nav-link {{ ($active ?? '') === 'reports' ? 'is-active' : '' }}">التقارير</a>
        <a href="{{ route('viewer-new.statistics') }}" class="vn-nav-link {{ ($active ?? '') === 'statistics' ? 'is-active' : '' }}">الإحصاءات</a>
    </nav>

    <button class="vn-sidebar__toggle" type="button" data-toggle-sidebar>طي القائمة</button>
</aside>
