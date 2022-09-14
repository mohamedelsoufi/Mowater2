@extends('admin.layouts.standard')
@section('title', __('words.show_special_number'))
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
                                    href="{{route('special-numbers.index')}}">{{__('words.show_special_numbers')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_special_number')}}</li>
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
                                <h3 class="card-title">{{__('words.show_special_number')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">{{__('words.number')}}</th>
                                            <td>{{$special_number->number}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.size')}}</th>
                                            <td>{{$special_number->size}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.category')}}</th>
                                            <td>{{$special_number->category->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.sub_category')}}</th>
                                            <td>{{$special_number->sub_category->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.organization')}}</th>
                                            <td>{{$special_number->special_number_organization ? $special_number->special_number_organization->name : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.user')}}</th>
                                            <td>{{$special_number->user ? $special_number->user->first_name . ' ' .$special_number->user->last_name  : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.transfer_type')}}</th>
                                            <td>{{$special_number->transfer_type}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.Include_insurance')}}</th>
                                            <td>{{$special_number->Include_insurance == '1' ? __('vehicle.yes') : __('vehicle.no')}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.is_special')}}</th>
                                            <td>{{$special_number->is_special == '1' ? __('vehicle.yes') : __('vehicle.no')}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.price')}}</th>
                                            <td>{{$special_number->price}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.discount_type')}}</th>
                                            <td>{{$special_number->discount_type == null ? '--' : __('words.'.$special_number->discount_type)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.discount_value')}}</th>
                                            <td>{{$special_number->discount == null ? '--' : $special_number->discount}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.price_after_discount')}}</th>
                                            <td>{{$special_number->price_after_discount == null ? '--' : $special_number->price_after_discount}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.price_include_transfer')}}</th>
                                            <td>{{$special_number->price_include_transfer == '1' ? __('vehicle.yes') : __('vehicle.no')}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.number_of_views')}}</th>
                                            <td>{{$special_number->number_of_views}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.active_number_of_views')}}</th>
                                            <td>{{$special_number->getActiveNumberOfViews()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.availability')}}</th>
                                            <td>{{$special_number->getAvailable()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.activity')}}</th>
                                            <td>{{$special_number->getActive()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($special_number->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($special_number->created_at) == updatedAtFormat($special_number->updated_at) ? '--' : updatedAtFormat($special_number->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>


                            @if(auth('admin')->user()->hasPermission('update-special_numbers'))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('special-numbers.edit',$special_number->id)}}"
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
