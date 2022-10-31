@extends('organization.layouts.app')
@section('title', __('words.new_phone'))
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
                                    href="{{route('organization.phones.index')}}">{{__('words.show_phones')}}</a></li>

                            <li class="breadcrumb-item active">{{__('words.new_phone')}}</li>
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
                                <h3 class="card-title">{{__('words.new_phone')}}</h3>
                            </div>
                            <form action="{{route('organization.phones.store')}}" method="POST" autocomplete="off"
                                  enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    <div class="basic-form">
                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.title_ar')}}</label>
                                                <input type="text" name="title_ar" dir="rtl"
                                                       class="form-control @error('title_ar') is-invalid @enderror"
                                                       value="{{ old('title_ar') }}" placeholder="{{__('words.title_ar')}}">
                                                @error('title_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.title_en')}}</label>
                                                <input type="text" name="title_en" dir="ltr"
                                                       class="form-control @error('title_en') is-invalid @enderror"
                                                       value="{{ old('title_en') }}" placeholder="Title">

                                                @error('title_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.country_code')}}</label>
                                                <select name="country_code" id="single-select"
                                                        class="form-control select2 select2-danger @error('country_code') is-invalid @enderror" style="width: 100%;" data-dropdown-css-class="select2-danger">
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                    @foreach(phoneCodes() as $key=>$value)
                                                        <option value="{{$key}}" {{old('country_code') == $key ? 'selected' : ''}}>{{$value}}</option>
                                                    @endforeach
                                                </select>

                                                @error('country_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.phone')}}</label>
                                                <input type="text" name="phone" dir="ltr"
                                                       class="form-control @error('phone') is-invalid @enderror"
                                                       value="{{ old('phone') }}"
                                                       placeholder="{{__('words.phone')}}">

                                                @error('phone')
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
                                            <button type="submit" class="btn btn-block btn-outline-success">
                                                {{__('words.create')}}
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
