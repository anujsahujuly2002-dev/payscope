@extends('admin.layouts.master')
@push('title')
    Manage Role
@endpush
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @livewire('admin.role.role-component')
    </div>
    <!-- Content wrapper -->
@endsection