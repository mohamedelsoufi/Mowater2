@extends('admin.layouts.standard')
@section('title', __('words.show_slider'))
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
                            <li class="breadcrumb-item active">{{__('words.show_slider')}}</li>
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
                                <h3 class="card-title">{{__('words.show_slider')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">{{__('words.section')}}</th>
                                            <td>{{$app_slider->section ? $app_slider->section->name : __('words.app_home')}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.type')}}</th>
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
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($app_slider->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($app_slider->created_at) == updatedAtFormat($app_slider->updated_at) ? '--' : updatedAtFormat($app_slider->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <hr>
                                <div class="row">
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
                                                    <a href="{{asset($file->path)}}" data-toggle="lightbox"
                                                       data-title="{{__('words.show_slider')}}"
                                                       data-gallery="gallery">
                                                        <img class="img-thumbnail" style="width:250px;height: 200px"
                                                             src="{{asset($file->path)}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="slider_image">
                                                    </a>
                                                @endif
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if(auth('admin')->user()->hasPermission('update-app_sliders'))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('app-sliders.edit',$app_slider->id)}}"
                                               class="btn btn-block btn-outline-info">
                                                {{__('words.edit')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        @endif
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
