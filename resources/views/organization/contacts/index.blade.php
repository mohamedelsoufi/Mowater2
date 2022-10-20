@extends('organization.layouts.app')
@section('title', __('words.show_contacts'))
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
                            <li class="breadcrumb-item active">{{__('words.show_contacts')}}</li>
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
                                <h3 class="card-title">{{__('words.show_contacts').': '.$record->name}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">
                                                {{__('words.facebook_link')}}</th>
                                            <td>{{$contacts->facebook_link}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">
                                                {{__('words.instagram_link')}}</th>
                                            <td>{{$contacts->instagram_link}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">
                                                {{__('words.whatsapp_number')}}</th>
                                            <td>{{$contacts->whatsapp_number}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">
                                                {{__('words.website')}}</th>
                                            <td>{{$contacts->website}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">
                                                {{__('words.country_code')}}</th>
                                            <td>{{$contacts->country_code}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">
                                                {{__('words.phone')}}</th>
                                            <td>{{$contacts->phone}}</td>
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
