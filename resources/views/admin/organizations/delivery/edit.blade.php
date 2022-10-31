@extends('admin.layouts.standard')
@section('title', __('words.edit_delivery'))
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
                                    href="{{route('delivery.index')}}">{{__('words.show_deliveries')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.edit_delivery')}}</li>
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
                                <h3 class="card-title">{{__('words.edit_delivery')}}</h3>
                            </div>
                            <form method="post"
                                  action="{{route('delivery.update',$delivery->id)}}"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{$delivery->id}}">
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.name_ar')}}</label>
                                                <input type="text" name="name_ar" dir="rtl"
                                                       class="form-control @error('name_ar') is-invalid @enderror"
                                                       value="{{ old('name_ar',$delivery->name_ar) }}"
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
                                                       value="{{ old('name_en',$delivery->name_en) }}"
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
                                                          class="form-control @error('description_ar') is-invalid @enderror">{{ old('description_ar',$delivery->description_ar) }}</textarea>

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
                                                          class="form-control @error('description_en') is-invalid @enderror">{{ old('description_en',$delivery->description_en) }}</textarea>

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
                                                        value="male" {{ $delivery->gender == "male" ? "selected" : "" }} >{{__('words.male')}}</option>
                                                    <option
                                                        value="female" {{ $delivery->gender == "female" ? "selected" : "" }}>{{__('words.female')}}</option>
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
                                                    <input type="text" class="form-control datetimepicker-input"
                                                           value="{{$delivery->birth_date}}" name="birth_date"
                                                           data-target="#reservationdate" data-toggle="datetimepicker"/>
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
                                                <img src="{{ $delivery->profile }}"
                                                     onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                     class="index_image image-preview" alt="profile_picture">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.license')}}</label>
                                                <input type="file" name="license"
                                                       class="form-control license @error('license') is-invalid @enderror"
                                                       placeholder="{{__('words.license')}}">
                                                @error('license')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                            <div class="col-6 text-center pt-3">
                                                <img
                                                    src="{{ $delivery->file()->where('type','driving_license')->first() ? $delivery->file()->where('type','driving_license')->first()->path : asset('uploads/default_image.png') }}"
                                                    onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                    class="index_image license-preview" alt="license">
                                            </div>
                                        </div>

                                        <hr>
                                        <hr>

                                        {{--vehicle detalis start--}}
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.vehicle_image')}}</label>
                                                <input type="file" name="file_url"
                                                       class="form-control vehicle-image @error('file_url') is-invalid @enderror">
                                                @error('file_url')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="col-6 text-center pt-3">
                                                <img src="{{ $delivery->file_url != null ? $delivery->file_url : asset('uploads/default_image.png')  }}"
                                                     class="index_image vehicle-image-preview" alt="vehicle-image">
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
                                                                value="{{$brand->id}}" {{$delivery->brand_id == $brand->id ? 'selected' : ''}}>{{$brand->name}}</option>
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
                                                <select name="car_model_id" id="car_model_id"
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
                                                                value="{{$car_class->id}}" {{$delivery->car_class_id == $car_class->id ? 'selected' : ''}}>{{$car_class->name}}</option>

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

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>{{__('vehicle.vehicle_type')}}</label>
                                                <select name="vehicle_type"
                                                        class="form-control @error('vehicle_type') is-invalid @enderror">
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                    <option
                                                        value="cars" {{old('vehicle_type') || $delivery->vehicle_type == "cars" ? "selected" : ""}}>{{__('vehicle.cars')}}</option>
                                                    <option
                                                        value="motorcycles" {{old('vehicle_type') || $delivery->vehicle_type == "motorcycles" ? "selected" : ""}}>{{__('vehicle.motorcycles')}}</option>
                                                    <option
                                                        value="pickups" {{old('vehicle_type') || $delivery->vehicle_type == "pickups" ? "selected" : ""}}>{{__('vehicle.pickups')}}</option>
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
                                                        <option
                                                            value="{{$key}}" {{$delivery->conveyor_type == $key ? "selected" : ""}}>{{$value}}</option>
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
                                                       value="{{ old('manufacturing_year',$delivery->manufacturing_year) }}"
                                                       placeholder="{{__('vehicle.manufacturing_year')}}">

                                                @error('manufacturing_year')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-8">
                                                <label>{{__('words.delivery_type')}}</label>
                                                <select multiple="multiple" name="category_id[]"
                                                        data-placeholder="--"
                                                        class="select2 form-control {{$errors->has('category_id') ? 'is-invalid' : '' }}"
                                                        style="width: 100%;">
                                                    @foreach($categories as $category)
                                                        <option
                                                            value="{{$category->id}}" {{in_array($category->id, old("category_id",$delivery->categories()->pluck('category_id')->toArray()) ?: []) ? "selected": ""}}>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('category_id'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('category_id') }}</strong>
                                                    </span>
                                                @endif
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
                                                                value="{{$country->id}}" {{$delivery->country_id == $country->id ? "selected" : ""}}>{{$country->name}}</option>
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
                                                            <option value="{{ $model->id }}">{{ $model->name }}</option>
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
                                                    <input class="form-check-input" name="active" value="0"
                                                           type="checkbox" {{$delivery->active == 1 ? "checked" : ""}}>
                                                    <label class="form-check-label">
                                                        {{__('words.activity')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active_number_of_views"
                                                           value="0"
                                                           type="checkbox" {{$delivery->active_number_of_views == 1 ? "checked" : ""}}>
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
                                                <select name="organization_user_id"
                                                        class="form-control email-change @error('email') is-invalid @enderror">
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                </select>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>{{__('words.user_name')}}</label>
                                                <input type="text" name="user_name"
                                                       class="form-control username @error('user_name') is-invalid @enderror"
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
    @include('change_brand')
    <script>
        $(document).ready(function () {
            if("{{$delivery->brand_id != null}}"){
                get_models("{{$delivery->brand_id}}", "{{$delivery->car_model_id}}");
            }
            get_cities("{{$delivery->country_id}}", "{{$delivery->city_id}}", "{{$delivery->area_id}}");
            get_areas("{{$delivery->city_id}}", "{{$delivery->area_id}}");


            let url = "{{route('delivery-user.users' , ':id')}}";
            url = url.replace(':id', "{{$delivery->id}}");
            $.ajax({
                type: "Get",
                url: url,
                datatype: 'JSON',
                success: function (data) {
                    if (data.status == true) {
                        data.data.users.forEach(function (user) {
                            var option = `<option value ="${user.id}" >${user.email}</option>`;
                            $('.email-change').append(option);
                        });
                    }
                },
                error: function (reject) {
                    alert("{{__('message.something_wrong')}}");
                }
            });
        });

        $('.email-change').on('change', function () {
            let user_id = $('.email-change').val();
            let get_user_url = "{{route('delivery-user.user',[$delivery->id,':user'])}}";
            get_user_url = get_user_url.replace(':user', user_id);

            $.ajax({
                type: "Get",
                url: get_user_url,
                datatype: 'JSON',
                success: function (data) {
                    if (data.status == true) {
                        $('.username').val(data.data.user.user_name);
                    }
                },
                error: function (reject) {
                    alert(reject);
                }
            });
        });
    </script>
@endsection
