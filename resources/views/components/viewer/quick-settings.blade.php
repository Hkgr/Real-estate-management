<div class="qs-fab" id="qs-fab">
    <div class="qs-panel" id="qs-panel" onclick="event.stopPropagation()">
        <div class="qs-panel-head">
            <div>
                <div class="qs-panel-title">الإعدادات السريعة</div>
                <div class="qs-panel-sub">مظهر، خط، ألوان، عملة، مساحة، لغة</div>
            </div>
            <div style="display:flex;align-items:center;gap:6px">
                <button type="button" class="qs-reset-btn" onclick="resetAllSettings()" aria-label="إعادة تعيين الإعدادات" title="إعادة تعيين كل الإعدادات">
                    افتراضي
                </button>
                <button type="button" class="qs-close" onclick="closeQuickSettings()" aria-label="إغلاق">✕</button>
            </div>
        </div>

        <div class="qs-panel-body">
            <div class="qs-row">
                <div class="qs-row-title">المظهر</div>
                <div class="qs-tpill">
                    <button type="button" class="qs-tpill-btn active" id="theme-dark-btn" onclick="setThemePref('dark')">🌙 داكن</button>
                    <button type="button" class="qs-tpill-btn" id="theme-light-btn" onclick="setThemePref('light')">☀️ فاتح</button>
                </div>
            </div>

            <div class="qs-row qs-span2">
                <div class="qs-row-title">حجم الخط</div>
                <div class="qs-tpill">
                    <button type="button" class="qs-tpill-btn active" id="fs-normal-btn" onclick="setFontSize('normal')">١٥</button>
                    <button type="button" class="qs-tpill-btn" id="fs-large-btn" onclick="setFontSize('large')">١٧</button>
                    <button type="button" class="qs-tpill-btn" id="fs-xl-btn" onclick="setFontSize('xl')">٢٠</button>
                    <button type="button" class="qs-tpill-btn" id="fs-xxl-btn" onclick="setFontSize('xxl')">٢٢</button>
                </div>
            </div>

            <div class="qs-row qs-span2">
                <div class="qs-row-title">اللغة</div>
                <div class="qs-tpill" style="max-width:260px">
                    <button type="button" class="qs-tpill-btn active" id="lang-ar-btn" onclick="setLang('ar')">🇸🇦 العربية</button>
                    <button type="button" class="qs-tpill-btn" id="lang-en-btn" onclick="setLang('en')">🇬🇧 English</button>
                </div>
                <div class="qs-note">* تغيير اللغة يطبق اتجاه الصفحة فوراً؛ ترجمة النصوص تُكمّل لاحقاً.</div>
            </div>
        </div>
    </div>

    <button
        type="button"
        class="qs-fab-trigger"
        id="qs-fab-trigger"
        aria-expanded="false"
        aria-label="الإعدادات السريعة"
        onclick="event.stopPropagation(); toggleQuickSettings();"
    >
        ⚙
    </button>
</div>
