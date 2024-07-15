<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Otp Verification | {{env('APP_NAME')}}</title>
	{{-- <link href="{{ asset('/assets/css/bootstrap.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('/assets/css/app.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/icons.css')}}" id="icons-style" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{asset('assets/css/otp-verification.css')}}">
    @livewireStyles()
</head>
<body>
<section class="forgotbg">
	@livewire('admin.auth.otp-verification-component')
</section>
</body>
<script src="{{asset('/assets/libs/jquery/jquery.min.js')}}"></script>
@yield('script-bottom')

@livewireScripts()

</html>
