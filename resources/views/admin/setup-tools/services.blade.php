@extends('admin.layouts.master')
@section('title')
Services List
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')Services @endslot
    @endcomponent
    @livewire('admin.setup-tool.service-component')
@endsection

