@extends('admin.layouts.standard')
@section('title', __('words.edit_currency'))
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
                                    href="{{route('currencies.index')}}">{{__('words.show_currencies')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.edit_currency')}}</li>
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
                                <h3 class="card-title">{{__('words.edit_currency')}}</h3>
                            </div>
                            <form method="post" action="{{route('currencies.update',$currency->id)}}"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{$currency->id}}">
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.currency_name_ar')}}</label>
                                                <input type="text" name="name_ar"
                                                       class="form-control @error('name_ar') is-invalid @enderror"
                                                       value="{{$currency->name_ar}}"
                                                       placeholder="إسم العملة">
                                                @error('name_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.currency_name_en')}}</label>
                                                <input type="text" name="name_en"
                                                       class="form-control @error('name_en') is-invalid @enderror"
                                                       value="{{ $currency->name_en }}"
                                                       placeholder="Currency name">

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
                                                <label>{{__('words.currency_code')}}</label>
                                                <select name="code" id="single-select"
                                                        class="form-control select2 select2-danger @error('code') is-invalid @enderror" style="width: 100%;" data-dropdown-css-class="select2-danger">
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                    @foreach(currency_code_arr() as $key=>$value)
                                                        <option value="{{$key}}" {{$currency->code == $key ? 'selected' : ''}}>{{$value}}</option>
                                                    @endforeach
                                                </select>

                                                @error('code')
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
