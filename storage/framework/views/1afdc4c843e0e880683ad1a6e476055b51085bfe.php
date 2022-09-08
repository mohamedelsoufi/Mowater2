<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php echo $__env->yieldContent('title',__('words.admin_dashboard')); ?></title>
    <link rel="icon" href="<?php echo e(URL::asset('logo.png')); ?>" type="image/x-icon" sizes="32x32"/>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo e(asset('Dashboard/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet"
          href="<?php echo e(asset('Dashboard/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">

    <!-- daterange picker -->
    <link rel="stylesheet" href="<?php echo e(asset('Dashboard/plugins/daterangepicker/daterangepicker.css')); ?>">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?php echo e(asset('Dashboard/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')); ?>">

    
    <link rel="stylesheet" href="<?php echo e(asset('Dashboard/custom/yearpicker.css')); ?>">

    <?php if(App::isLocale('ar')): ?>
    <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo e(asset('Dashboard/plugins/fontawesome-free/css/allAr.min.css')); ?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo e(asset('Dashboard/dist/css/adminlteAr.css')); ?>">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="<?php echo e(asset('Dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')); ?>">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo e(asset('Dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
        <link rel="stylesheet"
              href="<?php echo e(asset('Dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('Dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')); ?>">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo e(asset('Dashboard/custom/styleAr.css')); ?>">
        <!-- Ekko Lightbox -->
        <link rel="stylesheet" href="<?php echo e(asset('Dashboard/plugins/ekko-lightbox/ekko-lightboxAr.css')); ?>">
        <!-- Select2 -->

    <?php else: ?>
    <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo e(asset('Dashboard/plugins/fontawesome-free/css/all.min.css')); ?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo e(asset('Dashboard/dist/css/adminlte.css')); ?>">
        <!-- overlayScrollbars -->
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="<?php echo e(asset('Dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')); ?>">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo e(asset('Dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
        <link rel="stylesheet"
              href="<?php echo e(asset('Dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('Dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('Dashboard/custom/style.css')); ?>">
        <!-- Ekko Lightbox -->
        <link rel="stylesheet" href="<?php echo e(asset('Dashboard/plugins/ekko-lightbox/ekko-lightbox.css')); ?>">
    <?php endif; ?>

    <?php echo $__env->yieldContent('styles'); ?>
    <?php echo $__env->yieldContent('head'); ?>
</head>

<body dir="<?php echo e((App::isLocale('ar') ? 'rtl' : 'ltr')); ?>" class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader Begin -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake mowater" src="<?php echo e(asset('mowater.png')); ?>" alt="Mowater Logo">
    </div>
    <!-- Preloader End -->

<?php echo $__env->make('admin.includes.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php echo $__env->make('admin.includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<!-- Content Wrapper. Contains page content -->
<?php echo $__env->yieldContent('content'); ?>
<!-- /.content-wrapper -->


<?php echo $__env->make('admin.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


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

<script src="<?php echo e(asset('Dashboard/plugins/jquery/jquery.min.js')); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo e(asset('Dashboard/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>

<!-- Bootstrap 4 -->
<script src="<?php echo e(asset('Dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>

<!-- Ekko Lightbox -->
<script src="<?php echo e(asset('Dashboard//plugins/ekko-lightbox/ekko-lightbox.min.js')); ?>"></script>

<!-- overlayScrollbars -->
<script src="<?php echo e(asset('Dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset('Dashboard/dist/js/adminlte.js')); ?>"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo e(asset('Dashboard/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('Dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('Dashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('Dashboard/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('Dashboard/plugins/datatables-buttons/js/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('Dashboard/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('Dashboard/plugins/jszip/jszip.min.js')); ?>"></script>
<script src="<?php echo e(asset('Dashboard/plugins/pdfmake/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(asset('Dashboard/plugins/pdfmake/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(asset('Dashboard/plugins/datatables-buttons/js/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(asset('Dashboard/plugins/datatables-buttons/js/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(asset('Dashboard/plugins/datatables-buttons/js/buttons.colVis.min.js')); ?>"></script>


<script src="<?php echo e(asset('/dashboard/custom/image-preview.js')); ?>"></script>

<script src="<?php echo e(asset('Dashboard/plugins/ckeditor/ckeditor.js')); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<!-- Select2 -->
<script src="<?php echo e(asset('Dashboard/plugins/select2/js/select2.full.min.js')); ?>"></script>

<!-- bs-custom-file-input -->
<script src="<?php echo e(asset('Dashboard/plugins/bs-custom-file-input/bs-custom-file-input.min.js')); ?>"></script>

<!-- InputMask -->
<script src="<?php echo e(asset('Dashboard/plugins/moment/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('Dashboard/plugins/inputmask/jquery.inputmask.min.js')); ?>"></script>

<!-- date-range-picker -->
<script src="<?php echo e(asset('Dashboard/plugins/daterangepicker/daterangepicker.js')); ?>"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo e(asset('Dashboard/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')); ?>"></script>

<!-- YearPicker -->
<script src="<?php echo e(asset('Dashboard/custom/yearpicker.js')); ?>"></script>

<script>
    var year_num = Number($('.yearpicker').val());
    $('.yearpicker').yearpicker({
        year: year_num,
    });
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        bsCustomFileInput.init();
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        //Date and time picker
        $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        });
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges   : {
                    'Today'       : [moment(), moment()],
                    'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                    'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate  : moment()
            },
            function (start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        );

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        });
    });
    // $('.yearpicker').yearpicker({
    //     // Initial Year
    //     year: null,
    //     startYear: 2022,
    // });
</script>
<script>
    $(function () {

        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "oLanguage": {
                "sSearch": "<?php echo e(__('words.search')); ?> : ",
                "sLoadingRecords": "<?php echo e(__('words.loading')); ?>",
                "sInfo": "<?php echo e(__('words.showing')); ?> _TOTAL_ <?php echo e(__('words.to')); ?> _START_ <?php echo e(__('words.of')); ?> _END_ <?php echo e(__('words.entries')); ?>",
                "sInfoEmpty": "<?php echo e(__('words.no_result')); ?>",
                "sEmptyTable": "<?php echo e(__('words.no_result')); ?>"
            },

            'buttons': [
                {
                    extend: 'copy', text: '<?php echo e(__('words.copy')); ?>'
                },
                {
                    extend: 'csv', text: '<?php echo e(__('words.csv')); ?>'
                },
                {
                    extend: 'excel', text: '<?php echo e(__('words.excel')); ?>'
                },
                {
                    extend: 'pdf', text: '<?php echo e(__('words.pdf')); ?>'
                },
                {
                    extend: 'print', text: '<?php echo e(__('words.print')); ?>'
                },
                {
                    extend: 'colvis', text: '<?php echo e(__('words.column_visibility')); ?>'
                },
            ],
            "language": {
                "paginate": {
                    "previous": "<?php echo e(__('pagination.previous')); ?>",
                    "next": "<?php echo e(__('pagination.next')); ?>",
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
<?php echo $__env->make('location', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('change_brand', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('scripts'); ?>


</body>

</html>
<?php /**PATH D:\xampp\htdocs\mawatery-web\resources\views/admin/layouts/standard.blade.php ENDPATH**/ ?>