@extends('organization.layouts.app')
@section('title', __('words.show_service'))
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
                                    href="{{route('organization.services.index')}}">{{__('words.show_services')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_service')}}</li>
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
                                <h3 class="card-title">{{__('words.show_service').': '.$service->name}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <!-- service images start-->
                                        @if($service->files)
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h4 class="card-title">{{__('words.images')}}</h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    @foreach($service->files as $file)
                                                                        <div class="col-sm-3 ">
                                                                            <a href="{{$file->path}}"
                                                                               data-toggle="lightbox"
                                                                               data-title="{{$service->name}}"
                                                                               data-gallery="gallery">
                                                                                <img src="{{$file->path}}"
                                                                                     class="img-fluid mb-2 image-galley"
                                                                                     alt="service image"/>
                                                                            </a>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    <!-- service images end-->
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_ar')}}</th>
                                            <td>{{$service->name_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_en')}}</th>
                                            <td>{{$service->name_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_ar')}}</th>
                                            <td>{{$service->description_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_en')}}</th>
                                            <td>{{$service->description_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.category')}}</th>
                                            <td>{{$service->category ? $service->category->name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.sub_category')}}</th>
                                            <td>{{$service->sub_category ? $service->sub_category->name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.location_required')}}</th>
                                            <td>{{$service->getLocationRequired()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.price')}}</th>
                                            <td>{{$service->price}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.discount_type')}}</th>
                                            <td>{{$service->discount_type ? $service->discount_type : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.discount_value')}}</th>
                                            <td>{{$service->discount ? $service->discount : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.price_after_discount')}}</th>
                                            <td>{{$service->discount ? $service->price_after_discount : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.number_of_views')}}</th>
                                            <td>{{$service->number_of_views}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.active_number_of_views')}}</th>
                                            <td>{{$service->getActiveNumberOfViews()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.activity')}}</th>
                                            <td>{{$service->getActive()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.availability')}}</th>
                                            <td>{{$service->getAvailability()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_by')}}</th>
                                            <td>{{$service->created_by}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($service->created_at)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($service->created_at) == updatedAtFormat($service->updated_at) ? '--' : updatedAtFormat($service->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>

                            </div>

                            @if(auth('web')->user()->hasPermission(['update-services-' . $record->name_en]))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('organization.services.edit',$service->id)}}"
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
