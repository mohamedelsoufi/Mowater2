@extends('admin.layouts.standard')
@section('title', __('words.show_ad_type'))
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
                                    href="{{route('ad-types.index')}}">{{__('words.show_ad_types')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_ad_type')}}</li>
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
                                <h3 class="card-title">{{__('words.show_ad_type')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_ar')}}</th>
                                            <td>{{$ad_type->name_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_en')}}</th>
                                            <td>{{$ad_type->name_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.price')}}</th>
                                            <td>{{$ad_type->price}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_by')}}</th>
                                            <td>{{$ad_type->created_by}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($ad_type->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($ad_type->created_at) == updatedAtFormat($ad_type->updated_at) ? '--' : updatedAtFormat($ad_type->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>

                            </div>

                            @if(auth('admin')->user()->hasPermission('update-ad_types'))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('ad-types.edit',$ad_type->id)}}"
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
