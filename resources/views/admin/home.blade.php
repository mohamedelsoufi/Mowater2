@extends('admin.layouts.standard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{__('words.admin_dashboard')}}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb {{app()->getLocale() == 'ar' ? 'float-sm-left' :  'float-sm-right'}}">
                            <li class="breadcrumb-item active"><a href="#">{{__('words.home')}}</a></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    @if(auth('admin')->user()->hasPermission('read-admins'))
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{\App\Models\Admin::count()}}</h3>

                                <p>{{__('words.admin_users')}}</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{route('admin-users.index')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    @endif
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{\App\Models\OrganizationUser::count()}}</h3>

                                <p>{{__('words.org_users')}}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-place-of-worship"></i>
                            </div>
                            <a href="{{route('org-users.index')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{\App\Models\User::count()}}</h3>

                                <p>{{__('words.app_users')}}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-mobile"></i>
                            </div>
                            <a href="{{route('app-users.index')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                </div>
                <!-- /.row -->
                <!-- Main row -->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            <div class="col-md-3 {{app()->getLocale() == 'ar' ? 'col-md-push-9' :  'col-md-3'}}">
                                <h4>{{__('sentences.welcome_back')}}</h4>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
