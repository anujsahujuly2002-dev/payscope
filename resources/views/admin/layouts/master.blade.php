<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('admin.layouts.title-meta')
    @include('admin.layouts.header')
</head>

@section('body')
    <body>
    @show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('admin.layouts.topbar')
        @include('admin.layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('admin.layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('admin.layouts.right-sidebar')
    <!-- /Right-bar -->
    <!-- JAVASCRIPT -->
    @include('admin.layouts.scripts')
    <!-- App js -->
    <script src="{{asset('/assets/js/app.min.js')}}"></script>
    <script>
        window.addEventListener('show-form',event=>{
            $("#form").modal('show');
        });
        window.addEventListener('hide-form',event=>{
            let $from = $("#form").find('form');
            $from[0].reset();
            $("#form").modal('hide');
        });
    </script>


<script>
    function downloadPdf() {
        var element = document.getElementById('transaction-details'); // Select the modal content

        // Configure and download PDF
        html2pdf().from(element).set({
            margin: 1,
            filename: 'transaction-details.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        }).save();
    }
</script>
@livewireScripts
</body>
</html>
