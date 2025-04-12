@extends('admin.layouts.master')
@section('title')
QR Request
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')QR Request @endslot
    @endcomponent
    @livewire('admin.fund.q-r-request-component')
@endsection