<?php if(Session::has('error')): ?>
    <script>
        toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": 'toast-top-left',
            }
        toastr.error("<?php echo e(Session::get('error')); ?>");
    </script>
<?php endif; ?>


<?php /**PATH D:\xampp\htdocs\mawatery-web\resources\views/admin/includes/alerts/errors.blade.php ENDPATH**/ ?>