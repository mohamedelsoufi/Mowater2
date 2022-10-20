@extends('admin.layouts.standard')
@section('title', __('words.edit_color'))
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
                                    href="{{route('colors.index')}}">{{__('words.show_colors')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.edit_color')}}</li>
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
                                <h3 class="card-title">{{__('words.edit_color')}}</h3>
                            </div>
                            <form method="post" action="{{route('colors.update',$color->id)}}"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{$color->id}}">
                                <div class="card-body">
                                    <div class="basic-form">

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.color_name_ar')}}</label>
                                                <input type="text" name="color_name_ar" dir="rtl" id="color_name_ar"
                                                       class="form-control @error('color_name_ar') is-invalid @enderror"
                                                      value="{{$color->color_name_ar}}" placeholder="إسم اللون" >
                                                @error('color_name_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.color_name')}}</label>
                                                <input type="text" name="color_name" dir="ltr" id="color_name"
                                                       class="form-control @error('color_name') is-invalid @enderror"
                                                       value="{{$color->color_name}}" placeholder="Color name" >

                                                @error('color_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>{{__('words.color_code')}}</label>
                                                <input type="color" name="color_code" id="color_code"
                                                       class="form-control @error('color_code') is-invalid @enderror"
                                                       value="{{$color->color_code}}" placeholder="{{__('words.color_code')}}">

                                                @error('color_code')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>

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
