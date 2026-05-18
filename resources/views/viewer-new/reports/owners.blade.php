@extends('viewer-new.layouts.app')

@section('page_title', 'تقرير المالك')
@section('topbar_title', 'تقرير المالك')
@section('active', 'reports')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'العودة إلى بوابة التقارير')

@section('content')
    @include('viewer-new.partials.page-header', ['title' => 'تقرير المالك', 'subtitle' => 'عرض موجز لملفات المالكين ونسب الحصص'])

    <section class="vn-report-metrics">
        <article class="vn-metric-card"><span>عدد المالكين</span><strong>36</strong></article>
        <article class="vn-metric-card"><span>إجمالي الحصص</span><strong>100%</strong></article>
        <article class="vn-metric-card"><span>عقود قيد المتابعة</span><strong>9</strong></article>
        <article class="vn-metric-card"><span>آخر تحديث</span><strong>18-05-2026</strong></article>
    </section>

    <section class="vn-table-card vn-report-detail">
        <div class="vn-table-card__head"><h3>تفاصيل المالكين</h3></div>
        <div class="vn-table-responsive">
            <table>
                <thead><tr><th>المالك</th><th>عدد العقارات</th><th>الحصة</th><th>الحالة</th><th>ملاحظات</th></tr></thead>
                <tbody>
                    <tr><td>شركة المدار العقارية</td><td>12</td><td>40%</td><td>مكتمل</td><td>جميع الوثائق محدثة</td></tr>
                    <tr><td>مؤسسة البناء المتين</td><td>8</td><td>25%</td><td>قيد المتابعة</td><td>تجديد عقدين قبل نهاية الشهر</td></tr>
                    <tr><td>عبدالله السالم</td><td>5</td><td>12%</td><td>مكتمل</td><td>لا توجد ملاحظات</td></tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection
