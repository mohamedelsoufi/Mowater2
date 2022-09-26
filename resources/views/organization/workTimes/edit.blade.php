@extends('organization.layouts.app')
@section('title', __('words.edit_work_times'))
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
                                    href="{{route('organization.work-times.index')}}">{{__('words.show_work_times')}}</a>
                            </li>

                            <li class="breadcrumb-item active">{{__('words.edit_work_times')}}</li>
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
                                <h3 class="card-title">{{__('words.edit_work_times')}}</h3>
                            </div>
                            <form method="post" action="{{route('organization.work-times.update')}}"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="row">

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.time_from')}}</label>
                                                <input type="time" name="from"
                                                       value="{{$work_time ? $work_time->from : ''}}"
                                                       class="form-control @error('from') is-invalid @enderror">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.time_to')}}</label>
                                                <input type="time" name="to"
                                                       value="{{$work_time ? $work_time->to : ''}}"
                                                       class="form-control @error('to') is-invalid @enderror">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.duration')}}</label>
                                                <input type="number" name="duration"
                                                       @if( get_class($record)=='App\Models\DrivingTrainer')disabled
                                                       value="120"
                                                       @endif value="{{$work_time ? $work_time->duration : ''}}"
                                                       class="form-control @error('duration') is-invalid @enderror">
                                                @if(get_class($record)=='App\Models\DrivingTrainer')
                                                    <input type="hidden" name="duration" value="120">
                                                @endif
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>{{__('words.work_days')}}</label>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label for="Sun">{{__('words.Sun')}}</label>
                                                        <input type="checkbox" name="work_days[]" value="Sun"
                                                               id="Sun" {{ $work_time && in_array('Sun' , $work_time->days) ? 'checked' : ''   }} >
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="Mon">{{__('words.Mon')}}</label>
                                                        <input type="checkbox" name="work_days[]" value="Mon"
                                                               id="Mon" {{ $work_time && in_array('Mon' , $work_time->days) ? 'checked' : ''   }} >
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="Tue">{{__('words.Tue')}}</label>
                                                        <input type="checkbox" name="work_days[]" value="Tue"
                                                               id="Tue" {{ $work_time && in_array('Tue' , $work_time->days) ? 'checked' : ''   }} >
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="Wed">{{__('words.Wed')}}</label>
                                                        <input type="checkbox" name="work_days[]" value="Wed"
                                                               id="Wed" {{ $work_time && in_array('Wed' , $work_time->days) ? 'checked' : ''   }} >
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="Thu">{{__('words.Thur')}}</label>
                                                        <input type="checkbox" name="work_days[]" value="Thu"
                                                               id="Thu" {{ $work_time && in_array('Thu' , $work_time->days) ? 'checked' : ''   }} >
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="Fri">{{__('words.Fri')}}</label>
                                                        <input type="checkbox" name="work_days[]" value="Fri"
                                                               id="Fri" {{ $work_time && in_array('Fri' , $work_time->days) ? 'checked' : ''   }} >
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="Sat">{{__('words.Sat')}}</label>
                                                        <input type="checkbox" name="work_days[]" value="Sat"
                                                               id="Sat" {{ $work_time && in_array('Sat' , $work_time->days) ? 'checked' : ''   }} >
                                                    </div>
                                                </div>
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
