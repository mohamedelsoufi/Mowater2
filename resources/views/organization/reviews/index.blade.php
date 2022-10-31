@extends('organization.layouts.app')
@section('title', __('words.show_reviews'))
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('words.dashboard') .' '. $record->name}}</h1>
                        <br>
                        <b class="text-success">{{__('words.total_rates') .': '. $record->rating}}</b>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb {{app()->getLocale() == 'ar' ? 'float-sm-left' :  'float-sm-right'}}">
                            <li class="breadcrumb-item"><a
                                    href="{{route('organization.home')}}">{{__('words.home')}}</a></li>
                            <li class="breadcrumb-item active">{{__('words.show_reviews')}}</li>
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

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{__('words.show_reviews')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.user')}}</th>
                                        <th>{{__('words.rate')}}</th>
                                        <th>{{__('words.review')}}</th>
                                        <th>{{__('words.created_at')}}</th>
                                        <th>{{__('words.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reviews as $key => $review)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$review->user ? $review->user->nickname.' '.$review->user->first_name .' '. $review->user->last_name: ''}}</td>
                                            <td>{{$review->rate}}</td>
                                            <td>{{Str::limit($review->review , 20)}}</td>
                                            <td>{{createdAtFormat($review->created_at)}}</td>
                                            <td class="action">
                                                @if(auth('web')->user()->hasPermission(['read-reviews-' . $record->name_en]))
                                                    <a href="{{route('organization.reviews.show',$review->id)}}"
                                                       class="btn btn-outline-info" data-toggle="tooltip"
                                                       title="{{__('words.show')}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if(auth('web')->user()->hasPermission(['delete-reviews-' . $record->name_en]))
                                                    <a href="" class="btn btn-outline-danger"
                                                       data-toggle="modal"
                                                       data-target="#ModalDelete{{$review->id}}"
                                                       title="{{__('words.delete')}}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @include('organization.reviews.deleteModal')
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
