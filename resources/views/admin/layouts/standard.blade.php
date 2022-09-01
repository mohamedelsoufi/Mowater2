<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title',__('words.admin_dashboard'))</title>
    <link rel="icon" href="{{ URL::asset('logo.png') }}" type="image/x-icon" sizes="32x32"/>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('Dashboard/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('Dashboard/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    {{--YearPicker--}}
    <link rel="stylesheet" href="{{asset('Dashboard/dist/css/yearpicker.css')}}">

    @if(App::isLocale('ar'))
    <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('Dashboard/plugins/fontawesome-free/css/allAr.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('Dashboard/dist/css/adminlteAr.css')}}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{asset('Dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{asset('Dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet"
              href="{{asset('Dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{asset('Dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{asset('Dashboard/custom/styleAr.css')}}">
        <!-- Ekko Lightbox -->
        <link rel="stylesheet" href="{{asset('Dashboard/plugins/ekko-lightbox/ekko-lightboxAr.css')}}">
        <!-- Select2 -->
        <style>
            body {
                font-family: 'Cairo', sans-serif;
            }
        </style>
    @else
    <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('Dashboard/plugins/fontawesome-free/css/all.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('Dashboard/dist/css/adminlte.css')}}">
        <!-- overlayScrollbars -->
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{asset('Dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{asset('Dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet"
              href="{{asset('Dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{asset('Dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{asset('Dashboard/custom/style.css')}}">
        <!-- Ekko Lightbox -->
        <link rel="stylesheet" href="{{asset('Dashboard/plugins/ekko-lightbox/ekko-lightbox.css')}}">
    @endif

    @yield('styles')
    @yield('head')
</head>

<body dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}" class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader Begin -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake mowater" src="{{asset('mowater.png')}}" alt="Mowater Logo">
    </div>
    <!-- Preloader End -->
{{--Navbar Begin--}}
@include('admin.includes.navbar')
{{--Navbar End--}}

{{--Sidebar Begin--}}
@include('admin.includes.sidebar')
{{--Sidebar End--}}

<!-- Content Wrapper. Contains page content -->
@yield('content')
<!-- /.content-wrapper -->

{{--Footer Begin--}}
@include('admin.includes.footer')
{{--Footer End--}}

<!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>

<!-- ./wrapper -->


<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine.js"
        integrity="sha512-nIwdJlD5/vHj23CbO2iHCXtsqzdTTx3e3uAmpTm4x2Y8xCIFyWu4cSIV8GaGe2UNVq86/1h9EgUZy7tn243qdA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{asset('Dashboard/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('Dashboard/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<!-- Bootstrap 4 -->
<script src="{{asset('Dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Ekko Lightbox -->
<script src="{{asset('Dashboard//plugins/ekko-lightbox/ekko-lightbox.min.js')}}"></script>

<!-- overlayScrollbars -->
<script src="{{asset('Dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('Dashboard/dist/js/adminlte.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('Dashboard/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('Dashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('Dashboard/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('Dashboard/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('Dashboard/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('Dashboard/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('Dashboard/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('Dashboard/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('Dashboard/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('Dashboard/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('Dashboard/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

{{-- custom Js --}}
<script src="{{asset('/dashboard/custom/image-preview.js')}}"></script>

<script src="{{asset('Dashboard/plugins/ckeditor/ckeditor.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<!-- Select2 -->
<script src="{{asset('Dashboard/plugins/select2/js/select2.full.min.js')}}"></script>

<!-- bs-custom-file-input -->
<script src="{{asset('Dashboard/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<!-- YearPicker -->
<script src="{{asset('Dashboard/dist/js/yearpicker.js')}}"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        bsCustomFileInput.init();
    });
    // $(".yearpicker").yearpicker();
    $('.yearpicker').yearpicker({
        // Initial Year
        year: null,
        startYear: 2022,
    });
</script>
<script>
    $(function () {

        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "oLanguage": {
                "sSearch": "{{__('words.search')}} : ",
                "sLoadingRecords": "{{__('words.loading')}}",
                "sInfo": "{{__('words.showing')}} _TOTAL_ {{__('words.to')}} _START_ {{__('words.of')}} _END_ {{__('words.entries')}}",
                "sInfoEmpty": "{{__('words.no_result')}}",
                "sEmptyTable": "{{__('words.no_result')}}"
            },

            'buttons': [
                {
                    extend: 'copy', text: '{{__('words.copy')}}'
                },
                {
                    extend: 'csv', text: '{{__('words.csv')}}'
                },
                {
                    extend: 'excel', text: '{{__('words.excel')}}'
                },
                {
                    extend: 'pdf', text: '{{__('words.pdf')}}'
                },
                {
                    extend: 'print', text: '{{__('words.print')}}'
                },
                {
                    extend: 'colvis', text: '{{__('words.column_visibility')}}'
                },
            ],
            "language": {
                "paginate": {
                    "previous": "{{__('pagination.previous')}}",
                    "next": "{{__('pagination.next')}}",
                }
            }
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
    });
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

</script>
@include('location')
@yield('scripts')


</body>

</html>
