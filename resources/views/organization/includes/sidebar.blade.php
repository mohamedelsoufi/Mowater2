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

                {{-- Vehicle toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'vehicles'))
                    @if(auth('web')->user()->hasPermission(['read-vehicles-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.vehicles.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.vehicles.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-car-side"></i>
                                <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                <p>
                                    {{__('words.vehicles')}}
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

                {{-- Available Payment Methods toggle start --}}
                @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'payment_methods'))

                    @if(auth('web')->user()->hasPermission(['read-payment_methods-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.available-payment-methods.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.available-payment-methods.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-solid fa-money-bill"></i>
                                <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                <p>
                                    {{__('words.available_payment_methods')}}
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

                    @if(auth('web')->user()->hasPermission(['read-work_times-' . $orgData->name_en]))
                        <li class="nav-item {{ request()->routeIs('organization.work-times.*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->routeIs('organization.work-times.*') ? 'sub-menu active' : '' }}">
                                <i class="fas fa-clock"></i>
                                <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                <p>
                                    {{__('words.work_times')}}
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth('web')->user()->hasPermission(['read-work_times-' . $orgData->name_en]))
                                    <li class="nav-item">
                                        <a href="{{route('organization.work-times.index')}}"
                                           class="nav-link {{ request()->routeIs('organization.work-times.index') ? 'active' : '' }}">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>{{__('words.show_all')}}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth('web')->user()->hasPermission(['update-work_times-' . $orgData->name_en]))
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
                                <i class="{{app()->getLocale() == 'ar' ? 'left fas fa-angle-right' :  'right fas fa-angle-left'}}"></i>
                                <p>
                                    {{__('words.days_off')}}
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
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
