@extends('admin.layouts.standard')
@section('title', __('words.show_technical_inspection_center'))
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
                                    href="{{route('inspection-centers.index')}}">{{__('words.show_technical_inspection_centers')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_technical_inspection_center')}}</li>
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
                                <h3 class="card-title">{{__('words.show_technical_inspection_center')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">{{__('words.logo')}}</th>
                                            <td>
                                                @if(!$center->logo)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$center->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}"
                                                             alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$center->logo}}"
                                                       data-toggle="lightbox" data-title="{{$center->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$center->logo}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_ar')}}</th>
                                            <td>{{$center->name_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_en')}}</th>
                                            <td>{{$center->name_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_ar')}}</th>
                                            <td>{{$center->description_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_en')}}</th>
                                            <td>{{$center->description_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.address')}}</th>
                                            <td>{{$center->address}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.tax_number')}}</th>
                                            <td>{{$center->tax_number}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.city')}}</th>
                                            <td>{{$center->city->name}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.number_of_views')}}</th>
                                            <td>{{$center->number_of_views}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.active_number_of_views')}}</th>
                                            <td>{{$center->getActiveNumberOfViews()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.reservation_active')}}</th>
                                            <td>{{$center->getReservationActive()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.availability')}}</th>
                                            <td>{{$center->getAvailable()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.activity')}}</th>
                                            <td>{{$center->getActive()}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>


                            @if(auth('admin')->user()->hasPermission('update-technical_inspection_centers'))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('inspection-centers.edit',$center->id)}}"
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
