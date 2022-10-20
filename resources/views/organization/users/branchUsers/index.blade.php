@extends('organization.layouts.app')
@section('title', __('words.show_branches_users'))
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('words.dashboard') .' '. $record->name}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb {{app()->getLocale() == 'ar' ? 'float-sm-left' :  'float-sm-right'}}">
                            <li class="breadcrumb-item"><a href="{{route('organization.home')}}">{{__('words.home')}}</a></li>
                            <li class="breadcrumb-item active">{{__('words.show_branches_users')}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        @include('organization.includes.alerts.success')
        @include('organization.includes.alerts.errors')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{__('words.show_branches_users')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.user_name')}}</th>
                                        <th>{{__('words.email')}}</th>
                                        <th>{{__('words.roles')}}</th>
                                        <th>{{__('words.branch')}}</th>
                                        <th>{{__('words.activity')}}</th>
                                        <th>{{__('words.created_by')}}</th>
                                        <th>{{__('words.created_at')}}</th>
                                        <th>{{__('words.updated_at')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $key => $user)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$user['user_name']}}</td>
                                            <td>{{$user['email']}}</td>
                                            <td>{{$user['role']}}</td>
                                            <td>{{$user['branch']}}</td>
                                            <td>{{$user['active']}}</td>
                                            <td>{{$user['created_by']}}</td>
                                            <td>{{createdAtFormat($user['created_at'])}}</td>
                                            <td>{{createdAtFormat($user['created_at']) == updatedAtFormat($user['updated_at']) ? '--' : updatedAtFormat($user['updated_at'])}}</td>
                                            <td class="action">
                                                @if(auth('web')->user()->hasPermission('read-branch_users-'. $record->name_en))
                                                    <a href="{{route('organization.org-branches-users.show',$user['id'])}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(auth('web')->user()->hasPermission('update-branch_users-'. $record->name_en))
                                                    <a href="{{route('organization.org-branches-users.edit',$user['id'])}}"
                                                       class="btn btn-outline-warning" data-toggle="tooltip"
                                                       title="{{__('words.edit')}}">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                @endif
                                                @if(auth('web')->user()->hasPermission('delete-branch_users-'. $record->name_en))
                                                    <a href="" class="btn btn-outline-danger"
                                                       data-toggle="modal"
                                                       data-target="#ModalDelete{{$user['id']}}"
                                                       title="{{__('words.delete')}}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @include('organization.users.branchUsers.deleteModal')
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
