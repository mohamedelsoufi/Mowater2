@extends('admin.layouts.standard')
@section('title', __('words.show_payment_method'))
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
                                    href="{{route('payment-methods.index')}}">{{__('words.show_payment_methods')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_payment_method')}}</li>
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
                                <h3 class="card-title">{{__('words.show_payment_method')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">
                                            {{__('words.image_s')}}</th>
                                            <td>
                                                @if(! $payment_method->symbol)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$payment_method->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$payment_method->symbol}}"
                                                       data-toggle="lightbox" data-title="{{$payment_method->name}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$payment_method->symbol}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">
                                            {{__('words.name_ar')}}</th>
                                            <td>{{$payment_method->name_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">
                                            {{__('words.name_en')}}</th>
                                            <td>{{$payment_method->name_en}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if(auth('admin')->user()->hasPermission('update-payment_methods'))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('payment-methods.edit',$payment_method->id)}}"
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
