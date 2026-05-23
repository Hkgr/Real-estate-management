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
            } elseif ($value === null || $value === '') {
                continue;
            }

            $activeFilters[] = ['label' => $label, 'value' => $value];
        }
    @endphp

    <section class="vn-owners-report" id="page-owners">
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
                            <input type="checkbox" data-column-toggle value="{{ $key }}" checked>
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="vn-report-generator__actions">
                    <button type="submit" class="vn-report-toolbar-button">تطبيق الفلاتر</button>
                    <a href="{{ route('viewer-new.reports.owners') }}" class="vn-report-toolbar-button">إعادة تعيين</a>
                </div>
            </form>
        </section>

        @if ($activeFilters !== [])
            <section class="vn-active-filters" aria-label="الفلاتر المفعلة">
                @foreach ($activeFilters as $filter)
                    <span class="vn-filter-chip">{{ $filter['label'] }}: {{ $filter['value'] }}</span>
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
                <table>
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
                                <td data-column-key="properties_linked_count">{{ $owner['properties_linked_count'] ?? '—' }}</td>
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
