@extends('admin.layouts.master')
@section('title')
Scheme Manager
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title') Scheme Manager @endslot
    @endcomponent
    @livewire('admin.resources.scheme-manager-component')
@endsection

