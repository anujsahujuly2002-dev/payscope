@extends('admin.layouts.master')
@section('title')
Retailer List
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')Manage Retailer @endslot
    @endcomponent
    @livewire('admin.member.retailer-component')
@endsection

