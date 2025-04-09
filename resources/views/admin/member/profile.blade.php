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
@section('script-bottom')
<script>
    window.addEventListener('otp-move', function(event) {
        const position = event.detail.position;
        const key = event.detail.key;

        // Use a short delay so the value registers before focus moves
        setTimeout(() => {
            if (key !== 'Backspace') {
                const nextInput = document.getElementById(`otp-digit-${position + 1}`);
                if (nextInput) nextInput.focus();
            } else {
                const prevInput = document.getElementById(`otp-digit-${position - 1}`);
                if (prevInput) prevInput.focus();
            }
        }, 10); // Just 10ms is enough
    });
</script>



@endsection
