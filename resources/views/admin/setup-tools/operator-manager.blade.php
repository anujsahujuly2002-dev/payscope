@extends('admin.layouts.master')
@section('title')
Charge Slabs
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')Charge Slabs @endslot
    @endcomponent
    @livewire('admin.setup-tool.operater-manager-component')
@endsection

