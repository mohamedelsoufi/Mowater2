@extends('organization.layouts.app')
@section('title', __('words.edit_available_services'))
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
                                    href="{{route('organization.available-services.index')}}">{{__('words.show_available_services')}}</a>
                            </li>

                            <li class="breadcrumb-item active">{{__('words.edit_available_services')}}</li>
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
                                <h3 class="card-title">{{__('words.edit_available_services')}}</h3>
                            </div>
                            <form method="post" action="{{route('organization.available-services.update')}}"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="card-body table-responsive p-0"
                                             style="height: 600px;">
                                            <table
                                                class="table table-bordered table-striped table-head-fixed text-center">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{__('words.availability')}}</th>
                                                    <th>{{__('words.image_s')}}</th>
                                                    <th>{{__('words.name')}}</th>
                                                    <th>{{__('words.category')}}</th>
                                                    <th>{{__('words.sub_category')}}</th>
                                                    <th>{{__('words.price')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($services as $key => $service)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input"
                                                                       name="available_services[]"
                                                                       value="{{$service->id}}"
                                                                       {{in_array($service->id, $availableServices) ? "checked" : ""}} type="checkbox">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if(!$service->one_image)
                                                                <a href="{{asset('uploads/default_image.png')}}"
                                                                   data-toggle="lightbox"
                                                                   data-title="{{$service->name}}"
                                                                   data-gallery="gallery">
                                                                    <img class="index_image"
                                                                         src="{{asset('uploads/default_image.png')}}"
                                                                         alt="logo">
                                                                </a>
                                                            @else
                                                                <a href="{{$service->one_image}}"
                                                                   data-toggle="lightbox"
                                                                   data-title="{{$service->name}}"
                                                                   data-gallery="gallery">
                                                                    <img class="index_image"
                                                                         src="{{$service->one_image}}"
                                                                         onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                                         alt="logo">
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td>{{$service->name}}</td>
                                                        <td>{{$service->category ? $service->category->name : "--"}}</td>
                                                        <td>{{$service->sub_category ? $service->sub_category->name : "--"}}</td>
                                                        <td>{{$service->price}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>

                                            </table>
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
