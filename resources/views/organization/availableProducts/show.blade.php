@extends('organization.layouts.app')
@section('title', __('words.show_product'))
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
                                    href="{{route('organization.products.index')}}">{{__('words.show_products')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_product')}}</li>
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
                                <h3 class="card-title">{{__('words.show_product').': '.$availableProduct->name}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <!-- product images start-->
                                        @if($availableProduct->files)
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h4 class="card-title">{{__('words.images')}}</h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    @foreach($availableProduct->files as $file)
                                                                        <div class="col-sm-3 ">
                                                                            <a href="{{$file->path}}"
                                                                               data-toggle="lightbox"
                                                                               data-title="{{$availableProduct->name}}"
                                                                               data-gallery="gallery">
                                                                                <img src="{{$file->path}}"
                                                                                     class="img-fluid mb-2 image-galley"
                                                                                     alt="product image"/>
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
                                    <!-- product images end-->
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_ar')}}</th>
                                            <td>{{$availableProduct->name_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_en')}}</th>
                                            <td>{{$availableProduct->name_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_ar')}}</th>
                                            <td>{{$availableProduct->description_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_en')}}</th>
                                            <td>{{$availableProduct->description_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.category')}}</th>
                                            <td>{{$availableProduct->category ? $availableProduct->category->name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.sub_category')}}</th>
                                            <td>{{$availableProduct->sub_category ? $availableProduct->sub_category->name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.brand')}}</th>
                                            <td>{{$availableProduct->brand ? $availableProduct->brand->name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.car_model')}}</th>
                                            <td>{{$availableProduct->car_model ? $availableProduct->car_model->name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.car_class')}}</th>
                                            <td>{{$availableProduct->car_class ? $availableProduct->car_class->name : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.manufacturing_year')}}</th>
                                            <td>{{$availableProduct->manufacturing_year}}</td>
                                        </tr>

                                        {{--                                        @if($record->getTable() != 'agencies')--}}
                                        <tr>
                                            <th class="show-details-table">{{__('words.product_status')}}</th>
                                            <td>{{$availableProduct->product_status}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.type')}}</th>
                                            <td>{{__('words.' . $availableProduct->type)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.product_warranty')}}</th>
                                            <td>{{$availableProduct->warranty_value ? $availableProduct->warranty_value : __('words.product_no_warranty')}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.product_is_new')}}</th>
                                            <td>{{$availableProduct->getIsNew()}}</td>
                                        </tr>
                                        {{--                                        @endif--}}
                                        <tr>
                                            <th class="show-details-table">{{__('words.price')}}</th>
                                            <td>{{$availableProduct->price}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.discount_type')}}</th>
                                            <td>{{$availableProduct->discount_type ? $availableProduct->discount_type : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.discount_value')}}</th>
                                            <td>{{$availableProduct->discount ? $availableProduct->discount : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.price_after_discount')}}</th>
                                            <td>{{$availableProduct->discount ? $availableProduct->price_after_discount : "--"}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.number_of_views')}}</th>
                                            <td>{{$availableProduct->number_of_views}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.active_number_of_views')}}</th>
                                            <td>{{$availableProduct->getActiveNumberOfViews()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.activity')}}</th>
                                            <td>{{$availableProduct->getActive()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.availability')}}</th>
                                            <td>{{$availableProduct->getAvailability()}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_by')}}</th>
                                            <td>{{$availableProduct->created_by}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($availableProduct->created_at)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($availableProduct->created_at) == updatedAtFormat($availableProduct->updated_at) ? '--' : updatedAtFormat($availableProduct->updated_at)}}</td>
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
