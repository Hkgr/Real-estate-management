@extends('viewer-new.layouts.app')

@section('page_title', 'تقرير الملحقات')
@section('topbar_title', 'تقرير الملحقات')
@section('active', 'reports')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'العودة إلى بوابة التقارير')

@section('content')
    @include('viewer-new.partials.page-header', ['title' => 'تقرير الملحقات', 'subtitle' => 'مراجعة حالة الملفات والوثائق المرتبطة بالعقارات'])

    <section class="vn-report-metrics">
        <article class="vn-metric-card"><span>عدد الملفات</span><strong>312</strong></article>
        <article class="vn-metric-card"><span>ملفات ناقصة</span><strong>27</strong></article>
        <article class="vn-metric-card"><span>ملفات مكتملة</span><strong>285</strong></article>
        <article class="vn-metric-card"><span>آخر تحديث</span><strong>18-05-2026</strong></article>
    </section>

    <section class="vn-table-card vn-report-detail">
        <div class="vn-table-card__head"><h3>تفاصيل الملحقات</h3></div>
        <div class="vn-table-responsive">
            <table>
                <thead><tr><th>نوع الملف</th><th>العقار</th><th>الحالة</th><th>تاريخ الإضافة</th><th>ملاحظات</th></tr></thead>
                <tbody>
                    <tr><td>صك ملكية</td><td>فيلا النخبة 12</td><td>مكتمل</td><td>14-05-2026</td><td>نسخة مصدقة</td></tr>
                    <tr><td>عقد إيجار</td><td>عمارة الواحة 7</td><td>ناقص</td><td>13-05-2026</td><td>توقيع المستأجر مطلوب</td></tr>
                    <tr><td>رخصة تشغيل</td><td>مخزن الشرق 3</td><td>مكتمل</td><td>11-05-2026</td><td>صالحة حتى 2028</td></tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection
