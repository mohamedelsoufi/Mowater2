@extends('admin.layouts.standard')
@section('title', __('words.show_manufacture_countries'))
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
                            <li class="breadcrumb-item active">{{__('words.show_manufacture_countries')}}</li>
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
                                <h3 class="card-title">{{__('words.show_manufacture_countries')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
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
                                    @foreach($manufacture_countries as $key => $manufacture_country)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$manufacture_country->name_ar}}</td>
                                            <td>{{$manufacture_country->name_en}}</td>
                                            <td>{{$manufacture_country->getActive()}}</td>
                                            <td>{{$manufacture_country->created_by}}</td>
                                            <td>{{createdAtFormat($manufacture_country->created_at)}}</td>
                                            <td>{{createdAtFormat($manufacture_country->created_at) == updatedAtFormat($manufacture_country->updated_at) ? '--' : updatedAtFormat($manufacture_country->updated_at)}}</td>
                                            <td class="action">
                                                @if(auth('admin')->user()->hasPermission('read-manufacture_countries'))
                                                    <a href="{{route('manufacture-countries.show',$manufacture_country->id)}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('update-manufacture_countries'))
                                                    <a href="{{route('manufacture-countries.edit',$manufacture_country->id)}}"
                                                       data-toggle="tooltip" title="{{__('words.edit')}}"
                                                       class="btn btn-outline-warning"> <i class="fas fa-pen"></i></a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('delete-manufacture_countries'))
                                                    <a href="" class="btn btn-outline-danger"
                                                       data-toggle="modal"
                                                       data-target="#ModalDelete{{$manufacture_country->id}}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @include('admin.vehicle_details.manufacture_countries.deleteModal')
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
