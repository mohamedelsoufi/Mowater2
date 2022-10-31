@extends('admin.layouts.standard')
@section('title', __('words.show_used_vehicles'))
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
                            <li class="breadcrumb-item active">{{__('words.show_used_vehicles')}}</li>
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

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{__('words.show_used_vehicles')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.vehicle_image')}}</th>
                                        <th>{{__('words.name')}}</th>
                                        <th>{{__('words.manufacturing_year')}}</th>
                                        <th>{{__('words.price')}}</th>
                                        <th>{{__('words.activity')}}</th>
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
                                                @if(!$vehicle->files()->where('type','front_side_image')->first())
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$vehicle->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$vehicle->files()->where('type','front_side_image')->first()->path}}"
                                                       data-toggle="lightbox" data-title="{{$vehicle->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$vehicle->files()->where('type','front_side_image')->first()->path}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{$vehicle->name}}</td>
                                            <td>{{$vehicle->manufacturing_year}}</td>
                                            <td>{{$vehicle->price}}</td>
                                            <td>{{$vehicle->getActive()}}</td>
                                            <td>{{$vehicle->vehicable->email}}</td>
                                            <td>{{createdAtFormat($vehicle->created_at)}}</td>
                                            <td>{{createdAtFormat($vehicle->created_at) == updatedAtFormat($vehicle->updated_at) ? '--' : updatedAtFormat($vehicle->updated_at)}}</td>
                                            <td class="action">
                                                @if(auth('admin')->user()->hasPermission('read-used_vehicles'))
                                                    <a href="{{route('used-vehicles.show',$vehicle->id)}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('update-used_vehicles'))
                                                    <a href="{{route('used-vehicles.edit',$vehicle->id)}}" data-toggle="tooltip"
                                                       title="{{__('words.edit')}}"
                                                       class="btn btn-outline-warning"> <i class="fas fa-pen"></i></a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('delete-used_vehicles'))
                                                    <a href="" class="btn btn-outline-danger"
                                                       data-toggle="modal"
                                                       data-target="#ModalDelete{{$vehicle->id}}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @include('admin.vehicle_details.usedVehicles.deleteModal')
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
