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

    <section class="vn-properties-report">
        <header class="vn-report-hero">
            <div class="vn-report-hero__content">
                <p>تقرير العقارات الكامل</p>
                <h1>تقرير العقارات</h1>
                <p>جميع بطاقات العقارات والبيانات المرتبطة بها — مع تصفية متقدمة واستعراض منظم</p>
            </div>
            <div class="vn-report-hero__meta">
                <a href="{{ route('viewer-new.reports') }}">العودة إلى بوابة التقارير</a>
                {{-- TODO: Connect export actions when a viewer-new properties export route is available. --}}
                <span>إجمالي النتائج: {{ number_format((int) $totalResults) }}</span>
                <div>
                    <strong>{{ $metrics['total_area'] ?? '—' }}</strong>
                    <small>المساحة الإجمالية ضمن نتائج البحث الحالية</small>
                </div>
            </div>
        </header>

        <section class="vn-report-kpi-grid" aria-label="مؤشرات تقرير العقارات">
            @foreach ($kpiItems as $item)
                <article class="vn-report-kpi-card">
                    <h3>{{ $item['label'] }}</h3>
                    <p>{{ filled((string) ($item['value'] ?? null)) ? $item['value'] : '—' }}</p>
                </article>
            @endforeach
        </section>

        <section class="vn-report-toolbar" aria-label="شريط أدوات تقرير العقارات">
            <div class="vn-report-toolbar__search">
                <label for="filter-q" class="vn-report-toolbar__search-label">بحث شامل</label>
                <input id="filter-q" type="text" name="q" form="vn-properties-report-generator-form" value="{{ $filters['q'] ?? '' }}" placeholder="بحث برقم المحضر أو المنطقة أو الملاحظات" />
                <button type="button" class="vn-report-toolbar-button" data-properties-clear-search aria-label="مسح البحث">مسح</button>
            </div>
            <div class="vn-report-toolbar__actions">
                <button type="button" class="vn-report-toolbar-button vn-report-toolbar-button--primary vn-report-toolbar-button--active" data-report-generator-toggle aria-expanded="true" aria-controls="vn-properties-generator-panel">مولد تقارير</button>
                <button type="button" class="vn-report-toolbar-button vn-report-toolbar-button--disabled" disabled aria-disabled="true" title="سيتم دعم التصدير لاحقاً">تصدير</button>
                <button type="button" class="vn-report-toolbar-button" data-properties-fullscreen>ملء الشاشة</button>
            </div>
        </section>

        <section id="vn-properties-generator-panel" class="vn-report-generator is-open" data-report-generator-panel>
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
            <div class="vn-table-responsive vn-properties-table">
                <table>
                    <thead>
                        <tr>
                            <th data-column-key="id">ID العقار</th><th data-column-key="property_name">اسم العقار</th><th data-column-key="property_country">الدولة</th><th data-column-key="card_governorate">المحافظة</th><th data-column-key="card_region_name">المنطقة</th><th data-column-key="card_subdivision">التقسيم</th><th data-column-key="card_record_number">رقم المحضر</th><th data-column-key="card_property_number">رقم العقار</th><th data-column-key="card_total_area">المساحة</th><th data-column-key="card_area_unit">وحدة المساحة</th><th data-column-key="total_property_value_usd">القيمة الإجمالية</th><th data-column-key="owned_property_value_usd">القيمة المملوكة</th><th data-column-key="actual_price_usd">السعر الفعلي</th><th data-column-key="estimated_price_usd">السعر التقريبي</th><th data-column-key="card_status">الحالة</th><th data-column-key="card_investment_type">نوع الاستثمار</th><th data-column-key="card_purchase_method">طريقة الشراء</th><th data-column-key="card_sale_date">تاريخ البيع</th><th data-column-key="final_balance">الرصيد النهائي</th><th data-column-key="card_google_maps_url">الخريطة</th><th data-column-key="owners_count">الملاك</th><th data-column-key="operations_count">العمليات</th><th data-column-key="signals_count">الإشارات</th><th data-column-key="files_count">الملفات</th><th data-column-key="installments_count">الدفعات</th><th data-column-key="updated_at">آخر تحديث</th><th data-column-key="card_property_details">ملاحظات</th><th data-column-key="actions">الإجراءات</th>
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
                                <td data-column-key="id">{{ $property->id ?? '—' }}</td>
                                <td data-column-key="property_name">{{ ($columns['property_name'] ?? false) ? ($property->property_name ?: '—') : '—' }}</td>
                                <td data-column-key="property_country">{{ ($columns['property_country'] ?? false) ? ($property->property_country ?: '—') : '—' }}</td>
                                <td data-column-key="card_governorate">{{ ($columns['card_governorate'] ?? false) ? ($property->card_governorate ?: '—') : '—' }}</td>
                                <td data-column-key="card_region_name">{{ ($columns['card_region_name'] ?? false) ? ($property->card_region_name ?: '—') : '—' }}</td>
                                <td data-column-key="card_subdivision">{{ ($columns['card_subdivision'] ?? false) ? ($property->card_subdivision ?: '—') : '—' }}</td>
                                <td data-column-key="card_record_number">{{ ($columns['card_record_number'] ?? false) ? ($property->card_record_number ?: '—') : '—' }}</td>
                                <td data-column-key="card_property_number">{{ ($columns['card_property_number'] ?? false) ? ($property->card_property_number ?: '—') : '—' }}</td>
                                <td data-column-key="card_total_area">{{ ($columns['card_total_area'] ?? false) && filled($property->card_total_area) ? number_format((float) $property->card_total_area, 2) : '—' }}</td>
                                <td data-column-key="card_area_unit">{{ ($columns['card_area_unit'] ?? false) ? $areaUnit : '—' }}</td>
                                <td data-column-key="total_property_value_usd">{{ ($columns['total_property_value_usd'] ?? false) && filled($property->total_property_value_usd) ? number_format((float) $property->total_property_value_usd, 2) . ' $' : '—' }}</td>
                                <td data-column-key="owned_property_value_usd">{{ ($columns['owned_property_value_usd'] ?? false) && filled($property->owned_property_value_usd) ? number_format((float) $property->owned_property_value_usd, 2) . ' $' : '—' }}</td>
                                <td data-column-key="actual_price_usd">{{ ($columns['actual_price_usd'] ?? false) && filled($property->actual_price_usd) ? number_format((float) $property->actual_price_usd, 2) . ' $' : '—' }}</td>
                                <td data-column-key="estimated_price_usd">{{ ($columns['estimated_price_usd'] ?? false) && filled($property->estimated_price_usd) ? number_format((float) $property->estimated_price_usd, 2) . ' $' : '—' }}</td>
                                <td data-column-key="card_status"><span class="vn-status-badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
                                <td data-column-key="card_investment_type">{{ ($columns['card_investment_type'] ?? false) ? ($property->card_investment_type ?: '—') : '—' }}</td>
                                <td data-column-key="card_purchase_method">{{ ($columns['card_purchase_method'] ?? false) ? ($property->card_purchase_method ?: '—') : '—' }}</td>
                                <td data-column-key="card_sale_date">{{ ($columns['card_sale_date'] ?? false) ? ($property->card_sale_date ?: '—') : '—' }}</td>
                                <td data-column-key="final_balance">{{ ($columns['final_balance'] ?? false) && filled($property->final_balance) ? number_format((float) $property->final_balance, 2) . ' $' : '—' }}</td>
                                <td data-column-key="card_google_maps_url">
                                    @if (($columns['card_google_maps_url'] ?? false) && $mapUrl)
                                        <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer">الخريطة</a>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td data-column-key="owners_count">
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
                                <td data-column-key="card_property_details">{{ ($columns['card_property_details'] ?? false) ? ($property->card_property_details ?: '—') : '—' }}</td>
                                <td data-column-key="actions">
                                    <div class="vn-row-actions">
                                        {{-- TODO: Connect this action when a viewer-new single property route is available. --}}
                                        <span class="vn-row-action vn-row-action--disabled" aria-disabled="true">استعراض</span>
                                    </div>
                                </td>
                            </tr>
                            @if ($propertyOperations->isNotEmpty())
                                <tr class="vn-property-operations-row" id="{{ $operationsRowId }}" data-property-operations-row hidden>
                                    <td colspan="28">
                                        <div class="vn-property-operations-panel">
                                            <table class="vn-property-operations-table">
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
                                                        <td><span class="vn-operation-badge">{{ $operationTypeLabel }}</span></td>
                                                        <td>{{ filled($operation['transaction_amount']) ? number_format((float) $operation['transaction_amount'], 2) . ($unitLabel !== '' ? ' ' . $unitLabel : '') : '—' }}</td>
                                                        <td>{{ filled($operation['shares_equivalent']) ? number_format((float) $operation['shares_equivalent'], 2) : '—' }}</td>
                                                        <td class="vn-operation-owner-list">{{ $oldOwnersLabel }}</td>
                                                        <td class="vn-operation-owner-list">{{ $newOwnersLabel }}</td>
                                                        <td>{{ filled((string) ($operation['operation_method'] ?? '')) ? $operation['operation_method'] : '—' }}</td>
                                                        <td>{{ $decisionContract !== '' ? $decisionContract : '—' }}</td>
                                                        <td>{{ filled((string) $operationDate) ? $operationDate : '—' }}</td>
                                                        <td>{{ filled((string) ($operation['notes'] ?? '')) ? $operation['notes'] : '—' }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            @if ($propertyFiles->isNotEmpty())
                                <tr class="vn-property-files-row" id="{{ $filesRowId }}" data-property-files-row hidden>
                                    <td colspan="28">
                                        <div class="vn-property-files-panel">
                                            <table class="vn-property-files-table">
                                                <thead><tr><th>اسم الملف</th><th>تاريخ الإصدار</th><th>نوع الملف</th><th>الحجم KB</th><th>الحجم MB</th><th>القرص</th><th>المسار</th><th>تاريخ الإضافة</th><th>آخر تعديل</th><th>الإجراء</th></tr></thead>
                                                <tbody>
                                                @foreach ($propertyFiles as $propertyFile)
                                                    <tr>
                                                        <td><span class="vn-file-badge">{{ filled((string) ($propertyFile['file_name'] ?? '')) ? $propertyFile['file_name'] : '—' }}</span></td>
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
                                                                <span class="vn-file-muted">غير متاح حالياً</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @endif



                            @if ($propertyInstallments->isNotEmpty())
                                <tr class="vn-property-installments-row" id="{{ $installmentsRowId }}" data-property-installments-row hidden>
                                    <td colspan="28">
                                        <div class="vn-property-installments-panel">
                                            <table class="vn-property-installments-table">
                                                <thead><tr><th>رقم الدفعة</th><th>قيمة الدفعة</th><th>تاريخ الدفع</th><th>المتبقي بعد الدفع</th><th>تاريخ الإضافة</th><th>آخر تعديل</th></tr></thead>
                                                <tbody>
                                                @foreach ($propertyInstallments as $installment)
                                                    <tr>
                                                        <td><span class="vn-installment-badge">{{ filled((string) ($installment['installment_id'] ?? '')) ? $installment['installment_id'] : '—' }}</span></td>
                                                        <td class="vn-installment-amount">{{ isset($installment['payment_amount']) && is_numeric($installment['payment_amount']) ? number_format((float) $installment['payment_amount'], 2) . ' $' : '—' }}</td>
                                                        <td>{{ filled((string) ($installment['payment_date'] ?? '')) ? $installment['payment_date'] : '—' }}</td>
                                                        <td class="vn-installment-amount">{{ isset($installment['remaining_after_payment']) && is_numeric($installment['remaining_after_payment']) ? number_format((float) $installment['remaining_after_payment'], 2) . ' $' : '—' }}</td>
                                                        <td>{{ filled((string) ($installment['installment_created_at'] ?? '')) ? $installment['installment_created_at'] : '—' }}</td>
                                                        <td>{{ filled((string) ($installment['installment_updated_at'] ?? '')) ? $installment['installment_updated_at'] : '—' }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if ($propertySignals->isNotEmpty())
                                <tr class="vn-property-signals-row" id="{{ $signalsRowId }}" data-property-signals-row hidden>
                                    <td colspan="28">
                                        <div class="vn-property-signals-panel">
                                            <table class="vn-property-signals-table">
                                                <thead><tr><th>رقم الإشارة</th><th>النوع</th><th>تاريخ الإشارة</th><th>صاحب الإشارة</th><th>مصدر الإشارة</th><th>رقم المصدر</th><th>تاريخ المصدر</th><th>المتضرر</th><th>ملاحظات</th><th>تاريخ الإضافة</th><th>آخر تعديل</th></tr></thead>
                                                <tbody>
                                                @foreach ($propertySignals as $signal)
                                                    <tr>
                                                        <td><span class="vn-signal-badge">{{ filled((string) ($signal['signal_number'] ?? '')) ? $signal['signal_number'] : '—' }}</span></td>
                                                        <td>{{ filled((string) ($signal['signal_type'] ?? '')) ? $signal['signal_type'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['signal_date'] ?? '')) ? $signal['signal_date'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['signal_owners_label'] ?? '')) ? $signal['signal_owners_label'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['signal_sources_label'] ?? '')) ? $signal['signal_sources_label'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['signal_source_number'] ?? '')) ? $signal['signal_source_number'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['signal_source_date'] ?? '')) ? $signal['signal_source_date'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['signal_victims_label'] ?? '')) ? $signal['signal_victims_label'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['signal_notes'] ?? '')) ? $signal['signal_notes'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['created_at'] ?? '')) ? $signal['created_at'] : '—' }}</td>
                                                        <td>{{ filled((string) ($signal['updated_at'] ?? '')) ? $signal['updated_at'] : '—' }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            @include('viewer-new.partials.pagination', ['paginator' => $properties ?? null])
        @else
            @include('viewer-new.partials.empty-state', ['message' => 'لم يتم العثور على عقارات وفقاً لعوامل البحث الحالية.'])
        @endif
    </section>
@endsection
