@extends('admin.layouts.master')
@section('title')
Api List
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
    @slot('pagetitle') List @endslot
    @slot('title')Api List @endslot
    @endcomponent
    @livewire('admin.admin-setting.api-list-component')
@endsection