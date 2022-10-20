@extends('organization.layouts.app')
@section('title', __('words.show_role'))
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('words.organization_dashboard')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb {{app()->getLocale() == 'ar' ? 'float-sm-left' :  'float-sm-right'}}">
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.home')}}">{{__('words.home')}}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.org-roles.index')}}">{{__('words.roles')}}</a></li>
                            <li class="breadcrumb-item active">{{__('words.show_role')}}</li>
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
                                <h3 class="card-title">{{__('words.show_role') .": ".$role->name}}</h3>
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
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_by')}}</th>
                                            <td>{{$role->created_by}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($role->created_at)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.updated_at')}}</th>
                                            <td>{{createdAtFormat($role->created_at) == updatedAtFormat($role->updated_at) ? '--' : updatedAtFormat($role->updated_at)}}</td>
                                        </tr>
                                    </table>
                                </div>
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
                                                        <input type="checkbox"
                                                               disabled {{$role->hasPermission('read-general_data-' .$record->name_en) ? 'checked' : ''}}>

                                                        <label for="{{'read-general_data-' .$record->name_en}}"
                                                               class="{{$role->hasPermission('read-general_data-' .$record->name_en) ? 'text-success' : ''}}">
                                                            {{__('words.read')}}
                                                        </label>
                                                    </div>
                                                    <div class="">
                                                        <input type="checkbox"
                                                               disabled {{$role->hasPermission('update-general_data-' .$record->name_en) ? 'checked' : ''}}>

                                                        <label for="{{'update-general_data-' .$record->name_en}}"
                                                               class="{{$role->hasPermission('update-general_data-' .$record->name_en) ? 'text-success' : ''}}">
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
                                                        <input type="checkbox" disabled
                                                               value="{{'read-org_users-' .$record->name_en}}"
                                                            {{$role->hasPermission('read-org_users-' .$record->name_en) ? 'checked' : ''}}>

                                                        <label for="{{'read-org_users-' .$record->name_en}}"
                                                               class="{{$role->hasPermission('read-org_users-' .$record->name_en) ? 'text-success' : ''}}">
                                                            {{__('words.read')}}
                                                        </label>
                                                    </div>

                                                    <div class="">
                                                        <input type="checkbox" disabled
                                                               value="{{'create-org_users-' .$record->name_en}}"
                                                            {{$role->hasPermission('create-org_users-' .$record->name_en) ? 'checked' : ''}}>

                                                        <label for="{{'create-org_users-' .$record->name_en}}"
                                                               class="{{$role->hasPermission('create-org_users-' .$record->name_en) ? 'text-success' : ''}}">
                                                            {{__('words.update')}}
                                                        </label>
                                                    </div>

                                                    <div class="">
                                                        <input type="checkbox" disabled
                                                               value="{{'update-org_users-' .$record->name_en}}"
                                                            {{$role->hasPermission('update-org_users-' .$record->name_en) ? 'checked' : ''}}>

                                                        <label for="{{'update-org_users-' .$record->name_en}}"
                                                               class="{{$role->hasPermission('update-org_users-' .$record->name_en) ? 'text-success' : ''}}">
                                                            {{__('words.update')}}
                                                        </label>
                                                    </div>

                                                    <div class="">
                                                        <input type="checkbox" disabled
                                                               value="{{'delete-org_users-' .$record->name_en}}"
                                                            {{$role->hasPermission('delete-org_users-' .$record->name_en) ? 'checked' : ''}}>

                                                        <label for="{{'delete-org_users-' .$record->name_en}}"
                                                               class="{{$role->hasPermission('delete-org_users-' .$record->name_en) ? 'text-success' : ''}}">
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
                                                            <input type="checkbox" disabled
                                                                   value="{{'read-branch_users-' .$record->name_en}}"
                                                                {{$role->hasPermission('read-branch_users-' .$record->name_en) ? 'checked' : ''}}>

                                                            <label for="{{'read-branch_users-' .$record->name_en}}"
                                                                   class="{{$role->hasPermission('read-branch_users-' .$record->name_en) ? 'text-success' : ''}}">
                                                                {{__('words.read')}}
                                                            </label>
                                                        </div>

                                                        <div class="">
                                                            <input type="checkbox" disabled
                                                                   value="{{'update-branch_users-' .$record->name_en}}"
                                                                {{$role->hasPermission('update-branch_users-' .$record->name_en) ? 'checked' : ''}}>

                                                            <label
                                                                for="{{'update-branch_users-' .$record->name_en}}"
                                                                class="{{$role->hasPermission('update-branch_users-' .$record->name_en) ? 'text-success' : ''}}">
                                                                {{__('words.update')}}
                                                            </label>
                                                        </div>

                                                        <div class="">
                                                            <input type="checkbox" disabled
                                                                   value="{{'delete-branch_users-' .$record->name_en}}"
                                                                {{$role->hasPermission('delete-branch_users-' .$record->name_en) ? 'checked' : ''}}>

                                                            <label
                                                                for="{{'delete-branch_users-' .$record->name_en}}"
                                                                class="{{$role->hasPermission('delete-branch_users-' .$record->name_en) ? 'text-success' : ''}}">
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
                                                            <input type="checkbox" disabled
                                                                   value="{{'read-cars_properties-' .$record->name_en}}"
                                                                {{$role->hasPermission('read-cars_properties-' .$record->name_en) ? 'checked' : ''}}>

                                                            <label for="{{'read-cars_properties-' .$record->name_en}}"
                                                                   class="{{$role->hasPermission('read-cars_properties-' .$record->name_en) ? 'text-success' : ''}}">
                                                                {{__('words.read')}}
                                                            </label>
                                                        </div>

                                                        <div class="">
                                                            <input type="checkbox" disabled
                                                                   value="{{'create-cars_properties-' .$record->name_en}}"
                                                                {{$role->hasPermission('create-cars_properties-' .$record->name_en) ? 'checked' : ''}}>

                                                            <label for="{{'create-cars_properties-' .$record->name_en}}"
                                                                   class="{{$role->hasPermission('create-cars_properties-' .$record->name_en) ? 'text-success' : ''}}">
                                                                {{__('words.update')}}
                                                            </label>
                                                        </div>

                                                        <div class="">
                                                            <input type="checkbox" disabled
                                                                   value="{{'update-cars_properties-' .$record->name_en}}"
                                                                {{$role->hasPermission('update-cars_properties-' .$record->name_en) ? 'checked' : ''}}>

                                                            <label for="{{'update-cars_properties-' .$record->name_en}}"
                                                                   class="{{$role->hasPermission('update-cars_properties-' .$record->name_en) ? 'text-success' : ''}}">
                                                                {{__('words.update')}}
                                                            </label>
                                                        </div>

                                                        <div class="">
                                                            <input type="checkbox" disabled
                                                                   value="{{'delete-cars_properties-' .$record->name_en}}"
                                                                {{$role->hasPermission('delete-cars_properties-' .$record->name_en) ? 'checked' : ''}}>

                                                            <label for="{{'-cars_properties-' .$record->name_en}}"
                                                                   class="{{$role->hasPermission('delete-cars_properties-' .$record->name_en) ? 'text-success' : ''}}">
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
                                                                           disabled {{$role->hasPermission($value . '-' . $key.'-'.$record->name_en) ? 'checked' : ''}}>

                                                                    <label
                                                                        for="{{$value . '-' . $key.'-'.$record->name_en}}"
                                                                        class="{{$role->hasPermission($value . '-' . $key.'-'.$record->name_en) ? 'text-success' : ''}}">
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

                            @if(auth('web')->user()->hasPermission('update-org_roles-'. $record->name_en))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('organization.org-roles.edit',$role->id)}}"
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
