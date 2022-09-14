@extends('admin.layouts.standard')
@section('title', __('words.show_delivery'))
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
                                    href="{{route('delivery.index')}}">{{__('words.show_deliveries')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_delivery')}}</li>
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
                                <h3 class="card-title">{{__('words.show_delivery')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">{{__('words.profile_picture')}}</th>
                                            <td>
                                                @if(!$delivery->profile)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$delivery->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}"
                                                             alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$delivery->profile}}"
                                                       data-toggle="lightbox" data-title="{{$delivery->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$delivery->profile}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_ar')}}</th>
                                            <td>{{$delivery->name_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_en')}}</th>
                                            <td>{{$delivery->name_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_ar')}}</th>
                                            <td>{{$delivery->description_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_en')}}</th>
                                            <td>{{$delivery->description_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.gender')}}</th>
                                            <td>{{__('words.'.$delivery->gender)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.birth_date')}}</th>
                                            <td>{{$delivery->birth_date}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.age')}}</th>
                                            <td>{{$delivery->age}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.vehicle_image')}}</th>
                                            <td>
                                                @if(!$delivery->file_url)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox"
                                                       data-title="{{$delivery->brand->name .'-'.$delivery->car_model->name.'-' .$delivery->car_class->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}"
                                                             alt="vehicle-image">
                                                    </a>
                                                @else
                                                    <a href="{{$delivery->file_url}}"
                                                       data-toggle="lightbox"
                                                       data-title="{{$delivery->brand_id != null ? $delivery->brand->name.'-' .$delivery->car_model->name.'-' .$delivery->car_class->name : ''}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$delivery->file_url}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="vehicle-image">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.license')}}</th>
                                            <td>
                                                @if(!$delivery->file()->where('type','driving_license')->first())
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox"
                                                       data-title="{{__('words.license')}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}"
                                                             alt="license">
                                                    </a>
                                                @else
                                                    <a href="{{$delivery->file()->where('type','driving_license')->first()->path}}"
                                                       data-toggle="lightbox"
                                                       data-title="{{__('words.license')}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$delivery->file()->where('type','driving_license')->first()->path}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="license">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('vehicle.vehicle_type')}}</th>
                                            <td>{{$delivery->vehicle_type != null ? __('vehicle.'.$delivery->vehicle_type) : '--'}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.brand')}}</th>
                                            <td>{{$delivery->brand ? $delivery->brand->name : '--'}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.car_model')}}</th>
                                            <td>{{$delivery->car_model ? $delivery->car_model->name : '--'}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.car_class')}}</th>
                                            <td>{{$delivery->car_class ? $delivery->car_class->name : '--'}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('vehicle.manufacturing_year')}}</th>
                                            <td>{{$delivery->manufacturing_year}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.conveyor_type')}}</th>
                                            <td>{{$delivery->conveyor_type != null ? __('words.'.$delivery->conveyor_type) : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.delivery_type')}}</th>
                                            <td>
                                                <ul>
                                                    @foreach($delivery->categories as $category)
                                                        <li>{{$category->name}}</li>@endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.country')}}</th>
                                            <td>{{$delivery->country->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.city')}}</th>
                                            <td>{{$delivery->city->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.area')}}</th>
                                            <td>{{$delivery->area->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.reservation_cost')}}</th>
                                            <td>{{$reservation_cost}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.number_of_views')}}</th>
                                            <td>{{$delivery->number_of_views}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.active_number_of_views')}}</th>
                                            <td>{{$delivery->getActiveNumberOfViews()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.availability')}}</th>
                                            <td>{{$delivery->getAvailable()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.activity')}}</th>
                                            <td>{{$delivery->getActive()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($delivery->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($delivery->created_at) == updatedAtFormat($delivery->updated_at) ? '--' : updatedAtFormat($delivery->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>


                            @if(auth('admin')->user()->hasPermission('update-delivery'))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('delivery.edit',$delivery->id)}}"
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
