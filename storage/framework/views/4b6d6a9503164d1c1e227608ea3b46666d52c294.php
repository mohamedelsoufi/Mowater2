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
                <a href="#"
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
                
                <?php if(auth('admin')->user()->hasPermission(['read-admins','read-roles'])): ?>
                    <li class="nav-item <?php echo e(request()->routeIs('admin-roles.*','admin-users.*') ? 'menu-open' : ''); ?>">
                        <a href="#"
                           class="nav-link <?php echo e(request()->routeIs('admin-roles.*','admin-users.*') ? 'active' : ''); ?>">
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
                        </ul>
                    </li>
                <?php endif; ?>
                

                
                <?php if(auth('admin')->user()->hasPermission(['read-brands','read-car_models','read-car_classes','read-manufacture_countries'])): ?>
                    <li class="nav-item <?php echo e(request()->routeIs('brands.*','car-models.*','car-classes.*','manufacture-countries.*') ? 'menu-open' : ''); ?>">
                        <a href="#"
                           class="nav-link <?php echo e(request()->routeIs('brands.*','car-models.*','car-classes.*','manufacture-countries.*') ? 'active' : ''); ?>">
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
                

                
                <?php if(auth('admin')->user()->hasPermission(['read-sections','read-categories','read-sub_categories','read-currencies','payment_methods','app_sliders','discount_cards','colors'])): ?>
                    <li class="nav-item <?php echo e(request()->routeIs('sections.*','categories.*','sub-categories.*','currencies.*','payment-methods.*','app-sliders.*','discount-cards.*','colors.*') ? 'menu-open' : ''); ?>">
                        <a href="#"
                           class="nav-link <?php echo e(request()->routeIs('sections.*','categories.*','sub-categories.*','currencies.*','payment-methods.*','app-sliders.*','discount-cards.*','colors.*') ? 'active' : ''); ?>">
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
                

                
                <?php if(auth('admin')->user()->hasPermission(['read-special_numbers_organizations','read-special_numbers'])): ?>
                    <li class="nav-item <?php echo e(request()->routeIs('special-number-organizations.*','special-numbers.*') ? 'menu-open' : ''); ?>">
                        <a href="#"
                           class="nav-link <?php echo e(request()->routeIs('special-number-organizations.*','special-numbers.*') ? 'active' : ''); ?>">
                            <i class="fas fa-place-of-worship"></i>
                            <p>
                                <?php echo e(__('words.organizations')); ?>

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
                

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php /**PATH D:\xampp\htdocs\mawatery-web\resources\views/admin/includes/sidebar.blade.php ENDPATH**/ ?>