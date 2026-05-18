<header class="topbar">
    <div class="topbar-title topbar-title-desktop" id="topbar-title">
        @yield('topbar_title', 'بوابة <span>الإحصاءات</span>')
    </div>

    <nav class="topbar-mobile-nav" aria-label="تنقل رئيسي">
        <a href="{{ route('viewer-new.reports.index') }}" class="topbar-nav-pill {{ ($active ?? '') === 'reports' ? 'active' : '' }}">التقارير</a>
        <a href="{{ route('viewer-new.index') }}" class="topbar-nav-pill {{ ($active ?? 'index') === 'index' ? 'active' : '' }}">الإحصاءات</a>
        <a href="#" class="topbar-nav-pill">تتبع</a>
    </nav>

    <div class="topbar-actions">
        <span class="app-version-badge" aria-label="Application version">v0.2.1</span>

        <div class="topbar-date topbar-datetime" id="topbar-datetime">
            <span id="topbar-time">--:--:--</span>
            <span class="topbar-datetime-sep">•</span>
            <span id="topbar-date">جارٍ التحميل…</span>
        </div>

        <a href="{{ route('viewer-new.reports.index') }}"
           class="topbar-btn topbar-btn-props"
           id="topbar-hub-shortcut"
           title="الانتقال إلى قسم التقارير">
           ⊞ إلى التقارير
        </a>

        <button class="topbar-btn logout" onclick="handleLogout()">⎋ تسجيل الخروج</button>
    </div>
</header>
