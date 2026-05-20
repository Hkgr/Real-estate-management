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

        <section class="vn-report-filter-panel" aria-label="فلاتر التقرير">
            <div class="vn-report-filter-panel__header">
                <h2>فلاتر التقرير</h2>
                <button type="button" data-properties-filter-toggle aria-expanded="true" aria-controls="vn-properties-filter-panel">إخفاء الفلاتر</button>
            </div>
            <div id="vn-properties-filter-panel" data-properties-filter-panel>
            <form method="GET" action="{{ route('viewer-new.reports.properties') }}" class="vn-report-filter-grid" data-properties-filter-form>
                <div>
                    <label for="filter-q">بحث شامل</label>
                    <input id="filter-q" type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="بحث برقم المحضر أو المنطقة أو الملاحظات" />
                    <button type="button" data-properties-clear-search aria-label="مسح البحث">مسح</button>
                </div>
                <div>
                    <label for="filter-country">الدولة</label>
                    <select id="filter-country" name="country">
                        <option value="">الكل</option>
                        @foreach (($countryOptions ?? []) as $option)
                            <option value="{{ $option }}" @selected(($filters['country'] ?? '') === (string) $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="filter-governorate">المحافظة</label>
                    <select id="filter-governorate" name="governorate">
                        <option value="">الكل</option>
                        @foreach (($governorateOptions ?? []) as $option)
                            <option value="{{ $option }}" @selected(($filters['governorate'] ?? '') === (string) $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="filter-region">المنطقة</label>
                    <select id="filter-region" name="region">
                        <option value="">الكل</option>
                        @foreach (($regionOptions ?? []) as $option)
                            <option value="{{ $option }}" @selected(($filters['region'] ?? '') === (string) $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="filter-status">الحالة</label>
                    <select id="filter-status" name="status">
                        <option value="">الكل</option>
                        @foreach (($statusOptions ?? []) as $option)
                            <option value="{{ $option }}" @selected(($filters['status'] ?? '') === (string) $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="filter-investment-type">نوع الاستثمار</label>
                    <select id="filter-investment-type" name="investment_type">
                        <option value="">الكل</option>
                        @foreach (($investmentTypeOptions ?? []) as $option)
                            <option value="{{ $option }}" @selected(($filters['investment_type'] ?? '') === (string) $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="filter-purchase-method">طريقة الشراء</label>
                    <select id="filter-purchase-method" name="purchase_method">
                        <option value="">الكل</option>
                        @foreach (($purchaseMethodOptions ?? []) as $option)
                            <option value="{{ $option }}" @selected(($filters['purchase_method'] ?? '') === (string) $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="filter-min-area">المساحة من</label>
                    <input id="filter-min-area" type="number" step="0.01" name="min_area" value="{{ $filters['min_area'] ?? '' }}" />
                </div>
                <div>
                    <label for="filter-max-area">المساحة إلى</label>
                    <input id="filter-max-area" type="number" step="0.01" name="max_area" value="{{ $filters['max_area'] ?? '' }}" />
                </div>
                <div>
                    <label for="filter-min-value">القيمة من</label>
                    <input id="filter-min-value" type="number" step="0.01" name="min_value" value="{{ $filters['min_value'] ?? '' }}" />
                </div>
                <div>
                    <label for="filter-max-value">القيمة إلى</label>
                    <input id="filter-max-value" type="number" step="0.01" name="max_value" value="{{ $filters['max_value'] ?? '' }}" />
                </div>
                <div>
                    <label for="filter-date-from">من تاريخ</label>
                    <input id="filter-date-from" type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" />
                </div>
                <div>
                    <label for="filter-date-to">إلى تاريخ</label>
                    <input id="filter-date-to" type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" />
                </div>
                @foreach (['has_owners' => 'لديه ملاك', 'has_signals' => 'لديه إشارات', 'has_files' => 'لديه ملفات'] as $name => $label)
                    <div>
                        <label for="filter-{{ $name }}">{{ $label }}</label>
                        <select id="filter-{{ $name }}" name="{{ $name }}">
                            <option value="">الكل</option>
                            <option value="1" @selected(($filters[$name] ?? null) === '1' || ($filters[$name] ?? null) === 1 || ($filters[$name] ?? null) === true)>نعم</option>
                            <option value="0" @selected(($filters[$name] ?? null) === '0' || ($filters[$name] ?? null) === 0 || ($filters[$name] ?? null) === false)>لا</option>
                        </select>
                    </div>
                @endforeach

                <div>
                    <button type="submit">تطبيق الفلاتر</button>
                    <a href="{{ route('viewer-new.reports.properties') }}">إعادة تعيين</a>
                </div>
            </form>
            </div>
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
                            <th>ID</th><th>اسم العقار</th><th>رقم المحضر</th><th>رقم العقار</th><th>الدولة / المحافظة / المنطقة</th><th>التقسيم</th><th>المساحة</th><th>القيمة</th><th>الحالة</th><th>نوع الاستثمار</th><th>طريقة الشراء</th><th>الملاك</th><th>العمليات</th><th>الإشارات</th><th>الملفات</th><th>الأقساط</th><th>آخر تحديث</th><th>ملاحظات</th><th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($properties as $property)
                            @php
                                $locationParts = [
                                    ($columns['property_country'] ?? false) ? ($property->property_country ?? null) : null,
                                    ($columns['card_governorate'] ?? false) ? ($property->card_governorate ?? null) : null,
                                    ($columns['card_region_name'] ?? false) ? ($property->card_region_name ?? null) : null,
                                ];
                                $location = implode(' / ', array_values(array_filter($locationParts, fn ($part) => filled((string) $part))));

                                $area = ($columns['card_total_area'] ?? false) ? $property->card_total_area : null;
                                $areaUnitRaw = ($columns['card_area_unit'] ?? false) ? strtolower((string) ($property->card_area_unit ?? '')) : '';
                                $areaUnit = match ($areaUnitRaw) {
                                    'shares' => 'سهم',
                                    'percentage' => '%',
                                    default => 'م²',
                                };

                                $value = null;
                                foreach (['total_property_value_usd', 'owned_property_value_usd', 'estimated_price_usd', 'actual_price_usd'] as $valueColumn) {
                                    if (($columns[$valueColumn] ?? false) && filled($property->{$valueColumn})) {
                                        $value = $property->{$valueColumn};
                                        break;
                                    }
                                }

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
                            @endphp
                            <tr>
                                <td>{{ $property->id ?? '—' }}</td>
                                <td>{{ ($columns['property_name'] ?? false) ? ($property->property_name ?: '—') : '—' }}</td>
                                <td>{{ ($columns['card_record_number'] ?? false) ? ($property->card_record_number ?: '—') : '—' }}</td>
                                <td>{{ ($columns['card_property_number'] ?? false) ? ($property->card_property_number ?: '—') : '—' }}</td>
                                <td>{{ $location !== '' ? $location : '—' }}</td>
                                <td>{{ ($columns['card_subdivision'] ?? false) ? ($property->card_subdivision ?: '—') : '—' }}</td>
                                <td>{{ filled($area) ? number_format((float) $area, 2) . ' ' . $areaUnit : '—' }}</td>
                                <td>{{ filled($value) ? number_format((float) $value, 2) . ' $' : '—' }}</td>
                                <td><span class="vn-status-badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
                                <td>{{ ($columns['card_investment_type'] ?? false) ? ($property->card_investment_type ?: '—') : '—' }}</td>
                                <td>{{ ($columns['card_purchase_method'] ?? false) ? ($property->card_purchase_method ?: '—') : '—' }}</td>
                                <td>{{ $property->owners_count ?? '—' }}</td>
                                <td>{{ $property->operations_count ?? '—' }}</td>
                                <td>{{ $property->signals_count ?? '—' }}</td>
                                <td>{{ $property->files_count ?? '—' }}</td>
                                <td>{{ $property->installments_count ?? '—' }}</td>
                                <td>{{ ($columns['updated_at'] ?? false) && $property->updated_at ? $property->updated_at->format('Y-m-d H:i') : '—' }}</td>
                                <td>{{ ($columns['card_property_details'] ?? false) ? ($property->card_property_details ?: '—') : '—' }}</td>
                                <td>
                                    <div class="vn-row-actions">
                                        @if (($columns['card_google_maps_url'] ?? false) && filled($property->card_google_maps_url))
                                            <a class="vn-row-action" href="{{ $property->card_google_maps_url }}" target="_blank" rel="noopener noreferrer">الخريطة</a>
                                        @endif
                                        {{-- TODO: Connect this action when a viewer-new single property route is available. --}}
                                        <span class="vn-row-action vn-row-action--disabled" aria-disabled="true">استعراض</span>
                                    </div>
                                </td>
                            </tr>
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
