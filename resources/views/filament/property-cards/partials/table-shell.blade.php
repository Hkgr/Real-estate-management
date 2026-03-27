        <div class="table-toolbar">
          <div class="search-wrap">
            <input class="search-input" type="text" placeholder="ابحث برقم العقار، المحضر، المحافظة أو المنطقة…" id="table-search" oninput="filterTable()">
          </div>

          <div class="filter-dropdown">
            <button type="button" class="filter-multi-btn" onclick="toggleCityMenu()" id="filter-city-label">
              كل المحافظات
            </button>
            <div class="col-menu" id="city-menu">
              <div class="col-menu-item" onclick="toggleCityFilter('الرياض')"><div class="col-toggle" id="city-riyadh">✓</div> الرياض</div>
              <div class="col-menu-item" onclick="toggleCityFilter('جدة')"><div class="col-toggle" id="city-jeddah">✓</div> جدة</div>
              <div class="col-menu-item" onclick="toggleCityFilter('الدمام')"><div class="col-toggle" id="city-dammam">✓</div> الدمام</div>
              <div class="col-menu-item" onclick="toggleCityFilter('أبوظبي')"><div class="col-toggle" id="city-abu">✓</div> أبوظبي</div>
              <div class="col-menu-item" onclick="toggleCityFilter('دبي')"><div class="col-toggle" id="city-dubai">✓</div> دبي</div>
            </div>
          </div>

          <div class="filter-dropdown">
            <button type="button" class="filter-multi-btn" onclick="toggleTypeMenu()" id="filter-type-label">
              كل المناطق العقارية
            </button>
            <div class="col-menu" id="type-menu">
              <div class="col-menu-item" onclick="toggleTypeFilter('حي العليا')"><div class="col-toggle" id="type-highrise">✓</div> حي العليا</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي الحمراء')"><div class="col-toggle" id="type-hamra">✓</div> حي الحمراء</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي النزهة')"><div class="col-toggle" id="type-nuzha">✓</div> حي النزهة</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي الشاطئ')"><div class="col-toggle" id="type-shate">✓</div> حي الشاطئ</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('منطقة الكورنيش')"><div class="col-toggle" id="type-corniche">✓</div> منطقة الكورنيش</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('طريق الملك فهد')"><div class="col-toggle" id="type-kingroad">✓</div> طريق الملك فهد</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي الرويس')"><div class="col-toggle" id="type-ruwais">✓</div> حي الرويس</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي الياسمين')"><div class="col-toggle" id="type-yasmin">✓</div> حي الياسمين</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('منطقة الخليج التجاري')"><div class="col-toggle" id="type-bay">✓</div> منطقة الخليج التجاري</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي المنار')"><div class="col-toggle" id="type-manar">✓</div> حي المنار</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('المنطقة المالية')"><div class="col-toggle" id="type-financial">✓</div> المنطقة المالية</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي الشاطئ الذهبي')"><div class="col-toggle" id="type-golden">✓</div> حي الشاطئ الذهبي</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('حي الروضة')"><div class="col-toggle" id="type-rawda">✓</div> حي الروضة</div>
              <div class="col-menu-item" onclick="toggleTypeFilter('واجهة الخليج')"><div class="col-toggle" id="type-waterfront">✓</div> واجهة الخليج</div>
            </div>
          </div>

          <div class="filter-dropdown">
            <button type="button" class="filter-multi-btn" onclick="toggleAreaMenu()" id="filter-area-label">
              كل المساحات
            </button>
            <div class="col-menu" id="area-menu">
              <div class="col-menu-item" onclick="toggleAreaFilter('small')"><div class="col-toggle" id="area-small">✓</div> أقل من ١٠٬٠٠٠ م²</div>
              <div class="col-menu-item" onclick="toggleAreaFilter('medium')"><div class="col-toggle" id="area-medium">✓</div> ١٠٬٠٠٠ - ٢٠٬٠٠٠ م²</div>
              <div class="col-menu-item" onclick="toggleAreaFilter('large')"><div class="col-toggle" id="area-large">✓</div> أكثر من ٢٠٬٠٠٠ م²</div>
            </div>
          </div>

          <div class="toolbar-separator"></div>

          <div style="position:relative">
            <button class="toolbar-btn toolbar-btn-outline" onclick="toggleColMenu()">
              ⊟ إخفاء أعمدة
            </button>
            <div class="col-menu" id="col-menu">
              <div class="col-menu-item" onclick="toggleCol('col-city')"><div class="col-toggle" id="tog-city">✓</div> المحافظة</div>
              <div class="col-menu-item" onclick="toggleCol('col-type')"><div class="col-toggle" id="tog-type">✓</div> المنطقة العقارية</div>
              <div class="col-menu-item" onclick="toggleCol('col-division')"><div class="col-toggle" id="tog-division">✓</div> المقسم / الوصف</div>
              <div class="col-menu-item" onclick="toggleCol('col-payments')"><div class="col-toggle" id="tog-payments">✓</div> الدفعات</div>
            </div>
          </div>

          <button class="toolbar-btn toolbar-btn-outline" onclick="alert('يمكنك إعادة ترتيب الأعمدة بالسحب والإفلات')">
            ⇅ إعادة الترتيب
          </button>

          <div class="toolbar-separator"></div>

          <button class="toolbar-btn toolbar-btn-gold" onclick="toggleMultiSelect()" id="multi-select-btn">
            اختيار متعدد
          </button>

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
          <div class="export-btns">
            <button class="btn-export btn-excel" onclick="exportExcel()">
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="1" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M4 4l6 6M10 4L4 10" stroke="currentColor" stroke-width="1.5"/></svg>
              تصدير Excel
            </button>
            <button class="btn-export btn-pdf" onclick="exportPDF()">
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="1" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M4 7h6M4 4h6M4 10h4" stroke="currentColor" stroke-width="1.5"/></svg>
              تصدير PDF
            </button>
          </div>
        </div>

        <!-- TABLE -->
        <div class="table-card" id="property-table-card">
          <div class="table-overflow">
            <table class="big-table" id="main-table">
              <thead>
                <tr>
                  <th class="select-col">
                    <div class="th-inner">
                      <input type="checkbox" id="select-all" onclick="toggleSelectAll()" />
                    </div>
                  </th>
                  <th onclick="sortBySeq()" style="cursor:pointer">
                    <div class="th-inner">
                      تسلسل
                      <span class="sort-icon" id="sort-seq">↕</span>
                    </div>
                  </th>
                  <th><div class="th-inner">رقم العقار</div></th>
                  <th><div class="th-inner">المحضر</div></th>
                  <th class="col-city"><div class="th-inner">المحافظة</div></th>
                  <th class="col-type"><div class="th-inner">المنطقة العقارية</div></th>
                  <th class="col-division"><div class="th-inner">المقسم</div></th>
                  <th onclick="sortByArea()" style="cursor:pointer">
                    <div class="th-inner">
                      مساحة العقار الكلية
                      <span class="sort-icon" id="sort-area">↕</span>
                    </div>
                  </th>
                  <th><div class="th-inner">الموقع الجغرافي</div></th>
                  <th><div class="th-inner">الحالة</div></th>
                  <th><div class="th-inner">العمليات</div></th>
                  <th class="col-payments"><div class="th-inner">الدفعات</div></th>
                  <th><div class="th-inner">عرض</div></th>
                </tr>
              </thead>
              <tbody id="table-body">
                <!-- rows injected by JS -->
              </tbody>
            </table>
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