@extends('organization.layouts.app')
@section('title', __('words.edit_org_data') .' '. $orgData->name)
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('words.dashboard') .' '. $orgData->name}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb {{app()->getLocale() == 'ar' ? 'float-sm-left' :  'float-sm-right'}}">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">{{__('words.home')}}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.organizations.index')}}">{{__('words.show_data')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.edit_org_data') .' '. $orgData->name}}</li>
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
                                <h3 class="card-title">{{__('words.edit_org_data') .' '. $orgData->name}}</h3>
                            </div>
                            <form method="post"
                                  action="{{route('organization.organizations.update',$orgData->id)}}"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{$orgData->id}}">
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.name_ar')}}</label>
                                                <input type="text" name="name_ar"
                                                       class="form-control @error('name_ar') is-invalid @enderror"
                                                       value="{{ old('name_ar',$orgData->name_ar) }}"
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
                                                       value="{{ old('name_en',$orgData->name_en) }}"
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
                                                <textarea name="description_ar"
                                                          class="form-control @error('description_ar') is-invalid @enderror">{{ old('description_ar',$orgData->description_ar) }}</textarea>

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
                                                          class="form-control @error('description_en') is-invalid @enderror">{{ old('description_en',$orgData->description_en) }}</textarea>

                                                @error('description_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>{{__('words.brand')}}</label>
                                                <select name="brand_id"
                                                        class="form-control @error('brand_id') is-invalid @enderror">
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                    @foreach($brands as $brand)
                                                        <option value="{{$brand->id}}"
                                                                @if (Input::old('brand_id') == $brand->id) selected @else {{$orgData->brand_id == $brand->id ? 'selected' : ''}} @endif
                                                        >{{$brand->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('brand_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

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
                                                <img src="{{ old('logo',$orgData->logo) }}"
                                                     class="index_image image-preview" alt="logo">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.tax_number')}}</label>
                                                <input type="text" name="tax_number"
                                                       class="form-control @error('tax_number') is-invalid @enderror"
                                                       value="{{ old('tax_number',$orgData->tax_number) }}"
                                                       placeholder="{{__('words.tax_number')}}">
                                                @error('tax_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.year_founded')}}</label>
                                                <input type="text" name="year_founded"
                                                       class="yearpicker form-control @error('year_founded') is-invalid @enderror"
                                                       value="{{ old('year_founded',$orgData->year_founded) }}"
                                                       placeholder="{{__('words.year_founded')}}">

                                                @error('year_founded')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
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
                                                                value="{{$country->id}}" {{$orgData->country_id == $country->id ? "selected" : ""}}>{{$country->name}}</option>
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
                                            <div class="form-group col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="available" value="0"
                                                           {{$orgData->available == 1 ? 'checked' : ''}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.available')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active_number_of_views"
                                                           value="0"
                                                           {{$orgData->active_number_of_views == 1 ? 'checked' : ''}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.active_number_of_views')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="reservation_availability" value="0"
                                                           {{$orgData->reservation_availability == 1 ? 'checked' : ''}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.reservation_availability')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="delivery_availability" value="0"
                                                           {{$orgData->delivery_availability == 1 ? 'checked' : ''}} type="checkbox">
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
            get_cities("{{$orgData->country_id}}", "{{$orgData->city_id}}", "{{$orgData->area_id}}");
            get_areas("{{$orgData->city_id}}", "{{$orgData->area_id}}");
        });
    </script>
@endsection
