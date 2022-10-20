@extends('admin.layouts.standard')
@section('title', __('words.create_ad'))
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
                                    href="{{route('ads.index')}}">{{__('words.show_ads')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.create_ad')}}</li>
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
                                <h3 class="card-title">{{__('words.create_ad')}}</h3>
                            </div>
                            <form action="{{route('ads.store')}}" method="POST" autocomplete="off"
                                  enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    <div class="basic-form">
                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.title_ar')}}</label>
                                                <input type="text" name="title_ar" dir="rtl"
                                                       class="form-control @error('title_ar') is-invalid @enderror"
                                                       value="{{ old('title_ar') }}" placeholder="عنوان الإعلان">
                                                @error('title_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.title_en')}}</label>
                                                <input type="text" name="title_en" dir="ltr"
                                                       class="form-control @error('title_en') is-invalid @enderror"
                                                       value="{{ old('title_en') }}" placeholder="Ad name">

                                                @error('title_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.description_ar')}}</label>
                                                <textarea name="description_ar" dir="rtl" placeholder="وصف الإعلان"
                                                          class="form-control @error('description_ar') is-invalid @enderror">{{ old('description_ar') }}</textarea>

                                                @error('description_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.description_en')}}</label>
                                                <textarea name="description_en" dir="ltr" placeholder="Ad description"
                                                          class="form-control @error('description_en') is-invalid @enderror">{{ old('description_en') }}</textarea>

                                                @error('description_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-3">
                                                <label>{{__('words.section')}}</label>
                                                <select name="ref_name" id="section"
                                                        class="form-control select2 select2-danger @error('ref_name') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach($sections as $section)
                                                        <option value="{{$section->ref_name}}"
                                                            {{ old('ref_name') == $section->ref_name ? "selected" : "" }}>{{$section->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('ref_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div
                                                class="form-group col-md-3 show-org {{old('ref_name') ? "d-block" : "d-none"}}">
                                                <label>{{__('words.organization')}}</label>
                                                <select name="organization_id"
                                                        class="form-control select2 select2-danger organization @error('organization_id') is-invalid @enderror">
                                                    @if(old('ref_name'))
                                                        <?php
                                                        $class = 'App\\Models\\' . old('ref_name');
                                                        $module = new $class;
                                                        ?>
                                                        @foreach($module->latest('id')->get() as $model)
                                                            @if (Input::old('organization_id') == $model->id)

                                                                <option value="{{ $model->id }}"
                                                                        selected>{{ $model->name }}</option>
                                                            @else
                                                                <option value="{{ $model->id }}"
                                                                >{{ $model->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('organization_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>{{__('words.ad_type')}}</label>
                                                <select name="ad_type_id" id="ad_type_id"
                                                        class="form-control @error('ad_type_id') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach($ad_types as $ad_type)
                                                        <option value="{{$ad_type->id}}"
                                                            {{ old('ad_type_id') == $ad_type->id ? "selected" : "" }}>{{$ad_type->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('ad_type_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-3 link {{ old('link') ? "d-block" : "d-none"}}">
                                                <label>{{__('words.link')}}</label>
                                                <input type="url" name="link" dir="ltr"
                                                       class="form-control @error('link') is-invalid @enderror"
                                                       value="{{ old('link') }}" placeholder="https://www.domain.com">
                                                @error('link')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-6">
                                                <label for="image">{{__('words.choose_image')}}</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file"
                                                               class="custom-file-input image @error('image') is-invalid @enderror"
                                                               name="image"
                                                               id="image">
                                                        <label class="custom-file-label"
                                                               for="image">{{__('words.choose_image')}}</label>
                                                    </div>
                                                    @error('image')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-6 text-center pt-3">
                                                <img src="{{ asset('uploads/default_image.png') }}"
                                                     class="index_image image-preview" alt="image">
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('words.price')}}</label>
                                                <input type="number" name="price" step="0.01" min="0"
                                                       class="form-control @error('price') is-invalid @enderror"
                                                       value="{{ old('price') }}" placeholder="{{__('words.price')}}">
                                                @error('price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>
                                                    {{__('words.negotiable')}}
                                                </label>
                                                <select name="negotiable"
                                                        class="form-control @error('negotiable') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    <option value="0"
                                                        {{ old('negotiable') == "0" ? "selected" : "" }}>{{__('vehicle.no')}}</option>
                                                    <option value="1"
                                                        {{ old('negotiable') == "1" ? "selected" : "" }}>{{__('vehicle.yes')}}</option>
                                                </select>
                                                @error('negotiable')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.status')}}</label>
                                                <select name="status"
                                                        class="form-control @error('status') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach(ad_status_arr() as $key=>$value)
                                                        <option
                                                            value="{{$key}}" {{ old('status') == $key ? "selected" : "" }} >{{$value}}</option>
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
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.start_date_time')}}</label>
                                                <div class="input-group date" id="start_date"
                                                     data-target-input="nearest">
                                                    <input type="text" name="start_date"
                                                           class="form-control datetimepicker-input @error('start_date') is-invalid @enderror"
                                                           data-target="#start_date" value="{{old('start_date')}}"/>
                                                    <div class="input-group-append" data-target="#start_date"
                                                         data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    @error('start_date')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.end_date_time')}}</label>
                                                <div class="input-group date" id="end_date" data-target-input="nearest">
                                                    <input type="text" name="end_date"
                                                           class="form-control datetimepicker-input @error('end_date') is-invalid @enderror"
                                                           data-target="#end_date" value="{{old('end_date')}}"/>
                                                    <div class="input-group-append" data-target="#end_date"
                                                         data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    @error('end_date')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
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

                                        <hr>
                                        <div class="form-row mb-3">
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
        $('#ad_type_id').on('change', function () {
            if ($(this).val() == '4') {
                $('.link').removeClass('d-none');
            } else {
                $('.link').addClass('d-none');
            }
        });

        $('#section').on('change', function () {
            $('.show-org').removeClass('d-none');
            getOrganizations();
        });

        function getOrganizations() {
            var url = "{{route('ads.orgs' , ':orgName')}}";
            url = url.replace(':orgName', $('#section').val());
            $.ajax({
                type: "Get",
                url: url,
                datatype: 'JSON',
                success: function (data) {
                    if (data.status == true) {
                        $('.organization').empty();
                        let equal;
                        data.data.forEach(function (org) {
                            var option = `<option value="${org.id}">${org.name}</option>`;
                            $('.organization').append(option);
                        });

                    }
                },
                error: function (reject) {
                    alert("{{__('message.something_wrong')}}");
                }
            });
        }
    </script>
@endsection
