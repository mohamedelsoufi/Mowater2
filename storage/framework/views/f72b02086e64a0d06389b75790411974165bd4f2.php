<?php if(Session::has('success')): ?>
    <script>
        toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": 'toast-top-left',
            }
        toastr.success("<?php echo e(Session::get('success')); ?>");
    </script>
<?php endif; ?>
<?php /**PATH D:\xampp\htdocs\mawatery-web\resources\views/admin/includes/alerts/success.blade.php ENDPATH**/ ?>