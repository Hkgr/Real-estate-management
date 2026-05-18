@extends('viewer-new.layouts.app')

@section('page_title', 'تقرير الملحقات')
@section('topbar_title', 'تقرير الملحقات')
@section('active', 'reports')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'العودة إلى بوابة التقارير')

@section('content')
    @include('viewer-new.partials.page-header', ['title' => 'تقرير الملحقات', 'subtitle' => 'مراجعة حالة الملفات والوثائق المرتبطة بالعقارات'])

    <section class="vn-report-metrics">
        <article class="vn-metric-card"><span>عدد الملفات</span><strong>{{ $metrics['total_files'] ?? '—' }}</strong></article>
        <article class="vn-metric-card"><span>العقارات المرتبطة</span><strong>{{ $metrics['linked_properties'] ?? 'غير متوفر' }}</strong></article>
        <article class="vn-metric-card"><span>عدد أنواع الملفات</span><strong>{{ $metrics['file_types_count'] ?? 'غير متوفر' }}</strong></article>
        <article class="vn-metric-card"><span>إجمالي الحجم التخزيني</span><strong>{{ $metrics['total_storage_size'] ?? 'غير متوفر' }}</strong></article>
        <article class="vn-metric-card"><span>آخر رفع/تحديث</span><strong>{{ $metrics['latest_upload_or_update'] ?? 'غير متوفر' }}</strong></article>
    </section>

    <section class="vn-table-card vn-report-detail">
        <div class="vn-table-card__head"><h3>تفاصيل الملحقات</h3></div>

        <form method="GET" action="{{ route('viewer-new.reports.attachments') }}" class="vn-attachments-filter">
            <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="بحث باسم الملف أو نوعه">

            @if(!empty($typeOptions))
                <select name="type">
                    <option value="">كل الأنواع</option>
                    @foreach($typeOptions as $type)
                        <option value="{{ $type }}" @selected(($filters['type'] ?? '') === $type)>{{ $type }}</option>
                    @endforeach
                </select>
            @endif

            @if(($fieldAvailability['property_card_id'] ?? false) === true)
                <input type="text" name="property" value="{{ $filters['property'] ?? '' }}" placeholder="بحث بالعقار المرتبط أو رقمه">
            @endif

            <button type="submit">تطبيق</button>
            <a href="{{ route('viewer-new.reports.attachments') }}" class="vn-filter-reset">إعادة ضبط</a>
        </form>

        @if(($attachments ?? collect())->count() > 0)
            <div class="vn-table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>اسم الملف</th>
                            <th>نوع الملف</th>
                            <th>العقار المرتبط</th>
                            <th>تاريخ الإضافة</th>
                            <th>الحجم</th>
                            <th>آخر تحديث</th>
                            <th>تحميل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attachments as $file)
                            <tr>
                                <td>{{ $file['file_name'] }}</td>
                                <td>{{ $file['mime_type'] }}</td>
                                <td class="vn-muted-value">{{ $file['property_title'] }}</td>
                                <td>{{ $file['issued_at'] }}</td>
                                <td>{{ $file['file_size_human'] }}</td>
                                <td>{{ $file['created_or_updated_at'] }}</td>
                                <td>
                                    @if(!empty($file['download_url']))
                                        <a class="vn-attachment-download" href="{{ $file['download_url'] }}">تحميل</a>
                                    @else
                                        <span class="vn-muted-value">غير متوفر</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="vn-pagination-wrap">
                @include('viewer-new.partials.pagination', ['paginator' => $attachments ?? null])
            </div>
        @else
            @include('viewer-new.partials.empty-state', ['title' => 'لا توجد ملحقات مطابقة', 'message' => 'جرّب تعديل معايير البحث أو إزالة الفلاتر لعرض نتائج إضافية.'])
        @endif
    </section>
@endsection
