@extends('organization.layouts.app')
@section('title', __('words.show_data'))
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
                            <li class="breadcrumb-item active">{{__('words.show_data')}}</li>
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

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{__('words.show_data')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>{{__('words.logo')}}</th>
                                        <th>{{__('words.name')}}</th>
                                        <th>{{__('words.availability')}}</th>
                                        <th>{{__('words.updated_at')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            @if(!$record->logo)
                                                <a href="{{asset('uploads/default_image.png')}}"
                                                   data-toggle="lightbox" data-title="{{$record->name}}"
                                                   data-gallery="gallery">
                                                    <img class="index_image"
                                                         src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                </a>
                                            @else
                                                <a href="{{$record->logo}}"
                                                   data-toggle="lightbox" data-title="{{$record->name}}"
                                                   data-gallery="gallery">
                                                    <img class="index_image"
                                                         src="{{$record->logo}}"
                                                         onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                         alt="logo">
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{$record->name}}</td>
                                        <td>{{$record->getAvailable()}}</td>
                                        <td>{{createdAtFormat($record->created_at) == updatedAtFormat($record->updated_at) ? '--' : updatedAtFormat($record->updated_at)}}</td>
                                        <td class="action">
                                            @if(auth('web')->user()->hasPermission(['read-general_data-' . $record->name_en]))
                                                <a href="{{route('organization.organizations.show',$record->id)}}"
                                                   class="btn btn-outline-info" data-toggle="tooltip"
                                                   title="{{__('words.show')}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif

                                            @if(auth('web')->user()->hasPermission(['update-general_data-' . $record->name_en]))
                                            <a href="{{route('organization.organizations.edit',$record->id)}}"
                                               data-toggle="tooltip"
                                               title="{{__('words.edit')}}"
                                               class="btn btn-outline-warning"> <i class="fas fa-pen"></i></a>
                                            @endif
                                        </td>
                                    </tr>
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
