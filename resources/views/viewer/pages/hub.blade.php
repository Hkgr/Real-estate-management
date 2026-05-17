@extends('viewer.layouts.app')

@section('title', 'Viewer New Hub')

@push('viewer-vite')
    @vite(['resources/css/viewer/hub.css', 'resources/js/viewer/hub.js'])
@endpush

@section('content')
    @include('viewer.components.hub.background')
    @include('viewer.components.hub.topbar')

    <main class="main">
        <div class="main-left">
            @include('viewer.components.hub.main-cards')
            @include('viewer.components.hub.quick-stats')
        </div>

        <div class="main-right">
            @include('viewer.components.hub.quick-settings')
        </div>
    </main>
@endsection
