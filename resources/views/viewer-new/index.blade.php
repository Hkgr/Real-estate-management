@extends('viewer-new.layout')

@section('page_title', 'بوابة المستعرض')
@section('active_navbar_key', 'hub')

@section('content')
<div class="viewer-hub" dir="rtl" data-reports-url="{{ route('viewer-new.reports') }}" data-hub-url="{{ route('viewer-new.hub') }}">
    @include('viewer.components.hub.background')
    @include('viewer.components.hub.main-cards')
</div>
@endsection
