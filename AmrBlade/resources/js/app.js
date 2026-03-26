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
    propNo: '١٠٢٤/أ',
    mahder: 'محضر رقم ٣٤٥/١٤٤٢',
    division: 'قطع تجارية على شارع رئيسي',
    geo: 'https://maps.google.com',
    details: 'برج تجاري حديث في قلب حي العليا التجاري، يحتوي على مكاتب فاخرة بمواصفات عالية وتشطيبات مميزة مع مواقف سيارات مخصصة.',
    opsCount: 3,
    opsDetails: [
      '01/01/2025 — توزيع أرباح ربع سنوي بقيمة ٢٥٠,٠٠٠ ﷼.',
      '15/03/2025 — صيانة دورية للمصاعد والواجهات الزجاجية.',
      '30/06/2025 — تجديد عقد إيجار رئيسي لمدة ثلاث سنوات.'
    ],
    payments: '٣ دفعات مسددة من أصل ٤'
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
    payments: '٤ دفعات مكتملة حتى تاريخه'
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
    payments: '٢ دفعة مسددة ودفعة واحدة متبقية'
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
    payments: '٥ دفعات مسددة بالكامل'
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
    propNo: '٥٢٣٠/هـ',
    mahder: 'محضر رقم ٢٣٠/١٤٣٩',
    division: 'مركز أعمال على شارعين',
    geo: 'https://maps.google.com',
    details: 'مبنى مكاتب دولية في منطقة مالية نشطة، يضم شركات متعددة الجنسيات وبمساحات مكتبية مرنة.',
    opsCount: 1,
    opsDetails: [
      '25/03/2025 — مراجعة شاملة للعقود الحالية وخطط إعادة التأجير.'
    ],
    payments: 'دفعة واحدة مبدئية قيد التسوية'
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
    payments: '٣ دفعات مجدولة خلال العام'
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
    payments: '٢ دفعة مسددة من أصل ٣'
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
    payments: '٣ دفعات شهرية منتظمة'
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
    payments: '٤ دفعات ربع سنوية'
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
    payments: '٢ دفعة سنوية مستلمة'
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
    propNo: '١١٢٠٠/ك',
    mahder: 'محضر رقم ١٥٠/١٤٣٧',
    division: 'مبنى مكاتب رئيسية',
    geo: 'https://maps.google.com',
    details: 'مبنى مكاتب لشركات مالية واستثمارية، مزود بقاعات اجتماعات تنفيذية وخدمات استقبال على مدار الساعة.',
    opsCount: 1,
    opsDetails: [
      '18/04/2025 — مراجعة عقود شركات الخدمات والدعم اللوجستي.'
    ],
    payments: 'دفعة مراجعة قيد الاعتماد'
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
    payments: '٣ دفعات فندقية قيد التحصيل'
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
    payments: '٤ دفعات شهرية من شركات التعاقد'
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
    payments: '٢ دفعة نصف سنوية'
  },
];

const totalAreaAll = buildings.reduce((sum, b) => sum + (b.area || 0), 0);
let filteredData = [...buildings];
let rowsLimit = 'all'; // rows per page ('all' = no limit)
let currentPage = 1;
let selectedProps = new Set();
let multiSelectEnabled = false;
let selectedCitiesFilter = new Set();
let selectedTypesFilter = new Set();
let selectedAreasFilter = new Set();

function fmt(n) {
  return n.toLocaleString('ar-SA');
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

function renderTable() {
  const tbody = document.getElementById('table-body');
  const total = filteredData.length;
  const perPage = rowsLimit === 'all' ? (total || 1) : rowsLimit;
  const totalPages = Math.max(1, Math.ceil(total / perPage));
  if (currentPage > totalPages) currentPage = totalPages;
  const start = rowsLimit === 'all' ? 0 : (currentPage - 1) * perPage;
  const end = rowsLimit === 'all' ? total : start + perPage;
  const visible = filteredData.slice(start, end);
  tbody.innerHTML = visible.map((b, idx) => {
    const rowId = `detail-row-${idx}`;
    const btnId = `detail-btn-${idx}`;
    const opsRowId = `ops-row-${idx}`;
    const isSelected = selectedProps.has(b.propNo);
    return `<tr class="${isSelected ? 'selected-row' : ''}">
      <td class="select-col" style="text-align:center">
        ${multiSelectEnabled ? `
        <input type="checkbox"
               class="row-select"
               onchange="toggleRowSelection('${b.propNo}', this.checked, this)"
               ${selectedProps.has(b.propNo) ? 'checked' : ''} />` : ''}
      </td>
      <td class="td-seq">${idx + 1}</td>
      <td>${b.propNo || '-'}</td>
      <td>${b.mahder || '-'}</td>
      <td class="col-city">${b.city}</td>
      <td class="col-type">${b.type}</td>
      <td class="col-division">${b.division || '-'}</td>
      <td>${fmt(b.area)} م²</td>
      <td style="text-align:center">
        <button type="button"
                class="geo-link"
                title="عرض التفاصيل والموقع"
                onclick="toggleDetails('${rowId}','${btnId}')">📍</button>
      </td>
      <td>${statusBadge(b.status)}</td>
      <td style="text-align:center">
        <span class="ops-toggle" onclick="toggleOperations('${opsRowId}','${rowId}')">
          ${b.opsCount || 0} عملية
        </span>
      </td>
      <td class="col-payments">${b.payments || '-'}</td>
      <td style="text-align:center">
        <button class="eye-btn" type="button" onclick="openPropertyDetails('${b.propNo}')">👁</button>
      </td>
      <td style="text-align:center">
        <button id="${btnId}" class="details-toggle" type="button" onclick="toggleDetails('${rowId}','${btnId}')">
          <span>تفاصيل</span>
          <span>▾</span>
        </button>
      </td>
    </tr>
    <tr id="${rowId}" class="detail-row">
      <td class="detail-cell" colspan="13">
        <div class="detail-title">${b.name}</div>
        <div class="detail-layout">
          <div class="detail-text">${b.details || 'لا توجد بيانات تفصيلية.'}</div>
          <div class="detail-map">
            <div class="detail-map-title">الموقع الجغرافي</div>
            ${b.geo ? `<a href="${b.geo}" target="_blank" class="geo-link" title="فتح في خرائط جوجل">📍</a>` : '<span style="color:var(--text-muted);font-size:12px">لا يوجد رابط خريطة</span>'}
          </div>
        </div>
      </td>
    </tr>
    <tr id="${opsRowId}" class="ops-row">
      <td class="ops-cell" colspan="13">
        <div class="ops-title">سجل العمليات — ${b.name}</div>
        <ul class="ops-list">
          ${(b.opsDetails || []).map(item => `<li>${item}</li>`).join('')}
        </ul>
      </td>
    </tr>`;
  }).join('');
  updateSelectColumnVisibility();
  updateSelectedCount();
  document.getElementById('row-count').textContent = buildings.length;
  const pageInfo = document.getElementById('page-info');
  if (pageInfo) pageInfo.textContent = `صفحة ${total ? currentPage : 0} من ${total ? totalPages : 0}`;
  const rowsInput = document.getElementById('rows-input');
  if (rowsInput) rowsInput.value = rowsLimit === 'all' ? total : rowsLimit;
}

function filterTable() {
  const q     = document.getElementById('table-search').value.toLowerCase();

  filteredData = buildings.filter(b => {
    const matchQ =
      !q ||
      (b.propNo   && b.propNo.includes(q))   ||
      (b.mahder   && b.mahder.includes(q))   ||
      (b.city     && b.city.includes(q))     ||
      (b.type     && b.type.includes(q))     ||
      (b.division && b.division.includes(q)) ||
      (b.details  && b.details.includes(q));
    const cities = Array.from(selectedCitiesFilter);
    const types  = Array.from(selectedTypesFilter);
    const areas  = Array.from(selectedAreasFilter);
    const matchCity = cities.length === 0 || cities.includes(b.city);
    const matchType = types.length === 0 || types.includes(b.type);
    const matchArea =
      areas.length === 0 ||
      (areas.includes('small')  && b.area < 10000) ||
      (areas.includes('medium') && b.area >= 10000 && b.area <= 20000) ||
      (areas.includes('large')  && b.area > 20000);
    return matchQ && matchCity && matchType && matchArea;
  });

  currentPage = 1;
  renderTable();
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
  if (!multiSelectEnabled) {
    selectedProps = new Set();
    const selectAll = document.getElementById('select-all');
    if (selectAll) selectAll.checked = false;
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

  areaEl.textContent = (count ? fmt(totalArea) : '--') + ' م²';
  countEl.textContent = count ? `${count} عقار` : '-- عقار';

  const pct = totalAreaAll ? Math.min(100, Math.round((totalArea / totalAreaAll) * 100)) : 0;
  barEl.style.width = pct + '%';

  modeEl.textContent = modeLabel || 'جميع العقارات';
  shareEl.textContent = `${pct}٪ من المساحة الكلية`;
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

/* ─── COLUMN TOGGLE ─── */
const colVisible = { city: true, type: true, division: true, payments: true };

function toggleColMenu() {
  document.getElementById('col-menu').classList.toggle('open');
}

document.addEventListener('click', e => {
  if (!e.target.closest('.filter-dropdown') && !e.target.closest('[onclick="toggleColMenu()"]')) {
    const colMenu = document.getElementById('col-menu');
    if (colMenu) colMenu.classList.remove('open');
    const cityMenu = document.getElementById('city-menu');
    if (cityMenu) cityMenu.classList.remove('open');
    const typeMenu = document.getElementById('type-menu');
    if (typeMenu) typeMenu.classList.remove('open');
    const areaMenu = document.getElementById('area-menu');
    if (areaMenu) areaMenu.classList.remove('open');
  }
});

function toggleCol(cls) {
  const key = cls.replace('col-','');
  colVisible[key] = !colVisible[key];
  document.querySelectorAll('.' + cls).forEach(el => {
    el.style.display = colVisible[key] ? '' : 'none';
  });
  document.getElementById('tog-' + key).textContent = colVisible[key] ? '✓' : '';
}

function toggleCityMenu() {
  const menu = document.getElementById('city-menu');
  if (menu) menu.classList.toggle('open');
}

function updateCityLabel() {
  const labelEl = document.getElementById('filter-city-label');
  if (!labelEl) return;
  const cities = Array.from(selectedCitiesFilter);
  if (cities.length === 0) {
    labelEl.textContent = 'كل المحافظات';
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
  const idMap = {
    'الرياض': 'city-riyadh',
    'جدة': 'city-jeddah',
    'الدمام': 'city-dammam',
    'أبوظبي': 'city-abu',
    'دبي': 'city-dubai'
  };
  const toggleId = idMap[city];
  if (toggleId) {
    const el = document.getElementById(toggleId);
    if (el) el.textContent = selectedCitiesFilter.has(city) ? '✓' : '';
  }
  updateCityLabel();
  currentPage = 1;
  filterTable();
}

function toggleTypeMenu() {
  const menu = document.getElementById('type-menu');
  if (menu) menu.classList.toggle('open');
}

function updateTypeLabel() {
  const labelEl = document.getElementById('filter-type-label');
  if (!labelEl) return;
  const types = Array.from(selectedTypesFilter);
  if (types.length === 0) {
    labelEl.textContent = 'كل المناطق العقارية';
  } else if (types.length === 1) {
    labelEl.textContent = types[0];
  } else {
    labelEl.textContent = `مناطق متعددة (${types.length})`;
  }
}

function toggleTypeFilter(type) {
  if (selectedTypesFilter.has(type)) {
    selectedTypesFilter.delete(type);
  } else {
    selectedTypesFilter.add(type);
  }
  const idMap = {
    'حي العليا': 'type-highrise',
    'حي الحمراء': 'type-hamra',
    'حي النزهة': 'type-nuzha',
    'حي الشاطئ': 'type-shate',
    'منطقة الكورنيش': 'type-corniche',
    'طريق الملك فهد': 'type-kingroad',
    'حي الرويس': 'type-ruwais',
    'حي الياسمين': 'type-yasmin',
    'منطقة الخليج التجاري': 'type-bay',
    'حي المنار': 'type-manar',
    'المنطقة المالية': 'type-financial',
    'حي الشاطئ الذهبي': 'type-golden',
    'حي الروضة': 'type-rawda',
    'واجهة الخليج': 'type-waterfront'
  };
  const toggleId = idMap[type];
  if (toggleId) {
    const el = document.getElementById(toggleId);
    if (el) el.textContent = selectedTypesFilter.has(type) ? '✓' : '';
  }
  updateTypeLabel();
  currentPage = 1;
  filterTable();
}

function toggleAreaMenu() {
  const menu = document.getElementById('area-menu');
  if (menu) menu.classList.toggle('open');
}

function updateAreaLabel() {
  const labelEl = document.getElementById('filter-area-label');
  if (!labelEl) return;
  const areas = Array.from(selectedAreasFilter);
  if (areas.length === 0 || areas.length === 3) {
    labelEl.textContent = 'كل المساحات';
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
  updateAreaLabel();
  currentPage = 1;
  filterTable();
}

/* ─── EXPORT ─── */
function exportExcel() {
  const header = [
    'تسلسل',
    'رقم العقار',
    'المحضر',
    'المحافظة',
    'المنطقة العقارية',
    'المقسم',
    'مساحة العقار الكلية',
    'رابط الموقع الجغرافي',
    'بيانات تفصيلية'
  ];
  const rows = filteredData.map((b, idx) => [
    idx + 1,
    b.propNo || '-',
    b.mahder || '-',
    b.city,
    b.type,
    b.division || '-',
    b.area,
    b.geo || '',
    (b.details || '').replace(/[\r\n]+/g, ' ')
  ]);
  let csv = '\uFEFF' + header.join(',') + '\n' + rows.map(r => r.join(',')).join('\n');
  const blob = new Blob([csv], {type:'text/csv;charset=utf-8'});
  const a = document.createElement('a'); a.href = URL.createObjectURL(blob);
  a.download = 'عقارات_المحفظة.csv'; a.click();
}

function exportPDF() {
  window.print();
}

/* ─── PAGE SWITCH ─── */
function openPropertyView(propNo) {
  const b = buildings.find(x => x.propNo === propNo);
  if (!b) return;
  const w = window.open('', '_blank');
  if (!w) return;
  w.document.write(`
    <html lang="ar" dir="rtl">
    <head>
      <meta charset="UTF-8">
      <title>بيانات العقار ${b.propNo}</title>
      <style>
        body { font-family: 'Tajawal', sans-serif; background:#0b0b0b; color:#f5f0e8; padding:24px; direction:rtl; }
        h1 { font-size:22px; margin-bottom:16px; color:#D4AF37; }
        .field { margin-bottom:8px; }
        .label { color:#a3a3a3; font-size:13px; }
        .value { font-size:14px; }
        .section-title { margin-top:18px; margin-bottom:8px; color:#D4AF37; font-size:15px; }
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
          font-size:12px;
          cursor:pointer;
        }
      </style>
    </head>
    <body>
      <button class="back-btn" onclick="window.close()">↩ العودة إلى لوحة العقارات</button>
      <h1>بيانات العقار ${b.propNo}</h1>
      <div class="field"><span class="label">اسم المبنى:</span> <span class="value">${b.name}</span></div>
      <div class="field"><span class="label">المحافظة:</span> <span class="value">${b.city}</span></div>
      <div class="field"><span class="label">المنطقة العقارية:</span> <span class="value">${b.type}</span></div>
      <div class="field"><span class="label">المقسم:</span> <span class="value">${b.division || '-'}</span></div>
      <div class="field"><span class="label">المساحة الكلية:</span> <span class="value">${fmt(b.area)} م²</span></div>
      <div class="field"><span class="label">الحالة:</span> <span class="value">${b.status}</span></div>
      <div class="field"><span class="label">الدفعات:</span> <span class="value">${b.payments || '-'}</span></div>
      <div class="section-title">بيانات تفصيلية</div>
      <div class="value">${b.details || 'لا توجد بيانات تفصيلية.'}</div>
      <div class="section-title">سجل العمليات</div>
      <ul>
        ${(b.opsDetails || []).map(item => `<li>${item}</li>`).join('')}
      </ul>
    </body>
    </html>
  `);
  w.document.close();
}

function openPropertyDetails(propNo) {
  const b = buildings.find(x => x.propNo === propNo);
  if (!b) return;
  const csvRows = [
    ['القسم', 'الحقل', 'القيمة'],
    ['البيانات المفتاحية', 'رقم المحضر', (b.mahder || '-').replace(/[\r\n]+/g, ' ')],
    ['البيانات المفتاحية', 'حالة العقار', (b.status || '-').replace(/[\r\n]+/g, ' ')],
    ['البيانات الأساسية', 'المحافظة', (b.city || '-').replace(/[\r\n]+/g, ' ')],
    ['البيانات الأساسية', 'اسم المنطقة', (b.type || '-').replace(/[\r\n]+/g, ' ')],
    ['البيانات الأساسية', 'المقسم', (b.division || '-').replace(/[\r\n]+/g, ' ')],
    ['البيانات الأساسية', 'نوع الاستثمار', (b.investType || 'غير محدد').replace(/[\r\n]+/g, ' ')],
    ['البيانات الأساسية', 'رابط Google Maps', (b.geo || '-').replace(/[\r\n]+/g, ' ')],
    ['البيانات الأساسية', 'تفصيل العقار', (b.details || '').replace(/[\r\n]+/g, ' ')],
    ['المساحات والملكية', 'مساحة العقار الكلية (م²)', typeof b.area === 'number' ? String(b.area) : '-'],
    [
      'المساحات والملكية',
      'قيمة العقار بالدولار (تقريبي)',
      typeof b.value === 'number'
        ? (b.value / 3.75).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
        : '-'
    ],
    ['معلومات عامة', 'الدفعات (نص)', (b.payments || '-').replace(/[\r\n]+/g, ' ')]
  ];
  const csvText = '\uFEFF' + csvRows.map(r => r.join(',')).join('\n');
  const w = window.open('', '_blank');
  if (!w) return;
  w.document.write(`
    <html lang="ar" dir="rtl">
    <head>
      <meta charset="UTF-8">
      <title>بيانات العقار ${b.propNo}</title>
      <style>
        :root {
          --gold-deep: #9b7b24;
          --gold-mid: #c49a2a;
          --gold-bright: #f6d37a;
          --gold-soft: #e4c26a;
          --ivory-warm: #f5f0e8;
          --ivory-soft: #e5ddd0;
          --black-pure: #020202;
          --bg-main: radial-gradient(circle at top, #14100b 0, #050304 45%, #020202 100%);
          --bg-elevated: #111013;
          --bg-elevated-soft: #17151b;
          --border-subtle: rgba(148,119,34,.4);
          --border-strong: rgba(212,175,55,.72);
          --text-primary: #f7f2e9;
          --text-secondary: #d3c4a8;
          --text-muted: #9b8b72;
        }
        * { box-sizing:border-box; }
        body {
          margin:0;
          min-height:100vh;
          font-family: 'Tajawal', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
          background: var(--bg-main);
          color: var(--text-primary);
          padding:32px 40px 40px;
          direction:rtl;
          line-height:1.6;
        }
        h1 {
          font-size:26px;
          margin:0 0 22px;
          color: var(--gold-bright);
          letter-spacing:.02em;
        }
        .toolbar {
          display:flex;
          align-items:center;
          justify-content:space-between;
          margin-bottom:26px;
          gap:18px;
          flex-wrap:wrap;
        }
        .toolbar-left {
          display:flex;
          align-items:center;
          gap:12px;
          flex-wrap:wrap;
        }
        .toolbar-center {
          flex:1;
          display:flex;
          justify-content:center;
        }
        .property-id-pill {
          display:inline-flex;
          align-items:center;
          gap:8px;
          padding:7px 20px;
          border-radius:999px;
          border:1px solid rgba(212,175,55,.6);
          background: radial-gradient(circle at top, rgba(212,175,55,.24), rgba(0,0,0,.95));
          box-shadow: 0 0 16px rgba(212,175,55,.55);
        }
        .property-id-label {
          font-size:12px;
          color: var(--text-muted);
        }
        .property-id-value {
          font-size:15px;
          color: var(--gold-bright);
          font-weight:600;
          letter-spacing:.04em;
        }
        .toolbar-right {
          display:flex;
          align-items:center;
          gap:10px;
        }
        .search-wrapper {
          position:relative;
          min-width:240px;
        }
        .search-input {
          width:100%;
          padding:7px 36px 7px 12px;
          border-radius:999px;
          border:1px solid rgba(212,175,55,.38);
          background: rgba(6,4,2,.9);
          color: var(--ivory-warm);
          font-family: inherit;
          font-size:13px;
          outline:none;
        }
        .search-input::placeholder {
          color: var(--text-muted);
        }
        .search-icon {
          position:absolute;
          right:10px;
          top:50%;
          transform:translateY(-50%);
          color: var(--gold-soft);
          font-size:13px;
        }
        .btn {
          display:inline-flex;
          align-items:center;
          gap:6px;
          padding:8px 20px;
          border-radius:999px;
          border:1px solid rgba(212,175,55,.45);
          background: radial-gradient(circle at top, rgba(212,175,55,.18), rgba(0,0,0,.96));
          color: var(--ivory-warm);
          font-size:13px;
          cursor:pointer;
          font-weight:500;
          box-shadow: 0 0 12px rgba(212,175,55,.4);
          transition: all .18s ease;
        }
        .btn span.icon {
          display:inline-flex;
          align-items:center;
          justify-content:center;
        }
        .btn span.icon svg {
          width:14px;
          height:14px;
          fill: var(--gold-bright);
        }
        .btn:hover {
          transform: translateY(-1px) scale(1.02);
          box-shadow: 0 0 18px rgba(212,175,55,.7);
          border-color: rgba(246,211,122,.9);
        }
        .btn.secondary {
          border-color: rgba(148,119,34,.55);
          background: linear-gradient(135deg, rgba(24,20,11,.95), rgba(9,7,4,.98));
          box-shadow:none;
          color: var(--text-secondary);
        }
        .btn.secondary:hover {
          border-color: rgba(212,175,55,.75);
          color: var(--ivory-soft);
        }
        .sections {
          display:flex;
          flex-direction:column;
          gap:20px;
        }
        .section-card {
          border-radius:16px;
          border:1px solid rgba(212,175,55,.28);
          background:
            radial-gradient(circle at top, rgba(212,175,55,.12), rgba(0,0,0,.96)),
            linear-gradient(145deg, rgba(8,6,3,.96), rgba(10,8,5,.98));
          padding:18px 20px 16px;
          box-shadow:
            0 18px 40px rgba(0,0,0,.85),
            0 0 0 1px rgba(0,0,0,.9);
        }
        .section-header {
          display:flex;
          justify-content:space-between;
          align-items:center;
          margin-bottom:12px;
        }
        .section-title {
          color: var(--gold-soft);
          font-size:15px;
          font-weight:600;
        }
        .section-sub {
          font-size:12px;
          color: var(--text-muted);
        }
        .field-grid {
          display:grid;
          grid-template-columns:repeat(auto-fit, minmax(180px,1fr));
          gap:10px 20px;
        }
        .field {
          margin-bottom:6px;
        }
        .label {
          color: var(--text-muted);
          font-size:12px;
          display:block;
          margin-bottom:3px;
        }
        .value {
          font-size:14px;
          color: var(--text-primary);
        }
        a.map-link {
          color:#7fb8ff;
          text-decoration:none;
          font-size:13px;
        }
        a.map-link:hover {
          text-decoration:underline;
          color:#b7d6ff;
        }
        ul { margin:4px 0 0; padding-right:20px; }
        li { margin-bottom:6px; font-size:13px; }
        .muted { color: var(--text-muted); font-size:12px; }
        table.simple {
          width:100%;
          border-collapse:collapse;
          font-size:13px;
        }
        table.simple th,
        table.simple td {
          border:1px solid rgba(212,175,55,.18);
          padding:5px 8px;
          text-align:right;
        }
        table.simple th {
          background: rgba(24,18,8,.96);
          color: var(--ivory-soft);
          font-weight:500;
        }
        table.simple tbody tr:nth-child(even) td {
          background: rgba(14,10,5,.72);
        }
      </style>
    </head>
    <body>
      <div class="toolbar">
        <div class="toolbar-left">
          <button class="btn secondary" onclick="window.close()">
            <span class="icon">↩</span>
            <span>العودة إلى لوحة العقارات</span>
          </button>
        </div>
        <div class="toolbar-center">
          <div class="property-id-pill">
            <span class="property-id-label">رقم العقار</span>
            <span class="property-id-value">${b.propNo}</span>
          </div>
        </div>
        <div class="toolbar-right">
          <div class="search-wrapper">
            <span class="search-icon">🔍</span>
            <input
              type="text"
              class="search-input"
              placeholder="بحث برقم العقار..."
              value="${b.propNo}"
              oninput="this.value = this.value.replace(/[^0-9٠-٩\/\-]/g,'')"
            />
          </div>
          <button class="btn" onclick="window.print()">
            <span class="icon">🖨</span>
            <span>تصدير PDF</span>
          </button>
          <button class="btn" onclick="window.exportPropertyExcel && window.exportPropertyExcel()">
            <span class="icon">
              <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                <rect x="1" y="7" width="2.4" height="7" rx="0.6"></rect>
                <rect x="6.1" y="4" width="2.4" height="10" rx="0.6"></rect>
                <rect x="11.2" y="1" width="2.4" height="13" rx="0.6"></rect>
              </svg>
            </span>
            <span>تصدير Excel</span>
          </button>
        </div>
      </div>
      <h1>${b.name}</h1>

      <div class="sections">
        <div class="section-card">
          <div class="section-header">
            <div class="section-title">القسم ١ : البيانات المفتاحية</div>
          </div>
          <div class="field-grid">
            <div class="field">
              <span class="label">رقم المحضر</span>
              <span class="value">${b.mahder || '-'}</span>
            </div>
            <div class="field">
              <span class="label">حالة العقار</span>
              <span class="value">${b.status || '-'}</span>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="section-header">
            <div class="section-title">القسم ٢ : البيانات الأساسية</div>
          </div>
          <div class="field-grid">
            <div class="field">
              <span class="label">المحافظة</span>
              <span class="value">${b.city || '-'}</span>
            </div>
            <div class="field">
              <span class="label">اسم المنطقة</span>
              <span class="value">${b.type || '-'}</span>
            </div>
            <div class="field">
              <span class="label">المقسم</span>
              <span class="value">${b.division || '-'}</span>
            </div>
            <div class="field">
              <span class="label">نوع الاستثمار</span>
              <span class="value">${b.investType || 'غير محدد'}</span>
            </div>
            <div class="field">
              <span class="label">رابط موقع Google Maps</span>
              <span class="value">
                ${b.geo ? `<a class="map-link" href="${b.geo}" target="_blank" rel="noopener">فتح الخريطة</a>` : '<span class="muted">لا يوجد رابط</span>'}
              </span>
            </div>
          </div>
          <div class="field" style="margin-top:8px;">
            <span class="label">تفصيل العقار</span>
            <span class="value">${b.details || 'لا توجد بيانات تفصيلية.'}</span>
          </div>
        </div>

        <div class="section-card">
          <div class="section-header">
            <div class="section-title">القسم ٣ : المساحات والملكية</div>
          </div>
          <div class="field-grid">
            <div class="field">
              <span class="label">مساحة العقار الكلية</span>
              <span class="value">${typeof b.area === 'number' ? b.area.toLocaleString('ar-EG') + ' م²' : '-'}</span>
            </div>
            <div class="field">
              <span class="label">قيمة العقار بالدولار الأمريكي (تقريبي)</span>
              <span class="value">
                ${
                  (typeof b.value === 'number')
                    ? (b.value / 3.75).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' USD'
                    : '-'
                }
              </span>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="section-header">
            <div class="section-title">القسم ٤ : الملاك</div>
            <div class="section-sub">يمكن لاحقًا إضافة أكثر من مالك</div>
          </div>
          <table class="simple">
            <thead>
              <tr>
                <th>اسم المالك</th>
                <th>معيار التملك</th>
                <th>قيمة التملك</th>
                <th>مالك حالي؟</th>
                <th>تاريخ الشراء</th>
                <th>طريقة الشراء</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="6" class="muted">لا توجد بيانات مالكين محددة في هذا الإصدار.</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="section-card">
          <div class="section-header">
            <div class="section-title">القسم ٥ : الإشارات</div>
          </div>
          <table class="simple">
            <thead>
              <tr>
                <th>رقم الإشارة</th>
                <th>تاريخ الإشارة</th>
                <th>نوع الإشارة</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="3" class="muted">لا توجد إشارات مسجلة.</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="section-card">
          <div class="section-header">
            <div class="section-title">القسم ٦ : الملفات المرفقة</div>
          </div>
          <div class="field">
            <span class="label">الملفات الملحقة</span>
            <span class="value muted">${b.files && b.files.length ? 'يوجد ملفات مرفقة (تحتاج لربط فعلي).' : 'لا توجد ملفات مرفقة.'}</span>
          </div>
        </div>

        <div class="section-card">
          <div class="section-header">
            <div class="section-title">القسم ٧ : الدفعات بالدولار</div>
          </div>
          <table class="simple">
            <thead>
              <tr>
                <th>مجمل المدين (USD)</th>
                <th>مجمل الدائن (USD)</th>
                <th>مجموع الرصيد (USD)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="muted">غير محدد</td>
                <td class="muted">غير محدد</td>
                <td class="muted">غير محدد</td>
              </tr>
            </tbody>
          </table>
          <div class="field" style="margin-top:6px;">
            <span class="label">ملاحظة</span>
            <span class="value muted">يمكن ربط هذه الأرقام مستقبلاً بنظام الدفعات الفعلي.</span>
          </div>
        </div>

        <div class="section-card">
          <div class="section-header">
            <div class="section-title">سجل العمليات</div>
          </div>
          ${
            (b.opsDetails && b.opsDetails.length)
              ? `<ul>${b.opsDetails.map(item => `<li>${item}</li>`).join('')}</ul>`
              : '<div class="muted">لا يوجد سجل عمليات.</div>'
          }
        </div>
      </div>
    </body>
    </html>
  `);
  // تعريف دالة التصدير في نافذة التفاصيل نفسها
  w.exportPropertyExcel = function () {
    const csv = csvText;
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8' });
    const a = w.document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'بيانات_العقار_${b.propNo}.csv';
    a.click();
  };
  w.document.close();
}

function toggleOperations(opsRowId, detailRowId) {
  const opsRow = document.getElementById(opsRowId);
  const detailRow = document.getElementById(detailRowId);
  if (!opsRow) return;
  const isOpen = opsRow.classList.toggle('open');
  if (isOpen && detailRow) {
    detailRow.classList.remove('open');
  }
}

function toggleDetails(rowId, btnId) {
  const row = document.getElementById(rowId);
  const btn = document.getElementById(btnId);
  if (!row || !btn) return;
  const isOpen = row.classList.toggle('open');
  btn.classList.toggle('open', isOpen);
  const arrows = btn.querySelectorAll('span:last-child');
  if (isOpen) {
    btn.lastElementChild.textContent = '▴';
  } else {
    btn.lastElementChild.textContent = '▾';
  }

  // إخفاء صف العمليات في حال فتح تفاصيل العقار
  const idx = rowId.split('-').pop();
  const opsRow = document.getElementById('ops-row-' + idx);
  if (isOpen && opsRow) {
    opsRow.classList.remove('open');
  }
}

function switchPage(id, btn) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  document.getElementById('page-' + id).classList.add('active');
  if (btn) btn.classList.add('active');

  const titles = { dashboard: 'لوحة <span>التحكم</span>', properties: 'بطاقات <span>العقار</span>' };
  document.getElementById('topbar-title').innerHTML = titles[id];
}

function handleLogout() {
  if (confirm('هل تريد تأكيد تسجيل الخروج من لوحة التحكم؟')) {
    // هنا يمكن لاحقاً ربط زر الخروج بنظام الدخول الحقيقي
    alert('تم تسجيل الخروج (تنفيذ تجريبي في الواجهة فقط).');
  }
}

/* ─── DATE & TIME ─── */
function updateTime() {
  const d = new Date();
  const timeStr = d.toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
  const el = document.getElementById('topbar-time');
  if (el) el.textContent = timeStr;
}

(function() {
  const d = new Date();
  const opts = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
  document.getElementById('topbar-date').textContent = d.toLocaleDateString('ar-SA', opts);
  updateTime();
  setInterval(updateTime, 1000);
})();

/* ─── DASHBOARD HERO PARALLAX ─── */
(function() {
  const hero = document.getElementById('dashboard-hero');
  if (!hero) return;
  const svg = hero.querySelector('svg');
  const layers = Array.from(hero.querySelectorAll('.page-hero-layer'));

  function handleMove(e) {
    const rect = hero.getBoundingClientRect();
    const x = (e.clientX - rect.left) / rect.width - 0.5;  // -0.5 .. 0.5
    const y = (e.clientY - rect.top) / rect.height - 0.5;

    const rotateY = x * 10; // يمين / يسار
    const rotateX = -y * 8; // أعلى / أسفل
    if (svg) {
      svg.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
    }

    layers.forEach(layer => {
      const depth = parseFloat(layer.getAttribute('data-depth') || '1');
      const tx = -x * depth * 6;
      const ty = -y * depth * 4;
      layer.style.transform = `translate(${tx}px, ${ty}px)`;
    });
  }

  function reset() {
    if (svg) {
      svg.style.transform = 'rotateX(0deg) rotateY(0deg)';
    }
    layers.forEach(layer => {
      layer.style.transform = 'translate(0,0)';
    });
  }

  hero.addEventListener('mousemove', handleMove);
  hero.addEventListener('mouseleave', reset);
})();

/* ─── INIT ─── */
renderTable();
renderSelectionCard(filteredData, 'جميع العقارات');

// Expose handlers used by inline HTML attributes (onclick/oninput/onchange)
Object.assign(window, {
  switchPage,
  handleLogout,
  filterTable,
  handleRowsInput,
  toggleCityMenu,
  toggleCityFilter,
  toggleTypeMenu,
  toggleTypeFilter,
  toggleAreaMenu,
  toggleAreaFilter,
  toggleColMenu,
  toggleCol,
  toggleMultiSelect,
  toggleSelectAll,
  sortBySeq,
  sortByArea,
  changePage,
  exportExcel,
  exportPDF,
  openPropertyView,
});
