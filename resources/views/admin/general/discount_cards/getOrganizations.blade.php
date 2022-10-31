@extends('admin.layouts.standard')
@section('title', __('words.show_discount_card_orgs'))
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
                            <li class="breadcrumb-item active">{{__('words.show_discount_card_orgs')}}</li>
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

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{__('words.show_discount_card_orgs')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.logo')}}</th>
                                        <th>{{__('words.name')}}</th>
                                        <th>{{__('words.activity')}}</th>
                                        <th>{{__('words.created_at')}}</th>
                                        <th>{{__('words.updated_at')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($org_name as $key => $org)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                @if(!$org['logo'])
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$org['name']}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
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
                                            <td>{{$org['name']}}</td>
                                            <td>{{$org['active']}}</td>
                                            <td>{{createdAtFormat($org['created_at'])}}</td>
                                            <td>{{createdAtFormat($org['created_at']) == updatedAtFormat($org['updated_at']) ? '--' : updatedAtFormat($org['updated_at'])}}</td>

                                            <td class="action">
                                                @if(auth('admin')->user()->hasPermission('update-org-discount_cards'))
                                                    <a href="{{route('discount-cards.org.show',$org['discountCardOrgId'])}}"
                                                       data-toggle="tooltip"
                                                       title="{{__('words.edit')}}"
                                                       class="btn btn-outline-warning"> <i class="fas fa-pen"></i></a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('delete-org-discount_cards'))
                                                    <a href="" class="btn btn-outline-danger"
                                                       data-toggle="modal"
                                                       data-target="#ModalDeleteOrg{{$org['discountCardOrgId']}}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @include('admin.general.discount_cards.deleteDcOrgModal')
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>

    </div>

@endsection
