@extends('organization.layouts.app')
@section('title', __('words.show_work_times'))
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
                            <li class="breadcrumb-item active">{{__('words.show_work_times')}}</li>
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
                                <h3 class="card-title">{{__('words.show_work_times').': '.$record->name}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">
                                                {{__('words.from')}}</th>
                                            <td>{{date('h:i A',strtotime($work_time->from))}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">
                                                {{__('words.to')}}</th>
                                            <td>{{date('h:i A',strtotime($work_time->to))}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">
                                                {{__('words.duration')}}</th>
                                            <td>{{$work_time->duration}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">
                                                {{__('words.work_days')}}</th>
                                            <td>
                                                <input type="checkbox" name="work_days[]" value="Sun"
                                                       id="Sun" {{ $work_time && in_array('Sun' , $work_time->days) ? 'checked' : ''   }} >
                                                <label for="Sun">{{__('words.Sun')}}</label>
                                                &nbsp;
                                                &nbsp;
                                                &nbsp;
                                                <input type="checkbox" name="work_days[]" value="Mon"
                                                       id="Mon" {{ $work_time && in_array('Mon' , $work_time->days) ? 'checked' : ''   }} >
                                                <label for="Mon">{{__('words.Mon')}}</label>
                                                &nbsp;
                                                &nbsp;
                                                &nbsp;
                                                <input type="checkbox" name="work_days[]" value="Tue"
                                                       id="Tue" {{ $work_time && in_array('Tue' , $work_time->days) ? 'checked' : ''   }} >
                                                <label for="Tue">{{__('words.Tue')}}</label>
                                                &nbsp;
                                                &nbsp;
                                                &nbsp;
                                                <input type="checkbox" name="work_days[]" value="Wed"
                                                       id="Wed" {{ $work_time && in_array('Wed' , $work_time->days) ? 'checked' : ''   }} >
                                                <label for="Wed">{{__('words.Wed')}}</label>
                                                &nbsp;
                                                &nbsp;
                                                &nbsp;
                                                <input type="checkbox" name="work_days[]" value="Thu"
                                                       id="Thu" {{ $work_time && in_array('Thu' , $work_time->days) ? 'checked' : ''   }} >
                                                <label for="Thu">{{__('words.Thur')}}</label>
                                                &nbsp;
                                                &nbsp;
                                                &nbsp;
                                                <input type="checkbox" name="work_days[]" value="Fri"
                                                       id="Fri" {{ $work_time && in_array('Fri' , $work_time->days) ? 'checked' : ''   }} >
                                                <label for="Fri">{{__('words.Fri')}}</label>
                                                &nbsp;
                                                &nbsp;
                                                &nbsp;
                                                <input type="checkbox" name="work_days[]" value="Sat"
                                                       id="Sat" {{ $work_time && in_array('Sat' , $work_time->days) ? 'checked' : ''   }} >
                                                <label for="Sat">{{__('words.Sat')}}</label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>

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
