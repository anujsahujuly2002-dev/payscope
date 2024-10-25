@extends('admin.layouts.master')
@section('title') Dashboard @endsection
@section('content')
@component('admin.common-components.breadcrumb')
@slot('pagetitle') {{env('APP_NAME')}} @endslot
@slot('title') Dashboard @endslot
@endcomponent
    @livewire('admin.dashboard-component')
@endsection
@section('script')
<!-- apexcharts -->
<script src="{{asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<script src="{{asset('/assets/js/pages/dashboard.init.js') }}"></script>
@endsection
