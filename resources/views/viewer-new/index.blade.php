@extends('viewer-new.layout')

@section('page_title', 'بوابة المستعرض')
@section('active', 'index')

@section('topbar_title')
    بوابة <span>الإحصاءات</span>
@endsection

@section('content')
<div class="viewer-hub" dir="rtl" data-reports-url="{{ route('viewer-new.reports.index') }}" data-hub-url="{{ route('viewer-new.index') }}">
    @include('viewer.components.hub.background')
    @include('viewer.components.hub.main-cards')
</div>
@endsection
