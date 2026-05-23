@extends('viewer-new.layouts.app')

@section('page_title', 'تقرير المالك')
@section('topbar_title', 'تقرير المالك')
@section('active', 'reports')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'العودة إلى بوابة التقارير')

@section('content')
    @include('viewer-new.partials.page-header', ['title' => 'تقرير المالك', 'subtitle' => 'عرض موجز لملفات المالكين ونسب الحصص'])

    @include('viewer-new.partials.report-metrics', [
        'items' => [
            ['label' => 'عدد المالكين', 'value' => $metrics['total_owners'] ?? '—'],
            ['label' => 'إجمالي روابط الملكية', 'value' => $metrics['total_ownership_links'] ?? '—'],
            ['label' => 'الملكيات الحالية', 'value' => $metrics['current_ownerships'] ?? '—'],
            ['label' => 'إجمالي العقارات المرتبطة', 'value' => $metrics['total_properties_linked'] ?? '—'],
            ['label' => 'آخر تحديث', 'value' => $metrics['last_update'] ?? '—'],
        ],
    ])

    <section class="vn-table-card vn-report-detail">
        <div class="vn-table-card__head"><h3>تفاصيل المالكين</h3></div>

        <form method="GET" class="vn-properties-filter vn-owners-filter">
            <input
                type="text"
                name="q"
                value="{{ $filters['q'] ?? '' }}"
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

        @if (($owners ?? collect())->count() > 0)
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
                                <td>
                                    <div>{{ $owner['name'] }}</div>
                                    <div class="vn-muted-value">نوع المالك: {{ $owner['owner_type'] ?? '—' }}</div>
                                    <div class="vn-muted-value">اسم الأب: {{ $owner['father_name'] ?? '—' }}</div>
                                </td>
                                <td>
                                    <div>{{ $owner['phone'] }}</div>
                                    <div class="vn-muted-value vn-table-text-long">البريد: {{ $owner['email'] ?? '—' }}</div>
                                </td>
                                <td>{{ $owner['properties_linked_count'] }}</td>
                                <td class="vn-muted-value">{{ $owner['ownership_percentage'] }}</td>
                                <td>{{ $owner['current_ownerships_count'] }}</td>
                                <td>{{ $owner['last_update'] }}</td>
                                <td class="vn-muted-value">
                                    <div class="vn-table-text-long">{{ $owner['status_or_notes'] }}</div>
                                    <div>الرقم الوطني: {{ $owner['national_id'] ?? '—' }}</div>
                                    <div>رقم السجل التجاري: {{ $owner['commercial_register_number'] ?? '—' }}</div>
                                    <div>رقم السجل العقاري: {{ $owner['real_estate_registry_number'] ?? '—' }}</div>
                                    <div>تاريخ الميلاد: {{ $owner['birth_date'] ?? '—' }}</div>
                                    <div>تاريخ الإضافة: {{ $owner['created_at'] ?? '—' }}</div>
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
