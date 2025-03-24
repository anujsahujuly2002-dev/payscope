@extends('admin.layouts.master')
@section('title')
Disputes List
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')Disputes @endslot
    @endcomponent
    @livewire('admin.dispute-component')
@endsection

