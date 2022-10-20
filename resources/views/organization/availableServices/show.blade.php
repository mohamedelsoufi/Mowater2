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
                                <h3 class="card-title">{{__('words.show_service').': '.$availableService->name}}</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <!-- service images start-->
                                    @if($availableService->files)
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h4 class="card-title">{{__('words.images')}}</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                @foreach($availableService->files as $file)
                                                                    <div class="col-sm-3 ">
                                                                        <a href="{{$file->path}}"
                                                                           data-toggle="lightbox"
                                                                           data-title="{{$availableService->name}}"
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
                                        <td>{{$availableService->name_ar}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.name_en')}}</th>
                                        <td>{{$availableService->name_en}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.description_ar')}}</th>
                                        <td>{{$availableService->description_ar}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.description_en')}}</th>
                                        <td>{{$availableService->description_en}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.category')}}</th>
                                        <td>{{$availableService->category ? $availableService->category->name : "--"}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.sub_category')}}</th>
                                        <td>{{$availableService->sub_category ? $availableService->sub_category->name : "--"}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.location_required')}}</th>
                                        <td>{{$availableService->getLocationRequired()}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.price')}}</th>
                                        <td>{{$availableService->price}}</td>
                                    </tr>

                                    <tr>
                                        <th class="show-details-table">{{__('words.discount_type')}}</th>
                                        <td>{{$availableService->discount_type ? $availableService->discount_type : "--"}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.discount_value')}}</th>
                                        <td>{{$availableService->discount ? $availableService->discount : "--"}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.price_after_discount')}}</th>
                                        <td>{{$availableService->discount ? $availableService->price_after_discount : "--"}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.number_of_views')}}</th>
                                        <td>{{$availableService->number_of_views}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.active_number_of_views')}}</th>
                                        <td>{{$availableService->getActiveNumberOfViews()}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.activity')}}</th>
                                        <td>{{$availableService->getActive()}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.availability')}}</th>
                                        <td>{{$availableService->getAvailability()}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.created_by')}}</th>
                                        <td>{{$availableService->created_by}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.created_at')}}</th>
                                        <td>{{createdAtFormat($availableService->created_at)}}</td>
                                    </tr>
                                    <tr>
                                        <th class="show-details-table">{{__('words.updated_at')}}</th>
                                        <td>{{createdAtFormat($availableService->created_at) == updatedAtFormat($availableService->updated_at) ? '--' : updatedAtFormat($availableService->updated_at)}}</td>
                                    </tr>
                                </table>

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
