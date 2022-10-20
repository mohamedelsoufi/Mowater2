<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('organization.home')}}" class="brand-link">
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
                <a href="#"
                   class="d-block">{{auth('web')->user()->user_name}}</a>
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

    <?php
    $user = auth()->guard('web')->user();
    $model_type = $user->organizable_type;
    $model_id = $user->organizable_id;
    $model = new $model_type;
    $orgData = $model->find($model_id);
    ?>

    <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{-- Users details toggle start --}}
                @if($orgData->getTable() == 'branches')
                    @if(auth('web')->user()->hasPermission(['read-org_users-'. $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.users.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.users.*','organization.org-branches-users.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    {{__('words.users')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview level">
                                @if(auth('web')->user()->hasPermission('read-org_users-'. $orgData->name_en))
                                    <li class="nav-item">
                                        <a href="{{route('organization.users.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.users.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission('create-org_users-'. $orgData->name_en))
                                    <li class="nav-item">
                                        <a href="{{route('organization.users.create')}}"
                                           class="nav-link {{ request()->routeIs('organization.users.create') ? 'active' : '' }}">
                                            <i class="fas fa-folder-plus"></i>
                                            <p>{{__('words.create')}}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @else
                    @if(auth('web')->user()->hasPermission(['read-org_users-'. $orgData->name_en,'read-branch_users-'. $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.users.*','organization.org-branches-users.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.users.*','organization.org-branches-users.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    {{__('words.users')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview level">

                                {{-- Organization Users Start--}}
                                @if(auth('web')->user()->hasPermission('read-org_users-'. $orgData->name_en))
                                    <li class="nav-item {{ request()->routeIs('organization.users.*') ? 'menu-open' : '' }}">
                                        <a href="#"
                                           class="nav-link {{ request()->routeIs('organization.users.*') ? 'sub-menu active' : '' }}">
                                            <i class="nav-icon fas fa-user"></i>
                                            <p>
                                                {{__('words.org_users')}}
                                                <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @if(auth('web')->user()->hasPermission('read-org_users-'. $orgData->name_en))
                                                <li class="nav-item">
                                                    <a href="{{route('organization.users.index')}}"
                                                       class="nav-link {{ request()->routeIs('organization.users.index') ? 'active' : '' }}">
                                                        <i class="far fa-eye nav-icon"></i>
                                                        <p>{{__('words.show_all')}}</p>
                                                    </a>
                                                </li>
                                            @endif

                                            @if(auth('web')->user()->hasPermission('create-org_users-'. $orgData->name_en))
                                                <li class="nav-item">
                                                    <a href="{{route('organization.users.create')}}"
                                                       class="nav-link {{ request()->routeIs('organization.users.create') ? 'active' : '' }}">
                                                        <i class="fas fa-folder-plus"></i>
                                                        <p>{{__('words.create')}}</p>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                @endif
                                {{-- Organization Users end --}}

                                {{-- Branch Users Start --}}
                                @if(auth('web')->user()->hasPermission('read-branch_users-'. $orgData->name_en))
                                    <li class="nav-item {{ request()->routeIs('organization.org-branches-users.*') ? 'menu-open' : '' }}">
                                        <a href="#"
                                           class="nav-link {{ request()->routeIs('organization.org-branches-users.*') ? 'sub-menu active' : '' }}">
                                            <i class="nav-icon fas fa-user"></i>
                                            <p>
                                                {{__('words.branches_users')}}
                                                <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @if(auth('web')->user()->hasPermission('read-branch_users-'. $orgData->name_en))
                                                <li class="nav-item">
                                                    <a href="{{route('organization.org-branches-users.index')}}"
                                                       class="nav-link {{ request()->routeIs('organization.org-branches-users.index') ? 'active' : '' }}">
                                                        <i class="far fa-eye nav-icon"></i>
                                                        <p>{{__('words.show_all')}}</p>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                @endif
                                {{-- Branch Users end --}}
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Users details toggle end --}}

                {{-- Permissions Users Start --}}
                @if(auth('web')->user()->hasPermission('read-org_roles-'. $orgData->name_en))
                    <li class="nav-item {{ request()->routeIs('organization.org-roles.*') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->routeIs('organization.org-roles.*') ? 'sub-menu active' : '' }}">
                            <i class="fas fa-universal-access"></i>
                            <p>
                                {{__('words.permissions')}}
                                <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(auth('web')->user()->hasPermission('read-org_roles-'. $orgData->name_en))
                                <li class="nav-item">
                                    <a href="{{route('organization.org-roles.index')}}"
                                       class="nav-link {{ request()->routeIs('organization.org-roles.index') ? 'active' : '' }}">
                                        <i class="far fa-eye nav-icon"></i>
                                        <p>{{__('words.show_all')}}</p>
                                    </a>
                                </li>
                            @endif

                            @if(auth('web')->user()->hasPermission('create-org_roles-'. $orgData->name_en))
                                <li class="nav-item">
                                    <a href="{{route('organization.org-roles.create')}}"
                                       class="nav-link {{ request()->routeIs('organization.org-roles.create') ? 'active' : '' }}">
                                        <i class="fas fa-folder-plus"></i>
                                        <p>{{__('words.create')}}</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{-- Permissions Users end--}}

                {{-- Organization Data toggle start --}}
                @if(auth('web')->user()->hasPermission(['read-general_data-' . $orgData->name_en]))
                    <li class="nav-item {{ request()->routeIs('organization.organizations.*') ? 'menu-open' : '' }}">
                        <a href="{{route('organization.organizations.index')}}"
                           class="nav-link {{ request()->routeIs('organization.organizations.*') ? 'sub-menu active' : '' }}">
                            <i class="fas fa-server"></i>
                            <p>
                                {{__('words.show_data')}}
                            </p>
                        </a>
                    </li>
                @endif
                {{-- Organization Data toggle end --}}

                {{-- Banches toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'branches'))
                    @if(auth('web')->user()->hasPermission(['read-org-branch-general_data-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.org.branches.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.org.branches.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-code-branch"></i>
                                <p>
                                    {{__('words.branches')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth('web')->user()->hasPermission(['read-org-branch-general_data-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.org.branches.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.org.branches.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission(['create-org-branch-general_data-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.org.branches.create')}}"
                                           class="nav-link {{ request()->routeIs('organization.org.branches.create') ? 'active' : '' }}">
                                            <i class="fas fa-folder-plus"></i>
                                            <p>{{__('words.create')}}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Banches toggle end --}}

                {{-- Vehicle toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'vehicles'))
                    @if(auth('web')->user()->hasPermission(['read-vehicles-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.vehicles.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.vehicles.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-car-side"></i>
                                <p>
                                    {{__('words.vehicles')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth('web')->user()->hasPermission(['read-vehicles-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.vehicles.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.vehicles.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission(['create-vehicles-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.vehicles.create')}}"
                                           class="nav-link {{ request()->routeIs('organization.vehicles.create') ? 'active' : '' }}">
                                            <i class="fas fa-folder-plus"></i>
                                            <p>{{__('words.create')}}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Vehicle toggle end --}}

                {{-- Rental Office Cars toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'rental_office_cars'))
                    @if(auth('web')->user()->hasPermission(['read-rental_office_cars-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.rental-office-cars.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.rental-office-cars.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-car-side"></i>
                                <p>
                                    {{__('words.rental_office_cars')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth('web')->user()->hasPermission(['read-rental_office_cars-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.rental-office-cars.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.rental-office-cars.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission(['create-rental_office_cars-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.rental-office-cars.create')}}"
                                           class="nav-link {{ request()->routeIs('organization.rental-office-cars.create') ? 'active' : '' }}">
                                            <i class="fas fa-folder-plus"></i>
                                            <p>{{__('words.create')}}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Rental Office Cars toggle end --}}

                {{-- Rental Office Cars Properties toggle start --}}
                @if($orgData->getTable() == 'rental_offices')
                    @if(auth('web')->user()->hasPermission(['read-cars_properties-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.rental-cars-properties.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.rental-cars-properties.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-car"></i>
                                <p>
                                    {{__('words.cars_properties')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth('web')->user()->hasPermission(['read-cars_properties-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.rental-cars-properties.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.rental-cars-properties.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission(['create-cars_properties-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.rental-cars-properties.create')}}"
                                           class="nav-link {{ request()->routeIs('organization.rental-cars-properties.create') ? 'active' : '' }}">
                                            <i class="fas fa-folder-plus"></i>
                                            <p>{{__('words.create')}}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Rental Office Cars Properties toggle end --}}

                {{-- Rental Office Laws toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'rental_laws'))
                    @if(auth('web')->user()->hasPermission(['read-rental_laws-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.rental-laws.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.rental-laws.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-solid fa-gavel"></i>
                                <p>
                                    {{__('words.rental_laws')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth('web')->user()->hasPermission(['read-rental_laws-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.rental-laws.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.rental-laws.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission(['create-rental_laws-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.rental-laws.create')}}"
                                           class="nav-link {{ request()->routeIs('organization.rental-laws.create') ? 'active' : '' }}">
                                            <i class="fas fa-folder-plus"></i>
                                            <p>{{__('words.create')}}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Rental Office Laws toggle end --}}

                {{-- Available Vehicles toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'available_vehicles'))

                    @if(auth('web')->user()->hasPermission(['read-available_vehicles-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.available-vehicles.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.available-vehicles.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-car-side"></i>
                                <p>
                                    {{__('words.available_vehicles')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth('web')->user()->hasPermission(['read-available_vehicles-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.available-vehicles.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.available-vehicles.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission(['update-available_vehicles-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.available-vehicles.edit')}}"
                                           class="nav-link {{ request()->routeIs('organization.available-vehicles.edit') ? 'active' : '' }}">
                                            <i class="fas fa-pen"></i>
                                            <p>{{__('words.edit')}}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Available Vehicles toggle end --}}

                {{-- Available Products and Services toggle start --}}
                @if($orgData->getAttribute('branchable_type') != 'App\\Models\\CarShowroom')
                    {{-- Available Products toggle start --}}
                    @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'available_products'))

                        @if(auth('web')->user()->hasPermission(['read-available_products-' . $orgData->name_en]))
                            <li class="nav-item {{ request()->routeIs('organization.available-products.*') ? 'menu-open' : '' }}">
                                <a href="#"
                                   class="nav-link {{ request()->routeIs('organization.available-products.*') ? 'sub-menu active' : '' }}">
                                    <i class="fab fa-product-hunt"></i>
                                    <p>
                                        {{__('words.available_products')}}
                                        <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if(auth('web')->user()->hasPermission(['read-available_products-' . $orgData->name_en]))
                                        <li class="nav-item">
                                            <a href="{{route('organization.available-products.index')}}"
                                               class="nav-link {{ request()->routeIs('organization.available-products.index') ? 'active' : '' }}">
                                                <i class="far fa-eye nav-icon"></i>
                                                <p>{{__('words.show_all')}}</p>
                                            </a>
                                        </li>
                                    @endif

                                    @if(auth('web')->user()->hasPermission(['update-available_products-' . $orgData->name_en]))
                                        <li class="nav-item">
                                            <a href="{{route('organization.available-products.edit')}}"
                                               class="nav-link {{ request()->routeIs('organization.available-products.edit') ? 'active' : '' }}">
                                                <i class="fas fa-pen"></i>
                                                <p>{{__('words.edit')}}</p>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif
                    {{-- Available Products toggle end --}}

                    {{-- Available Services toggle start --}}
                    @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'available_services'))

                        @if(auth('web')->user()->hasPermission(['read-available_services-' . $orgData->name_en]))
                            <li class="nav-item {{ request()->routeIs('organization.available-services.*') ? 'menu-open' : '' }}">
                                <a href="#"
                                   class="nav-link {{ request()->routeIs('organization.available-services.*') ? 'sub-menu active' : '' }}">
                                    <i class="fas fa-toolbox"></i>
                                    <p>
                                        {{__('words.available_services')}}
                                        <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if(auth('web')->user()->hasPermission(['read-available_services-' . $orgData->name_en]))
                                        <li class="nav-item">
                                            <a href="{{route('organization.available-services.index')}}"
                                               class="nav-link {{ request()->routeIs('organization.available-services.index') ? 'active' : '' }}">
                                                <i class="far fa-eye nav-icon"></i>
                                                <p>{{__('words.show_all')}}</p>
                                            </a>
                                        </li>
                                    @endif

                                    @if(auth('web')->user()->hasPermission(['update-available_services-' . $orgData->name_en]))
                                        <li class="nav-item">
                                            <a href="{{route('organization.available-services.edit')}}"
                                               class="nav-link {{ request()->routeIs('organization.available-services.edit') ? 'active' : '' }}">
                                                <i class="fas fa-pen"></i>
                                                <p>{{__('words.edit')}}</p>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif
                    {{-- Available Services toggle end --}}
                @endif
                {{-- Available Products and Services toggle start --}}

                {{-- Vehicle Reservations toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'reserve_vehicles'))

                    @if(auth('web')->user()->hasPermission(['read-reserve_vehicles-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.vehicle-reservations.*') ? 'menu-open' : '' }}">
                            <a href="{{route('organization.vehicle-reservations.index')}}"
                               class="nav-link {{ request()->routeIs('organization.vehicle-reservations.index') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-clipboard"></i>
                                <p>
                                    {{__('words.reserve_vehicles')}}
                                </p>
                            </a>
                        </li>
                    @endif
                @endif
                {{-- Vehicle Reservations toggle end --}}

                @if($orgData->getAttribute('branchable_type') != 'App\\Models\\CarShowroom')
                    {{-- Test Drive toggle start --}}
                    @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'tests'))

                        @if(auth('web')->user()->hasPermission(['read-tests-' . $orgData->name_en]))
                            <li class="nav-item {{ request()->routeIs('organization.tests.*') ? 'menu-open' : '' }}">
                                <a href="{{route('organization.tests.index')}}"
                                   class="nav-link {{ request()->routeIs('organization.tests.index') ? 'sub-menu active' : '' }}">
                                    <i class="fas fa-clipboard"></i>
                                    <p>
                                        {{__('words.tests')}}
                                    </p>
                                </a>
                            </li>
                        @endif
                    @endif
                    {{-- Test Drive toggle end --}}

                    {{-- Reservations toggle start --}}
                    @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'reservations'))

                        @if(auth('web')->user()->hasPermission(['read-reservations-' . $orgData->name_en]))
                            <li class="nav-item {{ request()->routeIs('organization.reservations.*') ? 'menu-open' : '' }}">
                                <a href="{{route('organization.reservations.index')}}"
                                   class="nav-link {{ request()->routeIs('organization.reservations.index') ? 'sub-menu active' : '' }}">
                                    <i class="fas fa-clipboard"></i>
                                    <p>
                                        {{__('words.reservations')}}
                                    </p>
                                </a>
                            </li>
                        @endif
                    @endif
                    {{-- Reservations toggle end --}}
                @endif

                {{-- Product toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'products'))
                    @if(auth('web')->user()->hasPermission(['read-products-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.products.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.products.*') ? 'sub-menu active' : '' }}">
                                <i class="fab fa-product-hunt"></i>
                                <p>
                                    {{__('words.products')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth('web')->user()->hasPermission(['read-products-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.products.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.products.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission(['create-products-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.products.create')}}"
                                           class="nav-link {{ request()->routeIs('organization.products.create') ? 'active' : '' }}">
                                            <i class="fas fa-folder-plus"></i>
                                            <p>{{__('words.create')}}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Product toggle end --}}

                {{-- Service toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'services'))
                    @if(auth('web')->user()->hasPermission(['read-services-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.services.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.services.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-toolbox"></i>
                                <p>
                                    {{__('words.services')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth('web')->user()->hasPermission(['read-services-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.services.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.services.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission(['create-services-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.services.create')}}"
                                           class="nav-link {{ request()->routeIs('organization.services.create') ? 'active' : '' }}">
                                            <i class="fas fa-folder-plus"></i>
                                            <p>{{__('words.create')}}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Service toggle end --}}

                {{-- Ads toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'ads'))
                    @if(auth('web')->user()->hasPermission(['read-org_ads-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.ads.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.ads.*') ? 'sub-menu active' : '' }}">
                                <i class="fa fa-bullhorn" aria-hidden="true"></i>
                                <p>
                                    {{__('words.ads')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth('web')->user()->hasPermission(['read-org_ads-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.ads.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.ads.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission(['create-org_ads-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.ads.create')}}"
                                           class="nav-link {{ request()->routeIs('organization.ads.create') ? 'active' : '' }}">
                                            <i class="fas fa-folder-plus"></i>
                                            <p>{{__('words.create')}}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Ads toggle end --}}

                {{-- Discount Card toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'discount_cards'))
                    @if(auth('web')->user()->hasPermission(['read-org_discount_cards-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.discount-cards.*') ? 'menu-open' : '' }}">
                            <a href="{{route('organization.discount-cards.index')}}"
                               class="nav-link {{ request()->routeIs('organization.discount-cards.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-donate"></i>
                                <p>
                                    {{__('words.discount_cards')}}
                                </p>
                            </a>
                        </li>
                    @endif
                @endif
                {{-- Discount Card toggle end --}}

                {{-- Available Payment Methods toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'payment_methods'))

                    @if(auth('web')->user()->hasPermission(['read-payment_methods-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.available-payment-methods.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.available-payment-methods.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-solid fa-money-bill"></i>
                                <p>
                                    {{__('words.available_payment_methods')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth('web')->user()->hasPermission(['read-payment_methods-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.available-payment-methods.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.available-payment-methods.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission(['update-payment_methods-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.available-payment-methods.edit')}}"
                                           class="nav-link {{ request()->routeIs('organization.available-payment-methods.edit') ? 'active' : '' }}">
                                            <i class="fas fa-pen"></i>
                                            <p>{{__('words.edit')}}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Available Payment Methods toggle end --}}

                {{-- Work time toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'work_time'))

                    @if(auth('web')->user()->hasPermission(['read-work_time-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.work-times.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.work-times.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-clock"></i>
                                <p>
                                    {{__('words.work_times')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth('web')->user()->hasPermission(['read-work_time-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.work-times.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.work-times.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission(['update-work_time-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.work-times.edit')}}"
                                           class="nav-link {{ request()->routeIs('organization.work-times.edit') ? 'active' : '' }}">
                                            <i class="fas fa-pen"></i>
                                            <p>{{__('words.edit')}}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Work time toggle end --}}

                {{-- Day off toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'day_offs'))

                    @if(auth('web')->user()->hasPermission(['read-day_offs-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.days-off.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.days-off.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-calendar-day"></i>
                                <p>
                                    {{__('words.days_off')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth('web')->user()->hasPermission(['read-day_offs-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.days-off.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.days-off.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission(['create-day_offs-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.days-off.create')}}"
                                           class="nav-link {{ request()->routeIs('organization.days-off.create') ? 'active' : '' }}">
                                            <i class="fas fa-folder-plus"></i>
                                            <p>{{__('words.create')}}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Day off toggle end --}}

                {{-- Contact toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'contact'))

                    @if(auth('web')->user()->hasPermission(['read-contact-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.contacts.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.contacts.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-id-card-alt"></i>
                                <p>
                                    {{__('words.contacts')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth('web')->user()->hasPermission(['read-contact-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.contacts.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.contacts.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission(['update-contact-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.contacts.edit')}}"
                                           class="nav-link {{ request()->routeIs('organization.contacts.edit') ? 'active' : '' }}">
                                            <i class="fas fa-pen"></i>
                                            <p>{{__('words.edit')}}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Contact toggle end --}}

                {{-- Phone toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'phones'))

                    @if(auth('web')->user()->hasPermission(['read-phones-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.phones.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.phones.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-phone"></i>
                                <p>
                                    {{__('words.phones')}}
                                    <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth('web')->user()->hasPermission(['read-phones-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.phones.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.phones.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission(['create-phones-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.phones.create')}}"
                                           class="nav-link {{ request()->routeIs('organization.phones.create') ? 'active' : '' }}">
                                            <i class="fas fa-folder-plus"></i>
                                            <p>{{__('words.create')}}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- Phone toggle end --}}

                {{-- Review toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'reviews'))
                    @if(auth('web')->user()->hasPermission(['read-reviews-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.reviews.*') ? 'menu-open' : '' }}">
                            <a href="{{route('organization.reviews.index')}}"
                               class="nav-link {{ request()->routeIs('organization.reviews.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-star-half-alt"></i>
                                <p>
                                    {{__('words.reviews')}}
                                </p>
                            </a>
                        </li>
                    @endif
                @endif
                {{-- Review toggle end --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
