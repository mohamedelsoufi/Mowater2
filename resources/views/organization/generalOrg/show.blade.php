@extends('organization.layouts.app')
@section('title', __('words.show_org_data') .' '. $orgData->name)
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('words.dashboard') .' '. $orgData->name}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb {{app()->getLocale() == 'ar' ? 'float-sm-left' :  'float-sm-right'}}">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">{{__('words.home')}}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.organizations.index')}}">{{__('words.show_data')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_org_data') .' '. $orgData->name}}</li>
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
                                <h3 class="card-title">{{__('words.show_org_data') .' '. $orgData->name}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">{{__('words.logo')}}</th>
                                            <td>
                                                @if(!$orgData->logo)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$orgData->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}"
                                                             alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$orgData->logo}}"
                                                       data-toggle="lightbox" data-title="{{$orgData->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$orgData->logo}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_ar')}}</th>
                                            <td>{{$orgData->name_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_en')}}</th>
                                            <td>{{$orgData->name_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_ar')}}</th>
                                            <td>{{$orgData->description_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_en')}}</th>
                                            <td>{{$orgData->description_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.brand')}}</th>
                                            <td>{{$orgData->brand->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.tax_number')}}</th>
                                            <td>{{$orgData->tax_number}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.year_founded')}}</th>
                                            <td>{{$orgData->year_founded}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.country')}}</th>
                                            <td>{{$orgData->country->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.city')}}</th>
                                            <td>{{$orgData->city->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.area')}}</th>
                                            <td>{{$orgData->area->name}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.number_of_views')}}</th>
                                            <td>{{$orgData->number_of_views}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.active_number_of_views')}}</th>
                                            <td>{{$orgData->getActiveNumberOfViews()}}</td>
                                        </tr>

                                        @if($orgData->getAttribute('reservation_active', 'reservation_availability'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.reservation_active')}}</th>
                                                <td>{{$orgData->getReservationActive()}}</td>
                                            </tr>

                                            <tr>
                                                <th class="show-details-table">{{__('words.reservation_availability')}}</th>
                                                <td>{{$orgData->getReservationAvailability()}}</td>
                                            </tr>
                                        @endif

                                        @if($orgData->getAttribute('delivery_active', 'delivery_availability'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.delivery_active')}}</th>
                                                <td>{{$orgData->getDeliveryActive()}}</td>
                                            </tr>
                                            <tr>
                                                <th class="show-details-table">{{__('words.delivery_availability')}}</th>
                                                <td>{{$orgData->getDeliveryAvailability()}}</td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th class="show-details-table">{{__('words.availability')}}</th>
                                            <td>{{$orgData->getAvailable()}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($orgData->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($orgData->created_at) == updatedAtFormat($orgData->updated_at) ? '--' : updatedAtFormat($orgData->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if(auth('web')->user()->hasPermission(['update-general_data-' . $orgData->name_en]))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('organization.organizations.edit',$orgData->id)}}"
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
