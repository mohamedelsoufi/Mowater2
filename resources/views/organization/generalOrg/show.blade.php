@extends('organization.layouts.app')
@section('title', __('words.show_org_data') .' '. $record->name)
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
                                    href="{{route('organization.organizations.index')}}">{{__('words.show_data')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_org_data') .' '. $record->name}}</li>
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
                                <h3 class="card-title">{{__('words.show_org_data') .' '. $record->name}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        @if($record->getAttribute('logo'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.logo')}}</th>
                                                <td>
                                                    @if(!$record->logo)
                                                        <a href="{{asset('uploads/default_image.png')}}"
                                                           data-toggle="lightbox" data-title="{{$record->name}}"
                                                           data-gallery="gallery">
                                                            <img class="index_image"
                                                                 src="{{asset('uploads/default_image.png')}}"
                                                                 alt="logo">
                                                        </a>
                                                    @else
                                                        <a href="{{$record->logo}}"
                                                           data-toggle="lightbox" data-title="{{$record->name}}"
                                                           data-gallery="gallery">
                                                            <img class="index_image"
                                                                 src="{{$record->logo}}"
                                                                 onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                                 alt="logo">
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th class="show-details-table">{{__('words.name_ar')}}</th>
                                            <td>{{$record->name_ar}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.name_en')}}</th>
                                            <td>{{$record->name_en}}</td>
                                        </tr>

                                        @if($record->getAttribute('description_ar'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.description_ar')}}</th>
                                                <td>{{$record->description_ar}}</td>
                                            </tr>
                                        @endif

                                        @if($record->getAttribute('description_en'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.description_en')}}</th>
                                                <td>{{$record->description_en}}</td>
                                            </tr>
                                        @endif

                                        @if($record->getAttribute('address_ar'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.address_ar')}}</th>
                                                <td>{{$record->address_ar}}</td>
                                            </tr>
                                        @endif

                                        @if($record->getAttribute('address_en'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.address_en')}}</th>
                                                <td>{{$record->address_en}}</td>
                                            </tr>
                                        @endif

                                        @if($record->getAttribute('latitude'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.latitude')}}</th>
                                                <td>{{$record->latitude}}</td>
                                            </tr>
                                        @endif

                                        @if($record->getAttribute('longitude'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.longitude')}}</th>
                                                <td>{{$record->longitude}}</td>
                                            </tr>
                                        @endif

                                        @if($record->getAttribute('brand_id'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.brand')}}</th>
                                                <td>{{$record->brand->name}}</td>
                                            </tr>
                                        @endif

                                        @if($record->getAttribute('tax_number'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.tax_number')}}</th>
                                                <td>{{$record->tax_number}}</td>
                                            </tr>
                                        @endif

                                        @if($record->getAttribute('year_founded'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.year_founded')}}</th>
                                                <td>{{$record->year_founded}}</td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th class="show-details-table">{{__('words.country')}}</th>
                                            <td>{{$record->country->name}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.city')}}</th>
                                            <td>{{$record->city->name}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.area')}}</th>
                                            <td>{{$record->area->name}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.number_of_views')}}</th>
                                            <td>{{$record->number_of_views}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.active_number_of_views')}}</th>
                                            <td>{{$record->getActiveNumberOfViews()}}</td>
                                        </tr>

                                        @if($record->getAttribute('reservation_active', 'reservation_availability'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.reservation_active')}}</th>
                                                <td>{{$record->getReservationActive()}}</td>
                                            </tr>

                                            <tr>
                                                <th class="show-details-table">{{__('words.reservation_availability')}}</th>
                                                <td>{{$record->getReservationAvailability()}}</td>
                                            </tr>
                                        @endif

                                        @if($record->getAttribute('delivery_active', 'delivery_availability'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.delivery_active')}}</th>
                                                <td>{{$record->getDeliveryActive()}}</td>
                                            </tr>
                                            <tr>
                                                <th class="show-details-table">{{__('words.delivery_availability')}}</th>
                                                <td>{{$record->getDeliveryAvailability()}}</td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th class="show-details-table">{{__('words.availability')}}</th>
                                            <td>{{$record->getAvailable()}}</td>
                                        </tr>

                                        @if($record->getAttribute('created_by'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.created_by')}}</th>
                                                <td>{{$record->created_by}}</td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($record->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($record->created_at) == updatedAtFormat($record->updated_at) ? '--' : updatedAtFormat($record->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if(auth('web')->user()->hasPermission(['update-general_data-' . $record->name_en]))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('organization.organizations.edit',$record->id)}}"
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
