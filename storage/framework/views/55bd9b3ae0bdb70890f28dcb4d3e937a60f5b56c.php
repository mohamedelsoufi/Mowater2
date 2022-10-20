<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?php echo e(route('admin.home')); ?>" class="nav-link"><?php echo e(__('words.home')); ?></a>
        </li>



    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->











































































































        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-globe-asia"></i>
                <span class="MobileText"><?php echo e(LaravelLocalization::getCurrentLocaleNative()); ?></span>
            </a>
            <div class="dropdown-menu dropdown-flag">
                <?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a class="dropdown-item <?php echo e(LaravelLocalization::getCurrentLocaleNative() == $properties['native'] ? 'd-none' : ''); ?>" rel="alternate" hreflang="<?php echo e($localeCode); ?>" href="<?php echo e(LaravelLocalization::getLocalizedURL($localeCode, null, [], true)); ?>">
                        <?php echo e($properties['native']); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('admin.logout')); ?>" data-toggle="tooltip" title="<?php echo e(__('words.logout')); ?>" role="button">
                <i class="fa fa-sign-out-alt"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
<?php /**PATH D:\xampp\htdocs\mawatery-web\resources\views/admin/includes/navbar.blade.php ENDPATH**/ ?>