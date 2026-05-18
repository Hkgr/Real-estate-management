@extends('viewer-new.layouts.app')

@section('page_title', 'إحصاءات مالية')
@section('topbar_title', 'إحصاءات مالية')
@section('active', 'statistics')
@section('back_url', route('viewer-new.statistics'))
@section('back_label', 'العودة إلى بوابة الإحصاءات')

@section('content')
    @include('viewer-new.partials.page-header', [
        'title' => 'إحصاءات مالية',
        'subtitle' => 'مؤشرات مالية تمهيدية للقيم والأرصدة.',
    ])

    <section class="vn-report-detail">
        <h3 class="vn-section-title">نظرة عامة</h3>
        <div class="vn-report-metrics">
            <article class="vn-metric-card vn-stat-placeholder"><span>إجمالي قيمة العقارات</span><strong>—</strong></article>
            <article class="vn-metric-card vn-stat-placeholder"><span>القيمة المملوكة</span><strong>—</strong></article>
            <article class="vn-metric-card vn-stat-placeholder"><span>متوسط قيمة العقار</span><strong>—</strong></article>
            <article class="vn-metric-card vn-stat-placeholder"><span>أعلى قيمة مسجلة</span><strong>—</strong></article>
        </div>
    </section>

    <section class="vn-table-card vn-stat-summary">
        <h3 class="vn-section-title">ملخص مرحلي</h3>
        <p>ستعرض هذه الصفحة لاحقاً مؤشرات الأداء المالية الرئيسية بما يشمل القيم الإجمالية والمتوسطات والمقارنات.</p>
    </section>

    <section class="vn-report-grid vn-stat-detail-grid">
        <article class="vn-table-card vn-placeholder-block"><h4>القيم التقديرية</h4><p>قسم تجريبي ثابت سيتم ربطه ببيانات فعلية في مرحلة لاحقة.</p></article>
        <article class="vn-table-card vn-placeholder-block"><h4>الأرصدة</h4><p>قسم تجريبي ثابت سيتم ربطه ببيانات فعلية في مرحلة لاحقة.</p></article>
        <article class="vn-table-card vn-placeholder-block"><h4>المقارنات المالية</h4><p>قسم تجريبي ثابت سيتم ربطه ببيانات فعلية في مرحلة لاحقة.</p></article>
    </section>
@endsection
