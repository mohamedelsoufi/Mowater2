@extends('admin.layouts.standard')
@section('title', __('words.show_discount_card_org'))
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
                                    href="{{route('discount-cards.index')}}">{{__('words.show_discount_cards')}}</a>
                            </li>
                            <li class="breadcrumb-item"><a
                                    href="{{route('discount-cards.org.get',$id)}}">{{__('words.show_discount_card_orgs')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_discount_card_org')}}</li>
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
                                <h3 class="card-title">{{__('words.show_discount_card_org')}}</h3>
                            </div>
                            <form method="post" action="{{route('discount-cards.org.update',$org['discountCardOrgId'])}}"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tr>
                                                <th class="show-details-table">{{__('words.logo')}}</th>
                                                <td>
                                                    @if(!$org['logo'])
                                                        <a href="{{asset('uploads/default_image.png')}}"
                                                           data-toggle="lightbox" data-title="{{$org['name']}}"
                                                           data-gallery="gallery">
                                                            <img class="index_image"
                                                                 src="{{asset('uploads/default_image.png')}}"
                                                                 alt="logo">
                                                        </a>
                                                    @else
                                                        <a href="{{$org['logo']}}"
                                                           data-toggle="lightbox" data-title="{{$org['name']}}"
                                                           data-gallery="gallery">
                                                            <img class="index_image"
                                                                 src="{{$org['logo']}}"
                                                                 onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                                 alt="logo">
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="show-details-table">{{__('words.name')}}</th>
                                                <td>{{$org['name']}}</td>
                                            </tr>

                                            <tr>
                                                <th class="show-details-table">{{__('words.activity')}}</th>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="active" type="checkbox"
                                                               value="1" {{$org['active'] == 1 ? 'checked' : ''}}>
                                                        <label class="form-check-label">{{__('words.active')}}</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="show-details-table">{{__('words.created_at')}}</th>
                                                <td>{{createdAtFormat($org['created_at'])}}</td>
                                            </tr>

                                            <tr>
                                                <th class="show-details-table">{{__('words.updated_at')}}</th>
                                                <td>{{createdAtFormat($org['created_at']) == updatedAtFormat($org['updated_at']) ? '--' : updatedAtFormat($org['updated_at'])}}</td>
                                            </tr>

                                        </table>
                                    </div>

                                </div>

                                @if(auth('admin')->user()->hasPermission('update-org-discount_cards'))
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-4">
                                                <button type="submit" class="btn btn-block btn-outline-info">
                                                    {{__('words.update')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </form>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
