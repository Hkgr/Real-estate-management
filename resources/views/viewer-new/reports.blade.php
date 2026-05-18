@extends('viewer-new.layouts.app')

@section('page_title', 'بوابة التقارير')
@section('topbar_title', 'بوابة التقارير')
@section('active', 'reports')
@section('back_url', route('viewer-new.hub'))
@section('back_label', 'العودة إلى البوابة')

@section('content')
    @include('viewer-new.partials.page-header', ['title' => 'بوابة التقارير', 'subtitle' => 'نظرة موحدة على أهم تقارير المحفظة'])

    <section class="vn-report-grid">
        @include('viewer-new.partials.report-card', ['title' => 'تقرير العقارات', 'description' => 'عرض حالة العقارات ومؤشرات الأداء.', 'href' => '#reports-table'])
        @include('viewer-new.partials.report-card', ['title' => 'تقرير المالك', 'description' => 'ملخص بيانات المالكين والعقود.', 'href' => '#reports-table'])
        @include('viewer-new.partials.report-card', ['title' => 'تقرير الإشارات', 'description' => 'متابعة التنبيهات والإشارات التشغيلية.', 'href' => '#reports-table'])
        @include('viewer-new.partials.report-card', ['title' => 'تقرير الملحقات', 'description' => 'مراجعة الملحقات والوثائق المرتبطة.', 'href' => '#reports-table'])
    </section>

    @include('viewer-new.partials.report-table')
@endsection
