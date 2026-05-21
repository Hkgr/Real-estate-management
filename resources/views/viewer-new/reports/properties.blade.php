@extends('viewer-new.layouts.app')

@section('page_title', 'تقرير العقارات')
@section('topbar_title', 'تقرير العقارات')
@section('active', 'reports')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'العودة إلى بوابة التقارير')

@section('content')
    @php
        $paginator = $properties ?? null;
        $hasPaginator = $paginator && method_exists($paginator, 'total');

        $totalResults = $hasPaginator ? $paginator->total() : 0;
        $currentPage = $hasPaginator ? $paginator->currentPage() : 1;
        $lastPage = $hasPaginator ? $paginator->lastPage() : 1;
        $currentCount = $hasPaginator ? $paginator->count() : 0;
        $propertyTableColspan = 28;
        $propertyTableColumnKeys = [
            'id', 'property_name', 'property_country', 'card_governorate', 'card_region_name',
            'card_subdivision', 'card_record_number', 'card_property_number', 'card_total_area',
            'card_area_unit', 'total_property_value_usd', 'owned_property_value_usd', 'actual_price_usd',
            'estimated_price_usd', 'card_status', 'card_investment_type', 'card_purchase_method',
            'card_sale_date', 'final_balance', 'card_google_maps_url', 'owners_count', 'operations_count',
            'signals_count', 'files_count', 'installments_count', 'updated_at', 'card_property_details', 'actions',
        ];

        $kpiItems = [
            ['label' => 'عدد العقارات', 'value' => $metrics['total_properties'] ?? '—'],
            ['label' => 'المساحة الإجمالية', 'value' => $metrics['total_area'] ?? '—'],
            ['label' => 'القيمة التقديرية', 'value' => $metrics['total_estimated_value'] ?? '—'],
            ['label' => 'عقارات مرتبطة بملاك', 'value' => $metrics['linked_owners_count'] ?? '—'],
            ['label' => 'عقارات عليها إشارات', 'value' => $metrics['properties_with_signals'] ?? '—'],
            ['label' => 'عقارات لها ملفات', 'value' => $metrics['properties_with_files'] ?? '—'],
            ['label' => 'آخر تحديث', 'value' => $metrics['last_update'] ?? '—'],
        ];

        $filterLabels = [
            'q' => 'بحث شامل',
            'country' => 'الدولة',
            'governorate' => 'المحافظة',
            'region' => 'المنطقة',
            'status' => 'الحالة',
            'investment_type' => 'نوع الاستثمار',
            'purchase_method' => 'طريقة الشراء',
            'min_area' => 'المساحة من',
            'max_area' => 'المساحة إلى',
            'min_value' => 'القيمة من',
            'max_value' => 'القيمة إلى',
            'date_from' => 'من تاريخ',
            'date_to' => 'إلى تاريخ',
            'has_owners' => 'لديه ملاك',
            'has_signals' => 'لديه إشارات',
            'has_files' => 'لديه ملفات',
        ];

        $activeFilters = [];
        foreach ($filterLabels as $key => $label) {
            $value = $filters[$key] ?? null;

            if (in_array($key, ['has_owners', 'has_signals', 'has_files'], true)) {
                if ($value === null || $value === '') {
                    continue;
                }

                if ($value === true || $value === 1 || $value === '1') {
                    $value = 'نعم';
                } elseif ($value === false || $value === 0 || $value === '0') {
                    $value = 'لا';
                } else {
                    continue;
                }
            } elseif ($value === null || $value === '') {
                continue;
            }

            $activeFilters[] = ['label' => $label, 'value' => $value];
        }
    @endphp

    <section class="vn-properties-report" id="page-properties">
        <header class="page-header vn-report-hero">
            <div class="page-header-row vn-report-hero__row">
                <div class="vn-report-hero__content">
                    <div class="page-eyebrow">تقرير العقارات الكامل</div>
                    <h1 class="page-title">تقرير <em>العقارات</em></h1>
                    <p class="page-subtitle">جميع بطاقات العقارات والبيانات المرتبطة بها — مع تصفية متقدمة واستعراض منظم</p>
                </div>
                <div id="props-cards-float" class="vn-report-hero__meta-wrap">
                    <div class="selection-card vn-report-hero__meta">
                        <div class="selection-title">ملخص النتائج الحالية</div>
                        <a href="{{ route('viewer-new.reports') }}" class="vn-report-hero__back">العودة إلى بوابة التقارير</a>
                        <div class="selection-main-value" id="vn-selection-area">{{ $metrics['total_area'] ?? '—' }}</div>
                        <div class="selection-subvalue" id="vn-selection-count">إجمالي النتائج: {{ number_format((int) $totalResults) }}</div>
                        <div class="selection-bar" aria-hidden="true"><div class="selection-bar-fill" id="vn-selection-bar-fill" style="width:{{ $totalResults > 0 ? '100' : '0' }}%"></div></div>
                        <div class="selection-meta">
                            <span id="vn-selection-mode">نتائج البحث الحالية</span>
                            <span id="vn-selection-share">{{ number_format((int) $currentCount) }} معروض</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section class="stats-grid vn-report-kpi-grid" aria-label="مؤشرات تقرير العقارات">
            @foreach ($kpiItems as $item)
                <article class="stat-card vn-report-kpi-card">
                    <div class="stat-label">{{ $item['label'] }}</div>
                    <div class="stat-value">{{ filled((string) ($item['value'] ?? null)) ? $item['value'] : '—' }}</div>
                </article>
            @endforeach
        </section>

        <div id="vn-properties-focus-target" class="report-focus-target" data-properties-focus-target>
        <section class="table-toolbar vn-report-toolbar" aria-label="شريط أدوات تقرير العقارات">
            <div class="toolbar-main-actions vn-report-toolbar__main">
                <div class="toolbar-inline-search vn-report-toolbar__search active" id="vn-toolbar-inline-search">
                    <label for="filter-q" class="vn-report-toolbar__search-label filter-label">بحث شامل</label>
                    <input id="filter-q" class="search-input" type="text" name="q" form="vn-properties-report-generator-form" value="{{ $filters['q'] ?? '' }}" placeholder="بحث برقم المحضر أو المنطقة أو الملاحظات" />
                    <button type="button" class="toolbar-search-close vn-report-toolbar-button" data-properties-clear-search aria-label="مسح البحث">✕</button>
                </div>
                <button type="button" class="toolbar-main-btn vn-report-toolbar-button vn-report-toolbar-button--primary active" data-report-generator-toggle aria-expanded="true" aria-controls="vn-properties-generator-panel" id="toolbar-main-reports">مولد تقارير</button>
                <button type="button" class="toolbar-main-btn vn-report-toolbar-button vn-report-toolbar-button--disabled" disabled aria-disabled="true" title="سيتم دعم التصدير لاحقاً">تصدير ▾</button>
                <button type="button" class="toolbar-main-btn vn-report-toolbar-button" data-properties-fullscreen id="properties-fullscreen-btn">⛶ ملء الشاشة</button>
            </div>
        </section>

        <section id="vn-properties-generator-panel" class="toolbar-mode-panel vn-report-generator is-open" data-report-generator-panel>
            <form id="vn-properties-report-generator-form" method="GET" action="{{ route('viewer-new.reports.properties') }}" data-report-generator-form>
                <div class="vn-report-generator__filters">

                <div class="vn-report-generator__field">
                    <label for="filter-country">الدولة</label>
                    <select id="filter-country" name="country">
                        <option value="">الكل</option>
                        @foreach (($countryOptions ?? []) as $option)
                            <option value="{{ $option }}" @selected(($filters['country'] ?? '') === (string) $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="vn-report-generator__field">
                    <label for="filter-governorate">المحافظة</label>
                    <select id="filter-governorate" name="governorate">
                        <option value="">الكل</option>
                        @foreach (($governorateOptions ?? []) as $option)
                            <option value="{{ $option }}" @selected(($filters['governorate'] ?? '') === (string) $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="vn-report-generator__field">
                    <label for="filter-region">المنطقة</label>
                    <select id="filter-region" name="region">
                        <option value="">الكل</option>
                        @foreach (($regionOptions ?? []) as $option)
                            <option value="{{ $option }}" @selected(($filters['region'] ?? '') === (string) $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="vn-report-generator__field">
                    <label for="filter-status">الحالة</label>
                    <select id="filter-status" name="status">
                        <option value="">الكل</option>
                        @foreach (($statusOptions ?? []) as $option)
                            <option value="{{ $option }}" @selected(($filters['status'] ?? '') === (string) $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="vn-report-generator__field">
                    <label for="filter-investment-type">نوع الاستثمار</label>
                    <select id="filter-investment-type" name="investment_type">
                        <option value="">الكل</option>
                        @foreach (($investmentTypeOptions ?? []) as $option)
                            <option value="{{ $option }}" @selected(($filters['investment_type'] ?? '') === (string) $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="vn-report-generator__field">
                    <label for="filter-purchase-method">طريقة الشراء</label>
                    <select id="filter-purchase-method" name="purchase_method">
                        <option value="">الكل</option>
                        @foreach (($purchaseMethodOptions ?? []) as $option)
                            <option value="{{ $option }}" @selected(($filters['purchase_method'] ?? '') === (string) $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="vn-report-generator__field">
                    <label for="filter-min-area">المساحة من</label>
                    <input id="filter-min-area" type="number" step="0.01" name="min_area" value="{{ $filters['min_area'] ?? '' }}" />
                </div>
                <div class="vn-report-generator__field">
                    <label for="filter-max-area">المساحة إلى</label>
                    <input id="filter-max-area" type="number" step="0.01" name="max_area" value="{{ $filters['max_area'] ?? '' }}" />
                </div>
                <div class="vn-report-generator__field">
                    <label for="filter-min-value">القيمة من</label>
                    <input id="filter-min-value" type="number" step="0.01" name="min_value" value="{{ $filters['min_value'] ?? '' }}" />
                </div>
                <div class="vn-report-generator__field">
                    <label for="filter-max-value">القيمة إلى</label>
                    <input id="filter-max-value" type="number" step="0.01" name="max_value" value="{{ $filters['max_value'] ?? '' }}" />
                </div>
                <div class="vn-report-generator__field">
                    <label for="filter-date-from">من تاريخ</label>
                    <input id="filter-date-from" type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" />
                </div>
                <div class="vn-report-generator__field">
                    <label for="filter-date-to">إلى تاريخ</label>
                    <input id="filter-date-to" type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" />
                </div>
                @foreach (['has_owners' => 'لديه ملاك', 'has_signals' => 'لديه إشارات', 'has_files' => 'لديه ملفات'] as $name => $label)
                    <div class="vn-report-generator__field">
                        <label for="filter-{{ $name }}">{{ $label }}</label>
                        <select id="filter-{{ $name }}" name="{{ $name }}">
                            <option value="">الكل</option>
                            <option value="1" @selected(($filters[$name] ?? null) === '1' || ($filters[$name] ?? null) === 1 || ($filters[$name] ?? null) === true)>نعم</option>
                            <option value="0" @selected(($filters[$name] ?? null) === '0' || ($filters[$name] ?? null) === 0 || ($filters[$name] ?? null) === false)>لا</option>
                        </select>
                    </div>
                @endforeach

                
                </div>
                <div class="vn-report-generator__columns" data-column-picker>
                    @php
                        $columnOptions = [
                            'id' => 'ID العقار',
                            'property_name' => 'اسم العقار',
                            'property_country' => 'الدولة',
                            'card_governorate' => 'المحافظة',
                            'card_region_name' => 'المنطقة',
                            'card_subdivision' => 'التقسيم',
                            'card_record_number' => 'رقم المحضر',
                            'card_property_number' => 'رقم العقار',
                            'card_total_area' => 'المساحة',
                            'card_area_unit' => 'وحدة المساحة',
                            'total_property_value_usd' => 'القيمة الإجمالية',
                            'owned_property_value_usd' => 'القيمة المملوكة',
                            'actual_price_usd' => 'السعر الفعلي',
                            'estimated_price_usd' => 'السعر التقريبي',
                            'card_status' => 'الحالة',
                            'card_investment_type' => 'نوع الاستثمار',
                            'card_purchase_method' => 'طريقة الشراء',
                            'card_sale_date' => 'تاريخ البيع',
                            'final_balance' => 'الرصيد النهائي',
                            'card_google_maps_url' => 'الخريطة',
                            'owners_count' => 'الملاك',
                            'operations_count' => 'العمليات',
                            'signals_count' => 'الإشارات',
                            'files_count' => 'الملفات',
                            'installments_count' => 'الدفعات',
                            'updated_at' => 'آخر تحديث',
                            'card_property_details' => 'ملاحظات',
                            'actions' => 'الإجراءات',
                        ];
                    @endphp
                    @foreach ($columnOptions as $key => $label)
                        <label class="vn-report-column-option vn-report-column-option-card">
                            <input type="checkbox" data-column-toggle value="{{ $key }}" checked>
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="vn-col-pin-bar" data-properties-pin-bar>
                    <button type="button" class="vn-col-unpin-all" data-properties-unpin-all>إلغاء تثبيت الكل</button>
                    <span class="vn-col-pin-count" data-properties-pin-count></span>
                </div>
                <div class="vn-report-generator__actions">
                    <button type="submit" class="vn-report-toolbar-button">تطبيق الفلاتر</button>
                    <a href="{{ route('viewer-new.reports.properties') }}" class="vn-report-toolbar-button">إعادة تعيين</a>
                    <button type="button" class="vn-report-toolbar-button" data-reset-columns>إعادة الافتراضي</button>
                    <button type="button" class="vn-report-toolbar-button vn-report-toolbar-button--primary" data-generate-report>توليد تقرير</button>
                </div>
            </form>
        </section>

        <section class="vn-active-filter-chips" aria-label="الفلاتر المفعلة">
            @if (count($activeFilters) > 0)
                @foreach ($activeFilters as $activeFilter)
                    <span class="vn-active-filter-chip">{{ $activeFilter['label'] }}: {{ $activeFilter['value'] }}</span>
                @endforeach
                <a href="{{ route('viewer-new.reports.properties') }}">إعادة تعيين</a>
            @else
                <p>لا توجد فلاتر مفعّلة حالياً.</p>
            @endif
        </section>

        <section class="vn-results-summary">
            <span>عدد النتائج الكلي: {{ number_format((int) $totalResults) }}</span>
            <span>الصفحة الحالية: {{ $currentPage }}</span>
            <span>آخر صفحة: {{ $lastPage }}</span>
            <span>عدد السجلات المعروضة: {{ $currentCount }}</span>
        </section>

        @if ($currentCount > 0)
            <div class="vn-table-card vn-property-table-card">
            <div class="vn-table-with-scroll">
            <div class="vn-table-responsive vn-properties-table" id="vn-properties-overflow">
                <table id="vn-properties-table" class="vn-big-table" data-property-table-colspan="{{ $propertyTableColspan }}">
                    <colgroup id="vn-properties-colgroup">
                        @foreach ($propertyTableColumnKeys as $colKey)
                            @php
                                $colStyle = match ($colKey) {
                                    'id' => 'width:110px;min-width:110px',
                                    'property_name' => 'min-width:200px;width:15%',
                                    'owners_count' => 'min-width:190px;width:12%',
                                    'card_property_details', 'actions' => 'width:1px',
                                    default => 'width:1px',
                                };
                            @endphp
                            <col class="vn-col-{{ $colKey }}" data-column-key="{{ $colKey }}" style="{{ $colStyle }}">
                        @endforeach
                    </colgroup>
                    <thead>
                        <tr>
                            <th data-column-key="id"><div class="vn-th-inner">ID العقار</div></th>
                            <th data-column-key="property_name"><div class="vn-th-inner">اسم العقار</div></th>
                            <th data-column-key="property_country"><div class="vn-th-inner">الدولة</div></th>
                            <th data-column-key="card_governorate"><div class="vn-th-inner">المحافظة</div></th>
                            <th data-column-key="card_region_name"><div class="vn-th-inner">المنطقة</div></th>
                            <th data-column-key="card_subdivision"><div class="vn-th-inner">التقسيم</div></th>
                            <th data-column-key="card_record_number"><div class="vn-th-inner">رقم المحضر</div></th>
                            <th data-column-key="card_property_number"><div class="vn-th-inner">رقم العقار</div></th>
                            <th data-column-key="card_total_area"><div class="vn-th-inner">المساحة</div></th>
                            <th data-column-key="card_area_unit"><div class="vn-th-inner">وحدة المساحة</div></th>
                            <th data-column-key="total_property_value_usd"><div class="vn-th-inner">القيمة الإجمالية</div></th>
                            <th data-column-key="owned_property_value_usd"><div class="vn-th-inner">القيمة المملوكة</div></th>
                            <th data-column-key="actual_price_usd"><div class="vn-th-inner">السعر الفعلي</div></th>
                            <th data-column-key="estimated_price_usd"><div class="vn-th-inner">السعر التقريبي</div></th>
                            <th data-column-key="card_status"><div class="vn-th-inner">الحالة</div></th>
                            <th data-column-key="card_investment_type"><div class="vn-th-inner">نوع الاستثمار</div></th>
                            <th data-column-key="card_purchase_method"><div class="vn-th-inner">طريقة الشراء</div></th>
                            <th data-column-key="card_sale_date"><div class="vn-th-inner">تاريخ البيع</div></th>
                            <th data-column-key="final_balance"><div class="vn-th-inner">الرصيد النهائي</div></th>
                            <th data-column-key="card_google_maps_url"><div class="vn-th-inner">الخريطة</div></th>
                            <th data-column-key="owners_count"><div class="vn-th-inner">الملاك</div></th>
                            <th data-column-key="operations_count"><div class="vn-th-inner">العمليات</div></th>
                            <th data-column-key="signals_count"><div class="vn-th-inner">الإشارات</div></th>
                            <th data-column-key="files_count"><div class="vn-th-inner">الملفات</div></th>
                            <th data-column-key="installments_count"><div class="vn-th-inner">الدفعات</div></th>
                            <th data-column-key="updated_at"><div class="vn-th-inner">آخر تحديث</div></th>
                            <th data-column-key="card_property_details"><div class="vn-th-inner">ملاحظات</div></th>
                            <th data-column-key="actions"><div class="vn-th-inner">الإجراءات</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($properties as $property)
                            @php
                                $areaUnitRaw = strtolower((string) (($columns['card_area_unit'] ?? false) ? ($property->card_area_unit ?? '') : ''));
                                $areaUnit = match ($areaUnitRaw) {
                                    'meters', 'square_meter' => 'م²',
                                    'shares' => 'سهم',
                                    'percentage' => '%',
                                    default => filled($areaUnitRaw) ? $property->card_area_unit : '—',
                                };

                                $statusRaw = (string) (($columns['card_status'] ?? false) ? ($property->card_status ?? '') : '');
                                $statusNormalized = strtolower(trim($statusRaw));
                                $statusClass = 'vn-status-badge--muted';
                                $statusLabel = filled($statusRaw) ? $statusRaw : '—';

                                if (in_array($statusNormalized, ['active', 'نشط'], true)) {
                                    $statusClass = 'vn-status-badge--success';
                                    $statusLabel = 'نشط';
                                } elseif (in_array($statusNormalized, ['frozen', 'مجمد'], true)) {
                                    $statusClass = 'vn-status-badge--warning';
                                    $statusLabel = 'مجمد';
                                } elseif (in_array($statusNormalized, ['sold', 'closed', 'cancelled', 'مباع', 'مغلق', 'ملغى'], true)) {
                                    $statusClass = 'vn-status-badge--danger';
                                }

                                $mapUrl = null;
                                if (($columns['card_google_maps_url'] ?? false) && filled($property->card_google_maps_url)) {
                                    $candidateMapUrl = trim((string) $property->card_google_maps_url);
                                    $lowerMapUrl = strtolower($candidateMapUrl);

                                    if (str_starts_with($lowerMapUrl, 'http://') || str_starts_with($lowerMapUrl, 'https://')) {
                                        $mapUrl = $candidateMapUrl;
                                    }
                                }
                                                        @endphp
                            <tr>
                               <td data-column-key="id" class="vn-table-number">{{ $property->id ?? '—' }}</td>
                                <td data-column-key="property_name" class="vn-table-text-long">{{ ($columns['property_name'] ?? false) ? ($property->property_name ?: '—') : '—' }}</td>
                                <td data-column-key="property_country">{{ ($columns['property_country'] ?? false) ? ($property->property_country ?: '—') : '—' }}</td>
                                <td data-column-key="card_governorate">{{ ($columns['card_governorate'] ?? false) ? ($property->card_governorate ?: '—') : '—' }}</td>
                                <td data-column-key="card_region_name">{{ ($columns['card_region_name'] ?? false) ? ($property->card_region_name ?: '—') : '—' }}</td>
                                <td data-column-key="card_subdivision">{{ ($columns['card_subdivision'] ?? false) ? ($property->card_subdivision ?: '—') : '—' }}</td>
                                <td data-column-key="card_record_number">{{ ($columns['card_record_number'] ?? false) ? ($property->card_record_number ?: '—') : '—' }}</td>
                                <td data-column-key="card_property_number">{{ ($columns['card_property_number'] ?? false) ? ($property->card_property_number ?: '—') : '—' }}</td>
                                <td data-column-key="card_total_area" class="vn-table-number">{{ ($columns['card_total_area'] ?? false) && filled($property->card_total_area) ? number_format((float) $property->card_total_area, 2) : '—' }}</td>
                                <td data-column-key="card_area_unit">{{ ($columns['card_area_unit'] ?? false) ? $areaUnit : '—' }}</td>
                                <td data-column-key="total_property_value_usd" class="vn-table-money">{{ ($columns['total_property_value_usd'] ?? false) && filled($property->total_property_value_usd) ? number_format((float) $property->total_property_value_usd, 2) . ' $' : '—' }}</td>
                                <td data-column-key="owned_property_value_usd" class="vn-table-money">{{ ($columns['owned_property_value_usd'] ?? false) && filled($property->owned_property_value_usd) ? number_format((float) $property->owned_property_value_usd, 2) . ' $' : '—' }}</td>
                                <td data-column-key="actual_price_usd" class="vn-table-money">{{ ($columns['actual_price_usd'] ?? false) && filled($property->actual_price_usd) ? number_format((float) $property->actual_price_usd, 2) . ' $' : '—' }}</td>
                                <td data-column-key="estimated_price_usd" class="vn-table-money">{{ ($columns['estimated_price_usd'] ?? false) && filled($property->estimated_price_usd) ? number_format((float) $property->estimated_price_usd, 2) . ' $' : '—' }}</td>
                                <td data-column-key="card_status"><span class="vn-status-badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
                                <td data-column-key="card_investment_type">{{ ($columns['card_investment_type'] ?? false) ? ($property->card_investment_type ?: '—') : '—' }}</td>
                                <td data-column-key="card_purchase_method">{{ ($columns['card_purchase_method'] ?? false) ? ($property->card_purchase_method ?: '—') : '—' }}</td>
                                <td data-column-key="card_sale_date">{{ ($columns['card_sale_date'] ?? false) ? ($property->card_sale_date ?: '—') : '—' }}</td>
                                <td data-column-key="final_balance" class="vn-table-money">{{ ($columns['final_balance'] ?? false) && filled($property->final_balance) ? number_format((float) $property->final_balance, 2) . ' $' : '—' }}</td>
                                <td data-column-key="card_google_maps_url" class="vn-table-map-link">
                                    @if (($columns['card_google_maps_url'] ?? false) && $mapUrl)
                                        <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer">الخريطة</a>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td data-column-key="owners_count" class="vn-table-text-long">
                                    @php
                                        $operationOwners = collect($operationOwnersByProperty[$property->id] ?? []);
                                        $ownersToShow = $operationOwners->take(3);
                                        $remainingOwnersCount = max($operationOwners->count() - $ownersToShow->count(), 0);
                                    @endphp

                                    @if ($operationOwners->isNotEmpty())
                                        <div class="vn-owner-stack">
                                            @foreach ($ownersToShow as $owner)
                                                @php
                                                    $ownerName = trim((string) ($owner['owner_name'] ?? ''));
                                                    $ownerName = $ownerName !== '' ? $ownerName : 'مالك غير محدد';
                                                    $ownerShares = (float) ($owner['owner_shares'] ?? 0);
                                                    $ownershipPercentage = (float) ($owner['ownership_percentage'] ?? 0);
                                                @endphp

                                                <div class="vn-owner-pill">
                                                    <span class="vn-owner-pill__dot" aria-hidden="true"></span>
                                                    <span class="vn-owner-pill__name" title="{{ $ownerName }}">{{ $ownerName }}</span>
                                                    <span class="vn-owner-pill__share">{{ number_format($ownerShares, 2) }} سهم</span>
                                                    <span class="vn-owner-pill__meta">{{ number_format($ownershipPercentage, 2) }}%</span>
                                                </div>
                                            @endforeach

                                            @if ($remainingOwnersCount > 0)
                                                <span class="vn-owner-stack__more">+ {{ number_format($remainingOwnersCount) }} ملاك</span>
                                            @endif
                                        </div>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td data-column-key="operations_count">
                                    @php
                                        $propertyOperations = collect($operationsByProperty[$property->id] ?? []);
                                        $operationsRowId = 'operations-row-' . $property->id;
                                        $operationsCount = (int) ($property->operations_count ?? $propertyOperations->count());
                                    @endphp

                                    @if ($propertyOperations->isNotEmpty())
                                        <div class="vn-related-inline">
                                            <span class="vn-related-inline__count">{{ number_format($operationsCount) }} عمليات</span>
                                            <button type="button" class="vn-related-inline__toggle" data-property-operations-toggle data-target="{{ $operationsRowId }}" aria-expanded="false" aria-controls="{{ $operationsRowId }}" aria-label="عرض العمليات" data-show-label="▾" data-hide-label="▴">▾</button>
                                        </div>
                                    @else
                                        <span class="vn-operation-muted">—</span>
                                                                            @endif
                                </td>
                                <td data-column-key="signals_count">
                                    @php
                                        $propertySignals = collect($signalsByProperty[$property->id] ?? []);
                                        $signalsRowId = 'signals-row-' . $property->id;
                                    @endphp
                                    @if ($propertySignals->isNotEmpty())
                                        <div class="vn-related-inline">
                                            <span class="vn-related-inline__count">{{ number_format($propertySignals->count()) }} إشارات</span>
                                            <button type="button" class="vn-related-inline__toggle" data-property-signals-toggle data-target="{{ $signalsRowId }}" aria-expanded="false" aria-controls="{{ $signalsRowId }}" aria-label="عرض الإشارات" data-show-label="▾" data-hide-label="▴">▾</button>
                                        </div>
                                    @else
                                        <span class="vn-signal-muted">—</span>
                                    @endif
                                </td>
                                <td data-column-key="files_count">
                                    @php
                                        $propertyFiles = collect($filesByProperty[$property->id] ?? []);
                                        $filesRowId = 'files-row-' . $property->id;
                                    @endphp
                                    @if ($propertyFiles->isNotEmpty())
                                        <div class="vn-related-inline">
                                            <span class="vn-related-inline__count">{{ number_format($propertyFiles->count()) }} ملفات</span>
                                            <button type="button" class="vn-related-inline__toggle" data-property-files-toggle data-target="{{ $filesRowId }}" aria-expanded="false" aria-controls="{{ $filesRowId }}" aria-label="عرض الملفات" data-show-label="▾" data-hide-label="▴">▾</button>
                                        </div>
                                    @else
                                        <span class="vn-file-muted">—</span>
                                    @endif
                                </td>
                                <td data-column-key="installments_count">
                                    @php
                                        $propertyInstallments = collect($installmentsByProperty[$property->id] ?? []);
                                        $installmentsRowId = 'installments-row-' . $property->id;
                                    @endphp
                                    @if ($propertyInstallments->isNotEmpty())
                                        <div class="vn-related-inline">
                                            <span class="vn-related-inline__count">{{ number_format($propertyInstallments->count()) }} دفعات</span>
                                            <button type="button" class="vn-related-inline__toggle" data-property-installments-toggle data-target="{{ $installmentsRowId }}" aria-expanded="false" aria-controls="{{ $installmentsRowId }}" aria-label="عرض الدفعات" data-show-label="▾" data-hide-label="▴">▾</button>
                                        </div>
                                    @else
                                        <span class="vn-installment-muted">—</span>
                                    @endif
                                </td>
                                <td data-column-key="updated_at">{{ ($columns['updated_at'] ?? false) && $property->updated_at ? $property->updated_at->format('Y-m-d H:i') : '—' }}</td>
                                @php
                                    $notesRowId = 'notes-row-' . $property->id;
                                    $propertyNotes = trim((string) ($property->card_property_details ?? ''));
                                    $hasPropertyNotes = ($columns['card_property_details'] ?? false) && $propertyNotes !== '';
                                @endphp
                                <td data-column-key="card_property_details" class="vn-table-notes-cell">
                                    @if ($hasPropertyNotes)
                                        <button type="button" class="vn-details-toggle" data-property-notes-toggle data-target="{{ $notesRowId }}" aria-expanded="false" aria-controls="{{ $notesRowId }}" aria-label="عرض ملاحظات العقار">
                                            <span>ملاحظات</span><span aria-hidden="true">▾</span>
                                        </button>
                                    @else
                                        <span class="vn-notes-muted">—</span>
                                    @endif
                                </td>
                                <td data-column-key="actions">
                                    <div class="vn-row-actions">
                                        {{-- TODO: Connect this action when a viewer-new single property route is available. --}}
                                        <span class="vn-row-action vn-row-action--disabled" aria-disabled="true">استعراض</span>
                                    </div>
                                </td>
                            </tr>
                            @if ($hasPropertyNotes)
                                <tr class="vn-property-notes-row vn-detail-row" id="{{ $notesRowId }}" data-property-notes-row>
                                    <td colspan="{{ $propertyTableColspan }}" class="vn-detail-cell">
                                        <div class="vn-property-notes-wrap">
                                            <p class="vn-property-notes-text">{{ $propertyNotes }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if ($propertyOperations->isNotEmpty())
                                <tr class="vn-property-operations-row" id="{{ $operationsRowId }}" data-property-operations-row hidden>
                                    <td colspan="28">
                                        <div class="vn-property-operations-panel vn-child-panel vn-child-panel--operations">
                                            <div class="vn-child-panel__header">
                                                <h4 class="vn-child-panel__title">العمليات المرتبطة</h4>
                                                <span class="vn-child-panel__meta">{{ number_format($propertyOperations->count()) }} سجلات</span>
                                            </div>
                                            <div class="vn-child-panel__table-wrap">
                                            <table class="vn-property-operations-table vn-child-table">
                                                <thead>
                                                <tr>
                                                    <th>العملية</th><th>مقدار التصرف</th><th>ما يعادلها بالأسهم</th><th>المالك القديم</th><th>المالك الجديد</th><th>الطريقة</th><th>القرار / العقد</th><th>التاريخ</th><th>ملاحظات</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($propertyOperations as $operation)
                                                    @php
                                                        $operationTypeRaw = strtolower((string) ($operation['operation_type'] ?? ''));
                                                        $operationTypeLabel = match ($operationTypeRaw) {
                                                            'acquisition' => 'اكتساب',
                                                            'sale' => 'بيع',
                                                            'transfer' => 'نقل ملكية',
                                                            'court_judgment' => 'حكم قضائي',
                                                            'regular_contract' => 'عقد عادي',
                                                            'commercial_register_contract' => 'عقد سجل تجاري',
                                                            default => filled((string) ($operation['operation_type'] ?? '')) ? $operation['operation_type'] : '—',
                                                        };
                                                        $unitRaw = strtolower((string) ($operation['transaction_unit'] ?? ''));
                                                        $unitLabel = match ($unitRaw) {
                                                            'shares' => 'سهم',
                                                            'percentage' => '%',
                                                            'square_meter', 'meters' => 'م²',
                                                            default => filled($unitRaw) ? $unitRaw : '',
                                                        };
                                                        $oldOwnersLabel = ! empty($operation['old_owners']) ? implode('، ', $operation['old_owners']) : '—';
                                                        $newOwnersLabel = ! empty($operation['new_owners']) ? implode('، ', $operation['new_owners']) : '—';
                                                        $decisionContract = collect([
                                                            filled((string) ($operation['case_number'] ?? '')) ? 'قضية: ' . $operation['case_number'] : null,
                                                            filled((string) ($operation['decision_number'] ?? '')) ? 'قرار: ' . $operation['decision_number'] : null,
                                                            filled((string) ($operation['authority'] ?? '')) ? 'جهة: ' . $operation['authority'] : null,
                                                            filled((string) ($operation['contract_number'] ?? '')) ? 'عقد: ' . $operation['contract_number'] : null,
                                                        ])->filter()->implode(' • ');
                                                        $operationDate = $operation['judgment_date'] ?? $operation['contract_date'] ?? null;
                                                    @endphp
                                                    <tr>
                                                        <td><span class="vn-operation-badge vn-child-badge vn-child-badge--gold">{{ $operationTypeLabel }}</span></td>
                                                        <td><span class="vn-child-amount">{{ filled($operation['transaction_amount']) ? number_format((float) $operation['transaction_amount'], 2) . ($unitLabel !== '' ? ' ' . $unitLabel : '') : '—' }}</span></td>
                                                        <td><span class="vn-child-amount">{{ filled($operation['shares_equivalent']) ? number_format((float) $operation['shares_equivalent'], 2) : '—' }}</span></td>
                                                        <td class="vn-operation-owner-list">{{ $oldOwnersLabel }}</td>
                                                        <td class="vn-operation-owner-list">{{ $newOwnersLabel }}</td>
                                                        <td>{{ filled((string) ($operation['operation_method'] ?? '')) ? $operation['operation_method'] : '—' }}</td>
                                                        <td>{{ $decisionContract !== '' ? $decisionContract : '—' }}</td>
                                                        <td>{{ filled((string) $operationDate) ? $operationDate : '—' }}</td>
                                                        <td class="vn-child-muted">{{ filled((string) ($operation['notes'] ?? '')) ? $operation['notes'] : '—' }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            @if ($propertyFiles->isNotEmpty())
                                <tr class="vn-property-files-row" id="{{ $filesRowId }}" data-property-files-row hidden>
                                    <td colspan="28">
                                        <div class="vn-property-files-panel vn-child-panel vn-child-panel--files">
                                            <div class="vn-child-panel__header">
                                                <h4 class="vn-child-panel__title">الملفات المرتبطة</h4>
                                                <span class="vn-child-panel__meta">{{ number_format($propertyFiles->count()) }} سجلات</span>
                                            </div>
                                            <div class="vn-child-panel__table-wrap">
                                            <table class="vn-property-files-table vn-child-table">
                                                <thead><tr><th>اسم الملف</th><th>تاريخ الإصدار</th><th>نوع الملف</th><th>الحجم KB</th><th>الحجم MB</th><th>القرص</th><th>المسار</th><th>تاريخ الإضافة</th><th>آخر تعديل</th><th>الإجراء</th></tr></thead>
                                                <tbody>
                                                @foreach ($propertyFiles as $propertyFile)
                                                    <tr>
                                                        <td><span class="vn-file-badge vn-child-badge vn-child-badge--gold">{{ filled((string) ($propertyFile['file_name'] ?? '')) ? $propertyFile['file_name'] : '—' }}</span></td>
                                                        <td>{{ filled((string) ($propertyFile['issued_at'] ?? '')) ? $propertyFile['issued_at'] : '—' }}</td>
                                                        <td>{{ filled((string) ($propertyFile['mime_type'] ?? '')) ? $propertyFile['mime_type'] : '—' }}</td>
                                                        <td>{{ isset($propertyFile['file_size_kb']) && is_numeric($propertyFile['file_size_kb']) ? number_format((float) $propertyFile['file_size_kb'], 2) : '—' }}</td>
                                                        <td>{{ isset($propertyFile['file_size_mb']) && is_numeric($propertyFile['file_size_mb']) ? number_format((float) $propertyFile['file_size_mb'], 2) : '—' }}</td>
                                                        <td>{{ filled((string) ($propertyFile['storage_disk'] ?? '')) ? $propertyFile['storage_disk'] : '—' }}</td>
                                                        <td>{{ filled((string) ($propertyFile['storage_path'] ?? '')) ? $propertyFile['storage_path'] : '—' }}</td>
                                                        <td>{{ filled((string) ($propertyFile['file_created_at'] ?? '')) ? $propertyFile['file_created_at'] : '—' }}</td>
                                                        <td>{{ filled((string) ($propertyFile['file_updated_at'] ?? '')) ? $propertyFile['file_updated_at'] : '—' }}</td>
                                                        <td>
                                                            @if (filled((string) ($propertyFile['open_url'] ?? null)))
                                                                <a href="{{ $propertyFile['open_url'] }}" target="_blank" rel="noopener noreferrer">فتح</a>
                                                            @else
                                                                {{-- TODO: Add a safe viewer-new file open/download route and map open_url when available. --}}
                                                                <span class="vn-file-muted vn-child-muted">غير متاح حالياً</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif



                            @if ($propertyInstallments->isNotEmpty())
                                <tr class="vn-property-installments-row" id="{{ $installmentsRowId }}" data-property-installments-row hidden>
                                    <td colspan="28">
                                        <div class="vn-property-installments-panel vn-child-panel vn-child-panel--installments">
                                            <div class="vn-child-panel__header">
                                                <h4 class="vn-child-panel__title">الدفعات المرتبطة</h4>
                                                <span class="vn-child-panel__meta">{{ number_format($propertyInstallments->count()) }} سجلات</span>
                                            </div>
                                            <div class="vn-child-panel__table-wrap">
                                            <table class="vn-property-installments-table vn-child-table">
                                                <thead><tr><th>رقم الدفعة</th><th>قيمة الدفعة</th><th>تاريخ الدفع</th><th>المتبقي بعد الدفع</th><th>تاريخ الإضافة</th><th>آخر تعديل</th></tr></thead>
                                                <tbody>
                                                @foreach ($propertyInstallments as $installment)
                                                    <tr>
                                                        <td><span class="vn-installment-badge vn-child-badge vn-child-badge--gold">{{ filled((string) ($installment['installment_id'] ?? '')) ? $installment['installment_id'] : '—' }}</span></td>
                                                        <td class="vn-installment-amount vn-child-amount">{{ isset($installment['payment_amount']) && is_numeric($installment['payment_amount']) ? number_format((float) $installment['payment_amount'], 2) . ' $' : '—' }}</td>
                                                        <td>{{ filled((string) ($installment['payment_date'] ?? '')) ? $installment['payment_date'] : '—' }}</td>
                                                        <td class="vn-installment-amount vn-child-amount">{{ isset($installment['remaining_after_payment']) && is_numeric($installment['remaining_after_payment']) ? number_format((float) $installment['remaining_after_payment'], 2) . ' $' : '—' }}</td>
                                                        <td>{{ filled((string) ($installment['installment_created_at'] ?? '')) ? $installment['installment_created_at'] : '—' }}</td>
                                                        <td>{{ filled((string) ($installment['installment_updated_at'] ?? '')) ? $installment['installment_updated_at'] : '—' }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if ($propertySignals->isNotEmpty())
                                <tr class="vn-property-signals-row" id="{{ $signalsRowId }}" data-property-signals-row hidden>
                                    <td colspan="28">
                                        <div class="vn-property-signals-panel vn-child-panel vn-child-panel--signals">
                                            <div class="vn-child-panel__header">
                                                <h4 class="vn-child-panel__title">الإشارات المرتبطة</h4>
                                                <span class="vn-child-panel__meta">{{ number_format($propertySignals->count()) }} سجلات</span>
                                            </div>
                                            <div class="vn-child-panel__table-wrap">
                                            <table class="vn-property-signals-table vn-child-table">
                                                <thead><tr><th>رقم الإشارة</th><th>النوع</th><th>تاريخ الإشارة</th><th>صاحب الإشارة</th><th>مصدر الإشارة</th><th>رقم المصدر</th><th>تاريخ المصدر</th><th>المتضرر</th><th>ملاحظات</th><th>تاريخ الإضافة</th><th>آخر تعديل</th></tr></thead>
                                                <tbody>
                                                @foreach ($propertySignals as $signal)
                                                    <tr>
                                                        <td><span class="vn-signal-badge vn-child-badge vn-child-badge--gold">{{ filled((string) ($signal['signal_number'] ?? '')) ? $signal['signal_number'] : '—' }}</span></td>
                                                        <td>{{ filled((string) ($signal['signal_type'] ?? '')) ? $signal['signal_type'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['signal_date'] ?? '')) ? $signal['signal_date'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['signal_owners_label'] ?? '')) ? $signal['signal_owners_label'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['signal_sources_label'] ?? '')) ? $signal['signal_sources_label'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['signal_source_number'] ?? '')) ? $signal['signal_source_number'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['signal_source_date'] ?? '')) ? $signal['signal_source_date'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['signal_victims_label'] ?? '')) ? $signal['signal_victims_label'] : '—' }}</td>
                                                        <td class="vn-child-muted">{{ filled((string) ($signal['signal_notes'] ?? '')) ? $signal['signal_notes'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['created_at'] ?? '')) ? $signal['created_at'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['updated_at'] ?? '')) ? $signal['updated_at'] : '—' }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
            </div>

            @include('viewer-new.partials.pagination', ['paginator' => $properties ?? null])
        @else
            @include('viewer-new.partials.empty-state', ['message' => 'لم يتم العثور على عقارات وفقاً لعوامل البحث الحالية.'])
        @endif
    </section>

    {{-- Fallback until Vite assets are rebuilt (production manifest may lag source). --}}
    @if ($currentCount > 0)
        @php
            $propertiesTableFallbackVersion = '2';
        @endphp
        <style>
            .viewer-new .vn-properties-report .vn-detail-row{display:none;background:rgba(0,0,0,.4)}
            .viewer-new .vn-properties-report .vn-detail-row.open{display:table-row}
            .viewer-new .vn-properties-report col.vn-col-notes{width:1px}
            .viewer-new .vn-properties-report .vn-properties-table th[data-column-key="card_property_details"],
            .viewer-new .vn-properties-report .vn-properties-table td.vn-table-notes-cell{width:1px;max-width:108px;min-width:0;padding:.5rem .45rem!important;white-space:nowrap;text-align:center}
            .viewer-new .vn-properties-report .vn-details-toggle{padding:6px 12px;border-radius:8px;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.1);color:#a8adb7;font-size:11px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;white-space:nowrap}
            .viewer-new .vn-properties-report .vn-details-toggle span{font-size:12px}
            .viewer-new .vn-properties-report .vn-details-toggle:hover{border-color:rgba(212,175,55,.35);color:#e8d48b;background:rgba(212,175,55,.06)}
            .viewer-new .vn-properties-report .vn-details-toggle.open{border-color:rgba(212,175,55,.4);color:#e8d48b;background:rgba(212,175,55,.08)}
            .viewer-new .vn-properties-report .vn-detail-row td.vn-detail-cell{padding:16px 24px;line-height:1.9;overflow-wrap:anywhere;border-top:0}
            .viewer-new .vn-properties-report .vn-property-notes-wrap{border:1px solid rgba(212,175,55,.18);border-radius:12px;background:linear-gradient(160deg,rgba(212,175,55,.07),rgba(255,255,255,.015));padding:12px}
            .viewer-new .vn-properties-report .vn-property-notes-text{margin:0;line-height:1.8;white-space:pre-wrap;overflow-wrap:anywhere}
            .viewer-new .vn-properties-report .vn-th-inner{display:flex;align-items:center;gap:6px}
            .viewer-new .vn-properties-report .vn-col-pin-btn{display:inline-flex;margin-inline-start:auto;opacity:0;border:0;background:transparent;cursor:pointer;color:#6b6560;padding:2px}
            .viewer-new .vn-properties-report .vn-big-table thead th:hover .vn-col-pin-btn,.viewer-new .vn-properties-report .vn-col-pin-btn.active{opacity:1}
            .viewer-new .vn-properties-report .vn-col-pin-btn.active{color:#e8c96a}
            .viewer-new .vn-properties-report .vn-big-table thead th.vn-col-pinned,.viewer-new .vn-properties-report .vn-big-table tbody td.vn-col-pinned{position:sticky!important;z-index:20!important}
            .viewer-new .vn-properties-report .vn-col-resize-handle{position:absolute;top:0;inset-inline-start:-5px;width:10px;height:100%;cursor:col-resize;opacity:0;z-index:4}
            .viewer-new .vn-properties-report .vn-big-table thead th:hover .vn-col-resize-handle{opacity:1}
            .viewer-new .vn-properties-report .vn-tbl-top-scroll{overflow-x:auto;height:12px;display:none;background:rgba(255,255,255,.03)}
            .viewer-new .vn-properties-report .vn-tbl-top-scroll.is-visible{display:block}
            .viewer-new .vn-properties-report .vn-col-pin-bar.is-visible{display:flex;gap:8px;align-items:center}
        </style>
        <script>
            (function () {
                if (window.__vnPropertiesTableFallback === '{{ $propertiesTableFallbackVersion }}') return;
                window.__vnPropertiesTableFallback = '{{ $propertiesTableFallbackVersion }}';
                const report = document.querySelector('.vn-properties-report');
                const table = document.getElementById('vn-properties-table');
                const scroller = document.getElementById('vn-properties-overflow') || report?.querySelector('.vn-properties-table');
                const colgroup = document.getElementById('vn-properties-colgroup');
                if (!report || !table || !scroller) return;
                const PIN_KEY = 'viewer_new_properties_pinned_cols';
                const WIDTH_KEY = 'viewer_new_properties_col_widths';
                const PIN_SVG = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="17" x2="12" y2="22"/><path d="M5 17h14v-1.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V6h1a2 2 0 0 0 0-4H8a2 2 0 0 0 0 4h1v4.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24Z"/></svg>';
                let pinned = [];
                try { pinned = JSON.parse(localStorage.getItem(PIN_KEY) || '[]') || []; } catch (_) {}
                const colClass = (k) => 'vn-col-' + k;
                const applyPin = () => {
                    table.classList.remove('vn-has-pinned-cols');
                    table.querySelectorAll('.vn-col-pinned,.vn-col-pin-edge').forEach((el) => { el.classList.remove('vn-col-pinned','vn-col-pin-edge'); el.style.removeProperty('right'); });
                    table.querySelectorAll('.vn-col-pin-btn').forEach((b) => { b.classList.remove('active'); b.title = 'تثبيت العمود'; });
                    const visible = pinned.filter((k) => { const th = table.querySelector('thead th[data-column-key="'+k+'"]'); return th && getComputedStyle(th).display !== 'none'; });
                    if (!visible.length) { report.querySelector('[data-properties-pin-bar]')?.classList.remove('is-visible'); return; }
                    table.classList.add('vn-has-pinned-cols');
                    let off = 0;
                    visible.forEach((k) => {
                        const th = table.querySelector('thead th.'+colClass(k));
                        const w = th ? th.offsetWidth : 100;
                        table.querySelectorAll('th.'+colClass(k)+',td.'+colClass(k)).forEach((el) => { if (getComputedStyle(el).display !== 'none') { el.classList.add('vn-col-pinned'); el.style.right = off+'px'; } });
                        th?.querySelector('.vn-col-pin-btn')?.classList.add('active');
                        off += w;
                    });
                    const last = visible[visible.length-1];
                    table.querySelectorAll('th.'+colClass(last)+',td.'+colClass(last)).forEach((el) => { if (el.classList.contains('vn-col-pinned')) el.classList.add('vn-col-pin-edge'); });
                    report.querySelector('[data-properties-pin-bar]')?.classList.add('is-visible');
                    const cnt = report.querySelector('[data-properties-pin-count]');
                    if (cnt) cnt.textContent = visible.length + ' مثبت';
                };
                table.querySelectorAll('[data-column-key]').forEach((c) => c.classList.add(colClass(c.getAttribute('data-column-key'))));
                table.querySelectorAll('thead th[data-column-key]').forEach((th) => {
                    const key = th.getAttribute('data-column-key');
                    const inner = th.querySelector('.vn-th-inner') || th;
                    if (!th.querySelector('.vn-col-pin-btn')) {
                        const btn = document.createElement('button');
                        btn.type = 'button'; btn.className = 'vn-col-pin-btn'; btn.innerHTML = PIN_SVG; btn.title = 'تثبيت العمود';
                        btn.addEventListener('click', (e) => {
                            e.stopPropagation();
                            const i = pinned.indexOf(key);
                            if (i === -1) pinned.push(key); else pinned.splice(i, 1);
                            localStorage.setItem(PIN_KEY, JSON.stringify(pinned));
                            applyPin();
                        });
                        inner.appendChild(btn);
                    }
                    if (key !== 'id' && !th.querySelector('.vn-col-resize-handle')) {
                        const h = document.createElement('span');
                        h.className = 'vn-col-resize-handle';
                        th.appendChild(h);
                        h.addEventListener('pointerdown', (e) => {
                            e.preventDefault(); e.stopPropagation();
                            const col = colgroup?.querySelector('col.'+colClass(key));
                            if (!col) return;
                            const sx = e.clientX, sw = Math.max(th.getBoundingClientRect().width, 72);
                            const move = (ev) => { col.style.width = Math.max(72, sw + (ev.clientX - sx)) + 'px'; };
                            const up = () => { window.removeEventListener('pointermove', move); window.removeEventListener('pointerup', up); applyPin(); };
                            window.addEventListener('pointermove', move); window.addEventListener('pointerup', up);
                        });
                    }
                });
                report.querySelector('[data-properties-unpin-all]')?.addEventListener('click', () => { pinned = []; localStorage.setItem(PIN_KEY, '[]'); applyPin(); });
                let top = scroller.parentElement?.querySelector('.vn-tbl-top-scroll');
                if (!top) {
                    top = document.createElement('div');
                    top.className = 'vn-tbl-top-scroll';
                    top.innerHTML = '<div class="vn-tbl-top-scroll-inner"></div>';
                    scroller.parentElement?.insertBefore(top, scroller);
                }
                const syncTop = () => {
                    const inner = top.querySelector('.vn-tbl-top-scroll-inner');
                    if (inner) inner.style.width = table.scrollWidth + 'px';
                    top.classList.toggle('is-visible', scroller.scrollWidth > scroller.clientWidth + 4);
                };
                if (top.dataset.wired !== '1') {
                    top.dataset.wired = '1';
                    top.addEventListener('scroll', () => { scroller.scrollLeft = top.scrollLeft; }, { passive: true });
                    scroller.addEventListener('scroll', () => { top.scrollLeft = scroller.scrollLeft; syncTop(); }, { passive: true });
                }
                applyPin(); syncTop(); window.addEventListener('resize', () => { applyPin(); syncTop(); });
            })();
        </script>
        <script>
            (function () {
                if (window.__vnPropertyNotesReady) return;
                const report = document.querySelector('.vn-properties-report');
                const table = report?.querySelector('.vn-properties-table table');
                if (!report || !table) return;
                const esc = (id) => (typeof CSS !== 'undefined' && CSS.escape) ? CSS.escape(id) : id.replace(/[^a-zA-Z0-9_-]/g, '\\$&');
                table.addEventListener('click', (event) => {
                    const btn = event.target instanceof Element ? event.target.closest('[data-property-notes-toggle]') : null;
                    if (!btn) return;
                    event.preventDefault();
                    const row = table.querySelector('#' + esc(btn.getAttribute('data-target') || ''));
                    if (!row) return;
                    const open = row.classList.toggle('open');
                    btn.classList.toggle('open', open);
                    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                    const caret = btn.querySelector('span:last-child');
                    if (caret) caret.textContent = open ? '▴' : '▾';
                });
                window.__vnPropertyNotesReady = true;
            })();
        </script>
    @endif
@endsection
