@extends('admin.layouts.standard')
@section('title', __('words.edit_category'))
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
                                    href="{{route('categories.index')}}">{{__('words.show_categories')}}</a></li>
                            <li class="breadcrumb-item active">{{__('words.edit_category')}}</li>
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
                                <h3 class="card-title">{{__('words.edit_category')}}</h3>
                            </div>
                            <form method="post" action="{{route('categories.update',$category->id)}}" autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{$category->id}}">
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.name_ar')}}</label>
                                                <input type="text" name="name_ar" dir="rtl"
                                                       class="form-control @error('name_ar') is-invalid @enderror"
                                                       value="{{$category->name_ar}}" placeholder="إسم القائمة">
                                                @error('name_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.name_en')}}</label>
                                                <input type="text" name="name_en" dir="ltr"
                                                       class="form-control @error('name_en') is-invalid @enderror"
                                                       value="{{ $category->name_en }}" placeholder="Category name">

                                                @error('name_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.sections')}}</label>
                                                <select name="section_id"
                                                        class="form-control @error('section_id') is-invalid @enderror">
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                    @foreach($sections as $section)
                                                        <option {{$category->section_id == $section->id ? 'selected' : ''}}
                                                                value="{{$section->id}}">{{$section->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('section_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.ref_name_category')}}</label>
                                                <select name="ref_name" id = "ref_name" class="form-control @error('ref_name') is-invalid @enderror">
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                    <option value="products" {{$category->ref_name == 'products' ? 'selected' : ''}} >{{__('words.products')}}</option>
                                                    <option value="services" {{$category->ref_name == 'services' ? 'selected' : ''}} >{{__('words.services')}}</option>
                                                </select>
                                                @error('ref_name')
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
