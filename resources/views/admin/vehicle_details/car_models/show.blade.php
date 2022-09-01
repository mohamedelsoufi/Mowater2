@extends('admin.layouts.standard')
@section('title', __('words.show_car_model'))
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
                                    href="{{route('car-models.index')}}">{{__('words.show_car_models')}}</a></li>
                            <li class="breadcrumb-item active">{{__('words.show_car_model')}}</li>
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
                                <h3 class="card-title">{{__('words.show_brand')}}</h3>
                            </div>
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-4">{{__('words.name_ar')}}</dt>
                                    <dd class="col-sm-8">: {{$car_model->name_ar}}</dd>

                                    <dt class="col-sm-4">{{__('words.name_en')}}</dt>
                                    <dd class="col-sm-8">: {{$car_model->name_en}}</dd>

                                    <dt class="col-sm-4">{{__('words.brand')}}</dt>
                                    <dd class="col-sm-8">: {{$car_model->brand->name}}</dd>

                                    <dt class="col-sm-4">{{__('words.activity')}}</dt>
                                    <dd class="col-sm-8">: {{$car_model->getActive()}}</dd>
                                </dl>
                            </div>

                            @if(auth('admin')->user()->hasPermission('update-car_models'))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('car-models.edit',$car_model->id)}}"
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
