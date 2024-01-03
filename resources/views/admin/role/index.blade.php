@extends('admin.layouts.master')
@section('title')
Manage Role
@endsection
@section('css')
    <!-- DataTables -->
    {{-- <link href="{{asset('/assets/libs/rwd-table/rwd-table.min.css') }}" rel="stylesheet" type="text/css" /> --}}
@endsection

@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title') Manage Role @endslot
    @endcomponent
    @livewire('admin.role.role-component')
@endsection
@section('script')
    {{-- <script src="{{asset('/assets/libs/rwd-table/rwd-table.min.js') }}"></script> --}}
    {{-- <script src="{{asset('/assets/js/pages/table-responsive.init.js') }}"></script> --}}
@endsection
