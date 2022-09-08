@extends('admin.layouts.standard')
@section('title', __('words.show_rental_offices'))
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
                            <li class="breadcrumb-item active">{{__('words.show_rental_offices')}}</li>
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
                                <h3 class="card-title">{{__('words.show_rental_offices')}}</h3>
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
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rental_offices as $key => $rental_office)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                @if(!$rental_office->logo)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$rental_office->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$rental_office->logo}}"
                                                       data-toggle="lightbox" data-title="{{$rental_office->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$rental_office->logo}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{$rental_office->name_ar}}</td>
                                            <td>{{$rental_office->name_en}}</td>
                                            <td>{{$rental_office->getActive()}}</td>
                                            <td>
                                                @if(auth('admin')->user()->hasPermission('read-rental_offices'))
                                                    <a href="{{route('rental-offices.show',$rental_office->id)}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('update-rental_offices'))
                                                    <a href="{{route('rental-offices.edit',$rental_office->id)}}" data-toggle="tooltip"
                                                       title="{{__('words.edit')}}"
                                                       class="btn btn-outline-warning"> <i class="fas fa-pen"></i></a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('delete-rental_offices'))
                                                    <a href="" class="btn btn-outline-danger"
                                                       data-toggle="modal"
                                                       data-target="#ModalDelete{{$rental_office->id}}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @include('admin.organizations.rental_offices.deleteModal')
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
