@extends('admin.layouts.master')
@section('title')
Payout  Request
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')Payout  Request @endslot
    @endcomponent
    @livewire('admin.payout.payout-request')
@endsection

