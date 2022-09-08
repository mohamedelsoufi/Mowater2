@extends('admin.layouts.standard')
@section('title', __('words.show_role'))
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
                                    href="{{route('admin-roles.index')}}">{{__('words.roles')}}</a></li>
                            <li class="breadcrumb-item active">{{__('words.show_role')}}</li>
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
                                <h3 class="card-title">{{__('words.show_role')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_ar')}}</th>
                                            <td>{{$role->name_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.name_en')}}</th>
                                            <td>{{$role->name_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_ar')}}</th>
                                            <td>{{$role->description_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_en')}}</th>
                                            <td>{{$role->description_en}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row">
                                    @foreach (config('laratrust_seeder.roles') as $key => $values)
                                        <div class="col-md-2">
                                            <div class="card">
                                                <div class="card-header card-role">
                                                    <h3 class="card-title">{{__('words.'.$key)}}</h3>
                                                </div>

                                                <div class="card-body">
                                                    @foreach ($values as $value)
                                                        <div class="form-group clearfix">
                                                            {{-- icheck-success d-inline --}}
                                                            <div class="">
                                                                <input type="checkbox"
                                                                       disabled {{$role->hasPermission($value . '-' . $key) ? 'checked' : ''}}>

                                                                <label for="{{$value . '-' . $key}}"
                                                                       class="{{$role->hasPermission($value . '-' . $key) ? 'text-success' : ''}}">
                                                                    {{__('words.'.$value)}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if(auth('admin')->user()->hasPermission('update-roles'))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('admin-roles.edit',$role->id)}}"
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
