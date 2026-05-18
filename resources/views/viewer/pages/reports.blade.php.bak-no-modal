@extends('viewer.layouts.app')

@section('title', 'Viewer New Reports')

@section('content')
    <div class="viewer-reports" id="viewerReportsPage" data-hub-url="{{ route('viewer-new.hub') }}" data-reports-url="{{ route('viewer-new.reports') }}">
        <div class="app-wrapper">
            @include('viewer.components.reports.sidebar')
            @include('viewer.components.reports.sidebar-overlay')

            <div class="main-content reports-main-wrap">
                @include('viewer.components.reports.topbar')
                @include('viewer.components.reports.mobile-nav')

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
