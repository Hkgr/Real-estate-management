@extends('viewer-new.layouts.app')

@section('page_title', 'بوابة المستعرض')
@section('topbar_title', 'البوابة')
@section('active', 'hub')
@section('back_url', route('viewer-new.reports'))
@section('back_label', 'الذهاب إلى التقارير')

@section('content')
    {{-- Temporary compatibility load for the existing rich hub design. This is intentionally used only by viewer-new/index.blade.php and should be migrated to resources/css/viewer-new and resources/js/viewer-new in a later stage. --}}
    @vite(['resources/css/viewer/hub.css', 'resources/js/viewer/hub.js'])

    <div class="viewer-hub" dir="rtl" data-reports-url="{{ route('viewer-new.reports') }}" data-hub-url="{{ route('viewer-new.hub') }}">
        @include('viewer.components.hub.background')
        @include('viewer.components.hub.main-cards')
    </div>
@endsection
