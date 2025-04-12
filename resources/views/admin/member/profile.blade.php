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
@section('css')

<style>
    /* OTP Verification Styles */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-dialog {
        margin-top: 10vh;
    }

    #otpVerificationModal input.form-control {
        letter-spacing: 8px;
        font-size: 24px;
        padding: 10px;
        text-align: center;
    }

    #otpVerificationModal .btn-primary {
        padding: 10px 30px;
    }

    .timer-container {
        margin-top: 10px;
    }

    .timer-container .badge {
        font-size: 14px;
        padding: 8px 12px;
    }

    /* Mobile responsiveness */
    @media (max-width: 576px) {
        #otpVerificationModal input.form-control {
            letter-spacing: 4px;
            font-size: 20px;
        }
    }
</style>


@endsection
