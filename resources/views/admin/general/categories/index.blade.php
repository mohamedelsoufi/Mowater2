@extends('admin.layouts.standard')
@section('title', __('words.show_categories'))
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
                            <li class="breadcrumb-item active">{{__('words.show_categories')}}</li>
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
                                <h3 class="card-title">{{__('words.show_categories')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.name_ar')}}</th>
                                        <th>{{__('words.name_en')}}</th>
                                        <th>{{__('words.section')}}</th>
                                        <th>{{__('words.ref_name')}}</th>
                                        <th>{{__('words.created_by')}}</th>
                                        <th>{{__('words.created_at')}}</th>
                                        <th>{{__('words.updated_at')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories as $key => $category)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$category->name_ar}}</td>
                                            <td>{{$category->name_en}}</td>
                                            <td>{{$category->section ? $category->section->name : '--'}}</td>
                                            <td>{{$category->ref_name ? __('words.' . $category->ref_name) : '--'}}</td>
                                            <td>{{$category->created_by}}</td>
                                            <td>{{createdAtFormat($category->created_at)}}</td>
                                            <td>{{createdAtFormat($category->created_at) == updatedAtFormat($category->updated_at) ? '--' : updatedAtFormat($category->updated_at)}}</td>
                                            <td class="action">
                                                @if(auth('admin')->user()->hasPermission('read-categories'))
                                                    <a href="{{route('categories.show',$category->id)}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('update-categories'))
                                                    <a href="{{route('categories.edit',$category->id)}}" data-toggle="tooltip"
                                                       title="{{__('words.edit')}}"
                                                       class="btn btn-outline-warning"> <i class="fas fa-pen"></i></a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('delete-categories'))
                                                    <a href="" class="btn btn-outline-danger"
                                                       data-toggle="modal"
                                                       data-target="#ModalDelete{{$category->id}}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @include('admin.general.categories.deleteModal')
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
