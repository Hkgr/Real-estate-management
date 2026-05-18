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

    <section id="general-statistics" class="vn-report-detail">
        <h3 class="vn-section-title">المؤشرات الرئيسية</h3>
        @include('viewer-new.partials.report-metrics', ['items' => $primaryMetrics ?? []])
    </section>

    <section id="financial-statistics" class="vn-report-detail">
        <h3 class="vn-section-title">مؤشرات إضافية</h3>
        @include('viewer-new.partials.report-metrics', ['items' => $secondaryMetrics ?? []])
    </section>

    <section id="administrative-statistics" class="vn-report-detail">
        <h3 class="vn-section-title">مؤشرات صحة البيانات</h3>
        @include('viewer-new.partials.report-metrics', ['items' => $dataHealthMetrics ?? []])
    </section>

    <p class="vn-static-note">تم توليد هذه البيانات في: {{ $generatedAt ?? '—' }}. هذه البوابة تمهيدية، وسيتم ربط صفحات الإحصاءات التفصيلية في مراحل لاحقة.</p>
@endsection
