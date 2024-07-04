@extends('admin.layouts.master')
@section('title')
Callback & Token
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
    @slot('pagetitle') List @endslot
    @slot('title')CallBack & Token @endslot
    @endcomponent
    @livewire('admin.api-setting.setting')
@endsection