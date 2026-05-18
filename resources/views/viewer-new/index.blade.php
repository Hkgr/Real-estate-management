@extends('viewer-new.layout')

@section('page_title', 'بوابة الإحصاءات')
@section('active', 'index')

@section('topbar_title')
    بوابة <span>الإحصاءات</span>
@endsection

@section('content')
<section class="page active" id="page-dashboard">
    <div class="page-header page-header-dashboard">
        <div>
            <div class="page-eyebrow">لوحة العرض</div>
            <h1 class="page-title">بوابة <em>الإحصاءات</em></h1>
            <p class="page-subtitle">
                استعراض تحليلي شامل لمحفظة العقارات حسب مؤشرات مالية، عقارية، قانونية وإدارية.
            </p>
        </div>
    </div>

    <div class="nav-hub-grid">
        <div class="nav-hub-card">
            <span class="nav-hub-chip">Reports</span>
            <div class="nav-hub-card-title">بوابة التقارير</div>
            <div class="nav-hub-card-desc">الوصول إلى تقارير المحفظة ولوحات التحليل التفصيلية.</div>
            <a class="toolbar-main-btn" href="{{ route('viewer-new.reports.index') }}">فتح البوابة</a>
        </div>

        <div class="nav-hub-card">
            <span class="nav-hub-chip">Properties</span>
            <div class="nav-hub-card-title">العقارات</div>
            <div class="nav-hub-card-desc">استعراض بيانات العقارات ومتابعة مؤشرات الأداء الخاصة بها.</div>
            <a class="toolbar-main-btn" href="{{ route('viewer-new.properties.index') }}">عرض العقارات</a>
        </div>

        <div class="nav-hub-card">
            <span class="nav-hub-chip">Owners</span>
            <div class="nav-hub-card-title">الملاك</div>
            <div class="nav-hub-card-desc">متابعة سجلات الملاك والروابط المرتبطة بالمحفظة العقارية.</div>
            <a class="toolbar-main-btn" href="{{ route('viewer-new.owners.index') }}">عرض الملاك</a>
        </div>

        <div class="nav-hub-card">
            <span class="nav-hub-chip">Signals</span>
            <div class="nav-hub-card-title">الإشارات</div>
            <div class="nav-hub-card-desc">الوصول إلى الإشارات والتنبيهات المرتبطة بالعقارات والعقود.</div>
            <a class="toolbar-main-btn" href="{{ route('viewer-new.signals.index') }}">عرض الإشارات</a>
        </div>
    </div>
</section>
@endsection
