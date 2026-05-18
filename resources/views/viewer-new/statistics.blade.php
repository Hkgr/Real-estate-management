@extends('viewer-new.layouts.app')

@section('page_title', 'بوابة الإحصاءات')
@section('topbar_title', 'بوابة الإحصاءات')
@section('active', 'statistics')
@section('back_url', route('viewer-new.hub'))
@section('back_label', 'العودة إلى البوابة')

@section('content')
    @include('viewer-new.partials.page-header', [
        'title' => 'بوابة الإحصاءات',
        'subtitle' => 'مدخل موحد لمتابعة المؤشرات العامة والمالية والإدارية',
    ])

    <section class="vn-report-grid">
        @include('viewer-new.partials.report-card', ['title' => 'إحصاءات عامة', 'description' => 'نظرة شاملة على المحفظة العقارية ومؤشرات النمو.', 'href' => '#general-statistics'])
        @include('viewer-new.partials.report-card', ['title' => 'إحصاءات مالية', 'description' => 'مؤشرات القيم، المدفوعات، والأرصدة التقديرية.', 'href' => '#financial-statistics'])
        @include('viewer-new.partials.report-card', ['title' => 'إحصاءات إدارية', 'description' => 'متابعة الإدخالات والتحديثات وحالة البيانات.', 'href' => '#administrative-statistics'])
        @include('viewer-new.partials.report-card', ['title' => 'مولد الإحصاءات', 'description' => 'إعداد تقارير ومخططات مخصصة لاحقاً.', 'href' => '#statistics-generator'])
    </section>

    <section class="vn-report-metrics" aria-label="نظرة سريعة على المؤشرات">
        <article class="vn-metric-card">
            <span>إجمالي العقارات</span>
            <strong>1,250</strong>
        </article>
        <article class="vn-metric-card">
            <span>إجمالي المالكين</span>
            <strong>420</strong>
        </article>
        <article class="vn-metric-card">
            <span>إجمالي الإشارات</span>
            <strong>87</strong>
        </article>
        <article class="vn-metric-card">
            <span>إجمالي الملفات</span>
            <strong>3,980</strong>
        </article>
    </section>

    <p class="vn-static-note">هذه البوابة تمهيدية، وسيتم ربط المؤشرات بالبيانات الحقيقية في مراحل لاحقة.</p>
@endsection
