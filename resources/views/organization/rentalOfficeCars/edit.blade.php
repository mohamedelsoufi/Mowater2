@extends('organization.layouts.app')
@section('title', __('words.edit_rental_office_car'))
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
                                    href="{{route('organization.rental-office-cars.index')}}">{{__('words.show_rental_cars')}}</a></li>

                            <li class="breadcrumb-item active">{{__('words.edit_rental_office_car')}}</li>
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
                                <h3 class="card-title">{{__('words.edit_rental_office_car')}}</h3>
                            </div>
                            <form method="post" action="{{route('organization.rental-office-cars.update',$car->id)}}"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <input type="hidden" name="id" value="{{$car->id}}">
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
                                                                value="{{$brand->id}}" {{$car->brand_id == $brand->id ? "selected" : ""}}>{{$brand->name}}</option>
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
                                                                <option value="{{ $model->id }}" {{$car->car_model_id == $model->id ? "selected" : ""}}
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
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach($car_classes as $car_class)
                                                        @if (Input::old('car_class_id') == $car_class->id)
                                                            <option selected
                                                                    value="{{$car_class->id}}">{{$car_class->name}}</option>
                                                        @else
                                                            <option
                                                                value="{{$car_class->id}}" {{$car->car_class_id == $car_class->id ? "selected" : ""}}>{{$car_class->name}}</option>
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
                                                    @foreach(rental_car_types_arr() as $key => $val)
                                                        <option
                                                            value="{{$key}}" {{old('vehicle_type',$car->vehicle_type) == $key ?  "selected" : ""}}>{{$val}}</option>
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
                                                <input type="text" name="manufacture_year" min="1900"
                                                       class="yearpicker form-control @error('manufacture_year') is-invalid @enderror"
                                                       value="{{ old('manufacture_year',$car->manufacture_year) }}"
                                                       placeholder="{{__('vehicle.manufacturing_year')}}">

                                                @error('manufacture_year')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.color')}}</label>
                                                <select name="color_id"
                                                        class="form-control @error('color_id') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach($colors as $color)
                                                        <option value="{{$color->id}}"
                                                            {{ old('color_id',$car->color_id) == $color->id ? "selected" : "" }}>{{$color->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('color_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-3">
                                                <label>{{__('words.daily_rental_price')}}</label>
                                                <input type="number" name="daily_rental_price" step="0.01" min="0"
                                                       value="{{old('daily_rental_price',$car->daily_rental_price)}}"
                                                       class="form-control @error('daily_rental_price') is-invalid @enderror"
                                                       placeholder="{{__('words.daily_rental_price')}}">
                                                @error('daily_rental_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>{{__('words.weekly_rental_price')}}</label>
                                                <input type="number" name="weekly_rental_price" step="0.01" min="0"
                                                       value="{{old('weekly_rental_price',$car->weekly_rental_price)}}"
                                                       class="form-control @error('weekly_rental_price') is-invalid @enderror"
                                                       placeholder="{{__('words.weekly_rental_price')}}">
                                                @error('weekly_rental_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>{{__('words.monthly_rental_price')}}</label>
                                                <input type="number" name="monthly_rental_price" step="0.01" min="0"
                                                       value="{{old('monthly_rental_price',$car->monthly_rental_price)}}"
                                                       class="form-control @error('monthly_rental_price') is-invalid @enderror"
                                                       placeholder="{{__('words.monthly_rental_price')}}">
                                                @error('monthly_rental_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>{{__('words.yearly_rental_price')}}</label>
                                                <input type="number" name="yearly_rental_price" step="0.01" min="0"
                                                       value="{{old('yearly_rental_price',$car->yearly_rental_price)}}"
                                                       class="form-control @error('yearly_rental_price') is-invalid @enderror"
                                                       placeholder="{{__('words.yearly_rental_price')}}">
                                                @error('yearly_rental_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.cars_properties')}}</label>
                                                <select name="cars_properties[]" multiple
                                                        class="form-control select2 select2-primary @error('cars_properties') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach($properties as $property)
                                                        <option
                                                            value="{{$property->id}}" {{(collect(old('cars_properties',in_array($property->id,$car_properties)))->contains($property->id)) ? "selected" : ""}}>{{$property->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('cars_properties')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.choose_images')}}</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" multiple name="images[]"
                                                               class="custom-file-input images_files image @error('images') is-invalid @enderror"
                                                               accept="image/*">
                                                        <label class="custom-file-label"
                                                               for="images">{{__('words.choose_images')}}</label>
                                                    </div>
                                                    @error('images')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            @foreach($car->files as $file)
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

                                        <div id="deleted_images"></div>

                                        <hr>
                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active" value="1"
                                                           {{old('active',$car->active) ? "checked" : ""}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.activity')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="available" value="1"
                                                           {{old('available',$car->available) ? "checked" : ""}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.availability')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active_number_of_views"
                                                           value="1"
                                                           {{old('active_number_of_views',$car->active_number_of_views) ? "checked" : ""}} type="checkbox">
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
        get_models("{{$car->brand_id}}", "{{$car->car_model_id}}");

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
