<x-filament-panels::page>
    @vite([
        'resources/css/filament/viewer/dashboard.css',
        'resources/js/filament/viewer/dashboard.js',
    ])

    <div class="viewer-dashboard" dir="rtl">
        <div class="qs-fab" id="qs-fab">
            <div class="qs-panel" id="qs-panel" onclick="event.stopPropagation()">
        
        <div class="qs-panel-head">
        <div>
            <div class="qs-panel-title">الإعدادات السريعة</div>
            <div class="qs-panel-sub">مظهر، خط، ألوان، عملة، مساحة، لغة</div>
        </div>
        <div style="display:flex;align-items:center;gap:6px">
            <button type="button" class="qs-reset-btn" onclick="resetAllSettings()" aria-label="إعادة تعيين الإعدادات" title="إعادة تعيين كل الإعدادات">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
            افتراضي
            </button>
            <button type="button" class="qs-close" onclick="closeQuickSettings()" aria-label="إغلاق">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        </div>
        <div class="qs-panel-body">
        <div class="qs-row"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>المظهر</div><div class="qs-tpill"><button type="button" class="qs-tpill-btn active" id="theme-dark-btn" onclick="setThemePref('dark')">🌙 داكن</button><button type="button" class="qs-tpill-btn" id="theme-light-btn" onclick="setThemePref('light')">☀️ فاتح</button></div></div>
        <div class="qs-row qs-span2"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12"/></svg>حجم الخط</div><div class="qs-tpill"><button type="button" class="qs-tpill-btn active" id="fs-normal-btn" onclick="setFontSize('normal')">١٥</button><button type="button" class="qs-tpill-btn" id="fs-large-btn" onclick="setFontSize('large')">١٧</button><button type="button" class="qs-tpill-btn" id="fs-xl-btn" onclick="setFontSize('xl')">٢٠</button><button type="button" class="qs-tpill-btn" id="fs-xxl-btn" onclick="setFontSize('xxl')">٢٢</button></div></div>
        <div class="qs-row qs-span2"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/></svg>لون اللوحة</div><div class="qs-color-opts"><button type="button" class="qs-color-btn qs-swatch-default" id="panel-color-default-btn" onclick="setPanelColor('default')" title="افتراضي"></button><button type="button" class="qs-color-btn qs-swatch-plum" id="panel-color-plum-btn" onclick="setPanelColor('plum')" title="برقوقي"></button><button type="button" class="qs-color-btn qs-swatch-slate" id="panel-color-slate-btn" onclick="setPanelColor('slate')" title="أردوازي"></button><button type="button" class="qs-color-btn qs-swatch-navy" id="panel-color-navy-btn" onclick="setPanelColor('navy')" title="نيلي"></button><button type="button" class="qs-color-btn qs-swatch-forest" id="panel-color-forest-btn" onclick="setPanelColor('forest')" title="غابي"></button><button type="button" class="qs-color-btn qs-swatch-stone" id="panel-color-stone-btn" onclick="setPanelColor('stone')" title="حجري"></button><button type="button" class="qs-color-btn qs-swatch-rose" id="panel-color-rose-btn" onclick="setPanelColor('rose')" title="وردي"></button><button type="button" class="qs-color-btn qs-swatch-teal" id="panel-color-teal-btn" onclick="setPanelColor('teal')" title="فيروزي"></button><button type="button" class="qs-color-btn qs-swatch-gold-panel" id="panel-color-gold-btn" onclick="setPanelColor('gold')" title="ذهبي"></button></div></div>
        <div class="qs-row qs-span2" hidden><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0"/></svg>العملة</div><div class="qs-tpill"><button type="button" class="qs-tpill-btn active" id="cur-usd-btn" onclick="setCurrency('USD')">$ دولار</button><button type="button" class="qs-tpill-btn" id="cur-lbp-btn" onclick="setCurrency('LBP')" hidden>ليرة سورية</button><button type="button" class="qs-tpill-btn" id="cur-aed-btn" onclick="setCurrency('AED')" hidden>درهم إماراتي</button></div></div>
        <div class="qs-row"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>المساحة</div><div class="qs-tpill"><button type="button" class="qs-tpill-btn active" id="area-m2-btn" onclick="setArea('m2')">م² متر</button><button type="button" class="qs-tpill-btn" id="area-ft2-btn" onclick="setArea('ft2')">قدم²</button></div></div>
        <div class="qs-row"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375"/></svg>معيار التملك</div><div class="qs-tpill"><button type="button" class="qs-tpill-btn active" id="own-sahm-btn" onclick="setOwnership('sahm')">سهم / 2400</button><button type="button" class="qs-tpill-btn" id="own-pct-btn" onclick="setOwnership('pct')">نسبة %</button></div></div>
        <div class="qs-row qs-span2"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12"/></svg>نوع الخط</div>
            <div class="qs-font-opts">
            <label class="qs-font-opt"><input type="radio" name="fontFamily" value="Tajawal" checked><span class="qs-font-radio"></span><span class="qs-font-text"><span class="qs-font-lbl" style="font-family:'Tajawal',sans-serif">Tajawal</span><span class="qs-font-sub">Tajawal</span></span></label>
            <label class="qs-font-opt"><input type="radio" name="fontFamily" value="Cairo"><span class="qs-font-radio"></span><span class="qs-font-text"><span class="qs-font-lbl" style="font-family:'Cairo',sans-serif">القاهرة</span><span class="qs-font-sub">Cairo</span></span></label>
            <label class="qs-font-opt"><input type="radio" name="fontFamily" value="Amiri"><span class="qs-font-radio"></span><span class="qs-font-text"><span class="qs-font-lbl" style="font-family:'Amiri',serif">أميري</span><span class="qs-font-sub">Amiri</span></span></label>
            </div>
        </div>
        <div class="qs-row qs-span2"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3"/></svg>لون الخط</div><div class="qs-color-opts"><button type="button" class="qs-color-btn qs-swatch-fc-default" id="font-color-default-btn" onclick="setFontColor('default')" title="افتراضي"></button><button type="button" class="qs-color-btn qs-swatch-fc-ivory" id="font-color-ivory-btn" onclick="setFontColor('ivory')" title="عاجي"></button><button type="button" class="qs-color-btn qs-swatch-fc-gold" id="font-color-gold-btn" onclick="setFontColor('gold')" title="ذهبي"></button><button type="button" class="qs-color-btn qs-swatch-fc-silver" id="font-color-silver-btn" onclick="setFontColor('silver')" title="فضي"></button><button type="button" class="qs-color-btn qs-swatch-fc-mint" id="font-color-mint-btn" onclick="setFontColor('mint')" title="نعناعي"></button><button type="button" class="qs-color-btn qs-swatch-fc-rose" id="font-color-rose-btn" onclick="setFontColor('rose')" title="وردي"></button></div></div>
        <div class="qs-row qs-span2"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5h18M3 12h18M3 16.5h18"/></svg>لون شريط التنقل</div><div class="qs-color-opts"><button type="button" class="qs-color-btn qs-swatch-default" id="nav-color-default-btn" onclick="setNavbarColor('default')" title="افتراضي"></button><button type="button" class="qs-color-btn qs-swatch-obsidian" id="nav-color-obsidian-btn" onclick="setNavbarColor('obsidian')" title="أوبسيديان"></button><button type="button" class="qs-color-btn qs-swatch-sand" id="nav-color-sand-btn" onclick="setNavbarColor('sand')" title="رملي"></button><button type="button" class="qs-color-btn qs-swatch-emerald" id="nav-color-emerald-btn" onclick="setNavbarColor('emerald')" title="زمردي"></button><button type="button" class="qs-color-btn qs-swatch-royal" id="nav-color-royal-btn" onclick="setNavbarColor('royal')" title="ملكي"></button><button type="button" class="qs-color-btn qs-swatch-burgundy" id="nav-color-burgundy-btn" onclick="setNavbarColor('burgundy')" title="خمري"></button></div></div>
        <div class="qs-row qs-span2"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5.25h18M3 12h18M3 18.75h18"/></svg>لون رأس الصفحة</div><div class="qs-color-opts"><button type="button" class="qs-color-btn qs-swatch-default" id="header-color-default-btn" onclick="setHeaderColor('default')" title="افتراضي"></button><button type="button" class="qs-color-btn qs-swatch-obsidian" id="header-color-obsidian-btn" onclick="setHeaderColor('obsidian')" title="أوبسيديان"></button><button type="button" class="qs-color-btn qs-swatch-sand" id="header-color-sand-btn" onclick="setHeaderColor('sand')" title="رملي"></button><button type="button" class="qs-color-btn qs-swatch-emerald" id="header-color-emerald-btn" onclick="setHeaderColor('emerald')" title="زمردي"></button><button type="button" class="qs-color-btn qs-swatch-royal" id="header-color-royal-btn" onclick="setHeaderColor('royal')" title="ملكي"></button><button type="button" class="qs-color-btn qs-swatch-burgundy" id="header-color-burgundy-btn" onclick="setHeaderColor('burgundy')" title="خمري"></button></div></div>
        <div class="qs-row qs-span2"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6.75h15m-15 5.25h15m-15 5.25h15"/></svg>لون الجداول</div><div class="qs-color-opts"><button type="button" class="qs-color-btn qs-swatch-default" id="table-color-default-btn" onclick="setTableColor('default')" title="افتراضي"></button><button type="button" class="qs-color-btn qs-swatch-obsidian" id="table-color-obsidian-btn" onclick="setTableColor('obsidian')" title="أوبسيديان"></button><button type="button" class="qs-color-btn qs-swatch-sand" id="table-color-sand-btn" onclick="setTableColor('sand')" title="رملي"></button><button type="button" class="qs-color-btn qs-swatch-emerald" id="table-color-emerald-btn" onclick="setTableColor('emerald')" title="زمردي"></button><button type="button" class="qs-color-btn qs-swatch-royal" id="table-color-royal-btn" onclick="setTableColor('royal')" title="ملكي"></button><button type="button" class="qs-color-btn qs-swatch-burgundy" id="table-color-burgundy-btn" onclick="setTableColor('burgundy')" title="خمري"></button></div></div>
        <div class="qs-row qs-span2"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3"/></svg>اللغة</div>
            <div class="qs-tpill" style="max-width:260px"><button type="button" class="qs-tpill-btn active" id="lang-ar-btn" onclick="setLang('ar')">🇸🇦 العربية</button><button type="button" class="qs-tpill-btn" id="lang-en-btn" onclick="setLang('en')">🇬🇧 English</button></div>
            <div class="qs-note">* تغيير اللغة يطبق اتجاه الصفحة فوراً؛ ترجمة النصوص تُكمّل لاحقاً.</div>
        </div>
        <div class="qs-row qs-span2"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4.098 19.902a3.75 3.75 0 005.304 0l6.401-6.402M6.75 21A3.75 3.75 0 013 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 003.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88"/></svg>الثيم</div><div class="qs-tpill"><button type="button" class="qs-tpill-btn qs-tpill-disabled" disabled title="قريباً">قريباً ✦</button></div></div>
        </div>
    </div>
    <button type="button" class="qs-fab-trigger" id="qs-fab-trigger" aria-expanded="false" aria-label="الإعدادات السريعة" onclick="event.stopPropagation(); toggleQuickSettings();">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.65"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    </button>
    </div>

    <div class="app-wrapper">

    <!-- ═══ SIDEBAR ═══ -->
    <aside class="sidebar">
        <div class="sidebar-logo">
        <div class="logo-title-row">
            <div class="logo-title">عقارات</div>
            <button class="sidebar-toggle-top" type="button" aria-label="تصغير الشريط الجانبي" onclick="toggleSidebar()">
            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4l-6 6 6 6"/>
            </svg>
            </button>
        </div>
        <div class="logo-sub">نظام إدارة الحصص العقارية</div>
        </div>

        <nav class="sidebar-nav">
        <button class="sidebar-toggle sidebar-toggle-inside" type="button" aria-label="تبديل القائمة الجانبية" onclick="toggleSidebar()">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
            <path d="M4 7h16M4 12h16M4 17h16"/>
            </svg>
            <span class="nav-text"></span>
        </button>

        <div class="nav-group">
            <button type="button" class="nav-item" data-nav-page="reports-home" onclick="goToPage('reports-home')">
            <svg class="nav-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M3 2h12v14H3z" rx="1"/>
                <path d="M5 6h8M5 9h6M5 12h8"/>
            </svg>
            <span class="nav-text">التقارير</span>
            </button>
            <div class="nav-submenu" role="group" aria-label="قوائم التقارير">
            <button type="button" class="nav-subitem" data-nav-leaf="owners" onclick="event.stopPropagation(); goToPage('owners')" title="تقرير المالك">
                <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="6" r="2.5"/><path d="M4 16v-1c0-2 2.5-3.5 5-3.5s5 1.5 5 3.5v1"/></svg>
                تقرير المالك
            </button>
            <button type="button" class="nav-subitem" data-nav-leaf="properties" onclick="event.stopPropagation(); goToPage('properties')" title="تقرير عقارات">
                <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 16V7l7-5 7 5v9"/><rect x="6" y="10" width="3" height="6"/><rect x="9" y="10" width="3" height="6"/></svg>
                تقرير العقارات
            </button>
            <button type="button" class="nav-subitem" data-nav-leaf="consultations" onclick="event.stopPropagation(); goToPage('consultations')" title="تقرير الإشارات">
                <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 2L3 7v9h12V7L9 2z"/><path d="M9 10v4"/></svg>
                تقرير الإشارات
            </button>
            <button type="button" class="nav-subitem" data-nav-leaf="attachments" onclick="event.stopPropagation(); goToPage('attachments')" title="تقرير الملحقات">
                <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h10v10H4z"/><path d="M7 7h4M7 10h4M7 13h3"/></svg>
                تقرير الملحقات
            </button>
            </div>
        </div>

        <div class="nav-group">
            <button type="button" class="nav-item active" data-nav-page="stats-home" onclick="goToPage('stats-home')">
            <svg class="nav-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M2 14V4h4v10H2zM7 14V8h4v6H7zM12 14V2h4v12h-4z"/>
            </svg>
            <span class="nav-text">الإحصاءات</span>
            </button>
            <div class="nav-submenu" role="group" aria-label="أقسام الإحصاءات">
            <button type="button" class="nav-subitem" data-stats-filter="financial" onclick="event.stopPropagation(); goToPage('dashboard', { stats: 'financial' })" title="إحصاءات مالية">
                <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 6h12M3 10h12M6 14h6"/><circle cx="12" cy="6" r="1.2" fill="currentColor"/></svg>
                مالية
            </button>
            <button type="button" class="nav-subitem" data-stats-filter="administrative" onclick="event.stopPropagation(); goToPage('dashboard', { stats: 'administrative' })" title="إحصاءات إدارية">
                <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="12" height="12" rx="2"/><path d="M6 7h6M6 10h4"/><circle cx="12" cy="5" r="1" fill="currentColor"/></svg>
                إدارية
            </button>
            <button type="button" class="nav-subitem" data-stats-filter="general" onclick="event.stopPropagation(); goToPage('dashboard', { stats: 'general' })" title="إحصاءات عامة">
                <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="9" r="6.5"/><path d="M9 5v4l3 2"/></svg>
                عامة
            </button>
            <button type="button" class="nav-subitem" data-nav-leaf="stats-generator" onclick="event.stopPropagation(); goToPage('stats-generator')" title="مولد الاحصاءات">
                <svg class="nav-subicon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 14V8h3v6H3zm4 0V4h3v10H7zm4 0V10h3v4h-3z"/><path d="M2 16h14"/></svg>
                مولد الاحصاءات
            </button>
            </div>
        </div>

        <button type="button" class="nav-item" data-nav-page="activity" onclick="goToPage('activity')">
            <svg class="nav-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M9 4v5l3 2"/>
            <circle cx="9" cy="9" r="7"/>
            </svg>
            <span class="nav-text">تقرير التتبع</span>
        </button>
        </nav>

        <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">خ</div>
            <div>
            <div class="user-name">مستخدم </div>
            <div class="user-role">مستثمر رئيسي</div>
            </div>
            <div class="notif-dot" style="margin-right:auto"></div>
        </div>
        </div>
    </aside>
    <div class="sidebar-overlay" onclick="closeSidebarForMobile()"></div>

    <!-- ═══ MAIN ═══ -->
    <div class="main-content">

        <!-- TOP BAR -->
        <header class="topbar">
        <!-- Desktop: just title on the right -->
        <div class="topbar-title topbar-title-desktop" id="topbar-title">بوابة <span>الإحصاءات</span></div>

        <!-- Mobile nav pills: replace sidebar on phones/tablets -->
        <nav class="topbar-mobile-nav" aria-label="تنقل رئيسي">
            <button type="button" class="topbar-nav-pill" id="mnav-properties" data-nav-page="reports-home"
            onclick="goToPage('reports-home')">
            <svg width="14" height="14" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M3 2h12v14H3z"/><path d="M5 6h8M5 9h6M5 12h8"/>
            </svg>
            <span class="pill-label">التقارير</span>
            </button>
            <button type="button" class="topbar-nav-pill active" id="mnav-dashboard" data-nav-page="stats-home"
            onclick="goToPage('stats-home')">
            <svg width="14" height="14" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M2 14V4h4v10H2zM7 14V8h4v6H7zM12 14V2h4v12h-4z"/>
            </svg>
            <span class="pill-label">الإحصاءات</span>
            </button>
            <button type="button" class="topbar-nav-pill" id="mnav-activity" data-nav-page="activity"
            onclick="goToPage('activity')">
            <svg width="14" height="14" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M9 4v5l3 2"/><circle cx="9" cy="9" r="7"/>
            </svg>
            <span class="pill-label">تتبع</span>
            </button>
        </nav>

        <div class="topbar-actions">
            <span class="app-version-badge" aria-label="Application version">v0.2.1</span>
            <div class="topbar-date topbar-datetime" id="topbar-datetime">
            <span id="topbar-time">--:--:--</span>
            <span class="topbar-datetime-sep">•</span>
            <span id="topbar-date">جارٍ التحميل…</span>
            </div>
            <button type="button" class="topbar-btn topbar-btn-props" id="topbar-hub-shortcut" onclick="goToPage('reports-home')" title="الانتقال إلى قسم التقارير">⊞ إلى التقارير</button>
            <button class="topbar-btn logout" onclick="handleLogout()">⎋ تسجيل الخروج</button>
        </div>
        </header>

        <!-- Mobile navigation: only visible on small screens -->
        <nav class="mobile-nav" id="mobile-nav" aria-label="تنقل سريع">
        <button type="button" id="mobile-nav-properties" class="mobile-nav-btn nav-item" data-nav-page="reports-home" onclick="goToPage('reports-home')">التقارير</button>
        <button type="button" id="mobile-nav-dashboard" class="mobile-nav-btn nav-item active" data-nav-page="stats-home" onclick="goToPage('stats-home')">الإحصاءات</button>
        <button type="button" id="mobile-nav-activity" class="mobile-nav-btn nav-item" data-nav-page="activity" onclick="goToPage('activity')">تقرير تتبع</button>
        </nav>

        <!-- ══════════════════════
            PAGE 0: STATS HUB
        ══════════════════════ -->
        <div class="page active" id="page-stats-home">
        <div style="max-width: 1400px; margin: 0 auto;">
            <div class="page-header">
            <div class="page-header-row">
                <div>
                <div class="page-eyebrow">مدخل الإحصاءات</div>
                <div class="page-title">بوابة <em>الإحصاءات</em></div>
                <div class="page-subtitle">اختر نوع الإحصاءات لعرض المؤشرات والرسوم حسب الفئة المطلوبة</div>
                </div>
            </div>
            </div>

            <div class="nav-hub-grid">
            <div class="nav-hub-card">
                <div class="nav-hub-media">
                <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=1200&q=80" alt="صورة الإحصاءات المالية">
                <span class="nav-hub-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v10M9 9.5c0-1.4 1.2-2.5 3-2.5s3 1 3 2.2-1 1.9-2.8 2.3c-1.8.4-3.2 1.1-3.2 2.6 0 1.4 1.3 2.4 3 2.4s3-.9 3-2.4"/></svg>
                </span>
                </div>
                <span class="nav-hub-chip">Finance</span>
                <div class="nav-hub-card-title">إحصاءات مالية</div>
                <div class="nav-hub-card-desc">تحليل المبالغ والمدفوعات والمتبقي والأداء المالي للعقارات.</div>
                <button type="button" class="toolbar-main-btn" onclick="goToPage('dashboard', { stats: 'financial' })">عرض الآن</button>
            </div>
            <div class="nav-hub-card">
                <div class="nav-hub-media">
                <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1200&q=80" alt="صورة الإحصاءات الإدارية">
                <span class="nav-hub-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 4v16M5 8h14"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M8 12h8M8 15h5"/></svg>
                </span>
                </div>
                <span class="nav-hub-chip">Admin</span>
                <div class="nav-hub-card-title">إحصاءات إدارية</div>
                <div class="nav-hub-card-desc">لوحات المتابعة الإدارية، الطلبات القانونية، وسير المعاملات.</div>
                <button type="button" class="toolbar-main-btn" onclick="goToPage('dashboard', { stats: 'administrative' })">عرض الآن</button>
            </div>
            <div class="nav-hub-card">
                <div class="nav-hub-media">
                <img src="https://images.unsplash.com/photo-1460472178825-e5240623afd5?auto=format&fit=crop&w=1200&q=80" alt="صورة الإحصاءات العامة">
                <span class="nav-hub-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 18h16M7 14l3-3 3 2 4-5"/><circle cx="7" cy="14" r="1"/><circle cx="10" cy="11" r="1"/><circle cx="13" cy="13" r="1"/><circle cx="17" cy="8" r="1"/></svg>
                </span>
                </div>
                <span class="nav-hub-chip">Overview</span>
                <div class="nav-hub-card-title">إحصاءات عامة</div>
                <div class="nav-hub-card-desc">نظرة عامة على المحفظة، المؤشرات الجامعة، والاتجاهات الكلية.</div>
                <button type="button" class="toolbar-main-btn" onclick="goToPage('dashboard', { stats: 'general' })">عرض الآن</button>
            </div>
            <div class="nav-hub-card">
                <div class="nav-hub-media">
                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80" alt="صورة مولد الاحصاءات">
                <span class="nav-hub-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19V9h4v10H4zm6 0V5h4v14h-4zm6 0v-7h4v7h-4z"/><path d="M3 21h18"/></svg>
                </span>
                </div>
                <span class="nav-hub-chip">Generator</span>
                <div class="nav-hub-card-title">مولد الاحصاءات</div>
                <div class="nav-hub-card-desc">اختَر بيانات الصفوف المحددة من الجداول وحوّلها إلى مخطط بياني (٣ أنواع) مع إمكانية إنشاء عدة مخططات.</div>
                <button type="button" class="toolbar-main-btn" onclick="goToPage('stats-generator')">فتح المولد</button>
            </div>
            </div>
        </div>
        </div>

        <div class="page" id="page-stats-generator">
        <div style="max-width: 1400px; margin: 0 auto;">
            <div class="page-header">
            <div class="page-header-row">
                <div>
                <div class="page-eyebrow">قسم الإحصاءات</div>
                <div class="page-title">مولد <em>الاحصاءات</em></div>
                <div class="page-subtitle">يبني مخططات من البيانات المحددة في الجداول. يمكنك إنشاء أكثر من مخطط ثم إعادة التعيين بالكامل.</div>
                </div>
            </div>
            </div>
            <div class="stats-generator-panel">
            <div class="stats-generator-form">
                <label>
                <span class="filter-label">مصدر البيانات</span>
                <select class="search-input" id="stats-gen-source" onchange="statsGeneratorPopulateFields()">
                    <option value="properties">تقرير العقارات</option>
                    <option value="owners">تقرير المالك</option>
                    <option value="consultations">تقرير الإشارات</option>
                    <option value="attachments">تقرير الملحقات</option>
                </select>
                </label>
                <label>
                <span class="filter-label">نوع المخطط</span>
                <select class="search-input" id="stats-gen-type">
                    <option value="bar">أعمدة</option>
                    <option value="line">خطي</option>
                    <option value="pie">دائري</option>
                </select>
                </label>
                <label>
                <span class="filter-label">محور/تصنيف (X)</span>
                <select class="search-input" id="stats-gen-label-field"></select>
                </label>
                <label>
                <span class="filter-label">القيمة (Y)</span>
                <select class="search-input" id="stats-gen-value-field"></select>
                </label>
            </div>
            <div class="stats-generator-actions">
                <button type="button" class="toolbar-main-btn" onclick="createStatsGeneratedChart()">إنشاء مخطط</button>
                <button type="button" class="toolbar-btn toolbar-btn-outline" onclick="resetStatsGenerator()">إعادة تعيين الكل</button>
            </div>
            <div class="stats-generator-status" id="stats-gen-status">اختر الجدول ونوع المخطط ثم اضغط "إنشاء مخطط".</div>
            </div>
            <div class="stats-generated-grid" id="stats-generator-charts"></div>
        </div>
        </div>

        <!-- ══════════════════════
            PAGE 0.1: REPORTS HUB
        ══════════════════════ -->
        <div class="page" id="page-reports-home">
        <div style="max-width: 1400px; margin: 0 auto;">
            <div class="page-header">
            <div class="page-header-row">
                <div>
                <div class="page-eyebrow">مدخل التقارير</div>
                <div class="page-title">بوابة <em>التقارير</em></div>
                <div class="page-subtitle">صفحة رئيسية تجمع جميع التقارير التفصيلية للوصول السريع.</div>
                </div>
            </div>
            </div>

            <div class="nav-hub-grid">
            <div class="nav-hub-card">
                <div class="nav-hub-media">
                <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1200&q=80" alt="صورة تقرير العقارات">
                <span class="nav-hub-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 10l9-6 9 6v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V10z"/><path d="M9 21v-7h6v7"/></svg>
                </span>
                </div>
                <span class="nav-hub-chip">Properties</span>
                <div class="nav-hub-card-title">تقرير العقارات</div>
                <div class="nav-hub-card-desc">سجل العقارات الكامل مع البحث والفلترة ومولد التقارير والتصدير.</div>
                <button type="button" class="toolbar-main-btn" onclick="goToPage('properties')">فتح التقرير</button>
            </div>
            <div class="nav-hub-card">
                <div class="nav-hub-media">
                <img src="https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1200&q=80" alt="صورة تقرير المالك">
                <span class="nav-hub-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 20c1.8-3.5 5-5 8-5s6.2 1.5 8 5"/></svg>
                </span>
                </div>
                <span class="nav-hub-chip">Owners</span>
                <div class="nav-hub-card-title">تقرير المالك</div>
                <div class="nav-hub-card-desc">عرض بيانات المالكين والتفاصيل المرتبطة بالعقارات والإشارات.</div>
                <button type="button" class="toolbar-main-btn" onclick="goToPage('owners')">فتح التقرير</button>
            </div>
            <div class="nav-hub-card">
                <div class="nav-hub-media">
                <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=1200&q=80" alt="صورة تقرير الإشارات">
                <span class="nav-hub-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 4h10l4 4v12H5z"/><path d="M15 4v4h4M8 13h8M8 17h6"/></svg>
                </span>
                </div>
                <span class="nav-hub-chip">Signals</span>
                <div class="nav-hub-card-title">تقرير الإشارات</div>
                <div class="nav-hub-card-desc">متابعة الإشارات، العقود، الجهات المرتبطة، وتواريخ الإدخال.</div>
                <button type="button" class="toolbar-main-btn" onclick="goToPage('consultations')">فتح التقرير</button>
            </div>
            <div class="nav-hub-card">
                <div class="nav-hub-media">
                <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80" alt="صورة تقرير الملحقات">
                <span class="nav-hub-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 14v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h4"/><path d="M14 4h6v6M20 4l-9 9"/></svg>
                </span>
                </div>
                <span class="nav-hub-chip">Attachments</span>
                <div class="nav-hub-card-title">تقرير الملحقات</div>
                <div class="nav-hub-card-desc">سجل الملحقات المرفوعة وتواريخها وخيارات التنزيل المرتبطة بها.</div>
                <button type="button" class="toolbar-main-btn" onclick="goToPage('attachments')">فتح التقرير</button>
            </div>
            </div>
            <div class="nav-hub-note">يمكنك استخدام القائمة الجانبية أيضاً للتنقل السريع بين نفس الأقسام.</div>
        </div>
        </div>

        <!-- ══════════════════════
            PAGE 1: DASHBOARD
        ══════════════════════ -->
        <div class="page" id="page-dashboard">
        <div style="max-width: 1400px; margin: 0 auto;">

            <div class="page-header page-header-dashboard">
            <div>
                <div class="page-eyebrow">نظرة عامة على المحفظة</div>
                <div class="page-title">مرحباً، <em>مستخدم </em></div>
                <div class="page-subtitle">إجمالي محفظتك العقارية ومؤشرات الأداء الرئيسية</div>
            </div>
            <div class="page-hero-icon" aria-hidden="true" id="dashboard-hero">
                <img
                src="/vendor/viewer/assets/general-reports.gif"
                alt="صورة الإحصاءات العامة"
                />
            </div>
            </div>

            <!-- STAT CARDS -->
            <div class="stats-grid dashboard-block" data-stats-category="financial">
            <div class="stat-card gold-card">
                <div class="stat-bg-icon">
                <svg viewBox="0 0 64 64" width="64" height="64" aria-hidden="true">
                    <rect x="8" y="26" width="16" height="26" rx="2" fill="none" stroke="rgba(212,175,55,.4)" stroke-width="2"/>
                    <rect x="24" y="18" width="16" height="34" rx="2" fill="none" stroke="rgba(212,175,55,.25)" stroke-width="2"/>
                    <rect x="40" y="12" width="16" height="40" rx="2" fill="none" stroke="rgba(212,175,55,.2)" stroke-width="2"/>
                </svg>
                </div>
                <div class="stat-label">
                إجمالي المبلغ
                <div class="stat-icon">
                    <svg viewBox="0 0 20 20" width="16" height="16" aria-hidden="true">
                    <path d="M3 11h14M5 5h10M7 15h6" fill="none" stroke="var(--gold-bright)" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                </div>
                </div>
                <div class="stat-value" id="stat-total-value">65.00 $</div>
                <div class="stat-sub">إجمالي قيمة المحفظة العقارية</div>
                <div class="stat-mini-graph">
                <svg viewBox="0 0 100 40">
                    <!-- grid -->
                    <defs>
                    <pattern id="miniGrid1" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(148,163,184,0.18)" stroke-width="0.4"/>
                    </pattern>
                    </defs>
                    <rect x="0" y="0" width="100" height="40" fill="url(#miniGrid1)" />
                    <!-- axis -->
                    <line x1="5" y1="5" x2="5" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                    <line x1="5" y1="35" x2="95" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                    <!-- line -->
                    <polyline
                    fill="none"
                    stroke="var(--gold-bright)"
                    stroke-width="1.6"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    points="8,30 28,18 48,22 68,14 88,10"/>
                    <!-- points -->
                    <circle cx="8" cy="30" r="1.8" fill="#0A0A0A" stroke="var(--gold-bright)" stroke-width="1"/>
                    <circle cx="28" cy="18" r="1.8" fill="#0A0A0A" stroke="var(--gold-bright)" stroke-width="1"/>
                    <circle cx="48" cy="22" r="1.8" fill="#0A0A0A" stroke="var(--gold-bright)" stroke-width="1"/>
                    <circle cx="68" cy="14" r="1.8" fill="#0A0A0A" stroke="var(--gold-bright)" stroke-width="1"/>
                    <circle cx="88" cy="10" r="1.8" fill="#0A0A0A" stroke="var(--gold-bright)" stroke-width="1"/>
                </svg>
                </div>
                <div class="stat-badge badge-up">↑ نمو ١٢٪ عن العام الماضي</div>
            </div>

            <div class="stat-card">
                <div class="stat-bg-icon">
                <svg viewBox="0 0 64 64" width="64" height="64" aria-hidden="true">
                    <path d="M10 26c0-8 6-14 18-14h8c12 0 18 6 18 14s-6 14-18 14h-4" fill="none" stroke="rgba(212,175,55,.35)" stroke-width="2" stroke-linecap="round"/>
                    <path d="M24 40c0 4 3 7 8 7s8-3 8-7-3-7-8-7" fill="none" stroke="rgba(212,175,55,.25)" stroke-width="2" stroke-linecap="round"/>
                </svg>
                </div>
                <div class="stat-label">
                إجمالي المدفوعات
                <div class="stat-icon">
                    <svg viewBox="0 0 20 20" width="16" height="16" aria-hidden="true">
                    <rect x="3" y="4" width="14" height="10" rx="2" fill="none" stroke="var(--gold-bright)" stroke-width="1.4"/>
                    <path d="M3 9h14" fill="none" stroke="var(--gold-bright)" stroke-width="1.2"/>
                    </svg>
                </div>
                </div>
                <div class="stat-value" id="stat-paid-value">48.70 $</div>
                <div class="stat-sub">إجمالي المدفوعات المستلمة حتى الآن</div>
                <div class="stat-mini-graph">
                <svg viewBox="0 0 100 40">
                    <defs>
                    <pattern id="miniGrid2" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(148,163,184,0.18)" stroke-width="0.4"/>
                    </pattern>
                    </defs>
                    <rect x="0" y="0" width="100" height="40" fill="url(#miniGrid2)" />
                    <line x1="5" y1="5" x2="5" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                    <line x1="5" y1="35" x2="95" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                    <polyline
                    fill="none"
                    stroke="var(--gold-mid)"
                    stroke-width="1.6"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    points="8,32 28,24 48,26 68,18 88,14"/>
                    <circle cx="8" cy="32" r="1.8" fill="#0A0A0A" stroke="var(--gold-mid)" stroke-width="1"/>
                    <circle cx="28" cy="24" r="1.8" fill="#0A0A0A" stroke="var(--gold-mid)" stroke-width="1"/>
                    <circle cx="48" cy="26" r="1.8" fill="#0A0A0A" stroke="var(--gold-mid)" stroke-width="1"/>
                    <circle cx="68" cy="18" r="1.8" fill="#0A0A0A" stroke="var(--gold-mid)" stroke-width="1"/>
                    <circle cx="88" cy="14" r="1.8" fill="#0A0A0A" stroke="var(--gold-mid)" stroke-width="1"/>
                </svg>
                </div>
                <div class="stat-badge badge-up">↑ ١٤.٢٪ منذ بداية العام</div>
            </div>

            <div class="stat-card">
                <div class="stat-bg-icon">
                <svg viewBox="0 0 64 64" width="64" height="64" aria-hidden="true">
                    <path d="M12 30l20-16 20 16v18a4 4 0 0 1-4 4H16a4 4 0 0 1-4-4V30z" fill="none" stroke="rgba(212,175,55,.35)" stroke-width="2" stroke-linejoin="round"/>
                    <rect x="26" y="32" width="12" height="16" rx="2" fill="none" stroke="rgba(212,175,55,.25)" stroke-width="2"/>
                </svg>
                </div>
                <div class="stat-label">
                إجمالي الباقي
                <div class="stat-icon">
                    <svg viewBox="0 0 20 20" width="16" height="16" aria-hidden="true">
                    <circle cx="8" cy="8" r="3" fill="none" stroke="var(--gold-bright)" stroke-width="1.4"/>
                    <path d="M11 9l3 3m0-2.5l1.5 1.5" fill="none" stroke="var(--gold-bright)" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                </div>
                </div>
                <div class="stat-value" id="stat-remaining-value">16.30 $</div>
                <div class="stat-sub">المبالغ المتبقية على المستثمرين</div>
                <div class="stat-mini-graph">
                <svg viewBox="0 0 100 40">
                    <defs>
                    <pattern id="miniGrid3" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(148,163,184,0.18)" stroke-width="0.4"/>
                    </pattern>
                    </defs>
                    <rect x="0" y="0" width="100" height="40" fill="url(#miniGrid3)" />
                    <line x1="5" y1="5" x2="5" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                    <line x1="5" y1="35" x2="95" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                    <polyline
                    fill="none"
                    stroke="#f87171"
                    stroke-width="1.6"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    points="8,10 28,14 48,18 68,24 88,28"/>
                    <circle cx="8" cy="10" r="1.8" fill="#0A0A0A" stroke="#f87171" stroke-width="1"/>
                    <circle cx="28" cy="14" r="1.8" fill="#0A0A0A" stroke="#f87171" stroke-width="1"/>
                    <circle cx="48" cy="18" r="1.8" fill="#0A0A0A" stroke="#f87171" stroke-width="1"/>
                    <circle cx="68" cy="24" r="1.8" fill="#0A0A0A" stroke="#f87171" stroke-width="1"/>
                    <circle cx="88" cy="28" r="1.8" fill="#0A0A0A" stroke="#f87171" stroke-width="1"/>
                </svg>
                </div>
                <div class="stat-badge badge-neutral">● تحت المتابعة والتحصيل</div>
            </div>

            <div class="stat-card">
                <div class="stat-bg-icon">
                <svg viewBox="0 0 64 64" width="64" height="64" aria-hidden="true">
                    <path d="M12 44h40" fill="none" stroke="rgba(212,175,55,.3)" stroke-width="2" stroke-linecap="round"/>
                    <path d="M16 40l6-10 8 6 10-14 8 12" fill="none" stroke="rgba(212,175,55,.45)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="22" cy="30" r="2" fill="rgba(212,175,55,.5)"/>
                    <circle cx="30" cy="36" r="2" fill="rgba(212,175,55,.5)"/>
                    <circle cx="40" cy="22" r="2" fill="rgba(212,175,55,.5)"/>
                    <circle cx="48" cy="34" r="2" fill="rgba(212,175,55,.5)"/>
                </svg>
                </div>
                <div class="stat-label">
                إجمالي الأسهم
                <div class="stat-icon">
                    <svg viewBox="0 0 20 20" width="16" height="16" aria-hidden="true">
                    <path d="M6 5a3 3 0 0 1 3-3m2 3a3 3 0 0 1-3 3m5 5a3 3 0 0 1-3 3m-2-3a3 3 0 0 1 3-3M6 5l8 10" fill="none" stroke="var(--gold-bright)" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                </div>
                </div>
                <div class="stat-value">3,420<small>سهم</small></div>
                <div class="stat-sub">إجمالي عدد الأسهم في جميع العقارات</div>
                <div class="stat-mini-graph">
                <svg viewBox="0 0 100 40">
                    <defs>
                    <pattern id="miniGrid4" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(148,163,184,0.18)" stroke-width="0.4"/>
                    </pattern>
                    </defs>
                    <rect x="0" y="0" width="100" height="40" fill="url(#miniGrid4)" />
                    <line x1="5" y1="5" x2="5" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                    <line x1="5" y1="35" x2="95" y2="35" stroke="rgba(148,163,184,0.6)" stroke-width="0.8"/>
                    <polyline
                    fill="none"
                    stroke="var(--gold-light)"
                    stroke-width="1.6"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    points="8,26 28,24 48,20 68,16 88,12"/>
                    <circle cx="8" cy="26" r="1.8" fill="#0A0A0A" stroke="var(--gold-light)" stroke-width="1"/>
                    <circle cx="28" cy="24" r="1.8" fill="#0A0A0A" stroke="var(--gold-light)" stroke-width="1"/>
                    <circle cx="48" cy="20" r="1.8" fill="#0A0A0A" stroke="var(--gold-light)" stroke-width="1"/>
                    <circle cx="68" cy="16" r="1.8" fill="#0A0A0A" stroke="var(--gold-light)" stroke-width="1"/>
                    <circle cx="88" cy="12" r="1.8" fill="#0A0A0A" stroke="var(--gold-light)" stroke-width="1"/>
                </svg>
                </div>
                <div class="stat-badge badge-up">↑ إضافة أسهم جديدة هذا العام</div>
            </div>
            </div>

            <div class="ornament">
            <div class="ornament-line"></div>
            <div class="ornament-dot"></div>
            <div class="ornament-diamond"></div>
            <div class="ornament-dot"></div>
            <div class="ornament-line rev"></div>
            </div>

            <!-- ═══ الإحصاءات المالية الجديدة ═══ -->
            <div class="legal-charts-row">
            <div class="chart-card dashboard-block" data-stats-category="financial" data-chart-wrap="fin1">
                <div class="chart-header">
                <div>
                    <div class="chart-title">قيمة العقارات المملوكة حسب النوع</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="bar" onclick="switchDynChart('fin1','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('fin1','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                </div>
                </div>
                <div id="fin1" class="dyn-chart-root"></div>
            </div>

            <div class="chart-card dashboard-block" data-stats-category="financial" data-chart-wrap="fin2">
                <div class="chart-header">
                <div>
                    <div class="chart-title">الدفعات الكاملة حسب نوع العقار</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="bar" onclick="switchDynChart('fin2','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('fin2','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                </div>
                </div>
                <div id="fin2" class="dyn-chart-root"></div>
            </div>
            </div>
            <div class="legal-charts-row">
            <div class="chart-card dashboard-block" data-stats-category="financial" data-chart-wrap="fin3">
                <div class="chart-header">
                <div>
                    <div class="chart-title">الدفعات الجزئية حسب نوع العقار</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="bar" onclick="switchDynChart('fin3','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('fin3','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                </div>
                </div>
                <div id="fin3" class="dyn-chart-root"></div>
            </div>

            <div class="chart-card dashboard-block" data-stats-category="financial" data-chart-wrap="fin4">
                <div class="chart-header">
                <div>
                    <div class="chart-title">إجمالي المبلغ المدفوع لجميع العقارات المملوكة</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="bar" onclick="switchDynChart('fin4','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('fin4','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                </div>
                </div>
                <div style="margin:8px 0 0;"><span class="fin-summary-badge" id="fin4-total">جارٍ الحساب…</span></div>
                <div id="fin4" class="dyn-chart-root"></div>
            </div>
            </div>
            <div class="legal-charts-row">
            <div class="chart-card dashboard-block" data-stats-category="financial" data-chart-wrap="fin5">
                <div class="chart-header">
                <div>
                    <div class="chart-title">إجمالي قيمة العقارات غير المملوكة</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="bar" onclick="switchDynChart('fin5','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('fin5','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                </div>
                </div>
                <div id="fin5" class="dyn-chart-root"></div>
            </div>

            <div class="chart-card dashboard-block" data-stats-category="financial" data-chart-wrap="fin6">
                <div class="chart-header">
                <div>
                    <div class="chart-title">الدفعات والمتبقي للعقارات غير المملوكة حسب النوع</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="bar" onclick="switchDynChart('fin6','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="stacked" onclick="switchDynChart('fin6','stacked')" title="مكدس"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="7" width="3.5" height="6" rx="1" fill="currentColor" opacity=".5"/><rect x="1" y="3" width="3.5" height="4" rx="1" fill="currentColor"/><rect x="5.25" y="9" width="3.5" height="4" rx="1" fill="currentColor" opacity=".5"/><rect x="5.25" y="5" width="3.5" height="4" rx="1" fill="currentColor"/><rect x="9.5" y="5" width="3.5" height="8" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('fin6','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                </div>
                </div>
                <div id="fin6" class="dyn-chart-root"></div>
            </div>
            </div>
            <div class="legal-charts-row">
            <div class="chart-card dashboard-block" data-stats-category="financial" data-chart-wrap="fin7">
                <div class="chart-header">
                <div>
                    <div class="chart-title">قيمة العقارات الفعلية غير المملوكة حسب النوع</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="bar" onclick="switchDynChart('fin7','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('fin7','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                </div>
                </div>
                <div id="fin7" class="dyn-chart-root"></div>
            </div>

            <div class="chart-card dashboard-block" data-stats-category="financial" data-chart-wrap="fin8">
                <div class="chart-header">
                <div>
                    <div class="chart-title">قيمة العقارات التقريبية غير المملوكة حسب النوع</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="bar" onclick="switchDynChart('fin8','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('fin8','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                </div>
                </div>
                <div id="fin8" class="dyn-chart-root"></div>
            </div>
            </div>
            <div class="legal-charts-row">
            <div class="chart-card dashboard-block" data-stats-category="financial" data-chart-wrap="fin9">
                <div class="chart-header">
                <div>
                    <div class="chart-title">أعلى العقارات من حيث المبلغ المتبقي</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="bar" onclick="switchDynChart('fin9','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="hbar" onclick="switchDynChart('fin9','hbar')" title="أفقي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="2" width="8" height="2.5" rx="1" fill="currentColor"/><rect x="1" y="5.75" width="11" height="2.5" rx="1" fill="currentColor" opacity=".7"/><rect x="1" y="9.5" width="5.5" height="2.5" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('fin9','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                </div>
                </div>
                <div id="fin9" class="dyn-chart-root"></div>
            </div>

            <div class="chart-card dashboard-block" data-stats-category="financial" data-chart-wrap="fin10">
                <div class="chart-header">
                <div>
                    <div class="chart-title">أعلى المناطق الجغرافية تكلفة</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="bar" onclick="switchDynChart('fin10','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="hbar" onclick="switchDynChart('fin10','hbar')" title="أفقي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="2" width="8" height="2.5" rx="1" fill="currentColor"/><rect x="1" y="5.75" width="11" height="2.5" rx="1" fill="currentColor" opacity=".7"/><rect x="1" y="9.5" width="5.5" height="2.5" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('fin10','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                </div>
                </div>
                <div id="fin10" class="dyn-chart-root"></div>
            </div>
            </div>
            <div class="legal-charts-row" style="grid-template-columns:1fr;">
            <div class="chart-card dashboard-block" data-stats-category="financial" data-chart-wrap="fin11">
                <div class="chart-header">
                <div>
                    <div class="chart-title">تطور المحفظة العقارية سنوياً</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="line" onclick="switchDynChart('fin11','line')" title="خطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><polyline points="1,11 4,6 7,8 10,3 13,5" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" stroke-linecap="round"/><circle cx="4" cy="6" r="1.3" fill="currentColor"/><circle cx="10" cy="3" r="1.3" fill="currentColor"/></svg></button>
                    <button class="ctt-btn" data-ctype="bar" onclick="switchDynChart('fin11','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                </div>
                </div>
                <div id="fin11" class="dyn-chart-root"></div>
            </div>
            </div>

            <!-- CHARTS ROW (احصاءات عامة) -->
            <div class="charts-row">

            <!-- Donut: share distribution -->
            <div class="chart-card dashboard-block" data-stats-category="general">
                <div class="chart-header">
                <div>
                    <div class="chart-title">توزيع المناطق العقارية</div>
                    <div class="chart-sub">حسب المناطق الأكثر استثماراً في المحفظة</div>
                </div>
                <div class="chart-badge">٦ مناطق رئيسية</div>
                </div>
                <div class="donut-wrap">
                <svg class="donut-svg" width="110" height="110" viewBox="0 0 110 110">
                    <circle cx="55" cy="55" r="40" fill="none" stroke="#1A1A1A" stroke-width="20"/>
                    <!-- Segments: total = 251.3 -->
                    <circle cx="55" cy="55" r="40" fill="none" stroke="#D4AF37" stroke-width="20"
                    stroke-dasharray="110.6 140.7" stroke-dashoffset="0"
                    transform="rotate(-90 55 55)"/>
                    <circle cx="55" cy="55" r="40" fill="none" stroke="#C49A2A" stroke-width="20"
                    stroke-dasharray="75.4 175.9" stroke-dashoffset="-110.6"
                    transform="rotate(-90 55 55)"/>
                    <circle cx="55" cy="55" r="40" fill="none" stroke="#8B6914" stroke-width="20"
                    stroke-dasharray="50.3 201" stroke-dashoffset="-186"
                    transform="rotate(-90 55 55)"/>
                    <circle cx="55" cy="55" r="40" fill="none" stroke="#3D3D3D" stroke-width="20"
                    stroke-dasharray="15 236.3" stroke-dashoffset="-236.3"
                    transform="rotate(-90 55 55)"/>
                    <text x="55" y="52" text-anchor="middle" font-family="Amiri" font-size="16" fill="#D4AF37" font-weight="700">6</text>
                    <text x="55" y="65" text-anchor="middle" font-family="Tajawal" font-size="9" fill="#6B6560">مناطق</text>
                </svg>
                <div class="donut-legend">
                    <div class="legend-item">
                    <div class="legend-dot" style="background:#D4AF37"></div>
                    الرياض
                    <span class="legend-pct">٣٥٪</span>
                    </div>
                    <div class="legend-item">
                    <div class="legend-dot" style="background:#C49A2A"></div>
                    جدة
                    <span class="legend-pct">٢٥٪</span>
                    </div>
                    <div class="legend-item">
                    <div class="legend-dot" style="background:#8B6914"></div>
                    الدمام
                    <span class="legend-pct">٢٠٪</span>
                    </div>
                    <div class="legend-item">
                    <div class="legend-dot" style="background:#3D3D3D"></div>
                    أبوظبي / دبي
                    <span class="legend-pct">٢٠٪</span>
                    </div>
                </div>
                </div>
            </div>

            <!-- Sparklines -->
            <div class="chart-card dashboard-block" data-stats-category="general">
                <div class="chart-header">
                <div>
                    <div class="chart-title">أبرز العقارات من حيث التكلفة</div>
                    <div class="chart-sub">أعلى المباني من حيث قيمة الاستثمار</div>
                </div>
                </div>
                <div class="sparkline-grid">
                <div class="spark-item">
                    <div class="spark-info">
                    <div class="spark-name">برج النخيل</div>
                    <div class="spark-val">٨.٤م دولار</div>
                    <div class="spark-chg up">↑ ٨.٢٪</div>
                    </div>
                    <svg class="spark-svg" width="70" height="32" viewBox="0 0 70 32">
                    <polyline points="0,28 12,22 24,18 36,14 48,10 60,6 70,4" fill="none" stroke="#D4AF37" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="spark-item">
                    <div class="spark-info">
                    <div class="spark-name">مجمع الواحة</div>
                    <div class="spark-val">٦.١م دولار</div>
                    <div class="spark-chg up">↑ ٥.١٪</div>
                    </div>
                    <svg class="spark-svg" width="70" height="32" viewBox="0 0 70 32">
                    <polyline points="0,26 12,22 24,24 36,18 48,14 60,12 70,8" fill="none" stroke="#C49A2A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="spark-item">
                    <div class="spark-info">
                    <div class="spark-name">أبراج المدينة</div>
                    <div class="spark-val">٥.٧م دولار</div>
                    <div class="spark-chg down">↓ ١.٣٪</div>
                    </div>
                    <svg class="spark-svg" width="70" height="32" viewBox="0 0 70 32">
                    <polyline points="0,8 12,10 24,9 36,14 48,18 60,20 70,24" fill="none" stroke="#f87171" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="spark-item">
                    <div class="spark-info">
                    <div class="spark-name">برج الفيصلية</div>
                    <div class="spark-val">٤.٢م دولار</div>
                    <div class="spark-chg up">↑ ١١.٦٪</div>
                    </div>
                    <svg class="spark-svg" width="70" height="32" viewBox="0 0 70 32">
                    <polyline points="0,30 12,26 24,20 36,16 48,10 60,6 70,2" fill="none" stroke="#4ade80" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                </div>
            </div>

            </div>

            <div class="general-kpi-grid dashboard-block" data-stats-category="general">
            <div class="legal-kpi">
                <div class="legal-kpi-label">عدد العقارات</div>
                <div class="legal-kpi-value" id="general-kpi-properties">0</div>
                <div class="legal-kpi-sub">إجمالي العقارات المسجلة</div>
            </div>
            <div class="legal-kpi">
                <div class="legal-kpi-label">العقارات المملوكة بالكامل</div>
                <div class="legal-kpi-value" id="general-kpi-full-owned">0</div>
                <div class="legal-kpi-sub">حصة 100% من العقار</div>
            </div>
            <div class="legal-kpi">
                <div class="legal-kpi-label">متوسط نسبة التملك</div>
                <div class="legal-kpi-value" id="general-kpi-avg-share">0%</div>
                <div class="legal-kpi-sub">لكل عقار في المحفظة</div>
            </div>
            </div>

            <div class="chart-card dashboard-block" data-stats-category="general">
            <div class="chart-header">
                <div>
                <div class="chart-title">حصة كل مالك</div>
                <div class="chart-sub">توزيع الإشارات حسب أصحاب الإشارة</div>
                </div>
                <div class="chart-badge">مالكون</div>
            </div>
            <div class="bar-chart" id="general-owner-share-chart" aria-label="حصة كل مالك"></div>
            <div class="legal-chart-note" id="general-owner-share-note"></div>
            </div>

            <!-- ═══ الإحصاءات الإدارية الجديدة ═══ -->
            <div class="legal-charts-row">
            <div class="chart-card dashboard-block" data-stats-category="administrative" data-chart-wrap="adm1">
                <div class="chart-header">
                <div>
                    <div class="chart-title">العقارات المملوكة حسب النوع والموقع</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="bar" onclick="switchDynChart('adm1','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('adm1','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                    <button type="button" class="ctt-btn" data-ctype="country" onclick="switchDynChart('adm1','country')" title="عرض التوزيع حسب الدولة / الموقع" aria-label="عرض التوزيع حسب الموقع">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s7-4.5 7-10a7 7 0 1 0-14 0c0 5.5 7 10 7 10z"/><circle cx="12" cy="11" r="2.5"/></svg>
                    </button>
                </div>
                </div>
                <div id="adm1" class="dyn-chart-root"></div>
            </div>

            <div class="chart-card dashboard-block" data-stats-category="administrative" data-chart-wrap="adm2">
                <div class="chart-header">
                <div>
                    <div class="chart-title">العقارات غير المملوكة حسب النوع والموقع</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="bar" onclick="switchDynChart('adm2','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('adm2','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                    <button type="button" class="ctt-btn" data-ctype="country" onclick="switchDynChart('adm2','country')" title="عرض التوزيع حسب المدينة / موقع العقار" aria-label="عرض التوزيع حسب الموقع">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s7-4.5 7-10a7 7 0 1 0-14 0c0 5.5 7 10 7 10z"/><circle cx="12" cy="11" r="2.5"/></svg>
                    </button>
                </div>
                </div>
                <div id="adm2" class="dyn-chart-root"></div>
            </div>
            </div>
            <div class="legal-charts-row">
            <div class="chart-card dashboard-block" data-stats-category="administrative" data-chart-wrap="adm3">
                <div class="chart-header">
                <div>
                    <div class="chart-title">عدد الإشارات لكل عقار</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="hbar" onclick="switchDynChart('adm3','hbar')" title="أفقي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="2" width="8" height="2.5" rx="1" fill="currentColor"/><rect x="1" y="5.75" width="11" height="2.5" rx="1" fill="currentColor" opacity=".7"/><rect x="1" y="9.5" width="5.5" height="2.5" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="bar" onclick="switchDynChart('adm3','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('adm3','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                </div>
                </div>
                <div id="adm3" class="dyn-chart-root"></div>
            </div>

            <div class="chart-card dashboard-block" data-stats-category="administrative" data-chart-wrap="adm4">
                <div class="chart-header">
                <div>
                    <div class="chart-title">عدد المدخلين في النظام</div>
                </div>
                <div class="ctt-row">
                    <button type="button" class="ctt-btn active" data-ctype="hbar" onclick="switchDynChart('adm4','hbar')" title="أفقي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="2" width="8" height="2.5" rx="1" fill="currentColor"/><rect x="1" y="5.75" width="11" height="2.5" rx="1" fill="currentColor" opacity=".7"/><rect x="1" y="9.5" width="5.5" height="2.5" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button type="button" class="ctt-btn" data-ctype="donut" onclick="switchDynChart('adm4','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                    <button type="button" class="ctt-btn" data-ctype="bar" onclick="switchDynChart('adm4','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                </div>
                </div>
                <div style="text-align:center;margin:10px 0 6px;"><span class="fin-summary-badge" id="adm4-count">—</span><span style="color:var(--text-muted);font-size:calc(11px * var(--fs-scale));margin-right:6px;">مدخل</span></div>
                <div id="adm4" class="dyn-chart-root"></div>
            </div>
            </div>
            <div class="legal-charts-row">
            <div class="chart-card dashboard-block" data-stats-category="administrative" data-chart-wrap="adm5">
                <div class="chart-header">
                <div>
                    <div class="chart-title">عدد المالكين</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="donut" onclick="switchDynChart('adm5','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                    <button class="ctt-btn" data-ctype="bar" onclick="switchDynChart('adm5','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                </div>
                </div>
                <div style="text-align:center;margin:10px 0 6px;"><span class="fin-summary-badge" id="adm5-count">—</span><span style="color:var(--text-muted);font-size:calc(11px * var(--fs-scale));margin-right:6px;">مالك</span></div>
                <div id="adm5" class="dyn-chart-root"></div>
            </div>

            <div class="chart-card dashboard-block" data-stats-category="administrative" data-chart-wrap="adm6">
                <div class="chart-header">
                <div>
                    <div class="chart-title">عدد الإشارات حسب النوع</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="bar" onclick="switchDynChart('adm6','bar')" title="شريطي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="5" width="3" height="8" rx="1" fill="currentColor" opacity=".7"/><rect x="5.5" y="2" width="3" height="11" rx="1" fill="currentColor"/><rect x="10" y="7" width="3" height="6" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('adm6','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                </div>
                </div>
                <div style="text-align:center;margin:10px 0 6px;"><span class="fin-summary-badge" id="adm6-count">—</span><span style="color:var(--text-muted);font-size:calc(11px * var(--fs-scale));margin-right:6px;">إشارة</span></div>
                <div id="adm6" class="dyn-chart-root"></div>
            </div>
            </div>
            <div class="legal-charts-row">
            <div class="chart-card dashboard-block" data-stats-category="administrative" data-chart-wrap="adm7">
                <div class="chart-header">
                <div>
                    <div class="chart-title">عدد الدعاوى حسب العقار</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="hbar" onclick="switchDynChart('adm7','hbar')" title="أفقي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="2" width="8" height="2.5" rx="1" fill="currentColor"/><rect x="1" y="5.75" width="11" height="2.5" rx="1" fill="currentColor" opacity=".7"/><rect x="1" y="9.5" width="5.5" height="2.5" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('adm7','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                </div>
                </div>
                <div style="text-align:center;margin:10px 0 6px;"><span class="fin-summary-badge" id="adm7-count">—</span><span style="color:var(--text-muted);font-size:calc(11px * var(--fs-scale));margin-right:6px;">دعوى</span></div>
                <div id="adm7" class="dyn-chart-root"></div>
            </div>

            <div class="chart-card dashboard-block" data-stats-category="administrative" data-chart-wrap="adm8">
                <div class="chart-header">
                <div>
                    <div class="chart-title">أكثر شخص لديه إشارات</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="hbar" onclick="switchDynChart('adm8','hbar')" title="أفقي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="2" width="8" height="2.5" rx="1" fill="currentColor"/><rect x="1" y="5.75" width="11" height="2.5" rx="1" fill="currentColor" opacity=".7"/><rect x="1" y="9.5" width="5.5" height="2.5" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('adm8','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                </div>
                </div>
                <div id="adm8" class="dyn-chart-root"></div>
            </div>
            </div>
            <div class="legal-charts-row" style="grid-template-columns:1fr;">
            <div class="chart-card dashboard-block" data-stats-category="administrative" data-chart-wrap="adm9">
                <div class="chart-header">
                <div>
                    <div class="chart-title">أكثر شخص مدعى عليه</div>
                </div>
                <div class="ctt-row">
                    <button class="ctt-btn active" data-ctype="hbar" onclick="switchDynChart('adm9','hbar')" title="أفقي"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="2" width="8" height="2.5" rx="1" fill="currentColor"/><rect x="1" y="5.75" width="11" height="2.5" rx="1" fill="currentColor" opacity=".7"/><rect x="1" y="9.5" width="5.5" height="2.5" rx="1" fill="currentColor" opacity=".7"/></svg></button>
                    <button class="ctt-btn" data-ctype="donut" onclick="switchDynChart('adm9','donut')" title="دائري"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="2.2"/><path d="M7 1.5A5.5 5.5 0 0 1 12.5 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
                </div>
                </div>
                <div id="adm9" class="dyn-chart-root"></div>
            </div>
            </div>

            <!-- ═══ NEW STATS: عامة ═══ -->

            <!-- عدد الدول والمدن -->
            <div class="legal-charts-row">
            <div class="chart-card dashboard-block" data-stats-category="general">
                <div class="chart-header">
                <div>
                    <div class="chart-title">عدد الدول التي أعمل بها</div>
                    <div class="chart-sub">الانتشار الجغرافي للمحفظة العقارية</div>
                </div>
                <div class="chart-badge">دول</div>
                </div>
                <!-- Globe-style world map dots visualization -->
                <div style="display:flex;align-items:center;gap:20px;margin-top:12px;">
                <svg viewBox="0 0 130 100" width="130" height="100" style="flex-shrink:0;">
                    <defs>
                    <radialGradient id="globeGrad" cx="45%" cy="40%">
                        <stop offset="0%" stop-color="rgba(212,175,55,.15)"/>
                        <stop offset="100%" stop-color="rgba(0,0,0,0)"/>
                    </radialGradient>
                    </defs>
                    <ellipse cx="65" cy="50" rx="55" ry="44" fill="rgba(212,175,55,.04)" stroke="rgba(212,175,55,.12)" stroke-width="1"/>
                    <ellipse cx="65" cy="50" rx="36" ry="44" fill="none" stroke="rgba(212,175,55,.07)" stroke-width="1"/>
                    <ellipse cx="65" cy="50" rx="18" ry="44" fill="none" stroke="rgba(212,175,55,.05)" stroke-width="1"/>
                    <line x1="10" y1="50" x2="120" y2="50" stroke="rgba(212,175,55,.07)" stroke-width="1"/>
                    <line x1="10" y1="30" x2="120" y2="30" stroke="rgba(212,175,55,.05)" stroke-width=".7"/>
                    <line x1="10" y1="70" x2="120" y2="70" stroke="rgba(212,175,55,.05)" stroke-width=".7"/>
                    <!-- Country dots with pulses -->
                    <circle cx="78" cy="38" r="5" fill="rgba(212,175,55,.25)" stroke="var(--gold-bright)" stroke-width="1.5"/>
                    <circle cx="78" cy="38" r="8" fill="none" stroke="rgba(212,175,55,.3)" stroke-width=".8"/>
                    <circle cx="50" cy="42" r="4" fill="rgba(196,154,42,.25)" stroke="var(--gold-mid)" stroke-width="1.5"/>
                    <circle cx="50" cy="42" r="7" fill="none" stroke="rgba(196,154,42,.3)" stroke-width=".8"/>
                    <circle cx="92" cy="55" r="4" fill="rgba(139,105,20,.25)" stroke="var(--gold-deep)" stroke-width="1.5"/>
                    <circle cx="35" cy="58" r="3.5" fill="rgba(212,175,55,.2)" stroke="var(--gold-bright)" stroke-width="1.2"/>
                    <!-- Center count -->
                    <text x="65" y="94" text-anchor="middle" font-family="Amiri" font-size="22" fill="var(--gold-bright)" font-weight="700" id="stat-countries-count">—</text>
                    <text x="65" y="9" text-anchor="middle" font-family="Tajawal" font-size="7" fill="var(--text-muted)" title="دولة"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="1.5"/><ellipse cx="7" cy="7" rx="2.5" ry="5.5" stroke="currentColor" stroke-width="1.2"/><line x1="1.5" y1="7" x2="12.5" y2="7" stroke="currentColor" stroke-width="1.2"/></svg></text>
                </svg>
                <div style="flex:1;display:flex;flex-direction:column;gap:6px;" id="stat-countries-list">
                    <div style="display:flex;align-items:center;gap:8px;">
                    <span style="width:8px;height:8px;border-radius:50%;background:var(--gold-bright);display:inline-block;"></span>
                    <span style="font-size:calc(12px * var(--fs-scale));color:var(--text-secondary);">المملكة العربية السعودية</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                    <span style="width:8px;height:8px;border-radius:50%;background:var(--gold-mid);display:inline-block;"></span>
                    <span style="font-size:calc(12px * var(--fs-scale));color:var(--text-secondary);">الإمارات</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                    <span style="width:8px;height:8px;border-radius:50%;background:var(--gold-deep);display:inline-block;"></span>
                    <span style="font-size:calc(12px * var(--fs-scale));color:var(--text-secondary);">الأردن</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                    <span style="width:8px;height:8px;border-radius:50%;background:var(--text-muted);display:inline-block;"></span>
                    <span style="font-size:calc(12px * var(--fs-scale));color:var(--text-muted);">+ المزيد</span>
                    </div>
                </div>
                </div>
            </div>

            <!-- عدد المدن -->
            <div class="chart-card dashboard-block" data-stats-category="general">
                <div class="chart-header">
                <div>
                    <div class="chart-title">عدد المدن التي أعمل بها</div>
                    <div class="chart-sub">تنوع المدن الجغرافي حسب عدد العقارات</div>
                </div>
                <div class="chart-badge">مدن</div>
                </div>
                <!-- Bubble chart style -->
                <div style="position:relative;height:120px;margin-top:8px;">
                <svg viewBox="0 0 300 110" width="100%" height="100%">
                    <circle cx="60" cy="55" r="38" fill="rgba(212,175,55,.12)" stroke="rgba(212,175,55,.3)" stroke-width="1.5"/>
                    <text x="60" y="50" text-anchor="middle" font-family="Tajawal" font-size="8" fill="var(--text-secondary)">الرياض</text>
                    <text x="60" y="62" text-anchor="middle" font-family="Amiri" font-size="13" fill="var(--gold-bright)" font-weight="700">٨</text>

                    <circle cx="140" cy="50" r="28" fill="rgba(196,154,42,.1)" stroke="rgba(196,154,42,.3)" stroke-width="1.5"/>
                    <text x="140" y="46" text-anchor="middle" font-family="Tajawal" font-size="8" fill="var(--text-secondary)">جدة</text>
                    <text x="140" y="58" text-anchor="middle" font-family="Amiri" font-size="12" fill="var(--gold-mid)" font-weight="700">٥</text>

                    <circle cx="210" cy="58" r="22" fill="rgba(139,105,20,.1)" stroke="rgba(139,105,20,.3)" stroke-width="1.5"/>
                    <text x="210" y="54" text-anchor="middle" font-family="Tajawal" font-size="7" fill="var(--text-secondary)">دبي</text>
                    <text x="210" y="65" text-anchor="middle" font-family="Amiri" font-size="11" fill="var(--gold-deep)" font-weight="700">٣</text>

                    <circle cx="266" cy="62" r="16" fill="rgba(61,61,61,.2)" stroke="rgba(61,61,61,.4)" stroke-width="1.5"/>
                    <text x="266" y="58" text-anchor="middle" font-family="Tajawal" font-size="7" fill="var(--text-muted)">أخرى</text>
                    <text x="266" y="69" text-anchor="middle" font-family="Amiri" font-size="10" fill="var(--text-muted)" font-weight="700">٢</text>

                    <text x="150" y="105" text-anchor="middle" font-family="Tajawal" font-size="8" fill="var(--text-muted)">إجمالي المدن: <tspan font-family="Amiri" font-size="10" fill="var(--gold-bright)" font-weight="700" id="stat-cities-count">—</tspan></text>
                </svg>
                </div>
        
                </div>
            </div>
            </div>

            <!-- عدد الأراضي وأنواعها -->
            <div class="chart-card dashboard-block" data-stats-category="general">
            <div class="chart-header">
                <div>
                <div class="chart-title">عدد الأراضي وأنواعها</div>
                <div class="chart-sub">تصنيف الأراضي في المحفظة حسب النوع</div>
                </div>
                <div class="chart-badge">تصنيف</div>
            </div>
            <!-- Stacked horizontal bar -->
            <div style="margin-top:16px;">
                <div style="display:flex;border-radius:8px;overflow:hidden;height:28px;margin-bottom:16px;">
                <div style="width:20%;background:var(--gold-bright);display:flex;align-items:center;justify-content:center;font-size:calc(11px * var(--fs-scale));color:#111;font-weight:700;" id="stat-land-residential-pct">سكني</div>
                <div style="width:20%;background:var(--gold-mid);display:flex;align-items:center;justify-content:center;font-size:calc(11px * var(--fs-scale));color:#111;font-weight:700;" id="stat-land-commercial-pct">تجاري</div>
                <div style="width:20%;background:var(--gold-deep);display:flex;align-items:center;justify-content:center;font-size:calc(11px * var(--fs-scale));color:var(--ivory-warm);font-weight:700;" id="stat-land-agricultural-pct">زراعي</div>
                <div style="width:20%;background:rgba(61,61,61,.9);display:flex;align-items:center;justify-content:center;font-size:calc(10px * var(--fs-scale));color:var(--text-secondary);" id="stat-land-industrial-pct">صناعي</div>
                <div style="width:20%;background:rgba(40,40,40,.9);display:flex;align-items:center;justify-content:center;font-size:calc(9px * var(--fs-scale));color:var(--text-muted);" id="stat-land-other-pct">أخرى</div>
                </div>
                <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:8px;text-align:center;">
                <div class="legal-kpi" style="padding:10px 6px;">
                    <div class="legal-kpi-label">سكني</div>
                    <div class="legal-kpi-value" style="font-size:calc(18px * var(--fs-scale));" id="stat-land-residential">—</div>
                </div>
                <div class="legal-kpi" style="padding:10px 6px;">
                    <div class="legal-kpi-label">تجاري</div>
                    <div class="legal-kpi-value" style="font-size:calc(18px * var(--fs-scale));" id="stat-land-commercial">—</div>
                </div>
                <div class="legal-kpi" style="padding:10px 6px;">
                    <div class="legal-kpi-label">زراعي</div>
                    <div class="legal-kpi-value" style="font-size:calc(18px * var(--fs-scale));" id="stat-land-agricultural">—</div>
                </div>
                <div class="legal-kpi" style="padding:10px 6px;">
                    <div class="legal-kpi-label">صناعي</div>
                    <div class="legal-kpi-value" style="font-size:calc(18px * var(--fs-scale));" id="stat-land-industrial">—</div>
                </div>
                <div class="legal-kpi" style="padding:10px 6px;">
                    <div class="legal-kpi-label">أخرى</div>
                    <div class="legal-kpi-value" style="font-size:calc(18px * var(--fs-scale));" id="stat-land-other">—</div>
                </div>
                </div>
            </div>
            </div>

            <!-- كم أرض أو سكن لدي ضمن كل دولة -->
            <div class="chart-card dashboard-block" data-stats-category="general">
            <div class="chart-header">
                <div>
                <div class="chart-title">عدد الأراضي والسكن لكل دولة</div>
                <div class="chart-sub">تفصيل الأصول العقارية (أراضي / سكن) مقسّمة حسب الدولة</div>
                </div>
                <div class="chart-badge">دول × أنواع</div>
            </div>
            <!-- Grouped bar chart SVG -->
            <div style="margin-top:12px;overflow-x:auto;">
                <svg viewBox="0 0 420 150" width="100%" style="min-width:280px;">
                <defs>
                    <linearGradient id="landBarGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="var(--gold-bright)"/>
                    <stop offset="100%" stop-color="var(--gold-deep)"/>
                    </linearGradient>
                    <linearGradient id="homeBarGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="rgba(212,175,55,.5)"/>
                    <stop offset="100%" stop-color="rgba(139,105,20,.3)"/>
                    </linearGradient>
                </defs>
                <!-- Grid -->
                <line x1="40" y1="10" x2="40" y2="110" stroke="rgba(148,163,184,0.2)" stroke-width=".8"/>
                <line x1="40" y1="110" x2="410" y2="110" stroke="rgba(148,163,184,0.2)" stroke-width=".8"/>
                <line x1="40" y1="80" x2="410" y2="80" stroke="rgba(148,163,184,0.08)" stroke-width=".6" stroke-dasharray="3,3"/>
                <line x1="40" y1="50" x2="410" y2="50" stroke="rgba(148,163,184,0.08)" stroke-width=".6" stroke-dasharray="3,3"/>
                <!-- Country 1 -->
                <rect x="60" y="40" width="22" height="70" rx="3" fill="url(#landBarGrad)"/>
                <rect x="84" y="65" width="22" height="45" rx="3" fill="url(#homeBarGrad)"/>
                <text x="83" y="125" text-anchor="middle" font-size="8" fill="var(--text-muted)" font-family="Tajawal">السعودية</text>
                <!-- Country 2 -->
                <rect x="150" y="55" width="22" height="55" rx="3" fill="url(#landBarGrad)"/>
                <rect x="174" y="75" width="22" height="35" rx="3" fill="url(#homeBarGrad)"/>
                <text x="173" y="125" text-anchor="middle" font-size="8" fill="var(--text-muted)" font-family="Tajawal">الإمارات</text>
                <!-- Country 3 -->
                <rect x="240" y="70" width="22" height="40" rx="3" fill="url(#landBarGrad)"/>
                <rect x="264" y="85" width="22" height="25" rx="3" fill="url(#homeBarGrad)"/>
                <text x="263" y="125" text-anchor="middle" font-size="8" fill="var(--text-muted)" font-family="Tajawal">الأردن</text>
                <!-- Country 4 -->
                <rect x="330" y="80" width="22" height="30" rx="3" fill="url(#landBarGrad)"/>
                <rect x="354" y="90" width="22" height="20" rx="3" fill="url(#homeBarGrad)"/>
                <text x="353" y="125" text-anchor="middle" font-size="8" fill="var(--text-muted)" font-family="Tajawal">أخرى</text>
                <!-- Legend -->
                <rect x="60" y="135" width="10" height="7" rx="1" fill="url(#landBarGrad)"/>
                <text x="74" y="142" font-size="8" fill="var(--text-secondary)" font-family="Tajawal">أراضي</text>
                <rect x="130" y="135" width="10" height="7" rx="1" fill="url(#homeBarGrad)"/>
                <text x="144" y="142" font-size="8" fill="var(--text-secondary)" font-family="Tajawal">سكن</text>
                </svg>
            </div>
            </div>

            <!-- عدد العقارات المشتراة في آخر سنتين -->
            <div class="chart-card dashboard-block" data-stats-category="general">
            <div class="chart-header">
                <div>
                <div class="chart-title">عدد العقارات المشتراة في آخر سنتين</div>
                <div class="chart-sub">منحنى الاستحواذات الشهرية للسنتين الأخيرتين</div>
                </div>
                <div class="chart-badge" id="stat-recent-count">—</div>
            </div>
            <!-- Area chart style -->
            <div style="margin-top:10px;">
                <svg viewBox="0 0 380 110" width="100%" style="min-width:260px;">
                <defs>
                    <linearGradient id="areaGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="rgba(212,175,55,.3)"/>
                    <stop offset="100%" stop-color="rgba(212,175,55,0)"/>
                    </linearGradient>
                </defs>
                <!-- Grid -->
                <line x1="30" y1="10" x2="30" y2="85" stroke="rgba(148,163,184,0.25)" stroke-width=".8"/>
                <line x1="30" y1="85" x2="370" y2="85" stroke="rgba(148,163,184,0.25)" stroke-width=".8"/>
                <line x1="30" y1="65" x2="370" y2="65" stroke="rgba(148,163,184,.07)" stroke-width=".6" stroke-dasharray="4,4"/>
                <line x1="30" y1="45" x2="370" y2="45" stroke="rgba(148,163,184,.07)" stroke-width=".6" stroke-dasharray="4,4"/>
                <line x1="30" y1="25" x2="370" y2="25" stroke="rgba(148,163,184,.07)" stroke-width=".6" stroke-dasharray="4,4"/>
                <!-- Area fill -->
                <polygon
                    points="30,85 60,70 90,60 120,65 150,45 180,50 210,38 240,42 270,30 300,35 330,28 360,32 370,85"
                    fill="url(#areaGrad)"/>
                <!-- Line -->
                <polyline
                    points="30,85 60,70 90,60 120,65 150,45 180,50 210,38 240,42 270,30 300,35 330,28 360,32"
                    fill="none" stroke="var(--gold-bright)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <!-- Data dots -->
                <g fill="var(--bg-card)" stroke="var(--gold-bright)" stroke-width="1.5">
                    <circle cx="60" cy="70" r="2.5"/>
                    <circle cx="90" cy="60" r="2.5"/>
                    <circle cx="120" cy="65" r="2.5"/>
                    <circle cx="150" cy="45" r="2.5"/>
                    <circle cx="180" cy="50" r="2.5"/>
                    <circle cx="210" cy="38" r="2.5"/>
                    <circle cx="240" cy="42" r="2.5"/>
                    <circle cx="270" cy="30" r="2.5"/>
                    <circle cx="300" cy="35" r="2.5"/>
                    <circle cx="330" cy="28" r="2.5"/>
                    <circle cx="360" cy="32" r="2.5"/>
                </g>
                <!-- X labels - quarters -->
                <g font-size="7" fill="var(--text-muted)" font-family="Tajawal" text-anchor="middle">
                    <text x="60" y="98">ر١ ٢٠٢٤</text>
                    <text x="150" y="98">ر٢ ٢٠٢٤</text>
                    <text x="240" y="98">ر٣ ٢٠٢٤</text>
                    <text x="330" y="98">ر١ ٢٠٢٥</text>
                </g>
                <!-- trend badge -->
                <rect x="300" y="12" width="62" height="16" rx="4" fill="rgba(212,175,55,.1)" stroke="rgba(212,175,55,.2)" stroke-width="1"/>
                <text x="331" y="23" text-anchor="middle" font-size="8" fill="var(--gold-bright)" font-family="Tajawal">↑ نمو ثابت</text>
                </svg>
            </div>
            </div>

        </div>
        </div>

        <!-- ══════════════════════════════
            PAGE 2: BUILDING TABLE
        ══════════════════════════════ -->
        <div class="page" id="page-properties">
        <div style="max-width: 1400px; margin: 0 auto;">

            <div class="page-header">
            <div class="page-header-row">
                <div>
                <div class="page-eyebrow">تقرير العقارات الكامل</div>
                <div class="page-title"><em>تقرير</em> العقارات</div>
                <div class="page-subtitle">جميع المباني والوحدات التي تمتلك فيها حصصاً — مع تصفية متقدمة وتصدير</div>
                </div>
                <div id="props-cards-float">
                <div class="selection-card">
                    <div class="selection-title">ملخص الاختيار الحالي</div>
                    <div class="selection-main-value" id="selection-area">-- م²</div>
                    <div class="selection-subvalue" id="selection-count">-- عقار</div>
                    <div class="selection-bar">
                    <div class="selection-bar-fill" id="selection-bar-fill"></div>
                    </div>
                    <div class="selection-meta">
                    <span id="selection-mode">جميع العقارات</span>
                    <span id="selection-share">0٪ من المساحة الكلية</span>
                    </div>
                </div>
                <div class="selection-card" id="props-price-card" style="display:none">
                    <div class="selection-title">السعر التقريبي الكلي</div>
                    <div class="selection-main-value" id="props-approx-value">—</div>
                    <div class="selection-subvalue" id="props-actual-label" style="font-size:11px;opacity:.75">السعر الفعلي</div>
                    <div class="selection-main-value" id="props-actual-value" style="font-size:16px;color:var(--gold-mid)">—</div>
                    <div class="selection-bar"><div class="selection-bar-fill" id="props-price-bar"></div></div>
                    <div class="selection-meta"><span id="props-price-mode">العقارات المحددة</span><span>بالدولار</span></div>
                </div>
                </div>
            </div>
            </div>

            <div id="properties-focus-target" class="report-focus-target">
            <!-- TOOLBAR -->
            <div class="table-toolbar">
            <div class="toolbar-main-actions">
                <button type="button" class="toolbar-main-btn search-icon-btn" id="toolbar-main-search" onclick="setPropertyToolbarMode('search')" title="بحث" aria-label="بحث">
                🔍
                </button>
                <div class="toolbar-inline-search" id="toolbar-inline-search">
                <input class="search-input" type="text" placeholder="ابحث في جميع الحقول…" id="table-search" oninput="globalSearch(this.value)" style="min-width:0">
                <button type="button" class="toolbar-search-close" onclick="setPropertyToolbarMode('close-search')" title="إغلاق البحث">✕</button>
                </div>
                <button type="button" class="toolbar-main-btn" id="toolbar-main-reports" onclick="setPropertyToolbarMode('reports')">
                مولد تقارير
                </button>
                <div class="export-dropdown">
                <button type="button" class="toolbar-main-btn" id="toolbar-main-export" onclick="toggleExportDropdown('prop-export-menu')">
                    تصدير ▾
                </button>
                <div class="export-dropdown-menu" id="prop-export-menu">
                    <button class="export-dropdown-item excel" onclick="exportExcel(); closeExportDropdown('prop-export-menu')">
                    <svg width="13" height="13" viewBox="0 0 14 14" fill="none"><rect x="1" y="1" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M4 4l6 6M10 4L4 10" stroke="currentColor" stroke-width="1.5"/></svg>
                    تصدير Excel
                    </button>
                    <button class="export-dropdown-item pdf" onclick="exportPDF(); closeExportDropdown('prop-export-menu')">
                    <svg width="13" height="13" viewBox="0 0 14 14" fill="none"><rect x="1" y="1" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M4 7h6M4 4h6M4 10h4" stroke="currentColor" stroke-width="1.5"/></svg>
                    تصدير PDF
                    </button>
                </div>
                </div>
                <button type="button" class="toolbar-main-btn" id="properties-fullscreen-btn" data-fullscreen-key="properties" onclick="toggleReportTableFullscreen('properties')">
                ⛶ ملء الشاشة
                </button>
            </div>

            <div class="toolbar-mode-panel" id="toolbar-reports-panel" hidden>
                <div class="filter-group">
                <span class="filter-group-title">توليد تقرير</span>
                <div style="position:relative">
                    <button class="toolbar-btn toolbar-btn-report" id="prop-col-menu-btn" type="button" onclick="toggleColMenu(event)">⚙ مولد التقارير</button>
                    <div class="col-menu" id="col-menu">
                    <div class="col-menu-pin-bar" id="main-pin-actions">
                        <button type="button" class="col-menu-unpin-btn" onclick="unpinAllColumns('main-table')">إلغاء تثبيت الكل</button>
                        <span class="col-menu-pin-info">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="17" x2="12" y2="22"/><path d="M5 17h14v-1.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V6h1a2 2 0 0 0 0-4H8a2 2 0 0 0 0 4h1v4.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24Z"/></svg>
                        <span id="main-pin-count"></span>
                        </span>
                    </div>
                    <div class="col-menu-item col-menu-selectall" onclick="toggleAllColumns()"><div class="col-toggle" id="tog-all">✓</div> تحديد الكل</div>
                    <div class="col-menu-item" onclick="toggleCol('col-seq')"><div class="col-toggle" id="tog-seq">✓</div> ID العقار</div>
                    <div class="col-menu-item" onclick="toggleCol('col-propnoMahder')"><div class="col-toggle" id="tog-propnoMahder">✓</div> رقم العقار / المحضر</div>
                    <div class="col-menu-item" onclick="toggleCol('col-propOwners')"><div class="col-toggle" id="tog-propOwners">✓</div> مالك العقار</div>
                    <div class="col-menu-item" onclick="toggleCol('col-country')"><div class="col-toggle" id="tog-country"></div> الدولة</div>
                    <div class="col-menu-item" onclick="toggleCol('col-city')"><div class="col-toggle" id="tog-city"></div> المحافظة</div>
                    <div class="col-menu-item" onclick="toggleCol('col-type')"><div class="col-toggle" id="tog-type">✓</div> فئة / نوع العقار</div>
                    <div class="col-menu-item" onclick="toggleCol('col-owndate')"><div class="col-toggle" id="tog-owndate">✓</div> تاريخ تملك العقار</div>
                    <div class="col-menu-item" onclick="toggleCol('col-area')"><div class="col-toggle" id="tog-area">✓</div> مساحة العقار</div>
                    <div class="col-menu-item" onclick="toggleCol('col-geo')"><div class="col-toggle" id="tog-geo"></div> الموقع الجغرافي</div>
                    <div class="col-menu-item" onclick="toggleCol('col-propNotes')"><div class="col-toggle" id="tog-propNotes">✓</div> ملاحظات عن العقار</div>
                    <div class="col-menu-item" onclick="toggleCol('col-opstatus')"><div class="col-toggle" id="tog-opstatus">✓</div> الحالة التشغيلية</div>
                    <div class="col-menu-item" onclick="toggleCol('col-approxprice')"><div class="col-toggle" id="tog-approxprice">✓</div> السعر التقريبي</div>
                    <div class="col-menu-item" onclick="toggleCol('col-actualprice')"><div class="col-toggle" id="tog-actualprice">✓</div> السعر الفعلي</div>
                    <div class="col-menu-item" onclick="toggleCol('col-payfinance')"><div class="col-toggle" id="tog-payfinance">✓</div> الدفعات المالية</div>
                    <div class="col-menu-item" onclick="toggleCol('col-paydetail')"><div class="col-toggle" id="tog-paydetail">✓</div> تفاصيل الدفعات</div>
                    <div class="col-menu-item" onclick="toggleCol('col-view')"><div class="col-toggle" id="tog-view">✓</div> عرض</div>
                    <div class="col-menu-item" onclick="toggleCol('col-propEntered')"><div class="col-toggle" id="tog-propEntered">✓</div> المدخل</div>
                    <div class="col-menu-item" onclick="toggleCol('col-propCreated')"><div class="col-toggle" id="tog-propCreated">✓</div> تاريخ الادخال</div>
                    <div class="col-menu-item" onclick="toggleCol('col-propUpdated')"><div class="col-toggle" id="tog-propUpdated">✓</div> تاريخ آخر تعديل</div>
                    </div>
                </div>
                </div>

                <div class="filter-group">
                <span class="filter-group-title">المدخل</span>
                <input class="search-input" type="text" id="prop-entered-by" placeholder="اسم المدخل…" oninput="filterTable()" style="min-width:0">
                </div>

                <div class="filter-group">
                <span class="filter-group-title">الدولة</span>
                <div class="filter-dropdown">
                    <button type="button" class="filter-multi-btn" onclick="toggleCountryMenu()" id="filter-country-label">الدول</button>
                    <div class="col-menu" id="country-menu">
                    <div class="col-menu-item col-menu-selectall" onclick="toggleAllCountries()"><div class="col-toggle" id="country-all">✓</div> تحديد الكل</div>
                    <div class="col-menu-item" onclick="toggleCountryFilter('سورية')"><div class="col-toggle" id="country-syria"></div> سورية</div>
                    <div class="col-menu-item" onclick="toggleCountryFilter('الامارات')"><div class="col-toggle" id="country-uae"></div> الامارات</div>
                    <div class="col-menu-item" onclick="toggleCountryFilter('أخرى')"><div class="col-toggle" id="country-other"></div> أخرى</div>
                    </div>
                </div>
                </div>

                <div class="filter-group">
                <span class="filter-group-title">المحافظة</span>
                <div class="filter-dropdown">
                    <button type="button" class="filter-multi-btn" onclick="toggleCityMenu()" id="filter-city-label">المحافظة</button>
                    <div class="col-menu" id="city-menu"></div>
                </div>
                </div>

                <div class="filter-group">
                <span class="filter-group-title">العقار</span>
                <div class="filter-dropdown">
                    <button type="button" class="filter-multi-btn" onclick="toggleCascadeMenu(event)" id="filter-cascade-label">نوع العقار</button>
                    <div class="cascade-menu" id="cascade-menu">
                    <div class="col-menu-item col-menu-selectall" onclick="toggleAllCascade(event)"><div class="col-toggle" id="cascade-all">✓</div> تحديد الكل</div>
                    <div class="cascade-sep"></div>
                    <div class="cascade-item" onclick="toggleCascadeCat('أرض', event)">
                        <div class="cascade-item-left"><div class="col-toggle" id="cascade-cat-أرض"></div> أرض</div>
                        <span class="cascade-item-arrow">◂</span>
                        <div class="cascade-submenu">
                        <div class="cascade-sub-item" onclick="toggleCascadeSub('زراعية', event)"><div class="col-toggle" id="cascade-sub-زراعية"></div> زراعية</div>
                        <div class="cascade-sub-item" onclick="toggleCascadeSub('سكنية', event)"><div class="col-toggle" id="cascade-sub-سكنية"></div> سكنية</div>
                        </div>
                    </div>
                    <div class="cascade-item" onclick="toggleCascadeCat('سكن', event)">
                        <div class="cascade-item-left"><div class="col-toggle" id="cascade-cat-سكن"></div> سكن</div>
                        <span class="cascade-item-arrow">◂</span>
                        <div class="cascade-submenu">
                        <div class="cascade-sub-item" onclick="toggleCascadeSub('منزل', event)"><div class="col-toggle" id="cascade-sub-منزل"></div> منزل</div>
                        <div class="cascade-sub-item" onclick="toggleCascadeSub('فيلا', event)"><div class="col-toggle" id="cascade-sub-فيلا"></div> فيلا</div>
                        </div>
                    </div>
                    <div class="cascade-item" onclick="toggleCascadeCat('تجاري', event)">
                        <div class="cascade-item-left"><div class="col-toggle" id="cascade-cat-تجاري"></div> تجاري</div>
                        <span class="cascade-item-arrow">◂</span>
                        <div class="cascade-submenu">
                        <div class="cascade-sub-item" onclick="toggleCascadeSub('مجمع', event)"><div class="col-toggle" id="cascade-sub-مجمع"></div> مجمع</div>
                        <div class="cascade-sub-item" onclick="toggleCascadeSub('دكان', event)"><div class="col-toggle" id="cascade-sub-دكان"></div> دكان</div>
                        <div class="cascade-sub-item" onclick="toggleCascadeSub('مول', event)"><div class="col-toggle" id="cascade-sub-مول"></div> مول</div>
                        <div class="cascade-sub-item" onclick="toggleCascadeSub('مطعم', event)"><div class="col-toggle" id="cascade-sub-مطعم"></div> مطعم</div>
                        <div class="cascade-sub-item" onclick="toggleCascadeSub('أخرى', event)"><div class="col-toggle" id="cascade-sub-أخرى"></div> أخرى</div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <div class="filter-group">
                <span class="filter-group-title">المساحة</span>
                <div class="filter-dropdown">
                    <button type="button" class="filter-multi-btn" onclick="toggleAreaMenu()" id="filter-area-label">المساحات</button>
                    <div class="col-menu" id="area-menu">
                    <div class="col-menu-item col-menu-selectall" onclick="toggleAllAreas()"><div class="col-toggle" id="area-all">✓</div> تحديد الكل</div>
                    <div class="col-menu-item" onclick="toggleAreaFilter('small')"><div class="col-toggle" id="area-small">✓</div> أقل من ١٠٬٠٠٠ م²</div>
                    <div class="col-menu-item" onclick="toggleAreaFilter('medium')"><div class="col-toggle" id="area-medium">✓</div> ١٠٬٠٠٠ - ٢٠٬٠٠٠ م²</div>
                    <div class="col-menu-item" onclick="toggleAreaFilter('large')"><div class="col-toggle" id="area-large">✓</div> أكثر من ٢٠٬٠٠٠ م²</div>
                    </div>
                </div>
                </div>

                <div class="filter-group">
                <span class="filter-group-title">تاريخ الادخال</span>
                <div class="date-range-dropdown">
                    <button type="button" class="date-range-btn" id="prop-created-btn" onclick="toggleDateRangePopover('prop-created-pop', event)">
                    <span id="prop-created-label">من — إلى</span>
                    <span class="date-range-arrow">▾</span>
                    </button>
                    <div class="date-range-popover" id="prop-created-pop">
                    <div class="date-range-popover-row">
                        <span class="date-range-popover-label">من</span>
                        <input class="search-input" id="prop-created-from" type="date" oninput="onPropDateFilter();updateDateRangeLabel('prop-created-from','prop-created-to','prop-created-label','prop-created-btn')">
                    </div>
                    <div class="date-range-popover-row">
                        <span class="date-range-popover-label">إلى</span>
                        <input class="search-input" id="prop-created-to" type="date" oninput="onPropDateFilter();updateDateRangeLabel('prop-created-from','prop-created-to','prop-created-label','prop-created-btn')">
                    </div>
                    <button class="date-range-clear" onclick="clearDateRange('prop-created-from','prop-created-to','prop-created-label','prop-created-btn');onPropDateFilter()">✕ مسح</button>
                    </div>
                </div>
                </div>

                <div class="filter-group">
                <span class="filter-group-title">تاريخ تملك العقار</span>
                <div class="date-range-dropdown">
                    <button type="button" class="date-range-btn" id="prop-own-btn" onclick="toggleDateRangePopover('prop-own-pop', event)">
                    <span id="prop-own-label">من — إلى</span>
                    <span class="date-range-arrow">▾</span>
                    </button>
                    <div class="date-range-popover" id="prop-own-pop">
                    <div class="date-range-popover-row">
                        <span class="date-range-popover-label">من</span>
                        <input class="search-input" id="prop-own-from" type="date" oninput="onPropDateFilter();updateDateRangeLabel('prop-own-from','prop-own-to','prop-own-label','prop-own-btn')">
                    </div>
                    <div class="date-range-popover-row">
                        <span class="date-range-popover-label">إلى</span>
                        <input class="search-input" id="prop-own-to" type="date" oninput="onPropDateFilter();updateDateRangeLabel('prop-own-from','prop-own-to','prop-own-label','prop-own-btn')">
                    </div>
                    <button class="date-range-clear" onclick="clearDateRange('prop-own-from','prop-own-to','prop-own-label','prop-own-btn');onPropDateFilter()">✕ مسح</button>
                    </div>
                </div>
                </div>

                <div class="filter-group">
                <span class="filter-group-title">حالة التشغيل</span>
                <div class="filter-dropdown">
                    <button type="button" class="filter-multi-btn" onclick="togglePropOpMenu()" id="filter-prop-op-btn">حالة العقار</button>
                    <div class="col-menu" id="prop-op-menu">
                    <div class="col-menu-item col-menu-selectall" onclick="toggleAllPropOpStatus()"><div class="col-toggle" id="prop-op-all">✓</div> تحديد الكل</div>
                    <div class="col-menu-item" onclick="togglePropOpStatusFilter('يعمل')"><div class="col-toggle" id="prop-op-working"></div> يعمل</div>
                    <div class="col-menu-item" onclick="togglePropOpStatusFilter('جاري صيانته')"><div class="col-toggle" id="prop-op-maint"></div> جاري صيانته</div>
                    <div class="col-menu-item" onclick="togglePropOpStatusFilter('متوقف عن العمل')"><div class="col-toggle" id="prop-op-stopped"></div> متوقف عن العمل</div>
                    </div>
                </div>
                </div>

                <div class="filter-group">
                <span class="filter-group-title">الدفعات</span>
                <div class="filter-dropdown">
                    <button type="button" class="filter-multi-btn" onclick="togglePropPayFinanceMenu()" id="filter-prop-pay-btn">مدفوع / جزئي</button>
                    <div class="col-menu" id="prop-pay-menu">
                    <div class="col-menu-item col-menu-selectall" onclick="toggleAllPropPayFinance()"><div class="col-toggle" id="prop-pay-all">✓</div> تحديد الكل</div>
                    <div class="col-menu-item" onclick="togglePropPayFinanceFilter('مدفوع بشكل كامل')"><div class="col-toggle" id="prop-pay-full"></div> مدفوع بشكل كامل</div>
                    <div class="col-menu-item" onclick="togglePropPayFinanceFilter('جزئي')"><div class="col-toggle" id="prop-pay-partial"></div> جزئي</div>
                    </div>
                </div>
                </div>

                <div class="filter-group">
                <span class="filter-group-title">تاريخ آخر تعديل</span>
                <div class="date-range-dropdown">
                    <button type="button" class="date-range-btn" id="prop-updated-btn" onclick="toggleDateRangePopover('prop-updated-pop', event)">
                    <span id="prop-updated-label">من — إلى</span>
                    <span class="date-range-arrow">▾</span>
                    </button>
                    <div class="date-range-popover" id="prop-updated-pop">
                    <div class="date-range-popover-row">
                        <span class="date-range-popover-label">من</span>
                        <input class="search-input" id="prop-updated-from" type="date" oninput="onPropDateFilter();updateDateRangeLabel('prop-updated-from','prop-updated-to','prop-updated-label','prop-updated-btn')">
                    </div>
                    <div class="date-range-popover-row">
                        <span class="date-range-popover-label">إلى</span>
                        <input class="search-input" id="prop-updated-to" type="date" oninput="onPropDateFilter();updateDateRangeLabel('prop-updated-from','prop-updated-to','prop-updated-label','prop-updated-btn')">
                    </div>
                    <button class="date-range-clear" onclick="clearDateRange('prop-updated-from','prop-updated-to','prop-updated-label','prop-updated-btn');onPropDateFilter()">✕ مسح</button>
                    </div>
                </div>
                </div>

                <div class="filter-group">
                <span class="filter-group-title">ترتيب الأعمدة</span>
                <button class="toolbar-btn toolbar-btn-outline" id="reorder-cols-btn" onclick="toggleColumnReorderMode()">⇅ إعادة الترتيب</button>
                </div>

                <div class="filter-group">
                <span class="filter-group-title">تحديد الصفوف</span>
                <button class="toolbar-btn toolbar-btn-gold" onclick="toggleMultiSelect()" id="multi-select-btn">اختيار متعدد</button>
                </div>
            </div>

            <button
                class="toolbar-btn toolbar-btn-outline mobile-table-view-toggle"
                type="button"
                id="mobile-table-view-toggle"
                onclick="togglePropertyTableView()"
            >
                عرض عمودي
            </button>
            </div>

            <!-- ACTIVE FILTERS + EXPORT -->
            <div class="filter-chips" id="filter-chips">
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
                <span class="filter-label">التصفية الحالية:</span>
                <span class="chip active">الكل <span class="chip-remove">×</span></span>
            </div>
            </div>

            <!-- TABLE -->
            <div class="table-card registry-pdf-print-root" id="property-table-card">
            <div class="table-with-scroll-btn">
            <div class="tbl-top-scroll" id="main-top-scroll"><div class="tbl-top-scroll-inner"></div></div>
            <div class="table-overflow" id="main-overflow">
                <table class="big-table" id="main-table">
                <colgroup id="main-colgroup">
                    <col class="select-col"           style="width:1px">
                    <col class="col-seq"              style="width:110px; min-width:110px">
                    <col class="col-propnoMahder"     style="width:1px">
                    <col class="col-propOwners"       style="min-width:200px;width:15%">
                    <col class="col-country"          style="width:1px">
                    <col class="col-city"             style="width:1px">
                    <col class="col-type"             style="width:auto">
                    <col class="col-owndate"          style="width:1px">
                    <col class="col-area"             style="width:1px">
                    <col class="col-geo"              style="width:1px">
                    <col class="col-propNotes"       style="width:1px">
                    <col class="col-opstatus"         style="width:1px">
                    <col class="col-approxprice"     style="width:1px">
                    <col class="col-actualprice"     style="width:1px">
                    <col class="col-payfinance"      style="width:1px">
                    <col class="col-paydetail"       style="width:1px">
                    <col class="col-view"            style="width:1px">
                    <col class="col-propEntered"     style="width:1px">
                    <col class="col-propCreated"      style="width:1px">
                    <col class="col-propUpdated"      style="width:1px">
                </colgroup>
                <thead>
                    <tr>
                    <th class="select-col">
                        <div class="th-inner">
                        <input type="checkbox" id="select-all" onclick="toggleSelectAll()" />
                        </div>
                    </th>
                    <th class="col-seq" data-col-key="col-seq" onclick="sortBySeq()" style="cursor:pointer">
                        <div class="th-inner">
                        ID العقار
                        <span class="sort-icon" id="sort-seq">↕</span>
                        </div>
                    </th>
                    <th class="col-propnoMahder" data-col-key="col-propnoMahder"><div class="th-inner">رقم العقار / اسم المحضر</div></th>
                    <th class="col-propOwners" data-col-key="col-propOwners"><div class="th-inner">مالك العقار</div></th>
                    <th class="col-country" data-col-key="col-country"><div class="th-inner">الدولة</div></th>
                    <th class="col-city" data-col-key="col-city"><div class="th-inner">المحافظة</div></th>
                    <th class="col-type" data-col-key="col-type"><div class="th-inner">فئة / نوع العقار</div></th>
                    <th class="col-owndate" data-col-key="col-owndate"><div class="th-inner">تاريخ تملك العقار</div></th>
                    <th class="col-area" data-col-key="col-area" onclick="sortByArea()" style="cursor:pointer">
                        <div class="th-inner">
                        مساحة العقار
                        <span class="sort-icon" id="sort-area">↕</span>
                        </div>
                    </th>
                    <th class="col-geo" data-col-key="col-geo"><div class="th-inner">الموقع الجغرافي</div></th>
                    <th class="col-propNotes" data-col-key="col-propNotes"><div class="th-inner">ملاحظات عن العقار</div></th>
                    <th class="col-opstatus" data-col-key="col-opstatus"><div class="th-inner">الحالة</div></th>
                    <th class="col-approxprice" data-col-key="col-approxprice"><div class="th-inner">السعر التقريبي ($)</div></th>
                    <th class="col-actualprice" data-col-key="col-actualprice"><div class="th-inner">السعر الفعلي ($)</div></th>
                    <th class="col-payfinance" data-col-key="col-payfinance"><div class="th-inner">الدفعات المالية</div></th>
                    <th class="col-paydetail" data-col-key="col-paydetail"><div class="th-inner">تفاصيل الدفعات</div></th>
                    <th class="col-view" data-col-key="col-view"><div class="th-inner">عرض</div></th>
                    <th class="col-propEntered" data-col-key="col-propEntered"><div class="th-inner">المدخل</div></th>
                    <th class="col-propCreated" data-col-key="col-propCreated"><div class="th-inner">تاريخ ادخال البيانات</div></th>
                    <th class="col-propUpdated" data-col-key="col-propUpdated"><div class="th-inner">تاريخ آخر تعديل</div></th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <!-- rows injected by JS -->
                </tbody>
                </table>
            </div>
            <div class="table-scroll-start-bar" aria-hidden="true"></div>
            <div class="tbl-nav-pill" id="main-tbl-nav-pill" role="navigation" aria-label="التنقل في الجدول">
                <div class="tbl-nav-pill-inner">
                <button type="button" class="tbl-nav-pill-btn" id="main-nav-start" onclick="tblNavGo(this,'right')" title="بداية الجدول" aria-label="بداية الجدول">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 17l-5-5 5-5"/><path d="M18 17l-5-5 5-5"/></svg>
                    بداية الجدول
                </button>
                <div class="tbl-nav-pill-sep" aria-hidden="true"></div>
                <button type="button" class="tbl-nav-pill-btn" id="main-nav-end" onclick="tblNavGo(this,'left')" title="نهاية الجدول" aria-label="نهاية الجدول">
                    نهاية الجدول
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13 17l5-5-5-5"/><path d="M6 17l5-5-5-5"/></svg>
                </button>
                </div>
            </div>
            </div>

            <!-- PAGINATION -->
            <div class="pagination" id="pagination">
                <div class="export-info">
                إجمالي الصفوف: <strong id="row-count">14</strong> عقار
                | المحدَّد: <strong id="selected-count">0</strong>
                </div>
                <div style="display:flex;align-items:center;gap:12px">
                <button class="page-btn" onclick="changePage(-1)">‹</button>
                <span class="filter-label" id="page-info">صفحة ١ من ١</span>
                <button class="page-btn" onclick="changePage(1)">›</button>
                </div>
                <div style="display:flex;align-items:center;gap:8px">
                <span class="filter-label">عدد الصفوف المعروضة:</span>
                <input type="number" min="1" class="rows-input" id="rows-input" value="14" onchange="handleRowsInput(this.value)" />
                </div>
            </div>
            </div>
        </div>

        </div>
        </div>

        <!-- ══════════════════════════════
            PAGE: تقرير المالك
        ══════════════════════════════ -->
        <div class="page" id="page-owners">
        <div style="max-width: 1400px; margin: 0 auto;">
            <div class="page-header">
            <div class="page-header-row">
                <div>
                <div class="page-eyebrow">تقرير المالك الكامل</div>
                <div class="page-title">تقرير <em>المالك</em></div>
                <div class="page-subtitle">نفس أدوات البحث والتصفية والتصدير مع بيانات تقرير المالك</div>
                </div>

            </div>
            </div>
            <div id="owners-records-root"></div>
        </div>
        </div>

        <!-- ══════════════════════════════
            PAGE: تقرير الإشارات
        ══════════════════════════════ -->
        <div class="page" id="page-consultations">
        <div style="max-width: 1400px; margin: 0 auto;">
            <div class="page-header">
            <div class="page-header-row">
                <div>
                <div class="page-eyebrow">تقرير الإشارات الكامل</div>
                <div class="page-title">تقرير <em>الإشارات</em></div>
                <div class="page-subtitle">نفس النمط العام للسجلات مع محتوى خاص بسجل الإشارات</div>
                </div>
            </div>
            </div>
            <div id="consultations-records-root"></div>
        </div>
        </div>

        <!-- ══════════════════════════════
            PAGE: تقرير الملحقات
        ══════════════════════════════ -->
        <div class="page" id="page-attachments">
        <div style="max-width: 1400px; margin: 0 auto;">
            <div class="page-header">
            <div class="page-header-row">
                <div>
                <div class="page-eyebrow">تقرير الملحقات الكامل</div>
                <div class="page-title">تقرير <em>الملحقات</em></div>
                <div class="page-subtitle">نفس الشكل والفلترة والتصدير مع بيانات الملحقات</div>
                </div>
            </div>
            </div>
            <div id="attachments-records-root"></div>
        </div>
        </div>

        <!-- ══════════════════════════════
            PAGE: تقرير التتبع
        ══════════════════════════════ -->
        <div class="page" id="page-activity">
        <div style="max-width: 720px; margin: 0 auto;">
            <div class="page-header">
            <div>
                <div class="page-eyebrow">آخر الإدخالات والتعديلات</div>
                <div class="page-title">تقرير <em>التتبع</em></div>
                <div class="page-subtitle">أحدث العقارات في التقارير وما يُسجَّل من تحديثات على البيانات</div>
            </div>
            </div>
            <div class="activity-feed-card">
            <div class="recent-header">
                <div class="recent-title">النشاط الأخير</div>
            </div>
            <ul class="activity-feed-list" id="activity-feed-list" aria-live="polite"></ul>
            </div>
        </div>
        </div>

    </div>
    </div>

    <script>
    /* ─── DATA ─── */
    const buildings = [
    {
        name: 'برج النخيل التجاري',
        city: 'الرياض',
        type: 'حي العليا',
        units: 48,
        floors: 18,
        year: 2018,
        area: 12400,
        share: 45,
        value: 8400000,
        rent: 24000,
        status: 'نشط',
        propId: 'PRO-001',
        ownDate: '2020-03-15',
        propNo: '١٠٢٤/أ',
        mahder: 'محضر رقم ٣٤٥/١٤٤٢',
        division: 'قطع تجارية على شارع رئيسي',
        geo: 'https://maps.google.com',
        details: 'برج تجاري حديث في قلب حي العليا التجاري، يحتوي على مكاتب فاخرة بمواصفات عالية وتشطيبات مميزة مع مواقف سيارات مخصصة.',
        opsCount: 3,
        opsDetails: [
        '01/01/2025 — توزيع أرباح ربع سنوي بقيمة ٢٥٠,٠٠٠ دولار.',
        '15/03/2025 — صيانة دورية للمصاعد والواجهات الزجاجية.',
        '30/06/2025 — تجديد عقد إيجار رئيسي لمدة ثلاث سنوات.'
        ],
        payments: '٣ دفعات مسددة من أصل ٤',

        // ── تفاصيل تجريبية لصفحة البطاقة الجديدة ──
        totalOpShares: 1250,
        shares: {
        abdulqader: '٢٧٥ سهم',
        riyad: '٣٢٠ سهم'
        },
        operations: [
        {
            type: 'شراء',
            prevOwners: ['شركة الواجهة التجارية'],
            newOwners: ['د. عبد القادر السنكري', 'رياض عسلي'],
            team1: ['أحمد عبدالله', 'سارة محمد'],
            team2: ['خالد حسن', 'ريم خالد'],
            amount: 150,
            unit: 'سهم',
            method: 'عقد تقرير عقاري',
            contractNo: 'CTR-1024-01',
            contractDate: '2024-11-12',
            notes: 'تمت العملية وفق إجراءات السجل العقاري وبحضور الشهود.',
            witness1: 'عبدالله سالم',
            witness2: 'ماجد يوسف'
        },
        {
            type: 'بيع',
            prevOwners: ['رياض عسلي'],
            newOwners: ['د. عبد القادر السنكري'],
            team1: ['فهد علي'],
            team2: ['نور أحمد'],
            amount: 45,
            unit: 'نسبة مئوية',
            method: 'عقد عادي',
            contractNo: 'CTR-1024-02',
            contractDate: '2025-05-03',
            notes: 'بيع حصة جزئية مع تحديث بيانات المالك.',
            witness1: 'سلمان ناصر',
            witness2: 'محمد عبدالعزيز'
        }
        ],
        signals: [
        {
            signalId: 'SIG-001',
            no: 'A-10021',
            date: '2025-03-11',
            type: 'دعوى',
            notes: 'تم تقديم الدعوى لدى المحكمة العقارية بخصوص برج النخيل التجاري — مطابق لسجل تقرير الإشارات.',
            owners: ['أحمد محمد العلي'],
            defendants: ['شركة التوريد']
        },
        {
            signalId: 'SIG-015',
            no: 'A-30150',
            date: '2025-01-20',
            type: 'حجز',
            notes: 'حجز تحفظي مؤقت لحين استكمال إجراء إداري؛ المعرّف SIG-015 مطابق لسجل تقرير الإشارات.',
            owners: ['د. عبد القادر السنكري'],
            defendants: ['جهة تمويل']
        }
        ],
        attachments: [
        { name: 'صك الملكية.pdf', issuedAt: '2024-11-12' },
        { name: 'عقد البيع.pdf', issuedAt: '2025-05-03' },
        { name: 'محضر استلام.pdf', issuedAt: '2025-01-01' }
        ],
        ownedValueUsd: '420,000 $',
        totalPaymentsUsd: '180,000 $',
        remainingUsd: '240,000 $',
        paymentsUsd: [
        { date: '2025-02-01', amountUsd: 60000 },
        { date: '2025-04-01', amountUsd: 60000 },
        { date: '2025-07-01', amountUsd: 60000 }
        ]
    },
    {
        name: 'مجمع الواحة السكني',
        city: 'جدة',
        type: 'حي الحمراء',
        units: 86,
        floors: 12,
        year: 2015,
        area: 28600,
        share: 32,
        value: 6100000,
        rent: 8500,
        status: 'نشط',
        propId: 'PRO-002',
        ownDate: '2019-07-22',
        propNo: '٢١١٩/ب',
        mahder: 'محضر رقم ٢١٧/١٤٤٠',
        division: 'مجمع سكني مغلق بعدة مبانٍ',
        geo: 'https://maps.google.com',
        details: 'مجمع سكني متكامل الخدمات بالقرب من الكورنيش، يضم شققاً عائلية بمساحات مختلفة وحدائق داخلية ومناطق ألعاب.',
        opsCount: 4,
        opsDetails: [
        '10/02/2025 — إضافة مواقف مظللة إضافية.',
        '05/04/2025 — تحسين إنارة الممرات الداخلية.',
        '20/05/2025 — توقيع عقود إيجار جديدة لـ ٦ شقق.',
        '01/07/2025 — مراجعة عقود الصيانة السنوية.'
        ],
        payments: '٤ دفعات مكتملة حتى تاريخه',
        signals: [
        {
            signalId: 'SIG-003',
            no: 'A-20660',
            date: '2025-04-21',
            type: 'تظلم',
            notes: 'تظلم مرتبط بعقد صيانة المجمع — مطابق لمعلومات تقرير الإشارات.',
            owners: ['مجموعة مستثمري الواحة'],
            defendants: ['شركة إدارة المجمع']
        }
        ]
    },
    {
        name: 'أبراج المدينة المكتبية',
        city: 'الرياض',
        type: 'حي النزهة',
        units: 36,
        floors: 22,
        year: 2019,
        area: 9200,
        share: 28,
        value: 5700000,
        rent: 32000,
        status: 'جزئي',
        propId: 'PRO-003',
        ownDate: '2021-01-10',
        propNo: '٣٠٥٨/ج',
        mahder: 'محضر رقم ٤٥٢/١٤٤١',
        division: 'برج مكاتب متعدد الاستخدام',
        geo: 'https://maps.google.com',
        details: 'برجان إداريان بمكاتب مطلة على الطرق الرئيسية، مجهزان ببنية تحتية تقنية حديثة ومواقف متعددة الأدوار.',
        opsCount: 2,
        opsDetails: [
        '12/01/2025 — توقيع عقد إيجار مع شركة تقنية عالمية.',
        '18/06/2025 — تحديث أنظمة الأمن والدخول الذكي.'
        ],
        payments: '٢ دفعة مسددة ودفعة واحدة متبقية',
        signals: [
        {
            signalId: 'SIG-002',
            no: 'A-10310',
            date: '2026-02-03',
            type: 'استيفاء',
            notes: 'استيفاء وتسوية مرتبطة بأبراج المدينة المكتبية — مطابق لسجل تقرير الإشارات.',
            owners: ['ريم خالد الشامي'],
            defendants: ['مقاول التنفيذ']
        }
        ]
    },
    {
        name: 'برج الفيصلية الفندقي',
        city: 'الدمام',
        type: 'حي الشاطئ',
        units: 22,
        floors: 8,
        year: 2020,
        area: 6800,
        share: 50,
        value: 4200000,
        rent: 45000,
        status: 'نشط',
        propId: 'PRO-004',
        ownDate: '2018-11-05',
        propNo: '٤١٠٧/د',
        mahder: 'محضر رقم ٥٦٠/١٤٤٢',
        division: 'برج فندقي مطل على البحر',
        geo: 'https://maps.google.com',
        details: 'برج فندقي يطل على الكورنيش مباشرة، يحتوي على أجنحة فندقية ومساحات استقبال فاخرة وقاعات مناسبات.',
        opsCount: 5,
        opsDetails: [
        '05/01/2025 — تجديد عقود مع شركة تشغيل فندقي.',
        '22/02/2025 — إطلاق باقة عروض منتصف الأسبوع.',
        '10/04/2025 — ترميم جزء من الواجهة البحرية.',
        '15/06/2025 — توقيع عقد فعاليات سنوية.',
        '01/08/2025 — تحديث الأثاث في الأجنحة التنفيذية.'
        ],
        payments: '٥ دفعات مسددة بالكامل',
        signals: [
        {
            signalId: 'SIG-004',
            no: 'A-21891',
            date: '2025-08-03',
            type: 'تنفيذ',
            notes: 'طلب تنفيذ بخصوص مستحقات تشغيل فندقي — مطابق لمعلومات تقرير الإشارات.',
            owners: ['شركة واجهات الخليج'],
            defendants: ['مشغل الفندق الحالي']
        }
        ]
    },
    {
        name: 'مركز الأعمال الدولي',
        city: 'أبوظبي',
        type: 'منطقة الكورنيش',
        units: 60,
        floors: 30,
        year: 2016,
        area: 18000,
        share: 20,
        value: 3900000,
        rent: 28000,
        status: 'قيد المراجعة',
        propId: 'PRO-005',
        ownDate: '2022-06-18',
        propNo: '٥٢٣٠/هـ',
        mahder: 'محضر رقم ٢٣٠/١٤٣٩',
        division: 'مركز أعمال على شارعين',
        geo: 'https://maps.google.com',
        details: 'مبنى مكاتب دولية في منطقة مالية نشطة، يضم شركات متعددة الجنسيات وبمساحات مكتبية مرنة.',
        opsCount: 1,
        opsDetails: [
        '25/03/2025 — مراجعة شاملة للعقود الحالية وخطط إعادة التأجير.'
        ],
        payments: 'دفعة واحدة مبدئية قيد التسوية',
        signals: [
        {
            signalId: 'SIG-005',
            no: 'A-22105',
            date: '2025-06-17',
            type: 'مراجعة',
            notes: 'مراجعة عقارية إدارية لمركز الأعمال الدولي — مطابق لمعلومات تقرير الإشارات.',
            owners: ['هيئة المحفظة — أبوظبي'],
            defendants: []
        }
        ]
    },
    {
        name: 'بوابة الرياض التجارية',
        city: 'الرياض',
        type: 'طريق الملك فهد',
        units: 40,
        floors: 14,
        year: 2021,
        area: 11200,
        share: 38,
        value: 7200000,
        rent: 22000,
        status: 'نشط',
        propId: 'PRO-006',
        ownDate: '2017-09-30',
        propNo: '٦١٨٩/و',
        mahder: 'محضر رقم ٣١٢/١٤٤٣',
        division: 'مركز تجاري ومكاتب',
        geo: 'https://maps.google.com',
        details: 'مبنى تجاري حديث على طريق الملك فهد، يضم معارض تجارية في الأدوار السفلية ومكاتب في الأدوار العليا.',
        opsCount: 3,
        opsDetails: [
        '02/02/2025 — افتتاح معرض جديد للعلامات الفاخرة.',
        '18/03/2025 — تحديث أنظمة التكييف المركزية.',
        '29/05/2025 — إعادة تقسيم بعض المساحات المكتبية.'
        ],
        payments: '٣ دفعات مجدولة خلال العام',
        signals: [
        {
            signalId: 'SIG-006',
            no: 'A-23144',
            date: '2025-09-09',
            type: 'دعوى',
            notes: 'نزاع على إيقاف أعمال تأجير جزئية — مطابق لمعلومات تقرير الإشارات.',
            owners: ['شركة بوابة الرياض القابضة'],
            defendants: ['مستأجر سابق — محل رقم ٤']
        }
        ]
    },
    {
        name: 'أبراج جدة الإدارية',
        city: 'جدة',
        type: 'حي الرويس',
        units: 55,
        floors: 25,
        year: 2017,
        area: 14500,
        share: 25,
        value: 5100000,
        rent: 26000,
        status: 'نشط',
        propId: 'PRO-007',
        ownDate: '2023-02-14',
        propNo: '٧٠٢٤/ز',
        mahder: 'محضر رقم ١١٠/١٤٤٠',
        division: 'أبراج مكتبية متجاورة',
        geo: 'https://maps.google.com',
        details: 'مجمع أبراج مكتبية بالقرب من المراكز الحيوية، مع ردهات استقبال واسعة وأنظمة أمن ومواقف تحت الأرض.',
        opsCount: 2,
        opsDetails: [
        '07/01/2025 — ترقية أنظمة المراقبة الأمنية.',
        '21/04/2025 — إعادة تصميم بهو الاستقبال الرئيسي.'
        ],
        payments: '٢ دفعة مسددة من أصل ٣',
        signals: [
        {
            signalId: 'SIG-007',
            no: 'A-24008',
            date: '2025-11-02',
            type: 'صلح',
            notes: 'مسار صلح قبل الدعوى — مطابق لمعلومات تقرير الإشارات.',
            owners: ['شركة مسارات جدة للعقارات'],
            defendants: ['مقاول واجهات زجاجية']
        }
        ]
    },
    {
        name: 'فيلات بيوت الشمال',
        city: 'الرياض',
        type: 'حي الياسمين',
        units: 18,
        floors: 3,
        year: 2022,
        area: 9000,
        share: 60,
        value: 6800000,
        rent: 12000,
        status: 'نشط',
        propId: 'PRO-008',
        ownDate: '2016-04-25',
        propNo: '٨١٥٠/ح',
        mahder: 'محضر رقم ١٧٥/١٤٤٤',
        division: 'مجمع فلل سكنية',
        geo: 'https://maps.google.com',
        details: 'مجموعة فلل سكنية حديثة التصميم بواجهات عصرية، مخصصة لسكن العائلات مع حدائق ومساحات خارجية خاصة.',
        opsCount: 3,
        opsDetails: [
        '11/02/2025 — تسليم فلل جديدة للمستأجرين.',
        '30/03/2025 — أعمال تنسيق حدائق إضافية.',
        '19/06/2025 — إضافة كاميرات مراقبة على المداخل.'
        ],
        payments: '٣ دفعات شهرية منتظمة',
        signals: [
        {
            signalId: 'SIG-008',
            no: 'A-25090',
            date: '2025-05-29',
            type: 'حجز',
            notes: 'حجز وفق تنبيه بنكي على جزء من المجمع — مطابق لمعلومات تقرير الإشارات.',
            owners: ['جمعية ملاك بيوت الشمال'],
            defendants: ['البنك الأهلي — إدارة التحصيل']
        }
        ]
    },
    {
        name: 'مجمع دبي للأعمال',
        city: 'دبي',
        type: 'منطقة الخليج التجاري',
        units: 72,
        floors: 35,
        year: 2014,
        area: 22000,
        share: 15,
        value: 3200000,
        rent: 35000,
        status: 'جزئي',
        propId: 'PRO-009',
        ownDate: '2024-08-01',
        propNo: '٩٠٠٢/ط',
        mahder: 'محضر رقم ٢٨٠/١٤٣٨',
        division: 'برج أعمال متعدد الاستخدام',
        geo: 'https://maps.google.com',
        details: 'برج أعمال في قلب منطقة الخليج التجاري، يضم مكاتب ومعارض وقاعات اجتماعات بإطلالات مفتوحة.',
        opsCount: 4,
        opsDetails: [
        '09/01/2025 — إعادة هيكلة عقود بعض المستأجرين.',
        '14/03/2025 — توسعة قاعة الاجتماعات الرئيسية.',
        '27/05/2025 — تحسين مساحات الخدمات المشتركة.',
        '08/07/2025 — إضافة لوحة إرشادية رقمية في البهو.'
        ],
        payments: '٤ دفعات ربع سنوية',
        signals: [
        {
            signalId: 'SIG-009',
            no: 'A-26011',
            date: '2025-10-14',
            type: 'إنذار',
            notes: 'إنذار بسبب تأخر أقساط الخدمات المشتركة — مطابق لمعلومات تقرير الإشارات.',
            owners: ['إدارة البرج — دبي'],
            defendants: ['شركة تأجير المساحات المشتركة']
        }
        ]
    },
    {
        name: 'برج المنارة السكني',
        city: 'الدمام',
        type: 'حي المنار',
        units: 64,
        floors: 16,
        year: 2019,
        area: 16800,
        share: 40,
        value: 4900000,
        rent: 9000,
        status: 'نشط',
        propId: 'PRO-010',
        ownDate: '2015-12-20',
        propNo: '١٠١٥٥/ي',
        mahder: 'محضر رقم ٣٢٠/١٤٤١',
        division: 'برج شقق سكنية',
        geo: 'https://maps.google.com',
        details: 'برج سكني متوسط الارتفاع بالقرب من الخدمات الأساسية، يضم شققاً متوسطة المساحة بمواقف مخصصة.',
        opsCount: 2,
        opsDetails: [
        '03/02/2025 — تركيب مصاعد جديدة عالية الكفاءة.',
        '25/05/2025 — إعادة طلاء الممرات والأدوار المشتركة.'
        ],
        payments: '٢ دفعة سنوية مستلمة',
        signals: [
        {
            signalId: 'SIG-010',
            no: 'A-27033',
            date: '2025-07-06',
            type: 'مخالفة',
            notes: 'مخالفة بلدية مؤقتة في مواقف الزوار — مطابق لمعلومات تقرير الإشارات.',
            owners: ['شركة المنارة الإسكانية'],
            defendants: ['بلدية المنطقة الشرقية']
        }
        ]
    },
    {
        name: 'مركز أبوظبي المالي',
        city: 'أبوظبي',
        type: 'المنطقة المالية',
        units: 45,
        floors: 28,
        year: 2013,
        area: 13500,
        share: 18,
        value: 2800000,
        rent: 30000,
        status: 'قيد المراجعة',
        propId: 'PRO-011',
        ownDate: '2020-05-07',
        propNo: '١١٢٠٠/ك',
        mahder: 'محضر رقم ١٥٠/١٤٣٧',
        division: 'مبنى مكاتب رئيسية',
        geo: 'https://maps.google.com',
        details: 'مبنى مكاتب لشركات مالية واستثمارية، مزود بقاعات اجتماعات تنفيذية وخدمات استقبال على مدار الساعة.',
        opsCount: 1,
        opsDetails: [
        '18/04/2025 — مراجعة عقود شركات الخدمات والدعم اللوجستي.'
        ],
        payments: 'دفعة مراجعة قيد الاعتماد',
        signals: [
        {
            signalId: 'SIG-011',
            no: 'A-28077',
            date: '2025-12-01',
            type: 'تدقيق',
            notes: 'تدقيق داخلي للعقود المالية بالمركز — مطابق لمعلومات تقرير الإشارات.',
            owners: ['مكتب الالتزام — أبوظبي'],
            defendants: []
        }
        ]
    },
    {
        name: 'الحي الذهبي السكني',
        city: 'جدة',
        type: 'حي الشاطئ الذهبي',
        units: 32,
        floors: 8,
        year: 2023,
        area: 8400,
        share: 55,
        value: 5600000,
        rent: 11000,
        status: 'نشط',
        propId: 'PRO-012',
        ownDate: '2019-03-17',
        propNo: '١٢٠٥٥/ل',
        mahder: 'محضر رقم ٤٢٥/١٤٤٤',
        division: 'مجمع شقق فاخرة',
        geo: 'https://maps.google.com',
        details: 'مجمع سكني فاخر بإطلالة بحرية، يضم شققاً ذات تشطيبات عالية المستوى ومرافق ترفيهية للسكان.',
        opsCount: 3,
        opsDetails: [
        '06/01/2025 — إطلاق خدمة الاستقبال على مدار الساعة.',
        '17/03/2025 — إضافة نادي صحي ومسبح داخلي.',
        '12/06/2025 — حملات تسويق للوحدات الفارغة.'
        ],
        payments: '٣ دفعات فندقية قيد التحصيل',
        signals: [
        {
            signalId: 'SIG-012',
            no: 'A-29120',
            date: '2025-03-08',
            type: 'دعوى',
            notes: 'دعوى بسبب تأخر تسليم وحدات مؤجَّرة سياحياً — مطابق لمعلومات تقرير الإشارات.',
            owners: ['شركة الواجهات الذهبية'],
            defendants: ['شركة تأجير وإدارة وحدات']
        }
        ]
    },
    {
        name: 'مجمع الروضة الفندقي',
        city: 'الرياض',
        type: 'حي الروضة',
        units: 120,
        floors: 20,
        year: 2018,
        area: 32000,
        share: 22,
        value: 9100000,
        rent: 40000,
        status: 'نشط',
        propId: 'PRO-013',
        ownDate: '2021-09-29',
        propNo: '١٣٥٦٠/م',
        mahder: 'محضر رقم ٣٣٠/١٤٤٠',
        division: 'مجمع فندقي وشقق مخدومة',
        geo: 'https://maps.google.com',
        details: 'مجمع فندقي يحتوي على غرف فندقية وشقق مخدومة طويلة الأمد مع خدمات استقبال ونظافة.',
        opsCount: 4,
        opsDetails: [
        '04/02/2025 — تحديث نظام الحجز الإلكتروني.',
        '22/03/2025 — عقد صيانة شامل للأدوار العليا.',
        '09/05/2025 — إضافة خدمة نقل من وإلى المطار.',
        '28/07/2025 — ترقية أثاث بعض الشقق المخدومة.'
        ],
        payments: '٤ دفعات شهرية من شركات التعاقد',
        signals: [
        {
            signalId: 'SIG-013',
            no: 'A-30005',
            date: '2025-06-26',
            type: 'استيفاء جزئي',
            notes: 'سداد جزئي لرسوم الطاقة — مطابق لمعلومات تقرير الإشارات.',
            owners: ['شركة تشغيل الروضة الفندقي'],
            defendants: ['شركة المرافق الموحَّدة']
        }
        ]
    },
    {
        name: 'برج الخليج للأعمال',
        city: 'دبي',
        type: 'واجهة الخليج',
        units: 90,
        floors: 42,
        year: 2015,
        area: 26000,
        share: 12,
        value: 4500000,
        rent: 38000,
        status: 'جزئي',
        propId: 'PRO-014',
        ownDate: '2018-06-11',
        propNo: '١٤٢٢٠/ن',
        mahder: 'محضر رقم ٢٧٠/١٤٣٩',
        division: 'برج مكاتب على الواجهة البحرية',
        geo: 'https://maps.google.com',
        details: 'برج أعمال على الواجهة البحرية مع إطلالات بانورامية، يضم مكاتب للشركات العالمية ومرافق مشتركة راقية.',
        opsCount: 2,
        opsDetails: [
        '13/03/2025 — إعادة تأجير طابق كامل لشركة دولية.',
        '30/06/2025 — أعمال صيانة للمرسى القريب من البرج.'
        ],
        payments: '٢ دفعة نصف سنوية',
        signals: [
        {
            signalId: 'SIG-014',
            no: 'A-31088',
            date: '2025-11-19',
            type: 'تحكيم',
            notes: 'اتفاق تحكيم لحسم نسب الإيرادات — مطابق لمعلومات تقرير الإشارات.',
            owners: ['شركة أبراج الخليج دبي'],
            defendants: ['شريك تشغيل دولي — فرع المنطقة']
        }
        ]
    },
    ];

    /** أصحاب الحصص لكل عقار (معرّف مالك من تقرير المالك + نسبة تقريبية) */
    const buildingOwnerStakes = {
    'PRO-001': [{ ownerId: 'OWN-003', share: '42%' }, { ownerId: 'OWN-017', share: '33%' }, { ownerId: 'OWN-001', share: '25%' }],
    'PRO-002': [{ ownerId: 'OWN-004', share: '100%' }],
    'PRO-003': [{ ownerId: 'OWN-002', share: '72%' }, { ownerId: 'OWN-018', share: '28%' }],
    'PRO-004': [{ ownerId: 'OWN-005', share: '100%' }],
    'PRO-005': [{ ownerId: 'OWN-006', share: '100%' }],
    'PRO-006': [{ ownerId: 'OWN-007', share: '100%' }],
    'PRO-007': [{ ownerId: 'OWN-008', share: '100%' }],
    'PRO-008': [{ ownerId: 'OWN-009', share: '100%' }],
    'PRO-009': [{ ownerId: 'OWN-010', share: '100%' }],
    'PRO-010': [{ ownerId: 'OWN-011', share: '100%' }],
    'PRO-011': [{ ownerId: 'OWN-012', share: '100%' }],
    'PRO-012': [{ ownerId: 'OWN-013', share: '100%' }],
    'PRO-013': [{ ownerId: 'OWN-014', share: '58%' }, { ownerId: 'OWN-019', share: '42%' }],
    'PRO-014': [{ ownerId: 'OWN-015', share: '100%' }]
    };

    const totalAreaAll = buildings.reduce((sum, b) => sum + (b.area || 0), 0);
    let filteredData = [...buildings];
    /** صفوف تفصيل العقارات (خرطة، ملاحظات، دفعات…) */
    let propertyExpandedKeys = new Set();
    let rowsLimit = 'all'; // rows per page ('all' = no limit)
    let currentPage = 1;
    let selectedProps = new Set();
    let multiSelectEnabled = false;
    let selectedCountriesFilter = new Set();
    let selectedCitiesFilter = new Set();
    let selectedTypesFilter = new Set();
    let selectedSubTypesFilter = new Set();
    let selectedAreasFilter = new Set();
    let propCreatedFrom = '';
    let propCreatedTo = '';
    let propOwnFrom = '';
    let propOwnTo = '';
    let propEnteredBy = '';
    let propUpdatedFrom = '';
    let propUpdatedTo = '';
    let selectedOpStatusFilter = new Set();
    let selectedPaymentFinanceFilter = new Set();
    const countryGovernorates = {
    'سورية': ['دمشق', 'حلب', 'حمص', 'اللاذقية', 'حماة', 'طرطوس', 'السويداء', 'دير الزور'],
    'الامارات': ['أبوظبي', 'دبي', 'الشارقة', 'عجمان', 'رأس الخيمة', 'الفجيرة', 'أم القيوين'],
    'أخرى': []
    };
    // فلتر العقار — 3 main categories
    const propertyKinds = ['أرض', 'سكن', 'تجاري'];
    // فلتر نوع العقار — sub-types per category
    const propertySubTypes = {
    'أرض':   ['زراعية', 'سكنية'],
    'سكن':   ['منزل', 'فيلا'],
    'تجاري': ['مجمع', 'دكان', 'مول', 'مطعم', 'أخرى']
    };
    // Per-building type assignments
    const buildingTypeData = {
    'PRO-001': { category: 'تجاري',  subType: 'مجمع'  },
    'PRO-002': { category: 'سكن',    subType: 'فيلا'  },
    'PRO-003': { category: 'تجاري',  subType: 'مول'   },
    'PRO-004': { category: 'تجاري',  subType: 'أخرى'  },
    'PRO-005': { category: 'تجاري',  subType: 'مجمع'  },
    'PRO-006': { category: 'تجاري',  subType: 'دكان'  },
    'PRO-007': { category: 'تجاري',  subType: 'مجمع'  },
    'PRO-008': { category: 'سكن',    subType: 'فيلا'  },
    'PRO-009': { category: 'تجاري',  subType: 'مجمع'  },
    'PRO-010': { category: 'سكن',    subType: 'منزل'  },
    'PRO-011': { category: 'تجاري',  subType: 'مول'   },
    'PRO-012': { category: 'سكن',    subType: 'منزل'  },
    'PRO-013': { category: 'تجاري',  subType: 'مطعم'  },
    'PRO-014': { category: 'أرض',    subType: 'سكنية' }
    };
    const defaultResponsiblePeople = [
    'أحمد العلي',
    'محمود الخطيب',
    'سارة الحسن',
    'ليث درويش',
    'ريم الشامي',
    'نور المصري'
    ];
    const defaultEnteredBy = ['سارة', 'نور', 'أحمد', 'خالد', 'ريم', 'ليث'];
    function getEnteredByOfBuilding(b, idx) {
    if (b.enteredBy) return b.enteredBy;
    return defaultEnteredBy[idx % defaultEnteredBy.length];
    }

    function inferCountryFromCity(city) {
    if (countryGovernorates['سورية'].includes(city)) return 'سورية';
    if (countryGovernorates['الامارات'].includes(city)) return 'الامارات';
    return 'أخرى';
    }

    function getCountryOfBuilding(b) {
    return b.country || inferCountryFromCity(b.city);
    }

    function getPropertyKindOfBuilding(b, idx) {
    if (b.propertyCategory) return b.propertyCategory;
    const td = buildingTypeData[b.propId];
    if (td) return td.category;
    return propertyKinds[idx % propertyKinds.length];
    }

    function getPropertySubTypeOfBuilding(b, idx) {
    if (b.propertySubType) return b.propertySubType;
    const td = buildingTypeData[b.propId];
    if (td) return td.subType;
    return '';
    }

    function getRegistrationDateOfBuilding(b, idx) {
    if (b.registeredAt) return b.registeredAt;
    const year = 2021 + (idx % 5);
    const month = ((idx % 12) + 1).toString().padStart(2, '0');
    const day = ((idx % 28) + 1).toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
    }

    function getResponsiblePersonOfBuilding(b, idx) {
    if (b.responsiblePerson) return b.responsiblePerson;
    return defaultResponsiblePeople[idx % defaultResponsiblePeople.length];
    }

    function fmt(n) {
    return n.toLocaleString('ar-SA');
    }

    function formatShareOutOf2400(rawShare) {
    if (rawShare == null) return '—';
    const westernDigits = String(rawShare)
        .replace(/[٠-٩]/g, d => '٠١٢٣٤٥٦٧٨٩'.indexOf(d))
        .replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d));
    const match = westernDigits.match(/\d+(?:\.\d+)?/);
    if (!match) return '—';
    const parsed = Number(match[0]);
    if (!isFinite(parsed)) return '—';
    return `${Math.trunc(parsed)}/2400 سهم`;
    }

    /** عرض حصة العقار للجدول: النسبة % تُحسب من أصل 2400 سهمًا */
    function formatStakeForDisplay(rawShare) {
    if (rawShare == null || rawShare === '') return '—';
    const str = String(rawShare).trim();
    const western = str
        .replace(/[٠-٩]/g, d => '٠١٢٣٤٥٦٧٨٩'.indexOf(d))
        .replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d));
    if (/%/.test(western) || /٪/.test(str)) {
        const m = western.match(/(\d+(?:\.\d+)?)/);
        if (!m) return '—';
        const pct = Number(m[1]);
        if (!isFinite(pct) || pct < 0) return '—';
        const shares = Math.round((pct / 100) * 2400);
        return `${Math.min(2400, Math.max(0, shares))}/2400 سهم`;
    }
    const slash = western.match(/^(\d+)\s*\/\s*2400/);
    if (slash) {
        const n = Math.min(2400, Math.max(0, parseInt(slash[1], 10)));
        return `${n}/2400 سهم`;
    }
    const plain = western.match(/^\s*(\d+)\s*$/);
    if (plain) {
        const v = parseInt(plain[1], 10);
        if (v >= 0 && v <= 2400) return `${v}/2400 سهم`;
    }
    return formatShareOutOf2400(rawShare);
    }

    const PREF_KEY = 'realestate_prefs';
    const DEFAULT_USD_RATES = {
    LBP: 124,
    AED: 3.67
    };
    const CURRENCY_LABELS = {
    USD: 'USD',
    LBP: 'ليرة سورية',
    AED: 'درهم إماراتي'
    };

    function getPrefs() {
    try {
        return JSON.parse(localStorage.getItem(PREF_KEY)) || {};
    } catch {
        return {};
    }
    }

    function savePrefs(p) {
    localStorage.setItem(PREF_KEY, JSON.stringify(p));
    }

    function getExchangeRateFor(currency) {
    if (currency === 'USD') return 1;
    const p = getPrefs();
    const rates = p.exchangeRates || {};
    const customRate = Number(rates[currency]);
    if (isFinite(customRate) && customRate > 0) return customRate;
    return DEFAULT_USD_RATES[currency] || 1;
    }

    function updateCurrencyRateUi(currency) {
    const activeCurrency = currency || getPrefs().currency || 'USD';
    const rd = document.getElementById('rate-display');
    const rc = document.getElementById('rate-currency-name');
    const ri = document.getElementById('rate-input');
    const rate = getExchangeRateFor(activeCurrency);
    if (rd) {
        rd.textContent = rate.toLocaleString('ar-SA', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
    if (rc) rc.textContent = CURRENCY_LABELS[activeCurrency] || activeCurrency;
    if (ri) {
        ri.value = String(rate);
        ri.disabled = activeCurrency === 'USD';
        ri.title = activeCurrency === 'USD' ? 'الدولار هو العملة الأساسية' : '';
    }
    }

    function formatAreaFromM2(m2) {
    if (typeof m2 !== 'number' || !isFinite(m2)) return '—';
    const p = getPrefs();
    if (p.area === 'ft2') {
        return fmt(Math.round(m2 * 10.76391041671)) + ' قدم²';
    }
    return fmt(m2) + ' م²';
    }

    function formatUsdMoney(usd) {
    if (usd == null || !isFinite(usd)) return '—';
    const p = getPrefs();
    const selected = p.currency || 'USD';
    if (selected === 'USD') {
        return usd.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '\u202F$';
    }
    const converted = usd * getExchangeRateFor(selected);
    return converted.toLocaleString('ar-SA', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' ' + (CURRENCY_LABELS[selected] || selected);
    }

    function parseUsdAmount(value) {
    if (typeof value === 'number' && isFinite(value)) return value;
    if (typeof value !== 'string') return 0;
    const normalized = value.replace(/,/g, '').replace(/[^\d.]/g, '');
    const num = Number(normalized);
    return isFinite(num) ? num : 0;
    }

    function shiftDateDays(isoDate, delta) {
    if (!isoDate || typeof isoDate !== 'string') return '';
    const t = Date.parse(isoDate);
    if (!isFinite(t)) return isoDate;
    const d = new Date(t + delta * 86400000);
    return d.toISOString().slice(0, 10);
    }

    function togglePropertyExpand(propNo, section) {
    const id = String(propNo) + '\x1e' + section;
    if (propertyExpandedKeys.has(id)) propertyExpandedKeys.delete(id);
    else propertyExpandedKeys.add(id);
    renderTable();
    }

    function isPropertyExpandOpen(propNo, section) {
    return propertyExpandedKeys.has(String(propNo) + '\x1e' + section);
    }

    function getVisiblePropertyColCount() {
    let n = 1;
    columnOrder.forEach(cls => {
        const key = cls.replace('col-', '');
        if (colVisible[key]) n++;
    });
    return n;
    }

    function operationalStatusBadge(s) {
    const map = {
        'يعمل': 'status-active',
        'جاري صيانته': 'status-partial',
        'متوقف عن العمل': 'status-pending'
    };
    const dot = { 'يعمل': '●', 'جاري صيانته': '◑', 'متوقف عن العمل': '○' };
    const v = String(s || '—');
    return `<span class="status-badge ${map[v] || 'status-pending'}">${dot[v] || '○'} ${v}</span>`;
    }

    function hydrateBuildingPortalFields() {
    const SAR_TO_USD = 3.75; // b.value is stored in SAR
    buildings.forEach((b, idx) => {
        const totalValSar = typeof b.value === 'number' && isFinite(b.value) ? b.value : 0;
        // Derive USD price via correct SAR→USD rate if not already in the data
        if (b.approxPriceUsd == null) b.approxPriceUsd = Math.round(totalValSar / SAR_TO_USD);
        if (b.actualPriceUsd  == null) b.actualPriceUsd  = Math.round(totalValSar / SAR_TO_USD);
        // Use the USD price as the single source of truth for all payment maths
        const totalValUsd = Number(b.approxPriceUsd) || Number(b.actualPriceUsd) || 0;
        // paid is already in USD (paymentsUsd)
        const paid = Array.isArray(b.paymentsUsd) && b.paymentsUsd.length
        ? b.paymentsUsd.reduce((sum, p) => sum + (Number(p.amountUsd) || 0), 0)
        : parseUsdAmount(b.totalPaymentsUsd);
        if (!b.createdAt) b.createdAt = getRegistrationDateOfBuilding(b, idx);
        if (!b.updatedAt) b.updatedAt = shiftDateDays(b.createdAt, 10 + (idx % 21));
        if (!b.enteredBy) b.enteredBy = getEnteredByOfBuilding(b, idx);
        if (!b.operationalStatus) {
        if (b.status === 'نشط') b.operationalStatus = 'يعمل';
        else if (b.status === 'جزئي') b.operationalStatus = 'جاري صيانته';
        else b.operationalStatus = 'متوقف عن العمل';
        }
        // paymentFinanceStatus: compare paid (USD) vs totalValUsd (USD) — same unit
        if (!b.paymentFinanceStatus) {
        b.paymentFinanceStatus = (totalValUsd > 0 && paid >= totalValUsd * 0.97)
            ? 'مدفوع بشكل كامل' : 'جزئي';
        }
        // Remainder in USD — can never exceed total
        const remUsd = Math.max(0, totalValUsd - paid);
        if (b.paymentRemainderUsd == null) b.paymentRemainderUsd = remUsd;
        if (!b.paymentRemainderLabel) {
        b.paymentRemainderLabel = remUsd <= 1
            ? 'لا يوجد'
            : `${Math.round(remUsd).toLocaleString('en-US')}\u202F$`;
        }
        if (!b.paymentDetailBlurb) {
        const lastPay = Array.isArray(b.paymentsUsd) && b.paymentsUsd.length
            ? b.paymentsUsd[b.paymentsUsd.length - 1].date : '';
        if (b.paymentFinanceStatus === 'مدفوع بشكل كامل') {
            b.paymentDetailBlurb = lastPay
            ? `اكتملت الدفعات بتاريخ ${lastPay}`
            : 'اكتملت الدفعات وفق الجدول';
        } else if (Array.isArray(b.paymentsUsd) && b.paymentsUsd.length >= 2) {
            const a = Number(b.paymentsUsd[0].amountUsd) || 0;
            const c = Number(b.paymentsUsd[1].amountUsd) || 0;
            b.paymentDetailBlurb = `دفعتين: ${Math.round(a).toLocaleString('en-US')}\u202F$ (${b.paymentsUsd[0].date}) و${Math.round(c).toLocaleString('en-US')}\u202F$ (${b.paymentsUsd[1].date})`;
        } else {
            b.paymentDetailBlurb = String(b.payments || 'دفعات جزئية — راجع تقرير المالية');
        }
        }
        const stakes = buildingOwnerStakes[b.propId];
        if (stakes && stakes.length && !b.propertyOwners) b.propertyOwners = stakes.slice();
    });
    }

    function renderFinancialOverviewStats() {
    const totalEl = document.getElementById('stat-total-value');
    const paidEl = document.getElementById('stat-paid-value');
    const remainingEl = document.getElementById('stat-remaining-value');
    if (!totalEl || !paidEl || !remainingEl) return;

    const usdRate = 3.75; // قيمة البيانات المخزنة في value
    const totalPortfolioUsd = buildings.reduce((sum, b) => {
        const usd = typeof b.value === 'number' && isFinite(b.value) ? (b.value / usdRate) : 0;
        return sum + usd;
    }, 0);

    const totalPaymentsUsd = buildings.reduce((sum, b) => {
        if (Array.isArray(b.paymentsUsd) && b.paymentsUsd.length) {
        return sum + b.paymentsUsd.reduce((inner, pay) => inner + (Number(pay.amountUsd) || 0), 0);
        }
        return sum + parseUsdAmount(b.totalPaymentsUsd);
    }, 0);

    const remainingUsd = Math.max(0, totalPortfolioUsd - totalPaymentsUsd);
    totalEl.textContent = formatUsdMoney(totalPortfolioUsd);
    paidEl.textContent = formatUsdMoney(totalPaymentsUsd);
    remainingEl.textContent = formatUsdMoney(remainingUsd);
    renderFinancialRemainingChart();
    renderFinancialGeoCostChart();
    }

    function renderFinancialRemainingChart() {
    const chartRoot = document.getElementById('financial-remaining-chart');
    if (!chartRoot) return;

    const usdRate = 3.75;
    const topRows = buildings
        .map((b, idx) => {
        const totalUsd = typeof b.value === 'number' && isFinite(b.value) ? (b.value / usdRate) : 0;
        const paidUsd = Array.isArray(b.paymentsUsd) && b.paymentsUsd.length
            ? b.paymentsUsd.reduce((sum, pay) => sum + (Number(pay.amountUsd) || 0), 0)
            : parseUsdAmount(b.totalPaymentsUsd);
        const remainingUsd = Math.max(0, totalUsd - paidUsd);
        return {
            idx,
            label: b.propNo || `عقار ${idx + 1}`,
            remainingUsd
        };
        })
        .sort((a, b) => b.remainingUsd - a.remainingUsd)
        .slice(0, 6);

    const maxRemaining = topRows.reduce((max, row) => Math.max(max, row.remainingUsd), 0);
    chartRoot.innerHTML = '';

    if (!topRows.length || maxRemaining <= 0) {
        chartRoot.innerHTML = '<div class="chart-sub">لا توجد بيانات كافية لعرض المخطط.</div>';
        return;
    }

    topRows.forEach((row) => {
        const wrap = document.createElement('div');
        wrap.className = 'bar-wrap';

        const bar = document.createElement('div');
        bar.className = 'bar';
        bar.style.height = `${Math.max(12, (row.remainingUsd / maxRemaining) * 100)}%`;
        bar.style.background = 'linear-gradient(180deg, var(--gold-bright), var(--gold-deep))';
        bar.title = `${row.label}: ${formatUsdMoney(row.remainingUsd)}`;

        const value = document.createElement('div');
        value.className = 'bar-val';
        value.textContent = formatUsdMoney(row.remainingUsd);

        const label = document.createElement('div');
        label.className = 'bar-label';
        label.textContent = row.label;

        wrap.appendChild(bar);
        wrap.appendChild(value);
        wrap.appendChild(label);
        chartRoot.appendChild(wrap);
    });
    }

        

                <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900">
        
    function renderFinancialGeoCostChart() {
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">التقارير المالية</h2>
        
    const root = document.getElementById('financial-geo-cost-chart');
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">قريباً — سيتم الربط في المرحلة القادمة.</p>
        
    if (!root) return;
    const usdRate = 3.75;
    const byCity = {};
    buildings.forEach((b) => {
        const city = b.city || 'غير محدد';
        const usd = typeof b.value === 'number' && isFinite(b.value) ? (b.value / usdRate) : 0;
        byCity[city] = (byCity[city] || 0) + usd;
    });
    const rows = Object.entries(byCity)
        .map(([label, value]) => ({ label, value }))
        .sort((a, b) => b.value - a.value)
        .slice(0, 6);

    renderSimpleBars(root, rows, [
        'linear-gradient(180deg, var(--gold-bright), var(--gold-deep))',
        'linear-gradient(180deg, #60a5fa, #2563eb)',
        'linear-gradient(180deg, #34d399, #059669)',
        'linear-gradient(180deg, #f59e0b, #b45309)'
    ]);
    }

    function renderSimpleBars(rootEl, rows, palette) {
    if (!rootEl) return;
    const safeRows = Array.isArray(rows) ? rows : [];
    const maxValue = safeRows.reduce((max, row) => Math.max(max, Number(row.value) || 0), 0);
    rootEl.innerHTML = '';

    if (!safeRows.length || maxValue <= 0) {
        rootEl.innerHTML = '<div class="chart-sub">لا توجد بيانات كافية لعرض المخطط.</div>';
        return;
    }

    safeRows.forEach((row, idx) => {
        const wrap = document.createElement('div');
        wrap.className = 'bar-wrap';

        const bar = document.createElement('div');
        bar.className = 'bar';
        bar.style.height = `${Math.max(12, ((Number(row.value) || 0) / maxValue) * 100)}%`;
        bar.style.background = palette[idx % palette.length];
        bar.title = `${row.label}: ${Number(row.value || 0).toLocaleString('ar-SA')}`;

        const value = document.createElement('div');
        value.className = 'bar-val';
        value.textContent = Number(row.value || 0).toLocaleString('ar-SA');

        const label = document.createElement('div');
        label.className = 'bar-label';
        label.textContent = row.label;

        wrap.appendChild(bar);
        wrap.appendChild(value);
        wrap.appendChild(label);
        rootEl.appendChild(wrap);
    });
    }

    function renderLegalDonut(svgEl, legendEl, rows) {
    if (!svgEl || !legendEl) return;
    const safeRows = Array.isArray(rows) ? rows : [];
    const total = safeRows.reduce((s, r) => s + (Number(r.value) || 0), 0);
    svgEl.innerHTML = '';
    legendEl.innerHTML = '';

    if (!safeRows.length || total <= 0) {
        svgEl.innerHTML = '<text x="160" y="100" fill="#9ca3af" text-anchor="middle" font-size="12">لا توجد بيانات كافية</text>';
        return;
    }

    const colors = ['#D4AF37', '#C49A2A', '#8B6914', '#60a5fa', '#34d399', '#f87171'];
    const cx = 90;
    const cy = 100;
    const r = 58;
    const c = 2 * Math.PI * r;
    let offset = 0;

    const base = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    base.setAttribute('cx', String(cx));
    base.setAttribute('cy', String(cy));
    base.setAttribute('r', String(r));
    base.setAttribute('fill', 'none');
    base.setAttribute('stroke', 'rgba(148,163,184,.25)');
    base.setAttribute('stroke-width', '18');
    svgEl.appendChild(base);

    safeRows.forEach((row, idx) => {
        const value = Number(row.value) || 0;
        const length = (value / total) * c;
        const seg = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
        seg.setAttribute('cx', String(cx));
        seg.setAttribute('cy', String(cy));
        seg.setAttribute('r', String(r));
        seg.setAttribute('fill', 'none');
        seg.setAttribute('stroke', colors[idx % colors.length]);
        seg.setAttribute('stroke-width', '18');
        seg.setAttribute('stroke-linecap', 'round');
        seg.setAttribute('stroke-dasharray', `${Math.max(0, length - 1)} ${c}`);
        seg.setAttribute('stroke-dashoffset', String(-offset));
        seg.setAttribute('transform', `rotate(-90 ${cx} ${cy})`);
        svgEl.appendChild(seg);
        offset += length;

        const legendItem = document.createElement('span');
        legendItem.className = 'legal-legend-item';
        legendItem.innerHTML = `<span class="legal-legend-swatch" style="background:${colors[idx % colors.length]}"></span>${row.label} (${Math.round((value / total) * 100)}٪)`;
        legendEl.appendChild(legendItem);
    });

    const centerMain = document.createElementNS('http://www.w3.org/2000/svg', 'text');
    centerMain.setAttribute('x', String(cx));
    centerMain.setAttribute('y', '95');
    centerMain.setAttribute('text-anchor', 'middle');
    centerMain.setAttribute('fill', '#D4AF37');
    centerMain.setAttribute('font-size', '22');
    centerMain.setAttribute('font-weight', '700');
    centerMain.textContent = total.toLocaleString('ar-SA');
    svgEl.appendChild(centerMain);

    const centerSub = document.createElementNS('http://www.w3.org/2000/svg', 'text');
    centerSub.setAttribute('x', String(cx));
    centerSub.setAttribute('y', '112');
    centerSub.setAttribute('text-anchor', 'middle');
    centerSub.setAttribute('fill', '#9ca3af');
    centerSub.setAttribute('font-size', '11');
    centerSub.textContent = 'إجمالي الإشارات';
    svgEl.appendChild(centerSub);
    }

    function renderLegalTrend(svgEl, rows) {
    if (!svgEl) return;
    const safeRows = Array.isArray(rows) ? rows : [];
    svgEl.innerHTML = '';
    if (!safeRows.length) {
        svgEl.innerHTML = '<text x="160" y="100" fill="#9ca3af" text-anchor="middle" font-size="12">لا توجد بيانات كافية</text>';
        return;
    }

    const w = 320;
    const h = 200;
    const padX = 26;
    const padY = 24;
    const innerW = w - padX * 2;
    const innerH = h - padY * 2;
    const maxValue = Math.max(1, ...safeRows.map(r => Number(r.value) || 0));
    const points = safeRows.map((row, i) => {
        const x = padX + (i * innerW) / Math.max(1, safeRows.length - 1);
        const y = padY + innerH - ((Number(row.value) || 0) / maxValue) * innerH;
        return { x, y, label: row.label, value: Number(row.value) || 0 };
    });

    const grid = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
    grid.setAttribute('x', String(padX));
    grid.setAttribute('y', String(padY));
    grid.setAttribute('width', String(innerW));
    grid.setAttribute('height', String(innerH));
    grid.setAttribute('fill', 'rgba(148,163,184,.05)');
    grid.setAttribute('stroke', 'rgba(148,163,184,.25)');
    grid.setAttribute('stroke-dasharray', '4 4');
    svgEl.appendChild(grid);

    const poly = document.createElementNS('http://www.w3.org/2000/svg', 'polyline');
    poly.setAttribute('fill', 'none');
    poly.setAttribute('stroke', '#D4AF37');
    poly.setAttribute('stroke-width', '2.5');
    poly.setAttribute('stroke-linejoin', 'round');
    poly.setAttribute('stroke-linecap', 'round');
    poly.setAttribute('points', points.map(p => `${p.x},${p.y}`).join(' '));
    svgEl.appendChild(poly);

    const avg = safeRows.reduce((s, r) => s + (Number(r.value) || 0), 0) / safeRows.length;
    const avgY = padY + innerH - (avg / maxValue) * innerH;
    const avgLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
    avgLine.setAttribute('x1', String(padX));
    avgLine.setAttribute('x2', String(padX + innerW));
    avgLine.setAttribute('y1', String(avgY));
    avgLine.setAttribute('y2', String(avgY));
    avgLine.setAttribute('stroke', '#60a5fa');
    avgLine.setAttribute('stroke-width', '1.2');
    avgLine.setAttribute('stroke-dasharray', '5 4');
    svgEl.appendChild(avgLine);

    points.forEach((p) => {
        const dot = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
        dot.setAttribute('cx', String(p.x));
        dot.setAttribute('cy', String(p.y));
        dot.setAttribute('r', '3');
        dot.setAttribute('fill', '#0b0b0b');
        dot.setAttribute('stroke', '#D4AF37');
        dot.setAttribute('stroke-width', '1.5');
        svgEl.appendChild(dot);

        const label = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        label.setAttribute('x', String(p.x));
        label.setAttribute('y', String(h - 8));
        label.setAttribute('text-anchor', 'middle');
        label.setAttribute('fill', '#9ca3af');
        label.setAttribute('font-size', '10');
        label.textContent = p.label.slice(5).replace('/', '-');
        svgEl.appendChild(label);
    });
    }

    function renderLegalOverviewCharts() {
    const signalDonut = document.getElementById('legal-signal-donut');
    const signalLegend = document.getElementById('legal-signal-legend');
    const trendRoot = document.getElementById('legal-trend-chart');
    const categoryRoot = document.getElementById('legal-category-chart');
    if (!signalDonut || !signalLegend || !trendRoot || !categoryRoot) return;

    const consultations = (AUX_RECORDS_CONFIG.consultations && AUX_RECORDS_CONFIG.consultations.data) || [];
    const owners = (AUX_RECORDS_CONFIG.owners && AUX_RECORDS_CONFIG.owners.data) || [];
    const attachments = (AUX_RECORDS_CONFIG.attachments && AUX_RECORDS_CONFIG.attachments.data) || [];

    const typeCounts = {};
    consultations.forEach((row) => {
        const type = (row && row.signalType) ? row.signalType : 'غير محدد';
        typeCounts[type] = (typeCounts[type] || 0) + 1;
    });
    const signalRows = Object.entries(typeCounts)
        .map(([label, value]) => ({ label, value }))
        .sort((a, b) => b.value - a.value)
        .slice(0, 6);

    renderLegalDonut(signalDonut, signalLegend, signalRows);

    const monthCounts = {};
    [...owners, ...consultations, ...attachments].forEach((row) => {
        if (!row || typeof row.createdAt !== 'string') return;
        const monthKey = row.createdAt.slice(0, 7);
        if (!/^\d{4}-\d{2}$/.test(monthKey)) return;
        monthCounts[monthKey] = (monthCounts[monthKey] || 0) + 1;
    });
    const monthlyRows = Object.entries(monthCounts)
        .sort(([a], [b]) => a.localeCompare(b))
        .slice(-6)
        .map(([month, value]) => ({ label: month.replace('-', '/'), value }));

    renderLegalTrend(trendRoot, monthlyRows);

    renderSimpleBars(categoryRoot, [
        { label: 'المالك', value: owners.length },
        { label: 'استشارات', value: consultations.length },
        { label: 'ملحقات', value: attachments.length }
    ], [
        'linear-gradient(180deg, var(--gold-bright), var(--gold-deep))',
        'linear-gradient(180deg, #60a5fa, #2563eb)',
        'linear-gradient(180deg, #34d399, #059669)'
    ]);

    const totalLegalRecords = owners.length + consultations.length + attachments.length;
    const uniqueUsers = new Set(
        [...owners, ...consultations, ...attachments]
        .map(r => (r && r.enteredBy) ? r.enteredBy : '')
        .filter(Boolean)
    );
    const latestDate = [...owners, ...consultations, ...attachments]
        .map(r => (r && typeof r.createdAt === 'string') ? r.createdAt : '')
        .filter(Boolean)
        .sort()
        .slice(-1)[0] || '';

    const kpiTotal = document.getElementById('legal-kpi-total');
    const kpiSignals = document.getElementById('legal-kpi-signals');
    const kpiUsers = document.getElementById('legal-kpi-users');
    const kpiLatest = document.getElementById('legal-kpi-latest');
    if (kpiTotal) kpiTotal.textContent = totalLegalRecords.toLocaleString('ar-SA');
    if (kpiSignals) kpiSignals.textContent = consultations.length.toLocaleString('ar-SA');
    if (kpiUsers) kpiUsers.textContent = uniqueUsers.size.toLocaleString('ar-SA');
    if (kpiLatest) kpiLatest.textContent = latestDate ? latestDate.replace(/-/g, '/') : '—';

    const signalNote = document.getElementById('legal-signal-type-note');
    if (signalNote) {
        signalNote.textContent = `السجل الأعلى: ${owners.length >= consultations.length && owners.length >= attachments.length ? 'المالك' : consultations.length >= attachments.length ? 'الإشارات' : 'الملحقات'} • إجمالي التقارير: ${totalLegalRecords.toLocaleString('ar-SA')}`;
    }
    const monthlyNote = document.getElementById('legal-monthly-note');
    if (monthlyNote) {
        const avgMonthly = monthlyRows.length ? (monthlyRows.reduce((s, r) => s + r.value, 0) / monthlyRows.length) : 0;
        monthlyNote.textContent = `متوسط الإدخال الشهري: ${avgMonthly.toFixed(1)} تقرير`;
    }
    }

    function collectAllPropertySignals() {
    const rows = [];
    buildings.forEach((b) => {
        const propertySignals = Array.isArray(b.signals) ? b.signals : [];
        propertySignals.forEach((s, idx) => {
        rows.push({
            signalNo: s.signalId || s.no || `SIG-${idx + 1}`,
            date: s.date || '',
            type: s.type || 'غير محدد',
            owners: Array.isArray(s.owners) ? s.owners : [],
            defendants: Array.isArray(s.defendants) ? s.defendants : [],
            mahder: b.mahder || 'غير محدد',
            propertyNo: b.propNo || '—'
        });
        });
    });
    return rows;
    }

    function renderLegalRequestedCharts() {
    const signals = collectAllPropertySignals();
    const sideRoot = document.getElementById('legal-side-count-chart');
    const lastFiveBody = document.getElementById('legal-last-five-signals-body');
    const topMahderRoot = document.getElementById('legal-top-mahder-chart');
    const topOwnerRoot = document.getElementById('legal-top-owner-chart');
    const topDefRoot = document.getElementById('legal-top-defendant-chart');
    if (!sideRoot || !lastFiveBody || !topMahderRoot || !topOwnerRoot || !topDefRoot) return;

    const ownersMentions = signals.reduce((sum, s) => sum + (s.owners.length || 0), 0);
    const defendantsMentions = signals.reduce((sum, s) => sum + (s.defendants.length || 0), 0);
    renderSimpleBars(sideRoot, [
        { label: 'صاحب الإشارة', value: ownersMentions },
        { label: 'المدعى عليه', value: defendantsMentions }
    ], [
        'linear-gradient(180deg, #34d399, #059669)',
        'linear-gradient(180deg, #f87171, #b91c1c)'
    ]);

    const lastFive = [...signals]
        .sort((a, b) => (a.date || '').localeCompare(b.date || ''))
        .slice(-5)
        .reverse();
    lastFiveBody.innerHTML = '';
    if (!lastFive.length) {
        lastFiveBody.innerHTML = '<tr><td colspan="4">لا توجد إشارات حتى الآن.</td></tr>';
    } else {
        lastFive.forEach((s) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${s.signalNo}</td>
            <td>${s.date || '—'}</td>
            <td>${s.mahder}</td>
            <td>${s.type}</td>
        `;
        lastFiveBody.appendChild(tr);
        });
    }

    const mahderCount = {};
    signals.forEach((s) => {
        mahderCount[s.mahder] = (mahderCount[s.mahder] || 0) + 1;
    });
    const topMahders = Object.entries(mahderCount)
        .map(([label, value]) => ({ label, value }))
        .sort((a, b) => b.value - a.value)
        .slice(0, 6);
    renderSimpleBars(topMahderRoot, topMahders, [
        'linear-gradient(180deg, var(--gold-bright), var(--gold-deep))'
    ]);

    const ownerCount = {};
    signals.forEach((s) => s.owners.forEach((name) => {
        ownerCount[name] = (ownerCount[name] || 0) + 1;
    }));
    const topOwners = Object.entries(ownerCount)
        .map(([label, value]) => ({ label, value }))
        .sort((a, b) => b.value - a.value)
        .slice(0, 6);
    renderSimpleBars(topOwnerRoot, topOwners, [
        'linear-gradient(180deg, #34d399, #059669)'
    ]);

    const defendantCount = {};
    signals.forEach((s) => s.defendants.forEach((name) => {
        defendantCount[name] = (defendantCount[name] || 0) + 1;
    }));
    const topDefendants = Object.entries(defendantCount)
        .map(([label, value]) => ({ label, value }))
        .sort((a, b) => b.value - a.value)
        .slice(0, 6);
    renderSimpleBars(topDefRoot, topDefendants, [
        'linear-gradient(180deg, #f87171, #b91c1c)'
    ]);
    }

    function renderGeneralOverviewCharts() {
    const totalEl = document.getElementById('general-kpi-properties');
    const fullOwnedEl = document.getElementById('general-kpi-full-owned');
    const avgShareEl = document.getElementById('general-kpi-avg-share');
    const ownerShareRoot = document.getElementById('general-owner-share-chart');
    const ownerShareNote = document.getElementById('general-owner-share-note');
    if (!totalEl || !fullOwnedEl || !avgShareEl || !ownerShareRoot || !ownerShareNote) return;

    const totalProperties = buildings.length;
    const fullyOwned = buildings.filter((b) => Number(b.share) >= 100).length;
    const avgShare = totalProperties
        ? buildings.reduce((sum, b) => sum + (Number(b.share) || 0), 0) / totalProperties
        : 0;

    totalEl.textContent = totalProperties.toLocaleString('ar-SA');
    fullOwnedEl.textContent = fullyOwned.toLocaleString('ar-SA');
    avgShareEl.textContent = `${avgShare.toFixed(1)}%`;

    const ownerCount = {};
    collectAllPropertySignals().forEach((s) => {
        s.owners.forEach((name) => {
        ownerCount[name] = (ownerCount[name] || 0) + 1;
        });
    });
    const rows = Object.entries(ownerCount)
        .map(([label, value]) => ({ label, value }))
        .sort((a, b) => b.value - a.value)
        .slice(0, 6);
    renderSimpleBars(ownerShareRoot, rows, [
        'linear-gradient(180deg, #60a5fa, #2563eb)',
        'linear-gradient(180deg, #34d399, #059669)'
    ]);
    ownerShareNote.textContent = `عدد المالكين الظاهرين في الإشارات: ${Object.keys(ownerCount).length.toLocaleString('ar-SA')}`;
    }

    function areaLabelForCard() {
    return getPrefs().area === 'ft2' ? 'المساحة الكلية (قدم²)' : 'المساحة الكلية (م²)';
    }

    function portfolioShareLabel(pct) {
    const p = getPrefs();
    if (p.ownership === 'sahm') {
        const shares = Math.round((pct / 100) * 2400);
        return shares.toLocaleString('ar-SA') + ' سهم من ٢٤٠٠';
    }
    return pct + '٪ من المساحة الكلية';
    }

    // Mobile/tablet layout mode:
    // - phones (<= 700px)
    // - tablets in portrait (<= 1024px + portrait)
    function isMobileNavMode() {
    return (
        window.matchMedia('(max-width: 700px)').matches ||
        window.matchMedia('(max-device-width: 700px)').matches ||
        (window.matchMedia('(max-width: 1024px) and (orientation: portrait)').matches) ||
        (window.matchMedia('(max-device-width: 1024px) and (orientation: portrait)').matches)
    );
    }

    let propertyTableView = 'horizontal'; // for tablets portrait: horizontal by default

    function applyPropertyTableView(view) {
    const card = document.getElementById('property-table-card');
    if (!card) return;

    propertyTableView = view === 'vertical' ? 'vertical' : 'horizontal';
    card.classList.toggle('property-table--vertical', propertyTableView === 'vertical');

    const btn = document.getElementById('mobile-table-view-toggle');
    if (btn) {
        btn.textContent = propertyTableView === 'vertical' ? 'عرض أفقي' : 'عرض عمودي';
    }
    }

    function togglePropertyTableView() {
    applyPropertyTableView(propertyTableView === 'vertical' ? 'horizontal' : 'vertical');
    }

    function initPropertyTableView() {
    // Cards/vertical rows already happen on phones via CSS media query, so keep default horizontal for tablets.
    // If you want vertical as default for tablets too, change 'horizontal' to 'vertical' below.
    applyPropertyTableView('horizontal');

    // On phones, add a one-time swipe hint on the table overflow container
    if (window.matchMedia('(max-width: 600px)').matches) {
        const overflow = document.querySelector('.table-overflow');
        if (overflow && !overflow.dataset.hintAdded) {
        overflow.dataset.hintAdded = '1';
        const hint = document.createElement('div');
        hint.id = 'swipe-hint';
        hint.style.cssText = [
            'display:flex', 'align-items:center', 'justify-content:center',
            'gap:8px', 'padding:8px 14px',
            'background:rgba(212,175,55,.07)', 'border-bottom:1px solid rgba(212,175,55,.15)',
            'font-family:var(--font-ui)', 'font-size:calc(11px * var(--fs-scale))', 'color:var(--gold-mid)',
            'letter-spacing:.04em', 'animation:fadeSlide .4s ease'
        ].join(';');
        hint.innerHTML = '← اسحب يساراً لرؤية بقية الأعمدة →';
        overflow.parentElement.insertBefore(hint, overflow);
        // Dismiss after first scroll
        overflow.addEventListener('scroll', function dismissHint() {
            const h = document.getElementById('swipe-hint');
            if (h) { h.style.transition = 'opacity .4s'; h.style.opacity = '0'; setTimeout(() => h.remove(), 400); }
            overflow.removeEventListener('scroll', dismissHint);
        });
        }
    }
    }

    function updateSelectedCount() {
    const el = document.getElementById('selected-count');
    if (!el) return;
    const count = buildings.filter(b => selectedProps.has(b.propNo)).length;
    el.textContent = count;
    }

    function updateSelectColumnVisibility() {
    const table = document.getElementById('main-table');
    if (!table) return;
    table.classList.toggle('hide-select', !multiSelectEnabled);
    }

    function statusBadge(s) {
    const map = { 'نشط': 'status-active', 'جزئي': 'status-partial', 'قيد المراجعة': 'status-pending' };
    const dot = { 'نشط': '●', 'جزئي': '◑', 'قيد المراجعة': '○' };
    return `<span class="status-badge ${map[s]}">${dot[s]} ${s}</span>`;
    }

    function buildPaymentPanel(b) {
    var pays = Array.isArray(b.paymentsUsd) && b.paymentsUsd.length ? b.paymentsUsd : [];
    var totalVal = Number(b.approxPriceUsd) || Number(b.actualPriceUsd) || Number(b.value) || 0;
    var paidAmt = pays.reduce(function(s,p){ return s + (Number(p.amountUsd)||0); }, 0);
    var remAmt = Math.max(0, totalVal - paidAmt);
    var pct = totalVal > 0 ? Math.min(100, Math.round(paidAmt / totalVal * 100)) : 0;
    var statusColor = b.paymentFinanceStatus === 'مدفوع بشكل كامل' ? '#4ade80' : pct >= 50 ? '#fbbf24' : '#94a3b8';
    var now = new Date().toISOString().slice(0,10);
    function fmtAmt(v) { return v > 0 ? Number(v).toLocaleString('en-US') + ' $' : '—'; }
    // Summary cards
    var cards = ''
        + '<div style="flex:1;min-width:140px;background:rgba(212,175,55,.05);border:1px solid rgba(212,175,55,.18);border-radius:10px;padding:12px 16px">'
        +   '<div style="font-size:calc(10px * var(--fs-scale));color:var(--text-muted);margin-bottom:4px">القيمة الكلية</div>'
        +   '<div style="font-size:calc(15px * var(--fs-scale));font-weight:700;color:var(--text-primary);direction:ltr">' + fmtAmt(totalVal) + '</div>'
        + '</div>'
        + '<div style="flex:1;min-width:140px;background:rgba(74,222,128,.05);border:1px solid rgba(74,222,128,.18);border-radius:10px;padding:12px 16px">'
        +   '<div style="font-size:calc(10px * var(--fs-scale));color:var(--text-muted);margin-bottom:4px">المدفوع حتى الآن</div>'
        +   '<div style="font-size:calc(15px * var(--fs-scale));font-weight:700;color:#4ade80;direction:ltr">' + fmtAmt(paidAmt) + '</div>'
        + '</div>'
        + '<div style="flex:1;min-width:140px;background:rgba(251,191,36,.05);border:1px solid rgba(251,191,36,.18);border-radius:10px;padding:12px 16px">'
        +   '<div style="font-size:calc(10px * var(--fs-scale));color:var(--text-muted);margin-bottom:4px">المتبقي</div>'
        +   '<div style="font-size:calc(15px * var(--fs-scale));font-weight:700;direction:ltr;color:' + (remAmt > 0 ? '#fbbf24' : '#4ade80') + '">' + (remAmt > 0 ? fmtAmt(remAmt) : '✓ مكتمل') + '</div>'
        + '</div>';
    // Progress bar
    var progress = ''
        + '<div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:calc(10.5px * var(--fs-scale));color:var(--text-muted)">'
        +   '<span>نسبة السداد</span>'
        +   '<span style="color:' + statusColor + ';font-weight:600">' + pct + '%</span>'
        + '</div>'
        + '<div style="height:6px;border-radius:6px;background:rgba(255,255,255,.06);overflow:hidden">'
        +   '<div style="height:100%;width:' + pct + '%;background:linear-gradient(to left,' + statusColor + ',' + statusColor + '88);border-radius:6px"></div>'
        + '</div>';
    // Payment rows
    var tblRows = '';
    if (pays.length) {
        pays.forEach(function(p) {
        var isPast = p.date && p.date <= now;
        var dot = isPast ? '✓' : '○';
        var dotClr = isPast ? '#4ade80' : '#94a3b8';
        var rowClr = isPast ? 'var(--gold-light)' : 'var(--text-secondary)';
        var pillBg = isPast ? 'rgba(74,222,128,.1)' : 'rgba(148,163,184,.08)';
        var pillClr = isPast ? '#4ade80' : '#94a3b8';
        var pillBdr = isPast ? 'rgba(74,222,128,.2)' : 'rgba(148,163,184,.15)';
        tblRows += '<tr>'
            + '<td style="padding:8px 12px;border-bottom:1px solid rgba(42,42,42,.5);font-family:var(--font-ui);font-size:calc(10.5px * var(--fs-scale));color:' + dotClr + ';text-align:center">' + dot + '</td>'
            + '<td style="padding:8px 12px;border-bottom:1px solid rgba(42,42,42,.5);font-variant-numeric:tabular-nums;direction:ltr;color:var(--text-muted);font-size:calc(11px * var(--fs-scale))">' + escapeCellHtml(p.date||'') + '</td>'
            + '<td style="padding:8px 12px;border-bottom:1px solid rgba(42,42,42,.5);font-weight:600;color:' + rowClr + ';font-size:calc(12px * var(--fs-scale));font-variant-numeric:tabular-nums;direction:ltr">' + fmtAmt(p.amountUsd) + '</td>'
            + '<td style="padding:8px 12px;border-bottom:1px solid rgba(42,42,42,.5)">'
            +   '<span style="font-size:calc(10px * var(--fs-scale));padding:2px 8px;border-radius:20px;background:' + pillBg + ';color:' + pillClr + ';border:1px solid ' + pillBdr + '">' + (isPast ? 'مسدَّدة' : 'معلَّقة') + '</span>'
            + '</td>'
            + '</tr>';
        });
    } else {
        tblRows = '<tr><td colspan="4" style="padding:10px;text-align:center;color:var(--text-muted)">' + escapeCellHtml(b.paymentDetailBlurb || String(b.payments || '—')) + '</td></tr>';
    }
    var tbl = pays.length
        ? ('<div style="border:1px solid var(--border);border-radius:10px;overflow:hidden">'
        + '<table style="width:100%;border-collapse:collapse">'
        + '<thead><tr style="background:rgba(0,0,0,.25)">'
        + '<th style="padding:8px 12px;font-size:calc(10px * var(--fs-scale));color:var(--text-muted);font-weight:600;text-align:center;width:32px"></th>'
        + '<th style="padding:8px 12px;font-size:calc(10px * var(--fs-scale));color:var(--text-muted);font-weight:600;text-align:right">تاريخ الدفعة</th>'
        + '<th style="padding:8px 12px;font-size:calc(10px * var(--fs-scale));color:var(--text-muted);font-weight:600;text-align:right">المبلغ</th>'
        + '<th style="padding:8px 12px;font-size:calc(10px * var(--fs-scale));color:var(--text-muted);font-weight:600;text-align:right">الحالة</th>'
        + '</tr></thead>'
        + '<tbody>' + tblRows + '</tbody>'
        + '</table></div>')
        : '';
    return '<div style="display:flex;flex-direction:column;gap:16px;max-width:680px">'
        + '<div style="display:flex;flex-wrap:wrap;gap:12px">' + cards + '</div>'
        + '<div>' + progress + '</div>'
        + tbl
        + '</div>';
    }

    function renderTable() {
    const tbody = document.getElementById('table-body');
    if (!tbody) {
        console.warn('[Alrowad] عنصر الجدول #table-body غير موجود بعد — لم يُعرَض تقرير العقارات بعد.');
        return;
    }
    const total = filteredData.length;
    const perPage = rowsLimit === 'all' ? (total || 1) : rowsLimit;
    const totalPages = Math.max(1, Math.ceil(total / perPage));
    if (currentPage > totalPages) currentPage = totalPages;
    const start = rowsLimit === 'all' ? 0 : (currentPage - 1) * perPage;
    const end = rowsLimit === 'all' ? total : start + perPage;
    const visible = filteredData.slice(start, end);
    const spanCols = getVisiblePropertyColCount();
    tbody.innerHTML = visible.map((b, idx) => {
        const isSelected = selectedProps.has(b.propNo);
        const bi = buildings.indexOf(b);
        const propertyKind = getPropertyKindOfBuilding(b, bi);
        const propertySubType = getPropertySubTypeOfBuilding(b, bi);
        const pid = b.propId;
        const om = getAuxOwnerRowMap();
        const stakes = b.propertyOwners || [];
        let ownersCellHtml = '';
        // ── Owner cell helpers ──────────────────────────────
        const PALETTE_SIZE = 5;
        const pocInitials = nm => {
        const clean = nm.replace(/^(د\.?|أ\.?|م\.?)\s+/, '').trim();
        const parts = clean.split(/\s+/);
        return parts.length >= 2
            ? (parts[0][0] + parts[1][0])
            : (parts[0] || '?')[0];
        };
        const pocPct = rawShare => {
        if (!rawShare && rawShare !== 0) return '';
        const full = formatStakeForDisplay(rawShare);
        const m = full.match(/^(\d+)\//);
        if (!m) return full;
        const n = parseInt(m[1], 10);
        // Respect the ownership display mode set in لوحة الاعدادات السريعة
        if (getPrefs().ownership === 'pct') {
            if (n === 2400) return '100%';
            const p = n / 2400 * 100;
            return (Number.isInteger(p) ? p : +p.toFixed(1)) + '%';
        }
        return n.toLocaleString('en-US') + ' سهم';
        };
        const pocAvatar = (nm, colorIdx) => {
        const ci = colorIdx % PALETTE_SIZE;
        return '<div class="poc-av poc-av-' + ci + '" aria-hidden="true"></div>';
        };
        // Single-owner card
        const pocSingleCard = (po, nm, colorIdx) => {
        const ci = colorIdx % PALETTE_SIZE;
        const pct = pocPct(po.share);
        return '<div class="poc-card">'
            + pocAvatar(nm, ci)
            + '<button type="button" class="poc-nm" data-poc-id="' + escapeCellHtml(po.ownerId) + '" onclick="pocNav(this)" title="' + escapeCellHtml(nm) + '">' + escapeCellHtml(nm) + '</button>'
            + (pct ? '<span class="poc-pct poc-pct-' + ci + '">' + pct + '</span>' : '')
            + '</div>';
        };
        // Multi-owner: show every owner as its own compact card, stacked
        const pocCluster = (stks, ownerMap) => {
        const cards = stks.map((po, i) => {
            const r = ownerMap[po.ownerId];
            const nm = r ? r.ownerName : po.holderName || po.ownerId;
            return pocSingleCard(po, nm, i);
        }).join('');
        return '<div class="poc-stack">' + cards + '</div>';
        };
        // ── Render ────────────────────────────────────────
        if (!stakes.length) {
        const fallback = getResponsiblePersonOfBuilding(b, bi) || '—';
        const ini = (fallback.replace(/^(د\.?|أ\.?|م\.?)\s+/,'').trim()[0] || '?').toUpperCase();
        ownersCellHtml = '<div class="poc-card"><div class="poc-av poc-av-muted" aria-hidden="true">' + ini + '</div>'
            + '<span class="poc-nm poc-nm--plain" title="' + escapeCellHtml(fallback) + '">' + escapeCellHtml(fallback) + '</span></div>';
        } else if (stakes.length === 1) {
        const x = stakes[0];
        const rowm = om[x.ownerId];
        const nm = rowm ? rowm.ownerName : x.holderName || x.ownerId;
        ownersCellHtml = pocSingleCard(x, nm, 0);
        } else {
        ownersCellHtml = pocCluster(stakes, om);
        }
        const approxVal = Number(b.approxPriceUsd);
        const actVal = Number(b.actualPriceUsd != null ? b.actualPriceUsd : b.value);
        const fmtUsd = v => (isFinite(v) ? `<span class="price-cell price-approx"><span class="price-cur">$</span><span class="price-amount">${Number(v).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}</span></span>` : '<span class="price-empty">—</span>');
        const sigAux = propertySignalsFromAux(pid);
        const attAux = propertyAttachmentsFromAux(pid);
        const stakeTbl = stakes.length <= 1 ? ''
        : `<div class="prop-owner-stake-list">${stakes.map(po => {
            const rr = om[po.ownerId];
            const nm = rr ? rr.ownerName : po.holderName || po.ownerId;
            return `<div class="prop-owner-stake-row"><button type="button" class="geo-link detail-deep-link prop-owner-name-btn" onclick="jumpLinkedRecord('owner','${po.ownerId}')" title="تقرير المالك">${escapeCellHtml(nm)}</button><span class="prop-owner-stake" title="الحصة من 2400 سهمًا">${escapeCellHtml(formatStakeForDisplay(po.share))}</span></div>`;
        }).join('')}</div>`;
        const geoOpen = isPropertyExpandOpen(pid, 'geo');
        const notesOpen = isPropertyExpandOpen(pid, 'pnotes');
        const payOpen      = isPropertyExpandOpen(pid, 'paydet');
        const areaBreakOpen = isPropertyExpandOpen(pid, 'areaBreak');
        const ownStakeOpen = isPropertyExpandOpen(pid, 'ownStake');
        const rawGeo = String(b.geo || '').trim();
        const iframeSrc = /^https:\/\/www\.google\.com\/maps\/embed/i.test(rawGeo)
        ? rawGeo
        : ('https://maps.google.com/maps?q=' + encodeURIComponent(`${b.city || ''} ${b.name || ''}`.trim()) + '&output=embed');
        const iframeSafeAttr = iframeSrc.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;');
        const mapBlock = !rawGeo
        ? '<div style="color:var(--text-muted);padding:12px;text-align:center">لا يوجد رابط موقع لهذا السجل.</div>'
        : `<div style="display:flex;flex-direction:column;gap:12px;align-items:stretch;">
            <iframe title="موقع على خرائط Google" loading="lazy" style="border:0;width:100%;min-height:260px;border-radius:8px;background:#111827" referrerpolicy="no-referrer-when-downgrade" src="${iframeSafeAttr}"></iframe>
            <div style="text-align:center"><a href="${escapeCellHtml(rawGeo)}" target="_blank" rel="noopener noreferrer" class="geo-link">فتح الرابط المحفوظ للموقع الجغرافي</a></div>
            </div>`;
        const sigPanel = !sigAux.length
        ? '<div style="color:var(--text-muted);padding:6px 0">لا توجد إشارات مرتبطة في تقرير الإشارات.</div>'
        : sigAux.map((s, si) => {
            const claimants = auxFormatOwnerLabels(s.claimantOwnerIds || []).join('، ');
            const defendants = auxFormatOwnerLabels((s.defendantOwnerIds || []).filter(Boolean)).join('، ') || '—';
            return `<div style="margin-bottom:10px;padding:12px 14px;border-radius:10px;border:1px solid rgba(212,175,55,.2);background:linear-gradient(135deg,rgba(212,175,55,.05),rgba(0,0,0,.15));line-height:1.65">
                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:6px;margin-bottom:8px">
                <span style="font-family:var(--font-ui);font-weight:700;color:var(--gold-mid);font-size:calc(12px * var(--fs-scale))">${escapeCellHtml(s.signalId)}</span>
                <span style="background:rgba(212,175,55,.1);border:1px solid rgba(212,175,55,.2);border-radius:20px;padding:2px 10px;font-size:calc(10.5px * var(--fs-scale));color:var(--gold-light);white-space:nowrap">${escapeCellHtml(s.signalType)}</span>
                </div>
                <div style="font-size:calc(11.5px * var(--fs-scale));color:var(--text-secondary);margin-bottom:6px">
                <span style="color:var(--text-muted)">رقم العقد:</span> ${escapeCellHtml(s.signalContractNo)}
                <span style="margin:0 6px;color:var(--text-muted)">•</span>
                <span style="color:var(--text-muted)">التاريخ:</span> ${escapeCellHtml(s.signalDate)}
                </div>
        
                </div>
                <div style="font-size:calc(11px * var(--fs-scale));color:var(--text-muted);margin-bottom:10px;line-height:1.5">
                <span>الأطراف:</span> <span style="color:var(--text-secondary)">${escapeCellHtml(claimants)}</span>
                <span style="margin:0 4px">ضد</span>
                <span style="color:var(--text-secondary)">${escapeCellHtml(defendants)}</span>
                </div>
                <button type="button" class="detail-deep-link" onclick="jumpLinkedRecord('consultation','${s.signalId}')" title="فتح في تقرير الإشارات" style="font-size:calc(11.5px * var(--fs-scale))">↪ الانتقال لتقرير الإشارات</button>
            </div>`;
            }).join('');
        const attPanel = !attAux.length
        ? '<div style="color:var(--text-muted);padding:6px 0">لا توجد ملحقات مرتبطة في تقرير الملحقات.</div>'
        : attAux.map((a, ai) =>
            `<div style="display:flex;align-items:center;gap:10px;padding:8px 12px;margin-bottom:6px;border-radius:8px;border:1px solid rgba(212,175,55,.15);background:rgba(212,175,55,.03)">
                <span style="flex:0 0 auto;width:28px;height:28px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:rgba(212,175,55,.1);border:1px solid rgba(212,175,55,.2);color:var(--gold-mid);font-size:calc(11px * var(--fs-scale));font-weight:700">${ai+1}</span>
                <div style="flex:1;min-width:0">
                <button type="button" class="detail-deep-link" onclick="jumpLinkedRecord('attachment','${a.attachmentId}')" title="تقرير الملحقات" style="font-size:calc(12px * var(--fs-scale));display:block;text-align:start;width:100%">${escapeCellHtml(a.attachmentName)}</button>
                <div style="font-size:calc(10.5px * var(--fs-scale));color:var(--text-muted);margin-top:2px">${escapeCellHtml(a.attachmentId)}${a.attachmentNo ? ' · ' + escapeCellHtml(a.attachmentNo) : ''}</div>
                </div>
            </div>`
            ).join('');
        const createdShown = b.createdAt || getRegistrationDateOfBuilding(b, bi);
        return `<tr class="${isSelected ? 'selected-row' : ''}" data-prop-id="${escapeCellHtml(pid || '')}">
        <td class="select-col" style="text-align:center">
            ${multiSelectEnabled ? `<input type="checkbox" class="row-select" onchange="toggleRowSelection('${b.propNo}', this.checked, this)" ${selectedProps.has(b.propNo) ? 'checked' : ''} />` : ''}</td>
        <td class="td-seq col-seq"><span class="id-badge">${escapeCellHtml(pid || String(idx + 1))}</span></td>
        <td class="col-propnoMahder">${propCombo(b)}</td>
        <td class="col-propOwners">${ownersCellHtml}</td>
        <td class="col-country">${escapeCellHtml(getCountryOfBuilding(b))}</td>
        <td class="col-city">${escapeCellHtml(b.city)}</td>
        <td class="col-type">${escapeCellHtml(propertyKind + (propertySubType ? ' — ' + propertySubType : ''))}</td>
        <td class="col-owndate">${escapeCellHtml(b.ownDate || '—')}</td>
        <td class="col-area" style="text-align:center">
            ${stakes.length > 0
            ? `<button type="button" class="area-expand-btn" onclick="togglePropertyExpand('${pid}','areaBreak')">
                <span class="area-expand-val">${escapeCellHtml(formatAreaFromM2(Number(b.area) || 0))}</span>
                <span class="area-expand-caret">${areaBreakOpen ? '▴' : '▾'}</span>
                </button>`
            : `<span>${escapeCellHtml(formatAreaFromM2(Number(b.area) || 0))}</span>`
            }
        </td>
        <td class="col-geo" style="text-align:center">
            <button type="button" class="geo-link" title="عرض الخريطة" onclick="togglePropertyExpand('${pid}','geo')">${geoOpen ? '🗺▴' : '🗺▾'}</button>
        </td>
        <td class="col-propNotes" style="text-align:center">
            <button type="button" class="details-toggle" onclick="togglePropertyExpand('${pid}','pnotes')"><span>ملاحظات</span><span>${notesOpen ? '▴' : '▾'}</span></button></td>
        <td class="col-opstatus">${operationalStatusBadge(b.operationalStatus)}</td>
        <td class="col-approxprice">${fmtUsd(approxVal)}</td>
        <td class="col-actualprice">${fmtUsd(actVal)}</td>
        <td class="col-payfinance">${(()=>{
            const s = b.paymentFinanceStatus || '—';
            const cls = s === 'مدفوع بشكل كامل' ? 'pay-status-full' : s === 'جزئي' ? 'pay-status-partial' : 'pay-status-other';
            const dot = s === 'مدفوع بشكل كامل' ? '●' : s === 'جزئي' ? '◑' : '○';
            return `<span class="pay-status-badge ${cls}">${dot} ${escapeCellHtml(s)}</span>`;
        })()}</td>
        <td class="col-paydetail" style="text-align:center">
            <button type="button" class="details-toggle" onclick="togglePropertyExpand('${pid}','paydet')"><span>تفاصيل الدفعات</span><span>${payOpen ? '▴' : '▾'}</span></button></td>
        <td class="col-view" style="text-align:center">
            <button class="eye-btn" type="button" onclick="openPropertyDetails('${b.propNo}')">👁</button>
        </td>
        <td class="col-propEntered">${escapeCellHtml(getEnteredByOfBuilding(b, bi))}</td>
        <td class="col-propCreated">${escapeCellHtml(createdShown)}</td>
        <td class="col-propUpdated">${escapeCellHtml(b.updatedAt || '')}</td>
        </tr>

        

                <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900">
        
        <tr class="detail-row ${geoOpen ? 'open' : ''}"><td class="detail-cell" colspan="${spanCols}"><div class="detail-map-title" style="margin-bottom:10px">${escapeCellHtml(b.name)}</div>${mapBlock}</td></tr>
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">الإشارات والملحقات</h2>
        
        <tr class="detail-row ${notesOpen ? 'open' : ''}"><td class="detail-cell" colspan="${spanCols}">
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">قريباً — سيتم الربط في المرحلة القادمة.</p>
        
        <div class="property-notes-wrap">
            <p class="property-notes-text">${escapeCellHtml((b.details || 'لا توجد ملاحظة نصية — راجع الوصف أسفل عنوان العقار.').slice(0, 2000))}</p>
            <div class="property-notes-grid">
            <section class="property-notes-card">
                <div class="property-notes-card-title">الإشارات المرتبطة (${sigAux.length})</div>
                ${sigPanel}
            </section>
            <section class="property-notes-card">
                <div class="property-notes-card-title">الملحقات المرتبطة (${attAux.length})</div>
                ${attPanel}
            </section>
            </div>
        </div></td></tr>
        <tr class="detail-row ${payOpen ? 'open' : ''}"><td class="detail-cell" colspan="${spanCols}">${buildPaymentPanel(b)}</td></tr>
        <tr class="detail-row ${areaBreakOpen ? 'open' : ''}"><td class="detail-cell" colspan="${spanCols}">
        <div class="area-break-panel">
            <div class="area-break-header">
            <span>توزيع مساحة العقار على الملاك</span>
            <span class="area-break-total">${escapeCellHtml(formatAreaFromM2(Number(b.area) || 0))} إجمالي</span>
            </div>
            ${stakes.map((po, pi) => {
            const r = om[po.ownerId];
            const nm = r ? r.ownerName : po.holderName || po.ownerId;
            const full = formatStakeForDisplay(po.share);
            const shareM = full.match(/^(\d+)\/2400/);
            const shares = shareM ? parseInt(shareM[1], 10) : 0;
            const ownerArea = shares > 0 ? (Number(b.area) || 0) * shares / 2400 : 0;
            const pct = shares > 0 ? +(shares / 2400 * 100).toFixed(1) : 0;
            const COLORS = ['#d4af37','#63b3ed','#9acd6e','#ed8936','#b794f6'];
            const col = COLORS[pi % COLORS.length];
            return `<div class="area-break-row">
                <div class="area-break-dot" style="background:${col}"></div>
                <div class="area-break-name">
                <button type="button" class="detail-deep-link" data-poc-id="${escapeCellHtml(po.ownerId)}" onclick="pocNav(this)">${escapeCellHtml(nm)}</button>
                </div>
        
                </div>
            </section>
        
                <div class="area-break-bar-wrap">
                <div class="area-break-bar" style="width:${pct}%;background:${col}22;border-color:${col}55"></div>
                </div>
                <div class="area-break-pct" style="color:${col}">${pct}%</div>
                <div class="area-break-value">${escapeCellHtml(formatAreaFromM2(ownerArea))}</div>
                <div class="area-break-shares" style="color:${col};background:${col}18;border:1px solid ${col}44">${shares} سهم</div>
            </div>`;
            }).join('')}
        </div>
        </td></tr>`;
    }).join('');
    updateSelectColumnVisibility();
    applyColumnOrder();
    applyColumnVisibility();
    setupColumnReorderHandlers();
    ensureColumnResizers('main-table', 'main-colgroup');
    bindColumnResizeHandlers('main-table', 'main-colgroup');
    updateSelectedCount();
    document.getElementById('row-count').textContent = buildings.length.toLocaleString('ar-SA');
    const pageInfo = document.getElementById('page-info');
    if (pageInfo) pageInfo.textContent = `صفحة ${total ? currentPage : 0} من ${total ? totalPages : 0}`;
    const rowsInput = document.getElementById('rows-input');
    if (rowsInput) rowsInput.value = rowsLimit === 'all' ? total : rowsLimit;
    syncAllPagesTableScrollState();
    requestFloatingTableHeadSync();
    updateTableScrollStartButtons();
    if (typeof updateAllTblNavPills === 'function') updateAllTblNavPills();
    if (typeof window._wireTblNavPills === 'function') window._wireTblNavPills();
    // Inject pin buttons (idempotent) and re-apply pinning after DOM settles
    requestAnimationFrame(() => {
        injectPinButtons(document.getElementById('main-table')?.parentElement);
        applyColumnPinning('main-table');
    });
    }

    function propCombo(b) {
    return `<div>${escapeCellHtml(b.propNo || '—')}</div><div style="color:var(--text-muted);font-size:calc(11px * var(--fs-scale))">${escapeCellHtml(b.mahder || '—')}</div>`;
    }

    /* ═══════════════════════════════════════════════════════════════
    GLOBAL SEARCH — syncs all 4 table search inputs and re-filters
    every table with the same query simultaneously.
    ═══════════════════════════════════════════════════════════════ */
    var _gSearchLock = false;
    function globalSearch(q) {
    if (_gSearchLock) return;
    _gSearchLock = true;
    // Sync all 4 search inputs
    var ids = ['table-search', 'owners-search', 'consultations-search', 'attachments-search'];
    ids.forEach(function(id) {
        var el = document.getElementById(id);
        if (el && el.value !== q) el.value = q;
    });
    // Sync aux state searchInput objects (in case they differ from DOM ids)
    ['owners', 'consultations', 'attachments'].forEach(function(pk) {
        var st = auxRecordStates[pk];
        if (st && st.searchInput && st.searchInput.value !== q) st.searchInput.value = q;
    });
    _gSearchLock = false;
    // Re-filter all tables
    filterTable();
    ['owners', 'consultations', 'attachments'].forEach(function(pk) {
        if (auxRecordStates[pk]) filterAuxRecords(pk);
    });
    }

    /* Build lookup caches used by enhanced cross-table search */
    function _buildOwnerNameMap() {
    var map = {};
    var rows = (AUX_RECORDS_CONFIG.owners && AUX_RECORDS_CONFIG.owners.data) || [];
    rows.forEach(function(r) { if (r.ownerId) map[r.ownerId] = (r.ownerName || '').toLowerCase(); });
    return map;
    }
    function _buildSignalMap() {
    var map = {};
    var rows = (AUX_RECORDS_CONFIG.consultations && AUX_RECORDS_CONFIG.consultations.data) || [];
    rows.forEach(function(r) { if (r.signalId) map[r.signalId] = r; });
    return map;
    }
    function _buildAttachmentMap() {
    var map = {};
    var rows = (AUX_RECORDS_CONFIG.attachments && AUX_RECORDS_CONFIG.attachments.data) || [];
    rows.forEach(function(r) { if (r.attachmentId) map[r.attachmentId] = r; });
    return map;
    }
    function _buildPropertyMap() {
    var map = {};
    (buildings || []).forEach(function(b) { if (b.propId) map[b.propId] = b; });
    return map;
    }

    function filterTable() {
    const searchEl = document.getElementById('table-search');
    if (!searchEl) return;
    const q = (searchEl.value || '').toLowerCase();
    propCreatedFrom = (document.getElementById('prop-created-from') || {}).value || '';
    propCreatedTo = (document.getElementById('prop-created-to') || {}).value || '';
    propOwnFrom = (document.getElementById('prop-own-from') || {}).value || '';
    propOwnTo = (document.getElementById('prop-own-to') || {}).value || '';
    propEnteredBy = ((document.getElementById('prop-entered-by') || {}).value || '').trim().toLowerCase();
    propUpdatedFrom = (document.getElementById('prop-updated-from') || {}).value || '';
    propUpdatedTo = (document.getElementById('prop-updated-to') || {}).value || '';

    filteredData = buildings.filter(b => {
        const idx = buildings.indexOf(b);
        const country = getCountryOfBuilding(b);
        const propertyKind = getPropertyKindOfBuilding(b, idx);
        const propertySubType = getPropertySubTypeOfBuilding(b, idx);
        const payFin = String(b.paymentFinanceStatus || '').toLowerCase();
        const opSt = String(b.operationalStatus || '').toLowerCase();
        const ownerHay = JSON.stringify(b.propertyOwners || []).toLowerCase();
        // Build cross-table haystacks once per filterTable call (captured in closure)
        var ownerNameMap = typeof _ownerNameMapCache !== 'undefined' ? _ownerNameMapCache : {};
        var sigMapCache  = typeof _sigMapCache !== 'undefined' ? _sigMapCache : {};
        var attMapCache  = typeof _attMapCache !== 'undefined' ? _attMapCache : {};
        // Owner names from AUX owners table
        var linkedOwnerNames = '';
        if (Array.isArray(b.propertyOwners)) {
        b.propertyOwners.forEach(function(po) {
            var id = po.ownerId || po;
            if (ownerNameMap[id]) linkedOwnerNames += ' ' + ownerNameMap[id];
        });
        }
        // Signal data for this property (from AUX consultations)
        var sigHay = '';
        var allSigs = (AUX_RECORDS_CONFIG.consultations && AUX_RECORDS_CONFIG.consultations.data) || [];
        allSigs.forEach(function(s) {
        if ((s.propertyIds || []).includes(b.propId)) {
            sigHay += ' ' + JSON.stringify(s).toLowerCase();
        }
        });
        // Attachment data for this property (from AUX attachments)
        var attHay = '';
        var allAtts = (AUX_RECORDS_CONFIG.attachments && AUX_RECORDS_CONFIG.attachments.data) || [];
        allAtts.forEach(function(a) {
        if ((a.propertyIds || []).includes(b.propId)) {
            attHay += ' ' + JSON.stringify(a).toLowerCase();
        }
        });
        // Owner full records for this property
        var ownerFullHay = '';
        var allOwnRows = (AUX_RECORDS_CONFIG.owners && AUX_RECORDS_CONFIG.owners.data) || [];
        allOwnRows.forEach(function(o) {
        if ((o.propertyIds || []).includes(b.propId)) {
            ownerFullHay += ' ' + JSON.stringify(o).toLowerCase();
        }
        });
        const matchQ =
        !q ||
        (b.name && String(b.name).toLowerCase().includes(q)) ||
        (b.propNo && b.propNo.toLowerCase().includes(q)) ||
        (b.propId && String(b.propId).toLowerCase().includes(q)) ||
        (b.mahder && b.mahder.toLowerCase().includes(q)) ||
        (country && country.toLowerCase().includes(q)) ||
        (b.city && String(b.city).toLowerCase().includes(q)) ||
        (propertyKind && propertyKind.toLowerCase().includes(q)) ||
        (propertySubType && propertySubType.toLowerCase().includes(q)) ||
        (b.details && String(b.details).toLowerCase().includes(q)) ||
        (b.division && String(b.division).toLowerCase().includes(q)) ||
        (b.ownDate && b.ownDate.toLowerCase().includes(q)) ||
        (b.createdAt && b.createdAt.toLowerCase().includes(q)) ||
        (b.updatedAt && b.updatedAt.toLowerCase().includes(q)) ||
        (b.payments && String(b.payments).toLowerCase().includes(q)) ||
        (b.paymentDetailBlurb && String(b.paymentDetailBlurb).toLowerCase().includes(q)) ||
        (payFin && payFin.includes(q)) ||
        (opSt && opSt.includes(q)) ||
        ownerHay.includes(q) ||
        linkedOwnerNames.includes(q) ||
        ownerFullHay.includes(q) ||
        sigHay.includes(q) ||
        attHay.includes(q) ||
        (Array.isArray(b.opsDetails) && b.opsDetails.join(' ').toLowerCase().includes(q));
        const countries = Array.from(selectedCountriesFilter);
        const cities = Array.from(selectedCitiesFilter);
        const types = Array.from(selectedTypesFilter);
        const subTypes = Array.from(selectedSubTypesFilter);
        const areas = Array.from(selectedAreasFilter);
        const opsSel = Array.from(selectedOpStatusFilter);
        const paySel = Array.from(selectedPaymentFinanceFilter);
        const matchCountry = countries.length === 0 || countries.includes(country);
        const matchCity = cities.length === 0 || cities.includes(b.city);
        const matchType = types.length === 0 || types.includes(propertyKind);
        const matchSubType = subTypes.length === 0 || subTypes.includes(propertySubType);
        const matchArea =
        areas.length === 0 ||
        (areas.includes('small') && b.area < 10000) ||
        (areas.includes('medium') && b.area >= 10000 && b.area <= 20000) ||
        (areas.includes('large') && b.area > 20000);
        const bCreated = b.createdAt || b.registeredAt || getRegistrationDateOfBuilding(b, idx);
        const matchCreatedFrom = !propCreatedFrom || bCreated >= propCreatedFrom;
        const matchCreatedTo = !propCreatedTo || bCreated <= propCreatedTo;
        const bOwn = b.ownDate || '';
        const matchOwnFrom = !propOwnFrom || bOwn >= propOwnFrom;
        const matchOwnTo = !propOwnTo || bOwn <= propOwnTo;
        const bBy = String(getEnteredByOfBuilding(b, idx)).toLowerCase();
        const matchEnteredBy = !propEnteredBy || bBy.includes(propEnteredBy);
        const upd = b.updatedAt || '';
        const matchUpdFrom = !propUpdatedFrom || upd >= propUpdatedFrom;
        const matchUpdTo = !propUpdatedTo || upd <= propUpdatedTo;
        const matchOp = opsSel.length === 0 || opsSel.includes(b.operationalStatus);
        const matchPayFinance = paySel.length === 0 || paySel.includes(b.paymentFinanceStatus);
        return matchQ && matchCountry && matchCity && matchType && matchSubType && matchArea &&
        matchCreatedFrom && matchCreatedTo && matchOwnFrom && matchOwnTo && matchEnteredBy &&
        matchUpdFrom && matchUpdTo && matchOp && matchPayFinance;
    });

    syncPropOpMenuMarks();
    syncPropPayFinanceMenuMarks();
    currentPage = 1;
    renderTable();
    renderActiveFilterChips();
    renderSelectionCard(filteredData, 'نتائج التصفية');
    }

    function setRowsLimit(limit) {
    rowsLimit = limit;
    currentPage = 1;
    renderTable();
    }

    function handleRowsInput(val) {
    const n = parseInt(val, 10);
    if (!isNaN(n) && n > 0) {
        rowsLimit = n;
    } else {
        rowsLimit = 'all';
    }
    currentPage = 1;
    renderTable();
    }

    function toggleRowSelection(propNo, checked, inputEl) {
    if (checked) selectedProps.add(propNo);
    else selectedProps.delete(propNo);

    if (inputEl && inputEl.closest) {
        const row = inputEl.closest('tr');
        if (row) {
        row.classList.toggle('selected-row', checked);
        }
    }

    updateSelectionFromChecked();
    }

    function toggleSelectAll() {
    const total = filteredData.length;
    const perPage = rowsLimit === 'all' ? (total || 1) : rowsLimit;
    const start = rowsLimit === 'all' ? 0 : (currentPage - 1) * perPage;
    const end = rowsLimit === 'all' ? total : start + perPage;
    const visible = filteredData.slice(start, end);
    const allSelected = visible.length > 0 && visible.every(b => selectedProps.has(b.propNo));
    if (allSelected) {
        visible.forEach(b => selectedProps.delete(b.propNo));
    } else {
        visible.forEach(b => selectedProps.add(b.propNo));
    }
    renderTable();
    updateSelectionFromChecked();
    }

    function toggleMultiSelect() {
    multiSelectEnabled = !multiSelectEnabled;
    const float = document.getElementById('props-cards-float');
    if (!multiSelectEnabled) {
        selectedProps = new Set();
        const selectAll = document.getElementById('select-all');
        if (selectAll) selectAll.checked = false;
        const priceCard = document.getElementById('props-price-card');
        if (priceCard) priceCard.style.display = 'none';
        if (float) float.classList.remove('pinned');
    } else {
        if (float) float.classList.add('pinned');
    }
    const btn = document.getElementById('multi-select-btn');
    if (btn) {
        btn.textContent = multiSelectEnabled ? 'إلغاء الاختيار المتعدد' : 'اختيار متعدد';
    }
    renderTable();
    updateSelectColumnVisibility();
    if (!multiSelectEnabled) {
        renderSelectionCard(filteredData, 'نتائج التصفية');
    }
    }

    function changePage(delta) {
    const total = filteredData.length;
    const perPage = rowsLimit === 'all' ? (total || 1) : rowsLimit;
    const totalPages = Math.max(1, Math.ceil(total / perPage));
    currentPage = Math.min(totalPages, Math.max(1, currentPage + delta));
    renderTable();
    }

    function renderSelectionCard(source, modeLabel) {
    const list = (source && source.length) ? source : buildings;
    const totalArea = list.reduce((sum, b) => sum + (b.area || 0), 0);
    const count = list.length;

    const areaEl = document.getElementById('selection-area');
    const countEl = document.getElementById('selection-count');
    const barEl = document.getElementById('selection-bar-fill');
    const modeEl = document.getElementById('selection-mode');
    const shareEl = document.getElementById('selection-share');

    if (!areaEl || !countEl || !barEl || !modeEl || !shareEl) return;

    areaEl.textContent = count ? formatAreaFromM2(totalArea) : '—';
    countEl.textContent = count ? `${count} عقار` : '-- عقار';

    const pct = totalAreaAll ? Math.min(100, Math.round((totalArea / totalAreaAll) * 100)) : 0;
    barEl.style.width = pct + '%';

    modeEl.textContent = modeLabel || 'جميع العقارات';
    shareEl.textContent = pct + '٪ من المساحة الكلية';

    // Update price card if multi-select is enabled and items are selected
    const priceCard = document.getElementById('props-price-card');
    if (priceCard) {
        const isSelection = multiSelectEnabled && selectedProps.size > 0;
        priceCard.style.display = isSelection ? '' : 'none';
        if (isSelection) {
        const fmtPrice = v => isFinite(v) && v > 0
            ? '$\u202F' + Number(v).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 })
            : '—';
        const totalApprox = list.reduce((s, b) => s + (Number(b.approxPriceUsd) || 0), 0);
        const totalActual = list.reduce((s, b) => s + (Number(b.actualPriceUsd != null ? b.actualPriceUsd : b.value) || 0), 0);
        document.getElementById('props-approx-value').textContent = fmtPrice(totalApprox);
        document.getElementById('props-actual-value').textContent = fmtPrice(totalActual);
        document.getElementById('props-price-mode').textContent = `${count} عقار محدد`;
        }
    }
    }

    function refreshAfterPrefsChange() {
    if (window.__prefsHydrating) return;
    renderFinancialOverviewStats();
    renderLegalOverviewCharts();
    renderLegalRequestedCharts();
    renderGeneralOverviewCharts();
    renderTable();
    const selectedList = buildings.filter(b => selectedProps.has(b.propNo));
    if (selectedList.length) {
        renderSelectionCard(selectedList, 'العقارات المحددة');
    } else {
        renderSelectionCard(filteredData, 'نتائج التصفية');
    }
    }

    function updateSelectionFromChecked() {
    const selectedList = buildings.filter(b => selectedProps.has(b.propNo));
    if (selectedList.length) {
        renderSelectionCard(selectedList, 'العقارات المحددة');
    } else {
        renderSelectionCard(filteredData, 'نتائج التصفية');
    }
    updateSelectedCount();
    }

    function areaBandLabel(band) {
    const map = {
        small: 'أقل من ١٠٬٠٠٠ م²',
        medium: '١٠٬٠٠٠ - ٢٠٬٠٠٠ م²',
        large: 'أكثر من ٢٠٬٠٠٠ م²'
    };
    return map[band] || band;
    }

    function renderActiveFilterChips() {
    const chipsWrap = document.getElementById('filter-chips');
    if (!chipsWrap) return;

    const searchInput = document.getElementById('table-search');
    const searchValue = searchInput ? searchInput.value.trim() : '';
    const activeItems = [];

    if (searchValue) {
        activeItems.push({ type: 'search', value: searchValue, label: `بحث: ${searchValue}` });
    }

    Array.from(selectedCountriesFilter).forEach(country => {
        activeItems.push({ type: 'country', value: country, label: `الدولة: ${country}` });
    });
    Array.from(selectedCitiesFilter).forEach(city => {
        activeItems.push({ type: 'city', value: city, label: `المحافظة: ${city}` });
    });
    Array.from(selectedTypesFilter).forEach(type => {
        activeItems.push({ type: 'type', value: type, label: `العقار: ${type}` });
    });
    Array.from(selectedSubTypesFilter).forEach(sub => {
        activeItems.push({ type: 'subtype', value: sub, label: `النوع: ${sub}` });
    });
    const areas = Array.from(selectedAreasFilter);
    if (areas.length > 0 && areas.length < 3) {
        areas.forEach(band => {
        activeItems.push({ type: 'area', value: band, label: `المساحة: ${areaBandLabel(band)}` });
        });
    }
    if (propCreatedFrom) activeItems.push({ type: 'createdFrom', value: propCreatedFrom, label: `تاريخ الادخال من: ${propCreatedFrom}` });
    if (propCreatedTo)   activeItems.push({ type: 'createdTo',   value: propCreatedTo,   label: `تاريخ الادخال إلى: ${propCreatedTo}` });
    if (propOwnFrom)     activeItems.push({ type: 'ownFrom',     value: propOwnFrom,     label: `تاريخ التملك من: ${propOwnFrom}` });
    if (propOwnTo)       activeItems.push({ type: 'ownTo',       value: propOwnTo,       label: `تاريخ التملك إلى: ${propOwnTo}` });
    if (propEnteredBy)   activeItems.push({ type: 'enteredBy',   value: propEnteredBy,   label: `المدخل: ${propEnteredBy}` });
    if (propUpdatedFrom) activeItems.push({ type: 'updatedFrom', value: propUpdatedFrom, label: `آخر تعديل من: ${propUpdatedFrom}` });
    if (propUpdatedTo)   activeItems.push({ type: 'updatedTo',   value: propUpdatedTo,   label: `آخر تعديل إلى: ${propUpdatedTo}` });
    Array.from(selectedOpStatusFilter).forEach(st => {
        activeItems.push({ type: 'opStatus', value: st, label: `حالة العقار: ${st}` });
    });
    Array.from(selectedPaymentFinanceFilter).forEach(pf => {
        activeItems.push({ type: 'payFinance', value: pf, label: `الدفعات: ${pf}` });
    });

    chipsWrap.innerHTML = '';
    const row = document.createElement('div');
    row.style.display = 'flex';
    row.style.alignItems = 'center';
    row.style.gap = '8px';
    row.style.flexWrap = 'wrap';

    const label = document.createElement('span');
    label.className = 'filter-label';
    label.textContent = 'التصفية الحالية:';
    row.appendChild(label);

    const itemsToRender = activeItems.length
        ? activeItems
        : [{ type: 'all', value: 'all', label: 'الكل' }];

    itemsToRender.forEach(item => {
        const chip = document.createElement('span');
        chip.className = 'chip active';
        chip.style.cursor = 'pointer';
        chip.setAttribute('role', 'button');
        chip.setAttribute('tabindex', '0');
        chip.onclick = () => removeActiveFilter(item.type, item.value);
        chip.onkeydown = e => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            removeActiveFilter(item.type, item.value);
        }
        };
        chip.appendChild(document.createTextNode(`${item.label} `));
        const x = document.createElement('span');
        x.className = 'chip-remove';
        x.textContent = '×';
        chip.appendChild(x);
        row.appendChild(chip);
    });

    chipsWrap.appendChild(row);
    }

    function removeActiveFilter(type, value) {
    if (type === 'all') {
        selectedCountriesFilter.clear();
        selectedCitiesFilter.clear();
        selectedTypesFilter.clear();
        selectedSubTypesFilter.clear();
        selectedAreasFilter.clear();
        const searchInput = document.getElementById('table-search');
        if (searchInput) searchInput.value = '';
        const cf = document.getElementById('prop-created-from'); if (cf) cf.value = '';
        const ct = document.getElementById('prop-created-to');   if (ct) ct.value = '';
        const of = document.getElementById('prop-own-from');     if (of) of.value = '';
        const ot = document.getElementById('prop-own-to');       if (ot) ot.value = '';
        const eb = document.getElementById('prop-entered-by');   if (eb) eb.value = '';
        const uf = document.getElementById('prop-updated-from'); if (uf) uf.value = '';
        const ut = document.getElementById('prop-updated-to');   if (ut) ut.value = '';
        propCreatedFrom = propCreatedTo = propOwnFrom = propOwnTo = propEnteredBy = '';
        propUpdatedFrom = propUpdatedTo = '';
        selectedOpStatusFilter.clear();
        selectedPaymentFinanceFilter.clear();
        syncPropOpMenuMarks();
        syncPropPayFinanceMenuMarks();
        updateDateRangeLabel('prop-updated-from','prop-updated-to','prop-updated-label','prop-updated-btn');
        syncCascadeToggles();
        updateCascadeLabel();
    } else if (type === 'search') {
        const searchInput = document.getElementById('table-search');
        if (searchInput) searchInput.value = '';
    } else if (type === 'enteredBy') {
        const el = document.getElementById('prop-entered-by'); if (el) el.value = '';
        propEnteredBy = '';
    } else if (type === 'country') {
        selectedCountriesFilter.delete(value);
    } else if (type === 'city') {
        selectedCitiesFilter.delete(value);
    } else if (type === 'type') {
        selectedTypesFilter.delete(value);
        selectedSubTypesFilter.clear();
        syncCascadeToggles();
        updateCascadeLabel();
    } else if (type === 'subtype') {
        selectedSubTypesFilter.delete(value);
        syncCascadeToggles();
        updateCascadeLabel();
    } else if (type === 'area') {
        selectedAreasFilter.delete(value);
    } else if (type === 'createdFrom') {
        const el = document.getElementById('prop-created-from'); if (el) el.value = '';
        propCreatedFrom = '';
        updateDateRangeLabel('prop-created-from','prop-created-to','prop-created-label','prop-created-btn');
    } else if (type === 'createdTo') {
        const el = document.getElementById('prop-created-to'); if (el) el.value = '';
        propCreatedTo = '';
        updateDateRangeLabel('prop-created-from','prop-created-to','prop-created-label','prop-created-btn');
    } else if (type === 'ownFrom') {
        const el = document.getElementById('prop-own-from'); if (el) el.value = '';
        propOwnFrom = '';
        updateDateRangeLabel('prop-own-from','prop-own-to','prop-own-label','prop-own-btn');
    } else if (type === 'ownTo') {
        const el = document.getElementById('prop-own-to'); if (el) el.value = '';
        propOwnTo = '';
        updateDateRangeLabel('prop-own-from','prop-own-to','prop-own-label','prop-own-btn');
    } else if (type === 'updatedFrom') {
        const el = document.getElementById('prop-updated-from'); if (el) el.value = '';
        propUpdatedFrom = '';
        updateDateRangeLabel('prop-updated-from','prop-updated-to','prop-updated-label','prop-updated-btn');
    } else if (type === 'updatedTo') {
        const el = document.getElementById('prop-updated-to'); if (el) el.value = '';
        propUpdatedTo = '';
        updateDateRangeLabel('prop-updated-from','prop-updated-to','prop-updated-label','prop-updated-btn');
    } else if (type === 'opStatus') {
        selectedOpStatusFilter.delete(value);
        syncPropOpMenuMarks();
    } else if (type === 'payFinance') {
        selectedPaymentFinanceFilter.delete(value);
        syncPropPayFinanceMenuMarks();
    }

    updateCountryLabel();
    updateCountryAllToggle();
    renderCityMenu();
    updateCityLabel();
    updateTypeLabel();
    updateTypeAllToggle();
    updateAreaLabel();
    updateAreaAllToggle();
    currentPage = 1;
    filterTable();
    }

    /* ─── SORT ─── */
    let seqSortDir  = 0; // 0 = none, 1 = asc, -1 = desc
    let areaSortDir = 0;

    function resetSortIcons(except) {
    const seqIcon  = document.getElementById('sort-seq');
    const areaIcon = document.getElementById('sort-area');
    if (seqIcon && except !== 'seq') {
        seqIcon.textContent = '↕';
        seqIcon.classList.remove('active');
    }
    if (areaIcon && except !== 'area') {
        areaIcon.textContent = '↕';
        areaIcon.classList.remove('active');
    }
    }

    function sortBySeq() {
    // toggle direction (افتراضي: من الأصغر للأكبر في أول ضغطة)
    seqSortDir = seqSortDir === 1 ? -1 : 1;
    areaSortDir = 0;
    resetSortIcons('seq');

    const icon = document.getElementById('sort-seq');
    if (icon) {
        icon.textContent = seqSortDir === 1 ? '↑' : '↓';
        icon.classList.add('active');
    }

    filteredData.sort((a, b) => {
        const av = a.propNo || '';
        const bv = b.propNo || '';
        return av.localeCompare(bv, 'ar') * seqSortDir;
    });

    currentPage = 1;
    renderTable();
    }

    function sortByArea() {
    // toggle direction (افتراضي: من الأكبر للأصغر في أول ضغطة)
    areaSortDir = areaSortDir === -1 ? 1 : -1;
    seqSortDir = 0;
    resetSortIcons('area');

    const icon = document.getElementById('sort-area');
    if (icon) {
        icon.textContent = areaSortDir === 1 ? '↑' : '↓';
        icon.classList.add('active');
    }

    filteredData.sort((a, b) => {
        const av = a.area || 0;
        const bv = b.area || 0;
        return (av - bv) * areaSortDir;
    });

    currentPage = 1;
    renderTable();
    }

    /* ─── COLUMN TOGGLE + REORDER ─── */
    const colVisible = {
    seq: true,
    propnoMahder: true,
    propOwners: true,
    country: true,
    city: true,
    type: true,
    owndate: true,
    area: true,
    geo: false,
    propNotes: true,
    opstatus: true,
    approxprice: true,
    actualprice: true,
    payfinance: true,
    paydetail: true,
    view: true,
    propEntered: true,
    propCreated: true,
    propUpdated: true
    };

    let columnOrder = [
    'col-seq',
    'col-propnoMahder',
    'col-propOwners',
    'col-country',
    'col-city',
    'col-type',
    'col-owndate',
    'col-area',
    'col-geo',
    'col-propNotes',
    'col-opstatus',
    'col-approxprice',
    'col-actualprice',
    'col-payfinance',
    'col-paydetail',
    'col-view',
    'col-propEntered',
    'col-propCreated',
    'col-propUpdated'
    ];
    let columnReorderMode = false;
    let draggedColumnKey = null;
    let propertyToolbarMode = 'search';

    function setPropertyToolbarMode(mode) {
    // Toggle: clicking 'reports' while already in reports → close it
    if (mode === 'reports' && propertyToolbarMode === 'reports') mode = 'none';
    // 'close-search' = user pressed ✕ → go back to no active mode
    const validMode = ['search', 'reports'].includes(mode) ? mode : 'none';
    propertyToolbarMode = validMode;

    const searchBtn    = document.getElementById('toolbar-main-search');
    const inlineSearch = document.getElementById('toolbar-inline-search');
    const reportsBtn   = document.getElementById('toolbar-main-reports');

    const isSearch = validMode === 'search';
    if (searchBtn)    searchBtn.style.display    = isSearch ? 'none' : '';
    if (inlineSearch) inlineSearch.classList.toggle('active', isSearch);
    if (reportsBtn) {
        reportsBtn.classList.toggle('active', validMode === 'reports');
        reportsBtn.classList.toggle('active-caret', validMode === 'reports');
    }

    const reportsPanel = document.getElementById('toolbar-reports-panel');
    const chips        = document.getElementById('filter-chips');
    if (reportsPanel) reportsPanel.hidden = validMode !== 'reports';
    if (chips)        chips.hidden        = validMode !== 'reports';

    if (validMode !== 'reports') {
        closeAllMenus('');
        if (columnReorderMode) {
        columnReorderMode = false;
        setupColumnReorderHandlers();
        const btn = document.getElementById('reorder-cols-btn');
        if (btn) btn.textContent = '⇅ إعادة الترتيب';
        }
    }

    if (isSearch) {
        const searchInput = document.getElementById('table-search');
        if (searchInput) searchInput.focus();
    }
    }

    function closeAllMenus(exceptMenuId) {
    const keepOpenId = exceptMenuId || '';
    document.querySelectorAll('.col-menu.open, .cascade-menu.open, .date-range-popover.open, .export-dropdown-menu.open').forEach(menu => {
        if (menu.id !== keepOpenId) menu.classList.remove('open');
    });
    }

    /* ── Date-range dropdown helpers ── */
    function toggleDateRangePopover(popId, event) {
    if (event) event.stopPropagation();
    const pop = document.getElementById(popId);
    if (!pop) return;
    const isOpen = pop.classList.contains('open');
    // Close all other menus and popovers
    closeAllMenus(isOpen ? '' : popId);
    pop.classList.toggle('open', !isOpen);
    }

    function updateDateRangeLabel(fromId, toId, labelId, btnId) {
    const fromEl = document.getElementById(fromId);
    const toEl   = document.getElementById(toId);
    const labelEl = document.getElementById(labelId);
    const btnEl   = document.getElementById(btnId);
    if (!fromEl || !toEl || !labelEl) return;
    const from = fromEl.value;
    const to   = toEl.value;
    if (from && to)   labelEl.textContent = `${from} — ${to}`;
    else if (from)    labelEl.textContent = `من ${from}`;
    else if (to)      labelEl.textContent = `إلى ${to}`;
    else              labelEl.textContent = 'من — إلى';
    if (btnEl) btnEl.classList.toggle('has-value', !!(from || to));
    }

    function clearDateRange(fromId, toId, labelId, btnId) {
    const fromEl = document.getElementById(fromId);
    const toEl   = document.getElementById(toId);
    if (fromEl) fromEl.value = '';
    if (toEl)   toEl.value   = '';
    updateDateRangeLabel(fromId, toId, labelId, btnId);
    }

    // Close date-range popovers when clicking outside
    document.addEventListener('click', e => {
    if (!e.target.closest('.date-range-dropdown')) {
        document.querySelectorAll('.date-range-popover.open').forEach(p => p.classList.remove('open'));
    }
    });

    // Prevent clicks inside a popover from bubbling to the document close handler
    document.addEventListener('click', e => {
    if (e.target.closest('.date-range-popover')) e.stopPropagation();
    }, true);

    function toggleExportDropdown(menuId) {
    const menu = document.getElementById(menuId);
    if (!menu) return;
    const isOpen = menu.classList.contains('open');
    // close all other export dropdowns
    document.querySelectorAll('.export-dropdown-menu.open').forEach(m => m.classList.remove('open'));
    if (!isOpen) menu.classList.add('open');
    }

    function closeExportDropdown(menuId) {
    const menu = document.getElementById(menuId);
    if (menu) menu.classList.remove('open');
    }

    document.addEventListener('click', e => {
    if (!e.target.closest('.export-dropdown')) {
        document.querySelectorAll('.export-dropdown-menu.open').forEach(m => m.classList.remove('open'));
    }
    });

    function onOwnerCatChange(pageKey) {
    const catEl = document.getElementById(`${pageKey}-owner-cat-filter`);
    const subEl = document.getElementById(`${pageKey}-owner-sub-filter`);
    if (!catEl || !subEl) return;
    const cat = catEl.value;
    const subs = cat ? (propertySubTypes[cat] || []) : [];
    subEl.innerHTML = '<option value="">الكل</option>' +
        subs.map(s => `<option value="${s}">${s}</option>`).join('');
    filterAuxRecords(pageKey);
    }

    /* ── Cascading type+subtype filter ── */
    function toggleCascadeMenu(event) {
    if (event) event.stopPropagation();
    const menu = document.getElementById('cascade-menu');
    if (!menu) return;
    const isOpen = menu.classList.contains('open');
    closeAllMenus(isOpen ? '' : 'cascade-menu');
    menu.classList.toggle('open', !isOpen);
    }

    function updateCascadeLabel() {
    const btn = document.getElementById('filter-cascade-label');
    if (!btn) return;
    const cats = Array.from(selectedTypesFilter);
    const subs = Array.from(selectedSubTypesFilter);
    if (!cats.length && !subs.length) { btn.textContent = 'نوع العقار'; return; }
    const parts = [];
    if (cats.length) parts.push(cats.join('، '));
    if (subs.length) parts.push(subs.join('، '));
    btn.textContent = parts.join(' / ');
    }

    function toggleCascadeCat(cat, event) {
    if (event) event.stopPropagation();
    if (selectedTypesFilter.has(cat)) {
        selectedTypesFilter.delete(cat);
        // also remove sub-types belonging to this category
        (propertySubTypes[cat] || []).forEach(s => selectedSubTypesFilter.delete(s));
    } else {
        selectedTypesFilter.add(cat);
    }
    syncCascadeToggles();
    updateCascadeLabel();
    currentPage = 1;
    filterTable();
    }

    function toggleCascadeSub(sub, event) {
    if (event) event.stopPropagation();
    if (selectedSubTypesFilter.has(sub)) {
        selectedSubTypesFilter.delete(sub);
    } else {
        selectedSubTypesFilter.add(sub);
        // auto-select parent category
        for (const [cat, subs] of Object.entries(propertySubTypes)) {
        if (subs.includes(sub)) selectedTypesFilter.add(cat);
        }
    }
    syncCascadeToggles();
    updateCascadeLabel();
    currentPage = 1;
    filterTable();
    }

    function toggleAllCascade(event) {
    if (event) event.stopPropagation();
    if (selectedTypesFilter.size > 0 || selectedSubTypesFilter.size > 0) {
        selectedTypesFilter.clear();
        selectedSubTypesFilter.clear();
    }
    syncCascadeToggles();
    updateCascadeLabel();
    currentPage = 1;
    filterTable();
    }

    function syncCascadeToggles() {
    // all toggle
    const allTog = document.getElementById('cascade-all');
    if (allTog) allTog.textContent = (selectedTypesFilter.size === 0 && selectedSubTypesFilter.size === 0) ? '✓' : '';
    // category toggles
    ['أرض','سكن','تجاري'].forEach(cat => {
        const el = document.getElementById(`cascade-cat-${cat}`);
        if (el) el.textContent = selectedTypesFilter.has(cat) ? '✓' : '';
    });
    // sub-type toggles
    Object.values(propertySubTypes).flat().forEach(sub => {
        const el = document.getElementById(`cascade-sub-${sub}`);
        if (el) el.textContent = selectedSubTypesFilter.has(sub) ? '✓' : '';
    });
    }

    // Close cascade menu when clicking outside
    document.addEventListener('click', e => {
    if (!e.target.closest('#cascade-menu') && !e.target.closest('#filter-cascade-label')) {
        const menu = document.getElementById('cascade-menu');
        if (menu) menu.classList.remove('open');
    }
    // Also close owner cascade menus
    if (!e.target.closest('.cascade-menu') && !e.target.closest('[id$="-cascade-btn"]')) {
        document.querySelectorAll('[id$="-cascade-menu"]').forEach(m => {
        if (m.id !== 'cascade-menu') m.classList.remove('open');
        });
    }
    const csm = document.getElementById('consult-sigtype-menu');
    if (csm && !e.target.closest('#consult-sigtype-menu') && !e.target.closest('#consult-sigtype-btn')) {
        csm.classList.remove('open');
    }
    const pom = document.getElementById('prop-op-menu');
    if (pom && !e.target.closest('#prop-op-menu') && !e.target.closest('#filter-prop-op-btn')) pom.classList.remove('open');
    const ppm = document.getElementById('prop-pay-menu');
    if (ppm && !e.target.closest('#prop-pay-menu') && !e.target.closest('#filter-prop-pay-btn')) ppm.classList.remove('open');
    });

    /* ── Owner cascade filter state (per pageKey) ── */
    const ownerCascadeCats = {};  // pageKey → Set of selected categories
    const ownerCascadeSubs = {};  // pageKey → Set of selected sub-types

    function getOwnerCascadeState(pageKey) {
    if (!ownerCascadeCats[pageKey]) ownerCascadeCats[pageKey] = new Set();
    if (!ownerCascadeSubs[pageKey]) ownerCascadeSubs[pageKey] = new Set();
    return { cats: ownerCascadeCats[pageKey], subs: ownerCascadeSubs[pageKey] };
    }

    function toggleOwnerCascadeMenu(event, pageKey) {
    if (event) event.stopPropagation();
    const menu = document.getElementById(`${pageKey}-cascade-menu`);
    if (!menu) return;
    const isOpen = menu.classList.contains('open');
    closeAllMenus(isOpen ? '' : `${pageKey}-cascade-menu`);
    menu.classList.toggle('open', !isOpen);
    }

    function syncOwnerCascadeToggles(pageKey) {
    const { cats, subs } = getOwnerCascadeState(pageKey);
    const allTog = document.getElementById(`${pageKey}-cascade-all`);
    if (allTog) allTog.textContent = (cats.size === 0 && subs.size === 0) ? '✓' : '';
    ['أرض','سكن','تجاري'].forEach(cat => {
        const el = document.getElementById(`${pageKey}-cascade-cat-${cat}`);
        if (el) el.textContent = cats.has(cat) ? '✓' : '';
    });
    Object.values(propertySubTypes).flat().forEach(sub => {
        const el = document.getElementById(`${pageKey}-cascade-sub-${sub}`);
        if (el) el.textContent = subs.has(sub) ? '✓' : '';
    });
    }

    function updateOwnerCascadeLabel(pageKey) {
    const btn = document.getElementById(`${pageKey}-cascade-btn`);
    if (!btn) return;
    const { cats, subs } = getOwnerCascadeState(pageKey);
    if (!cats.size && !subs.size) { btn.textContent = 'نوع العقار'; return; }
    const parts = [];
    if (cats.size) parts.push(Array.from(cats).join('، '));
    if (subs.size) parts.push(Array.from(subs).join('، '));
    btn.textContent = parts.join(' / ');
    }

    function toggleOwnerCascadeCat(cat, pageKey, event) {
    if (event) event.stopPropagation();
    const { cats, subs } = getOwnerCascadeState(pageKey);
    if (cats.has(cat)) {
        cats.delete(cat);
        (propertySubTypes[cat] || []).forEach(s => subs.delete(s));
    } else {
        cats.add(cat);
    }
    syncOwnerCascadeToggles(pageKey);
    updateOwnerCascadeLabel(pageKey);
    filterAuxRecords(pageKey);
    }

    function toggleOwnerCascadeSub(sub, pageKey, event) {
    if (event) event.stopPropagation();
    const { cats, subs } = getOwnerCascadeState(pageKey);
    if (subs.has(sub)) {
        subs.delete(sub);
    } else {
        subs.add(sub);
        for (const [cat, subList] of Object.entries(propertySubTypes)) {
        if (subList.includes(sub)) cats.add(cat);
        }
    }
    syncOwnerCascadeToggles(pageKey);
    updateOwnerCascadeLabel(pageKey);
    filterAuxRecords(pageKey);
    }

    function toggleAllOwnerCascade(event, pageKey) {
    if (event) event.stopPropagation();
    const { cats, subs } = getOwnerCascadeState(pageKey);
    cats.clear(); subs.clear();
    syncOwnerCascadeToggles(pageKey);
    updateOwnerCascadeLabel(pageKey);
    filterAuxRecords(pageKey);
    }

    function onPropDateFilter() {
    filterTable();
    }

    /* ── Toggle-all helpers for filter dropdowns ── */
    const ALL_COUNTRIES = ['سورية', 'الامارات', 'أخرى'];
    const ALL_TYPES     = ['أرض', 'سكن', 'تجاري'];
    const ALL_AREAS     = ['small', 'medium', 'large'];

    function updateCountryAllToggle() {
    const el = document.getElementById('country-all');
    if (!el) return;
    el.textContent = selectedCountriesFilter.size === 0 ? '✓' : '';
    }

    function toggleAllCountries() {
    if (selectedCountriesFilter.size > 0) {
        selectedCountriesFilter.clear();
    }
    updateCountryLabel();
    updateCountryAllToggle();
    ALL_COUNTRIES.forEach(c => {
        const idMap = { 'سورية': 'country-syria', 'الامارات': 'country-uae', 'أخرى': 'country-other' };
        const el = document.getElementById(idMap[c]);
        if (el) el.textContent = '';
    });
    renderCityMenu();
    updateCityLabel();
    currentPage = 1;
    filterTable();
    }

    function updateTypeAllToggle() {
    const el = document.getElementById('type-all');
    if (!el) return;
    el.textContent = selectedTypesFilter.size === 0 ? '✓' : '';
    }

    function toggleAllTypes() {
    if (selectedTypesFilter.size > 0) {
        selectedTypesFilter.clear();
        selectedSubTypesFilter.clear();
        const idMap = { 'أرض': 'type-land', 'سكن': 'type-house', 'تجاري': 'type-villa' };
        ALL_TYPES.forEach(t => { const el = document.getElementById(idMap[t]); if (el) el.textContent = ''; });
    }
    updateTypeAllToggle();
    updateTypeLabel();
    renderSubTypeMenu();
    updateSubTypeLabel();
    currentPage = 1;
    filterTable();
    }

    /* ── Sub-type filter ── */
    function renderSubTypeMenu() {
    const menu = document.getElementById('subtype-menu');
    if (!menu) return;
    // Which categories are selected? If none → show all sub-types
    const selected = Array.from(selectedTypesFilter);
    const cats = selected.length ? selected : ALL_TYPES;
    const subs = new Set();
    cats.forEach(cat => (propertySubTypes[cat] || []).forEach(s => subs.add(s)));
    // Remove selected sub-types that no longer belong to current categories
    Array.from(selectedSubTypesFilter).forEach(s => { if (!subs.has(s)) selectedSubTypesFilter.delete(s); });
    const subList = Array.from(subs);
    menu.innerHTML = subList.length
        ? `<div class="col-menu-item col-menu-selectall" onclick="toggleAllSubTypes()"><div class="col-toggle" id="subtype-all">${selectedSubTypesFilter.size === 0 ? '✓' : ''}</div> تحديد الكل</div>` +
        subList.map(s => `<div class="col-menu-item" onclick="toggleSubTypeFilter('${s}')"><div class="col-toggle" id="subtype-${s}">${selectedSubTypesFilter.has(s) ? '✓' : ''}</div> ${s}</div>`).join('')
        : '<div class="col-menu-item" style="color:var(--text-muted)">اختر فئة أولاً</div>';
    }

    function updateSubTypeLabel() {
    const el = document.getElementById('filter-subtype-label');
    if (!el) return;
    const subs = Array.from(selectedSubTypesFilter);
    el.textContent = subs.length === 0 ? 'نوع العقار' : subs.length === 1 ? subs[0] : `أنواع متعددة (${subs.length})`;
    }

    function toggleSubTypeMenu() {
    const menu = document.getElementById('subtype-menu');
    if (!menu) return;
    renderSubTypeMenu();
    const shouldOpen = !menu.classList.contains('open');
    closeAllMenus(shouldOpen ? 'subtype-menu' : '');
    menu.classList.toggle('open', shouldOpen);
    }

    function toggleSubTypeFilter(sub) {
    if (selectedSubTypesFilter.has(sub)) selectedSubTypesFilter.delete(sub);
    else selectedSubTypesFilter.add(sub);
    const el = document.getElementById(`subtype-${sub}`);
    if (el) el.textContent = selectedSubTypesFilter.has(sub) ? '✓' : '';
    const allTog = document.getElementById('subtype-all');
    if (allTog) allTog.textContent = selectedSubTypesFilter.size === 0 ? '✓' : '';
    updateSubTypeLabel();
    currentPage = 1;
    filterTable();
    }

    function toggleAllSubTypes() {
    if (selectedSubTypesFilter.size > 0) {
        selectedSubTypesFilter.clear();
        document.querySelectorAll('[id^="subtype-"]:not(#subtype-all):not(#filter-subtype-label)').forEach(el => { el.textContent = ''; });
    }
    const allTog = document.getElementById('subtype-all');
    if (allTog) allTog.textContent = '✓';
    updateSubTypeLabel();
    currentPage = 1;
    filterTable();
    }

    function updateAreaAllToggle() {
    const el = document.getElementById('area-all');
    if (!el) return;
    el.textContent = (selectedAreasFilter.size === 0 || selectedAreasFilter.size === 3) ? '✓' : '';
    }

    function toggleAllAreas() {
    if (selectedAreasFilter.size > 0 && selectedAreasFilter.size < 3) {
        // deselect all
        selectedAreasFilter.clear();
        ['area-small', 'area-medium', 'area-large'].forEach(id => {
        const el = document.getElementById(id); if (el) el.textContent = '';
        });
    } else if (selectedAreasFilter.size === 0) {
        // select all
        ALL_AREAS.forEach(b => selectedAreasFilter.add(b));
        ['area-small', 'area-medium', 'area-large'].forEach(id => {
        const el = document.getElementById(id); if (el) el.textContent = '✓';
        });
    } else {
        // all 3 selected → clear all
        selectedAreasFilter.clear();
        ['area-small', 'area-medium', 'area-large'].forEach(id => {
        const el = document.getElementById(id); if (el) el.textContent = '';
        });
    }
    updateAreaAllToggle();
    updateAreaLabel();
    currentPage = 1;
    filterTable();
    }

    function toggleColMenu(event) {
    if (event) event.stopPropagation();
    const menu = document.getElementById('col-menu');
    if (!menu) return;
    const shouldOpen = !menu.classList.contains('open');
    closeAllMenus(shouldOpen ? 'col-menu' : '');
    menu.classList.toggle('open', shouldOpen);
    }

    document.addEventListener('click', e => {
    const inMainColMenu = !!e.target.closest('#col-menu');
    const onMainColMenuBtn = !!e.target.closest('#prop-col-menu-btn');
    const inAuxColMenu = !!e.target.closest('.col-menu[data-aux-menu="1"]');
    const onAuxColMenuBtn = !!e.target.closest('[onclick*="toggleAuxColMenu"]');
    const inExportDropdown = !!e.target.closest('.export-dropdown');
    const inFilterDropdown = !!e.target.closest('.filter-dropdown');
    const inCascadeMenu = !!e.target.closest('#cascade-menu');
    const onCascadeBtn = !!e.target.closest('#filter-cascade-label');
    if (!inMainColMenu && !onMainColMenuBtn && !inAuxColMenu && !onAuxColMenuBtn && !inExportDropdown && !inFilterDropdown && !inCascadeMenu && !onCascadeBtn) {
        closeAllMenus('');
    }
    });

    function renderCityMenu() {
    const menu = document.getElementById('city-menu');
    if (!menu) return;
    const countries = Array.from(selectedCountriesFilter);
    const activeCountries = countries.length ? countries : Object.keys(countryGovernorates);
    const citySet = new Set();
    activeCountries.forEach(country => {
        (countryGovernorates[country] || []).forEach(city => citySet.add(city));
    });
    const cityList = Array.from(citySet);
    selectedCitiesFilter.forEach(city => {
        if (!citySet.has(city)) selectedCitiesFilter.delete(city);
    });
    menu.innerHTML = cityList.length
        ? `<div class="col-menu-item col-menu-selectall" onclick="toggleAllCities()"><div class="col-toggle" id="city-all">${selectedCitiesFilter.size === 0 ? '✓' : ''}</div> تحديد الكل</div>` +
        cityList.map(city => `
        <div class="col-menu-item" onclick="toggleCityFilter('${city}')">
            <div class="col-toggle">${selectedCitiesFilter.has(city) ? '✓' : ''}</div> ${city}
        </div>
        `).join('')
        : '<div class="col-menu-item"><div class="col-toggle"></div> لا توجد محافظات مطابقة</div>';
    }

    function toggleAllCities() {
    if (selectedCitiesFilter.size > 0) {
        selectedCitiesFilter.clear();
    }
    updateCityLabel();
    renderCityMenu();
    currentPage = 1;
    filterTable();
    }

    function updateCountryLabel() {
    const labelEl = document.getElementById('filter-country-label');
    if (!labelEl) return;
    const countries = Array.from(selectedCountriesFilter);
    if (countries.length === 0) {
        labelEl.textContent = 'الدول';
    } else if (countries.length === 1) {
        labelEl.textContent = countries[0];
    } else {
        labelEl.textContent = `دول متعددة (${countries.length})`;
    }
    const idMap = { 'سورية': 'country-syria', 'الامارات': 'country-uae', 'أخرى': 'country-other' };
    Object.keys(idMap).forEach(country => {
        const el = document.getElementById(idMap[country]);
        if (el) el.textContent = selectedCountriesFilter.has(country) ? '✓' : '';
    });
    }

    function toggleCountryMenu() {
    const menu = document.getElementById('country-menu');
    if (!menu) return;
    const shouldOpen = !menu.classList.contains('open');
    closeAllMenus(shouldOpen ? 'country-menu' : '');
    menu.classList.toggle('open', shouldOpen);
    }

    function toggleCountryFilter(country) {
    if (selectedCountriesFilter.has(country)) {
        selectedCountriesFilter.delete(country);
    } else {
        selectedCountriesFilter.add(country);
    }
    updateCountryLabel();
    updateCountryAllToggle();
    renderCityMenu();
    updateCityLabel();
    currentPage = 1;
    filterTable();
    }

    function toggleCol(cls) {
    const key = cls.replace('col-','');
    if (!(key in colVisible)) return;
    colVisible[key] = !colVisible[key];
    applyColumnVisibility();
    // sync the select-all toggle
    const allVisible = Object.values(colVisible).every(v => v);
    const allTog = document.getElementById('tog-all');
    if (allTog) allTog.textContent = allVisible ? '✓' : '';
    }

    function toggleAllColumns() {
    const allVisible = Object.values(colVisible).every(v => v);
    const newVal = !allVisible;
    Object.keys(colVisible).forEach(key => { colVisible[key] = newVal; });
    applyColumnVisibility();
    const allTog = document.getElementById('tog-all');
    if (allTog) allTog.textContent = newVal ? '✓' : '';
    }

    function applyColumnVisibility() {
    const cg = document.getElementById('main-colgroup');
    Object.keys(colVisible).forEach(key => {
        const cls = 'col-' + key;
        const isVisible = !!colVisible[key];
        document.querySelectorAll('.' + cls).forEach(el => {
        el.style.display = isVisible ? '' : 'none';
        });
        if (cg) {
        const col = cg.querySelector('.' + cls);
        if (col) col.style.display = isVisible ? '' : 'none';
        }
        const mark = document.getElementById('tog-' + key);
        if (mark) mark.textContent = isVisible ? '✓' : '';
    });
    syncMainIdOnlyCompactLayout();
    requestAnimationFrame(() => updateTableScrollStartButtons());
    requestAnimationFrame(() => applyColumnPinning('main-table'));
    }

    function syncMainIdOnlyCompactLayout() {
    const table = document.getElementById('main-table');
    if (!table) return;
    const visibleKeys = Object.keys(colVisible).filter(key => !!colVisible[key]);
    const idOnlyVisible = visibleKeys.length === 1 && visibleKeys[0] === 'seq';
    table.classList.toggle('id-only-compact', idOnlyVisible);
    }

    function applyColumnOrder() {
    const table = document.getElementById('main-table');
    if (!table) return;
    const rows = table.querySelectorAll('thead tr, tbody tr:not(.detail-row):not(.ops-row)');
    rows.forEach(row => {
        const selectCell = row.querySelector('.select-col');
        const cellsByKey = new Map();
        columnOrder.forEach(cls => {
        const cell = row.querySelector('.' + cls);
        if (cell) cellsByKey.set(cls, cell);
        });
        if (selectCell) row.appendChild(selectCell);
        columnOrder.forEach(cls => {
        const cell = cellsByKey.get(cls);
        if (cell) row.appendChild(cell);
        });
    });
    const cg = document.getElementById('main-colgroup');
    if (cg) {
        const selectCol = cg.querySelector('.select-col');
        const colsByKey = new Map();
        columnOrder.forEach(cls => {
        const col = cg.querySelector('.' + cls);
        if (col) colsByKey.set(cls, col);
        });
        if (selectCol) cg.appendChild(selectCol);
        columnOrder.forEach(cls => {
        const col = colsByKey.get(cls);
        if (col) cg.appendChild(col);
        });
    }
    }

    function setupColumnReorderHandlers() {
    const headers = Array.from(document.querySelectorAll('#main-table thead th[data-col-key]'));
    headers.forEach(th => {
        const key = th.dataset.colKey;
        if (!key) return;
        th.draggable = columnReorderMode;
        th.classList.toggle('col-drag', columnReorderMode);
        if (th.dataset.dndBound === '1') return;
        th.dataset.dndBound = '1';
        th.addEventListener('dragstart', e => {
        if (!columnReorderMode) return;
        draggedColumnKey = key;
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/plain', key);
        });
        th.addEventListener('dragover', e => {
        if (!columnReorderMode) return;
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        });
        th.addEventListener('drop', e => {
        if (!columnReorderMode) return;
        e.preventDefault();
        const targetKey = key;
        const sourceKey = draggedColumnKey || e.dataTransfer.getData('text/plain');
        if (!sourceKey || !targetKey || sourceKey === targetKey) return;
        const from = columnOrder.indexOf(sourceKey);
        const to = columnOrder.indexOf(targetKey);
        if (from === -1 || to === -1) return;
        const [moved] = columnOrder.splice(from, 1);
        columnOrder.splice(to, 0, moved);
        renderTable();
        });
        th.addEventListener('dragend', () => {
        draggedColumnKey = null;
        });
    });
    }

    const LOCKED_ID_COLUMN_KEYS = new Set(['col-seq', 'col-ownerId', 'col-signalId', 'col-attachmentId']);
    function isLockedIdColumnKey(key) {
    return LOCKED_ID_COLUMN_KEYS.has(key || '');
    }

    /* ══════════════════════════════════════════════════════════════
    COLUMN PINNING SYSTEM  — Excel-style frozen columns (RTL)
    Columns pin to the RIGHT (visual start in RTL).
    Usage: click the 📌 icon that appears when hovering a column header.
    ══════════════════════════════════════════════════════════════ */

    /** tableId → ordered array of colKeys currently pinned, e.g. ['col-seq','col-propOwners'] */
    const _pinnedColsMap = {};

    const _COL_PIN_SVG = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <line x1="12" y1="17" x2="12" y2="22"/>
    <path d="M5 17h14v-1.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V6h1a2 2 0 0 0 0-4H8a2 2 0 0 0 0 4h1v4.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24Z"/>
    </svg>`;

    /**
     * Inject pin-icon buttons into all .big-table th[data-col-key] inside scopeEl.
     * Idempotent — skips headers that already have a button.
     * @param {Element|Document} [scopeEl]
     */
    function injectPinButtons(scopeEl) {
    const scope = scopeEl || document;
    scope.querySelectorAll('.big-table thead th[data-col-key]').forEach(th => {
        if (th.querySelector('.col-pin-btn')) return;
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'col-pin-btn';
        btn.setAttribute('aria-label', 'تثبيت العمود');
        btn.title = 'تثبيت العمود';
        btn.innerHTML = _COL_PIN_SVG;
        btn.addEventListener('click', e => {
        e.stopPropagation();
        const tableEl = th.closest('.big-table');
        if (!tableEl) return;
        togglePinColumn(tableEl.id, th.dataset.colKey);
        });
        const inner = th.querySelector('.th-inner');
        if (inner) inner.appendChild(btn);
    });
    }

    /**
     * Toggle a column's pin state for a table.
     * @param {string} tableId  e.g. 'main-table' | 'owners-table'
     * @param {string} colKey   e.g. 'col-seq' | 'col-propOwners'
     */
    function togglePinColumn(tableId, colKey) {
    if (!_pinnedColsMap[tableId]) _pinnedColsMap[tableId] = [];
    const arr = _pinnedColsMap[tableId];
    const idx = arr.indexOf(colKey);
    if (idx === -1) arr.push(colKey);
    else arr.splice(idx, 1);
    applyColumnPinning(tableId);
    _syncPinMenuBar(tableId);
    }

    /**
     * Unpin all columns for a table (called from "إلغاء تثبيت الكل" buttons).
     * @param {string} tableId
     */
    function unpinAllColumns(tableId) {
    _pinnedColsMap[tableId] = [];
    applyColumnPinning(tableId);
    _syncPinMenuBar(tableId);
    }

    /**
     * Apply the current pinning state to the live DOM table.
     * Calculates sticky `right` offsets from actual rendered widths.
     * @param {string} tableId
     */
    function applyColumnPinning(tableId) {
    const table = document.getElementById(tableId);
    if (!table) return;
    const pinned = _pinnedColsMap[tableId] || [];

    /* ── Clear previous pinning ─────────────────────────────── */
    table.classList.remove('has-pinned-cols');
    table.querySelectorAll('.col-pinned, .col-pin-edge').forEach(el => {
        el.classList.remove('col-pinned', 'col-pin-edge');
        el.style.removeProperty('right');
    });
    /* Reset select-col sticky state */
    table.querySelectorAll('th.select-col, td.select-col').forEach(el => {
        el.style.removeProperty('position');
        el.style.removeProperty('right');
        el.style.removeProperty('z-index');
    });
    /* Reset all pin buttons */
    table.querySelectorAll('.col-pin-btn').forEach(btn => {
        btn.classList.remove('active');
        btn.title = 'تثبيت العمود';
        btn.setAttribute('aria-pressed', 'false');
    });

    if (pinned.length === 0) return;

    /* ── Measure widths ─────────────────────────────────────── */
    /* select-col is always the base anchor at right:0 */
    const selectTh = table.querySelector('thead th.select-col');
    const selectColW = selectTh ? selectTh.offsetWidth : 44;

    table.classList.add('has-pinned-cols');

    /* Freeze select-col at right: 0 */
    table.querySelectorAll('th.select-col, td.select-col').forEach(el => {
        el.style.right = '0px';
    });

    /* ── Apply sticky right to each pinned column ───────────── */
    /* In RTL the first pinned col is directly adjacent to select-col (at right: selectColW).
        Each subsequent pinned col is further to the left (larger right value). */
    let offset = selectColW;
    pinned.forEach((colKey, i) => {
        const th = table.querySelector(`thead th.${colKey}`);
        const colW = th ? th.offsetWidth : 120;

        table.querySelectorAll(`th.${colKey}, td.${colKey}`).forEach(el => {
        el.classList.add('col-pinned');
        el.style.right = offset + 'px';
        });

        /* Activate pin button */
        if (th) {
        const btn = th.querySelector('.col-pin-btn');
        if (btn) {
            btn.classList.add('active');
            btn.title = 'إلغاء التثبيت';
            btn.setAttribute('aria-pressed', 'true');
        }
        }
        offset += colW;
    });

    /* ── Shadow on outermost (leftmost in RTL) pinned col ────── */
    const lastKey = pinned[pinned.length - 1];
    table.querySelectorAll(`th.${lastKey}, td.${lastKey}`).forEach(el => {
        el.classList.add('col-pin-edge');
    });
    }

    /**
     * Sync the "Unpin All" bar visibility and count in the col-menu.
     * @param {string} tableId
     */
    function _syncPinMenuBar(tableId) {
    const pinned = _pinnedColsMap[tableId] || [];
    const count = pinned.length;
    /* Derive the bar IDs from the tableId */
    const barId   = tableId === 'main-table' ? 'main-pin-actions' : `${tableId.replace('-table','')}-pin-actions`;
    const countId = tableId === 'main-table' ? 'main-pin-count'   : `${tableId.replace('-table','')}-pin-count`;
    const bar = document.getElementById(barId);
    const cnt = document.getElementById(countId);
    if (bar) bar.classList.toggle('visible', count > 0);
    if (cnt) cnt.textContent = count > 0 ? `${count} مثبت` : '';
    }

    /* ── Bootstrap: inject pin buttons on main table after DOM ready ── */
    document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => injectPinButtons(document), 600);
    });

    function ensureColumnResizers(tableId, colgroupId) {
    const table = document.getElementById(tableId);
    const colgroup = document.getElementById(colgroupId);
    if (!table || !colgroup) return;
    const headers = table.querySelectorAll('thead th[data-col-key]');
    headers.forEach(th => {
        if (isLockedIdColumnKey(th.dataset.colKey)) {
        const existingHandle = th.querySelector('.col-resize-handle');
        if (existingHandle) existingHandle.remove();
        return;
        }
        if (th.querySelector('.col-resize-handle')) return;
        const handle = document.createElement('span');
        handle.className = 'col-resize-handle';
        handle.setAttribute('aria-hidden', 'true');
        th.appendChild(handle);
    });
    }

    function bindColumnResizeHandlers(tableId, colgroupId) {
    const table = document.getElementById(tableId);
    const colgroup = document.getElementById(colgroupId);
    if (!table || !colgroup) return;
    const handles = table.querySelectorAll('thead th[data-col-key] .col-resize-handle');
    handles.forEach(handle => {
        if (handle.dataset.resizeBound === '1') return;
        handle.dataset.resizeBound = '1';
        handle.addEventListener('click', e => {
        e.preventDefault();
        e.stopPropagation();
        });
        handle.addEventListener('pointerdown', e => {
        e.preventDefault();
        e.stopPropagation();
        const th = handle.closest('th[data-col-key]');
        if (!th) return;
        const key = th.dataset.colKey;
        if (isLockedIdColumnKey(key)) return;
        const col = colgroup.querySelector(`col.${key}`);
        if (!col) return;
        const startX = e.clientX;
        const startWidth = Math.max(th.getBoundingClientRect().width, 72);
        const minWidth = 72;
        let moved = false;
        document.body.classList.add('is-col-resizing');
        if (handle.setPointerCapture) {
            try { handle.setPointerCapture(e.pointerId); } catch (_) {}
        }
        const onMove = ev => {
            const delta = ev.clientX - startX;
            if (!moved && Math.abs(delta) > 2) moved = true;
            const nextWidth = Math.max(minWidth, startWidth + delta);
            col.style.width = `${nextWidth}px`;
        };
        const onUp = () => {
            window.removeEventListener('pointermove', onMove);
            window.removeEventListener('pointerup', onUp);
            window.removeEventListener('pointercancel', onUp);
            document.body.classList.remove('is-col-resizing');
            if (moved) th.dataset.recentlyResized = String(Date.now());
        };
        window.addEventListener('pointermove', onMove);
        window.addEventListener('pointerup', onUp);
        window.addEventListener('pointercancel', onUp);
        });
    });
    if (table.dataset.resizeClickGuardBound !== '1') {
        table.dataset.resizeClickGuardBound = '1';
        table.addEventListener('click', e => {
        const th = e.target && e.target.closest ? e.target.closest('th[data-col-key]') : null;
        if (!th) return;
        const ts = Number(th.dataset.recentlyResized || 0);
        if (!ts) return;
        if (Date.now() - ts < 250) {
            e.preventDefault();
            e.stopPropagation();
        }
        }, true);
    }
    }

    function toggleColumnReorderMode() {
    columnReorderMode = !columnReorderMode;
    setupColumnReorderHandlers();
    const btn = document.getElementById('reorder-cols-btn');
    if (btn) btn.textContent = columnReorderMode ? '✓ وضع إعادة الترتيب' : '⇅ إعادة الترتيب';
    if (columnReorderMode) {
        alert('وضع إعادة الترتيب مُفعّل: اسحب عنوان العمود وأفلته في المكان المطلوب.');
    }
    }

    function toggleCityMenu() {
    const menu = document.getElementById('city-menu');
    if (!menu) return;
    renderCityMenu();
    const shouldOpen = !menu.classList.contains('open');
    closeAllMenus(shouldOpen ? 'city-menu' : '');
    menu.classList.toggle('open', shouldOpen);
    }

    function updateCityLabel() {
    const labelEl = document.getElementById('filter-city-label');
    if (!labelEl) return;
    const cities = Array.from(selectedCitiesFilter);
    if (cities.length === 0) {
        labelEl.textContent = 'المحافظة';
    } else if (cities.length === 1) {
        labelEl.textContent = cities[0];
    } else {
        labelEl.textContent = `محافظات متعددة (${cities.length})`;
    }
    }

    function toggleCityFilter(city) {
    if (selectedCitiesFilter.has(city)) {
        selectedCitiesFilter.delete(city);
    } else {
        selectedCitiesFilter.add(city);
    }
    // update city-all toggle
    const allTog = document.getElementById('city-all');
    if (allTog) allTog.textContent = selectedCitiesFilter.size === 0 ? '✓' : '';
    updateCityLabel();
    currentPage = 1;
    filterTable();
    }

    function toggleTypeMenu() {
    const menu = document.getElementById('type-menu');
    if (!menu) return;
    const shouldOpen = !menu.classList.contains('open');
    closeAllMenus(shouldOpen ? 'type-menu' : '');
    menu.classList.toggle('open', shouldOpen);
    }

    function updateTypeLabel() {
    const labelEl = document.getElementById('filter-type-label');
    if (!labelEl) return;
    const types = Array.from(selectedTypesFilter);
    if (types.length === 0) {
        labelEl.textContent = 'العقارات';
    } else if (types.length === 1) {
        labelEl.textContent = types[0];
    } else {
        labelEl.textContent = `أنواع متعددة (${types.length})`;
    }
    }

    function toggleTypeFilter(type) {
    if (selectedTypesFilter.has(type)) {
        selectedTypesFilter.delete(type);
    } else {
        selectedTypesFilter.add(type);
    }
    const idMap = { 'أرض': 'type-land', 'سكن': 'type-house', 'تجاري': 'type-villa' };
    const toggleId = idMap[type];
    if (toggleId) {
        const el = document.getElementById(toggleId);
        if (el) el.textContent = selectedTypesFilter.has(type) ? '✓' : '';
    }
    updateTypeAllToggle();
    updateTypeLabel();
    // Refresh sub-type menu when category changes
    selectedSubTypesFilter.clear();
    renderSubTypeMenu();
    updateSubTypeLabel();
    currentPage = 1;
    filterTable();
    }

    function toggleAreaMenu() {
    const menu = document.getElementById('area-menu');
    if (!menu) return;
    const shouldOpen = !menu.classList.contains('open');
    closeAllMenus(shouldOpen ? 'area-menu' : '');
    menu.classList.toggle('open', shouldOpen);
    }

    function updateAreaLabel() {
    const labelEl = document.getElementById('filter-area-label');
    if (!labelEl) return;
    const areas = Array.from(selectedAreasFilter);
    if (areas.length === 0 || areas.length === 3) {
        labelEl.textContent = 'المساحات';
    } else if (areas.length === 1) {
        const m = { small: 'أقل من ١٠٬٠٠٠ م²', medium: '١٠٬٠٠٠ - ٢٠٬٠٠٠ م²', large: 'أكثر من ٢٠٬٠٠٠ م²' };
        labelEl.textContent = m[areas[0]] || 'مساحة واحدة';
    } else {
        labelEl.textContent = `فئات مساحات متعددة (${areas.length})`;
    }
    }

    function toggleAreaFilter(band) {
    if (selectedAreasFilter.has(band)) {
        selectedAreasFilter.delete(band);
    } else {
        selectedAreasFilter.add(band);
    }
    const toggleId = band === 'small' ? 'area-small' : band === 'medium' ? 'area-medium' : 'area-large';
    const el = document.getElementById(toggleId);
    if (el) el.textContent = selectedAreasFilter.has(band) ? '✓' : '';
    updateAreaAllToggle();
    updateAreaLabel();
    currentPage = 1;
    filterTable();
    }

    function togglePropOpMenu() {
    const menu = document.getElementById('prop-op-menu');
    if (!menu) return;
    const shouldOpen = !menu.classList.contains('open');
    closeAllMenus(shouldOpen ? 'prop-op-menu' : '');
    menu.classList.toggle('open', shouldOpen);
    }

    function syncPropOpMenuMarks() {
    const all = document.getElementById('prop-op-all');
    if (all) all.textContent = selectedOpStatusFilter.size === 0 ? '✓' : '';
    const pairs = [['يعمل', 'prop-op-working'], ['جاري صيانته', 'prop-op-maint'], ['متوقف عن العمل', 'prop-op-stopped']];
    pairs.forEach(([s, id]) => {
        const el = document.getElementById(id);
        if (el) el.textContent = selectedOpStatusFilter.has(s) ? '✓' : '';
    });
    const btn = document.getElementById('filter-prop-op-btn');
    if (btn) btn.textContent = selectedOpStatusFilter.size ? `حالة (${selectedOpStatusFilter.size})` : 'حالة العقار';
    }

    function togglePropOpStatusFilter(statusLabel) {
    if (selectedOpStatusFilter.has(statusLabel)) selectedOpStatusFilter.delete(statusLabel);
    else selectedOpStatusFilter.add(statusLabel);
    syncPropOpMenuMarks();
    currentPage = 1;
    filterTable();
    }

    function toggleAllPropOpStatus() {
    selectedOpStatusFilter.clear();
    syncPropOpMenuMarks();
    currentPage = 1;
    filterTable();
    }

    function togglePropPayFinanceMenu() {
    const menu = document.getElementById('prop-pay-menu');
    if (!menu) return;
    const shouldOpen = !menu.classList.contains('open');
    closeAllMenus(shouldOpen ? 'prop-pay-menu' : '');
    menu.classList.toggle('open', shouldOpen);
    }

    function syncPropPayFinanceMenuMarks() {
    const all = document.getElementById('prop-pay-all');
    if (all) all.textContent = selectedPaymentFinanceFilter.size === 0 ? '✓' : '';
    const f = document.getElementById('prop-pay-full');
    const p = document.getElementById('prop-pay-partial');
    if (f) f.textContent = selectedPaymentFinanceFilter.has('مدفوع بشكل كامل') ? '✓' : '';
    if (p) p.textContent = selectedPaymentFinanceFilter.has('جزئي') ? '✓' : '';
    const btn = document.getElementById('filter-prop-pay-btn');
    if (btn) btn.textContent = selectedPaymentFinanceFilter.size ? `دفعات (${selectedPaymentFinanceFilter.size})` : 'مدفوع / جزئي';
    }

    function togglePropPayFinanceFilter(k) {
    if (selectedPaymentFinanceFilter.has(k)) selectedPaymentFinanceFilter.delete(k);
    else selectedPaymentFinanceFilter.add(k);
    syncPropPayFinanceMenuMarks();
    currentPage = 1;
    filterTable();
    }

    function toggleAllPropPayFinance() {
    selectedPaymentFinanceFilter.clear();
    syncPropPayFinanceMenuMarks();
    currentPage = 1;
    filterTable();
    }

    /* ─── EXPORT ─── */
    function csvEscapeCell(val) {
    const s = String(val == null ? '' : val);
    if (/[",\n\r]/.test(s)) return '"' + s.replace(/"/g, '""') + '"';
    return s;
    }

    function exportPropertyOwnersCsvText(b, bi, om) {
    const stakes = b.propertyOwners || [];
    if (!stakes.length) return getResponsiblePersonOfBuilding(b, bi);
    return stakes.map(po => {
        const rowm = om[po.ownerId];
        const nm = rowm ? rowm.ownerName : po.holderName || po.ownerId;
        return `${nm} (${po.share})`;
    }).join(' | ');
    }

    function exportExcel() {
    const om = typeof getAuxOwnerRowMap === 'function' ? getAuxOwnerRowMap() : {};
    const header = [
        'ID العقار',
        'رقم العقار / اسم المحضر',
        'مالك العقار (والحصص)',
        'الدولة',
        'المحافظة',
        'فئة / نوع العقار',
        'تاريخ تملك العقار',
        'مساحة العقار (م²)',
        'الموقع الجغرافي',
        'ملاحظات عن العقار',
        'الحالة التشغيلية',
        'السعر التقريبي (USD)',
        'السعر الفعلي (USD)',
        'الدفعات المالية',
        'تفاصيل الدفع',
        'الباقي من الدفعات',
        'المدخل',
        'تاريخ ادخال البيانات',
        'تاريخ آخر تعديل'
    ];
    const rows = filteredData.map((b, idx) => {
        const bi = buildings.indexOf(b);
        const propertyKind = getPropertyKindOfBuilding(b, bi);
        const propertySubType = getPropertySubTypeOfBuilding(b, bi);
        const cat = propertyKind + (propertySubType ? ' — ' + propertySubType : '');
        const ownersTxt = exportPropertyOwnersCsvText(b, bi, om);
        const createdShown = b.createdAt || getRegistrationDateOfBuilding(b, bi);
        const approxVal = Number(b.approxPriceUsd);
        const actVal = Number(b.actualPriceUsd != null ? b.actualPriceUsd : b.value);
        return [
        b.propId || String(idx + 1),
        [b.propNo, b.mahder].filter(Boolean).join(' / ') || '-',
        ownersTxt,
        getCountryOfBuilding(b),
        b.city || '-',
        cat,
        b.ownDate || '-',
        b.area != null ? b.area : '',
        (b.geo || '').trim(),
        (b.details || '').replace(/[\r\n]+/g, ' '),
        b.operationalStatus || '',
        isFinite(approxVal) ? Math.round(approxVal) : '',
        isFinite(actVal) ? Math.round(actVal) : '',
        b.paymentFinanceStatus || '',
        (b.paymentDetailBlurb || b.payments || '').replace(/[\r\n]+/g, ' '),
        String(b.paymentRemainderLabel || '').replace(/[\r\n]+/g, ' '),
        getEnteredByOfBuilding(b, bi),
        createdShown,
        b.updatedAt || ''
        ];
    });
    const line = cells => cells.map(csvEscapeCell).join(',');
    let csv = '\uFEFF' + line(header) + '\n' + rows.map(r => line(r)).join('\n');
    const blob = new Blob([csv], {type:'text/csv;charset=utf-8'});
    const a = document.createElement('a'); a.href = URL.createObjectURL(blob);
    a.download = 'عقارات_المحفظة.csv'; a.click();
    }

    function printRegistryTablePdf() {
    document.body.classList.add('print-registry-table-only');
    const cleanup = () => {
        document.body.classList.remove('print-registry-table-only');
        window.removeEventListener('afterprint', cleanup);
    };
    window.addEventListener('afterprint', cleanup);
    requestAnimationFrame(() => {
        window.print();
        setTimeout(cleanup, 1000);
    });
    }

    function exportPDF() {
    printRegistryTablePdf();
    }

    /* ─── PAGE SWITCH ─── */
    function openPropertyView(propNo) {
    const b = buildings.find(x => x.propNo === propNo);
    if (!b) return;
    const w = window.open('', '_blank');
    if (!w) return;
    const __pvRoot = document.documentElement;
    const __pvFs =
        __pvRoot.style.getPropertyValue('--fs-base').trim() ||
        getComputedStyle(__pvRoot).getPropertyValue('--fs-base').trim() ||
        '15px';
    const __pvFont =
        __pvRoot.style.getPropertyValue('--font-body').trim() ||
        getComputedStyle(__pvRoot).getPropertyValue('--font-body').trim() ||
        "'Tajawal', sans-serif";
    const pvBi = buildings.indexOf(b);
    const pvStakes = b.propertyOwners || [];
    const pvOm = getAuxOwnerRowMap();
    const pvOwnersTxt = exportPropertyOwnersCsvText(b, pvBi, pvOm);
    const pvKind = getPropertyKindOfBuilding(b, pvBi) + (getPropertySubTypeOfBuilding(b, pvBi) ? ' — ' + getPropertySubTypeOfBuilding(b, pvBi) : '');
    const pvApprox = Number(b.approxPriceUsd);
    const pvActual = Number(b.actualPriceUsd != null ? b.actualPriceUsd : b.value);
    w.document.write(`
        <html lang="ar" dir="rtl">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic:wght@400;500;600;700&family=Tajawal:wght@300;400;500;700&family=Amiri:ital,wght@0,400;0,700;1,400&family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
        <title>بيانات العقار ${b.propNo}</title>
        <style>
            :root { --fs-base: ${__pvFs}; --fs-scale: calc(var(--fs-base) / 15px); }
            body { font-family: ${__pvFont}; background:#0b0b0b; color:#f5f0e8; padding:24px; direction:rtl; }
            h1 { font-size: calc(22px * var(--fs-scale)); margin-bottom:16px; color:#D4AF37; }
            .field { margin-bottom:8px; }
            .label { color:#a3a3a3; font-size: calc(13px * var(--fs-scale)); }
            .value { font-size: calc(14px * var(--fs-scale)); }
            .section-title { margin-top:18px; margin-bottom:8px; color:#D4AF37; font-size: calc(15px * var(--fs-scale)); }
            ul { margin:0; padding-right:18px; }
            li { margin-bottom:4px; }
            .back-btn {
            display:inline-block;
            margin-bottom:16px;
            padding:6px 14px;
            border-radius:6px;
            border:1px solid #444;
            background:#111;
            color:#f5f0e8;
            font-size: calc(12px * var(--fs-scale));
            cursor:pointer;
            }
        </style>
        </head>
        <body>
        <button class="back-btn" onclick="window.close()">↩ العودة إلى لوحة العقارات</button>
        <h1>بيانات العقار ${b.propNo}</h1>
        <div class="field"><span class="label">ID العقار:</span> <span class="value">${escapeCellHtml(b.propId || '')}</span></div>
        <div class="field"><span class="label">اسم المحضر:</span> <span class="value">${escapeCellHtml(b.mahder || '-')}</span></div>
        <div class="field"><span class="label">اسم المبنى:</span> <span class="value">${escapeCellHtml(b.name)}</span></div>
        <div class="field"><span class="label">مالك العقار (والحصص):</span> <span class="value">${escapeCellHtml(pvOwnersTxt)}${pvStakes.length > 1 ? ' (' + pvStakes.length + ' ملاك)' : ''}</span></div>
        <div class="field"><span class="label">الدولة:</span> <span class="value">${escapeCellHtml(getCountryOfBuilding(b))}</span></div>
        <div class="field"><span class="label">المحافظة:</span> <span class="value">${escapeCellHtml(b.city)}</span></div>
        <div class="field"><span class="label">فئة / نوع العقار:</span> <span class="value">${escapeCellHtml(pvKind)}</span></div>
        <div class="field"><span class="label">تاريخ تملك العقار:</span> <span class="value">${escapeCellHtml(b.ownDate || '—')}</span></div>
        <div class="field"><span class="label">المساحة:</span> <span class="value">${formatAreaFromM2(b.area)}</span></div>
        <div class="field"><span class="label">الحالة التشغيلية:</span> <span class="value">${escapeCellHtml(b.operationalStatus || '')}</span></div>
        <div class="field"><span class="label">حالة السجل:</span> <span class="value">${escapeCellHtml(b.status || '')}</span></div>
        <div class="field"><span class="label">السعر التقريبي USD:</span> <span class="value">${isFinite(pvApprox) ? Math.round(pvApprox).toLocaleString('en-US') : '—'}</span></div>
        <div class="field"><span class="label">السعر الفعلي USD:</span> <span class="value">${isFinite(pvActual) ? Math.round(pvActual).toLocaleString('en-US') : '—'}</span></div>
        <div class="field"><span class="label">الدفعات المالية:</span> <span class="value">${escapeCellHtml(b.paymentFinanceStatus || '—')}</span></div>
        <div class="field"><span class="label">تفاصيل الدفع:</span> <span class="value">${escapeCellHtml(String(b.paymentDetailBlurb || b.payments || '—'))}</span></div>
        <div class="field"><span class="label">الباقي من الدفعات:</span> <span class="value">${escapeCellHtml(String(b.paymentRemainderLabel || '—'))}</span></div>
        <div class="field"><span class="label">المدخل:</span> <span class="value">${escapeCellHtml(getEnteredByOfBuilding(b, pvBi))}</span></div>
        <div class="field"><span class="label">تاريخ الإدخال / آخر تعديل:</span> <span class="value">${escapeCellHtml(b.createdAt || getRegistrationDateOfBuilding(b, pvBi))} — ${escapeCellHtml(b.updatedAt || '')}</span></div>
        <div class="section-title">بيانات تفصيلية</div>
        <div class="value">${escapeCellHtml(b.details || 'لا توجد بيانات تفصيلية.')}</div>
        <div class="section-title">تقرير العمليات</div>
        <ul>
            ${(b.opsDetails || []).map(item => `<li>${item}</li>`).join('')}
        </ul>

        </div>
    </x-filament-panels::page>
