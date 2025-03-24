@extends('admin.layouts.master')
@section('title')
Payment Settelment
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        {{-- @slot('pagetitle') @endslot --}}
        @slot('title') @endslot
    @endcomponent
    @livewire('admin.settelment-component')
@endsection