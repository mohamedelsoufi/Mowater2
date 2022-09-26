@extends('organization.layouts.app')
@section('title', __('words.show_vehicles'))
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
                            <li class="breadcrumb-item active">{{__('words.show_vehicles')}}</li>
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
                                <h3 class="card-title">{{__('words.show_vehicles')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.vehicle_image')}}</th>
                                        <th>{{__('words.s_car_model')}}</th>
                                        <th>{{__('words.s_car_class')}}</th>
                                        <th>{{__('words.vehicle_status')}}</th>
                                        <th>{{__('words.price')}} ({{__('words.bhd')}})</th>
                                        <th>{{__('words.availability')}}</th>
                                        <th>{{__('words.created_by')}}</th>
                                        <th>{{__('words.created_at')}}</th>
                                        <th>{{__('words.updated_at')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($vehicles as $key => $vehicle)
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
                                            <td>{{$vehicle->car_model->name}}</td>
                                            <td>{{$vehicle->car_class->name}}</td>
                                            <td>{{$vehicle->getIsNew()}}</td>
                                            <td>{{$vehicle->price}}</td>
                                            <td>{{$vehicle->getAvailability()}}</td>
                                            <td>{{$vehicle->created_by}}</td>
                                            <td>{{createdAtFormat($vehicle->created_at)}}</td>
                                            <td>{{createdAtFormat($vehicle->created_at) == updatedAtFormat($vehicle->updated_at) ? '--' : updatedAtFormat($vehicle->updated_at)}}</td>
                                            <td class="action">
                                                @if(auth('web')->user()->hasPermission(['read-vehicles-' . $record->name_en]))
                                                    <a href="{{route('organization.vehicles.show',$vehicle->id)}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(auth('web')->user()->hasPermission(['update-vehicles-' . $record->name_en]))
                                                    <a href="{{route('organization.vehicles.edit',$vehicle->id)}}"
                                                       class="btn btn-outline-warning" data-toggle="tooltip"
                                                       title="{{__('words.edit')}}">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                @endif

                                                @if(auth('web')->user()->hasPermission(['delete-vehicles-' . $record->name_en]))
                                                    <a href="" class="btn btn-outline-danger"
                                                       data-toggle="modal"
                                                       data-target="#ModalDelete{{$vehicle->id}}"
                                                       title="{{__('words.delete')}}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @include('organization.vehicles.deleteModal')
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
