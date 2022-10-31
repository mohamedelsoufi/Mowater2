@extends('admin.layouts.standard')
@section('title', __('words.new_driving_trainer'))
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
                                    href="{{route('trainers.index')}}">{{__('words.show_driving_trainers')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.new_delivery')}}</li>
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
                                <h3 class="card-title">{{__('words.new_delivery')}}</h3>
                            </div>
                            <form action="{{route('trainers.store')}}" method="POST" autocomplete="off"
                                  enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    <div class="basic-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.name_ar')}}</label>
                                                <input type="text" name="name_ar" dir="rtl"
                                                       class="form-control @error('name_ar') is-invalid @enderror"
                                                       value="{{ old('name_ar') }}"
                                                       placeholder="{{__('words.name_ar')}}">
                                                @error('name_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.name_en')}}</label>
                                                <input type="text" name="name_en" dir="ltr"
                                                       class="form-control @error('name_en') is-invalid @enderror"
                                                       value="{{ old('name_en') }}"
                                                       placeholder="{{__('words.name_en')}}">

                                                @error('name_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>{{__('words.description_ar')}}</label>
                                                <textarea name="description_ar" dir="rtl"
                                                          class="form-control @error('description_ar') is-invalid @enderror">{{ old('description_ar') }}</textarea>

                                                @error('description_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>{{__('words.description_en')}}</label>
                                                <textarea name="description_en" dir="ltr"
                                                          class="form-control @error('description_en') is-invalid @enderror">{{ old('description_en') }}</textarea>

                                                @error('description_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.gender')}}</label>
                                                <select name="gender"
                                                        class="form-control @error('gender') is-invalid @enderror">
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                    <option
                                                        value="male" {{ old('gender') == "male" ? "selected" : "" }} >{{__('words.male')}}</option>
                                                    <option
                                                        value="female" {{ old('gender') == "female" ? "selected" : "" }}>{{__('words.female')}}</option>
                                                </select>
                                                @error('gender')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.birth_date')}}</label>
                                                <div class="input-group date" id="reservationdate"
                                                     data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" value="{{old('birth_date')}}"
                                                           data-target="#reservationdate" name="birth_date" data-toggle="datetimepicker"/>
                                                    <div class="input-group-append" data-target="#reservationdate"
                                                         data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.profile_picture')}}</label>
                                                <input type="file" name="profile_picture"
                                                       class="form-control image @error('profile_picture') is-invalid @enderror"
                                                       placeholder="{{__('words.profile_picture')}}">
                                                @error('profile_picture')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="col-6 text-center pt-3">
                                                <img src="{{ asset('uploads/default_image.png') }}"
                                                     class="index_image image-preview" alt="profile_picture">
                                            </div>
                                        </div>

                                        <hr>
                                        <hr>

                                        {{--vehicle detalis start--}}
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.vehicle_image')}}</label>
                                                <input type="file" name="trainer_vehicle"
                                                       class="form-control vehicle-image @error('trainer_vehicle') is-invalid @enderror">
                                                @error('trainer_vehicle')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="col-6 text-center pt-3">
                                                <img src="{{ asset('uploads/default_image.png') }}"
                                                     class="index_image vehicle-image-preview" alt="profile_picture">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
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

                                            <div class="form-group col-md-4">
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

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.vehicle_type')}}</label>
                                                <select name="vehicle_type"
                                                        class="form-control @error('vehicle_type') is-invalid @enderror">
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                    <option
                                                        value="cars">{{__('vehicle.cars')}}</option>
                                                    <option
                                                        value="motorcycles">{{__('vehicle.motorcycles')}}</option>
                                                    <option
                                                        value="pickups">{{__('vehicle.pickups')}}</option>
                                                </select>
                                                @error('vehicle_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.conveyor_type')}}</label>
                                                <select name="conveyor_type"
                                                        class="form-control @error('conveyor_type') is-invalid @enderror">
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                    @foreach(transmission_type_arr() as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @error('conveyor_type')
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
                                        </div>
                                        {{--vehicle detalis end--}}

                                        <hr>
                                        <hr>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>{{__('words.country')}}</label>
                                                <select name="country_id"
                                                        class="form-control country_id @error('country_id') is-invalid @enderror">
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                    @foreach($countries as $country)
                                                        @if (Input::old('country_id') == $country->id)
                                                            <option
                                                                selected
                                                                value="{{$country->id}}">{{$country->name}}</option>
                                                        @else
                                                            <option

                                                                value="{{$country->id}}">{{$country->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('country_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.city')}}</label>
                                                <select name="city_id"
                                                        class="form-control city_id @error('city_id') is-invalid @enderror">
                                                    @foreach(\App\Models\City::where('country_id',old('country_id'))->get() as $model)
                                                        @if (Input::old('city_id') == $model->id)

                                                            <option value="{{ $model->id }}"
                                                                    selected>{{ $model->name }}</option>
                                                        @else
                                                            <option value="{{ $model->id }}"
                                                            >{{ $model->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('city_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.area')}}</label>
                                                <select name="area_id"
                                                        class="form-control area_id @error('area_id') is-invalid @enderror">
                                                    @foreach(\App\Models\Area::where('city_id',old('city_id'))->get() as $model)
                                                        @if (Input::old('area_id') == $model->id)

                                                            <option value="{{ $model->id }}"
                                                                    selected>{{ $model->name }}</option>
                                                        @else
                                                            <option value="{{ $model->id }}"
                                                            >{{ $model->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('area_id')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active" value="1"
                                                           {{old('active') ? "checked" : ""}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.activity')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active_number_of_views"
                                                           value="1" {{old('active_number_of_views') ? "checked" : ""}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.active_number_of_views')}}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <hr>

                                        {{-- Organization user start --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label>{{__('words.email')}}</label>
                                                <input type="email" name="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       value="{{ old('email') }}" placeholder="{{__('words.email')}}">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>{{__('words.user_name')}}</label>
                                                <input type="text" name="user_name"
                                                       class="form-control @error('user_name') is-invalid @enderror"
                                                       value="{{ old('user_name') }}"
                                                       placeholder="{{__('words.user_name')}}">

                                                @error('user_name')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>{{__('words.password')}}</label>
                                                <input type="password" name="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       value="{{ old('password') }}"
                                                       placeholder="{{__('words.password')}}">

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>{{__('words.confirm_password')}}</label>
                                                <input type="password" name="password_confirmation"
                                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                                       value="{{ old('password_confirmation') }}"
                                                       placeholder="{{__('words.confirm_password')}}">

                                                @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Organization user end --}}
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
