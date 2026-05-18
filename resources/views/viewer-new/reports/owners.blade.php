@extends('viewer-new.layouts.app')

@section('page_title', 'تقرير المالك')
@section('topbar_title', 'تقرير المالك')
@section('active', 'reports')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'العودة إلى بوابة التقارير')

@section('content')
    @include('viewer-new.partials.page-header', ['title' => 'تقرير المالك', 'subtitle' => 'عرض موجز لملفات المالكين ونسب الحصص'])

    <section class="vn-report-metrics">
        <article class="vn-metric-card"><span>عدد المالكين</span><strong>{{ $metrics['total_owners'] }}</strong></article>
        <article class="vn-metric-card"><span>إجمالي روابط الملكية</span><strong>{{ $metrics['total_ownership_links'] }}</strong></article>
        <article class="vn-metric-card"><span>الملكيات الحالية</span><strong>{{ $metrics['current_ownerships'] }}</strong></article>
        <article class="vn-metric-card"><span>إجمالي العقارات المرتبطة</span><strong>{{ $metrics['total_properties_linked'] }}</strong></article>
        <article class="vn-metric-card"><span>آخر تحديث</span><strong>{{ $metrics['last_update'] }}</strong></article>
    </section>

    <section class="vn-table-card vn-report-detail">
        <div class="vn-table-card__head"><h3>تفاصيل المالكين</h3></div>

        <form method="GET" class="vn-properties-filter vn-owners-filter">
            <input
                type="text"
                name="q"
                value="{{ $filters['q'] }}"
                placeholder="ابحث بالاسم أو الهاتف أو البريد..."
                @if (! $fieldAvailability['filters_q']) disabled @endif
            >

            @if ($fieldAvailability['is_current'])
                <select name="current">
                    <option value="">كل حالات الملكية</option>
                    <option value="1" @selected($filters['current'] === '1')>ملكية حالية فقط</option>
                    <option value="0" @selected($filters['current'] === '0')>ملكية غير حالية فقط</option>
                </select>
            @endif

            <button type="submit">تطبيق الفلاتر</button>
            <a class="vn-filter-reset" href="{{ route('viewer-new.reports.owners') }}">إعادة تعيين</a>
        </form>

        @if ($owners->count())
            <div class="vn-table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>المالك</th>
                            <th>رقم الهاتف</th>
                            <th>عدد العقارات المرتبطة</th>
                            <th>الحصة</th>
                            <th>الملكيات الحالية</th>
                            <th>آخر تحديث</th>
                            <th>الحالة / الملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($owners as $owner)
                            <tr>
                                <td>{{ $owner['name'] }}</td>
                                <td>{{ $owner['phone'] }}</td>
                                <td>{{ $owner['properties_linked_count'] }}</td>
                                <td class="vn-muted-value">{{ $owner['ownership_percentage'] }}</td>
                                <td>{{ $owner['current_ownerships_count'] }}</td>
                                <td>{{ $owner['last_update'] }}</td>
                                <td class="vn-muted-value">{{ $owner['status_or_notes'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="vn-pagination-wrap">
                {{ $owners->links() }}
            </div>
        @else
            <div class="vn-empty-state">
                <h4>لا توجد نتائج مطابقة</h4>
                <p>حاول تعديل معايير البحث أو إزالة الفلاتر لعرض جميع المالكين.</p>
            </div>
        @endif
    </section>
@endsection
