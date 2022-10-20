@extends('organization.layouts.app')
@section('title', __('words.show_reservation'))
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
                                    href="{{route('organization.reservations.index')}}">{{__('words.show_reservations')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_reservation')}}</li>
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
                                <h3 class="card-title">{{__('words.show_reservation').': '.$record->name}}</h3>
                            </div>
                            <div class="card-body">
                                {{-- Reservation Details Start --}}
                                <table id="example1" class="table table-bordered table-striped text-center"
                                       style="min-height: 400px; overflow: auto;">
                                    <thead>
                                    <tr>
                                        <th>{{__('words.image_s')}}</th>
                                        <th>{{__('words.name')}}</th>
                                        <th>{{__('words.price')}}</th>
                                        <th>{{__('words.quantity')}}</th>
                                        <th>{{__('words.total_price')}}</th>
                                        <th>{{__('words.availability')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($reservation->products)
                                        @foreach($reservation->products as $key => $product)
                                            <tr>
                                                <td>
                                                    @if(!$product->one_image)
                                                        <a href="{{asset('uploads/default_image.png')}}"
                                                           data-toggle="lightbox"
                                                           data-title="{{$product->name}}"
                                                           data-gallery="gallery">
                                                            <img class="index_image"
                                                                 src="{{asset('uploads/default_image.png')}}"
                                                                 alt="logo">
                                                        </a>
                                                    @else
                                                        <a href="{{$product->one_image}}"
                                                           data-toggle="lightbox"
                                                           data-title="{{$product->name}}"
                                                           data-gallery="gallery">
                                                            <img class="index_image"
                                                                 src="{{$product->one_image}}"
                                                                 onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                                 alt="logo">
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{$product->name}}</td>
                                                <td>{{$product->price}}</td>
                                                <td>{{$product->pivot->quantity}}</td>
                                                <td>{{$product->price * $product->pivot->quantity}}</td>
                                                <td>{{$product->getAvailability()}}</td>
                                                <td class="action">
                                                    @if(auth('web')->user()->hasPermission(['read-products-' . $record->name_en]))
                                                        <a href="{{route('organization.products.show',$product->id)}}"
                                                           class="btn btn-outline-info">
                                                            {{__('words.show_product_details')}}
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    @if($reservation->services)
                                        @foreach($reservation->services as $key => $service)
                                            <tr>
                                                <td>
                                                    @if(!$service->one_image)
                                                        <a href="{{asset('uploads/default_image.png')}}"
                                                           data-toggle="lightbox"
                                                           data-title="{{$service->name}}"
                                                           data-gallery="gallery">
                                                            <img class="index_image"
                                                                 src="{{asset('uploads/default_image.png')}}"
                                                                 alt="logo">
                                                        </a>
                                                    @else
                                                        <a href="{{$service->one_image}}"
                                                           data-toggle="lightbox"
                                                           data-title="{{$service->name}}"
                                                           data-gallery="gallery">
                                                            <img class="index_image"
                                                                 src="{{$service->one_image}}"
                                                                 onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                                 alt="logo">
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{$service->name}}</td>
                                                <td>{{$service->price}}</td>
                                                <td>{{"--"}}</td>
                                                <td>{{"--"}}</td>
                                                <td>{{$service->getAvailability()}}</td>
                                                <td class="action">
                                                    @if(auth('web')->user()->hasPermission(['read-services-' . $record->name_en]))
                                                        <a href="{{route('organization.services.show',$service->id)}}"
                                                           class="btn btn-outline-info">
                                                            {{__('words.show_service_details')}}
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>

                                </table>
                                {{-- Reservation Details End --}}
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-striped">
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
                                            <th class="show-details-table">{{__('words.brand')}}</th>
                                            <td>{{$reservation->brand ? $reservation->brand->name : "--"}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.car_model')}}</th>
                                            <td>{{$reservation->car_model ? $reservation->car_model->name : "--"}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.car_class')}}</th>
                                            <td>{{$reservation->car_class ? $reservation->car_class->name : "--"}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.manufacturing_year')}}</th>
                                            <td>{{$reservation->manufacturing_year}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('vehicle.chassis_number')}}</th>
                                            <td>{{$reservation->chassis_number}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('vehicle.number_plate')}}</th>
                                            <td>{{$reservation->number_plate}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.date')}}</th>
                                            <td>{{date('d/m/Y',strtotime($reservation->date))}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.time')}}</th>
                                            <td>{{date('h:i A',strtotime($reservation->time))}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.home_delivery')}}</th>
                                            <td>{{$reservation->delivery == 1 ? __('vehicle.yes') : __('vehicle.no')}}</td>
                                        </tr>

                                        @if($reservation->getAttribute('delivery') == 1)
                                            <tr>
                                                <th class="show-details-table">{{__('words.address')}}</th>
                                                <td>{{$reservation->address}}</td>
                                            </tr>

                                            <tr>
                                                <th class="show-details-table">{{__('words.distinctive_mark')}}</th>
                                                <td>{{$reservation->distinctive_mark}}</td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th class="show-details-table">{{__('words.is_mowater')}}</th>
                                            <td>{{$reservation->is_mawater_card == "1" ? __('vehicle.yes') : __('vehicle.no')}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.total_price')}}</th>
                                            <td>{{$reservation->price}}</td>
                                        </tr>

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

                            @if(auth('web')->user()->hasPermission(['update-reservations-' . $record->name_en]))
                                <div class="card-footer">
                                    <form method="post"
                                          action="{{route('organization.reservations.update',$reservation->id)}}"
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
