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
