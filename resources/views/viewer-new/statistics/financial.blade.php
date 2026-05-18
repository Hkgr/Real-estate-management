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
        <h3 class="vn-section-title">نظرة مالية عامة</h3>
        <div class="vn-report-metrics">
            @forelse ($overviewMetrics as $metric)
                <article class="vn-metric-card">
                    <span>{{ $metric['label'] }}</span>
                    <strong>{{ $metric['value'] }}</strong>
                </article>
            @empty
                <div class="vn-empty-state vn-empty-block">
                    <h4>لا توجد مؤشرات مالية</h4>
                    <p>تعذر تحميل المؤشرات المالية حالياً.</p>
                </div>
            @endforelse
        </div>
    </section>

    <section class="vn-report-detail">
        <h3 class="vn-section-title">توزيع القيم</h3>
        <div class="vn-stat-distribution-grid vn-financial-distribution-grid">
            @forelse($distributionSections as $section)
                <article class="vn-table-card vn-distribution-card vn-financial-distribution-card">
                    <h4>{{ $section['title'] }}</h4>

                    @if (! $section['available'])
                        <div class="vn-empty-state vn-empty-block">
                            <p>غير متوفر</p>
                        </div>
                    @elseif (filled($section['message']))
                        <div class="vn-empty-state vn-empty-block">
                            <p>{{ $section['message'] }}</p>
                        </div>
                    @else
                        <div class="vn-table-responsive vn-mini-table vn-financial-mini-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>التصنيف</th>
                                        <th>إجمالي القيمة (USD)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($section['rows'] as $row)
                                        <tr>
                                            <td>{{ $row['label'] }}</td>
                                            <td>{{ $row['value'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </article>
            @empty
                <div class="vn-empty-state vn-empty-block vn-financial-empty-block">
                    <h4>لا توجد بيانات توزيع</h4>
                    <p>جدول العقارات غير متاح أو لا يحتوي بيانات مالية حالياً.</p>
                </div>
            @endforelse
        </div>
    </section>

    <section class="vn-report-detail">
        <h3 class="vn-section-title">جودة البيانات المالية</h3>
        <div class="vn-report-metrics">
            @forelse ($financialHealthMetrics as $metric)
                <article class="vn-metric-card">
                    <span>{{ $metric['label'] }}</span>
                    <strong>{{ $metric['value'] }}</strong>
                </article>
            @empty
                <div class="vn-empty-state vn-empty-block vn-financial-empty-block">
                    <p>لا توجد مؤشرات جودة بيانات مالية حالياً.</p>
                </div>
            @endforelse
        </div>
    </section>

    <section class="vn-report-detail">
        <h3 class="vn-section-title">أعلى العقارات قيمة</h3>
        @if (count($topProperties) > 0)
            <div class="vn-table-card">
                <div class="vn-table-responsive vn-financial-top-table">
                    <table>
                        <thead>
                            <tr>
                                <th>رقم السجل</th>
                                <th>المحافظة</th>
                                <th>المنطقة</th>
                                <th>الحالة</th>
                                <th>القيمة الإجمالية (USD)</th>
                                <th>القيمة المملوكة (USD)</th>
                                <th>آخر تحديث</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProperties as $property)
                                <tr>
                                    <td>{{ $property['card_record_number'] }}</td>
                                    <td>{{ $property['card_governorate'] }}</td>
                                    <td>{{ $property['card_region_name'] }}</td>
                                    <td>{{ $property['card_status'] }}</td>
                                    <td>{{ $property['total_property_value_usd'] }}</td>
                                    <td>{{ $property['owned_property_value_usd'] }}</td>
                                    <td>{{ $property['updated_at'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="vn-empty-state vn-empty-block vn-financial-empty-block">
                <h4>لا توجد سجلات مالية متاحة</h4>
                <p>تعذر عرض أعلى العقارات قيمة حالياً.</p>
            </div>
        @endif
    </section>

    <p class="vn-static-note">تم توليد هذه البيانات في: {{ $generatedAt ?? '—' }}.</p>
@endsection
