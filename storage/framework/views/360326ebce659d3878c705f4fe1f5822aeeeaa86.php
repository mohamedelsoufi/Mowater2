<?php $__env->startSection('title', __('words.show_special_number_organizations')); ?>
<?php $__env->startSection('content'); ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?php echo e(__('words.admin_dashboard')); ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb <?php echo e(app()->getLocale() == 'ar' ? 'float-sm-left' :  'float-sm-right'); ?>">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.home')); ?>"><?php echo e(__('words.home')); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo e(__('words.show_special_number_organizations')); ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <?php echo $__env->make('admin.includes.alerts.success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('admin.includes.alerts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo e(__('words.show_special_number_organizations')); ?></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('words.logo')); ?></th>
                                        <th><?php echo e(__('words.name_ar')); ?></th>
                                        <th><?php echo e(__('words.name_en')); ?></th>
                                        <th><?php echo e(__('words.activity')); ?></th>
                                        <th><?php echo e(__('words.actions')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $organization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key+1); ?></td>
                                            <td>
                                                <?php if(!$organization->logo): ?>
                                                    <a href="<?php echo e(asset('uploads/default_image.png')); ?>"
                                                       data-toggle="lightbox" data-title="<?php echo e($organization->name); ?>"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="<?php echo e(asset('uploads/default_image.png')); ?>" alt="logo">
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e($organization->logo); ?>"
                                                       data-toggle="lightbox" data-title="<?php echo e($organization->name); ?>"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="<?php echo e($organization->logo); ?>"
                                                             onerror="this.src='<?php echo e(asset('uploads/default_image.png')); ?>'"
                                                             alt="logo">
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($organization->name_ar); ?></td>
                                            <td><?php echo e($organization->name_en); ?></td>
                                            <td><?php echo e($organization->getActive()); ?></td>
                                            <td>
                                                <?php if(auth('admin')->user()->hasPermission('read-special_numbers_organizations')): ?>
                                                    <a href="<?php echo e(route('special-number-organizations.show',$organization->id)); ?>"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="<?php echo e(__('words.show')); ?>">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if(auth('admin')->user()->hasPermission('update-special_numbers_organizations')): ?>
                                                    <a href="<?php echo e(route('special-number-organizations.edit',$organization->id)); ?>" data-toggle="tooltip"
                                                       title="<?php echo e(__('words.edit')); ?>"
                                                       class="btn btn-outline-warning"> <i class="fas fa-pen"></i></a>
                                                <?php endif; ?>

                                                <?php if(auth('admin')->user()->hasPermission('delete-special_numbers_organizations')): ?>
                                                    <a href="" class="btn btn-outline-danger"
                                                       data-toggle="modal"
                                                       data-target="#ModalDelete<?php echo e($organization->id); ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <?php echo $__env->make('admin.organizations.special_numbers.special_number_organizations.deleteModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.standard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\mawatery-web\resources\views/admin/organizations/special_numbers/special_number_organizations/index.blade.php ENDPATH**/ ?>