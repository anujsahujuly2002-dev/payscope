@extends('admin.layouts.master')
@section('title')
AEPS Service
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
    {{-- @slot('pagetitle') List @endslot --}}
    @slot('title')AEPS @endslot
    @endcomponent
    @livewire('admin.a-e-p-s.aeps-system')
@endsection
