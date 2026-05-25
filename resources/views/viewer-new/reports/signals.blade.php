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
                        <div class="selection-main-value">{{ $metrics['total_signals'] ?? '—' }}</div>
                        <div class="selection-subvalue">إجمالي النتائج: {{ number_format((int) $totalResults) }}</div>
                        <div class="selection-bar" aria-hidden="true"><div class="selection-bar-fill" style="width:{{ $totalResults > 0 ? '100' : '0' }}%"></div></div>
                        <div class="selection-meta">
                            <span>بطاقات مرتبطة: {{ $metrics['linked_property_cards'] ?? 'غير متوفر' }}</span>
                            <span>عقارات مرتبطة: {{ $metrics['linked_properties'] ?? 'غير متوفر' }}</span>
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
                                    <th data-column-key="id"><div class="vn-th-inner">ID</div></th>
                                    <th data-column-key="signal_id"><div class="vn-th-inner">رقم الإشارة</div></th>
                                    <th data-column-key="signal_type"><div class="vn-th-inner">نوع الإشارة</div></th>
                                    <th data-column-key="property_label"><div class="vn-th-inner">العقار المرتبط</div></th>
                                    <th data-column-key="owners_label"><div class="vn-th-inner">أصحاب الإشارة</div></th>
                                    <th data-column-key="victims_label"><div class="vn-th-inner">المتضررون</div></th>
                                    <th data-column-key="sources_label"><div class="vn-th-inner">مصادر الإشارة</div></th>
                                    <th data-column-key="signal_date"><div class="vn-th-inner">تاريخ الإشارة</div></th>
                                    <th data-column-key="signal_source_date"><div class="vn-th-inner">تاريخ مصدر الإشارة</div></th>
                                    <th data-column-key="created_at"><div class="vn-th-inner">تاريخ الإنشاء</div></th>
                                    <th data-column-key="last_update"><div class="vn-th-inner">آخر تحديث</div></th>
                                    <th data-column-key="notes"><div class="vn-th-inner">ملاحظات</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($signals as $signal)
                                    <tr>
                                        <td data-column-key="id">{{ $signal['id'] ?? '—' }}</td>
                                        <td data-column-key="signal_id">{{ $signal['signal_id'] ?? '—' }}</td>
                                        <td data-column-key="signal_type">{{ $signal['signal_type'] ?? '—' }}</td>
                                        <td data-column-key="property_label">{{ $signal['property_label'] ?? '—' }}</td>
                                        <td data-column-key="owners_label">{{ $signal['owners_label'] ?? '—' }}</td>
                                        <td data-column-key="victims_label">{{ $signal['victims_label'] ?? '—' }}</td>
                                        <td data-column-key="sources_label">{{ $signal['sources_label'] ?? '—' }}</td>
                                        <td data-column-key="signal_date">{{ $signal['signal_date'] ?? '—' }}</td>
                                        <td data-column-key="signal_source_date">{{ $signal['signal_source_date'] ?? '—' }}</td>
                                        <td data-column-key="created_at">{{ $signal['created_at'] ?? '—' }}</td>
                                        <td data-column-key="last_update">{{ $signal['last_update'] ?? '—' }}</td>
                                        <td data-column-key="notes" class="vn-muted-value">{{ $signal['notes'] ?? '—' }}</td>
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
@endsection
