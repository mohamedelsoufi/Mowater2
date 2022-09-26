@extends('admin.layouts.standard')
@section('title', __('words.show_ad'))
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
                                    href="{{route('ads.index')}}">{{__('words.show_ads')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_ad')}}</li>
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
                                <h3 class="card-title">{{__('words.show_ad')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">{{__('words.image_s')}}</th>
                                            <td>
                                                @if(!$ad->image)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$ad->title}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}"
                                                             alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$ad->image}}"
                                                       data-toggle="lightbox" data-title="{{$ad->title}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$ad->image}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.title_ar')}}</th>
                                            <td>{{$ad->title_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.title_en')}}</th>
                                            <td>{{$ad->title_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_ar')}}</th>
                                            <td>
                                                {{$ad->description_ar == null ? '--' : $ad->description_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_en')}}</th>
                                            <td>
                                                {{$ad->description_en == null ? '--' : $ad->description_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.organization_name')}}</th>
                                            <td>
                                                {{$ad->organizationable->name}}</td>
                                        </tr>

                                        @if($ad->ad_type_id == 4)
                                            <tr>
                                                <th class="show-details-table">{{__('words.link')}}</th>
                                                <td>
                                                    <a href="{{$ad->link}}"
                                                       target="_blank">{{$ad->link}}</a>
                                                </td>
                                            </tr>
                                            @else
                                            <tr>
                                                <th class="show-details-table">{{__('words.ad_for')}}</th>
                                                <td>
                                                    {{$ad->module ? $ad->module->name : "--"}}</td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th class="show-details-table">{{__('words.price')}}</th>
                                            <td>{{$ad->price}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.negotiable')}}</th>
                                            <td>{{$ad->negotiable == 1 ? __('vehicle.yes') : __('vehicle.no')}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.ad_type')}}</th>
                                            <td>{{$ad->adType->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.country')}}</th>
                                            <td>{{$ad->country_id != null ? $ad->country->name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.city')}}</th>
                                            <td>{{$ad->city_id != null ? $ad->city->name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.area')}}</th>
                                            <td>{{$ad->area_id != null ? $ad->area->name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.start_date_time')}}</th>
                                            <td>{{createdAtFormat($ad->start_date)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.end_date_time')}}</th>
                                            <td>{{createdAtFormat($ad->end_date)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.number_of_views')}}</th>
                                            <td>{{$ad->number_of_views}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.active_number_of_views')}}</th>
                                            <td>{{$ad->getActiveNumberOfViews()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.status')}}</th>
                                            <td>{{$ad->getStatus()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.activity')}}</th>
                                            <td>{{$ad->getActive()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_by')}}</th>
                                            <td>{{$ad->created_by}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($ad->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($ad->created_at) == updatedAtFormat($ad->updated_at) ? '--' : updatedAtFormat($ad->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>

                            </div>

                            @if(auth('admin')->user()->hasPermission('update-ads'))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('ads.edit',$ad->id)}}"
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
