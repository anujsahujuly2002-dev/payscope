@extends('admin.layouts.master')
@push('title')
    DashBoard
@endpush
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @livewire('admin.dashboard-component')
    </div>
    <!-- / Content-->

@endsection