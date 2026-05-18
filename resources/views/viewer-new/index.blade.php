@extends('viewer-new.layout')

@section('page_title', 'بوابة المستعرض')

@section('content')
<div class="viewer-hub" dir="rtl" data-reports-url="{{ route('viewer-new.reports.index') }}" data-hub-url="{{ route('viewer-new.index') }}">
    @php($active = 'index')
    @include('viewer.components.hub.background')
    @include('viewer.components.hub.main-cards')
</div>
@endsection
