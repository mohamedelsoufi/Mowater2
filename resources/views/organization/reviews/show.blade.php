@extends('organization.layouts.app')
@section('title', __('words.show_review'))
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
                            <li class="breadcrumb-item"><a href="{{route('organization.home')}}">{{__('words.home')}}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.reviews.index')}}">{{__('words.show_reviews')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.show_review')}}</li>
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
                                <h3 class="card-title">{{__('words.show_review').': '.$record->name}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="show-details-table">{{__('words.user')}}</th>
                                            <td>{{$review->user ? $review->user->nickname.' '.$review->user->first_name .' '. $review->user->last_name: ''}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.rate')}}</th>
                                            <td>{{$review->rate}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.review')}}</th>
                                            <td>{{$review->review}}</td>
                                        </tr>

                                        <tr>
                                            <th class="show-details-table">{{__('words.created_at')}}</th>
                                            <td>{{createdAtFormat($review->created_at)}}</td>
                                        </tr>
                                    </table>
                                </div>

                            </div>

                            @if(auth('web')->user()->hasPermission(['delete-reviews-' . $record->name_en]))
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="" class="btn btn-outline-danger"
                                               data-toggle="modal"
                                               data-target="#ModalDelete{{$review->id}}"
                                               title="{{__('words.delete')}}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            @include('organization.reviews.deleteModal')
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
