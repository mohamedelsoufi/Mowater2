@extends('admin.layouts.standard')
@section('title', __('words.show_org_users'))
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('words.admin_dashboard')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb {{app()->getLocale() == 'ar' ? 'float-sm-left' :  'float-sm-right'}}">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">{{__('words.home')}}</a></li>
                            <li class="breadcrumb-item active">{{__('words.show_org_users')}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        @include('admin.includes.alerts.success')
        @include('admin.includes.alerts.errors')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{__('words.show_org_users')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.user_name')}}</th>
                                        <th>{{__('words.email')}}</th>
                                        <th>{{__('words.activity')}}</th>
                                        <th>{{__('words.created_at')}}</th>
                                        <th>{{__('words.updated_at')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $key => $user)
                                        <tr>
                                            <td>{{$key+1}}</td>

                                            <td>{{$user->user_name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->getActive()}}</td>
                                            <td>{{createdAtFormat($user->created_at)}}</td>
                                            <td>{{createdAtFormat($user->created_at) == updatedAtFormat($user->updated_at) ? '--' : updatedAtFormat($user->updated_at)}}</td>
                                            <td>
                                                @if(auth('admin')->user()->hasPermission('read-org_users'))
                                                    <a href="{{route('org-users.show',$user->id)}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('update-org_users'))
                                                    <a href="{{route('org-users.edit',$user->id)}}"
                                                       class="btn btn-outline-warning" data-toggle="tooltip"
                                                       title="{{__('words.edit')}}">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                @endif
                                                @if(auth('admin')->user()->hasPermission('delete-org_users'))
                                                    <a href="" class="btn btn-outline-danger"
                                                       data-toggle="modal"
                                                       data-target="#ModalDelete{{$user->id}}"
                                                       title="{{__('words.delete')}}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @include('admin.general.OrgUsers.deleteModal')
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
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

@endsection
