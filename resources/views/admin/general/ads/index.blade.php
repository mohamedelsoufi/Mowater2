@extends('admin.layouts.standard')
@section('title', __('words.show_ads'))
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
                            <li class="breadcrumb-item active">{{__('words.show_ads')}}</li>
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
                                <h3 class="card-title">{{__('words.show_ads')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.image_s')}}</th>
                                        <th>{{__('words.title')}}</th>
                                        <th>{{__('words.type')}}</th>
                                        <th>{{__('words.price')}}</th>
                                        <th>{{__('words.status')}}</th>
                                        <th>{{__('words.activity')}}</th>
                                        <th>{{__('words.created_by')}}</th>
                                        <th>{{__('words.created_at')}}</th>
                                        <th>{{__('words.updated_at')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($ads as $key => $ad)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                @if(!$ad->image)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$ad->title}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$ad->image}}"
                                                       data-toggle="lightbox" data-title="{{$ad->title}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$ad->image}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{$ad->title}}</td>
                                            <td>
                                                @if($ad->getRawOriginal('link') != null)
                                                    <a href="{{$ad->link}}"
                                                       target="_blank">{{__('words.external_ad_link')}}</a>
                                                @else
                                                    {{__('words.ad_in_app')}}
                                                @endif
                                            </td>
                                            <td>{{$ad->price}}</td>
                                            <td>{{$ad->getStatus()}}</td>
                                            <td>{{$ad->getActive()}}</td>
                                            <td>{{$ad->created_by}}</td>
                                            <td>{{createdAtFormat($ad->created_at)}}</td>
                                            <td>{{createdAtFormat($ad->created_at) == updatedAtFormat($ad->updated_at) ? '--' : updatedAtFormat($ad->updated_at)}}</td>
                                            <td class="action">
                                                @if(auth('admin')->user()->hasPermission('read-ads'))
                                                    <a href="{{route('ads.show',$ad->id)}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('update-ads'))
                                                    <a href="{{route('ads.edit',$ad->id)}}"
                                                       data-toggle="tooltip"
                                                       title="{{__('words.edit')}}"
                                                       class="btn btn-outline-warning"> <i class="fas fa-pen"></i></a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('delete-ads'))
                                                    <a href="" class="btn btn-outline-danger"
                                                       data-toggle="modal"
                                                       data-target="#ModalDelete{{$ad->id}}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @include('admin.general.ads.deleteModal')
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
