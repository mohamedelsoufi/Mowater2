@extends('organization.layouts.app')
@section('title', __('words.edit_service'))
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
                                    href="{{route('organization.services.index')}}">{{__('words.show_services')}}</a>
                            </li>

                            <li class="breadcrumb-item active">{{__('words.edit_service')}}</li>
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
                                <h3 class="card-title">{{__('words.edit_service')}}</h3>
                            </div>
                            <form method="post" action="{{route('organization.services.update',$service->id)}}"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <input type="hidden" name="id" value="{{$service->id}}">
                                    <div class="basic-form">
                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.name_ar')}}</label>
                                                <input type="text" name="name_ar" dir="rtl"
                                                       class="form-control @error('name_ar') is-invalid @enderror"
                                                       value="{{ old('name_ar',$service->name_ar) }}"
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
                                                       value="{{ old('name_en',$service->name_en) }}"
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
                                                          class="form-control @error('description_ar') is-invalid @enderror">{{ old('description_ar',$service->description_ar) }}</textarea>

                                                @error('description_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.description_en')}}</label>
                                                <textarea name="description_en" dir="ltr"
                                                          class="form-control @error('description_en') is-invalid @enderror">{{ old('description_en',$service->description_en) }}</textarea>

                                                @error('description_en')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-4">
                                                <label>{{__('words.location_required')}}</label>
                                                <select name="location_required"
                                                        class="form-control @error('location_required') is-invalid @enderror">
                                                    <option
                                                        value="1" {{old('location_required',$service->location_required) == "1" ? "selected" : ""}}>{{__('words.required')}}
                                                    </option>
                                                    <option
                                                        value="0" {{old('location_required',$service->location_required) == "0" ? "selected" : ""}}>{{__('words.not_required')}}
                                                    </option>
                                                </select>
                                                @error('location_required')
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
                                                            {{old('category_id',$service->category_id) == $category->id ? "selected" : ""}}>{{$category->name}}</option>
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
                                                                    value="{{ $model->id }}" {{$service->sub_category_id == $model->id ? "selected" : ""}}>{{ $model->name }}</option>
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
                                            <div class="form-group col-md-4">
                                                <label>{{__('words.price')}}</label>
                                                <input type="number" name="price" step="0.01" min="0"
                                                       value="{{old('price',$service->price)}}"
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
                                                        value="percentage" {{ old('discount_type',$service->discount_type) == 'percentage' ? "selected" : "" }}>{{__('words.percentage')}}</option>
                                                    <option
                                                        value="amount" {{ old('discount_type',$service->discount_type) == 'amount' ? "selected" : "" }}>{{__('words.amount')}}</option>

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
                                                       value="{{old('discount',$service->discount)}}"
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
                                        @if($service->files)
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h4 class="card-title">{{__('words.images')}}</h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    @foreach($service->files as $file)
                                                                        <div class="col-md-3">
                                                                            <div class="rounded border m-1">
                                                                                <div>
                                                                                    <a href="{{$file->path}}"
                                                                                       data-toggle="lightbox"
                                                                                       data-title="{{$service->name}}"
                                                                                       data-gallery="gallery">
                                                                                        <img src="{{$file->path}}"
                                                                                             class="img-fluid mb-2 image-galley"
                                                                                             alt="service image"/>
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
                                                           {{old('active',$service->active) ? "checked" : ""}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.activity')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="available" value="1"
                                                           {{old('available',$service->available) ? "checked" : ""}} type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.availability')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active_number_of_views"
                                                           value="1"
                                                           {{old('active_number_of_views',$service->active_number_of_views) ? "checked" : ""}} type="checkbox">
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
                            equal = "{{$service->sub_category_id}}" == sub_category.id ? "selected" : "";
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
