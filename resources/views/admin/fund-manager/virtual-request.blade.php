@extends('admin.layouts.master')
@section('title')
Virtual Request
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')Virtual Request @endslot
    @endcomponent
    @livewire('admin.fund.virtual-request-component')
@endsection

