@extends('organization.layouts.app')
@section('title', __('words.show_vehicle_reservation'))
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
                                    href="{{route('organization.vehicle-reservations.index')}}">{{__('words.show_vehicles_reservations')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_vehicle_reservation')}}</li>
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
                                <h3 class="card-title">{{__('words.show_vehicle_reservation').': '.$record->name}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        {{-- vehicle data start --}}
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h4 class="card-title">{{__('words.vehicle_details')}}</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                @foreach($reservation->vehicle->files as $file)
                                                                    @if($file->type != 'vehicle_3D')
                                                                        <div class="col-sm-3 ">
                                                                            <a href="{{$file->path}}"
                                                                               data-toggle="lightbox"
                                                                               data-title="{{$reservation->vehicle->name}}"
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

                                                        @if(auth('web')->user()->hasPermission(['read-available_vehicles-' . $record->name_en]))
                                                            <div class="card-footer">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <a href="{{route('organization.available-vehicles.show',$reservation->vehicle->id)}}"
                                                                           class="btn btn-outline-info">
                                                                            {{__('words.show_vehicle_details')}}
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- vehicle data end --}}
                                        <tr>
                                            <th class="show-details-table">{{__('words.nickname')}}</th>
                                            <td>{{$reservation->nickname}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.first_name')}}</th>
                                            <td>{{$reservation->first_name}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.last_name')}}</th>
                                            <td>{{$reservation->last_name}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.nationality')}}</th>
                                            <td>{{$reservation->nationality}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.country_code')}}</th>
                                            <td>{{$reservation->country_code}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.phone')}}</th>
                                            <td>{{$reservation->phone}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.id_number')}}</th>
                                            <td>{{$reservation->id_number}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.id_type')}}</th>
                                            <td>{{ __('words.'.$reservation->id_type)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.personal_ID')}}</th>
                                            <td>
                                                @if(!$reservation->files()->where('type','personal_ID')->first())
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox"
                                                       data-title="{{$reservation->nickname . ' ' . $reservation->first_name . ' ' . $reservation->last_name}}">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}"
                                                             alt="personal_ID">
                                                    </a>
                                                @else
                                                    <a href="{{$reservation->files()->where('type','personal_ID')->first()->path}}"
                                                       data-toggle="lightbox"
                                                       data-title="{{$reservation->nickname . ' ' . $reservation->first_name . ' ' . $reservation->last_name}}">
                                                        <img class="index_image"
                                                             src="{{$reservation->files()->where('type','personal_ID')->first()->path}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="personal_ID">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.driving_license')}}</th>
                                            <td>
                                                @if(!$reservation->files()->where('type','driving_license')->first())
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox"
                                                       data-title="{{__('words.driving_license')}}">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}"
                                                             alt="driving_license">
                                                    </a>
                                                @else
                                                    <a href="{{$reservation->files()->where('type','driving_license')->first()->path}}"
                                                       data-toggle="lightbox"
                                                       data-title="{{__('words.driving_license')}}">
                                                        <img class="index_image"
                                                             src="{{$reservation->files()->where('type','driving_license')->first()->path}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="driving_license">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.price')}}</th>
                                            <td>{{$reservation->price}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.is_mowater')}}</th>
                                            <td>{{$reservation->is_mawater_card == "1" ? __('vehicle.yes') : __('vehicle.no')}}</td>
                                        </tr>

                                        @if($record->getTable() != 'branches')
                                            <tr>
                                                <th class="show-details-table">{{__('words.branch')}}</th>
                                                <td>{{$reservation->branch->name}}</td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th class="show-details-table">{{__('words.status')}}</th>
                                            <td>{{__('words.'.$reservation->status)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($reservation->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($reservation->created_at) == updatedAtFormat($reservation->updated_at) ? '--' : updatedAtFormat($reservation->updated_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.action_by')}}</th>
                                            <td>{{$reservation->action_by ? $reservation->action_by : "--"}}</td>
                                        </tr>

                                    </table>
                                </div>

                            </div>

                            @if(auth('web')->user()->hasPermission(['update-reserve_vehicles-' . $record->name_en]))
                                <div class="card-footer">
                                    <form method="post"
                                          action="{{route('organization.vehicle-reservations.update',$reservation->id)}}"
                                          autocomplete="off"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{$reservation->id}}">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label>
                                                    {{__('words.status')}}
                                                </label>
                                                <select name="status"
                                                        {{$reservation->status != "pending" ? "disabled" : ""}}
                                                        class="form-control @error('status') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(ad_status_arr() as $key=>$value)
                                                        <option value="{{$key}}"
                                                            {{ old('status',$reservation->status) == $key ? "selected" : "" }}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                        @if($reservation->status == "pending")
                                            <div class="row">
                                                <div class="col-4">
                                                    <button type="submit" class="btn btn-block btn-outline-info">
                                                        {{__('words.update')}}
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </form>
                                </div>
                            @endif
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
