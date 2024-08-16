@extends('admin.layouts.master')
@section('title')
Recharge
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
    {{-- @slot('pagetitle') List @endslot --}}
    @slot('title')Recharge @endslot
    @endcomponent
    @livewire('admin.recharge-and-bill-payment.mobile-recharge-component')
@endsection
