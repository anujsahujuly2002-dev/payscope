@extends('admin.layouts.master')
@push('title')
    Manage Bank
@endpush
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @livewire('admin.setup-tool.bank-component')
    </div>
    <!-- Content wrapper -->
@endsection