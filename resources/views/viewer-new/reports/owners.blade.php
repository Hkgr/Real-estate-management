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
        $currentPage = $hasPaginator ? $paginator->currentPage() : 1;
        $lastPage = $hasPaginator ? $paginator->lastPage() : 1;
        $currentCount = $hasPaginator ? $paginator->count() : 0;

        $ownerTableColumnKeys = [
            'id',
            'name',
            'owner_type',
            'father_name',
            'phone',
            'email',
            'national_id',
            'commercial_register_number',
            'real_estate_registry_number',
            'birth_date',
            'properties_linked_count',
            'signals_for_count',
            'signals_against_count',
            'ownership_percentage',
            'current_ownerships_count',
            'last_update',
            'created_at',
            'status_or_notes',
        ];
        $ownerTableColspan = count($ownerTableColumnKeys);

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
                        <div class="selection-bar" aria-hidden="true"><div class="selection-bar-fill" style="width:{{ $totalResults > 0 ? '100' : '0' }}%"></div></div>
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
                <button type="button" class="toolbar-main-btn vn-report-toolbar-button vn-report-toolbar-button--disabled" disabled aria-disabled="true" title="سيتم دعم التصدير لاحقاً">تصدير ▾</button>
                <button type="button" class="toolbar-main-btn vn-report-toolbar-button vn-report-toolbar-button--disabled" disabled aria-disabled="true" title="غير متاح حالياً">⛶ ملء الشاشة</button>
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
                            'id' => 'ID',
                            'name' => 'المالك',
                            'owner_type' => 'نوع المالك',
                            'father_name' => 'اسم الأب',
                            'phone' => 'رقم الهاتف',
                            'email' => 'البريد الإلكتروني',
                            'national_id' => 'الرقم الوطني',
                            'commercial_register_number' => 'السجل التجاري',
                            'real_estate_registry_number' => 'السجل العقاري',
                            'birth_date' => 'تاريخ الميلاد',
                            'properties_linked_count' => 'العقارات المرتبطة',
                            'signals_for_count' => 'إشارات له',
                            'signals_against_count' => 'إشارات عليه',
                            'ownership_percentage' => 'الحصة',
                            'current_ownerships_count' => 'الملكيات الحالية',
                            'last_update' => 'آخر تحديث',
                            'created_at' => 'تاريخ الإنشاء',
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

        <section class="vn-active-filter-chips" aria-label="الفلاتر المفعلة">
            @if (count($activeFilters) > 0)
                @foreach ($activeFilters as $activeFilter)
                    <span class="vn-active-filter-chip">{{ $activeFilter['label'] }}: {{ $activeFilter['value'] }}</span>
                @endforeach
                <a href="{{ route('viewer-new.reports.owners') }}">إعادة تعيين</a>
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

        @if (($owners ?? collect())->count() > 0)
            <div class="vn-table-card vn-property-table-card">
                <div class="vn-table-with-scroll">
                    <div class="vn-table-responsive vn-owners-table" id="vn-owners-overflow">
                        <table id="vn-owners-table" class="vn-big-table" data-owner-table-colspan="{{ $ownerTableColspan }}">
                    <thead>
                        <tr>
                            <th data-column-key="id"><div class="vn-th-inner">ID</div></th>
                            <th data-column-key="name"><div class="vn-th-inner">المالك</div></th>
                            <th data-column-key="owner_type"><div class="vn-th-inner">نوع المالك</div></th>
                            <th data-column-key="father_name"><div class="vn-th-inner">اسم الأب</div></th>
                            <th data-column-key="phone"><div class="vn-th-inner">رقم الهاتف</div></th>
                            <th data-column-key="email"><div class="vn-th-inner">البريد الإلكتروني</div></th>
                            <th data-column-key="national_id"><div class="vn-th-inner">الرقم الوطني</div></th>
                            <th data-column-key="commercial_register_number"><div class="vn-th-inner">السجل التجاري</div></th>
                            <th data-column-key="real_estate_registry_number"><div class="vn-th-inner">السجل العقاري</div></th>
                            <th data-column-key="birth_date"><div class="vn-th-inner">تاريخ الميلاد</div></th>
                            <th data-column-key="properties_linked_count"><div class="vn-th-inner">عدد العقارات المرتبطة</div></th>
                            <th data-column-key="signals_for_count"><div class="vn-th-inner">إشارات له</div></th>
                            <th data-column-key="signals_against_count"><div class="vn-th-inner">إشارات عليه</div></th>
                            <th data-column-key="ownership_percentage"><div class="vn-th-inner">الحصة</div></th>
                            <th data-column-key="current_ownerships_count"><div class="vn-th-inner">الملكيات الحالية</div></th>
                            <th data-column-key="last_update"><div class="vn-th-inner">آخر تحديث</div></th>
                            <th data-column-key="created_at"><div class="vn-th-inner">تاريخ الإنشاء</div></th>
                            <th data-column-key="status_or_notes"><div class="vn-th-inner">الحالة / الملاحظات</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($owners as $owner)
                            <tr>
                                <td data-column-key="id">{{ $owner['id'] ?? '—' }}</td>
                                <td data-column-key="name" class="vn-table-text-long">{{ $owner['name'] ?? '—' }}</td>
                                <td data-column-key="owner_type">{{ $owner['owner_type'] ?? '—' }}</td>
                                <td data-column-key="father_name">{{ $owner['father_name'] ?? '—' }}</td>
                                <td data-column-key="phone">{{ $owner['phone'] ?? '—' }}</td>
                                <td data-column-key="email">{{ $owner['email'] ?? '—' }}</td>
                                <td data-column-key="national_id">{{ $owner['national_id'] ?? '—' }}</td>
                                <td data-column-key="commercial_register_number">{{ $owner['commercial_register_number'] ?? '—' }}</td>
                                <td data-column-key="real_estate_registry_number">{{ $owner['real_estate_registry_number'] ?? '—' }}</td>
                                <td data-column-key="birth_date">{{ $owner['birth_date'] ?? '—' }}</td>
                                @php
                                    $relatedProperties = collect($owner['related_properties'] ?? []);
                                    $signals = collect($owner['signals'] ?? []);
                                    $propertiesRowId = 'owner-properties-row-' . ($owner['id'] ?? 'na');
                                    $signalsRowId = 'owner-signals-row-' . ($owner['id'] ?? 'na');
                                    $signalsTotalCount = (int) ($owner['signals_total_count'] ?? $signals->count());
                                @endphp
                                <td data-column-key="properties_linked_count">
                                    @if ($relatedProperties->isNotEmpty())
                                        <div class="vn-related-inline">
                                            <span class="vn-related-inline__count">{{ number_format($relatedProperties->count()) }} عقارات</span>
                                            <button type="button" class="vn-related-inline__toggle" data-owner-child-toggle data-owner-properties-toggle data-target="{{ $propertiesRowId }}" aria-expanded="false" aria-controls="{{ $propertiesRowId }}" data-show-label="▾" data-hide-label="▴">▾</button>
                                        </div>
                                    @else
                                        <span class="vn-muted-value">—</span>
                                    @endif
                                </td>
                                <td data-column-key="signals_for_count">
                                    @if ($signalsTotalCount > 0)
                                        <div class="vn-related-inline">
                                            <span class="vn-related-inline__count">{{ number_format($signalsTotalCount) }} إشارات</span>
                                            <button type="button" class="vn-related-inline__toggle" data-owner-child-toggle data-owner-signals-toggle data-target="{{ $signalsRowId }}" aria-expanded="false" aria-controls="{{ $signalsRowId }}" data-show-label="▾" data-hide-label="▴">▾</button>
                                        </div>
                                    @else
                                        <span class="vn-muted-value">{{ $owner['signals_for_count'] ?? 0 }}</span>
                                    @endif
                                </td>
                                <td data-column-key="signals_against_count">{{ $owner['signals_against_count'] ?? 0 }}</td>

                                <td data-column-key="ownership_percentage" class="vn-muted-value">{{ $owner['ownership_percentage'] ?? '—' }}</td>
                                <td data-column-key="current_ownerships_count">{{ $owner['current_ownerships_count'] ?? '—' }}</td>
                                <td data-column-key="last_update">{{ $owner['last_update'] ?? '—' }}</td>
                                <td data-column-key="created_at">{{ $owner['created_at'] ?? '—' }}</td>
                                <td data-column-key="status_or_notes" class="vn-muted-value vn-table-text-long">{{ $owner['status_or_notes'] ?? '—' }}</td>
                            </tr>
                            @if ($relatedProperties->isNotEmpty())
                                <tr class="vn-owner-properties-row vn-owner-child-row" id="{{ $propertiesRowId }}" data-owner-properties-row hidden>
                                    <td colspan="{{ $ownerTableColspan }}">
                                        <div class="vn-owner-properties-panel vn-child-panel vn-child-panel--properties">
                                            <div class="vn-child-panel__header">
                                                <h4 class="vn-child-panel__title">العقارات المرتبطة</h4>
                                                <span class="vn-child-panel__meta">{{ number_format($relatedProperties->count()) }} سجلات</span>
                                            </div>
                                            <div class="vn-child-panel__table-wrap">
                                                <table class="vn-owner-properties-table vn-child-table">
                                                    <thead><tr><th>ID</th><th>الاسم</th><th>الدولة</th><th>المحافظة</th><th>المنطقة</th><th>رقم المحضر</th><th>رقم العقار</th><th>الحصة</th><th>الأسهم</th><th>حالي</th><th>آخر تحديث</th></tr></thead>
                                                    <tbody>
                                                    @foreach ($relatedProperties as $property)
                                                        <tr>
                                                            <td>{{ $property['property_id'] ?? '—' }}</td><td>{{ $property['property_name'] ?? '—' }}</td><td>{{ $property['country'] ?? '—' }}</td><td>{{ $property['governorate'] ?? '—' }}</td><td>{{ $property['region'] ?? '—' }}</td><td>{{ $property['record_number'] ?? '—' }}</td><td>{{ $property['property_number'] ?? '—' }}</td><td>{{ $property['ownership_percentage'] ?? '—' }}</td><td>{{ $property['shares'] ?? '—' }}</td><td>{{ $property['is_current'] ?? '—' }}</td><td>{{ $property['updated_at'] ?? '—' }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if ($signalsTotalCount > 0)
                                <tr class="vn-owner-signals-row vn-owner-child-row" id="{{ $signalsRowId }}" data-owner-signals-row hidden>
                                    <td colspan="{{ $ownerTableColspan }}">
                                        <div class="vn-owner-signals-panel vn-child-panel vn-child-panel--signals">
                                            <div class="vn-child-panel__header">
                                                <h4 class="vn-child-panel__title">الإشارات المرتبطة</h4>
                                                <span class="vn-child-panel__meta">{{ number_format($signals->count()) }} سجلات</span>
                                            </div>
                                            <div class="vn-child-panel__table-wrap">
                                                <table class="vn-owner-signals-table vn-child-table">
                                                    <thead><tr><th>الاتجاه</th><th>رقم الإشارة</th><th>التاريخ</th><th>النوع</th><th>المالك / أصحاب الإشارة</th><th>المتضرر / المتضررون</th><th>المصدر</th><th>رقم المصدر</th><th>تاريخ المصدر</th><th>ملاحظات</th></tr></thead>
                                                    <tbody>
                                                    @foreach ($signals as $signal)
                                                        <tr>
                                                            <td>{{ $signal['signal_direction'] ?? '—' }}</td><td>{{ $signal['signal_number'] ?? '—' }}</td><td>{{ $signal['signal_date'] ?? '—' }}</td><td>{{ $signal['signal_type'] ?? '—' }}</td><td>{{ ($signal['signal_owner'] ?? '—') }} / {{ ($signal['signal_owners'] ?? '—') }}</td><td>{{ ($signal['signal_victim'] ?? '—') }} / {{ ($signal['signal_victims'] ?? '—') }}</td><td>{{ ($signal['signal_source'] ?? '—') }} / {{ ($signal['signal_sources'] ?? '—') }}</td><td>{{ $signal['signal_source_number'] ?? '—' }}</td><td>{{ $signal['signal_source_date'] ?? '—' }}</td><td>{{ $signal['signal_notes'] ?? '—' }}</td>
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

            <div class="vn-pagination-wrap">
                @include('viewer-new.partials.pagination', ['paginator' => $owners ?? null])
            </div>
        @else
            @include('viewer-new.partials.empty-state', ['message' => 'حاول تعديل معايير البحث أو إزالة الفلاتر لعرض جميع المالكين.'])
        @endif
    </section>


    <style>
        .viewer-new .vn-owners-report .vn-owner-child-row > td { padding: 14px 18px; }
    </style>
    <script>
        (function () {
            const report = document.querySelector('.vn-owners-report');
            if (!report) return;
            report.addEventListener('click', function (event) {
                const btn = event.target.closest('[data-owner-child-toggle],[data-owner-properties-toggle],[data-owner-signals-toggle]');
                if (!btn || !report.contains(btn)) return;
                const targetId = btn.getAttribute('data-target');
                if (!targetId) return;
                const row = report.querySelector('#' + CSS.escape(targetId));
                if (!row) return;
                const willOpen = row.hidden;
                row.hidden = !willOpen;
                btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
                btn.textContent = willOpen ? (btn.dataset.hideLabel || '▴') : (btn.dataset.showLabel || '▾');
            });
        })();
    </script>
@endsection

