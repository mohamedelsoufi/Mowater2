@extends('organization.layouts.app')
@section('title', __('words.show_discount_cards'))
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
                            <li class="breadcrumb-item active">{{__('words.show_discount_cards')}}</li>
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
                                <h3 class="card-title">{{__('words.show_discount_cards').': '.$record->name}}</h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.image_s')}}</th>
                                        <th>{{__('words.title')}}</th>
                                        <th>{{__('words.year')}}</th>
                                        <th>{{__('words.price')}}</th>
                                        <th>{{__('words.status')}}</th>
                                        <th>{{__('words.subscription')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($discountCards as $key => $discount_card)
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
                                            <td>{{$discount_card->title}}</td>
                                            <td>{{$discount_card->year}}</td>
                                            <td>{{$discount_card->price}}</td>
                                            <td>
                                                @foreach(discount_card_status_arr() as $key=>$val)
                                                    @if($discount_card->status === $key)
                                                        {{$val}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{$record->discount_cards()->where('discount_card_id',$discount_card->id)->first() ? __('words.subscribed') : __('words.unsubscribed')}}</td>
                                            <td class="action">
                                                @if(auth('web')->user()->hasPermission(['read-org_discount_cards-' . $record->name_en]))
                                                    <a href="{{route('organization.discount-cards.show',$discount_card->id)}}"
                                                       class="btn btn-outline-warning" data-toggle="tooltip"
                                                       title="{{__('words.show_discount_card')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if($discount_card->status == 'finished')
                                                    <button type="button" class="btn btn-outline-info">
                                                        <a href="{{route('organization.discount-cards.show_offer',$discount_card->id)}}">{{__('words.show_offers')}}</a>
                                                    </button>
                                                @elseif($record->discount_cards()->where('discount_card_id',$discount_card->id)->first())
                                                    <button type="button" class="btn btn-outline-info">
                                                        <a href="{{route('organization.discount-cards.show_offer',$discount_card->id)}}">{{__('words.show_offers')}}</a>
                                                    </button>
                                                @else
                                                    @if(auth('web')->user()->hasPermission(['subscribe-org_discount_cards-' . $record->name_en]) && $discount_card->status == 'not_started')
                                                        <a href="" class="btn btn-outline-success"
                                                           data-toggle="modal"
                                                           data-target="#ModalSubscribe{{$discount_card->id}}">
                                                            {{__('words.subscribe')}}
                                                        </a>
                                                        @include('organization.discountCards.subscribeModal')
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
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
