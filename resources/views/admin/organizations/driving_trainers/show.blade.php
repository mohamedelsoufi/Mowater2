@extends('admin.layouts.standard')
@section('title', __('words.show_driving_trainer'))
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
                                    href="{{route('trainers.index')}}">{{__('words.show_driving_trainers')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_driving_trainer')}}</li>
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
                                <h3 class="card-title">{{__('words.show_driving_trainer')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">{{__('words.profile_picture')}}</th>
                                            <td>
                                                @if(!$trainer->profile)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$trainer->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}"
                                                             alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$trainer->profile}}"
                                                       data-toggle="lightbox" data-title="{{$trainer->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$trainer->profile}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_ar')}}</th>
                                            <td>{{$trainer->name_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_en')}}</th>
                                            <td>{{$trainer->name_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_ar')}}</th>
                                            <td>{{$trainer->description_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_en')}}</th>
                                            <td>{{$trainer->description_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.gender')}}</th>
                                            <td>{{__('words.'.$trainer->gender)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.birth_date')}}</th>
                                            <td>{{$trainer->birth_date}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.age')}}</th>
                                            <td>{{$trainer->age}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.vehicle_image')}}</th>
                                            <td>
                                                @if(!$trainer->trainer_vehicle)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox"
                                                       data-title="{{$trainer->brand->name .'-'.$trainer->car_model->name.'-' .$trainer->car_class->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}"
                                                             alt="vehicle-image">
                                                    </a>
                                                @else
                                                    <a href="{{$trainer->trainer_vehicle}}"
                                                       data-toggle="lightbox"
                                                       data-title="{{$trainer->brand_id != null ? $trainer->brand->name.'-' .$trainer->car_model->name.'-' .$trainer->car_class->name : ''}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$trainer->trainer_vehicle}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="vehicle-image">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('vehicle.vehicle_type')}}</th>
                                            <td>{{$trainer->vehicle_type != null ? __('vehicle.'.$trainer->vehicle_type) : '--'}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.brand')}}</th>
                                            <td>{{$trainer->brand ? $trainer->brand->name : '--'}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.car_model')}}</th>
                                            <td>{{$trainer->car_model ? $trainer->car_model->name : '--'}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.car_class')}}</th>
                                            <td>{{$trainer->car_class ? $trainer->car_class->name : '--'}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('vehicle.manufacturing_year')}}</th>
                                            <td>{{$trainer->manufacturing_year}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.conveyor_type')}}</th>
                                            <td>{{$trainer->conveyor_type != null ? __('words.'.$trainer->conveyor_type) : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.country')}}</th>
                                            <td>{{$trainer->country->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.city')}}</th>
                                            <td>{{$trainer->city->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.area')}}</th>
                                            <td>{{$trainer->area->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.hour_price')}}</th>
                                            <td>{{$hour_price}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.number_of_views')}}</th>
                                            <td>{{$trainer->number_of_views}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.active_number_of_views')}}</th>
                                            <td>{{$trainer->getActiveNumberOfViews()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.availability')}}</th>
                                            <td>{{$trainer->getAvailable()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.activity')}}</th>
                                            <td>{{$trainer->getActive()}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>


                            @if(auth('admin')->user()->hasPermission('update-driving_trainers'))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('trainers.edit',$trainer->id)}}"
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
