@extends('admin.layouts.master')
@section('title')
Profile
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        {{-- @slot('pagetitle') Profile @endslot --}}
        @slot('title')Profile @endslot
    @endcomponent
    @livewire('admin.member.profile-componet')
@endsection