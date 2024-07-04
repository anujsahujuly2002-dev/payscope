@extends('admin.layouts.master')
@section('title')
Operator Manager
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')Operator Manager @endslot
    @endcomponent
    @livewire('admin.setup-tool.operater-manager-component')
@endsection

