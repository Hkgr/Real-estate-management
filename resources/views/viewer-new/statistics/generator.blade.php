@extends('viewer-new.layouts.app')

@section('page_title', 'مولد الإحصاءات')
@section('topbar_title', 'مولد الإحصاءات')
@section('active', 'statistics')
@section('back_url', route('viewer-new.statistics'))
@section('back_label', 'العودة إلى بوابة الإحصاءات')

@section('content')
    @include('viewer-new.partials.page-header', [
        'title' => 'مولد الإحصاءات',
        'subtitle' => 'توليد ملخصات إحصائية للقراءة فقط حسب النوع والنطاق والفترة.',
    ])

    <section class="vn-table-card vn-stat-summary">
        <h3 class="vn-section-title">إعداد الملخص</h3>
        <form method="GET" action="{{ route('viewer-new.statistics.generator') }}" class="vn-generator-form">
            <label>
                <span>نوع التقرير</span>
                <select name="report_type">
                    @foreach ($reportTypeOptions as $value => $label)
                        <option value="{{ $value }}" @selected(($filters['report_type'] ?? 'general') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <label>
                <span>النطاق</span>
                <select name="scope">
                    @foreach ($scopeOptions as $value => $label)
                        <option value="{{ $value }}" @selected(($filters['scope'] ?? 'all') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <label>
                <span>الفترة</span>
                <select name="period">
                    @foreach ($periodOptions as $value => $label)
                        <option value="{{ $value }}" @selected(($filters['period'] ?? 'all') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <div class="vn-generator-actions">
                <button type="submit">عرض الملخص</button>
                <a href="{{ route('viewer-new.statistics.generator') }}" class="vn-filter-reset">إعادة الضبط</a>
            </div>
        </form>

        @if (! $hasGenerated)
            <div class="vn-empty-state vn-generator-empty">
                <h4>ابدأ بتوليد ملخص جديد</h4>
                <p>اختر نوع التقرير والنطاق والفترة، ثم اضغط على «عرض الملخص» للحصول على قراءة إحصائية آمنة دون تعديل أي بيانات.</p>
            </div>
        @else
            @if (! empty($summaryMetrics))
                @include('viewer-new.partials.report-metrics', ['items' => $summaryMetrics])
            @endif

            @if (! empty($summarySections))
                <div class="vn-generator-sections">
                    @foreach ($summarySections as $section)
                        <article class="vn-table-card vn-generator-section">
                            <h4>{{ $section['title'] ?? 'ملخص' }}</h4>
                            @if (! empty($section['message']))
                                <p class="vn-static-note">{{ $section['message'] }}</p>
                            @elseif (! empty($section['rows']))
                                <div class="vn-table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                @foreach (array_keys($section['rows'][0]) as $head)
                                                    <th>{{ $head }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($section['rows'] as $row)
                                                <tr>
                                                    @foreach ($row as $value)
                                                        <td>{{ $value }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="vn-static-note">لا توجد بيانات لعرضها حالياً.</p>
                            @endif
                        </article>
                    @endforeach
                </div>
            @else
                <div class="vn-empty-state vn-generator-empty">
                    <h4>تم توليد الملخص</h4>
                    <p>لا توجد أقسام تفصيلية لهذا الاختيار، ويمكنك تغيير الفلاتر للحصول على عرض مختلف.</p>
                </div>
            @endif

            <p class="vn-static-note">تاريخ التوليد: {{ $generatedAt }}</p>
        @endif
    </section>
@endsection
