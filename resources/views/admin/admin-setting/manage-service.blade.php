@extends('admin.layouts.master')
@section('title')
Manage Service
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
    @slot('pagetitle') List @endslot
    @slot('title')Service Manage @endslot
    @endcomponent
    @livewire('admin.admin-setting.service-manage')
@endsection
