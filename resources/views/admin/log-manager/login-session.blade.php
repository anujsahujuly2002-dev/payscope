@extends('admin.layouts.master')
@section('title')
Login Session
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
    @slot('pagetitle') List @endslot
    @slot('title')Login Session @endslot
    @endcomponent
    @livewire('admin.log-manager.login-session-component')
@endsection