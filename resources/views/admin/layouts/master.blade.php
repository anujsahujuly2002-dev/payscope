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
    // Event listener for the download PDF button
    document.getElementById('downloadPdfBtn').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;

        // Create a new jsPDF instance
        const doc = new jsPDF();

        // Get the content of the modal (or any div you want to convert to PDF)
        const transactionDetails = document.getElementById('transactionSlip').innerHTML;

        // Ensure that content is available
        if (transactionDetails) {
            // Add the content to the PDF
            doc.html(transactionDetails, {
                callback: function (doc) {
                    // Save the generated PDF with the desired file name
                    doc.save('transaction-slip.pdf');
                },
                margin: [10, 10, 10, 10], // Adjust margins if necessary
                x: 10,
                y: 10
            });
        } else {
            alert("Content not available for PDF generation.");
        }
    });
</script>

@livewireScripts
</body>
</html>
