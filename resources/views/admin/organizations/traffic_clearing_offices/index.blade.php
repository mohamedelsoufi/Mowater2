@extends('admin.layouts.standard')
@section('title', __('words.show_traffic_clearing_offices'))
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
                            <li class="breadcrumb-item active">{{__('words.show_traffic_clearing_offices')}}</li>
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
                                <h3 class="card-title">{{__('words.show_traffic_clearing_offices')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.logo')}}</th>
                                        <th>{{__('words.name_ar')}}</th>
                                        <th>{{__('words.name_en')}}</th>
                                        <th>{{__('words.activity')}}</th>
                                        <th>{{__('words.created_by')}}</th>
                                        <th>{{__('words.created_at')}}</th>
                                        <th>{{__('words.updated_at')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($offices as $key => $office)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                @if(!$office->logo)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$office->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$office->logo}}"
                                                       data-toggle="lightbox" data-title="{{$office->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$office->logo}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{$office->name_ar}}</td>
                                            <td>{{$office->name_en}}</td>
                                            <td>{{$office->getActive()}}</td>
                                            <td>{{$office->created_by}}</td>
                                            <td>{{createdAtFormat($office->created_at)}}</td>
                                            <td>{{createdAtFormat($office->created_at) == updatedAtFormat($office->updated_at) ? '--' : updatedAtFormat($office->updated_at)}}</td>
                                            <td class="action">
                                                @if(auth('admin')->user()->hasPermission('read-traffic_clearing_offices'))
                                                    <a href="{{route('traffic-clearing-offices.show',$office->id)}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('update-traffic_clearing_offices'))
                                                    <a href="{{route('traffic-clearing-offices.edit',$office->id)}}" data-toggle="tooltip"
                                                       title="{{__('words.edit')}}"
                                                       class="btn btn-outline-warning"> <i class="fas fa-pen"></i></a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('delete-traffic_clearing_offices'))
                                                    <a href="" class="btn btn-outline-danger"
                                                       data-toggle="modal"
                                                       data-target="#ModalDelete{{$office->id}}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @include('admin.organizations.traffic_clearing_offices.deleteModal')
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
