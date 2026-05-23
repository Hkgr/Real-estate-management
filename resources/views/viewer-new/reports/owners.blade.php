@extends('viewer-new.layouts.app')

@section('page_title', 'تقرير المالك')
@section('topbar_title', 'تقرير المالك')
@section('active', 'reports')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'العودة إلى بوابة التقارير')

@section('content')
    @php
        $paginator = $owners ?? null;
        $hasPaginator = $paginator && method_exists($paginator, 'total');

        $totalResults = $hasPaginator ? $paginator->total() : 0;
        $currentCount = $hasPaginator ? $paginator->count() : 0;

        $ownerTableColumnKeys = [
            'name',
            'phone',
            'properties_linked_count',
            'ownership_percentage',
            'current_ownerships_count',
            'last_update',
            'status_or_notes',
        ];

        $filterLabels = [
            'q' => 'بحث شامل',
            'current' => 'حالة الملكية',
            'owner_type' => 'نوع المالك',
            'registry' => 'السجل العقاري',
            'birth_date_from' => 'تاريخ الميلاد من',
            'birth_date_to' => 'تاريخ الميلاد إلى',
            'has_properties' => 'امتلاك عقارات',
        ];

        $activeFilters = [];
        foreach ($filterLabels as $key => $label) {
            $value = $filters[$key] ?? null;

            if ($key === 'current') {
                if ($value === '1') {
                    $value = 'ملكية حالية فقط';
                } elseif ($value === '0') {
                    $value = 'ملكية غير حالية فقط';
                } else {
                    continue;
                }
            } elseif ($key === 'has_properties') {
                if ($value === '1') {
                    $value = 'مرتبط بعقارات';
                } elseif ($value === '0') {
                    $value = 'بدون عقارات مرتبطة';
                } else {
                    continue;
                }
            } elseif ($value === null || $value === '') {
                continue;
            }

            $activeFilters[] = ['label' => $label, 'value' => $value];
        }
    @endphp

    <section class="vn-properties-report vn-owners-report" id="page-owners">
        <header class="page-header vn-report-hero">
            <div class="page-header-row vn-report-hero__row">
                <div class="vn-report-hero__content">
                    <div class="page-eyebrow">تقرير المالكين الكامل</div>
                    <h1 class="page-title">تقرير <em>المالكين</em></h1>
                    <p class="page-subtitle">عرض موجز لملفات المالكين ونسب الحصص والبيانات المساندة</p>
                </div>
                <div class="vn-report-hero__meta-wrap">
                    <div class="selection-card vn-report-hero__meta">
                        <div class="selection-title">ملخص النتائج الحالية</div>
                        <a href="{{ route('viewer-new.reports') }}" class="vn-report-hero__back">العودة إلى بوابة التقارير</a>
                        <div class="selection-main-value">{{ $metrics['total_owners'] ?? '—' }}</div>
                        <div class="selection-subvalue">إجمالي النتائج: {{ number_format((int) $totalResults) }}</div>
                        <div class="selection-meta">
                            <span>روابط الملكية: {{ $metrics['total_ownership_links'] ?? '—' }}</span>
                            <span>{{ number_format((int) $currentCount) }} معروض</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section class="table-toolbar vn-report-toolbar" aria-label="شريط أدوات تقرير المالكين">
            <div class="toolbar-main-actions vn-report-toolbar__main">
                <div class="toolbar-inline-search vn-report-toolbar__search active" id="vn-toolbar-inline-search">
                    <label for="filter-q" class="vn-report-toolbar__search-label filter-label">بحث شامل</label>
                    <input id="filter-q" class="search-input" type="text" name="q" form="vn-owners-report-generator-form" value="{{ $filters['q'] ?? '' }}" placeholder="ابحث بالاسم أو الهاتف أو البريد..." @if (! $fieldAvailability['filters_q']) disabled @endif />
                </div>
                <button type="button" class="toolbar-main-btn vn-report-toolbar-button vn-report-toolbar-button--primary active" data-report-generator-toggle aria-expanded="true" aria-controls="vn-owners-generator-panel">مولد تقارير</button>
            </div>
        </section>

        <section id="vn-owners-generator-panel" class="toolbar-mode-panel vn-report-generator is-open" data-report-generator-panel>
            <form id="vn-owners-report-generator-form" method="GET" action="{{ route('viewer-new.reports.owners') }}" data-report-generator-form>
                <div class="vn-report-generator__filters">
                    @if ($fieldAvailability['is_current'])
                        <div class="vn-report-generator__field">
                            <label for="filter-current">حالة الملكية</label>
                            <select id="filter-current" name="current">
                                <option value="">كل حالات الملكية</option>
                                <option value="1" @selected(($filters['current'] ?? '') === '1')>ملكية حالية فقط</option>
                                <option value="0" @selected(($filters['current'] ?? '') === '0')>ملكية غير حالية فقط</option>
                            </select>
                        </div>
                    @endif
                    <div class="vn-report-generator__field">
                        <label for="filter-owner-type">نوع المالك</label>
                        <select id="filter-owner-type" name="owner_type">
                            <option value="">الكل</option>
                            <option value="فرد" @selected(($filters['owner_type'] ?? '') === 'فرد')>فرد</option>
                            <option value="شركة" @selected(($filters['owner_type'] ?? '') === 'شركة')>شركة</option>
                        </select>
                    </div>
                    <div class="vn-report-generator__field">
                        <label for="filter-registry">السجل العقاري</label>
                        <input id="filter-registry" type="text" name="registry" value="{{ $filters['registry'] ?? '' }}" />
                    </div>
                    <div class="vn-report-generator__field">
                        <label for="filter-birth-date-from">تاريخ الميلاد من</label>
                        <input id="filter-birth-date-from" type="date" name="birth_date_from" value="{{ $filters['birth_date_from'] ?? '' }}" />
                    </div>
                    <div class="vn-report-generator__field">
                        <label for="filter-birth-date-to">تاريخ الميلاد إلى</label>
                        <input id="filter-birth-date-to" type="date" name="birth_date_to" value="{{ $filters['birth_date_to'] ?? '' }}" />
                    </div>
                    <div class="vn-report-generator__field">
                        <label for="filter-has-properties">امتلاك عقارات</label>
                        <select id="filter-has-properties" name="has_properties">
                            <option value="">الكل</option>
                            <option value="1" @selected(($filters['has_properties'] ?? '') === '1')>مرتبط بعقارات</option>
                            <option value="0" @selected(($filters['has_properties'] ?? '') === '0')>بدون عقارات مرتبطة</option>
                        </select>
                    </div>
                </div>

                <div class="vn-report-generator__columns" data-column-picker>
                    @php
                        $columnOptions = [
                            'name' => 'المالك',
                            'phone' => 'رقم الهاتف',
                            'properties_linked_count' => 'عدد العقارات المرتبطة',
                            'ownership_percentage' => 'الحصة',
                            'current_ownerships_count' => 'الملكيات الحالية',
                            'last_update' => 'آخر تحديث',
                            'status_or_notes' => 'الحالة / الملاحظات',
                        ];
                    @endphp
                    @foreach ($columnOptions as $key => $label)
                        <label class="vn-report-column-option vn-report-column-option-card">
                            <input type="checkbox" value="{{ $key }}" checked disabled aria-disabled="true">
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                    <p class="vn-muted-value">اختيار الأعمدة سيتم ضبطه لاحقاً من واجهة العرض.</p>
                </div>

                <div class="vn-report-generator__actions">
                    <button type="submit" class="vn-report-toolbar-button">تطبيق الفلاتر</button>
                    <a href="{{ route('viewer-new.reports.owners') }}" class="vn-report-toolbar-button">إعادة تعيين</a>
                </div>
            </form>
        </section>

        @if ($activeFilters !== [])
            <section class="vn-active-filter-chips" aria-label="الفلاتر المفعلة">
                @foreach ($activeFilters as $filter)
                    <span class="vn-active-filter-chip">{{ $filter['label'] }}: {{ $filter['value'] }}</span>
                @endforeach
            </section>
        @endif

        <section class="vn-results-summary" aria-live="polite">
            <strong>النتائج:</strong>
            <span>{{ number_format((int) $totalResults) }} إجمالي</span>
            <span>• {{ number_format((int) $currentCount) }} في الصفحة الحالية</span>
            <span>• آخر تحديث: {{ $metrics['last_update'] ?? '—' }}</span>
        </section>

        @if (($owners ?? collect())->count() > 0)
            <div class="vn-table-responsive vn-owners-table">
                <table class="vn-big-table">
                    <thead>
                        <tr>
                            <th data-column-key="name">المالك</th>
                            <th data-column-key="phone">رقم الهاتف</th>
                            <th data-column-key="properties_linked_count">عدد العقارات المرتبطة</th>
                            <th data-column-key="ownership_percentage">الحصة</th>
                            <th data-column-key="current_ownerships_count">الملكيات الحالية</th>
                            <th data-column-key="last_update">آخر تحديث</th>
                            <th data-column-key="status_or_notes">الحالة / الملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($owners as $owner)
                            <tr>
                                <td data-column-key="name">
                                    <div>{{ $owner['name'] ?? '—' }}</div>
                                    <div class="vn-muted-value">النوع: {{ $owner['owner_type'] ?? '—' }}</div>
                                    <div class="vn-muted-value">اسم الأب: {{ $owner['father_name'] ?? '—' }}</div>
                                </td>
                                <td data-column-key="phone">
                                    <div>{{ $owner['phone'] ?? '—' }}</div>
                                    <div class="vn-muted-value">{{ $owner['email'] ?? '—' }}</div>
                                </td>
                                <td data-column-key="properties_linked_count">
                                    <div>{{ $owner['properties_linked_count'] ?? '—' }}</div>
                                    @php
                                        $relatedProperties = $owner['related_properties'] ?? [];
                                    @endphp
                                    @if (count($relatedProperties) > 0)
                                        <details>
                                            <summary>عرض العقارات المرتبطة</summary>
                                            <table class="vn-big-table">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>الاسم</th>
                                                        <th>الدولة</th>
                                                        <th>المحافظة</th>
                                                        <th>المنطقة</th>
                                                        <th>رقم المحضر</th>
                                                        <th>رقم العقار</th>
                                                        <th>الحصة</th>
                                                        <th>الأسهم</th>
                                                        <th>حالي</th>
                                                        <th>آخر تحديث</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($relatedProperties as $property)
                                                        <tr>
                                                            <td>{{ $property['property_id'] ?? '—' }}</td>
                                                            <td>{{ $property['property_name'] ?? '—' }}</td>
                                                            <td>{{ $property['country'] ?? '—' }}</td>
                                                            <td>{{ $property['governorate'] ?? '—' }}</td>
                                                            <td>{{ $property['region'] ?? '—' }}</td>
                                                            <td>{{ $property['record_number'] ?? '—' }}</td>
                                                            <td>{{ $property['property_number'] ?? '—' }}</td>
                                                            <td>{{ $property['ownership_percentage'] ?? '—' }}</td>
                                                            <td>{{ $property['shares'] ?? '—' }}</td>
                                                            <td>{{ $property['is_current'] ?? '—' }}</td>
                                                            <td>{{ $property['updated_at'] ?? '—' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </details>
                                    @endif
                                </td>
                                <td data-column-key="ownership_percentage" class="vn-muted-value">{{ $owner['ownership_percentage'] ?? '—' }}</td>
                                <td data-column-key="current_ownerships_count">{{ $owner['current_ownerships_count'] ?? '—' }}</td>
                                <td data-column-key="last_update">{{ $owner['last_update'] ?? '—' }}</td>
                                <td data-column-key="status_or_notes" class="vn-muted-value">
                                    <div>{{ $owner['status_or_notes'] ?? '—' }}</div>
                                    <div>الرقم الوطني: {{ $owner['national_id'] ?? '—' }}</div>
                                    <div>السجل التجاري: {{ $owner['commercial_register_number'] ?? '—' }}</div>
                                    <div>السجل العقاري: {{ $owner['real_estate_registry_number'] ?? '—' }}</div>
                                    <div>تاريخ الميلاد: {{ $owner['birth_date'] ?? '—' }}</div>
                                    <div>تاريخ الإنشاء: {{ $owner['created_at'] ?? '—' }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="vn-pagination-wrap">
                @include('viewer-new.partials.pagination', ['paginator' => $owners ?? null])
            </div>
        @else
            @include('viewer-new.partials.empty-state', ['message' => 'حاول تعديل معايير البحث أو إزالة الفلاتر لعرض جميع المالكين.'])
        @endif
    </section>
@endsection
