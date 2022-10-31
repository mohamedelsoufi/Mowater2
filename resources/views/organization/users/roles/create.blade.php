@extends('organization.layouts.app')
@section('title', __('words.create_role'))
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
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.home')}}">{{__('words.home')}}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.org-roles.index')}}">{{__('words.roles')}}</a></li>
                            <li class="breadcrumb-item active">{{__('words.create_role')}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        @include('organization.includes.alerts.success')
        @include('organization.includes.alerts.errors')
        @if ($errors->has('permissions'))
            <div class="row mr-2 ml-2">
                <div class="alert alert-danger alert-dismissible fade show btn-block text-center mb-2" role="alert">
                    <div class="error">{{ $errors->first('permissions') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

        @endif
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">{{__('words.create_role')}}</h3>
                            </div>
                            <form action="{{route('organization.org-roles.store')}}" method="POST" autocomplete="off"
                                  enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    <div class="row">
                                        <div class="input-group col-6 mb-3">
                                            <input type="text" name="name_ar" dir="rtl"
                                                   class="form-control @error('name_ar') is-invalid @enderror"
                                                   value="{{ old('name_ar') }}" placeholder="{{__('words.name_ar')}}">
                                            @error('name_ar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="input-group col-6 mb-3">
                                            <input type="text" name="name_en" dir="ltr"
                                                   class="form-control @error('name_en') is-invalid @enderror"
                                                   value="{{ old('name_en') }}" placeholder="{{__('words.name_en')}}">
                                            @error('name_en')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="input-group col-6 mb-3">
                                            <input type="text" name="description_ar" dir="rtl"
                                                   class="form-control @error('description_ar') is-invalid @enderror"
                                                   value="{{ old('description_ar') }}"
                                                   placeholder="{{__('words.description_ar')}}">
                                            @error('description_ar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="input-group col-6 mb-3">
                                            <input type="text" name="description_en" dir="ltr"
                                                   class="form-control @error('description_en') is-invalid @enderror"
                                                   value="{{ old('description_en') }}"
                                                   placeholder="{{__('words.description_en')}}">
                                            @error('description_en')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        {{--Moule does'nt have relation start--}}
                                        <div class="col-md-2">
                                            <div class="card">
                                                <div class="card-header card-role">
                                                    <h3 class="card-title">{{__('words.general_data')}}</h3>
                                                </div>

                                                <div class="card-body">
                                                    <div class="form-group clearfix">
                                                        {{-- icheck-success d-inline --}}
                                                        <div class="">
                                                            <input type="checkbox" name="permissions[]"
                                                                   value="{{'read-general_data-' .$record->name_en}}">

                                                            <label for="{{'read-general_data-' .$record->name_en}}">
                                                                {{__('words.read')}}
                                                            </label>
                                                        </div>
                                                        <div class="">
                                                            <input type="checkbox" name="permissions[]"
                                                                   value="{{'update-general_data-' .$record->name_en}}">

                                                            <label for="{{'update-general_data-' .$record->name_en}}">
                                                                {{__('words.update')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="card">
                                                <div class="card-header card-role">
                                                    <h3 class="card-title">{{__('words.org_users')}}</h3>
                                                </div>

                                                <div class="card-body">
                                                    <div class="form-group clearfix">
                                                        {{-- icheck-success d-inline --}}
                                                        <div class="">
                                                            <input type="checkbox" name="permissions[]"
                                                                   value="{{'read-org_users-' .$record->name_en}}">

                                                            <label for="{{'read-org_users-' .$record->name_en}}">
                                                                {{__('words.read')}}
                                                            </label>
                                                        </div>

                                                        <div class="">
                                                            <input type="checkbox" name="permissions[]"
                                                                   value="{{'create-org_users-' .$record->name_en}}">

                                                            <label for="{{'create-org_users-' .$record->name_en}}">
                                                                {{__('words.update')}}
                                                            </label>
                                                        </div>

                                                        <div class="">
                                                            <input type="checkbox" name="permissions[]"
                                                                   value="{{'update-org_users-' .$record->name_en}}">

                                                            <label for="{{'update-org_users-' .$record->name_en}}">
                                                                {{__('words.update')}}
                                                            </label>
                                                        </div>

                                                        <div class="">
                                                            <input type="checkbox" name="permissions[]"
                                                                   value="{{'delete-org_users-' .$record->name_en}}">

                                                            <label for="{{'delete-org_users-' .$record->name_en}}">
                                                                {{__('words.update')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if(auth()->guard('web')->user() && auth()->guard('web')->user()->organizable &&  method_exists(auth()->guard('web')->user()->organizable,'branches'))
                                            <div class="col-md-2">
                                                <div class="card">
                                                    <div class="card-header card-role">
                                                        <h3 class="card-title">{{__('words.branches_users')}}</h3>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="form-group clearfix">
                                                            {{-- icheck-success d-inline --}}
                                                            <div class="">
                                                                <input type="checkbox" name="permissions[]"
                                                                       value="{{'read-branch_users-' .$record->name_en}}">

                                                                <label for="{{'read-branch_users-' .$record->name_en}}">
                                                                    {{__('words.read')}}
                                                                </label>
                                                            </div>

                                                            <div class="">
                                                                <input type="checkbox" name="permissions[]"
                                                                       value="{{'update-branch_users-' .$record->name_en}}">

                                                                <label for="{{'update-branch_users-' .$record->name_en}}">
                                                                    {{__('words.update')}}
                                                                </label>
                                                            </div>

                                                            <div class="">
                                                                <input type="checkbox" name="permissions[]"
                                                                       value="{{'delete-branch_users-' .$record->name_en}}">

                                                                <label for="{{'delete-branch_users-' .$record->name_en}}">
                                                                    {{__('words.update')}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if($record->getTable() == 'rental_offices')
                                            <div class="col-md-2">
                                                <div class="card">
                                                    <div class="card-header card-role">
                                                        <h3 class="card-title">{{__('words.cars_properties')}}</h3>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="form-group clearfix">
                                                            {{-- icheck-success d-inline --}}
                                                            <div class="">
                                                                <input type="checkbox" name="permissions[]"
                                                                       value="{{'read-cars_properties-' .$record->name_en}}">

                                                                <label
                                                                    for="{{'read-cars_properties-' .$record->name_en}}">
                                                                    {{__('words.read')}}
                                                                </label>
                                                            </div>

                                                            <div class="">
                                                                <input type="checkbox" name="permissions[]"
                                                                       value="{{'create-cars_properties-' .$record->name_en}}">

                                                                <label
                                                                    for="{{'create-cars_properties-' .$record->name_en}}">
                                                                    {{__('words.update')}}
                                                                </label>
                                                            </div>

                                                            <div class="">
                                                                <input type="checkbox" name="permissions[]"
                                                                       value="{{'update-cars_properties-' .$record->name_en}}">

                                                                <label
                                                                    for="{{'update-cars_properties-' .$record->name_en}}">
                                                                    {{__('words.update')}}
                                                                </label>
                                                            </div>

                                                            <div class="">
                                                                <input type="checkbox" name="permissions[]"
                                                                       value="{{'delete-cars_properties-' .$record->name_en}}">

                                                                <label
                                                                    for="{{'delete-cars_properties-' .$record->name_en}}">
                                                                    {{__('words.update')}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        {{--Moule does'nt have relation end--}}
                                        <?php  $arr = config('laratrust_seeder.org_roles');?>
                                        @if($record->getAttribute('branchable_type') == 'App\\Models\\CarShowroom')
                                            <?php
                                            unset($arr['tests'], $arr['reservations']);

                                            ?>
                                        @endif
                                        @foreach ($arr as $key => $values)

                                            @if(method_exists(auth()->guard('web')->user()->organizable,str_replace('org_','',$key)))

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
                                                                               id="{{$value . '-' . $key.'-'.$record->name_en}}"
                                                                               name="permissions[]"
                                                                               value="{{$value . '-' . $key.'-'.$record->name_en}}">
                                                                        <label
                                                                            for="{{$value . '-' . $key.'-'.$record->name_en}}">
                                                                            {{__('words.'.$value)}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <button type="submit" class="btn btn-block btn-outline-success">
                                                {{__('words.create')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
