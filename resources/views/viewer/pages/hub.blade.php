@extends('viewer.layouts.app')

@section('title', 'Viewer New Hub')

@section('content')
<div class="viewer-hub" dir="rtl">
    @include('viewer.components.hub.background')
    @include('viewer.components.hub.topbar')
    @include('viewer.components.hub.hero')

    <main class="main">
        <div class="main-left">
            @include('viewer.components.hub.main-cards')
            @include('viewer.components.hub.quick-stats')
        </div>

        <div class="main-right">
            @include('viewer.components.hub.quick-settings')
        </div>
    </main>
</div>
@endsection
