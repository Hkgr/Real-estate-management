@extends('viewer-new.layouts.app')

@section('page_title', 'تقرير الإشارات')
@section('extra_styles')
    @vite(['resources/css/viewer-new/properties-report.css'])
@endsection
@section('topbar_title', 'تقرير الإشارات')
@section('active', 'reports')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'العودة إلى بوابة التقارير')

@section('content')
    @php
        $paginator    = $signals ?? null;
        $hasPaginator = $paginator && method_exists($paginator, 'total');
        $totalResults = $hasPaginator ? $paginator->total()       : 0;
        $currentPage  = $hasPaginator ? $paginator->currentPage() : 1;
        $lastPage     = $hasPaginator ? $paginator->lastPage()    : 1;
        $currentCount = $hasPaginator ? $paginator->count()       : 0;

        $signalTableColspan = 7;
        $signalColumnKeys = [
            'signal_type', 'property_label', 'owner_label',
            'signal_date', 'status', 'last_update', 'notes',
        ];
        $signalColumnLabels = [
            'signal_type'    => 'نوع الإشارة',
            'property_label' => 'العقار المرتبط',
            'owner_label'    => 'المالك المرتبط',
            'signal_date'    => 'التاريخ',
            'status'         => 'الحالة',
            'last_update'    => 'آخر تحديث',
            'notes'          => 'ملاحظات',
        ];
        $signalColWidths = [
            'signal_type'    => 150,
            'property_label' => 180,
            'owner_label'    => 220,
            'signal_date'    => 130,
            'status'         => 130,
            'last_update'    => 140,
            'notes'          => 280,
        ];
        $signalTableColTotal = max(1, (int) array_sum($signalColWidths));

        $filterLabels = [
            'q'      => 'بحث شامل',
            'type'   => 'النوع',
            'status' => 'الحالة',
        ];
        $activeFilters = [];
        foreach ($filterLabels as $key => $label) {
            $value = $filters[$key] ?? null;
            if ($value === null || $value === '') continue;
            $activeFilters[] = ['label' => $label, 'value' => $value];
        }

        $defaultColsJson = json_encode(array_values($signalColumnKeys));
    @endphp

    <section class="vn-properties-report vn-signals-report"
             id="page-signals"
             style="--vn-pr-table-min-width: {{ $signalTableColTotal }}px"
             data-report-gen-key="viewer_new_signals_generator_open"
             data-report-col-key="viewer_new_signals_visible_columns"
             data-report-default-cols="{{ htmlspecialchars($defaultColsJson, ENT_QUOTES, 'UTF-8') }}">

        <header class="page-header vn-report-hero">
            <div class="page-header-row vn-report-hero__row">
                <div class="vn-report-hero__content">
                    <div class="page-eyebrow">تقرير الإشارات الكامل</div>
                    <h1 class="page-title">تقرير <em>الإشارات</em></h1>
                    <p class="page-subtitle">متابعة الإشارات التشغيلية والتنبيهات — مع تصفية متقدمة واستعراض منظم</p>
                </div>
                <div class="vn-report-hero__meta-wrap">
                    <div class="selection-card vn-report-hero__meta">
                        <a href="{{ route('viewer-new.reports') }}" class="vn-report-hero__back">العودة إلى بوابة التقارير</a>
                        <div class="selection-main-value">{{ $metrics['total_signals'] ?? '—' }}</div>
                        <div class="selection-subvalue">إجمالي النتائج: {{ number_format((int) $totalResults) }}</div>
                        <div class="selection-bar" aria-hidden="true">
                            <div class="selection-bar-fill" style="width:{{ $totalResults > 0 ? '100' : '0' }}%"></div>
                        </div>
                        <div class="selection-meta">
                            <span>نشطة: {{ $metrics['active_signals'] ?? '—' }}</span>
                            <span>{{ number_format((int) $currentCount) }} معروض</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="report-focus-target" data-properties-focus-target>

        <section class="table-toolbar vn-report-toolbar" aria-label="شريط أدوات تقرير الإشارات">
            <div class="toolbar-main-actions vn-report-toolbar__main">
                <div class="toolbar-inline-search vn-report-toolbar__search active">
                    <label for="filter-q-signals" class="vn-report-toolbar__search-label filter-label">بحث شامل</label>
                    <input id="filter-q-signals" class="search-input" type="text" name="q"
                           form="vn-signals-report-generator-form"
                           value="{{ $filters['q'] ?? '' }}"
                           placeholder="بحث في رقم / نوع / ملاحظات الإشارة" />
                    <button type="button" class="toolbar-search-close vn-report-toolbar-button"
                            data-properties-clear-search aria-label="مسح البحث">✕</button>
                </div>
                <button type="button" class="toolbar-main-btn vn-report-toolbar-button"
                        data-report-generator-toggle aria-expanded="false"
                        aria-controls="vn-signals-generator-panel">مولد تقارير</button>
                <button type="button" class="toolbar-main-btn vn-report-toolbar-button vn-report-toolbar-button--disabled"
                        disabled aria-disabled="true" title="سيتم دعم التصدير لاحقاً">تصدير ▾</button>
                <button type="button" class="toolbar-main-btn vn-report-toolbar-button"
                        data-properties-fullscreen>⛶ ملء الشاشة</button>
            </div>
        </section>

        <section id="vn-signals-generator-panel" class="toolbar-mode-panel vn-report-generator" data-report-generator-panel>
            <form id="vn-signals-report-generator-form" method="GET"
                  action="{{ route('viewer-new.reports.signals') }}"
                  data-report-generator-form class="vn-report-generator__form">
                <div class="vn-report-generator__body">
                <div class="vn-report-generator__filters vn-report-generator__filters--compact">

                <div class="vn-report-generator__field">
                    <label for="filter-q-sig-gen">بحث شامل</label>
                    <input id="filter-q-sig-gen" type="text" name="q"
                           value="{{ $filters['q'] ?? '' }}"
                           placeholder="رقم / نوع / ملاحظات" />
                </div>

                @if (($fieldAvailability['type'] ?? false) && !empty($typeOptions))
                <div class="vn-report-generator__field">
                    <label for="filter-type">النوع</label>
                    <select id="filter-type" name="type">
                        <option value="">الكل</option>
                        @foreach ($typeOptions as $opt)
                            <option value="{{ $opt }}" @selected(($filters['type'] ?? '') === $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                @if (($fieldAvailability['status'] ?? false) && !empty($statusOptions))
                <div class="vn-report-generator__field">
                    <label for="filter-status">الحالة</label>
                    <select id="filter-status" name="status">
                        <option value="">الكل</option>
                        @foreach ($statusOptions as $opt)
                            <option value="{{ $opt }}" @selected(($filters['status'] ?? '') === $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                </div>

                <div class="vn-report-generator__columns vn-report-generator__columns--compact" data-column-picker>
                    @foreach ($signalColumnLabels as $key => $label)
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
                    <a href="{{ route('viewer-new.reports.signals') }}" class="vn-report-toolbar-button">إعادة تعيين</a>
                    <button type="button" class="vn-report-toolbar-button" data-reset-columns>إعادة الافتراضي</button>
                    <button type="button" class="vn-report-toolbar-button vn-report-toolbar-button--primary"
                            data-generate-report>توليد تقرير</button>
                </div>
                </div>
            </form>
        </section>

        <section class="vn-active-filter-chips" aria-label="الفلاتر المفعلة">
            @if (count($activeFilters) > 0)
                @foreach ($activeFilters as $chip)
                    <span class="vn-active-filter-chip">{{ $chip['label'] }}: {{ $chip['value'] }}</span>
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

        @if ($currentCount > 0)
        <div class="vn-table-card vn-property-table-card">
        <div class="vn-table-with-scroll">
        <div class="vn-tbl-top-scroll" aria-hidden="true"><div class="vn-tbl-top-scroll-inner"></div></div>
        <div class="vn-table-responsive vn-properties-table table-overflow" id="vn-signals-overflow">
            <table id="vn-properties-table" class="vn-big-table big-table"
                   data-property-table-colspan="{{ $signalTableColspan }}">
                <colgroup id="vn-properties-colgroup">
                    @foreach ($signalColumnKeys as $colKey)
                        <col class="vn-col-{{ $colKey }}"
                             data-column-key="{{ $colKey }}"
                             data-col-key="{{ $colKey }}"
                             style="width:{{ (int) ($signalColWidths[$colKey] ?? 140) }}px;min-width:{{ (int) ($signalColWidths[$colKey] ?? 140) }}px">
                    @endforeach
                </colgroup>
                <thead>
                    <tr>
                        @foreach ($signalColumnKeys as $colKey)
                            <th data-column-key="{{ $colKey }}" data-col-key="{{ $colKey }}"
                                class="vn-col-{{ $colKey }}">
                                <div class="vn-th-inner th-inner">
                                    <span class="vn-th-label">{{ $signalColumnLabels[$colKey] ?? $colKey }}</span>
                                    <button type="button" class="vn-col-pin-btn col-pin-btn"
                                            data-col-pin="{{ $colKey }}"
                                            aria-label="تثبيت العمود" title="تثبيت العمود" aria-pressed="false">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="17" x2="12" y2="22"/><path d="M5 17h14v-1.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V6h1a2 2 0 0 0 0-4H8a2 2 0 0 0 0 4h1v4.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24Z"/></svg>
                                    </button>
                                </div>
                                <span class="vn-col-resize-handle col-resize-handle"
                                      data-col-resize="{{ $colKey }}" aria-hidden="true"></span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($signals as $signal)
                        @php
                            $statusRaw = (string) ($signal['status'] ?? '');
                            $statusNorm = strtolower(trim($statusRaw));
                            $statusClass = 'vn-status-badge--muted';
                            if (in_array($statusNorm, ['active', 'نشط', 'مفتوح'], true)) $statusClass = 'vn-status-badge--success';
                            elseif (in_array($statusNorm, ['closed', 'منتهي', 'مغلق'], true)) $statusClass = 'vn-status-badge--danger';
                        @endphp
                        <tr>
                            <td data-column-key="signal_type">
                                @if ($signal['signal_type'] !== '—')
                                    <span class="vn-status-badge vn-status-badge--warning">{{ $signal['signal_type'] }}</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td data-column-key="property_label" class="vn-table-number">{{ $signal['property_label'] ?? '—' }}</td>
                            <td data-column-key="owner_label" class="vn-table-text-long">{{ $signal['owner_label'] ?? '—' }}</td>
                            <td data-column-key="signal_date">{{ $signal['signal_date'] ?? '—' }}</td>
                            <td data-column-key="status">
                                @if ($statusRaw !== '' && $statusRaw !== '—')
                                    <span class="vn-status-badge {{ $statusClass }}">{{ $statusRaw }}</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td data-column-key="last_update">{{ $signal['last_update'] ?? '—' }}</td>
                            <td data-column-key="notes" class="vn-muted-value">{{ $signal['notes'] ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
        </div>
        @else
            @include('viewer-new.partials.empty-state', [
                'title'   => 'لا توجد إشارات مطابقة',
                'message' => 'جرّب تغيير معايير البحث أو إزالة الفلاتر الحالية.',
            ])
        @endif

        <div class="vn-pagination-wrap">
            @include('viewer-new.partials.pagination', ['paginator' => $signals ?? null])
        </div>

        </div>{{-- /report-focus-target --}}
    </section>
@endsection
