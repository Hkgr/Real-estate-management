@extends('viewer-new.layouts.app')

@section('page_title', 'إحصاءات عامة')
@section('topbar_title', 'إحصاءات عامة')
@section('active', 'statistics')
@section('back_url', route('viewer-new.statistics'))
@section('back_label', 'العودة إلى بوابة الإحصاءات')

@section('content')
    @include('viewer-new.partials.page-header', [
        'title' => 'إحصاءات عامة',
        'subtitle' => 'مؤشرات عامة على مستوى المحفظة العقارية.',
    ])

    <section class="vn-report-detail">
        <h3 class="vn-section-title">نظرة عامة</h3>
        <div class="vn-report-metrics">
            <article class="vn-metric-card vn-stat-placeholder"><span>إجمالي العقارات</span><strong>—</strong></article>
            <article class="vn-metric-card vn-stat-placeholder"><span>إجمالي المالكين</span><strong>—</strong></article>
            <article class="vn-metric-card vn-stat-placeholder"><span>إجمالي الإشارات</span><strong>—</strong></article>
            <article class="vn-metric-card vn-stat-placeholder"><span>إجمالي الملفات</span><strong>—</strong></article>
        </div>
    </section>

    <section class="vn-table-card vn-stat-summary">
        <h3 class="vn-section-title">ملخص مرحلي</h3>
        <p>ستعرض هذه الصفحة لاحقاً مؤشرات الأداء الرئيسية العامة على مستوى المحفظة بالكامل مع تحديثات دورية.</p>
    </section>

    <section class="vn-report-grid vn-stat-detail-grid">
        <article class="vn-table-card vn-placeholder-block"><h4>توزيع العقارات حسب المنطقة</h4><p>قسم تجريبي ثابت سيتم ربطه ببيانات فعلية في مرحلة لاحقة.</p></article>
        <article class="vn-table-card vn-placeholder-block"><h4>توزيع الحالات</h4><p>قسم تجريبي ثابت سيتم ربطه ببيانات فعلية في مرحلة لاحقة.</p></article>
        <article class="vn-table-card vn-placeholder-block"><h4>آخر تحديث عام</h4><p>قسم تجريبي ثابت سيتم ربطه ببيانات فعلية في مرحلة لاحقة.</p></article>
    </section>
@endsection
