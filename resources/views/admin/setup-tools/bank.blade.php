@extends('admin.layouts.master')
@section('title')
Manage Bank
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')Manage Bank @endslot
    @endcomponent
    @livewire('admin.setup-tool.bank-component')
@endsection

