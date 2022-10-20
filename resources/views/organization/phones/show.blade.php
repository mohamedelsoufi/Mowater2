@extends('organization.layouts.app')
@section('title', __('words.show_phone'))
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
                            <li class="breadcrumb-item"><a href="{{route('organization.home')}}">{{__('words.home')}}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.phones.index')}}">{{__('words.show_phones')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_phone')}}</li>
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
                                <h3 class="card-title">{{__('words.show_phone').': '.$record->name}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">{{__('words.title_ar')}}</th>
                                            <td>{{$phone->title_ar}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.title_en')}}</th>
                                            <td>{{$phone->title_en}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.country_code')}}</th>
                                            <td>{{$phone->country_code}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.phone')}}</th>
                                            <td>{{$phone->phone}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.created_by')}}</th>
                                            <td>{{$phone->created_by}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($phone->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($phone->created_at) == updatedAtFormat($phone->updated_at) ? '--' : updatedAtFormat($phone->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>

                            </div>

                            @if(auth('web')->user()->hasPermission(['update-phones-' . $record->name_en]))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('organization.phones.edit',$phone->id)}}"
                                               class="btn btn-block btn-outline-info">
                                                {{__('words.edit')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        @endif
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
