<!-- JAVASCRIPT -->
<script src="{{ asset('/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/libs/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('/assets/libs/metismenu/metismenu.min.js') }}"></script>
<script src="{{ asset('/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('/assets/libs/node-waves/node-waves.min.js') }}"></script>
<script src="{{ asset('/assets/libs/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('/assets/libs/jquery-counterup/jquery-counterup.min.js') }}"></script>
<script src="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.js') }}"></script>
<script src="{{ asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('/assets/libs/datepicker/datepicker.min.js') }}"></script>
<script src="{{ asset('/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('/assets/js/pages/form-advanced.init.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>




<!-- apexcharts -->
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>
@yield('script-bottom')

<!-- App js -->
{{-- <script src="{{asset('/assets/js/app.min.js')}}"></script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function downloadPdf() {
        const element = document.getElementById('transaction-details');

        const options = {
            margin: 1,
            filename: 'transaction-details.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait'
            }
        };

        html2pdf()
            .from(element)
            .set(options)
            .save();
    }
</script>
