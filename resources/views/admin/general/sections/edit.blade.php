@extends('admin.layouts.standard')
@section('title', __('words.edit_section'))
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
                            <li class="breadcrumb-item active">{{__('words.edit_section')}}</li>
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
                                <h3 class="card-title">{{__('words.edit_section')}}</h3>
                            </div>
                            <form method="post" action="{{route('sections.update',$section->id)}}" autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{$section->id}}">
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.name_ar')}}</label>
                                                <input type="text" name="name_ar"
                                                       class="form-control @error('name_ar') is-invalid @enderror"
                                                       value="{{ $section->name_ar}}" placeholder="إسم القسم">
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
                                                       value="{{ $section->name_en }}" placeholder="Section name">

                                                @error('name_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.reservation_cost_type')}}</label>
                                                <select id="reservation_cost_type" name="reservation_cost_type"
                                                        class="form-control @error('reservation_cost_type') is-invalid @enderror">
                                                    <option value="amount">{{__('words.amount')}}</option>
                                                    <option value="percentage">{{__('words.percentage')}}</option>
                                                </select>
                                                @error('reservation_cost_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.reservation_cost')}}</label>
                                                <input type="number" name="reservation_cost" step="0.01" min="0"
                                                       class="form-control @error('reservation_cost') is-invalid @enderror"
                                                       value="{{$section->reservation_cost}}" placeholder="تكلفة الحجز">
                                                @error('reservation_cost')
                                                <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row {{$section->section_id == null ? 'd-none' : ''}}">
                                            <div class="form-group col-md-4">
                                                <label>{{__('words.section_parent')}}</label>
                                                <input type="text" class="form-control" disabled
                                                       value="{{$section->getSubSectionName($section->section_id)}}">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.choose_image')}}</label>
                                                <input type="file" name="file_url"
                                                       class="form-control image @error('file_url') is-invalid @enderror">
                                                @error('file_url')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>

                                            <div class="col-6 text-center pt-3">
                                                @if(!$section->file_url)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$section->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image image-preview"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$section->file_url}}"
                                                       data-toggle="lightbox" data-title="{{$section->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image image-preview"
                                                             src="{{$section->file_url}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
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
