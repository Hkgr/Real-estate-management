@extends('viewer-new.layouts.app')

@section('page_title', 'مولد الإحصاءات')
@section('topbar_title', 'مولد الإحصاءات')
@section('active', 'statistics')
@section('back_url', route('viewer-new.statistics'))
@section('back_label', 'العودة إلى بوابة الإحصاءات')

@section('content')
    @include('viewer-new.partials.page-header', [
        'title' => 'مولد الإحصاءات',
        'subtitle' => 'تهيئة مستقبلية لإنتاج تقارير إحصائية مخصصة.',
    ])

    <section class="vn-table-card vn-stat-summary">
        <h3 class="vn-section-title">إعداد التقرير</h3>
        <p>واجهة تجريبية لتهيئة معايير توليد الإحصاءات دون أي معالجة فعلية في هذه المرحلة.</p>
        <div class="vn-generator-grid">
            <article class="vn-placeholder-block">
                <h4>نوع التقرير</h4>
                <div class="vn-generator-control" aria-disabled="true">اختيار نوع التقرير (تجريبي)</div>
            </article>
            <article class="vn-placeholder-block">
                <h4>المجال</h4>
                <div class="vn-generator-control" aria-disabled="true">اختيار نطاق البيانات (تجريبي)</div>
            </article>
            <article class="vn-placeholder-block">
                <h4>الفترة</h4>
                <div class="vn-generator-control" aria-disabled="true">تحديد الفترة الزمنية (تجريبي)</div>
            </article>
        </div>
        <button class="vn-generator-button" type="button" disabled>تجهيز لاحقاً</button>
        <p class="vn-static-note">سيتم تفعيل مولد الإحصاءات في مرحلة لاحقة.</p>
    </section>
@endsection
