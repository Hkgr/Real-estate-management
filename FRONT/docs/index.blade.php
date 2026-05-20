@extends('layouts.dashboard')

@section('title', 'محفظة العقارات — إحصائيات')

@section('content')
@include('dashboard.ar.partials.quick-settings')

<div class="app-wrapper">
  @include('dashboard.ar.partials.sidebar')

  <div class="main-content">
    @include('dashboard.ar.partials.topbar')
    @include('dashboard.ar.partials.mobile-nav-strip')

    @include('dashboard.ar.partials.page-stats-home')
    @include('dashboard.ar.partials.page-stats-generator')
    @include('dashboard.ar.partials.page-reports-home')
    @include('dashboard.ar.partials.page-dashboard')
    @include('dashboard.ar.partials.page-properties')
    @include('dashboard.ar.partials.page-owners')
    @include('dashboard.ar.partials.page-consultations')
    @include('dashboard.ar.partials.page-attachments')
    @include('dashboard.ar.partials.page-activity')
  </div>
</div>

@include('dashboard.ar.partials.mobile-bottom-nav')
@endsection

@push('scripts')
<script src="{{ asset('js/dashboard-ar.js') }}"></script>
<script src="{{ asset('js/mobile-nav-ar.js') }}"></script>
@endpush