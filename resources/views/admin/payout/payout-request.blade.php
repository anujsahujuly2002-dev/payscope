@extends('admin.layouts.master')
@push('title')
    Payout Pending Request
@endpush
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @livewire('admin.payout.payout-request')
    </div>
    <!-- / Content-->

@endsection
