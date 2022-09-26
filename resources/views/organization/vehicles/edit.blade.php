@extends('organization.layouts.app')
@section('title', __('words.edit_vehicle'))
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
                                    href="{{route('organization.vehicles.index')}}">{{__('words.show_vehicles')}}</a></li>

                            <li class="breadcrumb-item active">{{__('words.edit_vehicle')}}</li>
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
                                <h3 class="card-title">{{__('words.edit_vehicle')}}</h3>
                            </div>
                            <form method="post" action="{{route('organization.vehicles.update',$vehicle->id)}}"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <input type="hidden" name="id" value="{{$vehicle->id}}">
                                    <div class="basic-form">
                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('words.brand')}}</label>
                                                <select name="brand_id"
                                                        class="form-control brand_id @error('brand_id') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach($brands as $brand)
                                                        @if (Input::old('brand_id') == $brand->id)
                                                            <option selected
                                                                    value="{{$brand->id}}">{{$brand->name}}</option>
                                                        @else
                                                            <option
                                                                value="{{$brand->id}}" {{$vehicle->brand_id == $brand->id ? "selected" : ""}}>{{$brand->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('brand_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.car_model')}}</label>
                                                <select name="car_model_id"
                                                        class="form-control car_model_id @error('car_model_id') is-invalid @enderror">
                                                    @if(old('brand_id'))
                                                        @foreach(\App\Models\CarModel::where('brand_id',old('brand_id'))->get() as $model)
                                                            @if (Input::old('car_model_id') == $model->id)

                                                                <option value="{{ $model->id }}"
                                                                        selected>{{ $model->name }}</option>
                                                            @else
                                                                <option
                                                                    value="{{ $model->id }}" {{$vehicle->car_model_id == $model->id ? "selected" : ""}}>
                                                                    {{ $model->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('car_model_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.car_class')}}</label>
                                                <select name="car_class_id"
                                                        class="form-control car_class_id @error('car_class_id') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach($car_classes as $car_class)
                                                        @if (Input::old('car_class_id') == $car_class->id)
                                                            <option selected
                                                                    value="{{$car_class->id}}">{{$car_class->name}}</option>
                                                        @else
                                                            <option
                                                                value="{{$car_class->id}}" {{$vehicle->car_class_id == $car_class->id ? "selected" : ""}}>{{$car_class->name}}</option>

                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('car_class_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.vehicle_type')}}</label>
                                                <select name="vehicle_type"
                                                        class="form-control @error('vehicle_type') is-invalid @enderror">
                                                    @foreach(vehicle_type_arr() as $key => $val)
                                                        <option
                                                            value="{{$key}}">{{$val}}</option>
                                                    @endforeach
                                                </select>
                                                @error('vehicle_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.manufacturing_year')}}</label>
                                                <input type="text" name="manufacturing_year" min="1900"
                                                       class="yearpicker form-control @error('manufacturing_year') is-invalid @enderror"
                                                       value="{{ old('manufacturing_year',$vehicle->manufacturing_year) }}"
                                                       placeholder="{{__('vehicle.manufacturing_year')}}">

                                                @error('manufacturing_year')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.engine_size')}}</label>
                                                <select name="engine_size"
                                                        class="form-control select2 select2-primary @error('engine_size') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(engine_size_arr() as $key => $val)
                                                        <option
                                                            value="{{$key}}" {{old('engine_size',$vehicle->engine_size) == $key ? "selected" : ""}}>{{$val}}</option>
                                                    @endforeach
                                                </select>
                                                @error('engine_size')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.outside_color')}}</label>
                                                <select name="outside_color_id"
                                                        class="form-control @error('outside_color_id') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach($colors as $color)
                                                        <option value="{{$color->id}}"
                                                            {{ old('outside_color_id',$vehicle->outside_color_id) == $color->id ? "selected" : "" }}>{{$color->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('outside_color_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.inside_color')}}</label>
                                                <select name="inside_color_id"
                                                        class="form-control @error('inside_color_id') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach($colors as $color)
                                                        <option value="{{$color->id}}"
                                                            {{ old('inside_color_id',$vehicle->inside_color_id) == $color->id ? "selected" : "" }}>{{$color->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('inside_color_id')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.transmission_type')}}</label>
                                                <select name="transmission_type"
                                                        class="form-control @error('transmission_type') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(transmission_type_arr() as $key=>$value)
                                                        <option value="{{$key}}"
                                                            {{ old('transmission_type',$vehicle->transmission_type) == $key ? "selected" : "" }}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @error('transmission_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.cylinder_number')}}</label>
                                                <select name="cylinder_number"
                                                        class="form-control @error('cylinder_number') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(cylinder_number_arr() as $key=>$value)
                                                        <option value="{{$key}}"
                                                            {{ old('cylinder_number',$vehicle->cylinder_number) == $key ? "selected" : "" }}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @error('cylinder_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.fuel_type')}}</label>
                                                <select name="fuel_type"
                                                        class="form-control @error('fuel_type') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(fuel_type_arr() as $key=>$value)
                                                        <option value="{{$key}}"
                                                            {{ old('fuel_type',$vehicle->fuel_type) == $key ? "selected" : "" }}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @error('fuel_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.wheel_drive_system')}}</label>
                                                <select name="wheel_drive_system"
                                                        class="form-control @error('wheel_drive_system') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(wheel_drive_system_arr() as $key=>$value)
                                                        <option value="{{$key}}"
                                                            {{ old('wheel_drive_system',$vehicle->wheel_drive_system) == $key ? "selected" : "" }}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @error('wheel_drive_system')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.specifications')}}</label>
                                                <select name="specifications"
                                                        class="form-control @error('specifications') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(specifications_arr() as $key=>$value)
                                                        <option value="{{$key}}"
                                                            {{ old('specifications',$vehicle->specifications) == $key ? "selected" : "" }}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @error('specifications')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.start_with_fingerprint')}}</label>
                                                <select name="start_with_fingerprint"
                                                        class="form-control @error('start_with_fingerprint') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    <option value="0"
                                                        {{ old('start_with_fingerprint',$vehicle->start_with_fingerprint) == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                    <option value="1"
                                                        {{ old('start_with_fingerprint',$vehicle->start_with_fingerprint) == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                </select>
                                                @error('start_with_fingerprint')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.remote_start')}}</label>
                                                <select name="remote_start"
                                                        class="form-control @error('remote_start') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    <option value="0"
                                                        {{ old('remote_start',$vehicle->remote_start) == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                    <option value="1"
                                                        {{ old('remote_start',$vehicle->remote_start) == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                </select>
                                                @error('remote_start')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.screen')}}</label>
                                                <select name="screen"
                                                        class="form-control @error('screen') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    <option value="0"
                                                        {{ old('screen',$vehicle->screen) == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                    <option value="1"
                                                        {{ old('screen',$vehicle->screen) == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                </select>
                                                @error('screen')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.seat_upholstery')}}</label>
                                                <select name="seat_upholstery"
                                                        class="form-control @error('seat_upholstery') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(seat_upholstery_arr() as $key=>$value)
                                                        <option value="{{$key}}"
                                                            {{ old('seat_upholstery',$vehicle->seat_upholstery) == $key ? "selected" : "" }}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @error('seat_upholstery')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.windows_control')}}</label>
                                                <select name="windows_control"
                                                        class="form-control @error('windows_control') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(windows_control_arr() as $key=>$value)
                                                        <option value="{{$key}}"
                                                            {{ old('windows_control',$vehicle->windows_control) == $key ? "selected" : "" }}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @error('windows_control')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.chassis_number')}}</label>
                                                <input type="text" name="chassis_number"
                                                       class="form-control @error('chassis_number') is-invalid @enderror"
                                                       value="{{ old('chassis_number',$vehicle->chassis_number) }}"
                                                       placeholder="{{__('vehicle.chassis_number')}}">

                                                @error('chassis_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.wheel_size')}}</label>
                                                <select name="wheel_size" id="single-select"
                                                        class="form-control select2 select2-primary @error('wheel_size') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(wheel_size_arr() as $key=>$value)
                                                        <option value="{{$key}}"
                                                            {{ old('wheel_size',$vehicle->wheel_size) == $key ? "selected" : "" }}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @error('wheel_size')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.wheel_type')}}</label>
                                                <select name="wheel_type"
                                                        class="form-control @error('wheel_type') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(wheel_type_arr() as $key=>$value)
                                                        <option value="{{$key}}"
                                                            {{ old('wheel_type',$vehicle->wheel_type) == $key ? "selected" : "" }}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @error('wheel_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.sunroof')}}</label>
                                                <select name="sunroof"
                                                        class="form-control @error('sunroof') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(sunroof_arr() as $key=>$value)
                                                        <option value="{{$key}}"
                                                            {{ old('sunroof',$vehicle->sunroof) == $key ? "selected" : "" }}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @error('sunroof')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.doors_number')}}</label>
                                                <input name="doors_number"
                                                       value="{{old('doors_number',$vehicle->doors_number)}}"
                                                       class="form-control @error('doors_number') is-invalid @enderror"
                                                       placeholder="4, 2, ...">
                                                @error('doors_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.electric_back_door')}}</label>
                                                <select name="electric_back_door"
                                                        class="form-control @error('electric_back_door') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    <option value="0"
                                                        {{ old('electric_back_door',$vehicle->electric_back_door) == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                    <option value="1"
                                                        {{ old('electric_back_door',$vehicle->electric_back_door) == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                </select>
                                                @error('electric_back_door')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.start_engine_with_button')}}</label>
                                                <select name="start_engine_with_button"
                                                        class="form-control @error('start_engine_with_button') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    <option value="0"
                                                        {{ old('start_engine_with_button',$vehicle->start_engine_with_button) == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                    <option value="1"
                                                        {{ old('start_engine_with_button',$vehicle->start_engine_with_button) == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                </select>
                                                @error('start_engine_with_button')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.seat_adjustment')}}</label>
                                                <select name="seat_adjustment"
                                                        class="form-control @error('seat_adjustment') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    <option value="0"
                                                        {{ old('seat_adjustment',$vehicle->seat_adjustment) == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                    <option value="1"
                                                        {{ old('seat_adjustment',$vehicle->seat_adjustment) == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                </select>
                                                @error('seat_adjustment')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.seat_heating_cooling_function')}}</label>
                                                <select name="seat_heating_cooling_function"
                                                        class="form-control @error('seat_heating_cooling_function') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    <option value="0"
                                                        {{ old('seat_heating_cooling_function',$vehicle->seat_heating_cooling_function) == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                    <option value="1"
                                                        {{ old('seat_heating_cooling_function',$vehicle->seat_heating_cooling_function) == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                </select>
                                                @error('seat_heating_cooling_function')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.seat_massage_feature')}}</label>
                                                <select name="seat_massage_feature"
                                                        class="form-control @error('seat_massage_feature') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    <option value="0"
                                                        {{ old('seat_massage_feature',$vehicle->seat_massage_feature) == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                    <option value="1"
                                                        {{ old('seat_massage_feature',$vehicle->seat_massage_feature) == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                </select>
                                                @error('seat_massage_feature')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.seat_memory_feature')}}</label>
                                                <select name="seat_memory_feature"
                                                        class="form-control @error('seat_memory_feature') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    <option value="0"
                                                        {{ old('seat_memory_feature',$vehicle->seat_memory_feature) == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                    <option value="1"
                                                        {{ old('seat_memory_feature',$vehicle->seat_memory_feature) == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                </select>
                                                @error('seat_memory_feature')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.fog_lights')}}</label>
                                                <select name="fog_lights"
                                                        class="form-control @error('fog_lights') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    <option value="0"
                                                        {{ old('fog_lights',$vehicle->fog_lights) == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                    <option value="1"
                                                        {{ old('fog_lights',$vehicle->fog_lights) == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                </select>
                                                @error('fog_lights')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.front_lighting')}}</label>
                                                <select name="front_lighting"
                                                        class="form-control @error('front_lighting') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(front_lighting_arr() as $key=>$value)
                                                        <option value="{{$key}}"
                                                            {{ old('front_lighting',$vehicle->front_lighting) == $key ? "selected" : "" }}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @error('front_lighting')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.air_conditioning_system')}}</label>
                                                <select name="air_conditioning_system"
                                                        class="form-control @error('air_conditioning_system') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(air_conditioning_system_arr() as $key=>$value)
                                                        <option value="{{$key}}"
                                                            {{ old('air_conditioning_system',$vehicle->air_conditioning_system) == $key ? "selected" : "" }}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @error('air_conditioning_system')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.battery_size')}}</label>
                                                <input type="text" name="battery_size"
                                                       class="form-control @error('battery_size') is-invalid @enderror"
                                                       value="{{ old('battery_size',$vehicle->battery_size) }}"
                                                       placeholder="{{__('vehicle.battery_size')}}">

                                                @error('battery_size')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div
                                                class="form-group {{$record->getTable() == 'agencies' ? "col-md-4" : "col-md-3"}}">
                                                <label>{{__('words.price')}}</label>
                                                <input type="number" name="price" step="0.01" min="0"
                                                       value="{{old('price',$vehicle->price)}}"
                                                       class="form-control @error('price') is-invalid @enderror"
                                                       placeholder="{{__('words.price')}}">

                                                @error('price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div
                                                class="form-group {{$record->getTable() == 'agencies' ? "col-md-4" : "col-md-3"}}">
                                                <label>{{__('words.discount_type')}}</label>
                                                <select name="discount_type"
                                                        class="form-control @error('discount_type') is-invalid @enderror">
                                                    <option value="">{{__('words.none')}}</option>
                                                    <option
                                                        value="percentage" {{ old('discount_type',$vehicle->discount_type) == 'percentage' ? "selected" : "" }}>{{__('words.percentage')}}</option>
                                                    <option
                                                        value="amount" {{ old('discount_type',$vehicle->discount_type) == 'amount' ? "selected" : "" }}>{{__('words.amount')}}</option>

                                                </select>
                                                @error('discount_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div
                                                class="form-group {{$record->getTable() == 'agencies' ? "col-md-4" : "col-md-3"}}">
                                                <label>{{__('words.discount_value')}}</label>
                                                <input type="number" name="discount" step="0.01" min="1"
                                                       value="{{old('discount',$vehicle->discount)}}"
                                                       class="form-control @error('discount') is-invalid @enderror"
                                                       placeholder="{{__('words.discount_value')}}">

                                                @error('discount')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div
                                                class="form-group {{$record->getTable() == 'agencies' ? "d-none" : "col-md-4"}}">
                                                <label>{{__('words.vehicle_status')}}</label>
                                                <select name="is_new" id="is_new"
                                                        class="form-control @error('is_new') is-invalid @enderror">
                                                    <option
                                                        value="1" {{ old('is_new',$vehicle->is_new) == '1' ? "selected" : "" }}>{{__('vehicle.new')}}</option>
                                                    <option
                                                        value="0" {{ old('is_new',$vehicle->is_new) == '0' ? "selected" : "" }}>{{__('vehicle.used')}}</option>
                                                </select>
                                                @error('is_new')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{--  for used start --}}
                                        <div id="show_for_used" class="d-none">

                                            <div class="form-row mb-3">
                                                <div class="form-group col-md-4">
                                                    <label>{{__('vehicle.traveled_distance')}}</label>
                                                    <input type="number" name="traveled_distance" step="0.01" min="0"
                                                           value="{{old('traveled_distance',$vehicle->traveled_distance)}}"
                                                           class="form-control @error('traveled_distance') is-invalid @enderror"
                                                           placeholder="{{__('vehicle.traveled_distance')}}">

                                                    @error('traveled_distance')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>
                                                        {{__('vehicle.traveled_distance_type')}}
                                                    </label>
                                                    <select name="traveled_distance_type"
                                                            class="form-control @error('traveled_distance_type') is-invalid @enderror">
                                                        <option value="">{{__('words.choose')}}</option>
                                                        <option value="km"
                                                            {{ old('traveled_distance_type',$vehicle->traveled_distance_type) == "km" ? "selected" : "" }}>{{__('vehicle.km')}}</option>
                                                        <option value="mile"
                                                            {{ old('traveled_distance_type',$vehicle->traveled_distance_type) == "mile" ? "selected" : "" }}>{{__('vehicle.mile')}}</option>
                                                    </select>
                                                    @error('traveled_distance_type')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>
                                                        {{__('vehicle.car_status')}}
                                                    </label>
                                                    <select name="status"
                                                            class="form-control @error('status') is-invalid @enderror">
                                                        <option value="">{{__('words.choose')}}</option>
                                                        @foreach(status_arr() as $key=>$value)
                                                            <option value="{{$key}}"
                                                                {{ old('status',$vehicle->status) == $key ? "selected" : "" }}>{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-row mb-3">
                                                <div class="form-group col-md-4">
                                                    <label>
                                                        {{__('vehicle.guarantee')}}
                                                    </label>
                                                    <select name="guarantee" id="guarantee"
                                                            class="form-control @error('guarantee') is-invalid @enderror">
                                                        <option value="">{{__('words.choose')}}</option>
                                                        <option value="0"
                                                            {{ old('guarantee',$vehicle->guarantee) == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                        <option value="1"
                                                            {{ old('guarantee',$vehicle->guarantee) == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                    </select>
                                                    @error('guarantee')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-4 show_for_guarantee d-none">
                                                    <label>
                                                        {{__('vehicle.year')}}
                                                    </label>
                                                    <input type="number" name="guarantee_year" min="1900"
                                                           value="{{old('guarantee_year',$vehicle->guarantee_year)}}"
                                                           class="yearpicker guarantee_year form-control @error('guarantee_year') is-invalid @enderror">
                                                    @error('guarantee_year')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-4 show_for_guarantee d-none">
                                                    <label>
                                                        {{__('vehicle.month')}}
                                                    </label>
                                                    <select type="number" name="guarantee_month"
                                                            class="form-control @error('guarantee_month') is-invalid @enderror">
                                                        <option value="">{{__('words.choose')}}</option>
                                                        <option
                                                            {{ old('guarantee_month',$vehicle->guarantee_month) == "01" ? "selected" : "" }} value="01">{{__('words.january')}}</option>
                                                        <option
                                                            {{ old('guarantee_month',$vehicle->guarantee_month) == "02" ? "selected" : "" }} value="02">{{__('words.february')}}</option>
                                                        <option
                                                            {{ old('guarantee_month',$vehicle->guarantee_month) == "03" ? "selected" : "" }} value="03">{{__('words.march')}}</option>
                                                        <option
                                                            {{ old('guarantee_month',$vehicle->guarantee_month) == "04" ? "selected" : "" }} value="04">{{__('words.april')}}</option>
                                                        <option
                                                            {{ old('guarantee_month',$vehicle->guarantee_month) == "05" ? "selected" : "" }} value="05">{{__('words.may')}}</option>
                                                        <option
                                                            {{ old('guarantee_month',$vehicle->guarantee_month) == "06" ? "selected" : "" }} value="06">{{__('words.june')}}</option>
                                                        <option
                                                            {{ old('guarantee_month',$vehicle->guarantee_month) == "07" ? "selected" : "" }} value="07">{{__('words.july')}}</option>
                                                        <option
                                                            {{ old('guarantee_month',$vehicle->guarantee_month) == "08" ? "selected" : "" }} value="08">{{__('words.august')}}</option>
                                                        <option
                                                            {{ old('guarantee_month',$vehicle->guarantee_month) == "09" ? "selected" : "" }} value="09">{{__('words.september')}}</option>
                                                        <option
                                                            {{ old('guarantee_month',$vehicle->guarantee_month) == "10" ? "selected" : "" }} value="10">{{__('words.october')}}</option>
                                                        <option
                                                            {{ old('guarantee_month',$vehicle->guarantee_month) == "11" ? "selected" : "" }} value="11">{{__('words.november')}}</option>
                                                        <option
                                                            {{ old('guarantee_month',$vehicle->guarantee_month) == "12" ? "selected" : "" }} value="12">{{__('words.december')}}</option>
                                                    </select>
                                                    @error('guarantee_month')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-row mb-3">
                                                <div class="form-group col-md-4">
                                                    <label>
                                                        {{__('vehicle.insurance')}}
                                                    </label>
                                                    <select name="insurance" id="insurance"
                                                            class="form-control @error('insurance') is-invalid @enderror">
                                                        <option value="">{{__('words.choose')}}</option>
                                                        <option value="0"
                                                            {{ old('insurance',$vehicle->insurance) == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                        <option value="1"
                                                            {{ old('insurance',$vehicle->insurance) == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                    </select>
                                                    @error('insurance')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-4 show_for_insurance d-none">
                                                    <label>
                                                        {{__('vehicle.year')}}
                                                    </label>
                                                    <input type="number" name="insurance_year" min="1900"
                                                           value="{{old('insurance_year',$vehicle->insurance_year)}}"
                                                           class="yearpicker insurance_year form-control @error('insurance_year') is-invalid @enderror">
                                                    @error('insurance_year')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-4 show_for_insurance d-none">
                                                    <label>
                                                        {{__('vehicle.month')}}
                                                    </label>
                                                    <select type="number" name="insurance_month"
                                                            class="form-control @error('insurance_month') is-invalid @enderror">
                                                        <option value="">{{__('words.choose')}}</option>
                                                        <option
                                                            {{ old('insurance_month',$vehicle->insurance_month) == "01" ? "selected" : "" }} value="01">{{__('words.january')}}</option>
                                                        <option
                                                            {{ old('insurance_month',$vehicle->insurance_month) == "02" ? "selected" : "" }} value="02">{{__('words.february')}}</option>
                                                        <option
                                                            {{ old('insurance_month',$vehicle->insurance_month) == "03" ? "selected" : "" }} value="03">{{__('words.march')}}</option>
                                                        <option
                                                            {{ old('insurance_month',$vehicle->insurance_month) == "04" ? "selected" : "" }} value="04">{{__('words.april')}}</option>
                                                        <option
                                                            {{ old('insurance_month',$vehicle->insurance_month) == "05" ? "selected" : "" }} value="05">{{__('words.may')}}</option>
                                                        <option
                                                            {{ old('insurance_month',$vehicle->insurance_month) == "06" ? "selected" : "" }} value="06">{{__('words.june')}}</option>
                                                        <option
                                                            {{ old('insurance_month',$vehicle->insurance_month) == "07" ? "selected" : "" }} value="07">{{__('words.july')}}</option>
                                                        <option
                                                            {{ old('insurance_month',$vehicle->insurance_month) == "08" ? "selected" : "" }} value="08">{{__('words.august')}}</option>
                                                        <option
                                                            {{ old('insurance_month',$vehicle->insurance_month) == "09" ? "selected" : "" }} value="09">{{__('words.september')}}</option>
                                                        <option
                                                            {{ old('insurance_month',$vehicle->insurance_month) == "10" ? "selected" : "" }} value="10">{{__('words.october')}}</option>
                                                        <option
                                                            {{ old('insurance_month',$vehicle->insurance_month) == "11" ? "selected" : "" }} value="11">{{__('words.november')}}</option>
                                                        <option
                                                            {{ old('insurance_month',$vehicle->insurance_month) == "12" ? "selected" : "" }} value="12">{{__('words.december')}}</option>
                                                    </select>
                                                    @error('insurance_month')
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-row mb-3">
                                                <div class="form-group col-md-3">
                                                    <label>
                                                        {{__('vehicle.coverage_type')}}
                                                    </label>
                                                    <select name="coverage_type"
                                                            class="form-control @error('coverage_type') is-invalid @enderror">
                                                        <option value="">{{__('words.choose')}}</option>
                                                        @foreach(coverage_type_arr() as $key=>$value)
                                                            <option value="{{$key}}"
                                                                {{ old('coverage_type',$vehicle->coverage_type) == $key ? "selected" : "" }}>{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('coverage_type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label>
                                                        {{__('vehicle.selling_by_plate')}}
                                                    </label>
                                                    <select name="selling_by_plate" id="selling_by_plate"
                                                            class="form-control @error('selling_by_plate') is-invalid @enderror">
                                                        <option value="">{{__('words.choose')}}</option>
                                                        <option value="0"
                                                            {{ old('selling_by_plate',$vehicle->selling_by_plate) == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                        <option value="1"
                                                            {{ old('selling_by_plate',$vehicle->selling_by_plate) == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                    </select>
                                                    @error('selling_by_plate')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-3 d-none" id="show_for_selling_by_plate">
                                                    <label>
                                                        {{__('vehicle.number_plate')}}
                                                    </label>
                                                    <input type="text" name="number_plate"
                                                           value="{{old('number_plate',$vehicle->number_plate)}}"
                                                           class="form-control @error('number_plate') is-invalid @enderror">

                                                    @error('number_plate')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label>
                                                        {{__('vehicle.price_is_negotiable')}}
                                                    </label>
                                                    <select name="price_is_negotiable"
                                                            class="form-control @error('price_is_negotiable') is-invalid @enderror">
                                                        <option value="">{{__('words.choose')}}</option>
                                                        <option value="0"
                                                            {{ old('price_is_negotiable',$vehicle->price_is_negotiable) == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                        <option value="1"
                                                            {{ old('price_is_negotiable',$vehicle->price_is_negotiable) == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                    </select>
                                                    @error('price_is_negotiable')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-row mb-3">
                                                <div class="form-group col-md-4">
                                                    <label>
                                                        {{__('vehicle.in_bahrain')}}
                                                    </label>
                                                    <select name="in_bahrain" id="in_bahrain"
                                                            class="form-control @error('in_bahrain') is-invalid @enderror">
                                                        <option value="">{{__('words.choose')}}</option>
                                                        <option
                                                            value="1" {{ old('in_bahrain',$vehicle->in_bahrain) == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                        <option value="0"
                                                            {{ old('in_bahrain',$vehicle->in_bahrain) == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                    </select>
                                                    @error('in_bahrain')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-4 d-none show_for_in_bahrin">
                                                    <label>{{__('words.country')}}</label>
                                                    <select name="country_id"
                                                            class="form-control country_id @error('country_id') is-invalid @enderror">
                                                        <option value="">{{__('words.choose')}}</option>
                                                        @foreach($countries as $country)
                                                            <option value="{{$country->id}}"
                                                                {{ old('country_id',$vehicle->country_id) == $country->id ? "selected" : "" }}>{{$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('country_id')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>{{__('vehicle.location')}}</label>
                                                    <input name="location"
                                                           value="{{old('location',$vehicle->location)}}"
                                                           class="form-control @error('location') is-invalid @enderror"
                                                           placeholder="{{__('vehicle.location')}}">
                                                    @error('location')
                                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        {{--  for used end --}}

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-12">
                                                <label>{{__('words.additional_notes')}}</label>
                                                <textarea name="additional_notes"
                                                          class="form-control @error('additional_notes') is-invalid @enderror">{{ old('additional_notes',$vehicle->additional_notes) }}</textarea>

                                                @error('additional_notes')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{--images--}}

                                        <hr>

                                        {{--3D file start--}}
                                        @if(!isset($threeD_file))
                                            <div class="form-row">

                                                <div class="form-group col-md-6">
                                                    <label>{{__('words.threeDFile')}}</label>
                                                    <input type="file" name="threeDFile"
                                                           class="D_files form-control  @error('threeDFiles') is-invalid @enderror">

                                                    @error('threeDFile')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{--3D file end--}}
                                        @endif
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.choose_image')}}</label>
                                                <input type="file" name="images[0][]" multiple
                                                       class="images_files form-control image @error('images[]') is-invalid @enderror">

                                                @error('images[]')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4 colors">
                                                <label>{{__('words.colors')}}</label>
                                                <select name="colors[]"
                                                        class="form-control @error('colors[]') is-invalid @enderror">
                                                    @foreach($colors as $color)
                                                        <option
                                                            {{ old('colors') == $color->id ? "selected" : "" }} value="{{$color->id}}">{{$color->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('colors[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row imageOption">

                                        </div>
                                        <div class="form-row DOption">

                                        </div>

                                        <div class="block">
                                            <button type="button" class="add btn btn-outline-success">
                                                {{__('words.add_more_images')}}
                                            </button>
                                        </div>

                                        @if(isset($threeD_file))
                                            <div class="form-row m-2 color-name">
                                                <div class="col-md-6 image-galley">
                                                    <div class="rounded v-images border m-1">
                                                        <model-viewer
                                                            src="{{$threeD_file->path}}"
                                                            alt="3d" auto-rotate
                                                            camera-controls ar
                                                            ios-src="{{$threeD_file->path}}"></model-viewer>

                                                        <div class="form-check form-check-inline">
                                                            <input
                                                                class="form-check-input m-2 checkImage @error('checkImage') is-invalid @enderror"
                                                                type="checkbox" id="image-{{$threeD_file->id}}">
                                                            <label class="form-check-label"
                                                                   for="image-{{$threeD_file->id}}">{{__('words.delete')}}</label>

                                                            @error('checkImage')
                                                            <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div>
                                            @foreach($grouped_images as $key=>$files)
                                                <div class="form-row m-2 color-name">
                                                    - {{App\Models\Color::find($key)->name}}
                                                    <span
                                                        style="background-color: {{App\Models\Color::find($key)->color_code}};"
                                                        class="dot"></span>
                                                </div>
                                                <div class="form-row">
                                                    @foreach($files as $file)
                                                        <div class="form-row col-md-3">
                                                            <div class="rounded v-images border m-1">
                                                                <a href="{{asset($file->path)}}"
                                                                   data-toggle="lightbox">
                                                                    <img
                                                                        class="img-thumbnail image-galley w-100"
                                                                        src="{{asset($file->path)}}"
                                                                        onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                                        alt="slider_image">
                                                                </a>

                                                                <div class="form-check form-check-inline">
                                                                    <input
                                                                        class="form-check-input m-2 checkImage @error('checkImage') is-invalid @enderror"
                                                                        type="checkbox" id="image-{{$file->id}}">
                                                                    <label class="form-check-label"
                                                                           for="image-{{$file->id}}">{{__('words.delete')}}</label>

                                                                    @error('checkImage')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                        </div>
                                                    @endforeach
                                                </div>

                                            @endforeach
                                        </div>

                                        <div id="deleted_images"></div>

                                        <hr>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active" value="0"
                                                           {{$vehicle->active == "1" ? "checked" : ""}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.activity')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="availability" value="0"
                                                           {{$vehicle->availability == "1" ? "checked" : ""}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.availability')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active_number_of_views"
                                                           {{$vehicle->active_number_of_views == "1" ? "checked" : ""}} value="0"
                                                           type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.active_number_of_views')}}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <button type="submit" class="btn btn-block btn-outline-info">
                                                {{__('words.update')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
@section('scripts')
    <script>
        get_models("{{$vehicle->brand_id}}", "{{$vehicle->car_model_id}}");

        @if($errors->has('used'))
        $('.show_for_guarantee').removeClass('d-none');
        $('.show_for_insurance').removeClass('d-none');
        $('#show_for_selling_by_plate').removeClass('d-none');
        $('#show_for_selling_by_plate').removeClass('d-none');
        $('.show_for_in_bahrin').removeClass('d-none');
        @endif

        $('.manufacturing_year').val("{{old('manufacturing_year')}}");
        $('.guarantee_year').val("{{old('guarantee_year')}}");
        $('.insurance_year').val("{{old('insurance_year')}}");

        $(window).on('load', function () {
            if ($('#is_new').val() == '0') {
                $('#show_for_used').removeClass('d-none');
                $('.color-name').addClass('d-none');
                $('.colors').addClass('d-none');
                $('.add').addClass('d-none');
            }
            if ($('#guarantee').val() == '1') {
                $('.show_for_guarantee').removeClass('d-none');
            }
            if ($('#insurance').val() == '1') {
                $('.show_for_insurance').removeClass('d-none');
            }
            if ($('#selling_by_plate').val() == '1') {
                $('#show_for_selling_by_plate').removeClass('d-none');
            }
            if ($('#in_bahrain').val() == 0) {
                $('.show_for_in_bahrin').removeClass('d-none');
            }
            if ($('#in_bahrain').val() == '') {
                $('.show_for_in_bahrin').addClass('d-none');
            }
            if ($('#vehicle_type').val() == 'pickups') {
                $('#ghamara_count').removeClass('d-none');
            }


            $('.manufacturing_year').val("{{$vehicle->manufacturing_year}}");
            $('.insurance_year').val("{{$vehicle->insurance_year}}");
            $('.guarantee_year').val("{{$vehicle->guarantee_year}}");

        });

        $('#is_new').on('change', function () {
            if ($(this).val() == 0) {
                $('.colors').addClass('d-none');
            } else {
                $('.colors').removeClass('d-none');
            }
            if ($(this).val() == '0') {
                $('#show_for_used').removeClass('d-none');
            } else {
                $('#show_for_used').addClass('d-none');
            }
        });

        $('#guarantee').on('change', function () {
            if ($(this).val() == '1') {
                $('.show_for_guarantee').removeClass('d-none');
            } else {
                $('.show_for_guarantee').addClass('d-none');
            }
        });

        $('#insurance').on('change', function () {
            if ($(this).val() == '1') {
                $('.show_for_insurance').removeClass('d-none');
            } else {
                $('.show_for_insurance').addClass('d-none');
            }
        });

        $('#selling_by_plate').on('change', function () {
            if ($(this).val() == '1') {
                $('#show_for_selling_by_plate').removeClass('d-none');
            } else {
                $('#show_for_selling_by_plate').addClass('d-none');
            }
        });

        $('#in_bahrain').on('change', function () {
            if ($(this).val() == '1') {
                $('.show_for_in_bahrin').addClass('d-none');
            } else {
                $('.show_for_in_bahrin').removeClass('d-none');
            }
        });

        $('.add').click(function () {
            var counter = $(".images_files").length;
            var option = "<div class='images_files form-group col-md-6'><label>{{__('words.choose_image')}}</label><input type='file' multiple name='images[" + counter + "][]' class='form-control image @error('images') is-invalid @enderror'></div><div class='form-group col-md-4'><label>{{__('words.colors')}}</label> <select name='colors[]' class='form-control @error('colors[]') is-invalid @enderror'>@foreach($colors as $color)<option value='{{$color->id}}'>{{$color->name}}</option>@endforeach</select></div>";
            $('.imageOption').append(option);
        });

        function getDeletedImages() {
            $('#deleted_images').empty();

            $('input[type="checkbox"].checkImage:checked').each(function () {
                $('#deleted_images').append('<input type="hidden" name="deleted_images[]" value="' + $(this).attr("id").replace('image-', '') + '">');

            });
        }


        $(".checkImage").change(function () {
            getDeletedImages();
            if (this.checked) {
                $(this).parent().find("img").addClass("delete");
            } else {
                $(this).parent().find("img").removeClass("delete");
            }

        });

    </script>
@endsection
