@extends('organization.layouts.app')
@section('title', __('words.show_rental_cars'))
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
                            <li class="breadcrumb-item active">{{__('words.show_rental_cars')}}</li>
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
                                <h3 class="card-title">{{__('words.show_rental_cars')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.vehicle_image')}}</th>
                                        <th>{{__('words.name')}}</th>
                                        <th>{{__('vehicle.vehicle_type')}}</th>
                                        <th>{{__('words.availability')}}</th>
                                        <th>{{__('words.activity')}}</th>
                                        <th>{{__('words.created_by')}}</th>
                                        <th>{{__('words.created_at')}}</th>
                                        <th>{{__('words.updated_at')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cars as $key => $car)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                @if(!$car->one_image)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$car->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$car->one_image}}"
                                                       data-toggle="lightbox" data-title="{{$car->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$car->one_image}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{$car->name}}</td>
                                            <td>{{$car->vehicle_type}}</td>
                                            <td>{{$car->getAvailability()}}</td>
                                            <td>{{$car->getActive()}}</td>
                                            <td>{{$car->created_by}}</td>
                                            <td>{{createdAtFormat($car->created_at)}}</td>
                                            <td>{{createdAtFormat($car->created_at) == updatedAtFormat($car->updated_at) ? '--' : updatedAtFormat($car->updated_at)}}</td>
                                            <td class="action">
                                                @if(auth('web')->user()->hasPermission(['read-rental_office_cars-' . $record->name_en]))
                                                    <a href="{{route('organization.rental-office-cars.show',$car->id)}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(auth('web')->user()->hasPermission(['update-rental_office_cars-' . $record->name_en]))
                                                    <a href="{{route('organization.rental-office-cars.edit',$car->id)}}"
                                                       class="btn btn-outline-warning" data-toggle="tooltip"
                                                       title="{{__('words.edit')}}">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                @endif

                                                @if(auth('web')->user()->hasPermission(['delete-rental_office_cars-' . $record->name_en]))
                                                    <a href="" class="btn btn-outline-danger"
                                                       data-toggle="modal"
                                                       data-target="#ModalDelete{{$car->id}}"
                                                       title="{{__('words.delete')}}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @include('organization.rentalOfficeCars.deleteModal')
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
