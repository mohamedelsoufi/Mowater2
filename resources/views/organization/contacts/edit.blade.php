@extends('organization.layouts.app')
@section('title', __('words.edit_contacts'))
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
                                    href="{{route('organization.contacts.index')}}">{{__('words.show_contacts')}}</a>
                            </li>

                            <li class="breadcrumb-item active">{{__('words.edit_contacts')}}</li>
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
                                <h3 class="card-title">{{__('words.edit_contacts')}}</h3>
                            </div>
                            <form method="post" action="{{route('organization.contacts.update')}}"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.facebook_link')}}</label>
                                                <input type="url" name="facebook_link" dir="ltr"
                                                       class="form-control @error('facebook_link') is-invalid @enderror"
                                                       value="{{ old('facebook_link',$contact != null ? $contact->facebook_link : '') }}"
                                                       placeholder="{{__('words.facebook_link')}}">
                                                @error('facebook_link')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.instagram_link')}}</label>
                                                <input type="url" name="instagram_link" dir="ltr"
                                                       class="form-control @error('instagram_link') is-invalid @enderror"
                                                       value="{{ old('instagram_link',$contact != null ? $contact->instagram_link : '') }}"
                                                       placeholder="{{__('words.instagram_link')}}">

                                                @error('instagram_link')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.whatsapp_number')}}</label>
                                                <input type="text" name="whatsapp_number" dir="ltr"
                                                       class="form-control @error('whatsapp_number') is-invalid @enderror"
                                                       value="{{ old('whatsapp_number',$contact != null ? $contact->whatsapp_number : '') }}"
                                                       placeholder="{{__('words.whatsapp_number')}}">
                                                @error('whatsapp_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.website')}}</label>
                                                <input type="url" name="website" dir="ltr"
                                                       class="form-control @error('website') is-invalid @enderror"
                                                       value="{{ old('website',$contact != null ? $contact->website : '') }}"
                                                       placeholder="{{__('words.website')}}">

                                                @error('website')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.country_code')}}</label>
                                                <select name="country_code" id="single-select"
                                                        class="form-control select2 select2-danger @error('country_code') is-invalid @enderror" style="width: 100%;" data-dropdown-css-class="select2-danger">
                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                    @foreach(phoneCodes() as $key=>$value)
                                                        <option value="{{$key}}" {{$contact != null && $contact->country_code == $key ? 'selected' : ''}}>{{$value}}</option>
                                                    @endforeach
                                                </select>

                                                @error('country_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.phone')}}</label>
                                                <input type="text" name="phone" dir="ltr"
                                                       class="form-control @error('phone') is-invalid @enderror"
                                                       value="{{ old('phone',$contact != null ? $contact->phone : '') }}"
                                                       placeholder="{{__('words.phone')}}">

                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <button type="submit" class="btn btn-block btn-outline-info">
                                                {{__('words.update')}}
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
