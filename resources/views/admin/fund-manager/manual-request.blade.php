@extends('admin.layouts.master')
@section('title')
Manual Request
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')Manual Request @endslot
    @endcomponent
    @livewire('admin.fund.manual-request')
@endsection

