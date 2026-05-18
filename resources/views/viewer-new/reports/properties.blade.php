@extends('viewer-new.layouts.app')

@section('page_title', 'تقرير العقارات')
@section('topbar_title', 'تقرير العقارات')
@section('active', 'reports')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'العودة إلى بوابة التقارير')

@section('content')
    @include('viewer-new.partials.page-header', ['title' => 'تقرير العقارات', 'subtitle' => 'متابعة حالة العقارات ومؤشرات الأداء الأساسية'])

    <section class="vn-report-metrics">
        <article class="vn-metric-card"><span>عدد العقارات</span><strong>{{ $metrics['total_properties'] ?? '—' }}</strong></article>
        <article class="vn-metric-card"><span>المساحة الإجمالية</span><strong>{{ $metrics['total_area'] ?? '—' }}</strong></article>
        <article class="vn-metric-card"><span>القيمة التقديرية</span><strong>{{ $metrics['total_estimated_value'] ?? '—' }}</strong></article>
        <article class="vn-metric-card"><span>آخر تحديث</span><strong>{{ $metrics['last_update'] ?? '—' }}</strong></article>
    </section>

    <section class="vn-table-card vn-report-detail">
        <div class="vn-table-card__head">
            <h3>تفاصيل العقارات</h3>
        </div>

        <form method="GET" action="{{ route('viewer-new.reports.properties') }}" class="vn-properties-filter">
            <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="بحث برقم المحضر أو المنطقة أو الملاحظات" aria-label="بحث" />
            <select name="status" aria-label="الحالة">
                <option value="">كل الحالات</option>
                @foreach ($statusOptions as $status)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>
                @endforeach
            </select>
            <button type="submit">تطبيق</button>
            <a href="{{ route('viewer-new.reports.properties') }}" class="vn-filter-reset">إعادة تعيين</a>
        </form>

        @if ($properties->count() > 0)
            <div class="vn-table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>المحضر</th>
                            <th>المحافظة / المنطقة</th>
                            <th>المساحة</th>
                            <th>القيمة</th>
                            <th>الحالة</th>
                            <th>المُلّاك</th>
                            <th>العمليات</th>
                            <th>ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($properties as $property)
                            <tr>
                                <td>{{ $property->id }}</td>
                                <td>{{ $columns['card_record_number'] ? ($property->card_record_number ?: '—') : '—' }}</td>
                                <td>{{ ($columns['card_governorate'] ? ($property->card_governorate ?: '—') : '—') }} / {{ ($columns['card_region_name'] ? ($property->card_region_name ?: '—') : '—') }}</td>
                                <td>{{ $columns['card_total_area'] ? (filled($property->card_total_area) ? number_format((float) $property->card_total_area, 2) . ' م²' : '—') : '—' }}</td>
                                <td>
                                    @php
                                        $value = $columns['total_property_value_usd'] ? $property->total_property_value_usd : ($columns['owned_property_value_usd'] ? $property->owned_property_value_usd : null);
                                    @endphp
                                    {{ filled($value) ? number_format((float) $value, 2) . ' $' : '—' }}
                                </td>
                                <td>{{ $columns['card_status'] ? ($property->card_status ?: '—') : '—' }}</td>
                                <td>{{ $property->owners_count ?? '—' }}</td>
                                <td>{{ $property->operations_count ?? '—' }}</td>
                                <td class="vn-muted-value">{{ $columns['card_property_details'] ? ($property->card_property_details ?: '—') : '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="vn-pagination-wrap">
                {{ $properties->links() }}
            </div>
        @else
            <div class="vn-empty-state">
                <h4>لا توجد نتائج مطابقة</h4>
                <p>لم يتم العثور على عقارات وفقاً لعوامل البحث الحالية.</p>
            </div>
        @endif
    </section>
@endsection
