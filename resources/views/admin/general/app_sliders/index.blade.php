@extends('admin.layouts.standard')
@section('title', __('words.app_sliders'))
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
                            <li class="breadcrumb-item active">{{__('words.show_sliders')}}</li>
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

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{__('words.show_sliders')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.image')}}</th>
                                        <th>{{__('words.section')}}</th>
                                        <th>{{__('words.type')}}</th>
                                        <th>{{__('words.created_at')}}</th>
                                        <th>{{__('words.updated_at')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($app_sliders as $key => $slider)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            @if($slider->files->first())
                                                <td>
                                                    @if($slider->files->first()->type == 'video_home_slider')

                                                        <video muted autoplay controls class="index_image">
                                                            <source src="{{asset($slider->files->first()->path)}}"
                                                                    type="video/mp4"
                                                                    onerror="this.src='{{asset('uploads/default-video.jpg')}}'">
                                                        </video>

                                                    @else
                                                        <a href="{{asset($slider->files->first()->path)}}"
                                                           data-toggle="lightbox"
                                                           data-title="{{__('words.show_slider')}}"
                                                           data-gallery="gallery">
                                                            <img class="index_image"
                                                                 src="{{asset($slider->files->first()->path)}}"
                                                                 onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                                 alt="slider_image">
                                                        </a>
                                                    @endif
                                                </td>
                                            @endif
                                            <td>{{$slider->section ? $slider->section->name : __('words.app_home')}}</td>
                                            <td>
                                                @if($slider->type == 'video_home_slider')
                                                    {{__('words.app_home_video')}}
                                                @elseif($slider->type == 'home_first_slider')
                                                    {{__('words.home_first_slider')}}
                                                @elseif($slider->type == 'home_second_slider')
                                                    {{__('words.home_second_slider')}}
                                                @elseif($slider->type == 'home_third_slider')
                                                    {{__('words.home_third_slider')}}
                                                @endif
                                            </td>
                                            <td>{{createdAtFormat($slider->created_at)}}</td>
                                            <td>{{createdAtFormat($slider->created_at) == updatedAtFormat($slider->updated_at) ? '--' : updatedAtFormat($slider->updated_at)}}</td>
                                            <td>
                                                @if(auth('admin')->user()->hasPermission('read-app_sliders'))
                                                    <a href="{{route('app-sliders.show',$slider->id)}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('update-app_sliders'))
                                                    <a href="{{route('app-sliders.edit',$slider->id)}}"
                                                       data-toggle="tooltip"
                                                       title="{{__('words.edit')}}"
                                                       class="btn btn-outline-warning"> <i class="fas fa-pen"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>

    </div>

@endsection

