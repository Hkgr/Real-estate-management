<nav class="mobile-nav" aria-label="التنقل للجوال">
    <a href="{{ route('viewer-new.index') }}" class="mobile-nav-btn {{ ($active ?? 'index') === 'index' ? 'active' : '' }}">الرئيسية</a>
    <a href="{{ route('viewer-new.properties.index') }}" class="mobile-nav-btn {{ ($active ?? '') === 'properties' ? 'active' : '' }}">العقارات</a>
    <a href="{{ route('viewer-new.reports.index') }}" class="mobile-nav-btn {{ ($active ?? '') === 'reports' ? 'active' : '' }}">التقارير</a>
</nav>
