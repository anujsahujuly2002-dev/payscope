<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @section('title')
        Login
    @endsection
    @include('admin.layouts.title-meta')
    @include('admin.layouts.header')
</head>
<body class="authentication-bg">
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <a href="{{route('admin.login') }}" class="mb-5 d-block auth-logo">
                            <img src="{{ asset('/assets/images/logo1.jpeg') }}" alt="" height="22" class="logo logo-dark">
                            <img src="{{asset('/assets/images/logo1.jpeg') }}" alt="" height="22" class="logo logo-light">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-body p-4">
                            @livewire('admin.auth.auth-component')
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>© <script>
                                document.write(new Date().getFullYear())
                            </script> 
                            {{-- Minible. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand --}}
                        </p>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    @include('admin.layouts.scripts')
</body>
</html>
