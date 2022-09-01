<?php $__env->startSection('title', __('words.edit_special_number_organization')); ?>
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
                            <li class="breadcrumb-item"><a
                                    href="<?php echo e(route('special-number-organizations.index')); ?>"><?php echo e(__('words.show_special_number_organizations')); ?></a>
                            </li>
                            <li class="breadcrumb-item active"><?php echo e(__('words.edit_special_number_organization')); ?></li>
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
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo e(__('words.edit_special_number_organization')); ?></h3>
                            </div>
                            <form method="post"
                                  action="<?php echo e(route('special-number-organizations.update',$organization->id)); ?>"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="id" value="<?php echo e($organization->id); ?>">
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label><?php echo e(__('words.name_ar')); ?></label>
                                                <input type="text" name="name_ar"
                                                       class="form-control <?php $__errorArgs = ['name_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       value="<?php echo e(old('name_ar',$organization->name_ar)); ?>"
                                                       placeholder="<?php echo e(__('words.name_ar')); ?>">
                                                <?php $__errorArgs = ['name_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>                                </div>

                                            <div class="form-group col-md-6">
                                                <label><?php echo e(__('words.name_en')); ?></label>
                                                <input type="text" name="name_en"
                                                       class="form-control <?php $__errorArgs = ['name_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       value="<?php echo e(old('name_en',$organization->name_en)); ?>"
                                                       placeholder="<?php echo e(__('words.name_en')); ?>">

                                                <?php $__errorArgs = ['name_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label><?php echo e(__('words.description_ar')); ?></label>
                                                <textarea name="description_ar"
                                                          class="form-control <?php $__errorArgs = ['description_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description_ar',$organization->description_ar)); ?></textarea>

                                                <?php $__errorArgs = ['description_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label><?php echo e(__('words.description_en')); ?></label>
                                                <textarea name="description_en"
                                                          class="form-control <?php $__errorArgs = ['description_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description_en',$organization->description_en)); ?></textarea>

                                                <?php $__errorArgs = ['description_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label><?php echo e(__('words.logo')); ?></label>
                                                <input type="file" name="logo"
                                                       class="form-control image <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       placeholder="<?php echo e(__('words.logo')); ?>">
                                                <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="col-6 text-center pt-3">
                                                <img src="<?php echo e(old('logo',$organization->logo)); ?>"
                                                     class="index_image image-preview" alt="logo">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label><?php echo e(__('words.tax_number')); ?></label>
                                                <input type="text" name="tax_number"
                                                       class="form-control <?php $__errorArgs = ['tax_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       value="<?php echo e(old('tax_number',$organization->tax_number)); ?>"
                                                       placeholder="<?php echo e(__('words.tax_number')); ?>">
                                                <?php $__errorArgs = ['tax_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label><?php echo e(__('words.year_founded')); ?></label>
                                                <input type="number" min="1900" name="year_founded"
                                                       class="form-control <?php $__errorArgs = ['year_founded'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       value="<?php echo e(old('year_founded',$organization->year_founded)); ?>"
                                                       placeholder="<?php echo e(__('words.year_founded')); ?>">

                                                <?php $__errorArgs = ['year_founded'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label><?php echo e(__('words.country')); ?></label>
                                                <select name="country_id"
                                                        class="form-control country_id <?php $__errorArgs = ['country_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <option value="" selected><?php echo e(__('words.choose')); ?></option>
                                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option
                                                            value="<?php echo e($country->id); ?>" <?php echo e($organization->country_id == $country->id ? 'selected' : ''); ?>><?php echo e($country->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['country_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label><?php echo e(__('words.city')); ?></label>
                                                <select name="city_id"
                                                        class="form-control city_id <?php $__errorArgs = ['city_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option
                                                            value="<?php echo e($city->id); ?>" <?php echo e($organization->city_id == $city->id ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['city_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label><?php echo e(__('words.area')); ?></label>
                                                <select name="area_id"
                                                        class="form-control area_id <?php $__errorArgs = ['area_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <option
                                                        value="<?php echo e($organization->area->id); ?>"><?php echo e($organization->area->name); ?></option>
                                                </select>
                                                <?php $__errorArgs = ['area_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active" value="0"
                                                           <?php echo e($organization->active == 1 ? 'checked' : ''); ?> type="checkbox">
                                                    <label class="form-check-label">
                                                        <?php echo e(__('words.activity')); ?>

                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="reservation_active" value="0"
                                                           <?php echo e($organization->reservation_active == 1 ? 'checked' : ''); ?> type="checkbox">
                                                    <label class="form-check-label">
                                                        <?php echo e(__('words.reservation_active')); ?>

                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="delivery_active" value="0"
                                                           <?php echo e($organization->delivery_active == 1 ? 'checked' : ''); ?> type="checkbox">
                                                    <label class="form-check-label">
                                                        <?php echo e(__('words.delivery_active')); ?>

                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <hr>

                                        
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label><?php echo e(__('words.email')); ?></label>
                                                <select name="organization_user_id"
                                                        class="form-control email-change <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <option value="" selected><?php echo e(__('words.choose')); ?></option>
                                                </select>
                                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label><?php echo e(__('words.user_name')); ?></label>
                                                <input type="text" name="user_name"
                                                       class="form-control username <?php $__errorArgs = ['user_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       value="<?php echo e(old('user_name')); ?>"
                                                       placeholder="<?php echo e(__('words.user_name')); ?>">

                                                <?php $__errorArgs = ['user_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label><?php echo e(__('words.password')); ?></label>
                                                <input type="password" name="password"
                                                       class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       value="<?php echo e(old('password')); ?>"
                                                       placeholder="<?php echo e(__('words.password')); ?>">

                                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label><?php echo e(__('words.confirm_password')); ?></label>
                                                <input type="password" name="password_confirmation"
                                                       class="form-control <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       value="<?php echo e(old('password_confirmation')); ?>"
                                                       placeholder="<?php echo e(__('words.confirm_password')); ?>">

                                                <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <button type="submit" class="btn btn-block btn-outline-info">
                                                <?php echo e(__('words.update')); ?>

                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function () {
            let url = "<?php echo e(route('special-org.users' , ':id')); ?>"
            url = url.replace(':id', "<?php echo e($organization->id); ?>");
            $.ajax({
                type: "Get",
                url: url,
                datatype: 'JSON',
                success: function (data) {
                    if (data.status == true) {
                        data.data.users.forEach(function (user) {
                            var option = `<option value ="${user.id}" >${user.email}</option>`;
                            $('.email-change').append(option);
                        });
                    }
                },
                error: function (reject) {
                    alert("<?php echo e(__('message.something_wrong')); ?>");
                }
            });
        });

        $('.email-change').on('change', function () {
            let user_id = $('.email-change').val();
            let get_user_url = "<?php echo e(route('special-org.user',[$organization->id,':user'])); ?>";
            get_user_url = get_user_url.replace(':user',user_id);

            $.ajax({
                type: "Get",
                url: get_user_url,
                datatype: 'JSON',
                success: function (data) {
                    if (data.status == true) {
                        $('.username').val(data.data.user.user_name);
                    }
                },
                error: function (reject) {
                    alert(reject);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.standard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\mawatery-web\resources\views/admin/organizations/special_numbers/special_number_organizations/edit.blade.php ENDPATH**/ ?>