@extends('organization.layouts.app')
@section('title', __('words.new_day_off'))
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
                                    href="{{route('organization.days-off.index')}}">{{__('words.show_days_off')}}</a></li>

                            <li class="breadcrumb-item active">{{__('words.new_day_off')}}</li>
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
                                <h3 class="card-title">{{__('words.new_day_off')}}</h3>
                            </div>
                            <form action="{{route('organization.days-off.store')}}" method="POST" autocomplete="off"
                                  enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    <div class="basic-form">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.day')}}</label>
                                                <div class="input-group date" id="reservationdate"
                                                     data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input @error('date') is-invalid @enderror"
                                                           value="{{old('date')}}"
                                                           data-target="#reservationdate" name="date" data-toggle="datetimepicker"/>
                                                    <div class="input-group-append" data-target="#reservationdate"
                                                         data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    @error('date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
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
