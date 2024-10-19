@extends('admin.layouts.master')
@section('title')
Api Logs
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
    @slot('pagetitle') List @endslot
    @slot('title') Api Logs @endslot
    @endcomponent
    @livewire('admin.log-manager.api-logs')
@endsection
