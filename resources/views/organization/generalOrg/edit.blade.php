@extends('organization.layouts.app')
@section('title', __('words.edit_org_data') .' '. $record->name)
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
                            <li class="breadcrumb-item"><a href="{{route('organization.home')}}">{{__('words.home')}}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.organizations.index')}}">{{__('words.show_data')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.edit_org_data') .' '. $record->name}}</li>
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
                                <h3 class="card-title">{{__('words.edit_org_data') .' '. $record->name}}</h3>
                            </div>
                            <form method="post"
                                  action="{{route('organization.organizations.update',$record->id)}}"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{$record->id}}">
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.name_ar')}}</label>
                                                <input type="text" name="name_ar" dir="rtl"
                                                       class="form-control @error('name_ar') is-invalid @enderror"
                                                       value="{{ old('name_ar',$record->name_ar) }}"
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
                                                       value="{{ old('name_en',$record->name_en) }}"
                                                       placeholder="{{__('words.name_en')}}">

                                                @error('name_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            @if($record->getAttribute('description_ar'))
                                                <div class="form-group col-md-6">
                                                    <label>{{__('words.description_ar')}}</label>
                                                    <textarea name="description_ar" dir="rtl"
                                                              class="form-control @error('description_ar') is-invalid @enderror">{{ old('description_ar',$record->description_ar) }}</textarea>

                                                    @error('description_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            @endif

                                            @if($record->getAttribute('description_en'))
                                                <div class="form-group col-md-6">
                                                    <label>{{__('words.description_en')}}</label>
                                                    <textarea name="description_en" dir="ltr"
                                                              class="form-control @error('description_en') is-invalid @enderror">{{ old('description_en',$record->description_en) }}</textarea>

                                                    @error('description_en')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            @endif
                                        </div>

                                        <div class="form-row">
                                            @if($record->getAttribute('address_ar'))
                                                <div class="form-group col-md-6">
                                                    <label>{{__('words.address_ar')}}</label>
                                                    <textarea name="address_ar" dir="rtl"
                                                              class="form-control @error('address_ar') is-invalid @enderror">{{ old('address_ar',$record->address_ar) }}</textarea>

                                                    @error('address_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            @endif

                                            @if($record->getAttribute('address_en'))
                                                <div class="form-group col-md-6">
                                                    <label>{{__('words.address_en')}}</label>
                                                    <textarea name="address_en" dir="ltr"
                                                              class="form-control @error('address_en') is-invalid @enderror">{{ old('address_en',$record->address_en) }}</textarea>

                                                    @error('address_en')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            @endif
                                        </div>

                                        <div class="form-row">
                                            @if($record->getAttribute('latitude'))
                                                <div class="form-group col-md-4">
                                                    <label class="coordinate_text" onclick="getLocation()">{{__('words.click_here_to_get_your_coordinates')}}</label>

                                                    <p id="demo"></p>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>{{__('words.latitude')}}</label>
                                                    <input type="text" name="latitude" id="latitude"
                                                           class="form-control @error('latitude') is-invalid @enderror"
                                                           value="{{ old('latitude',$record->latitude) }}"
                                                           placeholder="{{__('words.latitude')}}">

                                                    @error('latitude')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            @endif

                                            @if($record->getAttribute('longitude'))
                                                <div class="form-group col-md-4">
                                                    <label>{{__('words.longitude')}}</label>
                                                    <input type="text" name="longitude" id="longitude"
                                                           class="form-control @error('longitude') is-invalid @enderror"
                                                           value="{{ old('longitude',$record->longitude) }}"
                                                           placeholder="{{__('words.longitude')}}">

                                                    @error('longitude')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            @endif
                                        </div>

                                        <div class="form-row">
                                            @if($record->getAttribute('brand_id'))
                                                <div class="form-group col-md-4">
                                                    <label>{{__('words.brand')}}</label>
                                                    <select name="brand_id"
                                                            class="form-control @error('brand_id') is-invalid @enderror">
                                                        <option value="" selected>{{__('words.choose')}}</option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{$brand->id}}"
                                                                    @if (Input::old('brand_id') == $brand->id) selected @else {{$record->brand_id == $brand->id ? 'selected' : ''}} @endif
                                                            >{{$brand->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('brand_id')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            @endif

                                            @if($record->getAttribute('logo'))
                                                <div class="form-group col-md-4">
                                                    <label>{{__('words.logo')}}</label>
                                                    <input type="file" name="logo"
                                                           class="form-control image @error('logo') is-invalid @enderror"
                                                           placeholder="{{__('words.logo')}}">
                                                    @error('logo')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>

                                                <div class="col-4 text-center pt-3">
                                                    <img src="{{ old('logo',$record->logo) }}"
                                                         class="index_image image-preview" alt="logo">
                                                </div>
                                            @endif
                                        </div>

                                        <div class="form-row">
                                            @if($record->getAttribute('tax_number'))
                                                <div class="form-group col-md-6">
                                                    <label>{{__('words.tax_number')}}</label>
                                                    <input type="text" name="tax_number"
                                                           class="form-control @error('tax_number') is-invalid @enderror"
                                                           value="{{ old('tax_number',$record->tax_number) }}"
                                                           placeholder="{{__('words.tax_number')}}">
                                                    @error('tax_number')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            @endif

                                            @if($record->getAttribute('year_founded'))
                                                <div class="form-group col-md-6">
                                                    <label>{{__('words.year_founded')}}</label>
                                                    <input type="text" name="year_founded"
                                                           class="yearpicker form-control @error('year_founded') is-invalid @enderror"
                                                           value="{{ old('year_founded',$record->year_founded) }}"
                                                           placeholder="{{__('words.year_founded')}}">

                                                    @error('year_founded')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            @endif
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
                                                                value="{{$country->id}}" {{$record->country_id == $country->id ? "selected" : ""}}>{{$country->name}}</option>
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
                                            <div class="form-group col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="available" value="0"
                                                           {{$record->available == 1 ? 'checked' : ''}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.available')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active_number_of_views"
                                                           value="0"
                                                           {{$record->active_number_of_views == 1 ? 'checked' : ''}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.active_number_of_views')}}
                                                    </label>
                                                </div>
                                            </div>

                                            @if($record->getTable() == 'branches')
                                                <div class="form-group col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="reservation_active"
                                                               value="0"
                                                               {{$record->reservation_active == 1 ? 'checked' : ''}} type="checkbox">
                                                        <label class="form-check-label">
                                                            {{__('words.reservation_active')}}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="form-group col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="reservation_availability"
                                                           value="0"
                                                           {{$record->reservation_availability == 1 ? 'checked' : ''}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.reservation_availability')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="delivery_availability"
                                                           value="0"
                                                           {{$record->delivery_availability == 1 ? 'checked' : ''}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.delivery_availability')}}
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
        $(document).ready(function () {
            get_cities("{{$record->country_id}}", "{{$record->city_id}}", "{{$record->area_id}}");
            get_areas("{{$record->city_id}}", "{{$record->area_id}}");
        });

        function getLocation() {
            const p = document.querySelector('#demo');

            function onError() {
                p.textContent = 'Unable to locate you'
            }

            function onSuccess(position) {

                // p.textContent = `Latitude: ${position.coords.latitude} , Longitude: ${position.coords.longitude} `;

                $('#latitude').val(position.coords.latitude);
                $('#longitude').val(position.coords.longitude);
            }

            if (!navigator.geolocation) {
                // This browser doesn't support Geolocation, show an error
                onError();
            } else {
                // Get the current position of the user!
                navigator.geolocation.getCurrentPosition(onSuccess, onError);
            }
        }
    </script>
@endsection
