@extends('organization.layouts.app')
@section('title', __('words.show_available_vehicles'))
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
                            <li class="breadcrumb-item active">{{__('words.show_available_vehicles')}}</li>
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
                                <h3 class="card-title">{{__('words.show_available_vehicles')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.image_s')}}</th>
                                        <th>{{__('words.name')}}</th>
                                        <th>{{__('words.brand')}}</th>
                                        <th>{{__('words.car_model')}}</th>
                                        <th>{{__('words.car_class')}}</th>
                                        <th>{{__('words.manufacturing_year')}}</th>
                                        <th>{{__('words.price')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($availableVehicles as $key => $vehicle)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                @if(!$vehicle->one_image)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$vehicle->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$vehicle->one_image}}"
                                                       data-toggle="lightbox" data-title="{{$vehicle->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$vehicle->one_image}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{$vehicle->name}}</td>
                                            <td>{{$vehicle->brand->name}}</td>
                                            <td>{{$vehicle->car_model->name}}</td>
                                            <td>{{$vehicle->car_class->name}}</td>
                                            <td>{{$vehicle->manufacturing_year}}</td>
                                            <td>{{$vehicle->price}}</td>
                                            <td class="action">
                                                @if(auth('web')->user()->hasPermission(['read-available_vehicles-' . $record->name_en]))
                                                    <a href="{{route('organization.available-vehicles.show',$vehicle->id)}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
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
