@extends('organization.layouts.app')
@section('title', __('words.show_branch') .' '. $branch->name)
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
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">{{__('words.home')}}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.org.branches.index')}}">{{__('words.show_branches')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_branch') .' '. $branch->name}}</li>
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
                                <h3 class="card-title">{{__('words.show_branch') .' '. $branch->name}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_ar')}}</th>
                                            <td>{{$branch->name_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_en')}}</th>
                                            <td>{{$branch->name_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.city')}}</th>
                                            <td>{{$branch->city_id ? $branch->city->name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.area')}}</th>
                                            <td>{{$branch->area_id? $branch->area->name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.address_ar')}}</th>
                                            <td>{{$branch->address_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.address_en')}}</th>
                                            <td>{{$branch->address_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.latitude')}}</th>
                                            <td>{{$branch->latitude}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.longitude')}}</th>
                                            <td>{{$branch->longitude}}</td>
                                        </tr>


                                        <tr>
                                            <th class="show-details-table">{{__('words.number_of_views')}}</th>
                                            <td>{{$branch->number_of_views}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.active_number_of_views')}}</th>
                                            <td>{{$branch->getActiveNumberOfViews()}}</td>
                                        </tr>

                                        @if($branch->getAttribute('reservation_active', 'reservation_availability'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.reservation_active')}}</th>
                                                <td>{{$branch->getReservationActive()}}</td>
                                            </tr>

                                            <tr>
                                                <th class="show-details-table">{{__('words.reservation_availability')}}</th>
                                                <td>{{$branch->getReservationAvailability()}}</td>
                                            </tr>
                                        @endif

                                        @if($branch->getAttribute('delivery_active'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.delivery_active')}}</th>
                                                <td>{{$branch->getDeliveryActive()}}</td>
                                            </tr>
                                        @endif

                                        @if($branch->getAttribute('delivery_availability'))
                                            <tr>
                                                <th class="show-details-table">{{__('words.delivery_availability')}}</th>
                                                <td>{{$branch->getDeliveryAvailability()}}</td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th class="show-details-table">{{__('words.availability')}}</th>
                                            <td>{{$branch->getAvailable()}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.created_by')}}</th>
                                            <td>{{$branch->created_by}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($branch->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($branch->created_at) == updatedAtFormat($branch->updated_at) ? '--' : updatedAtFormat($branch->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if(auth('web')->user()->hasPermission(['update-org-branch-general_data-' . $record->name_en]))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('organization.org.branches.edit',$branch->id)}}"
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
