@extends('organization.layouts.app')
@section('title', __('words.show_vehicles_reservations'))
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
                            <li class="breadcrumb-item active">{{__('words.show_vehicles_reservations')}}</li>
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
                                <h3 class="card-title">{{__('words.show_vehicles_reservations')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.image_s')}}</th>
                                        <th>{{__('words.name')}}</th>
                                        <th>{{__('words.phone')}}</th>
                                        <th>{{__('words.vehicle')}}</th>
                                        <th>{{__('words.status')}}</th>
                                        @if($record->getTable() != 'branches')
                                            <th>{{__('words.branch')}}</th>
                                        @endif
                                        <th>{{__('words.created_at')}}</th>
                                        <th>{{__('words.updated_at')}}</th>
                                        <th>{{__('words.action_by')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reservations as $key => $reservation)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                @if(!$reservation->vehicle->one_image)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox"
                                                       data-title="{{$reservation->vehicle->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$reservation->vehicle->one_image}}"
                                                       data-toggle="lightbox"
                                                       data-title="{{$reservation->vehicle->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$reservation->vehicle->one_image}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{$reservation->nickname . ' ' . $reservation->first_name . ' ' . $reservation->last_name}}</td>
                                            <td dir="ltr">{{$reservation->country_code . ' ' . $reservation->phone}}</td>
                                            <td>{{$reservation->vehicle->name}}</td>
                                            <td>{{__('words.'.$reservation->status)}}</td>
                                            @if($record->getTable() != 'branches')
                                                <td>{{$reservation->branch->name}}</td>
                                            @endif
                                            <td>{{createdAtFormat($reservation->created_at)}}</td>
                                            <td>{{createdAtFormat($reservation->created_at) == updatedAtFormat($reservation->updated_at) ? '--' : updatedAtFormat($reservation->updated_at)}}</td>
                                            <td>{{$reservation->action_by ? $reservation->action_by : "--"}}</td>
                                            <td class="action">
                                                @if(auth('web')->user()->hasPermission(['read-reserve_vehicles-' . $record->name_en]))
                                                    <a href="{{route('organization.vehicle-reservations.show',$reservation->id)}}"
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
