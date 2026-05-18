<div class="qs-fab" id="qs-fab">
    <div class="qs-panel" id="qs-panel" onclick="event.stopPropagation()">
        <div class="qs-panel-head">
            <div>
                <div class="qs-panel-title">الإعدادات السريعة</div>
                <div class="qs-panel-sub">مظهر، خط، ألوان، عملة، مساحة، لغة</div>
            </div>
            <div style="display:flex;align-items:center;gap:6px">
                <button type="button" class="qs-reset-btn" onclick="resetAllSettings()" aria-label="إعادة تعيين الإعدادات" title="إعادة تعيين كل الإعدادات">افتراضي</button>
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
                <div class="qs-row-title">العملة</div>
                <div class="qs-tpill">
                    <button type="button" class="qs-tpill-btn active" id="cur-usd-btn" onclick="setCurrency('USD')">$ دولار</button>
                    <button type="button" class="qs-tpill-btn" id="cur-lbp-btn" onclick="setCurrency('LBP')" hidden>ليرة سورية</button>
                    <button type="button" class="qs-tpill-btn" id="cur-aed-btn" onclick="setCurrency('AED')" hidden>درهم إماراتي</button>
                </div>
            </div>

            <div class="qs-row">
                <div class="qs-row-title">المساحة</div>
                <div class="qs-tpill">
                    <button type="button" class="qs-tpill-btn active" id="area-m2-btn" onclick="setArea('m2')">م² متر</button>
                    <button type="button" class="qs-tpill-btn" id="area-ft2-btn" onclick="setArea('ft2')">قدم²</button>
                </div>
            </div>

            <div class="qs-row">
                <div class="qs-row-title">معيار التملك</div>
                <div class="qs-tpill">
                    <button type="button" class="qs-tpill-btn active" id="own-sahm-btn" onclick="setOwnership('sahm')">سهم / 2400</button>
                    <button type="button" class="qs-tpill-btn" id="own-pct-btn" onclick="setOwnership('pct')">نسبة %</button>
                </div>
            </div>

            <div class="qs-row qs-span2">
                <div class="qs-row-title">نوع الخط</div>
                <div class="qs-font-opts">
                    <label class="qs-font-opt">
                        <input type="radio" name="fontFamily" value="Tajawal" checked>
                        <span class="qs-font-radio"></span>
                        <span class="qs-font-text"><span class="qs-font-lbl" style="font-family:'Tajawal',sans-serif">Tajawal</span><span class="qs-font-sub">Tajawal</span></span>
                    </label>
                    <label class="qs-font-opt">
                        <input type="radio" name="fontFamily" value="Cairo">
                        <span class="qs-font-radio"></span>
                        <span class="qs-font-text"><span class="qs-font-lbl" style="font-family:'Cairo',sans-serif">القاهرة</span><span class="qs-font-sub">Cairo</span></span>
                    </label>
                    <label class="qs-font-opt">
                        <input type="radio" name="fontFamily" value="Amiri">
                        <span class="qs-font-radio"></span>
                        <span class="qs-font-text"><span class="qs-font-lbl" style="font-family:'Amiri',serif">أميري</span><span class="qs-font-sub">Amiri</span></span>
                    </label>
                </div>
            </div>

            <div class="qs-row qs-span2">
                <div class="qs-row-title">لون اللوحة</div>
                <div class="qs-color-opts">
                    <button type="button" class="qs-color-btn qs-swatch-default" id="panel-color-default-btn" onclick="setPanelColor('default')" title="افتراضي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-plum" id="panel-color-plum-btn" onclick="setPanelColor('plum')" title="برقوقي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-slate" id="panel-color-slate-btn" onclick="setPanelColor('slate')" title="أردوازي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-navy" id="panel-color-navy-btn" onclick="setPanelColor('navy')" title="نيلي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-forest" id="panel-color-forest-btn" onclick="setPanelColor('forest')" title="غابي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-stone" id="panel-color-stone-btn" onclick="setPanelColor('stone')" title="حجري"></button>
                    <button type="button" class="qs-color-btn qs-swatch-rose" id="panel-color-rose-btn" onclick="setPanelColor('rose')" title="وردي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-teal" id="panel-color-teal-btn" onclick="setPanelColor('teal')" title="فيروزي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-gold-panel" id="panel-color-gold-btn" onclick="setPanelColor('gold')" title="ذهبي"></button>
                </div>
            </div>

            <div class="qs-row qs-span2">
                <div class="qs-row-title">لون الخط</div>
                <div class="qs-color-opts">
                    <button type="button" class="qs-color-btn qs-swatch-fc-default" id="font-color-default-btn" onclick="setFontColor('default')" title="افتراضي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-fc-ivory" id="font-color-ivory-btn" onclick="setFontColor('ivory')" title="عاجي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-fc-gold" id="font-color-gold-btn" onclick="setFontColor('gold')" title="ذهبي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-fc-silver" id="font-color-silver-btn" onclick="setFontColor('silver')" title="فضي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-fc-mint" id="font-color-mint-btn" onclick="setFontColor('mint')" title="نعناعي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-fc-rose" id="font-color-rose-btn" onclick="setFontColor('rose')" title="وردي"></button>
                </div>
            </div>

            <div class="qs-row qs-span2">
                <div class="qs-row-title">لون شريط التنقل</div>
                <div class="qs-color-opts">
                    <button type="button" class="qs-color-btn qs-swatch-default" id="nav-color-default-btn" onclick="setNavbarColor('default')" title="افتراضي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-obsidian" id="nav-color-obsidian-btn" onclick="setNavbarColor('obsidian')" title="أوبسيديان"></button>
                    <button type="button" class="qs-color-btn qs-swatch-sand" id="nav-color-sand-btn" onclick="setNavbarColor('sand')" title="رملي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-emerald" id="nav-color-emerald-btn" onclick="setNavbarColor('emerald')" title="زمردي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-royal" id="nav-color-royal-btn" onclick="setNavbarColor('royal')" title="ملكي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-burgundy" id="nav-color-burgundy-btn" onclick="setNavbarColor('burgundy')" title="خمري"></button>
                </div>
            </div>

            <div class="qs-row qs-span2">
                <div class="qs-row-title">لون رأس الصفحة</div>
                <div class="qs-color-opts">
                    <button type="button" class="qs-color-btn qs-swatch-default" id="header-color-default-btn" onclick="setHeaderColor('default')" title="افتراضي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-obsidian" id="header-color-obsidian-btn" onclick="setHeaderColor('obsidian')" title="أوبسيديان"></button>
                    <button type="button" class="qs-color-btn qs-swatch-sand" id="header-color-sand-btn" onclick="setHeaderColor('sand')" title="رملي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-emerald" id="header-color-emerald-btn" onclick="setHeaderColor('emerald')" title="زمردي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-royal" id="header-color-royal-btn" onclick="setHeaderColor('royal')" title="ملكي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-burgundy" id="header-color-burgundy-btn" onclick="setHeaderColor('burgundy')" title="خمري"></button>
                </div>
            </div>

            <div class="qs-row qs-span2">
                <div class="qs-row-title">لون الجداول</div>
                <div class="qs-color-opts">
                    <button type="button" class="qs-color-btn qs-swatch-default" id="table-color-default-btn" onclick="setTableColor('default')" title="افتراضي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-obsidian" id="table-color-obsidian-btn" onclick="setTableColor('obsidian')" title="أوبسيديان"></button>
                    <button type="button" class="qs-color-btn qs-swatch-sand" id="table-color-sand-btn" onclick="setTableColor('sand')" title="رملي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-emerald" id="table-color-emerald-btn" onclick="setTableColor('emerald')" title="زمردي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-royal" id="table-color-royal-btn" onclick="setTableColor('royal')" title="ملكي"></button>
                    <button type="button" class="qs-color-btn qs-swatch-burgundy" id="table-color-burgundy-btn" onclick="setTableColor('burgundy')" title="خمري"></button>
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

    <button type="button" class="qs-fab-trigger" id="qs-fab-trigger" aria-expanded="false" aria-label="الإعدادات السريعة" onclick="event.stopPropagation(); toggleQuickSettings();">⚙</button>
</div>
