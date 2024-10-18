@extends('admin.layouts.master')
@section('title')
QR Collection
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')QR Collection @endslot
    @endcomponent
    @livewire('admin.fund.q-r-collection-component')
@endsection
