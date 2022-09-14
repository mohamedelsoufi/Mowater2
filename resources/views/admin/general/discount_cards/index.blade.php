@extends('admin.layouts.standard')
@section('title', __('words.show_discount_cards'))
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
                            <li class="breadcrumb-item active">{{__('words.show_discount_cards')}}</li>
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
                                <h3 class="card-title">{{__('words.show_discount_cards')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.image_s')}}</th>
                                        <th>{{__('words.title_ar')}}</th>
                                        <th>{{__('words.title_en')}}</th>
                                        <th>{{__('words.year')}}</th>
                                        <th>{{__('words.price')}}</th>
                                        <th>{{__('words.activity')}}</th>
                                        <th>{{__('words.created_at')}}</th>
                                        <th>{{__('words.updated_at')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($discount_cards as $key => $discount_card)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                @if(!$discount_card->image)
                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                       data-toggle="lightbox" data-title="{{$discount_card->title}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{asset('uploads/default_image.png')}}" alt="logo">
                                                    </a>
                                                @else
                                                    <a href="{{$discount_card->image}}"
                                                       data-toggle="lightbox" data-title="{{$discount_card->title}}"
                                                       data-gallery="gallery">
                                                        <img class="index_image"
                                                             src="{{$discount_card->image}}"
                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                             alt="logo">
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{$discount_card->title_ar}}</td>
                                            <td>{{$discount_card->title_en}}</td>
                                            <td>{{$discount_card->year}}</td>
                                            <td>{{$discount_card->price}}</td>
                                            <td>{{$discount_card->getActive()}}</td>
                                            <td>{{createdAtFormat($discount_card->created_at)}}</td>
                                            <td>{{createdAtFormat($discount_card->created_at) == updatedAtFormat($discount_card->updated_at) ? '--' : updatedAtFormat($discount_card->updated_at)}}</td>
                                            <td>
                                                @if(auth('admin')->user()->hasPermission('read-discount_cards'))
                                                    <a href="{{route('discount-cards.show',$discount_card->id)}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('update-discount_cards'))
                                                    <a href="{{route('discount-cards.edit',$discount_card->id)}}"
                                                       data-toggle="tooltip"
                                                       title="{{__('words.edit')}}"
                                                       class="btn btn-outline-warning"> <i class="fas fa-pen"></i></a>
                                                @endif

                                                @if(auth('admin')->user()->hasPermission('delete-discount_cards'))
                                                    <a href="" class="btn btn-outline-danger"
                                                       data-toggle="modal"
                                                       data-target="#ModalDelete{{$discount_card->id}}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @include('admin.general.discount_cards.deleteModal')
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
