@extends('viewer-new.layouts.app')

@section('page_title', 'بوابة المستعرض')
@section('topbar_title', 'البوابة')
@section('active', 'hub')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'الذهاب إلى التقارير')

@section('content')
    @include('viewer-new.partials.page-header', ['title' => 'لوحة الوصول السريع', 'subtitle' => 'اختر القسم المطلوب من البوابة الجديدة'])

    <section class="vn-report-grid">
        @include('viewer-new.partials.report-card', [
            'title' => 'بوابة التقارير',
            'description' => 'الانتقال إلى تقارير العقارات والمالكين والإشارات والملحقات.',
            'href' => route('viewer-new.reports'),
        ])
    </section>
@endsection
