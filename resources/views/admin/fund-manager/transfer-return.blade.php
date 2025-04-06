@extends('admin.layouts.master')
{{-- @include('styles.transfer_return') --}}
@section('css')
<style>
    .avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
    }

    .avatar-sm {
        width: 32px;
        height: 32px;
    }

    .avatar-md {
        width: 48px;
        height: 48px;
    }

    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .table> :not(caption)>*>* {
        padding: 1rem 1rem;
    }

    hr {
        border: 1px solid rgba(0, 0, 0, 0.541);
    }

    .stat-card:hover {
        scale: 1.05;
        transition: 0.2s ease-in-out;
    }
</style>
@endsection

@section('title')
Transfer-Return
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')Transfer-Return @endslot
    @endcomponent
    @livewire('admin.fund.transfer-return')
@endsection
