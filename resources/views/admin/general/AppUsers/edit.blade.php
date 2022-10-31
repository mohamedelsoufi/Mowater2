@extends('admin.layouts.standard')
@section('title', __('words.edit_app_user'))
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
                                    href="{{route('app-users.index')}}">{{__('words.show_app_users')}}</a></li>
                            <li class="breadcrumb-item active">{{__('words.edit_app_user')}}</li>
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
                                <h3 class="card-title">{{__('words.edit_app_user')}}</h3>
                            </div>
                            <form method="post" action="{{route('app-users.update',$user->id)}}" autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4 mb-3">
                                            <label>{{__('words.nickname')}}</label>
                                            <div class="input-group">
                                                <input type="text" name="nickname"
                                                       class="form-control @error('nickname') is-invalid @enderror"
                                                       value="{{$user->nickname}}"
                                                       placeholder="{{__('words.nickname')}}">
                                                @error('nickname')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4 mb-3">
                                            <label>{{__('words.first_name')}}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" name="first_name"
                                                       class="form-control @error('first_name') is-invalid @enderror"
                                                       value="{{$user->first_name}}"
                                                       placeholder="{{__('words.first_name')}}">
                                                @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4 mb-3">
                                            <label>{{__('words.last_name')}}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" name="last_name"
                                                       class="form-control @error('last_name') is-invalid @enderror"
                                                       value="{{ $user->last_name }}"
                                                       placeholder="{{__('words.last_name')}}">
                                                @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>{{__('words.gender')}}</label>
                                            <select name="gender"
                                                    class="form-control @error('gender') is-invalid @enderror">
                                                <option value="" selected>{{__('words.choose')}}</option>
                                                <option
                                                    value="male" {{ $user->gender == "male" ? "selected" : "" }} >{{__('words.male')}}</option>
                                                <option
                                                    value="female" {{ $user->gender == "female" ? "selected" : "" }}>{{__('words.female')}}</option>
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
                                                       value="{{$user->date_of_birth}}" name="date_of_birth"
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
                                        <div class="form-group col-4 mb-3">
                                            <label>{{__('words.nationality')}}</label>
                                            <input type="text" name="nationality"
                                                   class="form-control @error('nationality') is-invalid @enderror"
                                                   value="{{$user->nationality}}"
                                                   placeholder="{{__('words.nationality')}}">
                                            @error('nationality')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-4 mb-3">
                                            <label>{{__('words.phone_code')}}</label>
                                            <select name="phone_code"
                                                    class="form-control select2 @error('phone_code') is-invalid @enderror">
                                                @foreach(phoneCodes() as $key => $val)
                                                    <option data-countryCode="DZ"
                                                            value="{{$key}}" {{$user->phone_code == $key ? "selected" : ""}}>
                                                        {{$val}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('phone_code')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-4 mb-3">
                                            <label>{{__('words.phone')}}</label>
                                            <input type="text" name="phone"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   value="{{$user->phone}}"
                                                   placeholder="{{__('words.phone')}}">
                                            @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6 mb-3">
                                            <label>{{__('words.profile_picture')}}</label>
                                            <input type="file" name="profile_image"
                                                   class="form-control image @error('profile_image') is-invalid @enderror">
                                            @error('profile_image')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-6 text-center pt-3 mb-3">
                                            <img src="{{ $user->profile_image }}"
                                                 onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                 class="index_image image-preview" alt="profile_image">
                                        </div>
                                    </div>

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
                                                            value="{{$country->id}}" {{$user->country_id == $country->id ? "selected" : ""}}>{{$country->name}}</option>
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
                                        <div class="input-group col-4 mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="text" name="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   value="{{$user->email}}" placeholder="{{__('words.email')}}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="input-group col-4 mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   value="{{ old('password') }}" placeholder="{{__('words.password')}}"
                                                   autocomplete="off" readonly
                                                   onfocus="this.removeAttribute('readonly');">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="input-group col-4 mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
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

                                    <div class="row">
                                        <div class="input-group col-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" name="active" type="checkbox"
                                                       value="1" {{$user->active == 1 ? 'checked' : ''}}>
                                                <label class="form-check-label">{{__('words.active')}}</label>
                                            </div>
                                        </div>

                                        <div class="input-group col-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" name="is_verified" type="checkbox"
                                                       value="1" {{$user->is_verified == 1 ? 'checked' : ''}}>
                                                <label class="form-check-label">{{__('words.verification')}}</label>
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
        $(document).ready(function () {
            get_cities("{{$user->country_id}}", "{{$user->city_id}}", "{{$user->area_id}}");
            get_areas("{{$user->city_id}}", "{{$user->area_id}}");
        });
    </script>
@endsection
