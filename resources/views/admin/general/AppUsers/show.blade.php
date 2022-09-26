@extends('admin.layouts.standard')
@section('title', __('words.show_app_user'))
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
                            <li class="breadcrumb-item"><a
                                    href="{{route('app-users.index')}}">{{__('words.show_app_users')}}</a></li>
                            <li class="breadcrumb-item active">{{__('words.show_app_user')}}</li>
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
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">{{__('words.show_app_user')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">{{__('words.profile_picture')}}</th>
                                            <td>
                                                @if(!$user->profile_image)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox"
                                                       data-title="{{$user->nickname.' '.$user->first_name .' ' .$user->last_name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}"
                                                             alt="profile_image">
                                                    </a>
                                                @else
                                                    <a href="{{$user->profile_image}}"
                                                       data-toggle="lightbox"
                                                       data-title="{{$user->nickname.' '.$user->first_name .' ' .$user->last_name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$user->profile_image}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="profile_image">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.nickname')}}</th>
                                            <td> {{$user->nickname == null ? '--' : $user->nickname}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.first_name')}}</th>
                                            <td> {{$user->first_name == null ? '--' : $user->first_name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.last_name')}}</th>
                                            <td>{{$user->last_name == null ? '--' : $user->last_name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.email')}}</th>
                                            <td> {{$user->email}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.phone_code')}}</th>
                                            <td> {{$user->phone_code}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.phone')}}</th>
                                            <td> {{$user->phone}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.birth_date')}}</th>
                                            <td> {{$user->date_of_birth}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.gender')}}</th>
                                            <td>{{__('words.'.$user->gender)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.nationality')}}</th>
                                            <td> {{$user->nationality}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.country')}}</th>
                                            <td>{{$user->country->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.city')}}</th>
                                            <td>{{$user->city->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.area')}}</th>
                                            <td>{{$user->area->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.verification')}}</th>
                                            <td> {{$user->getIsVerified()}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.activity')}}</th>
                                            <td> {{$user->getActive()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_by')}}</th>
                                            <td> {{$user->created_by}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($user->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($user->created_at) == updatedAtFormat($user->updated_at) ? '--' : updatedAtFormat($user->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if(auth('admin')->user()->hasPermission('update-app_users'))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('app-users.edit',$user->id)}}"
                                               class="btn btn-block btn-outline-info">
                                                {{__('words.edit')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        @endif
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

@endsection
