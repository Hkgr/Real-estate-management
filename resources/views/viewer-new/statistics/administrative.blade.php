@extends('viewer-new.layouts.app')

@section('page_title', 'إحصاءات إدارية')
@section('topbar_title', 'إحصاءات إدارية')
@section('active', 'statistics')
@section('back_url', route('viewer-new.statistics'))
@section('back_label', 'العودة إلى بوابة الإحصاءات')

@section('content')
    @include('viewer-new.partials.page-header', [
        'title' => 'إحصاءات إدارية',
        'subtitle' => 'مؤشرات إدارية أولية لحالة السجلات وجودة البيانات.',
    ])

    <section class="vn-report-detail">
        <h3 class="vn-section-title">نظرة عامة</h3>
        <div class="vn-report-metrics">
            <article class="vn-metric-card vn-stat-placeholder"><span>سجلات محدثة</span><strong>—</strong></article>
            <article class="vn-metric-card vn-stat-placeholder"><span>سجلات ناقصة</span><strong>—</strong></article>
            <article class="vn-metric-card vn-stat-placeholder"><span>إشارات تحتاج متابعة</span><strong>—</strong></article>
            <article class="vn-metric-card vn-stat-placeholder"><span>ملفات تحتاج مراجعة</span><strong>—</strong></article>
        </div>
    </section>

    <section class="vn-table-card vn-stat-summary">
        <h3 class="vn-section-title">ملخص مرحلي</h3>
        <p>ستعرض هذه الصفحة لاحقاً مؤشرات الأداء الإدارية وصحة البيانات لمتابعة الاكتمال وجودة السجلات.</p>
    </section>

    <section class="vn-report-grid vn-stat-detail-grid">
        <article class="vn-table-card vn-placeholder-block"><h4>جودة البيانات</h4><p>قسم تجريبي ثابت سيتم ربطه ببيانات فعلية في مرحلة لاحقة.</p></article>
        <article class="vn-table-card vn-placeholder-block"><h4>آخر الإدخالات</h4><p>قسم تجريبي ثابت سيتم ربطه ببيانات فعلية في مرحلة لاحقة.</p></article>
        <article class="vn-table-card vn-placeholder-block"><h4>آخر التعديلات</h4><p>قسم تجريبي ثابت سيتم ربطه ببيانات فعلية في مرحلة لاحقة.</p></article>
    </section>
@endsection
