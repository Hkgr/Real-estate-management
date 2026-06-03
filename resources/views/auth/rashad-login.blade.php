<div>
{{-- Background --}}
<div class="bg-canvas">
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
</div>
<div class="bg-pattern"></div>

{{-- Quick Settings FAB --}}
<div class="qs-fab" id="qs-fab">
    <div class="qs-panel" id="qs-panel" onclick="event.stopPropagation()">
        <div class="qs-panel-head">
            <div>
                <div class="qs-panel-title">الإعدادات السريعة</div>
                <div class="qs-panel-sub">مظهر، خط، ألوان، عملة، مساحة</div>
            </div>
            <div style="display:flex;align-items:center;gap:6px">
                <button type="button" class="qs-reset-btn" onclick="resetAllSettings()" title="إعادة تعيين كل الإعدادات">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                    افتراضي
                </button>
                <button type="button" class="qs-close" onclick="closeQuickSettings()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        <div class="qs-panel-body">
            <div class="qs-row"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>المظهر</div><div class="qs-tpill"><button type="button" class="qs-tpill-btn active" id="theme-dark-btn" onclick="setThemePref('dark')">🌙 داكن</button><button type="button" class="qs-tpill-btn" id="theme-light-btn" onclick="setThemePref('light')">☀️ فاتح</button></div></div>
            <div class="qs-row qs-span2"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12"/></svg>حجم الخط</div><div class="qs-tpill"><button type="button" class="qs-tpill-btn active" id="fs-normal-btn" onclick="setFontSize('normal')">١٥</button><button type="button" class="qs-tpill-btn" id="fs-large-btn" onclick="setFontSize('large')">١٧</button><button type="button" class="qs-tpill-btn" id="fs-xl-btn" onclick="setFontSize('xl')">٢٠</button><button type="button" class="qs-tpill-btn" id="fs-xxl-btn" onclick="setFontSize('xxl')">٢٢</button></div></div>
            <div class="qs-row qs-span2"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/></svg>لون اللوحة</div><div class="qs-color-opts"><button type="button" class="qs-color-btn" id="panel-color-default-btn" onclick="setPanelColor('default')">افتراضي</button><button type="button" class="qs-color-btn" id="panel-color-plum-btn" onclick="setPanelColor('plum')">برقوقي</button><button type="button" class="qs-color-btn" id="panel-color-slate-btn" onclick="setPanelColor('slate')">أردوازي</button><button type="button" class="qs-color-btn" id="panel-color-navy-btn" onclick="setPanelColor('navy')">نيلي</button><button type="button" class="qs-color-btn" id="panel-color-forest-btn" onclick="setPanelColor('forest')">غابي</button><button type="button" class="qs-color-btn" id="panel-color-stone-btn" onclick="setPanelColor('stone')">حجري</button><button type="button" class="qs-color-btn" id="panel-color-rose-btn" onclick="setPanelColor('rose')">وردي</button><button type="button" class="qs-color-btn" id="panel-color-teal-btn" onclick="setPanelColor('teal')">فيروزي</button><button type="button" class="qs-color-btn" id="panel-color-gold-btn" onclick="setPanelColor('gold')">ذهبي</button></div></div>
            <div class="qs-row"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0"/></svg>العملة</div><div class="qs-tpill"><button type="button" class="qs-tpill-btn active" id="cur-usd-btn" onclick="setCurrency('USD')">$ دولار</button><button type="button" class="qs-tpill-btn" id="cur-lbp-btn" onclick="setCurrency('LBP')" hidden>ليرة</button></div></div>
            <div class="qs-row"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>المساحة</div><div class="qs-tpill"><button type="button" class="qs-tpill-btn active" id="area-m2-btn" onclick="setArea('m2')">م²</button><button type="button" class="qs-tpill-btn" id="area-ft2-btn" onclick="setArea('ft2')">قدم²</button></div></div>
            <div class="qs-row qs-span2"><div class="qs-row-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128"/></svg>الخط</div><div class="qs-font-opts">
                <label class="qs-font-opt"><input type="radio" name="fontFamily" value="Tajawal" checked><div class="qs-font-radio"></div><div><div class="qs-font-lbl" style="font-family:'Tajawal',sans-serif">تجوّل</div><div class="qs-font-sub">Tajawal</div></div></label>
                <label class="qs-font-opt"><input type="radio" name="fontFamily" value="Cairo"><div class="qs-font-radio"></div><div><div class="qs-font-lbl" style="font-family:'Cairo',sans-serif">القاهرة</div><div class="qs-font-sub">Cairo</div></div></label>
                <label class="qs-font-opt"><input type="radio" name="fontFamily" value="Amiri"><div class="qs-font-radio"></div><div><div class="qs-font-lbl" style="font-family:'Amiri',serif">أميري</div><div class="qs-font-sub">Amiri</div></div></label>
            </div></div>
        </div>
    </div>
    <button type="button" class="qs-fab-trigger" id="qs-fab-trigger" aria-expanded="false" aria-label="الإعدادات السريعة" onclick="event.stopPropagation(); toggleQuickSettings();">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    </button>
</div>

{{-- Main Layout --}}
<div class="login-wrapper">

    {{-- Brand Panel --}}
    <div class="brand-panel">
        <div class="brand-scene">
            <svg viewBox="0 0 520 700" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMax meet">
                <defs>
                    <linearGradient id="skyGrad" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#0d0a04"/><stop offset="100%" stop-color="#1a1406"/></linearGradient>
                    <linearGradient id="bldg1" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#1c1810"/><stop offset="50%" stop-color="#2a2416"/><stop offset="100%" stop-color="#161208"/></linearGradient>
                    <linearGradient id="bldg2" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#151107"/><stop offset="50%" stop-color="#221d0e"/><stop offset="100%" stop-color="#181407"/></linearGradient>
                    <linearGradient id="bldgTall" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#23200f"/><stop offset="40%" stop-color="#302c18"/><stop offset="100%" stop-color="#1a1709"/></linearGradient>
                    <linearGradient id="groundGrad" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#1e1a09"/><stop offset="100%" stop-color="#0d0a02"/></linearGradient>
                    <linearGradient id="glowGold" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#D4AF37" stop-opacity=".9"/><stop offset="100%" stop-color="#8B6914" stop-opacity=".3"/></linearGradient>
                    <filter id="glow"><feGaussianBlur stdDeviation="3" result="blur"/><feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge></filter>
                    <radialGradient id="moonGlow" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="#D4AF37" stop-opacity=".18"/><stop offset="100%" stop-color="#D4AF37" stop-opacity="0"/></radialGradient>
                    <radialGradient id="groundLight" cx="50%" cy="0%" r="60%"><stop offset="0%" stop-color="#C49A2A" stop-opacity=".12"/><stop offset="100%" stop-color="#C49A2A" stop-opacity="0"/></radialGradient>
                </defs>
                <rect width="520" height="700" fill="url(#skyGrad)"/>
                <ellipse cx="420" cy="80" rx="90" ry="90" fill="url(#moonGlow)"><animate attributeName="cx" values="420;426;420" dur="11s" repeatCount="indefinite"/><animate attributeName="opacity" values=".9;1;.9" dur="6s" repeatCount="indefinite"/></ellipse>
                <circle cx="420" cy="80" r="22" fill="#1c1810" stroke="#D4AF37" stroke-width=".8" opacity=".7"/><circle cx="412" cy="74" r="18" fill="#0f0d06"/>
                <g fill="#D4AF37" opacity=".5" filter="url(#glow)"><circle cx="60" cy="45" r="1"/><circle cx="140" cy="28" r="1.2"/><circle cx="200" cy="55" r=".8"/><circle cx="280" cy="20" r="1"/><circle cx="350" cy="40" r=".9"/><circle cx="470" cy="30" r="1.1"/><circle cx="90" cy="110" r=".7"/><circle cx="180" cy="90" r="1"/><circle cx="310" cy="75" r=".8"/><circle cx="490" cy="110" r=".9"/><circle cx="30" cy="130" r="1"/><circle cx="240" cy="100" r=".6"/></g>
                <g fill="#E8C96A"><circle cx="110" cy="65" r="1" opacity=".4"><animate attributeName="opacity" values=".4;1;.4" dur="3s" repeatCount="indefinite"/></circle><circle cx="320" cy="50" r=".9" opacity=".3"><animate attributeName="opacity" values=".3;.9;.3" dur="4.5s" repeatCount="indefinite"/></circle><circle cx="460" cy="95" r="1.1" opacity=".5"><animate attributeName="opacity" values=".5;1;.5" dur="2.8s" repeatCount="indefinite"/></circle></g>
                <rect x="0" y="380" width="60" height="320" fill="#100e06" opacity=".6"/><rect x="10" y="340" width="40" height="360" fill="#131007" opacity=".6"/><rect x="460" y="350" width="60" height="350" fill="#100e06" opacity=".6"/><rect x="470" y="310" width="40" height="390" fill="#131007" opacity=".6"/>
                <rect class="building-side-left" x="30" y="430" width="80" height="270" fill="url(#bldg2)"/>
                <g class="windows-left-dim" fill="#C49A2A" opacity=".18"><rect x="40" y="445" width="8" height="6" rx="1"/><rect x="55" y="445" width="8" height="6" rx="1"/><rect x="70" y="445" width="8" height="6" rx="1"/><rect x="85" y="445" width="8" height="6" rx="1"/><rect x="40" y="460" width="8" height="6" rx="1"/><rect x="55" y="460" width="8" height="6" rx="1"/><rect x="70" y="460" width="8" height="6" rx="1"/><rect x="85" y="460" width="8" height="6" rx="1"/><rect x="40" y="475" width="8" height="6" rx="1"/><rect x="70" y="475" width="8" height="6" rx="1"/><rect x="40" y="490" width="8" height="6" rx="1"/><rect x="55" y="490" width="8" height="6" rx="1"/><rect x="85" y="490" width="8" height="6" rx="1"/></g>
                <g fill="#E8C96A" opacity=".55" filter="url(#glow)"><rect x="55" y="475" width="8" height="6" rx="1"><animate attributeName="opacity" values=".55;.2;.55" dur="4s" repeatCount="indefinite"/></rect><rect x="85" y="475" width="8" height="6" rx="1"><animate attributeName="opacity" values=".3;.7;.3" dur="6s" repeatCount="indefinite"/></rect></g>
                <rect class="building-side-right" x="410" y="420" width="90" height="280" fill="url(#bldg2)"/>
                <g class="windows-right-dim" fill="#C49A2A" opacity=".18"><rect x="420" y="435" width="9" height="7" rx="1"/><rect x="436" y="435" width="9" height="7" rx="1"/><rect x="452" y="435" width="9" height="7" rx="1"/><rect x="468" y="435" width="9" height="7" rx="1"/><rect x="484" y="435" width="9" height="7" rx="1"/><rect x="420" y="452" width="9" height="7" rx="1"/><rect x="436" y="452" width="9" height="7" rx="1"/><rect x="452" y="452" width="9" height="7" rx="1"/><rect x="484" y="452" width="9" height="7" rx="1"/><rect x="420" y="469" width="9" height="7" rx="1"/><rect x="452" y="469" width="9" height="7" rx="1"/><rect x="468" y="469" width="9" height="7" rx="1"/><rect x="484" y="469" width="9" height="7" rx="1"/></g>
                <g fill="#E8C96A" opacity=".6" filter="url(#glow)"><rect x="436" y="469" width="9" height="7" rx="1"><animate attributeName="opacity" values=".6;.2;.6" dur="5s" repeatCount="indefinite"/></rect><rect x="468" y="452" width="9" height="7" rx="1"><animate attributeName="opacity" values=".3;.7;.3" dur="3.5s" repeatCount="indefinite"/></rect></g>
                <rect class="building-main" x="165" y="200" width="190" height="500" fill="url(#bldgTall)"/>
                <line x1="220" y1="200" x2="220" y2="700" stroke="#D4AF37" stroke-width=".4" opacity=".12"/><line x1="260" y1="200" x2="260" y2="700" stroke="#D4AF37" stroke-width=".4" opacity=".08"/><line x1="300" y1="200" x2="300" y2="700" stroke="#D4AF37" stroke-width=".4" opacity=".12"/>
                <polygon points="230,175 260,130 290,175" fill="#1e1a0a" stroke="#D4AF37" stroke-width=".8" opacity=".7"/>
                <line x1="260" y1="130" x2="260" y2="100" stroke="#D4AF37" stroke-width="1" opacity=".6" filter="url(#glow)"/>
                <circle cx="260" cy="98" r="3" fill="#D4AF37" opacity=".7" filter="url(#glow)"><animate attributeName="opacity" values=".7;1;.7" dur="2s" repeatCount="indefinite"/></circle>
                <rect x="158" y="198" width="204" height="4" fill="#D4AF37" opacity=".35" rx="1"/>
                <g fill="none" stroke="#D4AF37" stroke-width=".3" opacity=".12"><line x1="165" y1="250" x2="355" y2="250"/><line x1="165" y1="290" x2="355" y2="290"/><line x1="165" y1="330" x2="355" y2="330"/><line x1="165" y1="370" x2="355" y2="370"/><line x1="165" y1="410" x2="355" y2="410"/><line x1="165" y1="450" x2="355" y2="450"/><line x1="165" y1="490" x2="355" y2="490"/><line x1="165" y1="530" x2="355" y2="530"/><line x1="165" y1="570" x2="355" y2="570"/><line x1="165" y1="610" x2="355" y2="610"/><line x1="165" y1="650" x2="355" y2="650"/></g>
                <g class="windows-tower-dim" fill="#C49A2A" opacity=".15"><rect x="178" y="213" width="12" height="20" rx="2"/><rect x="198" y="213" width="12" height="20" rx="2"/><rect x="218" y="213" width="12" height="20" rx="2"/><rect x="238" y="213" width="12" height="20" rx="2"/><rect x="258" y="213" width="12" height="20" rx="2"/><rect x="278" y="213" width="12" height="20" rx="2"/><rect x="298" y="213" width="12" height="20" rx="2"/><rect x="318" y="213" width="12" height="20" rx="2"/><rect x="338" y="213" width="12" height="20" rx="2"/><rect x="178" y="254" width="12" height="20" rx="2"/><rect x="198" y="254" width="12" height="20" rx="2"/><rect x="238" y="254" width="12" height="20" rx="2"/><rect x="258" y="254" width="12" height="20" rx="2"/><rect x="298" y="254" width="12" height="20" rx="2"/><rect x="318" y="254" width="12" height="20" rx="2"/><rect x="338" y="254" width="12" height="20" rx="2"/><rect x="178" y="294" width="12" height="20" rx="2"/><rect x="218" y="294" width="12" height="20" rx="2"/><rect x="238" y="294" width="12" height="20" rx="2"/><rect x="258" y="294" width="12" height="20" rx="2"/><rect x="278" y="294" width="12" height="20" rx="2"/><rect x="318" y="294" width="12" height="20" rx="2"/><rect x="338" y="294" width="12" height="20" rx="2"/><rect x="178" y="334" width="12" height="20" rx="2"/><rect x="198" y="334" width="12" height="20" rx="2"/><rect x="258" y="334" width="12" height="20" rx="2"/><rect x="278" y="334" width="12" height="20" rx="2"/><rect x="298" y="334" width="12" height="20" rx="2"/><rect x="338" y="334" width="12" height="20" rx="2"/><rect x="198" y="374" width="12" height="20" rx="2"/><rect x="218" y="374" width="12" height="20" rx="2"/><rect x="258" y="374" width="12" height="20" rx="2"/><rect x="298" y="374" width="12" height="20" rx="2"/><rect x="318" y="374" width="12" height="20" rx="2"/><rect x="178" y="414" width="12" height="20" rx="2"/><rect x="238" y="414" width="12" height="20" rx="2"/><rect x="278" y="414" width="12" height="20" rx="2"/><rect x="298" y="414" width="12" height="20" rx="2"/><rect x="338" y="414" width="12" height="20" rx="2"/><rect x="178" y="454" width="12" height="20" rx="2"/><rect x="198" y="454" width="12" height="20" rx="2"/><rect x="218" y="454" width="12" height="20" rx="2"/><rect x="258" y="454" width="12" height="20" rx="2"/><rect x="318" y="454" width="12" height="20" rx="2"/><rect x="338" y="454" width="12" height="20" rx="2"/></g>
                <g filter="url(#glow)"><rect x="218" y="213" width="12" height="20" rx="2" fill="#E8C96A" opacity=".75"><animate attributeName="opacity" values=".75;.3;.75" dur="5.2s" repeatCount="indefinite"/></rect><rect x="278" y="213" width="12" height="20" rx="2" fill="#E8C96A" opacity=".6"><animate attributeName="opacity" values=".6;.9;.6" dur="3.8s" repeatCount="indefinite"/></rect><rect x="218" y="254" width="12" height="20" rx="2" fill="#E8C96A" opacity=".8"><animate attributeName="opacity" values=".8;.35;.8" dur="6s" repeatCount="indefinite"/></rect><rect x="278" y="254" width="12" height="20" rx="2" fill="#E8C96A" opacity=".5"><animate attributeName="opacity" values=".5;.85;.5" dur="4.4s" repeatCount="indefinite"/></rect><rect x="198" y="294" width="12" height="20" rx="2" fill="#E8C96A" opacity=".7"><animate attributeName="opacity" values=".7;.25;.7" dur="7s" repeatCount="indefinite"/></rect><rect x="298" y="294" width="12" height="20" rx="2" fill="#E8C96A" opacity=".55"><animate attributeName="opacity" values=".55;.9;.55" dur="5s" repeatCount="indefinite"/></rect><rect x="218" y="334" width="12" height="20" rx="2" fill="#D4AF37" opacity=".65"><animate attributeName="opacity" values=".65;.2;.65" dur="4.2s" repeatCount="indefinite"/></rect><rect x="238" y="374" width="12" height="20" rx="2" fill="#E8C96A" opacity=".7"><animate attributeName="opacity" values=".7;.3;.7" dur="3.5s" repeatCount="indefinite"/></rect><rect x="338" y="374" width="12" height="20" rx="2" fill="#D4AF37" opacity=".5"><animate attributeName="opacity" values=".5;.85;.5" dur="6.8s" repeatCount="indefinite"/></rect><rect x="218" y="414" width="12" height="20" rx="2" fill="#E8C96A" opacity=".6"><animate attributeName="opacity" values=".6;.95;.6" dur="4.8s" repeatCount="indefinite"/></rect><rect x="278" y="454" width="12" height="20" rx="2" fill="#D4AF37" opacity=".75"><animate attributeName="opacity" values=".75;.2;.75" dur="5.5s" repeatCount="indefinite"/></rect><rect x="298" y="454" width="12" height="20" rx="2" fill="#E8C96A" opacity=".5"><animate attributeName="opacity" values=".5;.8;.5" dur="3.2s" repeatCount="indefinite"/></rect></g>
                <rect x="100" y="320" width="110" height="380" fill="url(#bldg1)"/><rect x="94" y="318" width="122" height="3" fill="#D4AF37" opacity=".3" rx="1"/>
                <rect x="310" y="300" width="120" height="400" fill="url(#bldg1)"/><rect x="304" y="298" width="132" height="3" fill="#D4AF37" opacity=".3" rx="1"/>
                <rect x="0" y="695" width="520" height="5" fill="url(#groundGrad)"/>
                <line x1="0" y1="694" x2="520" y2="694" stroke="#D4AF37" stroke-width=".5" opacity=".2"/>
                <rect x="0" y="0" width="520" height="2" fill="url(#glowGold)" opacity=".4"/>
            </svg>
        </div>

        <div class="brand-bottom">
            <div class="brand-badge">محفظة العقارات</div>
            <div class="brand-headline">
                <em>مدخل البيانات</em>
            </div>
            <p class="brand-desc">منصة متكاملة لإدارة وتتبع عقاراتك بدقة واحترافية — من التحليل المالي إلى بطاقات التملك.</p>
            <div class="brand-pills">
                <span class="brand-pill">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="11" height="11"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    إحصاءات تفاعلية
                </span>
                <span class="brand-pill">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="11" height="11"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182"/></svg>
                    تحليل مالي
                </span>
                <span class="brand-pill">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="11" height="11"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75"/></svg>
                    صلاحيات آمنة
                </span>
                <span class="brand-pill">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="11" height="11"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3"/></svg>
                    متعدد العملات
                </span>
            </div>
        </div>
    </div>

    {{-- Form Panel --}}
    <div class="form-panel">
        <div class="login-card">
            <div class="login-card-header">
                <div class="login-badge">لوحة الإدارة</div>
                <h1 class="login-title">تسجيل الدخول</h1>
                <p class="login-subtitle">أدخل بياناتك للوصول إلى لوحة التحكم</p>
            </div>

            <form wire:submit="authenticate">

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" for="email">البريد الإلكتروني</label>
                    <div class="form-input-wrap">
                        <input
                            type="email"
                            id="email"
                            wire:model="data.email"
                            class="form-input"
                            placeholder="أدخل البريد الإلكتروني"
                            autocomplete="email"
                            autofocus
                        >
                        <span class="form-input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        </span>
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label" for="password">كلمة المرور</label>
                    <div class="form-input-wrap">
                        <input
                            type="password"
                            id="password"
                            wire:model="data.password"
                            class="form-input"
                            placeholder="أدخل كلمة المرور"
                            autocomplete="current-password"
                        >
                        <span class="form-input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                        </span>
                        <button class="form-input-action" type="button" id="toggle-pass" title="إظهار/إخفاء كلمة المرور">
                            <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Validation error --}}
                @error('data.email')
                    <div class="form-error show">{{ $message }}</div>
                @enderror

                {{-- Submit --}}
                <button class="btn-login" type="submit" id="btn-login" wire:loading.class="loading" wire:target="authenticate">
                    <span class="btn-login-text" wire:loading.remove wire:target="authenticate">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                        تسجيل الدخول
                    </span>
                </button>

            </form>
        </div>

        <div class="login-footer">محفظة العقارات — نظام إدارة متكامل © {{ date('Y') }}</div>
    </div>

</div>
</div>
