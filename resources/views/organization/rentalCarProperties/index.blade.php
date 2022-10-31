@extends('organization.layouts.app')
@section('title', __('words.show_cars_properties'))
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
                            <li class="breadcrumb-item active">{{__('words.show_cars_properties')}}</li>
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
                                <h3 class="card-title">{{__('words.show_cars_properties')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.name')}}</th>
                                        <th>{{__('words.description')}}</th>
                                        <th>{{__('words.created_by')}}</th>
                                        <th>{{__('words.created_at')}}</th>
                                        <th>{{__('words.updated_at')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($properties as $key => $property)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$property->name}}</td>
                                            <td>{{$property->description}}</td>
                                            <td>{{$property->created_by}}</td>
                                            <td>{{createdAtFormat($property->created_at)}}</td>
                                            <td>{{createdAtFormat($property->created_at) == updatedAtFormat($property->updated_at) ? '--' : updatedAtFormat($property->updated_at)}}</td>
                                            <td class="action">
                                                @if(auth('web')->user()->hasPermission(['read-cars_properties-' . $record->name_en]))
                                                    <a href="{{route('organization.rental-cars-properties.show',$property->id)}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(auth('web')->user()->hasPermission(['update-cars_properties-' . $record->name_en]))
                                                    <a href="{{route('organization.rental-cars-properties.edit',$property->id)}}"
                                                       class="btn btn-outline-warning" data-toggle="tooltip"
                                                       title="{{__('words.edit')}}">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                @endif

                                                @if(auth('web')->user()->hasPermission(['delete-cars_properties-' . $record->name_en]))
                                                    <a href="" class="btn btn-outline-danger"
                                                       data-toggle="modal"
                                                       data-target="#ModalDelete{{$property->id}}"
                                                       title="{{__('words.delete')}}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @include('organization.rentalCarProperties.deleteModal')
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
