@extends('admin.layouts.master')
@push('title')
    Api Partner List
@endpush
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @livewire('admin.member.api-partner-component')
    </div>
    <!-- Content wrapper -->
@endsection