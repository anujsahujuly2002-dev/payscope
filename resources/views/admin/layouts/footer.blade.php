<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
            ©
            <script>
                document.write(new Date().getFullYear());
            </script>
            , made with ❤️ by
            Payscope
        </div>
    </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/vendor/js/menu.js')}}"></script>
<!-- endbuild -->
<!-- Vendors JS -->
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
<!-- Main JS -->
<script src="{{asset('assets/js/main.js')}}"></script>
<!-- Page JS -->
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/js/select2.js')}}"></script>
<script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
@stack('script')


<script>
    $(document).ready(function() {
    /*  $('select').select2({
            width: 'auto',
            allowClear: false,
            height: '100%',
            dropdownParent: $('#form')
        }); */
        $(".start-date").datepicker({
            'autoclose':true,
            'clearBtn':true,
            'todayHighlight':true,
            'format':'yyyy-mm-dd'
        });

        $('#start-date').datepicker("setDate", new Date());
        $('#end-date').datepicker('setStartDate', new Date());

            $('#end-date').focus(function(){
            if($('#start-date').val().length == 0){
                $('#end-date').datepicker('hide');
                $('#start-date').focus();
            }
        });

        $('#start-date').datepicker().on('changeDate', function(e) {
            $('#end-date').datepicker('setStartDate', $('#start-date').val());
            $('#end-date').datepicker('setDate', $('#start-date').val());
        });

    })
    window.addEventListener('show-form',event=>{
        $("#form").modal('show');
    });
    window.addEventListener('hide-form',event=>{
        let $from = $("#form").find('form');
        $from[0].reset();
        $("#form").modal('hide');
    });

</script>
@livewireScripts
</body>
</html>
