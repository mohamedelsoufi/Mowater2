@extends('admin.layouts.standard')
@section('title', __('words.show_traffic_clearing_office'))
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
                                    href="{{route('traffic-clearing-offices.index')}}">{{__('words.show_traffic_clearing_offices')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_traffic_clearing_office')}}</li>
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
                                <h3 class="card-title">{{__('words.show_traffic_clearing_office')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">{{__('words.logo')}}</th>
                                            <td>
                                                @if(!$office->logo)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$office->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}"
                                                             alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$office->logo}}"
                                                       data-toggle="lightbox" data-title="{{$office->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$office->logo}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_ar')}}</th>
                                            <td>{{$office->name_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_en')}}</th>
                                            <td>{{$office->name_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_ar')}}</th>
                                            <td>{{$office->description_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_en')}}</th>
                                            <td>{{$office->description_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.tax_number')}}</th>
                                            <td>{{$office->tax_number}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.country')}}</th>
                                            <td>{{$office->country->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.city')}}</th>
                                            <td>{{$office->city->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.area')}}</th>
                                            <td>{{$office->area->name}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.number_of_views')}}</th>
                                            <td>{{$office->number_of_views}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.active_number_of_views')}}</th>
                                            <td>{{$office->getActiveNumberOfViews()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.reservation_active')}}</th>
                                            <td>{{$office->getReservationActive()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.availability')}}</th>
                                            <td>{{$office->getAvailable()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.activity')}}</th>
                                            <td>{{$office->getActive()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_by')}}</th>
                                            <td>{{$office->created_by}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($office->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($office->created_at) == updatedAtFormat($office->updated_at) ? '--' : updatedAtFormat($office->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>


                            @if(auth('admin')->user()->hasPermission('update-traffic_clearing_offices'))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('traffic-clearing-offices.edit',$office->id)}}"
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
