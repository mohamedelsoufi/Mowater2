@extends('admin.layouts.standard')
@section('title', __('words.create_admin_user'))
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
                            <li class="breadcrumb-item"><a href="{{route('admin-users.index')}}">{{__('words.show_admin_users')}}</a></li>
                            <li class="breadcrumb-item active">{{__('words.create_admin_user')}}</li>
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
                                <h3 class="card-title">{{__('words.create_admin_user')}}</h3>
                            </div>
                            <form action="{{route('admin-users.store')}}" method="POST" autocomplete="off"
                                  enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    <div class="row">
                                        <div class="input-group col-6 mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                                   value="{{ old('first_name') }}" placeholder="{{__('words.first_name')}}">
                                            @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="input-group col-6 mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                                   value="{{ old('last_name') }}" placeholder="{{__('words.last_name')}}">
                                            @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="input-group col-6 mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                                                   value="{{ old('email') }}" placeholder="{{__('words.email')}}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="input-group col-6 mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                                   value="{{ old('password') }}" placeholder="{{__('words.password')}}">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="input-group col-6 mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input type="password" name="password_confirmation"
                                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                                   value="{{ old('password_confirmation') }}"
                                                   placeholder="{{__('words.confirm_password')}}">

                                            @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>{{__('words.roles')}}</label>
                                            <select name="role_id"
                                                    class="form-control @error('role_id') is-invalid @enderror">
                                                <option value="" selected>{{__('words.choose')}}</option>
                                                @foreach($roles as $role)
                                                    <option value="{{$role->id}}" {{old('role_id') == $role->id ? "selected" : ""}}>{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('role_id')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                            <div class="input-group col-6 mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active" type="checkbox" value="1" {{old('active') ? "checked" : ""}}>
                                                    <label class="form-check-label">{{__('words.active')}}</label>
                                                </div>
                                            </div>
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
