@extends('viewer-new.layouts.app')

@section('page_title', 'تقرير الملاك')
@section('topbar_title', 'تقرير الملاك')
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

        $columnOptions = [
            'name' => 'المالك',
            'phone' => 'رقم الهاتف',
            'properties_linked_count' => 'عدد العقارات المرتبطة',
            'ownership_percentage' => 'الحصة',
            'current_ownerships_count' => 'الملكيات الحالية',
            'last_update' => 'آخر تحديث',
            'status_or_notes' => 'الحالة / الملاحظات',
        ];

        $activeFilters = [];

        if (filled($filters['q'] ?? null)) {
            $activeFilters[] = ['label' => 'بحث شامل', 'value' => $filters['q']];
        }

        if (filled($filters['current'] ?? null)) {
            $currentValue = (string) $filters['current'];
            if ($currentValue === '1') {
                $activeFilters[] = ['label' => 'حالة الملكية', 'value' => 'ملكية حالية فقط'];
            } elseif ($currentValue === '0') {
                $activeFilters[] = ['label' => 'حالة الملكية', 'value' => 'ملكية غير حالية فقط'];
            }
        } elseif (($filters['current'] ?? null) === '0') {
            $activeFilters[] = ['label' => 'حالة الملكية', 'value' => 'ملكية غير حالية فقط'];
        }
    @endphp

    <section class="vn-owners-report">
        <header class="vn-report-hero">
            <div class="vn-report-hero__content">
                <p>تقرير الملاك الكامل</p>
                <h1>تقرير الملاك</h1>
                <p>عرض سجلات الملاك والحصص والملكيات المرتبطة</p>
            </div>
            <div class="vn-report-hero__meta">
                <a href="{{ route('viewer-new.reports') }}">العودة إلى بوابة التقارير</a>
                @if ($hasPaginator)
                    <span>إجمالي النتائج: {{ number_format((int) $totalResults) }}</span>
                @endif
            </div>
        </header>

        <section class="vn-report-toolbar" aria-label="شريط أدوات تقرير الملاك">
            <div class="vn-report-toolbar__search">
                <label for="owners-filter-q" class="vn-report-toolbar__search-label">بحث شامل</label>
                <input id="owners-filter-q" type="text" name="q" form="vn-owners-report-generator-form" value="{{ $filters['q'] ?? '' }}" placeholder="ابحث بالاسم أو الهاتف أو البريد..." @if (! ($fieldAvailability['filters_q'] ?? false)) disabled @endif />
                <button type="button" class="vn-report-toolbar-button" data-owners-clear-search aria-label="مسح البحث">مسح</button>
            </div>
            <div class="vn-report-toolbar__actions">
                <button type="button" class="vn-report-toolbar-button vn-report-toolbar-button--primary vn-report-toolbar-button--active" data-report-generator-toggle aria-expanded="true" aria-controls="vn-owners-generator-panel">مولد تقارير</button>
                <button type="button" class="vn-report-toolbar-button vn-report-toolbar-button--disabled" disabled aria-disabled="true" title="سيتم دعم التصدير لاحقاً">تصدير</button>
                <button type="button" class="vn-report-toolbar-button" data-owners-fullscreen>ملء الشاشة</button>
            </div>
        </section>

        <section id="vn-owners-generator-panel" class="vn-report-generator is-open" data-report-generator-panel>
            <form id="vn-owners-report-generator-form" method="GET" action="{{ route('viewer-new.reports.owners') }}" data-report-generator-form>
                <div class="vn-report-generator__filters">
                    @if ($fieldAvailability['is_current'] ?? false)
                        <div class="vn-report-generator__field">
                            <label for="owners-filter-current">حالة الملكية</label>
                            <select id="owners-filter-current" name="current">
                                <option value="">كل حالات الملكية</option>
                                <option value="1" @selected(($filters['current'] ?? null) === '1')>ملكية حالية فقط</option>
                                <option value="0" @selected(($filters['current'] ?? null) === '0')>ملكية غير حالية فقط</option>
                            </select>
                        </div>
                    @endif
                </div>

                <div class="vn-report-generator__columns" data-column-picker>
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
            @else
                <span class="vn-active-filter-chip">لا توجد فلاتر مفعّلة</span>
            @endif
        </section>

        <section class="vn-results-summary" aria-label="ملخص النتائج">
            <article><h3>عدد النتائج الكلي</h3><p>{{ number_format((int) $totalResults) }}</p></article>
            <article><h3>الصفحة الحالية</h3><p>{{ number_format((int) $currentPage) }}</p></article>
            <article><h3>آخر صفحة</h3><p>{{ number_format((int) $lastPage) }}</p></article>
            <article><h3>عدد السجلات المعروضة</h3><p>{{ number_format((int) $currentCount) }}</p></article>
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
                                <td data-column-key="name">{{ filled((string) ($owner['name'] ?? null)) ? $owner['name'] : '—' }}</td>
                                <td data-column-key="phone">{{ filled((string) ($owner['phone'] ?? null)) ? $owner['phone'] : '—' }}</td>
                                <td data-column-key="properties_linked_count">{{ filled((string) ($owner['properties_linked_count'] ?? null)) ? $owner['properties_linked_count'] : '—' }}</td>
                                <td data-column-key="ownership_percentage" class="vn-muted-value">{{ filled((string) ($owner['ownership_percentage'] ?? null)) ? $owner['ownership_percentage'] : '—' }}</td>
                                <td data-column-key="current_ownerships_count">{{ filled((string) ($owner['current_ownerships_count'] ?? null)) ? $owner['current_ownerships_count'] : '—' }}</td>
                                <td data-column-key="last_update">{{ filled((string) ($owner['last_update'] ?? null)) ? $owner['last_update'] : '—' }}</td>
                                <td data-column-key="status_or_notes" class="vn-muted-value">{{ filled((string) ($owner['status_or_notes'] ?? null)) ? $owner['status_or_notes'] : '—' }}</td>
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
