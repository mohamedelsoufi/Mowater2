@extends('admin.layouts.standard')
@section('title', __('words.new_used_vehicle'))
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
                            <li class="breadcrumb-item"><a
                                    href="{{route('used-vehicles.index')}}">{{__('words.show_used_vehicles')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.new_used_vehicle')}}</li>
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

                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">{{__('words.new_used_vehicle')}}</h3>
                            </div>
                            <form action="{{route('used-vehicles.store')}}" method="POST" autocomplete="off"
                                  enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    <div class="basic-form">
                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-3">
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

                                            <div class="form-group col-md-3">
                                                <label>{{__('words.brand')}}</label>
                                                <select name="brand_id"
                                                        class="form-control brand_id @error('brand_id') is-invalid @enderror">
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                    @foreach($brands as $brand)
                                                        @if (Input::old('brand_id') == $brand->id)
                                                            <option selected
                                                                    value="{{$brand->id}}">{{$brand->name}}</option>
                                                        @else
                                                            <option
                                                                value="{{$brand->id}}">{{$brand->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('brand_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>{{__('words.car_model')}}</label>
                                                <select name="car_model_id"
                                                        class="form-control car_model_id @error('car_model_id') is-invalid @enderror">
                                                    @if(old('brand_id'))
                                                        @foreach(\App\Models\CarModel::where('brand_id',old('brand_id'))->get() as $model)
                                                            @if (Input::old('car_model_id') == $model->id)

                                                                <option value="{{ $model->id }}"
                                                                        selected>{{ $model->name }}</option>
                                                            @else
                                                                <option value="{{ $model->id }}"
                                                                >{{ $model->name }}</option>
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

                                            <div class="form-group col-md-3">
                                                <label>{{__('words.car_class')}}</label>
                                                <select name="car_class_id"
                                                        class="form-control car_class_id @error('car_class_id') is-invalid @enderror">
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                    @foreach($car_classes as $car_class)
                                                        @if (Input::old('car_class_id') == $car_class->id)
                                                            <option selected
                                                                    value="{{$car_class->id}}">{{$car_class->name}}</option>
                                                        @else
                                                            <option
                                                                value="{{$car_class->id}}">{{$car_class->name}}</option>

                                                        @endif                                                    @endforeach
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
                                                <label>{{__('words.vehicle_name')}}</label>
                                                <input type="text" name="vehicle_name"
                                                       class="form-control @error('vehicle_name') is-invalid @enderror"
                                                       value="{{ old('vehicle_name') }}"
                                                       placeholder="{{__('words.vehicle_name')}}">

                                                @error('vehicle_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.manufacturing_year')}}</label>
                                                <input type="text" name="manufacturing_year"
                                                       class="yearpicker form-control @error('manufacturing_year') is-invalid @enderror"
                                                       value="{{ old('manufacturing_year') }}"
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
                                                        class="form-control @error('engine_size') is-invalid @enderror">
                                                    @foreach(engine_size_arr() as $key => $val)
                                                        <option
                                                            value="{{$key}}">{{$val}}</option>
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
                                                        <option
                                                            {{ old('outside_color_id') == $color->id ? "selected" : "" }}
                                                            value="{{$color->id}}">{{$color->name}}</option>
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
                                                        <option
                                                            {{ old('inside_color_id') == $color->id ? "selected" : "" }}
                                                            value="{{$color->id}}">{{$color->name}}</option>
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
                                                        <option
                                                            {{ old('transmission_type') == $key ? "selected" : "" }} value="{{$key}}">{{$value}}</option>
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
                                                        <option
                                                            {{ old('cylinder_number') == $key ? "selected" : "" }} value="{{$key}}">{{$value}}</option>
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
                                                        <option
                                                            {{ old('fuel_type') == $key ? "selected" : "" }} value="{{$key}}">{{$value}}</option>
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
                                                        <option
                                                            {{ old('wheel_drive_system') == $key ? "selected" : "" }} value="{{$key}}">{{$value}}</option>
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
                                                        <option
                                                            {{ old('specifications') == $key ? "selected" : "" }} value="{{$key}}">{{$value}}</option>
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
                                                    <option
                                                        {{ old('start_with_fingerprint') == 0 ? "selected" : "" }} value="0">{{__('vehicle.no')}}</option>
                                                    <option
                                                        {{ old('start_with_fingerprint') == 1 ? "selected" : "" }} value="1">{{__('vehicle.yes')}}</option>
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
                                                    <option
                                                        {{ old('remote_start') == 0 ? "selected" : "" }} value="0">{{__('vehicle.no')}}</option>
                                                    <option
                                                        {{ old('remote_start') == 1 ? "selected" : "" }} value="1">{{__('vehicle.yes')}}</option>
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
                                                    <option
                                                        {{ old('screen') == 0 ? "selected" : "" }} value="0">{{__('vehicle.no')}}</option>
                                                    <option
                                                        {{ old('screen') == 1 ? "selected" : "" }} value="1">{{__('vehicle.yes')}}</option>
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
                                                        <option
                                                            {{ old('seat_upholstery') == $key ? "selected" : "" }} value="{{$key}}">{{$value}}</option>
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
                                                        <option
                                                            {{ old('windows_control') == $key ? "selected" : "" }} value="{{$key}}">{{$value}}</option>
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
                                                       value="{{ old('chassis_number') }}"
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
                                                        class="form-control @error('wheel_size') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(wheel_size_arr() as $key=>$value)
                                                        <option
                                                            {{ old('wheel_size') == $key ? "selected" : "" }} value="{{$key}}">{{$value}}</option>
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
                                                        <option
                                                            {{ old('wheel_type') == $key ? "selected" : "" }} value="{{$key}}">{{$value}}</option>
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
                                                        <option
                                                            {{ old('sunroof') == $key ? "selected" : "" }} value="{{$key}}">{{$value}}</option>
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
                                                <input name="doors_number" value="{{old('doors_number')}}"
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
                                                    <option
                                                        {{ old('electric_back_door') == 0 ? "selected" : "" }} value="0">{{__('vehicle.no')}}</option>
                                                    <option
                                                        {{ old('electric_back_door') == 1 ? "selected" : "" }} value="1">{{__('vehicle.yes')}}</option>
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
                                                    <option
                                                        {{ old('start_engine_with_button') == 0 ? "selected" : "" }} value="0">{{__('vehicle.no')}}</option>
                                                    <option
                                                        {{ old('start_engine_with_button') == 1 ? "selected" : "" }} value="1">{{__('vehicle.yes')}}</option>
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
                                                    <option
                                                        {{ old('seat_adjustment') == 0 ? "selected" : "" }} value="0">{{__('vehicle.no')}}</option>
                                                    <option
                                                        {{ old('seat_adjustment') == 1 ? "selected" : "" }} value="1">{{__('vehicle.yes')}}</option>
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
                                                    <option
                                                        {{ old('seat_heating_cooling_function') == 0 ? "selected" : "" }} value="0">{{__('vehicle.no')}}</option>
                                                    <option
                                                        {{ old('seat_heating_cooling_function') == 1 ? "selected" : "" }} value="1">{{__('vehicle.yes')}}</option>
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
                                                    <option
                                                        {{ old('seat_massage_feature') == 0 ? "selected" : "" }} value="0">{{__('vehicle.no')}}</option>
                                                    <option
                                                        {{ old('seat_massage_feature') == 1 ? "selected" : "" }} value="1">{{__('vehicle.yes')}}</option>
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
                                                    <option
                                                        {{ old('seat_memory_feature') == 0 ? "selected" : "" }} value="0">{{__('vehicle.no')}}</option>
                                                    <option
                                                        {{ old('seat_memory_feature') == 1 ? "selected" : "" }} value="1">{{__('vehicle.yes')}}</option>
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
                                                    <option
                                                        {{ old('fog_lights') == 0 ? "selected" : "" }} value="0">{{__('vehicle.no')}}</option>
                                                    <option
                                                        {{ old('fog_lights') == 1 ? "selected" : "" }} value="1">{{__('vehicle.yes')}}</option>
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
                                                        <option
                                                            {{ old('front_lighting') == $key ? "selected" : "" }} value="{{$key}}">{{$value}}</option>
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
                                                    @foreach(air_conditioning_system_arr() as $key=>$value)
                                                        <option
                                                            {{ old('air_conditioning_system') == $key ? "selected" : "" }} value="{{$key}}">{{$value}}</option>
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
                                                       value="{{ old('battery_size') }}"
                                                       placeholder="{{__('vehicle.battery_size')}}">

                                                @error('battery_size')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('words.price')}}</label>
                                                <input type="number" name="price" step="0.01" min="0"
                                                       value="{{old('price')}}"
                                                       class="form-control @error('price') is-invalid @enderror"
                                                       placeholder="{{__('words.price')}}">

                                                @error('price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.discount_type')}}</label>
                                                <select name="discount_type"
                                                        class="form-control @error('discount_type') is-invalid @enderror">
                                                    <option value="">{{__('words.none')}}</option>
                                                    <option {{ old('discount_type') == 'percentage' ? "selected" : "" }}
                                                            value="percentage">{{__('words.percentage')}}</option>
                                                    <option {{ old('discount_type') == 'amount' ? "selected" : "" }}
                                                            value="amount">{{__('words.amount')}}</option>

                                                </select>
                                                @error('discount_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.discount_value')}}</label>
                                                <input type="number" name="discount" step="0.01" min="1"
                                                       value="{{old('discount')}}"
                                                       class="form-control @error('discount') is-invalid @enderror"
                                                       placeholder="{{__('words.discount_value')}}">

                                                @error('discount')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.traveled_distance')}}</label>
                                                <input type="number" name="traveled_distance" step="0.01" min="0"
                                                       value="{{old('traveled_distance')}}"
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
                                                    <option
                                                        {{ old('traveled_distance_type') == "km" ? "selected" : "" }} value="km">{{__('vehicle.km')}}</option>
                                                    <option
                                                        {{ old('traveled_distance_type') == "mile" ? "selected" : "" }} value="mile">{{__('vehicle.mile')}}</option>
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
                                                        <option
                                                            {{ old('status') == $key ? "selected" : "" }} value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @error('status')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>
                                                    {{__('vehicle.guarantee')}}
                                                </label>
                                                <select name="guarantee" id="guarantee"
                                                        class="form-control @error('guarantee') is-invalid @enderror">
                                                    <option
                                                        {{ old('guarantee') == 0 ? "selected" : "" }} value="0">{{__('vehicle.no')}}</option>
                                                    <option
                                                        {{ old('guarantee') == 1 ? "selected" : "" }} value="1">{{__('vehicle.yes')}}</option>
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
                                                <input type="number" name="guarantee_year"
                                                       value="{{old('guarantee_year')}}"
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
                                                    <option
                                                        {{ old('guarantee_month') == "01" ? "selected" : "" }} value="01">{{__('words.january')}}</option>
                                                    <option
                                                        {{ old('guarantee_month') == "02" ? "selected" : "" }} value="02">{{__('words.february')}}</option>
                                                    <option
                                                        {{ old('guarantee_month') == "03" ? "selected" : "" }} value="03">{{__('words.march')}}</option>
                                                    <option
                                                        {{ old('guarantee_month') == "04" ? "selected" : "" }} value="04">{{__('words.april')}}</option>
                                                    <option
                                                        {{ old('guarantee_month') == "05" ? "selected" : "" }} value="05">{{__('words.may')}}</option>
                                                    <option
                                                        {{ old('guarantee_month') == "06" ? "selected" : "" }} value="06">{{__('words.june')}}</option>
                                                    <option
                                                        {{ old('guarantee_month') == "07" ? "selected" : "" }} value="07">{{__('words.july')}}</option>
                                                    <option
                                                        {{ old('guarantee_month') == "08" ? "selected" : "" }} value="08">{{__('words.august')}}</option>
                                                    <option
                                                        {{ old('guarantee_month') == "09" ? "selected" : "" }} value="09">{{__('words.september')}}</option>
                                                    <option
                                                        {{ old('guarantee_month') == "10" ? "selected" : "" }} value="10">{{__('words.october')}}</option>
                                                    <option
                                                        {{ old('guarantee_month') == "11" ? "selected" : "" }} value="11">{{__('words.november')}}</option>
                                                    <option
                                                        {{ old('guarantee_month') == "12" ? "selected" : "" }} value="12">{{__('words.december')}}</option>
                                                </select>
                                                @error('guarantee_month')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>
                                                    {{__('vehicle.insurance')}}
                                                </label>
                                                <select name="insurance" id="insurance"
                                                        class="form-control @error('insurance') is-invalid @enderror">
                                                    <option
                                                        {{ old('insurance') == 0 ? "selected" : "" }} value="0">{{__('vehicle.no')}}</option>
                                                    <option
                                                        {{ old('insurance') == 1 ? "selected" : "" }} value="1">{{__('vehicle.yes')}}</option>
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
                                                <input type="number" name="insurance_year"
                                                       value="{{old('insurance_year')}}"
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
                                                    <option
                                                        {{ old('insurance_month') == "01" ? "selected" : "" }} value="01">{{__('words.january')}}</option>
                                                    <option
                                                        {{ old('insurance_month') == "02" ? "selected" : "" }} value="02">{{__('words.february')}}</option>
                                                    <option
                                                        {{ old('insurance_month') == "03" ? "selected" : "" }} value="03">{{__('words.march')}}</option>
                                                    <option
                                                        {{ old('insurance_month') == "04" ? "selected" : "" }} value="04">{{__('words.april')}}</option>
                                                    <option
                                                        {{ old('insurance_month') == "05" ? "selected" : "" }} value="05">{{__('words.may')}}</option>
                                                    <option
                                                        {{ old('insurance_month') == "06" ? "selected" : "" }} value="06">{{__('words.june')}}</option>
                                                    <option
                                                        {{ old('insurance_month') == "07" ? "selected" : "" }} value="07">{{__('words.july')}}</option>
                                                    <option
                                                        {{ old('insurance_month') == "08" ? "selected" : "" }} value="08">{{__('words.august')}}</option>
                                                    <option
                                                        {{ old('insurance_month') == "09" ? "selected" : "" }} value="09">{{__('words.september')}}</option>
                                                    <option
                                                        {{ old('insurance_month') == "10" ? "selected" : "" }} value="10">{{__('words.october')}}</option>
                                                    <option
                                                        {{ old('insurance_month') == "11" ? "selected" : "" }} value="11">{{__('words.november')}}</option>
                                                    <option
                                                        {{ old('insurance_month') == "12" ? "selected" : "" }} value="12">{{__('words.december')}}</option>
                                                </select>
                                                @error('insurance_month')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label>
                                                    {{__('vehicle.coverage_type')}}
                                                </label>
                                                <select name="coverage_type"
                                                        class="form-control @error('coverage_type') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(coverage_type_arr() as $key=>$value)
                                                        <option
                                                            {{ old('coverage_type') == $key ? "selected" : "" }} value="{{$key}}">{{$value}}</option>
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
                                                    <option
                                                        {{ old('selling_by_plate') == 0 ? "selected" : "" }} value="0">{{__('vehicle.no')}}</option>
                                                    <option
                                                        {{ old('selling_by_plate') == 1 ? "selected" : "" }} value="1">{{__('vehicle.yes')}}</option>
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
                                                <input type="text" name="number_plate" value="{{old('number_plate')}}"
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
                                                    <option
                                                        {{ old('price_is_negotiable') == 0 ? "selected" : "" }} value="0">{{__('vehicle.no')}}</option>
                                                    <option
                                                        {{ old('price_is_negotiable') == 1 ? "selected" : "" }} value="1">{{__('vehicle.yes')}}</option>
                                                </select>
                                                @error('selling_by_plate')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>
                                                    {{__('vehicle.in_bahrain')}}
                                                </label>
                                                <select name="in_bahrain" id="in_bahrain"
                                                        class="form-control @error('in_bahrain') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    <option
                                                        {{ old('in_bahrain') == 0 ? "selected" : "" }} value="0">{{__('vehicle.no')}}</option>
                                                    <option {{ old('in_bahrain') == 1 ? "selected" : "" }} value="1"
                                                            selected>{{__('vehicle.yes')}}</option>
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
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                    @foreach($countries as $country)
                                                        <option
                                                            {{ old('country_id') == $country->id ? "selected" : "" }}
                                                            value="{{$country->id}}">{{$country->name}}</option>
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
                                                <input name="location" value="{{old('location')}}"
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
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <button type="submit" class="btn btn-block btn-outline-success">
                                                {{__('words.create')}}
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

    </script>
@endsection
