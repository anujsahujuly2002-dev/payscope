@extends('admin.layouts.master')
@section('title')
Razorpay Api Logs
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
    @slot('pagetitle') List @endslot
    @slot('title') Razorpay Api Logs @endslot
    @endcomponent
    @livewire('admin.log-manager.razorpay-api-logs')
@endsection
