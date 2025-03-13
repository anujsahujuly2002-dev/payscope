@extends('admin.layouts.master')
@section('title')
Payment Collection
@endsection
@section('css')
    <style>
    .hover-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    .interactive-icon {
        transition: color 0.2s ease;
    }
    .interactive-icon:hover {
        color: #007bff;
    }
    .interactive-btn {
        transition: transform 0.2s ease, color 0.2s ease;
    }
    .interactive-btn:hover {
        transform: scale(1.1);
        color: #0056b3;
    }
 
    </style>
@endsection
@section('content')
    @component('admin.common-components.breadcrumb')
        @slot('pagetitle') List @endslot
        @slot('title')Payment Collection @endslot
    @endcomponent
    @livewire('admin.payment-collection.payment-collection-component')
@endsection