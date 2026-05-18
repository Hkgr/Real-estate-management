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
            @forelse ($overviewMetrics as $metric)
                <article class="vn-metric-card">
                    <span>{{ $metric['label'] }}</span>
                    <strong>{{ $metric['value'] }}</strong>
                </article>
            @empty
                <div class="vn-empty-state vn-empty-block">
                    <h4>لا توجد مؤشرات عامة</h4>
                    <p>تعذر تحميل الإحصاءات العامة حالياً.</p>
                </div>
            @endforelse
        </div>
    </section>

    <section class="vn-report-detail">
        <h3 class="vn-section-title">توزيع العقارات</h3>
        <div class="vn-stat-distribution-grid">
            @forelse($distributionSections as $section)
                <article class="vn-table-card vn-distribution-card">
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
                        <div class="vn-table-responsive vn-mini-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>التصنيف</th>
                                        <th>العدد</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($section['rows'] as $row)
                                        <tr>
                                            <td>{{ $row['label'] }}</td>
                                            <td>{{ $row['total'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </article>
            @empty
                <div class="vn-empty-state vn-empty-block">
                    <h4>لا توجد بيانات توزيع</h4>
                    <p>جدول العقارات غير متاح أو لا يحتوي بيانات حالياً.</p>
                </div>
            @endforelse
        </div>
    </section>

    <section class="vn-report-detail">
        <h3 class="vn-section-title">جودة البيانات</h3>
        <div class="vn-report-metrics">
            @forelse ($completenessMetrics as $metric)
                <article class="vn-metric-card">
                    <span>{{ $metric['label'] }}</span>
                    <strong>{{ $metric['value'] }}</strong>
                </article>
            @empty
                <div class="vn-empty-state vn-empty-block">
                    <p>لا توجد مؤشرات جودة بيانات حالياً.</p>
                </div>
            @endforelse
        </div>
    </section>

    <section class="vn-report-detail">
        <h3 class="vn-section-title">آخر التحديثات</h3>
        @if (count($recentProperties) > 0)
            <div class="vn-table-card">
                <div class="vn-table-responsive vn-recent-table">
                    <table>
                        <thead>
                            <tr>
                                <th>رقم السجل</th>
                                <th>المحافظة</th>
                                <th>المنطقة</th>
                                <th>الحالة</th>
                                <th>آخر تحديث</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentProperties as $property)
                                <tr>
                                    <td>{{ $property['card_record_number'] }}</td>
                                    <td>{{ $property['card_governorate'] }}</td>
                                    <td>{{ $property['card_region_name'] }}</td>
                                    <td>{{ $property['card_status'] }}</td>
                                    <td>{{ $property['updated_at'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="vn-empty-state vn-empty-block">
                <h4>لا توجد تحديثات حديثة</h4>
                <p>تعذر الوصول إلى عمود التحديث أو لا توجد سجلات حالياً.</p>
            </div>
        @endif
    </section>

    <p class="vn-static-note">تم توليد هذه البيانات في: {{ $generatedAt ?? '—' }}.</p>
@endsection
