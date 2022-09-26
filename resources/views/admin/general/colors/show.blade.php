@extends('admin.layouts.standard')
@section('title', __('words.show_color'))
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
                                    href="{{route('colors.index')}}">{{__('words.show_colors')}}</a></li>
                            <li class="breadcrumb-item active">{{__('words.show_color')}}</li>
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
                                <h3 class="card-title">{{__('words.show_color')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">{{__('words.color_name_ar')}}</th>
                                            <td>{{$color->color_name_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.color_name')}}</th>
                                            <td>{{$color->color_name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.color_code')}}</th>
                                            <td>
                                                <div class="{{app()->getLocale() == 'ar' ? 'float-right ml-2' : 'float-left mr-2'}}" style="width: 30px;height: 30px;background-color: {{$color->color_code}}"></div>
                                                <div>{{$color->color_code}}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_by')}}</th>
                                            <td>
                                                {{$color->created_by}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($color->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($color->created_at) == updatedAtFormat($color->updated_at) ? '--' : updatedAtFormat($color->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>


                            @if(auth('admin')->user()->hasPermission('update-colors'))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('colors.edit',$color->id)}}"
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
