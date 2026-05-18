@extends('viewer-new.layouts.app')

@section('page_title', 'تقرير الإشارات')
@section('topbar_title', 'تقرير الإشارات')
@section('active', 'reports')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'العودة إلى بوابة التقارير')

@section('content')
    @include('viewer-new.partials.page-header', ['title' => 'تقرير الإشارات', 'subtitle' => 'متابعة الإشارات التشغيلية والتنبيهات الحديثة'])

    <section class="vn-report-metrics">
        <article class="vn-metric-card"><span>إجمالي الإشارات</span><strong>{{ $metrics['total_signals'] ?? '—' }}</strong></article>
        <article class="vn-metric-card"><span>إشارات نشطة</span><strong>{{ $metrics['active_signals'] ?? 'غير متوفر' }}</strong></article>
        <article class="vn-metric-card"><span>إشارات منتهية</span><strong>{{ $metrics['closed_signals'] ?? 'غير متوفر' }}</strong></article>
        <article class="vn-metric-card"><span>عقارات مرتبطة</span><strong>{{ $metrics['linked_properties'] ?? 'غير متوفر' }}</strong></article>
        <article class="vn-metric-card"><span>آخر تحديث</span><strong>{{ $metrics['last_update'] ?? '—' }}</strong></article>
    </section>

    <section class="vn-table-card vn-report-detail">
        <div class="vn-table-card__head"><h3>تفاصيل الإشارات</h3></div>

        <form method="GET" class="vn-signals-filter">
            <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="بحث في رقم/نوع/ملاحظات الإشارة">

            @if(($fieldAvailability['type'] ?? false) && !empty($typeOptions))
                <select name="type">
                    <option value="">كل الأنواع</option>
                    @foreach($typeOptions as $typeOption)
                        <option value="{{ $typeOption }}" @selected(($filters['type'] ?? '') === $typeOption)>{{ $typeOption }}</option>
                    @endforeach
                </select>
            @endif

            @if(($fieldAvailability['status'] ?? false) && !empty($statusOptions))
                <select name="status">
                    <option value="">كل الحالات</option>
                    @foreach($statusOptions as $statusOption)
                        <option value="{{ $statusOption }}" @selected(($filters['status'] ?? '') === $statusOption)>{{ $statusOption }}</option>
                    @endforeach
                </select>
            @endif

            <button type="submit">تصفية</button>
            <a class="vn-filter-reset" href="{{ route('viewer-new.reports.signals') }}">إعادة ضبط</a>
        </form>

        @if($signals->count() > 0)
            <div class="vn-table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>نوع الإشارة</th>
                            <th>العقار المرتبط</th>
                            <th>المالك المرتبط</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                            <th>آخر تحديث</th>
                            <th>ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($signals as $signal)
                            <tr>
                                <td>{{ $signal['signal_type'] }}</td>
                                <td>{{ $signal['property_label'] }}</td>
                                <td>{{ $signal['owner_label'] }}</td>
                                <td>{{ $signal['signal_date'] }}</td>
                                <td>{{ $signal['status'] }}</td>
                                <td>{{ $signal['last_update'] }}</td>
                                <td class="vn-muted-value">{{ $signal['notes'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="vn-pagination-wrap">
                {{ $signals->links() }}
            </div>
        @else
            <div class="vn-empty-state">
                <h4>لا توجد إشارات مطابقة</h4>
                <p>جرّب تغيير معايير البحث أو إزالة الفلاتر الحالية.</p>
            </div>
        @endif
    </section>
@endsection
