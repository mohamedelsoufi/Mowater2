@extends('organization.layouts.app')
@section('title', __('words.show_rental_car'))
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
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.home')}}">{{__('words.home')}}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.rental-office-cars.index')}}">{{__('words.show_rental_cars')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_rental_car')}}</li>
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
                                <h3 class="card-title">{{__('words.show_rental_car').': '.$car->name}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <!-- sale vehicle images start-->
                                        @if($car->files)
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h4 class="card-title">{{__('words.images')}}</h4>
                                                            </div>
                                                            <div class="card-body">

                                                                <div class="row">
                                                                    @foreach($car->files as $file)
                                                                        <div class="col-sm-3 ">
                                                                            <a href="{{$file->path}}"
                                                                               data-toggle="lightbox"
                                                                               data-title="{{$car->name}}"
                                                                               data-gallery="gallery">
                                                                                <img src="{{$file->path}}"
                                                                                     class="img-fluid mb-2 image-galley"
                                                                                     alt="vehicle image"/>
                                                                            </a>
                                                                        </div>
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
                                            <th class="show-details-table">{{__('vehicle.vehicle_type')}}</th>
                                            <td>{{$car->vehicle_type}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.brand')}}</th>
                                            <td>{{$car->brand ? $car->brand->name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.car_model')}}</th>
                                            <td>{{$car->car_model ? $car->car_model->name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.car_class')}}</th>
                                            <td>{{$car->car_class ? $car->car_class->name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.manufacturing_year')}}</th>
                                            <td>{{$car->manufacture_year}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.color')}}</th>
                                            <td>{{$car->color ? $car->color->name : "--"}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.features')}}</th>
                                            <td>
                                                <table class="table table-striped">
                                                    @foreach($properties as $val)
                                                        <tr>
                                                            <td>{{$val->name}}</td>
                                                            <td>{{$val->description}}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.daily_rental_price')}}</th>
                                            <td>{{$car->daily_rental_price}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.weekly_rental_price')}}</th>
                                            <td>{{$car->weekly_rental_price}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.monthly_rental_price')}}</th>
                                            <td>{{$car->monthly_rental_price}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.yearly_rental_price')}}</th>
                                            <td>{{$car->yearly_rental_price}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.number_of_views')}}</th>
                                            <td>{{$car->number_of_views}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.active_number_of_views')}}</th>
                                            <td>{{$car->getActiveNumberOfViews()}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.activity')}}</th>
                                            <td>{{$car->getActive()}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.availability')}}</th>
                                            <td>{{$car->getAvailability()}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.created_by')}}</th>
                                            <td>{{$car->created_by}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($car->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($car->created_at) == updatedAtFormat($car->updated_at) ? '--' : updatedAtFormat($car->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>

                            </div>

                            @if(auth('web')->user()->hasPermission(['update-rental_office_cars-' . $record->name_en]))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('organization.rental-office-cars.edit',$car->id)}}"
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
