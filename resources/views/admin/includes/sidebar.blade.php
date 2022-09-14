<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.home')}}" class="brand-link">
        <img src="{{asset('logo.png')}}" alt="Mowater Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{__('words.mowater')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('no-user.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('admin-users.show',auth('admin')->user()->id)}}"
                   class="d-block">{{auth('admin')->user()->first_name .' '. auth('admin')->user()->last_name}}</a>
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
                {{-- Users details toggle start --}}
                @if(auth('admin')->user()->hasPermission(['read-admins','read-roles','read-app_users','read-org_users']))
                    <li class="nav-item {{ request()->routeIs('admin-roles.*','admin-users.*','app-users.*','org-users.*') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->routeIs('admin-roles.*','admin-users.*','app-users.*','org-users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                {{__('words.users')}}
                                <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview level">
                            <!-- Permissions Users Start -->
                            @if(auth('admin')->user()->hasPermission('read-roles'))
                                <li class="nav-item {{ request()->routeIs('admin-roles.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('admin-roles.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-universal-access"></i>
                                        <p>
                                            {{__('words.permissions')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-roles'))
                                            <li class="nav-item">
                                                <a href="{{route('admin-roles.index')}}"
                                                   class="nav-link {{ request()->routeIs('admin-roles.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-roles'))
                                            <li class="nav-item">
                                                <a href="{{route('admin-roles.create')}}"
                                                   class="nav-link {{ request()->routeIs('admin-roles.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            <!-- Permissions Users end -->

                            <!-- Admin Users Start -->
                            @if(auth('admin')->user()->hasPermission('read-admins'))
                                <li class="nav-item {{ request()->routeIs('admin-users.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('admin-users.*') ? 'sub-menu active' : '' }}">
                                        <i class="nav-icon fas fa-user"></i>
                                        <p>
                                            {{__('words.admin_users')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-admins'))
                                            <li class="nav-item">
                                                <a href="{{route('admin-users.index')}}"
                                                   class="nav-link {{ request()->routeIs('admin-users.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-admins'))
                                            <li class="nav-item">
                                                <a href="{{route('admin-users.create')}}"
                                                   class="nav-link {{ request()->routeIs('admin-users.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            <!-- Admin Users end -->

                            <!-- App Users Start -->
                            @if(auth('admin')->user()->hasPermission('read-app_users'))
                                <li class="nav-item {{ request()->routeIs('app-users.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('app-users.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-mobile"></i>
                                        <p>
                                            {{__('words.app_users')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-app_users'))
                                            <li class="nav-item">
                                                <a href="{{route('app-users.index')}}"
                                                   class="nav-link {{ request()->routeIs('app-users.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            <!-- App Users end -->

                            <!-- Organization Users Start -->
                            @if(auth('admin')->user()->hasPermission('read-org_users'))
                                <li class="nav-item {{ request()->routeIs('org-users.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('org-users.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-place-of-worship"></i>
                                        <p>
                                            {{__('words.org_users')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-org_users'))
                                            <li class="nav-item">
                                                <a href="{{route('org-users.index')}}"
                                                   class="nav-link {{ request()->routeIs('org-users.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                        @endif
                            <!-- Organization Users end -->
                        </ul>
                    </li>
                @endif
                {{-- Users details toggle end --}}

                {{-- Vehicle details toggle start --}}
                @if(auth('admin')->user()->hasPermission(['read-brands','read-car_models','read-car_classes','read-manufacture_countries','read-used_vehicles']))
                    <li class="nav-item {{ request()->routeIs('brands.*','car-models.*','car-classes.*','manufacture-countries.*','used-vehicles.*') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->routeIs('brands.*','car-models.*','car-classes.*','manufacture-countries.*','used-vehicles.*') ? 'active' : '' }}">
                            <i class="fa fa-car"></i>
                            <p>
                                {{__('words.vehicles_details')}}
                                <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            {{-- Brand routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-brands'))
                                <li class="nav-item {{ request()->routeIs('brands.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('brands.*') ? 'sub-menu active' : '' }}">
                                        <i class="fa fa-circle-notch"></i>
                                        <p>
                                            {{__('words.brands')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-brands'))
                                            <li class="nav-item">
                                                <a href="{{route('brands.index')}}"
                                                   class="nav-link {{ request()->routeIs('brands.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-brands'))
                                            <li class="nav-item">
                                                <a href="{{route('brands.create')}}"
                                                   class="nav-link {{ request()->routeIs('brands.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Brand routes end --}}

                            {{-- Car models routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-car_models'))
                                <li class="nav-item {{ request()->routeIs('car-models.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('car-models.*') ? 'sub-menu active' : '' }}">
                                        <i class="fa fa-star"></i>
                                        <p>
                                            {{__('words.car_model')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-car_models'))
                                            <li class="nav-item">
                                                <a href="{{route('car-models.index')}}"
                                                   class="nav-link {{ request()->routeIs('car-models.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-car_models'))
                                            <li class="nav-item">
                                                <a href="{{route('car-models.create')}}"
                                                   class="nav-link {{ request()->routeIs('car-models.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Car models routes end --}}

                            {{-- Car class routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-car_classes'))
                                <li class="nav-item {{ request()->routeIs('car-classes.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('car-classes.*') ? 'sub-menu active' : '' }}">
                                        <i class="fa fa-list-ol"></i>
                                        <p>
                                            {{__('words.car_class')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-car_classes'))
                                            <li class="nav-item">
                                                <a href="{{route('car-classes.index')}}"
                                                   class="nav-link {{ request()->routeIs('car-classes.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                        @if(auth('admin')->user()->hasPermission('create-car_classes'))
                                            <li class="nav-item">
                                                <a href="{{route('car-classes.create')}}"
                                                   class="nav-link {{ request()->routeIs('car-classes.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Car class routes end --}}

                            {{-- Manufaturing countries routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-manufacture_countries'))
                                <li class="nav-item {{ request()->routeIs('manufacture-countries.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('manufacture-countries.*') ? 'sub-menu active' : '' }}">
                                        <i class="fa fa-industry"></i>
                                        <p>
                                            {{__('words.manufacture_countries')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-manufacture_countries'))
                                            <li class="nav-item">
                                                <a href="{{route('manufacture-countries.index')}}"
                                                   class="nav-link {{ request()->routeIs('manufacture-countries.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-manufacture_countries'))
                                            <li class="nav-item">
                                                <a href="{{route('manufacture-countries.create')}}"
                                                   class="nav-link {{ request()->routeIs('manufacture-countries.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Manufaturing countries routes end --}}

                            {{-- Used Vehicles For Sale routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-used_vehicles'))
                                <li class="nav-item {{ request()->routeIs('used-vehicles.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('used-vehicles.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-car"></i>
                                        <p>
                                            {{__('words.used_vehicles')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-used_vehicles'))
                                            <li class="nav-item">
                                                <a href="{{route('used-vehicles.index')}}"
                                                   class="nav-link {{ request()->routeIs('used-vehicles.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-used_vehicles'))
                                            <li class="nav-item">
                                                <a href="{{route('used-vehicles.create')}}"
                                                   class="nav-link {{ request()->routeIs('used-vehicles.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Used Vehicles For Sale routes end --}}
                        </ul>
                    </li>
                @endif
                {{-- Vehicle details toggle end --}}

                {{-- Location toggle start --}}
                @if(auth('admin')->user()->hasPermission(['read-countries','read-cities','read-areas']))
                    <li class="nav-item {{ request()->routeIs('countries.*','cities.*','areas.*') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->routeIs('countries.*','cities.*','areas.*') ? 'active' : '' }}">
                            <i class="fa fa-globe"></i>
                            <p>
                                {{__('words.location')}}
                                <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            {{-- Country routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-countries'))
                                <li class="nav-item {{ request()->routeIs('countries.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('countries.*') ? 'sub-menu active' : '' }}">
                                        <i class="fa fa-flag"></i>
                                        <p>
                                            {{__('words.countries')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-countries'))
                                            <li class="nav-item">
                                                <a href="{{route('countries.index')}}"
                                                   class="nav-link {{ request()->routeIs('countries.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                        @if(auth('admin')->user()->hasPermission('create-countries'))
                                            <li class="nav-item">
                                                <a href="{{route('countries.create')}}"
                                                   class="nav-link {{ request()->routeIs('countries.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Country routes end --}}

                            {{-- City routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-cities'))
                                <li class="nav-item {{ request()->routeIs('cities.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('cities.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-place-of-worship"></i>
                                        <p>
                                            {{__('words.cities')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-cities'))
                                            <li class="nav-item">
                                                <a href="{{route('cities.index')}}"
                                                   class="nav-link {{ request()->routeIs('cities.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-cities'))
                                            <li class="nav-item">
                                                <a href="{{route('cities.create')}}"
                                                   class="nav-link {{ request()->routeIs('cities.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- City routes end --}}

                            {{-- Area routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-areas'))
                                <li class="nav-item {{ request()->routeIs('areas.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('areas.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-home"></i>
                                        <p>
                                            {{__('words.areas')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-areas'))
                                            <li class="nav-item">
                                                <a href="{{route('areas.index')}}"
                                                   class="nav-link {{ request()->routeIs('areas.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-areas'))
                                            <li class="nav-item">
                                                <a href="{{route('areas.create')}}"
                                                   class="nav-link {{ request()->routeIs('areas.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Area routes end --}}

                        </ul>
                    </li>
                @endif
                {{-- Location toggle end --}}

                {{-- General toggle start --}}
                @if(auth('admin')->user()->hasPermission(['read-sections','read-categories','read-sub_categories','read-currencies','payment_methods','app_sliders','discount_cards','colors']))
                    <li class="nav-item {{ request()->routeIs('sections.*','categories.*','sub-categories.*','currencies.*','payment-methods.*','app-sliders.*','discount-cards.*','colors.*') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->routeIs('sections.*','categories.*','sub-categories.*','currencies.*','payment-methods.*','app-sliders.*','discount-cards.*','colors.*') ? 'active' : '' }}">
                            <i class="fas fa-sliders-h"></i>
                            <p>
                                {{__('words.general')}}
                                <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            {{-- Discount Card routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-discount_cards'))
                                <li class="nav-item {{ request()->routeIs('discount-cards.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('discount-cards.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-donate"></i>
                                        <p>
                                            {{__('words.discount_cards')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-discount_cards'))
                                            <li class="nav-item">
                                                <a href="{{route('discount-cards.index')}}"
                                                   class="nav-link {{ request()->routeIs('discount-cards.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-discount_cards'))
                                            <li class="nav-item">
                                                <a href="{{route('discount-cards.create')}}"
                                                   class="nav-link {{ request()->routeIs('discount-cards.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Discount Card routes end --}}

                            {{-- Section routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-sections'))
                                <li class="nav-item {{ request()->routeIs('sections.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('sections.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-th-list"></i>
                                        <p>
                                            {{__('words.sections')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-sections'))
                                            <li class="nav-item">
                                                <a href="{{route('sections.index')}}"
                                                   class="nav-link {{ request()->routeIs('sections.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Section routes end --}}

                            {{-- Category routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-categories'))
                                <li class="nav-item {{ request()->routeIs('categories.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('categories.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-bars"></i>
                                        <p>
                                            {{__('words.categories')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-categories'))
                                            <li class="nav-item">
                                                <a href="{{route('categories.index')}}"
                                                   class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-categories'))
                                            <li class="nav-item">
                                                <a href="{{route('categories.create')}}"
                                                   class="nav-link {{ request()->routeIs('categories.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Category routes end --}}

                            {{-- Sub Category routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-sub_categories'))
                                <li class="nav-item {{ request()->routeIs('sub-categories.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('sub-categories.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-folder"></i>
                                        <p>
                                            {{__('words.sub_categories')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-sub_categories'))
                                            <li class="nav-item">
                                                <a href="{{route('sub-categories.index')}}"
                                                   class="nav-link {{ request()->routeIs('sub-categories.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-sub_categories'))
                                            <li class="nav-item">
                                                <a href="{{route('sub-categories.create')}}"
                                                   class="nav-link {{ request()->routeIs('sub-categories.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Sub Category routes end --}}

                            {{-- Currency routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-currencies'))
                                <li class="nav-item {{ request()->routeIs('currencies.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('currencies.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-dollar-sign"></i>
                                        <p>
                                            {{__('words.currencies')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-currencies'))
                                            <li class="nav-item">
                                                <a href="{{route('currencies.index')}}"
                                                   class="nav-link {{ request()->routeIs('currencies.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-currencies'))
                                            <li class="nav-item">
                                                <a href="{{route('currencies.create')}}"
                                                   class="nav-link {{ request()->routeIs('currencies.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Currency routes end --}}

                            {{-- Payment method routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-payment_methods'))
                                <li class="nav-item {{ request()->routeIs('payment-methods.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('payment-methods.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-credit-card"></i>
                                        <p>
                                            {{__('words.payment_methods')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-payment_methods'))
                                            <li class="nav-item">
                                                <a href="{{route('payment-methods.index')}}"
                                                   class="nav-link {{ request()->routeIs('payment-methods.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-payment_methods'))
                                            <li class="nav-item">
                                                <a href="{{route('payment-methods.create')}}"
                                                   class="nav-link {{ request()->routeIs('payment-methods.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Payment method routes end --}}

                            {{-- App Sliders routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-app_sliders'))
                                <li class="nav-item {{ request()->routeIs('app-sliders.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('app-sliders.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-photo-video"></i>
                                        <p>
                                            {{__('words.app_sliders')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-app_sliders'))
                                            <li class="nav-item">
                                                <a href="{{route('app-sliders.index')}}"
                                                   class="nav-link {{ request()->routeIs('app-sliders.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- App Sliders routes end --}}

                            {{-- Color routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-colors'))
                                <li class="nav-item {{ request()->routeIs('colors.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('colors.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-palette"></i>
                                        <p>
                                            {{__('words.colors')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-colors'))
                                            <li class="nav-item">
                                                <a href="{{route('colors.index')}}"
                                                   class="nav-link {{ request()->routeIs('colors.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-colors'))
                                            <li class="nav-item">
                                                <a href="{{route('colors.create')}}"
                                                   class="nav-link {{ request()->routeIs('colors.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Color routes end --}}
                        </ul>
                    </li>
                @endif
                {{-- General toggle end --}}

                {{-- Organizations toggle start --}}
                @if(auth('admin')->user()->hasPermission(['read-special_numbers_organizations','read-special_numbers','read-agencies','read-car_showrooms','read-rental_offices','read-wenches','read-insurance_companies','read-brokers','read-delivery','read-driving_trainers','read-fuel_stations','read-traffic_clearing_offices','read-garages','read-technical_inspection_centers','read-tire_exchange_centers','read-accessories_stores','read-car_washes','read-mining_centers']))
                    <li class="nav-item {{ request()->routeIs('special-number-organizations.*','special-numbers.*','agencies.*','car-showrooms.*','rental-offices.*','wenches.*','insurance_companies.*','brokers.*','delivery.*','trainers.*','fuel-stations.*','traffic-clearing-offices.*','garages.*','inspection-centers.*','tire-exchange-centers.*','accessories-stores.*','car-washes.*','mining-centers.*') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->routeIs('special-number-organizations.*','special-numbers.*','agencies.*','car-showrooms.*','rental-offices.*','wenches.*','insurance_companies.*','brokers.*','delivery.*','trainers.*','fuel-stations.*','traffic-clearing-offices.*','garages.*','inspection-centers.*','tire-exchange-centers.*','accessories-stores.*','car-washes.*','mining-centers.*') ? 'active' : '' }}">
                            <i class="fas fa-place-of-worship"></i>
                            <p>
                                {{__('words.organizations')}}
                                <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            {{-- Agency routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-agencies'))
                                <li class="nav-item {{ request()->routeIs('agencies.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('agencies.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-peace"></i>
                                        <p>
                                            {{__('words.agencies')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-agencies'))
                                            <li class="nav-item">
                                                <a href="{{route('agencies.index')}}"
                                                   class="nav-link {{ request()->routeIs('agencies.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-agencies'))
                                            <li class="nav-item">
                                                <a href="{{route('agencies.create')}}"
                                                   class="nav-link {{ request()->routeIs('agencies.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Agency routes end --}}

                            {{-- Car Showroom routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-car_showrooms'))
                                <li class="nav-item {{ request()->routeIs('car-showrooms.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('car-showrooms.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-store"></i>
                                        <p>
                                            {{__('words.car_showrooms')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-car_showrooms'))
                                            <li class="nav-item">
                                                <a href="{{route('car-showrooms.index')}}"
                                                   class="nav-link {{ request()->routeIs('car-showrooms.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-car_showrooms'))
                                            <li class="nav-item">
                                                <a href="{{route('car-showrooms.create')}}"
                                                   class="nav-link {{ request()->routeIs('car-showrooms.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Car Showroom routes end --}}

                            {{-- Rental Office routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-rental_offices'))
                                <li class="nav-item {{ request()->routeIs('rental-offices.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('rental-offices.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-handshake"></i>
                                        <p>
                                            {{__('words.rental_offices')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-rental_offices'))
                                            <li class="nav-item">
                                                <a href="{{route('rental-offices.index')}}"
                                                   class="nav-link {{ request()->routeIs('rental-offices.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-rental_offices'))
                                            <li class="nav-item">
                                                <a href="{{route('rental-offices.create')}}"
                                                   class="nav-link {{ request()->routeIs('rental-offices.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Rental Office routes end --}}

                            {{-- Special numbers routes start --}}
                            @if(auth('admin')->user()->hasPermission(['read-special_numbers_organizations','read-special_numbers']))
                                <li class="nav-item {{ request()->routeIs('special-number-organizations.*','special-numbers.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('special-number-organizations.*','special-numbers.*') ? 'active' : '' }}">
                                        <i class="fas fa-sort-numeric-down"></i>
                                        <p>
                                            {{__('words.special_numbers')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>

                                    <ul class="nav nav-treeview">
                                        {{-- Special numbers routes start --}}
                                        @if(auth('admin')->user()->hasPermission('read-special_numbers'))
                                            <li class="nav-item {{ request()->routeIs('special-numbers.*') ? 'menu-open' : '' }}">
                                                <a href="#"
                                                   class="nav-link {{ request()->routeIs('special-numbers.*') ? 'sub-menu active' : '' }}">
                                                    <i class="fas fa-award"></i>
                                                    <p>
                                                        {{__('words.special_numbers')}}
                                                        <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    @if(auth('admin')->user()->hasPermission('read-special_numbers'))
                                                        <li class="nav-item">
                                                            <a href="{{route('special-numbers.index')}}"
                                                               class="nav-link {{ request()->routeIs('special-numbers.index') ? 'active' : '' }}">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p>{{__('words.show_all')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if(auth('admin')->user()->hasPermission('create-special_numbers'))
                                                        <li class="nav-item">
                                                            <a href="{{route('special-numbers.create')}}"
                                                               class="nav-link {{ request()->routeIs('special-numbers.create') ? 'active' : '' }}">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p>{{__('words.create')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </li>
                                        @endif
                                        {{-- Special numbers routes end --}}

                                        {{-- Special numbers organization routes start --}}
                                        @if(auth('admin')->user()->hasPermission('read-special_numbers_organizations'))
                                            <li class="nav-item {{ request()->routeIs('special-number-organizations.*') ? 'menu-open' : '' }}">
                                                <a href="#"
                                                   class="nav-link {{ request()->routeIs('special-number-organizations.*') ? 'sub-menu active' : '' }}">
                                                    <i class="fas fa-archway"></i>
                                                    <p>
                                                        {{__('words.special_numbers_organizations')}}
                                                        <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    @if(auth('admin')->user()->hasPermission('read-special_numbers_organizations'))
                                                        <li class="nav-item">
                                                            <a href="{{route('special-number-organizations.index')}}"
                                                               class="nav-link {{ request()->routeIs('special-number-organizations.index') ? 'active' : '' }}">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p>{{__('words.show_all')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if(auth('admin')->user()->hasPermission('create-special_numbers_organizations'))
                                                        <li class="nav-item">
                                                            <a href="{{route('special-number-organizations.create')}}"
                                                               class="nav-link {{ request()->routeIs('special-number-organizations.create') ? 'active' : '' }}">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p>{{__('words.create')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </li>
                                        @endif
                                        {{-- Special numbers organization routes end --}}
                                    </ul>
                                </li>
                            @endif
                            {{-- Special numbers routes end --}}

                            {{-- Wench routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-wenches'))
                                <li class="nav-item {{ request()->routeIs('wenches.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('wenches.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-truck-loading"></i>
                                        <p>
                                            {{__('words.wenches')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-wenches'))
                                            <li class="nav-item">
                                                <a href="{{route('wenches.index')}}"
                                                   class="nav-link {{ request()->routeIs('wenches.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-wenches'))
                                            <li class="nav-item">
                                                <a href="{{route('wenches.create')}}"
                                                   class="nav-link {{ request()->routeIs('wenches.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Wench routes end --}}

                            <hr class="mt-2 mb-3 sidebar-divider"/>

                            {{-- Auto Service Centers routes start --}}
                            @if(auth('admin')->user()->hasPermission(['read-garages','read-technical_inspection_centers','read-tire_exchange_centers','read-accessories_stores','read-car_washes','read-mining_centers']))
                                <li class="nav-item {{ request()->routeIs('garages.*','inspection-centers.*','tire-exchange-centers.*','accessories-stores.*','car-washes.*','mining-centers.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('garages.*','inspection-centers.*','tire-exchange-centers.*','accessories-stores.*','car-washes.*','mining-centers.*') ? 'active' : '' }}">
                                        <i class="fas fa-tools"></i>
                                        <p>
                                            {{__('words.AutoServiceCenters')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>

                                    <ul class="nav nav-treeview">
                                        {{-- Garage routes start --}}
                                        @if(auth('admin')->user()->hasPermission('read-garages'))
                                            <li class="nav-item {{ request()->routeIs('garages.*') ? 'menu-open' : '' }}">
                                                <a href="#"
                                                   class="nav-link {{ request()->routeIs('garages.*') ? 'sub-menu active' : '' }}">
                                                    <i class="fas fa-warehouse"></i>
                                                    <p>
                                                        {{__('words.garages')}}
                                                        <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    @if(auth('admin')->user()->hasPermission('read-garages'))
                                                        <li class="nav-item">
                                                            <a href="{{route('garages.index')}}"
                                                               class="nav-link {{ request()->routeIs('garages.index') ? 'active' : '' }}">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p>{{__('words.show_all')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if(auth('admin')->user()->hasPermission('create-garages'))
                                                        <li class="nav-item">
                                                            <a href="{{route('garages.create')}}"
                                                               class="nav-link {{ request()->routeIs('garages.create') ? 'active' : '' }}">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p>{{__('words.create')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </li>
                                        @endif
                                        {{-- Garage routes end --}}

                                        {{-- Technical Inspection Center routes start --}}
                                        @if(auth('admin')->user()->hasPermission('read-technical_inspection_centers'))
                                            <li class="nav-item {{ request()->routeIs('inspection-centers.*') ? 'menu-open' : '' }}">
                                                <a href="#"
                                                   class="nav-link {{ request()->routeIs('inspection-centers.*') ? 'sub-menu active' : '' }}">
                                                    <i class="fas fa-toolbox"></i>
                                                    <p>
                                                        {{__('words.technical_inspection_centers')}}
                                                        <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    @if(auth('admin')->user()->hasPermission('read-technical_inspection_centers'))
                                                        <li class="nav-item">
                                                            <a href="{{route('inspection-centers.index')}}"
                                                               class="nav-link {{ request()->routeIs('inspection-centers.index') ? 'active' : '' }}">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p>{{__('words.show_all')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if(auth('admin')->user()->hasPermission('create-technical_inspection_centers'))
                                                        <li class="nav-item">
                                                            <a href="{{route('inspection-centers.create')}}"
                                                               class="nav-link {{ request()->routeIs('inspection-centers.create') ? 'active' : '' }}">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p>{{__('words.create')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </li>
                                        @endif
                                        {{-- Technical Inspection Center routes end --}}

                                        {{-- Tire Exchange Center routes start --}}
                                        @if(auth('admin')->user()->hasPermission('read-tire_exchange_centers'))
                                            <li class="nav-item {{ request()->routeIs('tire-exchange-centers.*') ? 'menu-open' : '' }}">
                                                <a href="#"
                                                   class="nav-link {{ request()->routeIs('tire-exchange-centers.*') ? 'sub-menu active' : '' }}">
                                                    <i class="fas fa-truck-monster"></i>
                                                    <p>
                                                        {{__('words.tire_exchange_centers')}}
                                                        <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    @if(auth('admin')->user()->hasPermission('read-tire_exchange_centers'))
                                                        <li class="nav-item">
                                                            <a href="{{route('tire-exchange-centers.index')}}"
                                                               class="nav-link {{ request()->routeIs('tire-exchange-centers.index') ? 'active' : '' }}">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p>{{__('words.show_all')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if(auth('admin')->user()->hasPermission('create-tire_exchange_centers'))
                                                        <li class="nav-item">
                                                            <a href="{{route('tire-exchange-centers.create')}}"
                                                               class="nav-link {{ request()->routeIs('tire-exchange-centers.create') ? 'active' : '' }}">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p>{{__('words.create')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </li>
                                        @endif
                                        {{-- Tire Exchange Center routes end --}}

                                        {{-- Accessories Store routes start --}}
                                        @if(auth('admin')->user()->hasPermission('read-accessories_stores'))
                                            <li class="nav-item {{ request()->routeIs('accessories-stores.*') ? 'menu-open' : '' }}">
                                                <a href="#"
                                                   class="nav-link {{ request()->routeIs('accessories-stores.*') ? 'sub-menu active' : '' }}">
                                                    <i class="fas fa-store-alt"></i>
                                                    <p>
                                                        {{__('words.accessories_stores')}}
                                                        <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    @if(auth('admin')->user()->hasPermission('read-accessories_stores'))
                                                        <li class="nav-item">
                                                            <a href="{{route('accessories-stores.index')}}"
                                                               class="nav-link {{ request()->routeIs('accessories-stores.index') ? 'active' : '' }}">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p>{{__('words.show_all')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if(auth('admin')->user()->hasPermission('create-accessories_stores'))
                                                        <li class="nav-item">
                                                            <a href="{{route('accessories-stores.create')}}"
                                                               class="nav-link {{ request()->routeIs('accessories-stores.create') ? 'active' : '' }}">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p>{{__('words.create')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </li>
                                        @endif
                                        {{-- Accessories Store routes end --}}

                                        {{-- Car Wash routes start --}}
                                        @if(auth('admin')->user()->hasPermission('read-car_washes'))
                                            <li class="nav-item {{ request()->routeIs('car-washes.*') ? 'menu-open' : '' }}">
                                                <a href="#"
                                                   class="nav-link {{ request()->routeIs('car-washes.*') ? 'sub-menu active' : '' }}">
                                                    <i class="fas fa-shower"></i>
                                                    <p>
                                                        {{__('words.car_washes')}}
                                                        <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    @if(auth('admin')->user()->hasPermission('read-car_washes'))
                                                        <li class="nav-item">
                                                            <a href="{{route('car-washes.index')}}"
                                                               class="nav-link {{ request()->routeIs('car-washes.index') ? 'active' : '' }}">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p>{{__('words.show_all')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if(auth('admin')->user()->hasPermission('create-car_washes'))
                                                        <li class="nav-item">
                                                            <a href="{{route('car-washes.create')}}"
                                                               class="nav-link {{ request()->routeIs('car-washes.create') ? 'active' : '' }}">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p>{{__('words.create')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </li>
                                        @endif
                                        {{-- Car Wash routes end --}}

                                        {{-- Mining Center routes start --}}
                                        @if(auth('admin')->user()->hasPermission('read-mining_centers'))
                                            <li class="nav-item {{ request()->routeIs('mining-centers.*') ? 'menu-open' : '' }}">
                                                <a href="#"
                                                   class="nav-link {{ request()->routeIs('mining-centers.*') ? 'sub-menu active' : '' }}">
                                                    <i class="fas fa-charging-station"></i>
                                                    <p>
                                                        {{__('words.mining_centers')}}
                                                        <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    @if(auth('admin')->user()->hasPermission('read-mining_centers'))
                                                        <li class="nav-item">
                                                            <a href="{{route('mining-centers.index')}}"
                                                               class="nav-link {{ request()->routeIs('mining-centers.index') ? 'active' : '' }}">
                                                                <i class="far fa-eye nav-icon"></i>
                                                                <p>{{__('words.show_all')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if(auth('admin')->user()->hasPermission('create-mining_centers'))
                                                        <li class="nav-item">
                                                            <a href="{{route('mining-centers.create')}}"
                                                               class="nav-link {{ request()->routeIs('mining-centers.create') ? 'active' : '' }}">
                                                                <i class="fas fa-folder-plus"></i>
                                                                <p>{{__('words.create')}}</p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </li>
                                        @endif
                                        {{-- Mining Center routes end --}}
                                    </ul>
                                </li>
                            @endif
                            {{-- Auto Service Centers routes end --}}

                            <hr class="mt-2 mb-3 sidebar-divider"/>

                            {{-- Insurance Company routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-insurance_companies'))
                                <li class="nav-item {{ request()->routeIs('insurance_companies.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('insurance_companies.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-car-crash"></i>
                                        <p>
                                            {{__('words.insurance_companies')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-insurance_companies'))
                                            <li class="nav-item">
                                                <a href="{{route('insurance_companies.index')}}"
                                                   class="nav-link {{ request()->routeIs('insurance_companies.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-insurance_companies'))
                                            <li class="nav-item">
                                                <a href="{{route('insurance_companies.create')}}"
                                                   class="nav-link {{ request()->routeIs('insurance_companies.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Insurance Company routes end --}}

                            {{-- Broker routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-brokers'))
                                <li class="nav-item {{ request()->routeIs('brokers.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('brokers.*') ? 'sub-menu active' : '' }}">
                                        <i class="far fa-handshake"></i>
                                        <p>
                                            {{__('words.brokers')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-brokers'))
                                            <li class="nav-item">
                                                <a href="{{route('brokers.index')}}"
                                                   class="nav-link {{ request()->routeIs('brokers.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-brokers'))
                                            <li class="nav-item">
                                                <a href="{{route('brokers.create')}}"
                                                   class="nav-link {{ request()->routeIs('brokers.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Broker routes end --}}

                            {{-- Delivery routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-delivery'))
                                <li class="nav-item {{ request()->routeIs('delivery.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('delivery.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-truck"></i>
                                        <p>
                                            {{__('words.delivery')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-delivery'))
                                            <li class="nav-item">
                                                <a href="{{route('delivery.index')}}"
                                                   class="nav-link {{ request()->routeIs('delivery.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-delivery'))
                                            <li class="nav-item">
                                                <a href="{{route('delivery.create')}}"
                                                   class="nav-link {{ request()->routeIs('delivery.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Delivery routes end --}}

                            {{-- Trainers routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-driving_trainers'))
                                <li class="nav-item {{ request()->routeIs('trainers.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('trainers.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-car-side"></i>
                                        <p>
                                            {{__('words.driving_trainers')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-driving_trainers'))
                                            <li class="nav-item">
                                                <a href="{{route('trainers.index')}}"
                                                   class="nav-link {{ request()->routeIs('trainers.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-driving_trainers'))
                                            <li class="nav-item">
                                                <a href="{{route('trainers.create')}}"
                                                   class="nav-link {{ request()->routeIs('trainers.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Trainers routes end --}}

                            {{-- Fuel Stattion routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-fuel_stations'))
                                <li class="nav-item {{ request()->routeIs('fuel-stations.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('fuel-stations.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-gas-pump"></i>
                                        <p>
                                            {{__('words.fuel_stations')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-fuel_stations'))
                                            <li class="nav-item">
                                                <a href="{{route('fuel-stations.index')}}"
                                                   class="nav-link {{ request()->routeIs('fuel-stations.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-fuel_stations'))
                                            <li class="nav-item">
                                                <a href="{{route('fuel-stations.create')}}"
                                                   class="nav-link {{ request()->routeIs('fuel-stations.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Fuel Stattion routes end --}}

                            {{-- Traffic Clearing Office routes start --}}
                            @if(auth('admin')->user()->hasPermission('read-traffic_clearing_offices'))
                                <li class="nav-item {{ request()->routeIs('traffic-clearing-offices.*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                       class="nav-link {{ request()->routeIs('traffic-clearing-offices.*') ? 'sub-menu active' : '' }}">
                                        <i class="fas fa-traffic-light"></i>
                                        <p>
                                            {{__('words.traffic_clearing_offices')}}
                                            <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(auth('admin')->user()->hasPermission('read-traffic_clearing_offices'))
                                            <li class="nav-item">
                                                <a href="{{route('traffic-clearing-offices.index')}}"
                                                   class="nav-link {{ request()->routeIs('traffic-clearing-offices.index') ? 'active' : '' }}">
                                                    <i class="far fa-eye nav-icon"></i>
                                                    <p>{{__('words.show_all')}}</p>
                                                </a>
                                            </li>
                                        @endif

                                        @if(auth('admin')->user()->hasPermission('create-traffic_clearing_offices'))
                                            <li class="nav-item">
                                                <a href="{{route('traffic-clearing-offices.create')}}"
                                                   class="nav-link {{ request()->routeIs('traffic-clearing-offices.create') ? 'active' : '' }}">
                                                    <i class="fas fa-folder-plus"></i>
                                                    <p>{{__('words.create')}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            {{-- Traffic Clearing Office routes end --}}
                        </ul>
                    </li>

                @endif
                {{-- Organizations toggle end --}}

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
