@extends('viewer-new.layouts.app')

@section('page_title', 'تقرير الإشارات')
@section('topbar_title', 'تقرير الإشارات')
@section('active', 'reports')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'العودة إلى بوابة التقارير')

@section('content')
    @php
        $paginator = $signals ?? null;
        $hasPaginator = $paginator && method_exists($paginator, 'total');

        $totalResults = $hasPaginator ? $paginator->total() : 0;
        $currentPage = $hasPaginator ? $paginator->currentPage() : 1;
        $lastPage = $hasPaginator ? $paginator->lastPage() : 1;
        $currentCount = $hasPaginator ? $paginator->count() : 0;

        $activeFilters = [];

        if (($filters['q'] ?? '') !== '') {
            $activeFilters[] = ['label' => 'بحث شامل', 'value' => $filters['q']];
        }

        if (($filters['type'] ?? '') !== '') {
            $activeFilters[] = ['label' => 'نوع الإشارة', 'value' => $filters['type']];
        }

        if (($filters['signal_date_from'] ?? '') !== '') {
            $activeFilters[] = ['label' => 'تاريخ الإشارة من', 'value' => $filters['signal_date_from']];
        }

        if (($filters['signal_date_to'] ?? '') !== '') {
            $activeFilters[] = ['label' => 'تاريخ الإشارة إلى', 'value' => $filters['signal_date_to']];
        }

        if (($filters['source_date_from'] ?? '') !== '') {
            $activeFilters[] = ['label' => 'تاريخ مصدر الإشارة من', 'value' => $filters['source_date_from']];
        }

        if (($filters['source_date_to'] ?? '') !== '') {
            $activeFilters[] = ['label' => 'تاريخ مصدر الإشارة إلى', 'value' => $filters['source_date_to']];
        }
    @endphp

    <section class="vn-properties-report vn-signals-report" id="page-signals">
        <header class="page-header vn-report-hero">
            <div class="page-header-row vn-report-hero__row">
                <div class="vn-report-hero__content">
                    <div class="page-eyebrow">تقرير الإشارات التشغيلي</div>
                    <h1 class="page-title">تقرير <em>الإشارات</em></h1>
                    <p class="page-subtitle">متابعة الإشارات المرتبطة بالعقارات مع عرض الأطراف والمصادر والتواريخ والملاحظات.</p>
                </div>
                <div class="vn-report-hero__meta-wrap">
                    <div class="selection-card vn-report-hero__meta">
                        <div class="selection-title">ملخص النتائج الحالية</div>
                        <a href="{{ route('viewer-new.reports') }}" class="vn-report-hero__back">العودة إلى بوابة التقارير</a>
                        <div class="selection-main-value">{{ $metrics['total_unique_signals'] ?? '—' }}</div>
                        <div class="selection-subvalue">إجمالي النتائج: {{ number_format((int) $totalResults) }}</div>
                        <div class="selection-bar" aria-hidden="true"><div class="selection-bar-fill" style="width:{{ $totalResults > 0 ? '100' : '0' }}%"></div></div>
                        <div class="selection-meta">
                            <span>إجمالي السجلات الخام: {{ $metrics['total_raw_signal_rows'] ?? 'غير متوفر' }}</span>
                            <span>بطاقات مرتبطة: {{ $metrics['linked_property_cards'] ?? 'غير متوفر' }}</span>
                            <span>آخر تحديث: {{ $metrics['last_update'] ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section class="table-toolbar vn-report-toolbar" aria-label="شريط أدوات تقرير الإشارات">
            <div class="toolbar-main-actions vn-report-toolbar__main">
                <div class="toolbar-inline-search vn-report-toolbar__search active" id="vn-toolbar-inline-search-signals">
                    <label for="filter-q" class="vn-report-toolbar__search-label filter-label">بحث شامل</label>
                    <input id="filter-q" class="search-input" type="text" name="q" form="vn-signals-report-generator-form" value="{{ $filters['q'] ?? '' }}" placeholder="ابحث في رقم/نوع/ملاحظات/أطراف الإشارة..." />
                </div>
                <button type="button" class="toolbar-main-btn vn-report-toolbar-button vn-report-toolbar-button--primary active" data-report-generator-toggle aria-expanded="true" aria-controls="vn-signals-generator-panel">مولد تقارير</button>
                <button type="button" class="toolbar-main-btn vn-report-toolbar-button vn-report-toolbar-button--disabled" disabled aria-disabled="true" title="سيتم دعم التصدير لاحقاً">تصدير ▾</button>
                <button type="button" class="toolbar-main-btn vn-report-toolbar-button vn-report-toolbar-button--disabled" disabled aria-disabled="true" title="غير متاح حالياً">⛶ ملء الشاشة</button>
            </div>
        </section>

        <section id="vn-signals-generator-panel" class="toolbar-mode-panel vn-report-generator is-open" data-report-generator-panel>
            <form id="vn-signals-report-generator-form" method="GET" action="{{ route('viewer-new.reports.signals') }}" data-report-generator-form>
                <div class="vn-report-generator__filters">
                    @if (($fieldAvailability['type'] ?? false) && !empty($typeOptions))
                        <div class="vn-report-generator__field">
                            <label for="filter-type">نوع الإشارة</label>
                            <select id="filter-type" name="type">
                                <option value="">كل الأنواع</option>
                                @foreach ($typeOptions as $typeOption)
                                    <option value="{{ $typeOption }}" @selected(($filters['type'] ?? '') === $typeOption)>{{ $typeOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="vn-report-generator__field">
                        <label for="filter-signal-date-from">تاريخ الإشارة من</label>
                        <input id="filter-signal-date-from" type="date" name="signal_date_from" value="{{ $filters['signal_date_from'] ?? '' }}">
                    </div>

                    <div class="vn-report-generator__field">
                        <label for="filter-signal-date-to">تاريخ الإشارة إلى</label>
                        <input id="filter-signal-date-to" type="date" name="signal_date_to" value="{{ $filters['signal_date_to'] ?? '' }}">
                    </div>

                    <div class="vn-report-generator__field">
                        <label for="filter-source-date-from">تاريخ مصدر الإشارة من</label>
                        <input id="filter-source-date-from" type="date" name="source_date_from" value="{{ $filters['source_date_from'] ?? '' }}">
                    </div>

                    <div class="vn-report-generator__field">
                        <label for="filter-source-date-to">تاريخ مصدر الإشارة إلى</label>
                        <input id="filter-source-date-to" type="date" name="source_date_to" value="{{ $filters['source_date_to'] ?? '' }}">
                    </div>
                </div>

                <div class="vn-report-generator__actions">
                    <button type="submit" class="vn-report-toolbar-button">تطبيق الفلاتر</button>
                    <a href="{{ route('viewer-new.reports.signals') }}" class="vn-report-toolbar-button">إعادة تعيين</a>
                </div>
            </form>
        </section>

        <section class="vn-active-filter-chips" aria-label="الفلاتر المفعلة">
            @if (count($activeFilters) > 0)
                @foreach ($activeFilters as $activeFilter)
                    <span class="vn-active-filter-chip">{{ $activeFilter['label'] }}: {{ $activeFilter['value'] }}</span>
                @endforeach
                <a href="{{ route('viewer-new.reports.signals') }}">إعادة تعيين</a>
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

        @if (($signals ?? collect())->count() > 0)
            <div class="vn-table-card vn-property-table-card">
                <div class="vn-table-with-scroll">
                    <div class="vn-table-responsive vn-signals-table">
                        <table class="vn-big-table">
                            <thead>
                                <tr>
                                    <th data-column-key="signal_number"><div class="vn-th-inner">رقم الإشارة</div></th>
                                    <th data-column-key="signal_type_label"><div class="vn-th-inner">نوع الإشارة</div></th>
                                    <th data-column-key="signal_date_label"><div class="vn-th-inner">تاريخ الإشارة</div></th>
                                    <th data-column-key="properties_count"><div class="vn-th-inner">العقارات المرتبطة</div></th>
                                    <th data-column-key="owners_summary"><div class="vn-th-inner">أصحاب الإشارة</div></th>
                                    <th data-column-key="victims_summary"><div class="vn-th-inner">المتضررون</div></th>
                                    <th data-column-key="sources_summary"><div class="vn-th-inner">مصادر الإشارة</div></th>
                                    <th data-column-key="source_date_label"><div class="vn-th-inner">تاريخ مصدر الإشارة</div></th>
                                    <th data-column-key="last_update"><div class="vn-th-inner">آخر تحديث</div></th>
                                    <th data-column-key="notes_summary"><div class="vn-th-inner">ملاحظات</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($signals as $signal)
                                    @php
                                        $rowKey = 'signal-' . preg_replace('/[^A-Za-z0-9\-_]/', '-', (string) ($signal['signal_number'] ?? 'unknown'));
                                        $propertiesTarget = $rowKey . '-properties';
                                        $detailsTarget = $rowKey . '-details';
                                    @endphp
                                    <tr>
                                        <td data-column-key="signal_number">{{ $signal['signal_number'] ?? '—' }}</td>
                                        <td data-column-key="signal_type_label">{{ $signal['signal_type_label'] ?? '—' }}</td>
                                        <td data-column-key="signal_date_label">{{ $signal['signal_date_label'] ?? '—' }}</td>
                                        <td data-column-key="properties_count">
                                            <div class="vn-related-inline">
                                                <span class="vn-related-inline__count">{{ number_format((int) ($signal['properties_count'] ?? 0)) }} عقارات</span>
                                                @if (($signal['properties_count'] ?? 0) > 0)
                                                    <button type="button" class="vn-related-inline__toggle" data-signal-child-toggle data-target="{{ $propertiesTarget }}" aria-expanded="false" aria-controls="{{ $propertiesTarget }}" data-show-label="▾" data-hide-label="▴">▾</button>
                                                @endif
                                            </div>
                                        </td>
                                        <td data-column-key="owners_summary">
                                            <div class="vn-related-inline">
                                                <span class="vn-related-inline__count">{{ $signal['owners_summary'] ?? '—' }}</span>
                                                @if ((($signal['owners_count'] ?? 0) > 1) || (($signal['owners_count'] ?? 0) > 0))
                                                    <button type="button" class="vn-related-inline__toggle" data-signal-child-toggle data-target="{{ $detailsTarget }}" aria-expanded="false" aria-controls="{{ $detailsTarget }}" data-show-label="▾" data-hide-label="▴">▾</button>
                                                @endif
                                            </div>
                                        </td>
                                        <td data-column-key="victims_summary">{{ $signal['victims_summary'] ?? '—' }}</td>
                                        <td data-column-key="sources_summary">{{ $signal['sources_summary'] ?? '—' }}</td>
                                        <td data-column-key="source_date_label">{{ $signal['source_date_label'] ?? '—' }}</td>
                                        <td data-column-key="last_update">{{ $signal['last_update'] ?? '—' }}</td>
                                        <td data-column-key="notes_summary" class="vn-table-text-long vn-muted-value">{{ $signal['notes_summary'] ?? '—' }}</td>
                                    </tr>
                                    <tr id="{{ $propertiesTarget }}" class="vn-signal-child-row" data-signal-child-row="{{ $propertiesTarget }}" hidden>
                                        <td colspan="10">
                                            <div class="vn-child-panel">
                                                <div class="vn-child-panel__header"><h4 class="vn-child-panel__title">العقارات المرتبطة بالإشارة {{ $signal['signal_number'] ?? '—' }}</h4><span class="vn-child-panel__meta">{{ number_format((int) ($signal['properties_count'] ?? 0)) }} عقارات</span></div>
                                                <div class="vn-child-panel__table-wrap">
                                                    <table class="vn-child-table">
                                                        <thead><tr><th>رقم البطاقة</th><th>المحافظة</th><th>المنطقة</th><th>المقاطعة</th><th>المساحة</th><th>الحالة</th><th>آخر تحديث</th></tr></thead>
                                                        <tbody>
                                                        @foreach (($signal['related_properties'] ?? []) as $property)
                                                            <tr>
                                                                <td>{{ $property['record_number'] ?? ($property['property_card_id'] ?? '—') }}</td>
                                                                <td>{{ $property['governorate'] ?? '—' }}</td>
                                                                <td>{{ $property['region_name'] ?? '—' }}</td>
                                                                <td>{{ $property['subdivision'] ?? '—' }}</td>
                                                                <td>{{ ($property['total_area_m2'] ?? '—') }} {{ $property['card_area_unit'] ?? '' }}</td>
                                                                <td>{{ $property['card_status'] ?? '—' }}</td>
                                                                <td>{{ $property['updated_at'] ?? '—' }}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="{{ $detailsTarget }}" class="vn-signal-child-row" data-signal-child-row="{{ $detailsTarget }}" hidden>
                                        <td colspan="10">
                                            <div class="vn-child-panel">
                                                <div class="vn-child-panel__header"><h4 class="vn-child-panel__title">تفاصيل الأطراف والمصادر</h4></div>
                                                <div class="vn-child-panel__table-wrap">
                                                    <table class="vn-child-table"><tbody>
                                                        <tr><th>أصحاب الإشارة</th><td>{{ implode('، ', $signal['related_owners'] ?? []) ?: '—' }}</td></tr>
                                                        <tr><th>المتضررون</th><td>{{ implode('، ', $signal['related_victims'] ?? []) ?: '—' }}</td></tr>
                                                        <tr><th>مصادر الإشارة</th><td>{{ implode('، ', $signal['related_sources'] ?? []) ?: '—' }}</td></tr>
                                                    </tbody></table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="vn-pagination-wrap">
                @include('viewer-new.partials.pagination', ['paginator' => $signals ?? null])
            </div>
        @else
            @include('viewer-new.partials.empty-state', ['title' => 'لا توجد إشارات مطابقة', 'message' => 'جرّب تغيير معايير البحث أو إزالة الفلاتر الحالية.'])
        @endif
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const scope = document.querySelector('.vn-signals-report');
            if (!scope) return;

            scope.querySelectorAll('[data-signal-child-toggle]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const target = btn.getAttribute('data-target');
                    if (!target) return;

                    const row = scope.querySelector('[data-signal-child-row="' + target + '"]');
                    if (!row) return;

                    const willOpen = row.hidden;
                    row.hidden = !willOpen;

                    btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
                    btn.textContent = willOpen
                        ? (btn.getAttribute('data-hide-label') || '▴')
                        : (btn.getAttribute('data-show-label') || '▾');
                });
            });
        });
    </script>
@endsection
