<div class="qs-fab" id="qs-fab">

  {{-- FAB trigger — placed FIRST so panel opens to its right in flex-row --}}
  <button
    type="button"
    class="qs-fab-trigger"
    id="qs-fab-trigger"
    aria-expanded="false"
    aria-label="الإعدادات السريعة"
    onclick="event.stopPropagation(); toggleQuickSettings();"
  >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" class="qs-fab-icon">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
    </svg>
    <span class="qs-fab-label">إعدادات</span>
  </button>

  {{-- Panel — appears to the RIGHT of the trigger --}}
  <div class="qs-panel" id="qs-panel" onclick="event.stopPropagation()">

    {{-- Header --}}
    <div class="qs-panel-head">
      <div>
        <div class="qs-panel-title">الإعدادات السريعة</div>
        <div class="qs-panel-sub">مظهر، خط، ألوان، مساحة، لغة</div>
      </div>
      <div style="display:flex;align-items:center;gap:6px">
        <button type="button" class="qs-reset-btn" onclick="resetAllSettings()" aria-label="إعادة تعيين الإعدادات" title="إعادة تعيين كل الإعدادات">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="13" height="13">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
          </svg>
          افتراضي
        </button>
        <button type="button" class="qs-close" onclick="closeQuickSettings()" aria-label="إغلاق">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="16" height="16">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>

    {{-- Body --}}
    <div class="qs-panel-body">

      {{-- Theme --}}
      <div class="qs-row">
        <div class="qs-row-title">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
          المظهر
        </div>
        <div class="qs-tpill">
          <button type="button" class="qs-tpill-btn active" id="theme-dark-btn"  onclick="setThemePref('dark')">🌙 داكن</button>
          <button type="button" class="qs-tpill-btn"        id="theme-light-btn" onclick="setThemePref('light')">☀️ فاتح</button>
        </div>
      </div>

      {{-- Font size --}}
      <div class="qs-row qs-span2">
        <div class="qs-row-title">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12"/></svg>
          حجم الخط
        </div>
        <div class="qs-tpill">
          <button type="button" class="qs-tpill-btn active" id="fs-normal-btn" onclick="setFontSize('normal')">١٥</button>
          <button type="button" class="qs-tpill-btn"        id="fs-large-btn"  onclick="setFontSize('large')">١٧</button>
          <button type="button" class="qs-tpill-btn"        id="fs-xl-btn"     onclick="setFontSize('xl')">٢٠</button>
          <button type="button" class="qs-tpill-btn"        id="fs-xxl-btn"    onclick="setFontSize('xxl')">٢٢</button>
        </div>
      </div>

      {{-- Panel colour --}}
      <div class="qs-row qs-span2">
        <div class="qs-row-title">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/></svg>
          لون اللوحة
        </div>
        <div class="qs-color-opts">
          <button type="button" class="qs-color-btn qs-swatch-default"    id="panel-color-default-btn" onclick="setPanelColor('default')" title="افتراضي"></button>
          <button type="button" class="qs-color-btn qs-swatch-plum"       id="panel-color-plum-btn"    onclick="setPanelColor('plum')"    title="برقوقي"></button>
          <button type="button" class="qs-color-btn qs-swatch-slate"      id="panel-color-slate-btn"   onclick="setPanelColor('slate')"   title="أردوازي"></button>
          <button type="button" class="qs-color-btn qs-swatch-navy"       id="panel-color-navy-btn"    onclick="setPanelColor('navy')"    title="نيلي"></button>
          <button type="button" class="qs-color-btn qs-swatch-forest"     id="panel-color-forest-btn"  onclick="setPanelColor('forest')"  title="غابي"></button>
          <button type="button" class="qs-color-btn qs-swatch-stone"      id="panel-color-stone-btn"   onclick="setPanelColor('stone')"   title="حجري"></button>
          <button type="button" class="qs-color-btn qs-swatch-rose"       id="panel-color-rose-btn"    onclick="setPanelColor('rose')"    title="وردي"></button>
          <button type="button" class="qs-color-btn qs-swatch-teal"       id="panel-color-teal-btn"    onclick="setPanelColor('teal')"    title="فيروزي"></button>
          <button type="button" class="qs-color-btn qs-swatch-gold-panel" id="panel-color-gold-btn"    onclick="setPanelColor('gold')"    title="ذهبي"></button>
        </div>
      </div>

      {{-- Area --}}
      <div class="qs-row">
        <div class="qs-row-title">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>
          المساحة
        </div>
        <div class="qs-tpill">
          <button type="button" class="qs-tpill-btn active" id="area-m2-btn"  onclick="setArea('m2')">م² متر</button>
          <button type="button" class="qs-tpill-btn"        id="area-ft2-btn" onclick="setArea('ft2')">قدم²</button>
        </div>
      </div>

      {{-- Ownership --}}
      <div class="qs-row">
        <div class="qs-row-title">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375"/></svg>
          معيار التملك
        </div>
        <div class="qs-tpill">
          <button type="button" class="qs-tpill-btn active" id="own-sahm-btn" onclick="setOwnership('sahm')">سهم / 2400</button>
          <button type="button" class="qs-tpill-btn"        id="own-pct-btn"  onclick="setOwnership('pct')">نسبة %</button>
        </div>
      </div>

      {{-- Font type --}}
      <div class="qs-row qs-span2">
        <div class="qs-row-title">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12"/></svg>
          نوع الخط
        </div>
        <div class="qs-font-opts">
          <label class="qs-font-opt">
            <input type="radio" name="fontFamily" value="Tajawal" checked>
            <span class="qs-font-radio"></span>
            <span class="qs-font-text">
              <span class="qs-font-lbl" style="font-family:'Tajawal',sans-serif">Tajawal</span>
              <span class="qs-font-sub">Tajawal</span>
            </span>
          </label>
          <label class="qs-font-opt">
            <input type="radio" name="fontFamily" value="Cairo">
            <span class="qs-font-radio"></span>
            <span class="qs-font-text">
              <span class="qs-font-lbl" style="font-family:'Cairo',sans-serif">القاهرة</span>
              <span class="qs-font-sub">Cairo</span>
            </span>
          </label>
          <label class="qs-font-opt">
            <input type="radio" name="fontFamily" value="Amiri">
            <span class="qs-font-radio"></span>
            <span class="qs-font-text">
              <span class="qs-font-lbl" style="font-family:'Amiri',serif">أميري</span>
              <span class="qs-font-sub">Amiri</span>
            </span>
          </label>
        </div>
      </div>

      {{-- Font colour --}}
      <div class="qs-row qs-span2">
        <div class="qs-row-title">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3"/></svg>
          لون الخط
        </div>
        <div class="qs-color-opts">
          <button type="button" class="qs-color-btn qs-swatch-fc-default" id="font-color-default-btn" onclick="setFontColor('default')" title="افتراضي"></button>
          <button type="button" class="qs-color-btn qs-swatch-fc-ivory"   id="font-color-ivory-btn"   onclick="setFontColor('ivory')"   title="عاجي"></button>
          <button type="button" class="qs-color-btn qs-swatch-fc-gold"    id="font-color-gold-btn"    onclick="setFontColor('gold')"    title="ذهبي"></button>
          <button type="button" class="qs-color-btn qs-swatch-fc-silver"  id="font-color-silver-btn"  onclick="setFontColor('silver')"  title="فضي"></button>
          <button type="button" class="qs-color-btn qs-swatch-fc-mint"    id="font-color-mint-btn"    onclick="setFontColor('mint')"    title="نعناعي"></button>
          <button type="button" class="qs-color-btn qs-swatch-fc-rose"    id="font-color-rose-btn"    onclick="setFontColor('rose')"    title="وردي"></button>
        </div>
      </div>

      {{-- Sidebar colour --}}
      <div class="qs-row qs-span2">
        <div class="qs-row-title">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5h18M3 12h18M3 16.5h18"/></svg>
          لون الشريط الجانبي
        </div>
        <div class="qs-color-opts">
          <button type="button" class="qs-color-btn qs-swatch-default"  id="nav-color-default-btn"   onclick="setNavbarColor('default')"  title="افتراضي"></button>
          <button type="button" class="qs-color-btn qs-swatch-obsidian" id="nav-color-obsidian-btn"  onclick="setNavbarColor('obsidian')" title="أوبسيديان"></button>
          <button type="button" class="qs-color-btn qs-swatch-sand"     id="nav-color-sand-btn"      onclick="setNavbarColor('sand')"     title="رملي"></button>
          <button type="button" class="qs-color-btn qs-swatch-emerald"  id="nav-color-emerald-btn"   onclick="setNavbarColor('emerald')"  title="زمردي"></button>
          <button type="button" class="qs-color-btn qs-swatch-royal"    id="nav-color-royal-btn"     onclick="setNavbarColor('royal')"    title="ملكي"></button>
          <button type="button" class="qs-color-btn qs-swatch-burgundy" id="nav-color-burgundy-btn"  onclick="setNavbarColor('burgundy')" title="خمري"></button>
        </div>
      </div>

      {{-- Header colour --}}
      <div class="qs-row qs-span2">
        <div class="qs-row-title">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5.25h18M3 12h18M3 18.75h18"/></svg>
          لون رأس الصفحة
        </div>
        <div class="qs-color-opts">
          <button type="button" class="qs-color-btn qs-swatch-default"  id="header-color-default-btn"   onclick="setHeaderColor('default')"  title="افتراضي"></button>
          <button type="button" class="qs-color-btn qs-swatch-obsidian" id="header-color-obsidian-btn"  onclick="setHeaderColor('obsidian')" title="أوبسيديان"></button>
          <button type="button" class="qs-color-btn qs-swatch-sand"     id="header-color-sand-btn"      onclick="setHeaderColor('sand')"     title="رملي"></button>
          <button type="button" class="qs-color-btn qs-swatch-emerald"  id="header-color-emerald-btn"   onclick="setHeaderColor('emerald')"  title="زمردي"></button>
          <button type="button" class="qs-color-btn qs-swatch-royal"    id="header-color-royal-btn"     onclick="setHeaderColor('royal')"    title="ملكي"></button>
          <button type="button" class="qs-color-btn qs-swatch-burgundy" id="header-color-burgundy-btn"  onclick="setHeaderColor('burgundy')" title="خمري"></button>
        </div>
      </div>

      {{-- Table colour --}}
      <div class="qs-row qs-span2">
        <div class="qs-row-title">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6.75h15m-15 5.25h15m-15 5.25h15"/></svg>
          لون الجداول
        </div>
        <div class="qs-color-opts">
          <button type="button" class="qs-color-btn qs-swatch-default"  id="table-color-default-btn"   onclick="setTableColor('default')"  title="افتراضي"></button>
          <button type="button" class="qs-color-btn qs-swatch-obsidian" id="table-color-obsidian-btn"  onclick="setTableColor('obsidian')" title="أوبسيديان"></button>
          <button type="button" class="qs-color-btn qs-swatch-sand"     id="table-color-sand-btn"      onclick="setTableColor('sand')"     title="رملي"></button>
          <button type="button" class="qs-color-btn qs-swatch-emerald"  id="table-color-emerald-btn"   onclick="setTableColor('emerald')"  title="زمردي"></button>
          <button type="button" class="qs-color-btn qs-swatch-royal"    id="table-color-royal-btn"     onclick="setTableColor('royal')"    title="ملكي"></button>
          <button type="button" class="qs-color-btn qs-swatch-burgundy" id="table-color-burgundy-btn"  onclick="setTableColor('burgundy')" title="خمري"></button>
        </div>
      </div>

      {{-- Language --}}
      <div class="qs-row qs-span2">
        <div class="qs-row-title">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3"/></svg>
          اللغة
        </div>
        <div class="qs-tpill" style="max-width:260px">
          <button type="button" class="qs-tpill-btn active" id="lang-ar-btn" onclick="setLang('ar')">🇸🇦 العربية</button>
          <button type="button" class="qs-tpill-btn"        id="lang-en-btn" onclick="setLang('en')">🇬🇧 English</button>
        </div>
        <div class="qs-note">* تغيير اللغة يطبق اتجاه الصفحة فوراً.</div>
      </div>

    </div>{{-- /qs-panel-body --}}
  </div>{{-- /qs-panel --}}

  {{-- FAB trigger button --}}
</div>{{-- /qs-fab --}}
