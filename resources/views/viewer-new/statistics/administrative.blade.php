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
        <h3 class="vn-section-title">نظرة إدارية عامة</h3>
        <div class="vn-report-metrics">
            @forelse ($overviewMetrics as $metric)
                <article class="vn-metric-card vn-admin-metric-card">
                    <span>{{ $metric['label'] }}</span>
                    <strong>{{ $metric['value'] }}</strong>
                </article>
            @empty
                <div class="vn-empty-state vn-empty-block"><p>لا توجد مؤشرات متاحة حالياً.</p></div>
            @endforelse
        </div>
    </section>

    <section class="vn-report-detail">
        <h3 class="vn-section-title">جودة البيانات</h3>
        <div class="vn-report-metrics">
            @forelse ($dataQualityMetrics as $metric)
                <article class="vn-metric-card vn-admin-metric-card">
                    <span>{{ $metric['label'] }}</span>
                    <strong>{{ $metric['value'] }}</strong>
                </article>
            @empty
                <div class="vn-empty-state vn-empty-block"><p>لا توجد مؤشرات جودة بيانات حالياً.</p></div>
            @endforelse
        </div>
    </section>

    <section class="vn-report-detail">
        <h3 class="vn-section-title">عناصر تحتاج متابعة</h3>
        <div class="vn-report-metrics">
            @forelse ($followUpMetrics as $metric)
                <article class="vn-metric-card vn-admin-metric-card">
                    <span>{{ $metric['label'] }}</span>
                    <strong>{{ $metric['value'] }}</strong>
                </article>
            @empty
                <div class="vn-empty-state vn-empty-block"><p>لا توجد عناصر متابعة حالياً.</p></div>
            @endforelse
        </div>
    </section>

    <section class="vn-report-detail">
        <h3 class="vn-section-title">آخر النشاطات</h3>
        <div class="vn-admin-recent-grid">
            @foreach($recentSections as $section)
                <article class="vn-table-card vn-admin-recent-card">
                    <h4>{{ $section['title'] }}</h4>
                    @if (filled($section['message']))
                        <div class="vn-empty-state vn-empty-block vn-admin-empty"><p>{{ $section['message'] }}</p></div>
                    @else
                        <div class="vn-table-responsive vn-mini-table vn-admin-mini-table">
                            <table>
                                <thead>
                                    <tr>
                                        @foreach(array_keys($section['rows'][0]) as $header)
                                            <th>{{ $header }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($section['rows'] as $row)
                                        <tr>
                                            @foreach($row as $value)
                                                <td>{{ $value }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    </section>

    <p class="vn-static-note">تم توليد هذه البيانات في: {{ $generatedAt ?? '—' }}.</p>
@endsection
