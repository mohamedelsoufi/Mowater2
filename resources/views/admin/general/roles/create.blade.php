@extends('admin.layouts.standard')
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
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">{{__('words.home')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin-roles.index')}}">{{__('words.roles')}}</a></li>
                            <li class="breadcrumb-item active">{{__('words.create_role')}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        @include('admin.includes.alerts.success')
        @include('admin.includes.alerts.errors')
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
                            <form action="{{route('admin-roles.store')}}" method="POST" autocomplete="off"
                                  enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    <div class="row">
                                        <div class="input-group col-6 mb-3">
                                            <input type="text" name="name_ar" dir="rtl" class="form-control @error('name_ar') is-invalid @enderror"
                                                   value="{{ old('name_ar') }}" placeholder="{{__('words.name_ar')}}">
                                            @error('name_ar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="input-group col-6 mb-3">
                                            <input type="text" name="name_en" dir="ltr" class="form-control @error('name_en') is-invalid @enderror"
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
                                            <input type="text" name="description_ar" dir="rtl" class="form-control @error('description_ar') is-invalid @enderror"
                                                   value="{{ old('description_ar') }}" placeholder="{{__('words.description_ar')}}">
                                            @error('description_ar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="input-group col-6 mb-3">
                                            <input type="text" name="description_en" dir="ltr" class="form-control @error('description_en') is-invalid @enderror"
                                                   value="{{ old('description_en') }}" placeholder="{{__('words.description_en')}}">
                                            @error('description_en')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
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
                                                                    <input type="checkbox" id="{{$value . '-' . $key}}" name="permissions[]" value="{{$value . '-' . $key}}">

                                                                    <label for="{{$value . '-' . $key}}">
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
