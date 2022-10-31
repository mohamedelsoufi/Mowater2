@extends('admin.layouts.standard')
@section('title', __('words.edit_sliders'))
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
                                    href="{{route('app-sliders.index')}}">{{__('words.show_sliders')}}</a></li>
                            <li class="breadcrumb-item active">{{__('words.edit_sliders')}}</li>
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
                                <h3 class="card-title">{{__('words.edit_sliders')}}</h3>
                            </div>
                            <form method="post" action="{{route('app-sliders.update',$app_slider->id)}}" autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="type" value="{{$app_slider->type}}">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table" style="min-width: 845px">
                                            <thead>
                                            <tr class="text-center">
                                                <th>{{__('words.section')}}</th>
                                                <th>{{__('words.type')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody id="display_data">
                                            <tr class="text-center text-dark">

                                                <td>{{$app_slider->section ? $app_slider->section->name : __('words.app_home')}}</td>
                                                <td>
                                                    @if($app_slider->type == 'video_home_slider')
                                                        {{__('words.app_home_video')}}
                                                    @elseif($app_slider->type == 'home_first_slider')
                                                        {{__('words.home_first_slider')}}
                                                    @elseif($app_slider->type == 'home_second_slider')
                                                        {{__('words.home_second_slider')}}
                                                    @elseif($app_slider->type == 'home_third_slider')
                                                        {{__('words.home_third_slider')}}
                                                    @endif
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-12">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @if($app_slider->files->count() < 6)
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.choose_image')}}</label>
                                                <input type="file" name="slider_file[]" multiple
                                                       class="form-control image @error('slider_file[]') is-invalid @enderror"
                                                       placeholder="{{__('words.Slider_image_Video')}}">

                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-row">
                                        @foreach($app_slider->files as $file)
                                            <div class="form-row col-md-4">

                                                <div class="rounded border m-1">
                                                    @if($app_slider->type == 'video_home_slider')

                                                        <video muted autoplay controls class="img-thumbnail w-100">
                                                            <source src="{{asset($file->path)}}"
                                                                    type="video/mp4"
                                                                    onerror="this.src='{{asset('uploads/default-video.jpg')}}'">
                                                        </video>
                                                    @else
                                                        <a href="{{asset($file->path)}}" data-toggle="lightbox" data-title="{{__('words.show_slider')}}"
                                                           data-gallery="gallery">
                                                            <img class="img-thumbnail" style="width:250px;height: 200px"
                                                                 src="{{asset($file->path)}}"
                                                                 onerror="this.src='{{asset('uploads/default_image.png')}}'" alt="slider_image">
                                                        </a>
                                                    @endif
                                                    <div class="form-check form-check-inline mx-2">
                                                        <input
                                                            class="form-check-input checkImage @error('checkImage') is-invalid @enderror"
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
                                        <div id="deleted_images"></div>
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
    <script type="text/javascript">

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
