@extends('admin.layouts.master')
@push('title')
    Manual Request
@endpush
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @livewire('admin.fund.manual-request')
    </div>
    <!-- / Content-->

@endsection