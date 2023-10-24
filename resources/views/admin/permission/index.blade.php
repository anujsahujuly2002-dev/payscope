@extends('admin.layouts.master')
@push('title')
    Manage Permission
@endpush
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @livewire('admin.permission.permission-component')
    </div>
    <!-- Content wrapper -->
@endsection