@extends('admin.layouts.master')
@section('title')
DMT
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')DMT @endslot
    @endcomponent
    @livewire('admin.member.d-m-t-component')
@endsection

