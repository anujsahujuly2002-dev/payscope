@extends('admin.layouts.master')
@section('title')
Manager Setting
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
    @slot('pagetitle') Setting @endslot
    @slot('title') Manager Setting @endslot
    @endcomponent
    @livewire('admin.admin-setting.setting-component')
@endsection