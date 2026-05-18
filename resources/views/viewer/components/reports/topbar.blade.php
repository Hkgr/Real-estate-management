<header class="topbar">
    <div class="topbar-title topbar-title-desktop" id="topbar-title">بوابة <span>الإحصاءات</span></div>

    <nav class="topbar-mobile-nav" aria-label="تنقل رئيسي">
        <a href="{{ route('viewer-new.reports.index') }}" class="topbar-nav-pill active" id="mnav-properties">
            <span class="pill-label">التقارير</span>
        </a>
        <a href="{{ route('viewer-new.index') }}" class="topbar-nav-pill" id="mnav-dashboard">
            <span class="pill-label">الإحصاءات</span>
        </a>
    </nav>

    <div class="topbar-actions">
        <div class="topbar-date topbar-datetime" id="topbar-datetime">
            <span id="topbar-time">--:--:--</span>
            <span class="topbar-datetime-sep">•</span>
            <span id="topbar-date">جارٍ التحميل…</span>
        </div>
        <a href="{{ route('viewer-new.reports.index') }}" class="topbar-btn topbar-btn-props" id="topbar-hub-shortcut" title="الانتقال إلى قسم التقارير">⊞ إلى التقارير</a>
        <a href="{{ route('viewer-new.index') }}" class="topbar-btn logout">⎋ الرجوع للبوابة</a>
    </div>
</header>
