@extends('admin.layouts.master')
@section('title')
Manage Permisson
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title') Manage Permission @endslot
    @endcomponent
    @livewire('admin.permission.permission-component')
@endsection

