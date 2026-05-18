<aside class="sidebar" aria-label="التنقل الرئيسي">
    <div class="sidebar-logo">
        <div class="logo-badge">REAL ESTATE</div>
        <div class="logo-title-row">
            <h1 class="logo-title">محفظة العقارات</h1>
            <button type="button" class="sidebar-toggle-top" aria-label="طي الشريط الجانبي">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </button>
        </div>
        <p class="logo-sub">واجهة العرض الجديدة</p>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('viewer-new.index') }}" class="nav-item {{ ($active ?? 'index') === 'index' ? 'active' : '' }}">
            <span class="nav-text">الرئيسية</span>
        </a>
        <a href="{{ route('viewer-new.properties.index') }}" class="nav-item {{ ($active ?? '') === 'properties' ? 'active' : '' }}">
            <span class="nav-text">العقارات</span>
        </a>
        <a href="{{ route('viewer-new.owners.index') }}" class="nav-item {{ ($active ?? '') === 'owners' ? 'active' : '' }}">
            <span class="nav-text">الملاك</span>
        </a>
        <a href="{{ route('viewer-new.signals.index') }}" class="nav-item {{ ($active ?? '') === 'signals' ? 'active' : '' }}">
            <span class="nav-text">الإشارات</span>
        </a>
        <a href="{{ route('viewer-new.reports.index') }}" class="nav-item {{ ($active ?? '') === 'reports' ? 'active' : '' }}">
            <span class="nav-text">التقارير</span>
        </a>
    </nav>
</aside>
