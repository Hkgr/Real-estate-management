@extends('viewer-new.layouts.app')

@section('page_title', 'تقرير الإشارات')
@section('topbar_title', 'تقرير الإشارات')
@section('active', 'reports')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'العودة إلى بوابة التقارير')

@section('content')
    @include('viewer-new.partials.page-header', ['title' => 'تقرير الإشارات', 'subtitle' => 'متابعة الإشارات التشغيلية والتنبيهات الحديثة'])

    <section class="vn-report-metrics">
        <article class="vn-metric-card"><span>إجمالي الإشارات</span><strong>64</strong></article>
        <article class="vn-metric-card"><span>إشارات نشطة</span><strong>21</strong></article>
        <article class="vn-metric-card"><span>إشارات منتهية</span><strong>43</strong></article>
        <article class="vn-metric-card"><span>آخر تحديث</span><strong>18-05-2026</strong></article>
    </section>

    <section class="vn-table-card vn-report-detail">
        <div class="vn-table-card__head"><h3>تفاصيل الإشارات</h3></div>
        <div class="vn-table-responsive">
            <table>
                <thead><tr><th>نوع الإشارة</th><th>العقار</th><th>التاريخ</th><th>الحالة</th><th>ملاحظات</th></tr></thead>
                <tbody>
                    <tr><td>تنبيه صيانة</td><td>برج الأفق</td><td>17-05-2026</td><td>نشطة</td><td>موعد المعاينة غداً</td></tr>
                    <tr><td>تجديد عقد</td><td>فيلا النخبة 12</td><td>16-05-2026</td><td>منتهية</td><td>تم التوقيع</td></tr>
                    <tr><td>انخفاض إشغال</td><td>عمارة الواحة 7</td><td>15-05-2026</td><td>نشطة</td><td>مراجعة خطة التسويق</td></tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection
