@extends('admin.layouts.master')
@section('title')
Api Partner List
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')Manage Api Partner @endslot
    @endcomponent
    @livewire('admin.member.api-partner-component')
@endsection

