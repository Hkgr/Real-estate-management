<div class="settings-widget open" id="settings-widget">
    <div class="s-header" data-toggle-target="settings-widget">
        <div>
            <div class="s-header-title">الإعدادات السريعة</div>
            <div class="s-header-sub">كل الخيارات أمامك مباشرة بدون تمرير</div>
        </div>
        <button type="button" class="qs-reset-btn" id="qs-reset-btn">افتراضي</button>
    </div>

    <div class="s-body section-content">
        <div class="s-row">
            <div class="s-row-title">المظهر</div>
            <div class="tpill"><button class="tpill-btn active" id="theme-dark-btn" type="button">🌙 داكن</button><button class="tpill-btn" id="theme-light-btn" type="button">☀️ فاتح</button></div>
        </div>
        <div class="s-row">
            <div class="s-row-title">اللغة</div>
            <div class="tpill"><button class="tpill-btn active" type="button">🇸🇦 العربية</button><button class="tpill-btn" id="lang-en-btn-2" type="button">🇬🇧 English</button></div>
            <div class="s-lang-hint">* خيار الإنجليزية مؤجل حالياً.</div>
        </div>
        <div class="s-row">
            <a class="nav-card" href="{{ route('viewer-new.hub') }}">العودة للرئيسية</a>
            <a class="nav-card" href="{{ route('viewer-new.reports') }}">الانتقال إلى التقارير</a>
        </div>
    </div>
</div>
