@extends('organization.layouts.app')
@section('title', __('words.edit_product'))
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
                                    href="{{route('organization.products.index')}}">{{__('words.show_product')}}</a>
                            </li>

                            <li class="breadcrumb-item active">{{__('words.edit_product')}}</li>
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
                                <h3 class="card-title">{{__('words.edit_product')}}</h3>
                            </div>
                            <form method="post" action="{{route('organization.products.update',$product->id)}}"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <input type="hidden" name="id" value="{{$product->id}}">
                                    <div class="basic-form">
                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.name_ar')}}</label>
                                                <input type="text" name="name_ar" dir="rtl"
                                                       class="form-control @error('name_ar') is-invalid @enderror"
                                                       value="{{ old('name_ar',$product->name_ar) }}"
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
                                                       value="{{ old('name_en',$product->name_en) }}"
                                                       placeholder="{{__('words.name_en')}}">

                                                @error('name_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.description_ar')}}</label>
                                                <textarea name="description_ar" dir="rtl"
                                                          class="form-control @error('description_ar') is-invalid @enderror">{{ old('description_ar',$product->description_ar) }}</textarea>

                                                @error('description_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.description_en')}}</label>
                                                <textarea name="description_en" dir="ltr"
                                                          class="form-control @error('description_en') is-invalid @enderror">{{ old('description_en',$product->description_en) }}</textarea>

                                                @error('description_en')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>

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
                                                                value="{{$brand->id}}" {{$product->brand_id == $brand->id ? "selected" : ""}}>{{$brand->name}}</option>
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
                                                                    value="{{ $model->id }}" {{$product->car_model_id == $model->id ? "selected" : ""}}>{{ $model->name }}</option>
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
                                                                value="{{$car_class->id}}" {{$product->car_class_id == $car_class->id ? "selected" : ""}}>{{$car_class->name}}</option>

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
                                                <label>{{__('vehicle.manufacturing_year')}}</label>
                                                <input type="text" name="manufacturing_year" min="1900"
                                                       class="yearpicker form-control @error('manufacturing_year') is-invalid @enderror"
                                                       value="{{ old('manufacturing_year',$product->manufacturing_year) }}"
                                                       placeholder="{{__('vehicle.manufacturing_year')}}">

                                                @error('manufacturing_year')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.category')}}</label>
                                                <select name="category_id" id="category_id"
                                                        class="form-control select2 select2-select2 select2-primary category_id @error('category_id') is-invalid @enderror">
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}"
                                                            {{old('category_id',$product->category_id) == $category->id ? "selected" : ""}}>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.sub_category')}}</label>
                                                <select name="sub_category_id" id="sub_category_id"
                                                        class="form-control sub_category_id @error('sub_category_id') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @if(old('category_id'))
                                                        @foreach(\App\Models\SubCategory::where('category_id',old('category_id'))->get() as $model)
                                                            @if (Input::old('sub_category_id') == $model->id)

                                                                <option value="{{ $model->id }}"
                                                                        selected>{{ $model->name }}</option>
                                                            @else
                                                                <option
                                                                    value="{{ $model->id }}" {{$product->sub_category_id == $model->id ? "selected" : ""}}>{{ $model->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('sub_category_id')
                                                <span class="invalid-feedback" role="alert">
                                                     <strong>{{ $message }}</strong>
                                                 </span>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-3">
                                                <label>{{__('words.product_is_new')}}</label>
                                                <select name="is_new"
                                                        class="form-control @error('is_new') is-invalid @enderror">
                                                    <option
                                                        value="1" {{old('is_new',$product->is_new) == "1" ? "selected" : ""}}>{{__('words.new')}}
                                                    </option>
                                                    <option
                                                        value="0" {{old('is_new',$product->is_new) == "0" ? "selected" : ""}}>{{__('words.used')}}
                                                    </option>
                                                </select>
                                                @error('is_new')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>{{__('words.type')}}</label>
                                                <select name="type"
                                                        class="form-control @error('type') is-invalid @enderror">
                                                    <option
                                                        value="original" {{old('type',$product->type) == "original" ? "selected" : ""}}>{{__('words.original')}}
                                                    </option>
                                                    <option
                                                        value="commercial" {{old('type',$product->type) == "commercial" ? "selected" : ""}}>{{__('words.commercial')}}
                                                    </option>
                                                </select>
                                                @error('type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>{{__('words.status')}}</label>
                                                <select name="status"
                                                        class="form-control @error('status') is-invalid @enderror">
                                                    @foreach(g_status_arr() as $key=>$val)
                                                        <option
                                                            value="{{$key}}" {{ old('status',$product->status) == $key ? "selected" : "" }}>{{$val}}</option>
                                                    @endforeach
                                                </select>
                                                @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>{{__('words.product_warranty')}}</label>
                                                <input type="text" name="warranty_value"
                                                       value="{{old('warranty_value',$product->warranty_value)}}"
                                                       class="form-control @error('warranty_value') is-invalid @enderror"
                                                       placeholder="{{__('words.product_warranty')}}">
                                                @error('warranty_value')
                                                <span class="iinvalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('words.price')}}</label>
                                                <input type="number" name="price" step="0.01" min="0"
                                                       value="{{old('price',$product->price)}}"
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
                                                    <option
                                                        value="percentage" {{ old('discount_type',$product->discount_type) == 'percentage' ? "selected" : "" }}>{{__('words.percentage')}}</option>
                                                    <option
                                                        value="amount" {{ old('discount_type',$product->discount_type) == 'amount' ? "selected" : "" }}>{{__('words.amount')}}</option>

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
                                                       value="{{old('discount',$product->discount)}}"
                                                       class="form-control @error('discount') is-invalid @enderror"
                                                       placeholder="{{__('words.discount_value')}}">

                                                @error('discount')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <hr>
                                        <hr>
                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.add_more_images')}}</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" multiple
                                                               class="custom-file-input images_files image @error('images[]') is-invalid @enderror"
                                                               name="images[]"
                                                               accept="image/*">
                                                        <label class="custom-file-label"
                                                               for="images">{{__('words.choose_image')}}</label>
                                                    </div>
                                                    @error('images[]')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        @if($product->files)
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h4 class="card-title">{{__('words.images')}}</h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    @foreach($product->files as $file)
                                                                        <div class="col-md-3">
                                                                            <div class="rounded border m-1">
                                                                                <div>
                                                                                    <a href="{{$file->path}}"
                                                                                       data-toggle="lightbox"
                                                                                       data-title="{{$product->name}}"
                                                                                       data-gallery="gallery">
                                                                                        <img src="{{$file->path}}"
                                                                                             class="img-fluid mb-2 image-galley"
                                                                                             alt="product image"/>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="form-check form-check-inline mx-2">
                                                                                    <input
                                                                                        class="form-check-input checkImage @error('checkImage') is-invalid @enderror"
                                                                                        type="checkbox"
                                                                                        id="image-{{$file->id}}">
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
                                                                    <div id="deleted_images"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <hr>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active" value="1"
                                                           {{old('active',$product->active) ? "checked" : ""}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.activity')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="available" value="1"
                                                           {{old('available',$product->available) ? "checked" : ""}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.availability')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active_number_of_views"
                                                           value="1"
                                                           {{old('active_number_of_views',$product->active_number_of_views) ? "checked" : ""}} type="checkbox">
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
        $(window).on('load', function () {
            get_models("{{$product->brand_id}}", "{{$product->car_model_id}}");
            get_sub_category_data($('#category_id').val());
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

        $('#category_id').on('change', function () {
            get_sub_category_data($(this).val());
        });

        function get_sub_category_data(id) {
            var url = "{{route('organization.products.sub_category' , ':id')}}";
            url = url.replace(':id', id);
            $.ajax({
                type: "Get",
                url: url,
                datatype: 'JSON',
                success: function (data) {
                    if (data.status == true) {
                        $('#sub_category_id').empty();
                        let equal;
                        data.data.sub_categories.forEach(function (sub_category) {
                            equal = "{{$product->sub_category_id}}" == sub_category.id ? "selected" : "";
                            var option = `<option value ="${sub_category.id}" ${equal}>${sub_category.name}</option>`;
                            $('#sub_category_id').append(option);
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
