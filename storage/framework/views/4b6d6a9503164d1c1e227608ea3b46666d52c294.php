<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo e(route('admin.home')); ?>" class="brand-link">
        <img src="<?php echo e(asset('logo.png')); ?>" alt="Mowater Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo e(__('words.mowater')); ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo e(asset('no-user.jpg')); ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?php echo e(route('admin-users.show',auth('admin')->user()->id)); ?>"
                   class="d-block"><?php echo e(auth('admin')->user()->first_name .' '. auth('admin')->user()->last_name); ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <?php if(auth('admin')->user()->hasPermission(['read-admins','read-roles','read-app_users','read-org_users'])): ?>
                    <li class="nav-item <?php echo e(request()->routeIs('admin-roles.*','admin-users.*','app-users.*','org-users.*') ? 'menu-open' : ''); ?>">
                        <a href="#"
                           class="nav-link <?php echo e(request()->routeIs('admin-roles.*','admin-users.*','app-users.*','org-users.*') ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                <?php echo e(__('words.users')); ?>

                                <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview level">
                            <!-- Permissions Users Start -->
                            <?php if(auth('admin')->user()->hasPermission('read-roles')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('admin-roles.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('admin-roles.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-universal-access"></i>
                                        <p>
                                            <?php echo e(__('words.permissions')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-roles')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('admin-roles.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('admin-roles.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-roles')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('admin-roles.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('admin-roles.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <!-- Permissions Users end -->

                            <!-- Admin Users Start -->
                            <?php if(auth('admin')->user()->hasPermission('read-admins')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('admin-users.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('admin-users.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="nav-icon fas fa-user"></i>
                                        <p>
                                            <?php echo e(__('words.admin_users')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-admins')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('admin-users.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('admin-users.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-admins')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('admin-users.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('admin-users.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <!-- Admin Users end -->

                            <!-- App Users Start -->
                            <?php if(auth('admin')->user()->hasPermission('read-app_users')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('app-users.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('app-users.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-mobile"></i>
                                        <p>
                                            <?php echo e(__('words.app_users')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-app_users')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('app-users.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('app-users.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <!-- App Users end -->

                            <!-- Organization Users Start -->
                            <?php if(auth('admin')->user()->hasPermission('read-org_users')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('org-users.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('org-users.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-place-of-worship"></i>
                                        <p>
                                            <?php echo e(__('words.org_users')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-org_users')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('org-users.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('org-users.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                        <?php endif; ?>
                            <!-- Organization Users end -->
                        </ul>
                    </li>
                <?php endif; ?>
                

                
                <?php if(auth('admin')->user()->hasPermission(['read-brands','read-car_models','read-car_classes','read-manufacture_countries','read-used_vehicles'])): ?>
                    <li class="nav-item <?php echo e(request()->routeIs('brands.*','car-models.*','car-classes.*','manufacture-countries.*','used-vehicles.*') ? 'menu-open' : ''); ?>">
                        <a href="#"
                           class="nav-link <?php echo e(request()->routeIs('brands.*','car-models.*','car-classes.*','manufacture-countries.*','used-vehicles.*') ? 'active' : ''); ?>">
                            <i class="fa fa-car"></i>
                            <p>
                                <?php echo e(__('words.vehicles_details')); ?>

                                <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            
                            <?php if(auth('admin')->user()->hasPermission('read-brands')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('brands.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('brands.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fa fa-circle-notch"></i>
                                        <p>
                                            <?php echo e(__('words.brands')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-brands')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('brands.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('brands.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-brands')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('brands.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('brands.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-car_models')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('car-models.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('car-models.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fa fa-star"></i>
                                        <p>
                                            <?php echo e(__('words.car_model')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-car_models')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('car-models.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('car-models.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-car_models')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('car-models.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('car-models.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-car_classes')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('car-classes.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('car-classes.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fa fa-list-ol"></i>
                                        <p>
                                            <?php echo e(__('words.car_class')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-car_classes')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('car-classes.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('car-classes.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(auth('admin')->user()->hasPermission('create-car_classes')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('car-classes.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('car-classes.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-manufacture_countries')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('manufacture-countries.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('manufacture-countries.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fa fa-industry"></i>
                                        <p>
                                            <?php echo e(__('words.manufacture_countries')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-manufacture_countries')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('manufacture-countries.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('manufacture-countries.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-manufacture_countries')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('manufacture-countries.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('manufacture-countries.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-used_vehicles')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('used-vehicles.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('used-vehicles.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-car"></i>
                                        <p>
                                            <?php echo e(__('words.used_vehicles')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-used_vehicles')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('used-vehicles.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('used-vehicles.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-used_vehicles')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('used-vehicles.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('used-vehicles.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            
                        </ul>
                    </li>
                <?php endif; ?>
                

                
                <?php if(auth('admin')->user()->hasPermission(['read-countries','read-cities','read-areas'])): ?>
                    <li class="nav-item <?php echo e(request()->routeIs('countries.*','cities.*','areas.*') ? 'menu-open' : ''); ?>">
                        <a href="#"
                           class="nav-link <?php echo e(request()->routeIs('countries.*','cities.*','areas.*') ? 'active' : ''); ?>">
                            <i class="fa fa-globe"></i>
                            <p>
                                <?php echo e(__('words.location')); ?>

                                <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            
                            <?php if(auth('admin')->user()->hasPermission('read-countries')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('countries.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('countries.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fa fa-flag"></i>
                                        <p>
                                            <?php echo e(__('words.countries')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-countries')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('countries.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('countries.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(auth('admin')->user()->hasPermission('create-countries')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('countries.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('countries.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-cities')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('cities.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('cities.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-place-of-worship"></i>
                                        <p>
                                            <?php echo e(__('words.cities')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-cities')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('cities.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('cities.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-cities')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('cities.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('cities.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-areas')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('areas.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('areas.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-home"></i>
                                        <p>
                                            <?php echo e(__('words.areas')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-areas')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('areas.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('areas.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-areas')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('areas.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('areas.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                        </ul>
                    </li>
                <?php endif; ?>
                

                
                <?php if(auth('admin')->user()->hasPermission(['read-sections','read-categories','read-sub_categories','read-currencies','read-payment_methods','read-app_sliders','read-discount_cards','read-colors','read-ads','read-ad-types'])): ?>
                    <li class="nav-item <?php echo e(request()->routeIs('sections.*','categories.*','sub-categories.*','currencies.*','payment-methods.*','app-sliders.*','discount-cards.*','colors.*','ads.*','ad-types.*') ? 'menu-open' : ''); ?>">
                        <a href="#"
                           class="nav-link <?php echo e(request()->routeIs('sections.*','categories.*','sub-categories.*','currencies.*','payment-methods.*','app-sliders.*','discount-cards.*','colors.*','ads.*') ? 'active' : ''); ?>">
                            <i class="fas fa-sliders-h"></i>
                            <p>
                                <?php echo e(__('words.general')); ?>

                                <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            
                            <?php if(auth('admin')->user()->hasPermission('read-discount_cards')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('discount-cards.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('discount-cards.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-donate"></i>
                                        <p>
                                            <?php echo e(__('words.discount_cards')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-discount_cards')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('discount-cards.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('discount-cards.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-discount_cards')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('discount-cards.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('discount-cards.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-ads')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('ads.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('ads.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-ad"></i>
                                        <p>
                                            <?php echo e(__('words.ads')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-ads')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('ads.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('ads.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-ads')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('ads.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('ads.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                            
                                            <?php if(auth('admin')->user()->hasPermission('read-ad_types')): ?>
                                                <li class="nav-item <?php echo e(request()->routeIs('ad-types.*') ? 'menu-open' : ''); ?>">
                                                    <a href="#"
                                                       class="nav-link <?php echo e(request()->routeIs('ad-types.*') ? 'sub-menu active' : ''); ?>">
                                                        <i class="fas fa-award"></i>
                                                        <p>
                                                            <?php echo e(__('words.ad_types')); ?>

                                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                                        </p>
                                                    </a>
                                                    <ul class="nav nav-treeview">
                                                        <?php if(auth('admin')->user()->hasPermission('read-ad_types')): ?>
                                                            <li class="nav-item">
                                                                <a href="<?php echo e(route('ad-types.index')); ?>"
                                                                   class="nav-link <?php echo e(request()->routeIs('ad-types.index') ? 'active' : ''); ?>">
                                                                    <i class="far fa-eye nav-icon"></i>
                                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php if(auth('admin')->user()->hasPermission('create-ad_types')): ?>
                                                            <li class="nav-item">
                                                                <a href="<?php echo e(route('ad-types.create')); ?>"
                                                                   class="nav-link <?php echo e(request()->routeIs('ad-types.create') ? 'active' : ''); ?>">
                                                                    <i class="fas fa-folder-plus"></i>
                                                                    <p><?php echo e(__('words.create')); ?></p>
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </li>
                                            <?php endif; ?>
                                            
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-sections')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('sections.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('sections.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-th-list"></i>
                                        <p>
                                            <?php echo e(__('words.sections')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-sections')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('sections.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('sections.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-categories')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('categories.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('categories.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-bars"></i>
                                        <p>
                                            <?php echo e(__('words.categories')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-categories')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('categories.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('categories.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-categories')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('categories.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('categories.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-sub_categories')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('sub-categories.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('sub-categories.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-folder"></i>
                                        <p>
                                            <?php echo e(__('words.sub_categories')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-sub_categories')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('sub-categories.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('sub-categories.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-sub_categories')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('sub-categories.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('sub-categories.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-currencies')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('currencies.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('currencies.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-dollar-sign"></i>
                                        <p>
                                            <?php echo e(__('words.currencies')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-currencies')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('currencies.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('currencies.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-currencies')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('currencies.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('currencies.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-payment_methods')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('payment-methods.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('payment-methods.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-credit-card"></i>
                                        <p>
                                            <?php echo e(__('words.payment_methods')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-payment_methods')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('payment-methods.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('payment-methods.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-payment_methods')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('payment-methods.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('payment-methods.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-app_sliders')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('app-sliders.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('app-sliders.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-photo-video"></i>
                                        <p>
                                            <?php echo e(__('words.app_sliders')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-app_sliders')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('app-sliders.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('app-sliders.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-colors')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('colors.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('colors.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-palette"></i>
                                        <p>
                                            <?php echo e(__('words.colors')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-colors')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('colors.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('colors.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-colors')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('colors.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('colors.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            
                        </ul>
                    </li>
                <?php endif; ?>
                

                
                <?php if(auth('admin')->user()->hasPermission(['read-special_numbers_organizations','read-special_numbers','read-agencies','read-car_showrooms','read-rental_offices','read-wenches','read-insurance_companies','read-brokers','read-delivery','read-driving_trainers','read-fuel_stations','read-traffic_clearing_offices','read-garages','read-technical_inspection_centers','read-tire_exchange_centers','read-accessories_stores','read-car_washes','read-mining_centers'])): ?>
                    <li class="nav-item <?php echo e(request()->routeIs('special-number-organizations.*','special-numbers.*','agencies.*','car-showrooms.*','rental-offices.*','wenches.*','insurance_companies.*','brokers.*','delivery.*','trainers.*','fuel-stations.*','traffic-clearing-offices.*','garages.*','inspection-centers.*','tire-exchange-centers.*','accessories-stores.*','car-washes.*','mining-centers.*') ? 'menu-open' : ''); ?>">
                        <a href="#"
                           class="nav-link <?php echo e(request()->routeIs('special-number-organizations.*','special-numbers.*','agencies.*','car-showrooms.*','rental-offices.*','wenches.*','insurance_companies.*','brokers.*','delivery.*','trainers.*','fuel-stations.*','traffic-clearing-offices.*','garages.*','inspection-centers.*','tire-exchange-centers.*','accessories-stores.*','car-washes.*','mining-centers.*') ? 'active' : ''); ?>">
                            <i class="fas fa-place-of-worship"></i>
                            <p>
                                <?php echo e(__('words.organizations')); ?>

                                <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            
                            <?php if(auth('admin')->user()->hasPermission('read-agencies')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('agencies.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('agencies.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-peace"></i>
                                        <p>
                                            <?php echo e(__('words.agencies')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-agencies')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('agencies.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('agencies.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-agencies')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('agencies.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('agencies.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-car_showrooms')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('car-showrooms.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('car-showrooms.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-store"></i>
                                        <p>
                                            <?php echo e(__('words.car_showrooms')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-car_showrooms')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('car-showrooms.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('car-showrooms.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-car_showrooms')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('car-showrooms.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('car-showrooms.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-rental_offices')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('rental-offices.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('rental-offices.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-handshake"></i>
                                        <p>
                                            <?php echo e(__('words.rental_offices')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-rental_offices')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('rental-offices.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('rental-offices.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-rental_offices')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('rental-offices.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('rental-offices.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission(['read-special_numbers_organizations','read-special_numbers'])): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('special-number-organizations.*','special-numbers.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('special-number-organizations.*','special-numbers.*') ? 'active' : ''); ?>">
                                        <i class="fas fa-sort-numeric-down"></i>
                                        <p>
                                            <?php echo e(__('words.special_numbers')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>

                                    <ul class="nav nav-treeview">
                                        
                                        <?php if(auth('admin')->user()->hasPermission('read-special_numbers')): ?>
                                            <li class="nav-item <?php echo e(request()->routeIs('special-numbers.*') ? 'menu-open' : ''); ?>">
                                                <a href="#"
                                                   class="nav-link <?php echo e(request()->routeIs('special-numbers.*') ? 'sub-menu active' : ''); ?>">
                                                    <i class="fas fa-award"></i>
                                                    <p>
                                                        <?php echo e(__('words.special_numbers')); ?>

                                                        <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    <?php if(auth('admin')->user()->hasPermission('read-special_numbers')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('special-numbers.index')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('special-numbers.index') ? 'active' : ''); ?>">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p><?php echo e(__('words.show_all')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if(auth('admin')->user()->hasPermission('create-special_numbers')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('special-numbers.create')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('special-numbers.create') ? 'active' : ''); ?>">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p><?php echo e(__('words.create')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </li>
                                        <?php endif; ?>
                                        

                                        
                                        <?php if(auth('admin')->user()->hasPermission('read-special_numbers_organizations')): ?>
                                            <li class="nav-item <?php echo e(request()->routeIs('special-number-organizations.*') ? 'menu-open' : ''); ?>">
                                                <a href="#"
                                                   class="nav-link <?php echo e(request()->routeIs('special-number-organizations.*') ? 'sub-menu active' : ''); ?>">
                                                    <i class="fas fa-archway"></i>
                                                    <p>
                                                        <?php echo e(__('words.special_numbers_organizations')); ?>

                                                        <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    <?php if(auth('admin')->user()->hasPermission('read-special_numbers_organizations')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('special-number-organizations.index')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('special-number-organizations.index') ? 'active' : ''); ?>">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p><?php echo e(__('words.show_all')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if(auth('admin')->user()->hasPermission('create-special_numbers_organizations')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('special-number-organizations.create')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('special-number-organizations.create') ? 'active' : ''); ?>">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p><?php echo e(__('words.create')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </li>
                                        <?php endif; ?>
                                        
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-wenches')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('wenches.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('wenches.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-truck-loading"></i>
                                        <p>
                                            <?php echo e(__('words.wenches')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-wenches')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('wenches.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('wenches.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-wenches')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('wenches.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('wenches.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            <hr class="mt-2 mb-3 sidebar-divider"/>

                            
                            <?php if(auth('admin')->user()->hasPermission(['read-garages','read-technical_inspection_centers','read-tire_exchange_centers','read-accessories_stores','read-car_washes','read-mining_centers'])): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('garages.*','inspection-centers.*','tire-exchange-centers.*','accessories-stores.*','car-washes.*','mining-centers.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('garages.*','inspection-centers.*','tire-exchange-centers.*','accessories-stores.*','car-washes.*','mining-centers.*') ? 'active' : ''); ?>">
                                        <i class="fas fa-tools"></i>
                                        <p>
                                            <?php echo e(__('words.AutoServiceCenters')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>

                                    <ul class="nav nav-treeview">
                                        
                                        <?php if(auth('admin')->user()->hasPermission('read-garages')): ?>
                                            <li class="nav-item <?php echo e(request()->routeIs('garages.*') ? 'menu-open' : ''); ?>">
                                                <a href="#"
                                                   class="nav-link <?php echo e(request()->routeIs('garages.*') ? 'sub-menu active' : ''); ?>">
                                                    <i class="fas fa-warehouse"></i>
                                                    <p>
                                                        <?php echo e(__('words.garages')); ?>

                                                        <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    <?php if(auth('admin')->user()->hasPermission('read-garages')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('garages.index')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('garages.index') ? 'active' : ''); ?>">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p><?php echo e(__('words.show_all')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if(auth('admin')->user()->hasPermission('create-garages')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('garages.create')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('garages.create') ? 'active' : ''); ?>">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p><?php echo e(__('words.create')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </li>
                                        <?php endif; ?>
                                        

                                        
                                        <?php if(auth('admin')->user()->hasPermission('read-technical_inspection_centers')): ?>
                                            <li class="nav-item <?php echo e(request()->routeIs('inspection-centers.*') ? 'menu-open' : ''); ?>">
                                                <a href="#"
                                                   class="nav-link <?php echo e(request()->routeIs('inspection-centers.*') ? 'sub-menu active' : ''); ?>">
                                                    <i class="fas fa-toolbox"></i>
                                                    <p>
                                                        <?php echo e(__('words.technical_inspection_centers')); ?>

                                                        <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    <?php if(auth('admin')->user()->hasPermission('read-technical_inspection_centers')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('inspection-centers.index')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('inspection-centers.index') ? 'active' : ''); ?>">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p><?php echo e(__('words.show_all')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if(auth('admin')->user()->hasPermission('create-technical_inspection_centers')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('inspection-centers.create')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('inspection-centers.create') ? 'active' : ''); ?>">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p><?php echo e(__('words.create')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </li>
                                        <?php endif; ?>
                                        

                                        
                                        <?php if(auth('admin')->user()->hasPermission('read-tire_exchange_centers')): ?>
                                            <li class="nav-item <?php echo e(request()->routeIs('tire-exchange-centers.*') ? 'menu-open' : ''); ?>">
                                                <a href="#"
                                                   class="nav-link <?php echo e(request()->routeIs('tire-exchange-centers.*') ? 'sub-menu active' : ''); ?>">
                                                    <i class="fas fa-truck-monster"></i>
                                                    <p>
                                                        <?php echo e(__('words.tire_exchange_centers')); ?>

                                                        <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    <?php if(auth('admin')->user()->hasPermission('read-tire_exchange_centers')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('tire-exchange-centers.index')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('tire-exchange-centers.index') ? 'active' : ''); ?>">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p><?php echo e(__('words.show_all')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if(auth('admin')->user()->hasPermission('create-tire_exchange_centers')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('tire-exchange-centers.create')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('tire-exchange-centers.create') ? 'active' : ''); ?>">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p><?php echo e(__('words.create')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </li>
                                        <?php endif; ?>
                                        

                                        
                                        <?php if(auth('admin')->user()->hasPermission('read-accessories_stores')): ?>
                                            <li class="nav-item <?php echo e(request()->routeIs('accessories-stores.*') ? 'menu-open' : ''); ?>">
                                                <a href="#"
                                                   class="nav-link <?php echo e(request()->routeIs('accessories-stores.*') ? 'sub-menu active' : ''); ?>">
                                                    <i class="fas fa-store-alt"></i>
                                                    <p>
                                                        <?php echo e(__('words.accessories_stores')); ?>

                                                        <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    <?php if(auth('admin')->user()->hasPermission('read-accessories_stores')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('accessories-stores.index')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('accessories-stores.index') ? 'active' : ''); ?>">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p><?php echo e(__('words.show_all')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if(auth('admin')->user()->hasPermission('create-accessories_stores')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('accessories-stores.create')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('accessories-stores.create') ? 'active' : ''); ?>">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p><?php echo e(__('words.create')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </li>
                                        <?php endif; ?>
                                        

                                        
                                        <?php if(auth('admin')->user()->hasPermission('read-car_washes')): ?>
                                            <li class="nav-item <?php echo e(request()->routeIs('car-washes.*') ? 'menu-open' : ''); ?>">
                                                <a href="#"
                                                   class="nav-link <?php echo e(request()->routeIs('car-washes.*') ? 'sub-menu active' : ''); ?>">
                                                    <i class="fas fa-shower"></i>
                                                    <p>
                                                        <?php echo e(__('words.car_washes')); ?>

                                                        <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    <?php if(auth('admin')->user()->hasPermission('read-car_washes')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('car-washes.index')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('car-washes.index') ? 'active' : ''); ?>">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p><?php echo e(__('words.show_all')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if(auth('admin')->user()->hasPermission('create-car_washes')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('car-washes.create')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('car-washes.create') ? 'active' : ''); ?>">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p><?php echo e(__('words.create')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </li>
                                        <?php endif; ?>
                                        

                                        
                                        <?php if(auth('admin')->user()->hasPermission('read-mining_centers')): ?>
                                            <li class="nav-item <?php echo e(request()->routeIs('mining-centers.*') ? 'menu-open' : ''); ?>">
                                                <a href="#"
                                                   class="nav-link <?php echo e(request()->routeIs('mining-centers.*') ? 'sub-menu active' : ''); ?>">
                                                    <i class="fas fa-charging-station"></i>
                                                    <p>
                                                        <?php echo e(__('words.mining_centers')); ?>

                                                        <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    <?php if(auth('admin')->user()->hasPermission('read-mining_centers')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('mining-centers.index')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('mining-centers.index') ? 'active' : ''); ?>">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p><?php echo e(__('words.show_all')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if(auth('admin')->user()->hasPermission('create-mining_centers')): ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo e(route('mining-centers.create')); ?>"
                                                               class="nav-link <?php echo e(request()->routeIs('mining-centers.create') ? 'active' : ''); ?>">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p><?php echo e(__('words.create')); ?></p>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </li>
                                        <?php endif; ?>
                                        
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            <hr class="mt-2 mb-3 sidebar-divider"/>

                            
                            <?php if(auth('admin')->user()->hasPermission('read-insurance_companies')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('insurance_companies.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('insurance_companies.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-car-crash"></i>
                                        <p>
                                            <?php echo e(__('words.insurance_companies')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-insurance_companies')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('insurance_companies.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('insurance_companies.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-insurance_companies')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('insurance_companies.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('insurance_companies.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-brokers')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('brokers.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('brokers.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="far fa-handshake"></i>
                                        <p>
                                            <?php echo e(__('words.brokers')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-brokers')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('brokers.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('brokers.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-brokers')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('brokers.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('brokers.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-delivery')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('delivery.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('delivery.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-truck"></i>
                                        <p>
                                            <?php echo e(__('words.delivery')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-delivery')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('delivery.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('delivery.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-delivery')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('delivery.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('delivery.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-driving_trainers')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('trainers.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('trainers.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-car-side"></i>
                                        <p>
                                            <?php echo e(__('words.driving_trainers')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-driving_trainers')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('trainers.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('trainers.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-driving_trainers')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('trainers.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('trainers.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-fuel_stations')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('fuel-stations.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('fuel-stations.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-gas-pump"></i>
                                        <p>
                                            <?php echo e(__('words.fuel_stations')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-fuel_stations')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('fuel-stations.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('fuel-stations.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-fuel_stations')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('fuel-stations.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('fuel-stations.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            

                            
                            <?php if(auth('admin')->user()->hasPermission('read-traffic_clearing_offices')): ?>
                                <li class="nav-item <?php echo e(request()->routeIs('traffic-clearing-offices.*') ? 'menu-open' : ''); ?>">
                                    <a href="#"
                                       class="nav-link <?php echo e(request()->routeIs('traffic-clearing-offices.*') ? 'sub-menu active' : ''); ?>">
                                        <i class="fas fa-traffic-light"></i>
                                        <p>
                                            <?php echo e(__('words.traffic_clearing_offices')); ?>

                                            <i class="<?php echo e(app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'); ?>"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if(auth('admin')->user()->hasPermission('read-traffic_clearing_offices')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('traffic-clearing-offices.index')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('traffic-clearing-offices.index') ? 'active' : ''); ?>">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p><?php echo e(__('words.show_all')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(auth('admin')->user()->hasPermission('create-traffic_clearing_offices')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('traffic-clearing-offices.create')); ?>"
                                                   class="nav-link <?php echo e(request()->routeIs('traffic-clearing-offices.create') ? 'active' : ''); ?>">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p><?php echo e(__('words.create')); ?></p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            
                        </ul>
                    </li>

                <?php endif; ?>
                

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php /**PATH D:\xampp\htdocs\mawatery-web\resources\views/admin/includes/sidebar.blade.php ENDPATH**/ ?>