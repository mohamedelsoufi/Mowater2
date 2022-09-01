@extends('admin.layouts.standard')
@section('title', __('words.show_sub_sections'))
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
                                    href="{{route('sections.index')}}">{{__('words.show_sections')}}</a></li>
                            <li class="breadcrumb-item active">{{__('words.show_sub_sections')}}</li>
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
                                <h3 class="card-title">{{__('words.show_sub_sections')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.image_s')}}</th>
                                        <th>{{__('words.name_ar')}}</th>
                                        <th>{{__('words.name_en')}}</th>
                                        <th>{{__('words.ref_name')}}</th>
                                        <th>{{__('words.reservation_cost_type')}}</th>
                                        <th>{{__('words.reservation_cost')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sub_sections as $key => $section)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                @if(!$section->file_url)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$section->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$section->file_url}}"
                                                       data-toggle="lightbox" data-title="{{$section->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$section->file_url}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>


                                            <td>{{$section->name_ar}}</td>
                                            <td>{{$section->name_en}}</td>

                                            <td>{{$section->ref_name}}</td>
                                            <td>{{$section->getReservationCostType()}}</td>
                                            <td>{{$section->reservation_cost}}</td>
                                            <td>
                                                @if(auth('admin')->user()->hasPermission('read-sections'))
                                                    <a href="{{route('sections.show',$section->id)}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('update-sections'))
                                                    <a href="{{route('sections.edit',$section->id)}}"
                                                       data-toggle="tooltip"
                                                       title="{{__('words.edit')}}"
                                                       class="btn btn-outline-warning {{$section->ref_name == 'AutoServiceCenter' ? 'd-none' : ''}}">
                                                        <i class="fas fa-pen"></i></a>
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
