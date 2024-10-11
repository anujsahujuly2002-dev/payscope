@extends('admin.layouts.master')
@section('title')
Recipient Listing
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')Recipient Listing @endslot
    @endcomponent
    @livewire('admin.domestic-money-transfer.recipient-component')
@endsection

