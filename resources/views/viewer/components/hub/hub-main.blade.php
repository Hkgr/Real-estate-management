<!-- MAIN -->
<main class="main">
  <div class="main-left">
    <div class="section-card open" id="menu-main-sections">
      <button class="section-toggle" type="button" onclick="toggleSection('menu-main-sections')">
        <span class="panel-title">الأقسام الرئيسية</span>
        <span class="section-toggle-icon">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
        </span>
      </button>
      <div class="section-content">
        <div class="nav-cards">
      <a class="nav-card" href="{{ route('viewer-new.reports') }}">
      <div class="nc-visual">
        <div class="nc-visual-bg">
          <svg width="100%" height="100%" viewBox="0 0 560 176" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
            <rect width="560" height="176" fill="#0e0c07"/>
            <line x1="0" y1="136" x2="560" y2="136" stroke="#D4AF37" stroke-width=".4" opacity=".12"/>
            <line x1="0" y1="102" x2="560" y2="102" stroke="#D4AF37" stroke-width=".4" opacity=".08"/>
            <line x1="0" y1="68" x2="560" y2="68" stroke="#D4AF37" stroke-width=".4" opacity=".07"/>
            <line x1="0" y1="34" x2="560" y2="34" stroke="#D4AF37" stroke-width=".3" opacity=".06"/>
            <rect x="38" y="88" width="36" height="48" rx="4" fill="#C49A2A" opacity=".32"/>
            <rect x="94" y="58" width="36" height="78" rx="4" fill="#D4AF37" opacity=".48"/>
            <rect x="150" y="38" width="36" height="98" rx="4" fill="#C49A2A" opacity=".38"/>
            <rect x="206" y="68" width="36" height="68" rx="4" fill="#D4AF37" opacity=".52"/>
            <rect x="262" y="28" width="36" height="108" rx="4" fill="#E8C96A" opacity=".62"/>
            <rect x="318" y="52" width="36" height="84" rx="4" fill="#D4AF37" opacity=".48"/>
            <rect x="374" y="42" width="36" height="94" rx="4" fill="#C49A2A" opacity=".42"/>
            <rect x="430" y="18" width="36" height="118" rx="4" fill="#E8C96A" opacity=".68"/>
            <rect x="486" y="35" width="36" height="101" rx="4" fill="#D4AF37" opacity=".55"/>
            <polyline points="56,88 112,58 168,38 224,68 280,28 336,52 392,42 448,18 504,35" stroke="#D4AF37" stroke-width="1.8" fill="none" opacity=".55" stroke-linejoin="round" stroke-linecap="round"/>
            <circle cx="56" cy="88" r="3.5" fill="#E8C96A" opacity=".7"/>
            <circle cx="280" cy="28" r="5" fill="#E8C96A" opacity=".9"/>
            <circle cx="448" cy="18" r="3.5" fill="#E8C96A" opacity=".8"/>
            <defs><linearGradient id="sg" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#8B6914"/><stop offset="50%" stop-color="#D4AF37"/><stop offset="100%" stop-color="#8B6914"/></linearGradient></defs>
            <rect width="560" height="2" fill="url(#sg)"/>
          </svg>
        </div>
        <div class="nc-visual-fade"></div>

      </div>
      <div class="nc-body">
        <div class="nc-title">الإحصاءات</div>
        <div class="nc-desc">استعراض تحليلي شامل للمحفظة العقارية — رسوم بيانية تفاعلية، إحصاءات مالية مفصلة، ومؤشرات أداء الأصول.</div>
        <div class="nc-chips">
          <span class="nc-chip"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519"/></svg>رسوم بيانية</span>
          <span class="nc-chip"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0"/></svg>تحليل مالي</span>
          <span class="nc-chip"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9"/></svg>مؤشرات الأداء</span>
        </div>
        <div class="nc-cta">
          <span class="nc-cta-text"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>انتقل إلى لوحة الإحصاءات</span>
          <div class="nc-cta-btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg></div>
        </div>
      </div>
      </a>
      <a class="nav-card" href="{{ route('viewer-new.reports') }}" onclick="gotoProperties(event)">
      <div class="nc-visual">
        <div class="nc-visual-bg">
          <svg width="100%" height="100%" viewBox="0 0 560 176" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
            <rect width="560" height="176" fill="#0d0c09"/>
            <rect x="28" y="26" width="504" height="22" rx="4" fill="#D4AF37" opacity=".13"/>
            <rect x="28" y="56" width="504" height="18" rx="3" fill="#231e10" opacity=".9"/>
            <rect x="28" y="82" width="504" height="18" rx="3" fill="#1a170b" opacity=".7"/>
            <rect x="28" y="108" width="504" height="18" rx="3" fill="#231e10" opacity=".6"/>
            <rect x="28" y="134" width="320" height="18" rx="3" fill="#1a170b" opacity=".5"/>
            <line x1="168" y1="26" x2="168" y2="158" stroke="#D4AF37" stroke-width=".5" opacity=".16"/>
            <line x1="308" y1="26" x2="308" y2="158" stroke="#D4AF37" stroke-width=".5" opacity=".16"/>
            <line x1="428" y1="26" x2="428" y2="158" stroke="#D4AF37" stroke-width=".5" opacity=".16"/>
            <rect x="46" y="32" width="82" height="8" rx="2" fill="#D4AF37" opacity=".48"/>
            <rect x="186" y="32" width="62" height="8" rx="2" fill="#D4AF37" opacity=".38"/>
            <rect x="326" y="32" width="52" height="8" rx="2" fill="#D4AF37" opacity=".38"/>
            <rect x="446" y="32" width="42" height="8" rx="2" fill="#D4AF37" opacity=".38"/>
            <rect x="46" y="62" width="102" height="6" rx="2" fill="#B0A898" opacity=".48"/>
            <rect x="186" y="62" width="72" height="6" rx="2" fill="#C49A2A" opacity=".58"/>
            <rect x="46" y="88" width="92" height="6" rx="2" fill="#B0A898" opacity=".38"/>
            <rect x="186" y="88" width="62" height="6" rx="2" fill="#C49A2A" opacity=".48"/>
            <rect x="46" y="114" width="112" height="6" rx="2" fill="#B0A898" opacity=".32"/>
            <rect x="186" y="114" width="82" height="6" rx="2" fill="#C49A2A" opacity=".42"/>
            <rect x="326" y="59" width="54" height="12" rx="6" fill="#4ade80" opacity=".18"/>
            <rect x="326" y="85" width="50" height="12" rx="6" fill="#D4AF37" opacity=".18"/>
            <rect x="326" y="111" width="46" height="12" rx="6" fill="#94a3b8" opacity=".16"/>
            <defs><linearGradient id="pg" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#8B6914"/><stop offset="50%" stop-color="#D4AF37"/><stop offset="100%" stop-color="#8B6914"/></linearGradient></defs>
            <rect width="560" height="2" fill="url(#pg)"/>
          </svg>
        </div>
        <div class="nc-visual-fade"></div>

      </div>
      <div class="nc-body">
        <div class="nc-title">التقارير</div>
        <div class="nc-desc">تصفح تقرير شامل لجميع العقارات المملوكة — التفاصيل الكاملة، الموقع، المساحة، والبيانات المالية لكل عقار.</div>
        <div class="nc-chips">
          <span class="nc-chip"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>الموقع</span>
          <span class="nc-chip"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25"/></svg>جدول تفصيلي</span>
          <span class="nc-chip"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>تصدير CSV</span>
        </div>
        <div class="nc-cta">
          <span class="nc-cta-text"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>انتقل الى التقارير</span>
          <div class="nc-cta-btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg></div>
        </div>
      </div>
      </a>
        </div>
      </div>
    </div>
    <div class="section-card open" id="menu-quick-stats">
      <button class="section-toggle" type="button" onclick="toggleSection('menu-quick-stats')">
        <span class="panel-title">نظرة سريعة</span>
        <span class="section-toggle-icon">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
        </span>
      </button>
      <div class="section-content">
        <div class="quick-grid">
      <div class="q-card">
      <div class="q-card-top"><div class="q-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18"/></svg></div><div class="q-num">٢٤</div></div>
      <div class="q-label">إجمالي العقارات</div><div class="q-sub">مسجلة في المنظومة</div>
      </div>
      <div class="q-card">
      <div class="q-card-top"><div class="q-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9"/></svg></div><div class="q-num">٨٤٠٠</div></div>
      <div class="q-label">إجمالي المساحة</div><div class="q-sub">متر مربع</div>
      </div>
      <div class="q-card">
      <div class="q-card-top"><div class="q-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div><div class="q-num">٨٧٪</div></div>
      <div class="q-label">نسبة الإشغال</div><div class="q-sub">من إجمالي الوحدات</div>
      </div>
        </div>
      </div>
    </div>
  </div>

  <div class="main-right">
    <div class="settings-widget open" id="settings-widget">
      <div class="s-header" onclick="toggleSettings()">
      <div class="s-header-left">
        <div class="s-header-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
        <div><div class="s-header-title">الإعدادات السريعة</div><div class="s-header-sub">كل الخيارات أمامك مباشرة بدون تمرير</div></div>
      </div>
      <div style="display:flex;align-items:center;gap:8px">
        <button type="button" class="qs-reset-btn" onclick="event.stopPropagation();resetAllSettings()" title="إعادة تعيين كل الإعدادات">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
          افتراضي
        </button>
        <div class="s-chevron"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg></div>
      </div>
    </div>
    <div class="s-body">
      <div class="s-row"><div class="s-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>المظهر</div><div class="tpill"><button class="tpill-btn active" id="theme-dark-btn" onclick="setThemePref('dark')">🌙 داكن</button><button class="tpill-btn" id="theme-light-btn" onclick="setThemePref('light')">☀️ فاتح</button></div></div>
      <div class="s-row" style="grid-column:1/-1"><div class="s-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12"/></svg>حجم الخط</div><div class="tpill"><button class="tpill-btn active" id="fs-normal-btn" onclick="setFontSize('normal')">١٥</button><button class="tpill-btn" id="fs-large-btn" onclick="setFontSize('large')">١٧</button><button class="tpill-btn" id="fs-xl-btn" onclick="setFontSize('xl')">٢٠</button><button class="tpill-btn" id="fs-xxl-btn" onclick="setFontSize('xxl')">٢٢</button></div></div>
      <div class="s-row" style="grid-column:1/-1"><div class="s-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0"/></svg>العملة</div><div class="tpill"><button class="tpill-btn active" id="cur-usd-btn" onclick="setCurrency('USD')">$ دولار</button><button class="tpill-btn" id="cur-lbp-btn" onclick="setCurrency('LBP')" hidden>ليرة سورية</button><button class="tpill-btn" id="cur-aed-btn" onclick="setCurrency('AED')" hidden>درهم إماراتي</button></div></div>
      <div class="s-row"><div class="s-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>المساحة</div><div class="tpill"><button class="tpill-btn active" id="area-m2-btn" onclick="setArea('m2')">م² متر</button><button class="tpill-btn" id="area-ft2-btn" onclick="setArea('ft2')">قدم²</button></div></div>
      <div class="s-row"><div class="s-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375"/></svg>معيار التملك</div><div class="tpill"><button class="tpill-btn active" id="own-sahm-btn" onclick="setOwnership('sahm')">سهم / 2400</button><button class="tpill-btn" id="own-pct-btn" onclick="setOwnership('pct')">نسبة %</button></div></div>
      <div class="s-row" style="grid-column:1/-1"><div class="s-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12"/></svg>نوع الخط</div>
        <div class="font-opts">
          <label class="font-opt"><input type="radio" name="fontFamily" value="Tajawal" checked><div class="font-opt-radio"></div><div><div class="font-opt-lbl" style="font-family:'Tajawal',sans-serif">تجوّل</div><div class="font-opt-sub">Tajawal</div></div></label>
          <label class="font-opt"><input type="radio" name="fontFamily" value="Cairo"><div class="font-opt-radio"></div><div><div class="font-opt-lbl" style="font-family:'Cairo',sans-serif">القاهرة</div><div class="font-opt-sub">Cairo</div></div></label>
          <label class="font-opt"><input type="radio" name="fontFamily" value="Amiri"><div class="font-opt-radio"></div><div><div class="font-opt-lbl" style="font-family:'Amiri',serif">أميري</div><div class="font-opt-sub">Amiri</div></div></label>
        </div>
      </div>
      <div class="s-row" style="grid-column:1/-1"><div class="s-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3"/></svg>لون الخط</div><div class="qs-color-opts"><button type="button" class="qs-color-btn qs-swatch-fc-default" id="font-color-default-btn" onclick="setFontColor('default')" title="افتراضي"></button><button type="button" class="qs-color-btn qs-swatch-fc-ivory" id="font-color-ivory-btn" onclick="setFontColor('ivory')" title="عاجي"></button><button type="button" class="qs-color-btn qs-swatch-fc-gold" id="font-color-gold-btn" onclick="setFontColor('gold')" title="ذهبي"></button><button type="button" class="qs-color-btn qs-swatch-fc-silver" id="font-color-silver-btn" onclick="setFontColor('silver')" title="فضي"></button><button type="button" class="qs-color-btn qs-swatch-fc-mint" id="font-color-mint-btn" onclick="setFontColor('mint')" title="نعناعي"></button><button type="button" class="qs-color-btn qs-swatch-fc-rose" id="font-color-rose-btn" onclick="setFontColor('rose')" title="وردي"></button></div></div>
      <div class="s-row" style="grid-column:1/-1"><div class="s-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5h18M3 12h18M3 16.5h18"/></svg>لون شريط التنقل</div><div class="qs-color-opts"><button type="button" class="qs-color-btn qs-swatch-default" id="nav-color-default-btn" onclick="setNavbarColor('default')" title="افتراضي"></button><button type="button" class="qs-color-btn qs-swatch-obsidian" id="nav-color-obsidian-btn" onclick="setNavbarColor('obsidian')" title="أوبسيديان"></button><button type="button" class="qs-color-btn qs-swatch-sand" id="nav-color-sand-btn" onclick="setNavbarColor('sand')" title="رملي"></button><button type="button" class="qs-color-btn qs-swatch-emerald" id="nav-color-emerald-btn" onclick="setNavbarColor('emerald')" title="زمردي"></button><button type="button" class="qs-color-btn qs-swatch-royal" id="nav-color-royal-btn" onclick="setNavbarColor('royal')" title="ملكي"></button><button type="button" class="qs-color-btn qs-swatch-burgundy" id="nav-color-burgundy-btn" onclick="setNavbarColor('burgundy')" title="خمري"></button></div></div>
      <div class="s-row" style="grid-column:1/-1"><div class="s-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5.25h18M3 12h18M3 18.75h18"/></svg>لون رأس الصفحة</div><div class="qs-color-opts"><button type="button" class="qs-color-btn qs-swatch-default" id="header-color-default-btn" onclick="setHeaderColor('default')" title="افتراضي"></button><button type="button" class="qs-color-btn qs-swatch-obsidian" id="header-color-obsidian-btn" onclick="setHeaderColor('obsidian')" title="أوبسيديان"></button><button type="button" class="qs-color-btn qs-swatch-sand" id="header-color-sand-btn" onclick="setHeaderColor('sand')" title="رملي"></button><button type="button" class="qs-color-btn qs-swatch-emerald" id="header-color-emerald-btn" onclick="setHeaderColor('emerald')" title="زمردي"></button><button type="button" class="qs-color-btn qs-swatch-royal" id="header-color-royal-btn" onclick="setHeaderColor('royal')" title="ملكي"></button><button type="button" class="qs-color-btn qs-swatch-burgundy" id="header-color-burgundy-btn" onclick="setHeaderColor('burgundy')" title="خمري"></button></div></div>
      <div class="s-row" style="grid-column:1/-1"><div class="s-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6.75h15m-15 5.25h15m-15 5.25h15"/></svg>لون الجداول</div><div class="qs-color-opts"><button type="button" class="qs-color-btn qs-swatch-default" id="table-color-default-btn" onclick="setTableColor('default')" title="افتراضي"></button><button type="button" class="qs-color-btn qs-swatch-obsidian" id="table-color-obsidian-btn" onclick="setTableColor('obsidian')" title="أوبسيديان"></button><button type="button" class="qs-color-btn qs-swatch-sand" id="table-color-sand-btn" onclick="setTableColor('sand')" title="رملي"></button><button type="button" class="qs-color-btn qs-swatch-emerald" id="table-color-emerald-btn" onclick="setTableColor('emerald')" title="زمردي"></button><button type="button" class="qs-color-btn qs-swatch-royal" id="table-color-royal-btn" onclick="setTableColor('royal')" title="ملكي"></button><button type="button" class="qs-color-btn qs-swatch-burgundy" id="table-color-burgundy-btn" onclick="setTableColor('burgundy')" title="خمري"></button></div></div>
      <div class="s-row" style="grid-column:1/-1"><div class="s-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/></svg>لون اللوحة</div><div class="qs-color-opts"><button type="button" class="qs-color-btn qs-swatch-default" id="panel-color-default-btn" onclick="setPanelColor('default')" title="افتراضي"></button><button type="button" class="qs-color-btn qs-swatch-plum" id="panel-color-plum-btn" onclick="setPanelColor('plum')" title="برقوقي"></button><button type="button" class="qs-color-btn qs-swatch-slate" id="panel-color-slate-btn" onclick="setPanelColor('slate')" title="أردوازي"></button><button type="button" class="qs-color-btn qs-swatch-navy" id="panel-color-navy-btn" onclick="setPanelColor('navy')" title="نيلي"></button><button type="button" class="qs-color-btn qs-swatch-forest" id="panel-color-forest-btn" onclick="setPanelColor('forest')" title="غابي"></button><button type="button" class="qs-color-btn qs-swatch-stone" id="panel-color-stone-btn" onclick="setPanelColor('stone')" title="حجري"></button><button type="button" class="qs-color-btn qs-swatch-rose" id="panel-color-rose-btn" onclick="setPanelColor('rose')" title="وردي"></button><button type="button" class="qs-color-btn qs-swatch-teal" id="panel-color-teal-btn" onclick="setPanelColor('teal')" title="فيروزي"></button><button type="button" class="qs-color-btn qs-swatch-gold-panel" id="panel-color-gold-btn" onclick="setPanelColor('gold')" title="ذهبي"></button></div></div>
      <div class="s-row" style="grid-column:1/-1"><div class="s-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3"/></svg>اللغة</div>
        <div class="tpill" style="max-width:260px"><button class="tpill-btn active" id="lang-ar-btn" onclick="setLang('ar')">🇸🇦 العربية</button><button class="tpill-btn" id="lang-en-btn" onclick="setLang('en')">🇬🇧 English</button></div>
        <div class="s-lang-hint">* تغيير اللغة سيؤثر على واجهة الموقع بالكامل عند اكتمال التنفيذ</div>
      </div>
    </div>
    <div class="section-card open" id="menu-photos-info">
      <button class="section-toggle" type="button" onclick="toggleSection('menu-photos-info')">
        <span class="panel-title">صور العقارات والمعلومات</span>
        <span class="section-toggle-icon">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
        </span>
      </button>
      <div class="section-content">
        <div class="mini-photos">
      <a class="mini-photo" href="{{ route('viewer-new.reports') }}" onclick="gotoProperties(event)">
        <svg viewBox="0 0 200 100" xmlns="http://www.w3.org/2000/svg">
          <rect width="200" height="100" fill="#120f08"/>
          <rect x="14" y="48" width="52" height="32" rx="3" fill="#3a2d13"/>
          <rect x="20" y="56" width="10" height="8" fill="#D4AF37" opacity=".5"/>
          <rect x="34" y="56" width="10" height="8" fill="#D4AF37" opacity=".5"/>
          <rect x="48" y="56" width="10" height="8" fill="#D4AF37" opacity=".5"/>
          <rect x="74" y="36" width="58" height="44" rx="3" fill="#513d16"/>
          <rect x="84" y="46" width="14" height="10" fill="#E8C96A" opacity=".65"/>
          <rect x="104" y="46" width="14" height="10" fill="#E8C96A" opacity=".65"/>
          <rect x="138" y="56" width="48" height="24" rx="3" fill="#2a2110"/>
          <circle cx="166" cy="24" r="9" fill="#D4AF37" opacity=".35"/>
        </svg>
        <span class="cap">فلل</span>
      </a>
      <a class="mini-photo" href="{{ route('viewer-new.reports') }}">
        <svg viewBox="0 0 200 100" xmlns="http://www.w3.org/2000/svg">
          <rect width="200" height="100" fill="#100e09"/>
          <rect x="16" y="42" width="30" height="38" rx="2" fill="#4e3a16"/>
          <rect x="52" y="30" width="30" height="50" rx="2" fill="#70551f"/>
          <rect x="88" y="22" width="30" height="58" rx="2" fill="#8B6914"/>
          <rect x="124" y="36" width="30" height="44" rx="2" fill="#6d5220"/>
          <rect x="160" y="48" width="24" height="32" rx="2" fill="#4b3919"/>
          <line x1="0" y1="80" x2="200" y2="80" stroke="#D4AF37" opacity=".3"/>
        </svg>
        <span class="cap">مكاتب</span>
      </a>
        </div>
        <div class="info-card">
      <div class="info-item"><div class="info-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg></div><div><div class="info-title"><span class="sdot"></span> حالة النظام</div><div class="info-sub">جميع الخدمات تعمل بشكل طبيعي</div></div></div>
      <div class="info-item"><div class="info-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg></div><div><div class="info-title">الصلاحيات</div><div class="info-sub" id="info-role-text">عارض — مشاهدة فقط</div></div></div>
      <div class="info-item"><div class="info-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div><div><div class="info-title">آخر تحديث</div><div class="info-sub" id="info-time">—</div></div></div>
      </div>
      </div>
    </div>
  </div>
</main>

<script>
const PREF_KEY='realestate_prefs';
function getPrefs(){try{return JSON.parse(localStorage.getItem(PREF_KEY))||{};}catch{return {};}}
function savePrefs(p){localStorage.setItem(PREF_KEY,JSON.stringify(p));}
function initUser(){
  const user=localStorage.getItem('loggedInUser')||'viewer';
  const role=localStorage.getItem('userRole')||'viewer';
  const nameMap={admin:'مدير النظام',viewer:'عارض'};
  const n=nameMap[user]||user;
  const heroName=document.getElementById('hero-name');if(heroName)heroName.textContent=n;
  document.getElementById('user-display-name').textContent=n;
  document.getElementById('user-role-label').textContent=role==='admin'?'مدير':'عارض';
  document.getElementById('user-avatar-letter').textContent=n.charAt(0);
  const ri=document.getElementById('info-role-text');
  if(ri)ri.textContent=role==='admin'?'مدير — صلاحيات كاملة':'عارض — مشاهدة فقط';
}
function setThemePref(t){document.documentElement.setAttribute('data-theme',t);localStorage.setItem('themeMode',t);const p=getPrefs();p.theme=t;savePrefs(p);document.getElementById('theme-dark-btn').classList.toggle('active',t==='dark');document.getElementById('theme-light-btn').classList.toggle('active',t==='light');setFontColor(p.fontColor||'default');setNavbarColor(p.navbarColor||'default');setHeaderColor(p.headerColor||'default');setTableColor(p.tableColor||'default');setPanelColor(p.panelColor||'plum');}
function setFontSize(s){const sizeMap={normal:'15px',large:'17px',xl:'20px',xxl:'22px'};const sz=sizeMap[s]||'15px';document.documentElement.style.setProperty('--fs-base',sz);const p=getPrefs();p.fontSize=s;savePrefs(p);['normal','large','xl','xxl'].forEach(k=>{const btn=document.getElementById(`fs-${k}-btn`);if(btn)btn.classList.toggle('active',s===k);});}
const DEFAULT_RATES = { LBP: 124, AED: 3.67 };
function getExchangeRateFor(c) { const p = getPrefs(); return (p.exchangeRates && p.exchangeRates[c]) ? p.exchangeRates[c] : (DEFAULT_RATES[c] || 1); }
function updateCurrencyRateUi(c) {
  const rd = document.getElementById('rate-display');
  const rn = document.getElementById('rate-currency-name');
  const ri = document.getElementById('rate-input');
  if (c === 'USD') {
    if (rd) rd.textContent = '—';
    if (rn) rn.textContent = '';
    if (ri) { ri.value = ''; ri.disabled = true; ri.style.opacity = '.4'; }
  } else {
    const rate = getExchangeRateFor(c);
    const label = c === 'LBP' ? 'ليرة سورية' : 'درهم إماراتي';
    if (rd) rd.textContent = rate.toLocaleString('ar-SA', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    if (rn) rn.textContent = label;
    if (ri) { ri.value = rate; ri.disabled = false; ri.style.opacity = '1'; }
  }
}
function setCurrency(c) { const p = getPrefs(); p.currency = c; savePrefs(p); const u = document.getElementById('cur-usd-btn'); const lb = document.getElementById('cur-lbp-btn'); const ae = document.getElementById('cur-aed-btn'); if (u) u.classList.toggle('active', c === 'USD'); if (lb) lb.classList.toggle('active', c === 'LBP'); if (ae) ae.classList.toggle('active', c === 'AED'); updateCurrencyRateUi(c); }
function setExchangeRate(rawValue) { const p = getPrefs(); const selected = p.currency || 'USD'; if (selected === 'USD') return; const parsed = Number(rawValue); if (!isFinite(parsed) || parsed <= 0) return; p.exchangeRates = p.exchangeRates || {}; p.exchangeRates[selected] = parsed; savePrefs(p); updateCurrencyRateUi(selected); }
function setArea(a){const p=getPrefs();p.area=a;savePrefs(p);document.getElementById('area-m2-btn').classList.toggle('active',a==='m2');document.getElementById('area-ft2-btn').classList.toggle('active',a==='ft2');}
function setOwnership(o){const p=getPrefs();p.ownership=o;savePrefs(p);document.getElementById('own-sahm-btn').classList.toggle('active',o==='sahm');document.getElementById('own-pct-btn').classList.toggle('active',o==='pct');}
document.querySelectorAll('[name="fontFamily"]').forEach(r=>{r.addEventListener('change',function(){applyFont(this.value);const p=getPrefs();p.fontFamily=this.value;savePrefs(p);});});
function applyFont(f){const fm={Tajawal:"'Tajawal', sans-serif",Cairo:"'Cairo', sans-serif",Amiri:"'Amiri', serif"};const v=fm[f]||fm['Tajawal'];document.documentElement.style.setProperty('--font-body',v);document.documentElement.style.setProperty('--font-ui',v);document.documentElement.style.setProperty('--font-display',v);}
function setFontColor(colorMode){const p=getPrefs();p.fontColor=colorMode;savePrefs(p);const theme=document.documentElement.getAttribute('data-theme')||p.theme||'dark';const palettes={ivory:{dark:{primary:'#F5F0E8',secondary:'#DCCFB7',muted:'#B6A98E'},light:{primary:'#2D2418',secondary:'#645845',muted:'#867864'}},gold:{dark:{primary:'#E8C96A',secondary:'#D8B44F',muted:'#A48A46'},light:{primary:'#7A5B16',secondary:'#9B7522',muted:'#B08A3B'}},silver:{dark:{primary:'#E6EBF2',secondary:'#C6CEDB',muted:'#95A0B2'},light:{primary:'#2C3748',secondary:'#4C5A6F',muted:'#6B788B'}},mint:{dark:{primary:'#DDF8EE',secondary:'#AEE7D1',muted:'#79B79D'},light:{primary:'#1E5E4B',secondary:'#2F7861',muted:'#4A9078'}},rose:{dark:{primary:'#F8E5EC',secondary:'#E7BBCB',muted:'#B98297'},light:{primary:'#6A3245',secondary:'#8A4760',muted:'#A26179'}}};if(colorMode==='default'){document.documentElement.style.removeProperty('--text-primary');document.documentElement.style.removeProperty('--text-secondary');document.documentElement.style.removeProperty('--text-muted');}else if(palettes[colorMode]){const active=palettes[colorMode][theme==='light'?'light':'dark'];document.documentElement.style.setProperty('--text-primary',active.primary);document.documentElement.style.setProperty('--text-secondary',active.secondary);document.documentElement.style.setProperty('--text-muted',active.muted);}['default','ivory','gold','silver','mint','rose'].forEach(mode=>{const btn=document.getElementById(`font-color-${mode}-btn`);if(btn)btn.classList.toggle('active',colorMode===mode);});}
function setNavbarColor(colorMode){const p=getPrefs();p.navbarColor=colorMode;savePrefs(p);const theme=document.documentElement.getAttribute('data-theme')||p.theme||'dark';const palettes={obsidian:{dark:{surface:'#111827',border:'#334155',hoverBg:'rgba(96,165,250,.1)',hoverBorder:'rgba(96,165,250,.28)',activeBg:'linear-gradient(135deg, rgba(96,165,250,.22), rgba(59,130,246,.10))',activeBorder:'rgba(96,165,250,.42)',activeText:'#BFDBFE'},light:{surface:'#F8FBFF',border:'#CBDDF6',hoverBg:'rgba(59,130,246,.09)',hoverBorder:'rgba(59,130,246,.25)',activeBg:'linear-gradient(135deg, rgba(59,130,246,.16), rgba(96,165,250,.08))',activeBorder:'rgba(59,130,246,.35)',activeText:'#1D4ED8'}},sand:{dark:{surface:'#20170F',border:'#5B452E',hoverBg:'rgba(245,158,11,.1)',hoverBorder:'rgba(245,158,11,.28)',activeBg:'linear-gradient(135deg, rgba(245,158,11,.22), rgba(180,83,9,.10))',activeBorder:'rgba(245,158,11,.42)',activeText:'#FCD34D'},light:{surface:'#FFF9EE',border:'#E8D7BC',hoverBg:'rgba(180,83,9,.09)',hoverBorder:'rgba(180,83,9,.25)',activeBg:'linear-gradient(135deg, rgba(180,83,9,.16), rgba(245,158,11,.08))',activeBorder:'rgba(180,83,9,.35)',activeText:'#9A580A'}},emerald:{dark:{surface:'#10211B',border:'#2C5848',hoverBg:'rgba(16,185,129,.1)',hoverBorder:'rgba(16,185,129,.28)',activeBg:'linear-gradient(135deg, rgba(16,185,129,.22), rgba(4,120,87,.10))',activeBorder:'rgba(16,185,129,.4)',activeText:'#86EFAC'},light:{surface:'#F1FBF6',border:'#C8E6D9',hoverBg:'rgba(5,150,105,.09)',hoverBorder:'rgba(5,150,105,.25)',activeBg:'linear-gradient(135deg, rgba(5,150,105,.16), rgba(16,185,129,.08))',activeBorder:'rgba(5,150,105,.35)',activeText:'#065F46'}},royal:{dark:{surface:'#19152C',border:'#4A3C7C',hoverBg:'rgba(139,92,246,.1)',hoverBorder:'rgba(167,139,250,.28)',activeBg:'linear-gradient(135deg, rgba(139,92,246,.22), rgba(79,70,229,.10))',activeBorder:'rgba(167,139,250,.42)',activeText:'#DDD6FE'},light:{surface:'#F7F2FF',border:'#DDCEF9',hoverBg:'rgba(109,40,217,.09)',hoverBorder:'rgba(109,40,217,.25)',activeBg:'linear-gradient(135deg, rgba(109,40,217,.16), rgba(139,92,246,.08))',activeBorder:'rgba(109,40,217,.35)',activeText:'#5B21B6'}},burgundy:{dark:{surface:'#25141B',border:'#673548',hoverBg:'rgba(244,114,182,.1)',hoverBorder:'rgba(244,114,182,.28)',activeBg:'linear-gradient(135deg, rgba(244,114,182,.22), rgba(190,24,93,.10))',activeBorder:'rgba(244,114,182,.42)',activeText:'#FBCFE8'},light:{surface:'#FFF4F8',border:'#EDCFDB',hoverBg:'rgba(190,24,93,.09)',hoverBorder:'rgba(190,24,93,.25)',activeBg:'linear-gradient(135deg, rgba(190,24,93,.16), rgba(244,114,182,.08))',activeBorder:'rgba(190,24,93,.35)',activeText:'#9D174D'}}};if(colorMode==='default'){document.documentElement.style.removeProperty('--nav-surface');document.documentElement.style.removeProperty('--nav-border');document.documentElement.style.removeProperty('--nav-hover-bg');document.documentElement.style.removeProperty('--nav-hover-border');document.documentElement.style.removeProperty('--nav-active-bg');document.documentElement.style.removeProperty('--nav-active-border');document.documentElement.style.removeProperty('--nav-active-text');}else if(palettes[colorMode]){const nav=palettes[colorMode][theme==='light'?'light':'dark'];document.documentElement.style.setProperty('--nav-surface',nav.surface);document.documentElement.style.setProperty('--nav-border',nav.border);document.documentElement.style.setProperty('--nav-hover-bg',nav.hoverBg);document.documentElement.style.setProperty('--nav-hover-border',nav.hoverBorder);document.documentElement.style.setProperty('--nav-active-bg',nav.activeBg);document.documentElement.style.setProperty('--nav-active-border',nav.activeBorder);document.documentElement.style.setProperty('--nav-active-text',nav.activeText);}['default','obsidian','sand','emerald','royal','burgundy'].forEach(mode=>{const btn=document.getElementById(`nav-color-${mode}-btn`);if(btn)btn.classList.toggle('active',colorMode===mode);});}
function setHeaderColor(colorMode){const p=getPrefs();p.headerColor=colorMode;savePrefs(p);const theme=document.documentElement.getAttribute('data-theme')||p.theme||'dark';const palettes={obsidian:{dark:{surface:'linear-gradient(135deg,rgba(12,18,28,.9),rgba(8,12,20,.86))',border:'#2B3A52',accent:'#93C5FD',eyebrow:'#7FB3F4'},light:{surface:'linear-gradient(135deg,rgba(239,247,255,.95),rgba(227,240,255,.9))',border:'#C8DAF3',accent:'#2563EB',eyebrow:'#346FC9'}},sand:{dark:{surface:'linear-gradient(135deg,rgba(36,24,14,.9),rgba(26,17,10,.86))',border:'#5A422A',accent:'#FCD34D',eyebrow:'#E7BC58'},light:{surface:'linear-gradient(135deg,rgba(255,246,233,.95),rgba(250,236,210,.9))',border:'#E8D2B2',accent:'#B45309',eyebrow:'#9B640F'}},emerald:{dark:{surface:'linear-gradient(135deg,rgba(14,34,28,.9),rgba(10,24,20,.86))',border:'#2A584A',accent:'#6EE7B7',eyebrow:'#64D5A7'},light:{surface:'linear-gradient(135deg,rgba(235,250,243,.95),rgba(220,245,233,.9))',border:'#C1E7D4',accent:'#047857',eyebrow:'#0B8A66'}},royal:{dark:{surface:'linear-gradient(135deg,rgba(24,18,42,.9),rgba(17,12,31,.86))',border:'#473A77',accent:'#C4B5FD',eyebrow:'#AE99F4'},light:{surface:'linear-gradient(135deg,rgba(244,240,255,.95),rgba(233,225,255,.9))',border:'#D8CCFA',accent:'#6D28D9',eyebrow:'#7B36E0'}},burgundy:{dark:{surface:'linear-gradient(135deg,rgba(39,18,24,.9),rgba(28,12,17,.86))',border:'#663043',accent:'#F9A8D4',eyebrow:'#F28DBF'},light:{surface:'linear-gradient(135deg,rgba(255,241,247,.95),rgba(250,224,236,.9))',border:'#EDCCDA',accent:'#BE185D',eyebrow:'#C02D68'}}};if(colorMode==='default'){document.documentElement.style.removeProperty('--header-surface');document.documentElement.style.removeProperty('--header-border');document.documentElement.style.removeProperty('--header-title-accent');document.documentElement.style.removeProperty('--header-eyebrow');}else if(palettes[colorMode]){const h=palettes[colorMode][theme==='light'?'light':'dark'];document.documentElement.style.setProperty('--header-surface',h.surface);document.documentElement.style.setProperty('--header-border',h.border);document.documentElement.style.setProperty('--header-title-accent',h.accent);document.documentElement.style.setProperty('--header-eyebrow',h.eyebrow);}['default','obsidian','sand','emerald','royal','burgundy'].forEach(mode=>{const btn=document.getElementById(`header-color-${mode}-btn`);if(btn)btn.classList.toggle('active',colorMode===mode);});}
function setTableColor(colorMode){const p=getPrefs();p.tableColor=colorMode;savePrefs(p);const theme=document.documentElement.getAttribute('data-theme')||p.theme||'dark';const palettes={obsidian:{dark:{surface:'#111827',border:'#334155',headBg:'#172033',headText:'#94A3B8',headHover:'#93C5FD',rowBorder:'rgba(71,85,105,.65)',rowHoverBg:'rgba(96,165,250,.08)',rowSelectedBg:'rgba(96,165,250,.14)',rowSelectedBorder:'rgba(96,165,250,.32)'},light:{surface:'#F8FBFF',border:'#CBDDF6',headBg:'#EAF2FF',headText:'#4F6688',headHover:'#2563EB',rowBorder:'rgba(151,174,209,.62)',rowHoverBg:'rgba(59,130,246,.08)',rowSelectedBg:'rgba(59,130,246,.14)',rowSelectedBorder:'rgba(59,130,246,.28)'}},sand:{dark:{surface:'#1F1810',border:'#5B452E',headBg:'#2A2016',headText:'#BEA789',headHover:'#F3C56C',rowBorder:'rgba(121,94,61,.62)',rowHoverBg:'rgba(245,158,11,.08)',rowSelectedBg:'rgba(245,158,11,.14)',rowSelectedBorder:'rgba(245,158,11,.3)'},light:{surface:'#FFF9EE',border:'#E8D7BC',headBg:'#FBF1DD',headText:'#876B42',headHover:'#B45309',rowBorder:'rgba(205,180,141,.62)',rowHoverBg:'rgba(180,83,9,.08)',rowSelectedBg:'rgba(180,83,9,.14)',rowSelectedBorder:'rgba(180,83,9,.28)'}},emerald:{dark:{surface:'#10211B',border:'#2C5848',headBg:'#162E25',headText:'#8DB9A8',headHover:'#6EE7B7',rowBorder:'rgba(63,109,94,.62)',rowHoverBg:'rgba(16,185,129,.08)',rowSelectedBg:'rgba(16,185,129,.14)',rowSelectedBorder:'rgba(16,185,129,.31)'},light:{surface:'#F1FBF6',border:'#C8E6D9',headBg:'#E2F5EC',headText:'#4F7D6D',headHover:'#047857',rowBorder:'rgba(137,186,167,.62)',rowHoverBg:'rgba(5,150,105,.08)',rowSelectedBg:'rgba(5,150,105,.14)',rowSelectedBorder:'rgba(5,150,105,.28)'}},royal:{dark:{surface:'#19152C',border:'#4A3C7C',headBg:'#211A38',headText:'#AFA0D9',headHover:'#C4B5FD',rowBorder:'rgba(93,81,145,.62)',rowHoverBg:'rgba(139,92,246,.08)',rowSelectedBg:'rgba(139,92,246,.14)',rowSelectedBorder:'rgba(167,139,250,.31)'},light:{surface:'#F7F2FF',border:'#DDCEF9',headBg:'#EFE6FF',headText:'#74639F',headHover:'#6D28D9',rowBorder:'rgba(177,157,218,.62)',rowHoverBg:'rgba(109,40,217,.08)',rowSelectedBg:'rgba(109,40,217,.14)',rowSelectedBorder:'rgba(109,40,217,.28)'}},burgundy:{dark:{surface:'#25141B',border:'#673548',headBg:'#301924',headText:'#C39AAF',headHover:'#F9A8D4',rowBorder:'rgba(110,67,84,.62)',rowHoverBg:'rgba(244,114,182,.08)',rowSelectedBg:'rgba(244,114,182,.14)',rowSelectedBorder:'rgba(244,114,182,.31)'},light:{surface:'#FFF4F8',border:'#EDCFDB',headBg:'#FDEAF1',headText:'#8C5D70',headHover:'#BE185D',rowBorder:'rgba(205,154,177,.62)',rowHoverBg:'rgba(190,24,93,.08)',rowSelectedBg:'rgba(190,24,93,.14)',rowSelectedBorder:'rgba(190,24,93,.28)'}}};if(colorMode==='default'){document.documentElement.style.removeProperty('--table-surface');document.documentElement.style.removeProperty('--table-border');document.documentElement.style.removeProperty('--table-head-bg');document.documentElement.style.removeProperty('--table-head-text');document.documentElement.style.removeProperty('--table-head-hover');document.documentElement.style.removeProperty('--table-row-border');document.documentElement.style.removeProperty('--table-row-hover-bg');document.documentElement.style.removeProperty('--table-row-selected-bg');document.documentElement.style.removeProperty('--table-row-selected-border');}else if(palettes[colorMode]){const tb=palettes[colorMode][theme==='light'?'light':'dark'];document.documentElement.style.setProperty('--table-surface',tb.surface);document.documentElement.style.setProperty('--table-border',tb.border);document.documentElement.style.setProperty('--table-head-bg',tb.headBg);document.documentElement.style.setProperty('--table-head-text',tb.headText);document.documentElement.style.setProperty('--table-head-hover',tb.headHover);document.documentElement.style.setProperty('--table-row-border',tb.rowBorder);document.documentElement.style.setProperty('--table-row-hover-bg',tb.rowHoverBg);document.documentElement.style.setProperty('--table-row-selected-bg',tb.rowSelectedBg);document.documentElement.style.setProperty('--table-row-selected-border',tb.rowSelectedBorder);}['default','obsidian','sand','emerald','royal','burgundy'].forEach(mode=>{const btn=document.getElementById(`table-color-${mode}-btn`);if(btn)btn.classList.toggle('active',colorMode===mode);});}
function setLang(l){const p=getPrefs();p.lang=l;savePrefs(p);if(l==='en'){window.location.href=(document.querySelector('.viewer-hub')?.dataset.hubUrl||'/viewer-new');return;}document.getElementById('lang-ar-btn').classList.toggle('active',l==='ar');document.getElementById('lang-en-btn').classList.toggle('active',l==='en');document.documentElement.setAttribute('lang','ar');document.documentElement.setAttribute('dir','rtl');document.body.setAttribute('dir','rtl');}
function toggleSection(id){
  const sec=document.getElementById(id);
  if(!sec)return;
  const shouldOpen=!sec.classList.contains('open');
  document.querySelectorAll('.section-card').forEach(card=>card.classList.remove('open'));
  if(shouldOpen)sec.classList.add('open');
}
function toggleSettings(){document.getElementById('settings-widget').classList.toggle('open');}
function setPanelColor(colorMode){const p=getPrefs();p.panelColor=colorMode;savePrefs(p);const theme=document.documentElement.getAttribute('data-theme')||p.theme||'dark';const palettes={slate:{dark:{bg:'#1E2530',border:'#3A4558',head:'#1A2030'},light:{bg:'#EEF2F8',border:'#BCC8DC',head:'#E4EAF4'}},navy:{dark:{bg:'#111A2E',border:'#2A3F6A',head:'#0D1526'},light:{bg:'#DDE8F8',border:'#96B8E8',head:'#C8D9F4'}},forest:{dark:{bg:'#111E18',border:'#26432E',head:'#0D1A13'},light:{bg:'#D8F0E0',border:'#88C49A',head:'#C2E6CE'}},plum:{dark:{bg:'#1E1428',border:'#3E2860',head:'#180F22'},light:{bg:'#EDE0F8',border:'#C4A0E0',head:'#E0CDF4'}},stone:{dark:{bg:'#1E1C18',border:'#3D3830',head:'#191712'},light:{bg:'#EDE8DE',border:'#C0AE90',head:'#E2D9C8'}},rose:{dark:{bg:'#241420',border:'#5C2845',head:'#1C0D19'},light:{bg:'#F8E4EE',border:'#DDA0BF',head:'#F2D0E4'}},teal:{dark:{bg:'#0F1E20',border:'#1E4A50',head:'#0A1618'},light:{bg:'#D8F0EE',border:'#80C8C4',head:'#C0E6E4'}},gold:{dark:{bg:'#201A0A',border:'#5A4510',head:'#181200'},light:{bg:'#FDF3D8',border:'#D4AF5A',head:'#F8E8B8'}}};if(colorMode==='default'){document.documentElement.style.removeProperty('--qs-panel-bg');document.documentElement.style.removeProperty('--qs-panel-border');document.documentElement.style.removeProperty('--qs-panel-head-bg');}else if(palettes[colorMode]){const c=palettes[colorMode][theme==='light'?'light':'dark'];document.documentElement.style.setProperty('--qs-panel-bg',c.bg);document.documentElement.style.setProperty('--qs-panel-border',c.border);document.documentElement.style.setProperty('--qs-panel-head-bg',c.head);}['default','slate','navy','forest','plum','stone','rose','teal','gold'].forEach(mode=>{const btn=document.getElementById(`panel-color-${mode}-btn`);if(btn)btn.classList.toggle('active',colorMode===mode);}); }
function resetAllSettings(){const defaults={theme:'dark',fontSize:'normal',currency:'USD',area:'m2',ownership:'sahm',fontFamily:'Tajawal',lang:'ar',fontColor:'default',navbarColor:'default',headerColor:'default',tableColor:'default',panelColor:'plum'};savePrefs(defaults);setThemePref(defaults.theme);setFontSize(defaults.fontSize);setCurrency(defaults.currency);setArea(defaults.area);setOwnership(defaults.ownership);applyFont(defaults.fontFamily);document.querySelectorAll('[name="fontFamily"]').forEach(r=>{r.checked=r.value===defaults.fontFamily;});setFontColor(defaults.fontColor);setNavbarColor(defaults.navbarColor);setHeaderColor(defaults.headerColor);setTableColor(defaults.tableColor);setPanelColor(defaults.panelColor);if(typeof setLang==='function')setLang(defaults.lang);}
function loadPrefs(){const p=getPrefs();const t=localStorage.getItem('themeMode')||p.theme||'dark';setThemePref(t);if(p.fontSize)setFontSize(p.fontSize);if(p.currency)setCurrency(p.currency);else setCurrency('USD');if(p.area)setArea(p.area);if(p.ownership)setOwnership(p.ownership);if(p.fontFamily){applyFont(p.fontFamily);document.querySelectorAll('[name="fontFamily"]').forEach(r=>{r.checked=r.value===p.fontFamily;});}if(p.lang)setLang(p.lang);if(p.fontColor)setFontColor(p.fontColor);else setFontColor('default');if(p.navbarColor)setNavbarColor(p.navbarColor);else setNavbarColor('default');if(p.headerColor)setHeaderColor(p.headerColor);else setHeaderColor('default');if(p.tableColor)setTableColor(p.tableColor);else setTableColor('default');if(p.panelColor)setPanelColor(p.panelColor);else setPanelColor('plum');updateCurrencyRateUi(p.currency||'USD');}
function handleLogout(){if(confirm('هل تريد تسجيل الخروج؟')){localStorage.removeItem('loggedInUser');localStorage.removeItem('userRole');window.location.href=(document.querySelector('.viewer-hub')?.dataset.hubUrl||'/viewer-new');}}
function gotoProperties(e){e.preventDefault();localStorage.setItem('startPage','properties');window.location.href='{{ route('viewer-new.reports') }}';}
function updateTime(){const el=document.getElementById('info-time');if(el){const d=new Date();el.textContent=d.toLocaleString('ar-SA',{hour:'2-digit',minute:'2-digit',weekday:'short',day:'numeric',month:'short'});}}
function updateHeaderClock(){const el=document.getElementById('topbar-clock');if(!el)return;const d=new Date();el.textContent=d.toLocaleTimeString('ar-SA',{hour:'2-digit',minute:'2-digit',second:'2-digit'});}
initUser();loadPrefs();updateTime();updateHeaderClock();setInterval(updateTime,30000);setInterval(updateHeaderClock,1000);
</script>
