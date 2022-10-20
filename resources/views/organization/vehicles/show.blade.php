@extends('organization.layouts.app')
@section('title', __('words.show_vehicle'))
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
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.vehicles.index')}}">{{__('words.show_vehicles')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_vehicle')}}</li>
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
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">{{__('words.show_vehicle').': '.$vehicle->name}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <!-- sale vehicle images start-->
                                        @if($vehicle->files)
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h4 class="card-title">{{__('words.images')}}</h4>
                                                            </div>
                                                            <div class="card-body">

                                                                <div class="row">
                                                                    @foreach($vehicle->files as $file)
                                                                        @if($file->type != 'vehicle_3D')
                                                                            <div class="col-sm-3 ">
                                                                                <a href="{{$file->path}}"
                                                                                   data-toggle="lightbox"
                                                                                   data-title="{{$vehicle->name}}"
                                                                                   data-gallery="gallery">
                                                                                    <img src="{{$file->path}}"
                                                                                         class="img-fluid mb-2 image-galley"
                                                                                         alt="vehicle image"/>
                                                                                </a>
                                                                            </div>
                                                                        @else
                                                                            <div class="col-sm-3 ">
                                                                                <model-viewer
                                                                                    src="{{$file->path}}"
                                                                                    alt="3d" auto-rotate
                                                                                    camera-controls ar
                                                                                    ios-src="{{$file->path}}"></model-viewer>
                                                                            </div>


                                                                        @endif

                                                                    @endforeach
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endif
                                    <!-- sale vehicle images end-->
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
                                            <th class="show-details-table">{{__('words.availability')}}</th>
                                            <td>{{$vehicle->getAvailability()}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.created_by')}}</th>
                                            <td>{{$vehicle->created_by}}</td>
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

                            @if(auth('web')->user()->hasPermission(['update-vehicles-' . $record->name_en]))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('organization.vehicles.edit',$vehicle->id)}}"
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
