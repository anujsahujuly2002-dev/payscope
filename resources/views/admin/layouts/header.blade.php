    @yield('css')
    <!-- Bootstrap Css -->
    <link href="{{ asset('/assets/css/bootstrap.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('/assets/css/icons.css')}}" id="icons-style" rel="stylesheet" type="text/css" />
    <!--QR Collection Css-->
    <link href="{{ asset('/assets/css/qrCollection.css')}}" id="qrCollection-style" rel="stylesheet" type="text/css" />

    <!-- App Css-->
    <link href="{{ asset('/assets/css/app.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/assets/libs/datepicker/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/libs/flatpickr/flatpickr.min.css') }}">
    @livewireStyles
