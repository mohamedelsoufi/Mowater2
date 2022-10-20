@extends('organization.layouts.app')
@section('title', __('words.show_discount_card'))
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('words.dashboard') .' '. $record->title}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb {{app()->getLocale() == 'ar' ? 'float-sm-left' :  'float-sm-right'}}">
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.home')}}">{{__('words.home')}}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.discount-cards.index')}}">{{__('words.show_discount_cards')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_discount_card')}}</li>
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
                                <h3 class="card-title">{{__('words.show_discount_card').': '.$discount_card->title}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">
                                                {{__('words.image_s')}}</th>
                                            <td>
                                                @if(! $discount_card->image)
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
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.title_ar')}}</th>
                                            <td>{{$discount_card->title_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.title_en')}}</th>
                                            <td>{{$discount_card->title_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_ar')}}</th>
                                            <td>{{$discount_card->description_ar}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.description_en')}}</th>
                                            <td>{{$discount_card->description_en}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.price')}}</th>
                                            <td>{{$discount_card->price}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.year')}}</th>
                                            <td>{{$discount_card->year}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.subscription')}}</th>
                                            <td>{{$record->discount_cards()->where('discount_card_id',$discount_card->id)->first() ? __('words.subscribed') : __('words.unsubscribed')}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.org_activity')}}</th>
                                            <td>{{$record->discount_cards()->where('discount_card_id',$discount_card->id)->first() ?
 $record->discount_cards()->where('discount_card_id',$discount_card->id)->first()->getActive() :'--'}}</td>
                                        </tr>
                                        <tr>
                                            <th class="show-details-table">{{__('words.status')}}</th>
                                            <td>{{$discount_card->getStatus()}}</td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
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
