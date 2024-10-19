@extends('admin.layouts.master')
@section('title')
Manage Benificiary
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        {{-- @slot('pagetitle') @endslot --}}
        @slot('title') @endslot
    @endcomponent
    @livewire('admin.setup-tool.benificiary-component')
@endsection