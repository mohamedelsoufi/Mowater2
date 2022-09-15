@extends('admin.layouts.standard')
@section('title', __('words.show_used_vehicle'))
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
                                    href="{{route('used-vehicles.index')}}">{{__('words.show_used_vehicles')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_used_vehicle')}}</li>
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
                                <h3 class="card-title">{{__('words.show_used_vehicle')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <!-- sale vehicle images start-->
                                        <tr>
                                            <th class="show-details-table">{{__('words.front_side_image')}}</th>
                                            <td>
                                                @if(!$vehicle->files()->where('type','front_side_image')->first())
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{__('words.front_side_image')}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$vehicle->files()->where('type','front_side_image')->first()->path}}"
                                                       data-toggle="lightbox" data-title="{{__('words.front_side_image')}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$vehicle->files()->where('type','front_side_image')->first()->path}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.back_side_image')}}</th>
                                            <td>
                                                @if(!$vehicle->files()->where('type','back_side_image')->first())
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{__('words.back_side_image')}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$vehicle->files()->where('type','back_side_image')->first()->path}}"
                                                       data-toggle="lightbox" data-title="{{__('words.back_side_image')}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$vehicle->files()->where('type','back_side_image')->first()->path}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.right_side_image')}}</th>
                                            <td>
                                                @if(!$vehicle->files()->where('type','right_side_image')->first())
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{__('words.right_side_image')}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$vehicle->files()->where('type','right_side_image')->first()->path}}"
                                                       data-toggle="lightbox" data-title="{{__('words.right_side_image')}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$vehicle->files()->where('type','right_side_image')->first()->path}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.left_side_image')}}</th>
                                            <td>
                                                @if(!$vehicle->files()->where('type','left_side_image')->first())
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{__('words.left_side_image')}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$vehicle->files()->where('type','left_side_image')->first()->path}}"
                                                       data-toggle="lightbox" data-title="{{__('words.left_side_image')}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$vehicle->files()->where('type','left_side_image')->first()->path}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.inside_vehicle_image')}}</th>
                                            <td>
                                                @if(!$vehicle->files()->where('type','inside_vehicle_image')->first())
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{__('words.inside_vehicle_image')}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$vehicle->files()->where('type','inside_vehicle_image')->first()->path}}"
                                                       data-toggle="lightbox" data-title="{{__('words.inside_vehicle_image')}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$vehicle->files()->where('type','inside_vehicle_image')->first()->path}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.vehicle_dashboard_image')}}</th>
                                            <td>
                                                @if(!$vehicle->files()->where('type','vehicle_dashboard_image')->first())
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{__('words.vehicle_dashboard_image')}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$vehicle->files()->where('type','vehicle_dashboard_image')->first()->path}}"
                                                       data-toggle="lightbox" data-title="{{__('words.vehicle_dashboard_image')}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$vehicle->files()->where('type','vehicle_dashboard_image')->first()->path}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.traffic_pdf')}}</th>
                                            <td>
                                                @if(!$vehicle->files()->where('type','traffic_pdf')->first())
                                                    <a href="{{asset('uploads/pdf.png')}}"
                                                       data-toggle="lightbox" data-title="{{__('words.traffic_pdf')}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/pdf.png')}}" alt="logo">
                                                    </a>
                                                @else
{{--                                                    <object data="{{$vehicle->files()->where('type','traffic_pdf')->first()->path}}" type="application/pdf">--}}
{{--                                                        <iframe src="https://docs.google.com/viewer?{{$vehicle->files()->where('type','traffic_pdf')->first()->path}}&embedded=true"></iframe>--}}
{{--                                                    </object>--}}
                                                    <a href="{{$vehicle->files()->where('type','traffic_pdf')->first()->path}}" target="_blank">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/pdf.png')}}" alt="traffic_pdf">
                                                    </a>
                                                @endif

                                            </td>
                                        </tr>

                                        <!-- sale vehicle images end-->

                                        <tr>
                                            <th class="show-details-table">{{__('words.vehicle_name')}}</th>
                                            <td>{{$vehicle->vehicle_name != null ? $vehicle->vehicle_name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.vehicle_type')}}</th>
                                            <td>{{__('vehicle.'.$vehicle->vehicle_type)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.brand')}}</th>
                                            <td>{{$vehicle->brand->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.car_model')}}</th>
                                            <td>{{$vehicle->car_model->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.car_class')}}</th>
                                            <td>{{$vehicle->car_class->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.manufacturing_year')}}</th>
                                            <td>{{$vehicle->manufacturing_year}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('vehicle.battery_size')}}</th>
                                            <td>{{$vehicle->battery_size ? $vehicle->battery_size : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('vehicle.chassis_number')}}</th>
                                            <td>{{$vehicle->chassis_number ? $vehicle->chassis_number : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.country')}}</th>
                                            <td>{{$vehicle->country ? $vehicle->country->name : "--"}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.features')}}</th>
                                            <td>
                                                <table class="table table-striped">
                                                    @for($i =0; $i < count($keys); $i++)
                                                        <tr>
                                                            @foreach($vehicle->vehicleProperties()[$keys[$i]] as $key => $val)

                                                                <td>{{$val}}</td>

                                                            @endforeach
                                                        </tr>
                                                    @endfor
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.price')}}</th>
                                            <td>{{$vehicle->price}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.discount_type')}}</th>
                                            <td>{{$vehicle->discount_type ? $vehicle->discount_type : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.discount_value')}}</th>
                                            <td>{{$vehicle->discount ? $vehicle->discount : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.price_after_discount')}}</th>
                                            <td>{{$vehicle->discount ? $vehicle->price_after_discount : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.number_of_views')}}</th>
                                            <td>{{$vehicle->number_of_views}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.active_number_of_views')}}</th>
                                            <td>{{$vehicle->getActiveNumberOfViews()}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.activity')}}</th>
                                            <td>{{$vehicle->getActive()}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.created_by')}}</th>
                                            <td>{{$vehicle->vehicable->email}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($vehicle->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($vehicle->created_at) == updatedAtFormat($vehicle->updated_at) ? '--' : updatedAtFormat($vehicle->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>


                            @if(auth('admin')->user()->hasPermission('update-used_vehicles'))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('used-vehicles.edit',$vehicle->id)}}"
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
