@extends('admin.layouts.master')
@section('title')
Transaction History
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')Transaction History @endslot
    @endcomponent
    @livewire('admin.fund.transaction-history-component')
@endsection
