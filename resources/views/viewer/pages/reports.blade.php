@extends('viewer.layouts.app')

@section('title', 'Viewer New Reports')

@push('viewer-vite')
    @vite(['resources/css/viewer/reports.css', 'resources/js/viewer/reports.js'])
@endpush

@section('content')
    <div class="viewer-reports" id="viewerReportsPage">
        <div class="reports-layout">
            @include('viewer.components.reports.sidebar')

            <div class="reports-main-wrap">
                @include('viewer.components.reports.topbar')

                <main class="reports-main" aria-label="صفحة التقارير">
                    @include('viewer.components.reports.filters')
                    @include('viewer.components.reports.stats-cards')
                    @include('viewer.components.reports.charts')
                    @include('viewer.components.reports.table')
                </main>
            </div>
        </div>

        @include('viewer.components.reports.quick-settings')
        @include('viewer.components.reports.modals')
    </div>
@endsection
