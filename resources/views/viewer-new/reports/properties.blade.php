@extends('viewer-new.layouts.app')

@section('page_title', 'تقرير العقارات')
@section('topbar_title', 'تقرير العقارات')
@section('active', 'reports')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'العودة إلى بوابة التقارير')

@section('content')
    @include('viewer-new.partials.page-header', ['title' => 'تقرير العقارات', 'subtitle' => 'متابعة حالة العقارات ومؤشرات الأداء الأساسية'])

    <section class="vn-report-metrics">
        <article class="vn-metric-card"><span>عدد العقارات</span><strong>148</strong></article>
        <article class="vn-metric-card"><span>المساحة الإجمالية</span><strong>92,400 م²</strong></article>
        <article class="vn-metric-card"><span>القيمة التقديرية</span><strong>‎₨ 84,300,000</strong></article>
        <article class="vn-metric-card"><span>آخر تحديث</span><strong>18-05-2026</strong></article>
    </section>

    <section class="vn-table-card vn-report-detail">
        <div class="vn-table-card__head"><h3>تفاصيل العقارات</h3></div>
        <div class="vn-table-responsive">
            <table>
                <thead><tr><th>العقار</th><th>المنطقة</th><th>المساحة</th><th>الحالة</th><th>ملاحظات</th></tr></thead>
                <tbody>
                    <tr><td>فيلا النخبة 12</td><td>الرياض</td><td>1,250 م²</td><td>نشط</td><td>تحديث الصك خلال أسبوع</td></tr>
                    <tr><td>عمارة الواحة 7</td><td>جدة</td><td>3,100 م²</td><td>قيد المتابعة</td><td>تدقيق بيانات الإيجار</td></tr>
                    <tr><td>مخزن الشرق 3</td><td>الدمام</td><td>2,750 م²</td><td>نشط</td><td>جاهز للتأجير</td></tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection
