@extends('organization.layouts.app')
@section('title', __('words.discount_card_offers'))
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
                                    href="{{route('organization.discount-cards.index')}}">{{__('words.show_discount_cards')}}</a>
                            </li>

                            <li class="breadcrumb-item active">{{__('words.discount_card_offers')}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @include('organization.includes.alerts.success')
        @include('organization.includes.alerts.errors')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">{{__('words.discount_card_offers')}}</h3>
                            </div>
                            <form method="post"
                                  action="{{route('organization.discount-cards.update_offers',$discount_card->id)}}"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="discount_card_id" value="{{$discount_card->id}}">
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="card-body">
                                            @if(isset($vehicles) && count($vehicles) > 0)
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header bg-primary">
                                                            <h3 class="card-title">{{__('words.vehicles')}}</h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body table-responsive p-0"
                                                             style="height: 600px;">
                                                            <table class="table table-head-fixed text-nowrap">
                                                                <thead>
                                                                <tr class="text-center">
                                                                    <th>
                                                                        <i class="fas fa-check-circle"></i> {{__('words.select')}}
                                                                    </th>
                                                                    <th>{{__('words.image_s')}}</th>
                                                                    <th>{{__('words.name')}}</th>
                                                                    <th>{{__('words.number_of_uses_times')}}</th>
                                                                    <th>{{__('words.discount_type')}}</th>
                                                                    <th>{{__('words.value')}}</th>
                                                                    <th>{{__('words.notes')}}</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @for($i = 0 ; $i < count($vehicles); $i++)
                                                                    <tr class="text-center">
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input"
                                                                                       name="vehicle_id[{{$i}}]"
                                                                                       value="{{$vehicles[$i]->id}}"
                                                                                       {{$vehicles[$i]->offers->first() ? 'checked' :''}}
                                                                                       {{$discount_card->status != 'not_started' ? 'disabled' : ''}}
                                                                                       {{ (is_array(old('vehicle_id')) && in_array($vehicles[$i]->id,old('vehicle_id.*'))) ? ' checked' : '' }}
                                                                                       type="checkbox">
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            @if(!$vehicles[$i]->one_image)
                                                                                <a href="{{asset('uploads/default_image.png')}}"
                                                                                   data-toggle="lightbox"
                                                                                   data-title="{{$vehicles[$i]->name}}"
                                                                                   data-gallery="gallery">
                                                                                    <img class="index_image"
                                                                                         src="{{asset('uploads/default_image.png')}}"
                                                                                         alt="logo">
                                                                                </a>
                                                                            @else
                                                                                <a href="{{$vehicles[$i]->one_image}}"
                                                                                   data-toggle="lightbox"
                                                                                   data-title="{{$vehicles[$i]->name}}"
                                                                                   data-gallery="gallery">
                                                                                    <img class="index_image"
                                                                                         src="{{$vehicles[$i]->one_image}}"
                                                                                         onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                                                         alt="logo">
                                                                                </a>
                                                                            @endif
                                                                        </td>

                                                                        <td>{{$vehicles[$i]->name}}</td>

                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="number"
                                                                                       name="vehicle_specific_number[{{$i}}]"
                                                                                       min="1" {{$discount_card->status != 'not_started' ? 'disabled' : ''}}
                                                                                       class="form-control @error('vehicle_specific_number.'.$i) is-invalid @enderror"
                                                                                       value="{{ old('vehicle_specific_number',$vehicles[$i]->get_offer($discount_card->id) ? $vehicles[$i]->get_offer($discount_card->id)->specific_number : '') }}"
                                                                                       placeholder="{{__('words.specific_number')}}">
                                                                                @error('vehicle_specific_number.'.$i)
                                                                                <span class="invalid-feedback"
                                                                                      role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                @enderror
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <div class="form-group">
                                                                                <select {{$discount_card->status != 'not_started' ? 'disabled' : ''}}
                                                                                        name="vehicle_discount_type[{{$i}}]"
                                                                                        class="form-control @error('vehicle_discount_type') is-invalid @enderror">
                                                                                    <option value="" selected>{{__('words.choose')}}</option>
                                                                                    <option value="percentage"
                                                                                        {{old('vehicle_discount_type',$vehicles[$i]->get_offer($discount_card->id) != null ? $vehicles[$i]->get_offer($discount_card->id)->discount_type : '') == "percentage"  ? "selected" : ""}}
                                                                                    >{{__('words.percentage')}}</option>

                                                                                    <option value="amount"
                                                                                        {{old('vehicle_discount_type',$vehicles[$i]->get_offer($discount_card->id) != null ? $vehicles[$i]->get_offer($discount_card->id)->discount_type : '') == "amount"  ? "selected" : ""}}
                                                                                    >{{__('words.amount')}}</option>
                                                                                </select>
                                                                                @error('vehicle_discount_type.'.$i)
                                                                                <span class="invalid-feedback d-block"
                                                                                      role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="number"
                                                                                       name="vehicle_discount_value[{{$i}}]"
                                                                                       step="0.01"
                                                                                       min="0"  {{$discount_card->status != 'not_started' ? 'disabled' : ''}}
                                                                                       class="form-control @error('vehicle_discount_value.'.$i) is-invalid @enderror"
                                                                                       value="{{ old('vehicle_discount_value',$vehicles[$i]->get_offer($discount_card->id) ? $vehicles[$i]->get_offer($discount_card->id)->discount_value : '')}}"
                                                                                       placeholder="{{__('words.discount_value')}}">
                                                                                @error('vehicle_discount_value.'.$i)
                                                                                <span class="invalid-feedback"
                                                                                      role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                @enderror
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" {{$discount_card->status != 'not_started' ? 'disabled' : ''}}
                                                                                       name="vehicle_notes[{{$i}}]"
                                                                                       min="1"
                                                                                       class="form-control @error('vehicle_notes.'.$i) is-invalid @enderror"
                                                                                       value="{{ old('vehicle_notes',$vehicles[$i]->get_offer($discount_card->id) ? $vehicles[$i]->get_offer($discount_card->id)->notes : '') }}"
                                                                                       placeholder="{{__('words.notes')}}">
                                                                                @error('vehicle_notes.'.$i)
                                                                                <span class="invalid-feedback"
                                                                                      role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                @enderror
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endfor
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            @endif
                                            <br>
                                            <br>
                                            <br>
                                            @if(isset($products) && count($products) > 0)
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-header bg-gradient-primary">
                                                                <h3 class="card-title">{{__('words.products')}}</h3>
                                                            </div>
                                                            <!-- /.card-header -->
                                                            <div class="card-body table-responsive p-0"
                                                                 style="height: 600px;">
                                                                <table class="table table-head-fixed text-nowrap">
                                                                    <thead>
                                                                    <tr class="text-center">
                                                                        <th>
                                                                            <i class="fas fa-check-circle"></i> {{__('words.select')}}
                                                                        </th>
                                                                        <th>{{__('words.image_s')}}</th>
                                                                        <th>{{__('words.name')}}</th>
                                                                        <th>{{__('words.number_of_uses_times')}}</th>
                                                                        <th>{{__('words.discount_type')}}</th>
                                                                        <th>{{__('words.value')}}</th>
                                                                        <th>{{__('words.notes')}}</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @for($i = 0 ; $i < count($products); $i++)
                                                                        <tr class="text-center">
                                                                            <td>
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                           name="product_id[{{$i}}]"
                                                                                           value="{{$products[$i]->id}}"
                                                                                           {{$products[$i]->offers->first() ? 'checked' :''}}
                                                                                           {{$discount_card->status != 'not_started' ? 'disabled' : ''}}
                                                                                           {{ (is_array(old('product_id')) && in_array($products[$i]->id,old('product_id.*'))) ? ' checked' : '' }}
                                                                                           type="checkbox">
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                @if(!$products[$i]->one_image)
                                                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                                                       data-toggle="lightbox"
                                                                                       data-title="{{$products[$i]->name}}"
                                                                                       data-gallery="gallery">
                                                                                        <img class="index_image"
                                                                                             src="{{asset('uploads/default_image.png')}}"
                                                                                             alt="logo">
                                                                                    </a>
                                                                                @else
                                                                                    <a href="{{$products[$i]->one_image}}"
                                                                                       data-toggle="lightbox"
                                                                                       data-title="{{$products[$i]->name}}"
                                                                                       data-gallery="gallery">
                                                                                        <img class="index_image"
                                                                                             src="{{$products[$i]->one_image}}"
                                                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                                                             alt="logo">
                                                                                    </a>
                                                                                @endif
                                                                            </td>

                                                                            <td>{{$products[$i]->name}}</td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number"
                                                                                           name="product_specific_number[{{$i}}]"
                                                                                           min="1" {{$discount_card->status != 'not_started' ? 'disabled' : ''}}
                                                                                           class="form-control @error('product_specific_number.'.$i) is-invalid @enderror"
                                                                                           value="{{ old('product_specific_number',$products[$i]->get_offer($discount_card->id) ? $products[$i]->get_offer($discount_card->id)->specific_number : '') }}"
                                                                                           placeholder="{{__('words.specific_number')}}">
                                                                                    @error('product_specific_number.'.$i)
                                                                                    <span class="invalid-feedback"
                                                                                          role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <select {{$discount_card->status != 'not_started' ? 'disabled' : ''}}
                                                                                            name="product_discount_type[{{$i}}]"
                                                                                            class="form-control @error('product_discount_type') is-invalid @enderror">
                                                                                        <option value="" selected>{{__('words.choose')}}</option>
                                                                                        <option value="percentage"
                                                                                            {{old('product_discount_type',$products[$i]->get_offer($discount_card->id) != null ? $products[$i]->get_offer($discount_card->id)->discount_type : '') == "percentage"  ? "selected" : ""}}
                                                                                        >{{__('words.percentage')}}</option>

                                                                                        <option value="amount"
                                                                                            {{old('product_discount_type',$products[$i]->get_offer($discount_card->id) != null ? $products[$i]->get_offer($discount_card->id)->discount_type : '') == "amount"  ? "selected" : ""}}
                                                                                        >{{__('words.amount')}}</option>
                                                                                    </select>
                                                                                    @error('product_discount_type.'.$i)
                                                                                    <span class="invalid-feedback d-block"
                                                                                          role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number"
                                                                                           name="product_discount_value[{{$i}}]"
                                                                                           step="0.01"
                                                                                           min="0"  {{$discount_card->status != 'not_started' ? 'disabled' : ''}}
                                                                                           class="form-control @error('product_discount_value.'.$i) is-invalid @enderror"
                                                                                           value="{{ old('product_discount_value',$products[$i]->get_offer($discount_card->id) ? $products[$i]->get_offer($discount_card->id)->discount_value : '')}}"
                                                                                           placeholder="{{__('words.discount_value')}}">
                                                                                    @error('product_discount_value.'.$i)
                                                                                    <span class="invalid-feedback"
                                                                                          role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text"
                                                                                    {{$discount_card->status != 'not_started' ? 'disabled' : ''}}
                                                                                    name="product_notes[{{$i}}]"
                                                                                           min="1"
                                                                                           class="form-control @error('product_notes.'.$i) is-invalid @enderror"
                                                                                           value="{{ old('product_notes',$products[$i]->get_offer($discount_card->id) ? $products[$i]->get_offer($discount_card->id)->notes : '') }}"
                                                                                           placeholder="{{__('words.notes')}}">
                                                                                    @error('product_notes.'.$i)
                                                                                    <span class="invalid-feedback"
                                                                                          role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endfor
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                        <!-- /.card -->
                                                    </div>
                                                </div>
                                            @endif
                                            <br>
                                            <br>
                                            <br>
                                            @if(isset($services) && count($services) > 0)
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-header bg-primary">
                                                                <h3 class="card-title">{{__('words.services')}}</h3>
                                                            </div>
                                                            <!-- /.card-header -->
                                                            <div class="card-body table-responsive p-0"
                                                                 style="height: 600px;">
                                                                <table class="table table-head-fixed text-nowrap">
                                                                    <thead>
                                                                    <tr class="text-center">
                                                                        <th>
                                                                            <i class="fas fa-check-circle"></i> {{__('words.select')}}
                                                                        </th>
                                                                        <th>{{__('words.image_s')}}</th>
                                                                        <th>{{__('words.name')}}</th>
                                                                        <th>{{__('words.number_of_uses_times')}}</th>
                                                                        <th>{{__('words.discount_type')}}</th>
                                                                        <th>{{__('words.value')}}</th>
                                                                        <th>{{__('words.notes')}}</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @for($i = 0 ; $i < count($services); $i++)
                                                                        <tr class="text-center">
                                                                            <td>
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                           name="service_id[{{$i}}]"
                                                                                           value="{{$services[$i]->id}}"
                                                                                           {{$services[$i]->offers->first() ? 'checked' :''}}
                                                                                           {{$discount_card->status != 'not_started' ? 'disabled' : ''}}
                                                                                           {{ (is_array(old('service_id')) && in_array($services[$i]->id,old('service_id.*'))) ? ' checked' : '' }}
                                                                                           type="checkbox">
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                @if(!$services[$i]->one_image)
                                                                                    <a href="{{asset('uploads/default_image.png')}}"
                                                                                       data-toggle="lightbox"
                                                                                       data-title="{{$services[$i]->name}}"
                                                                                       data-gallery="gallery">
                                                                                        <img class="index_image"
                                                                                             src="{{asset('uploads/default_image.png')}}"
                                                                                             alt="logo">
                                                                                    </a>
                                                                                @else
                                                                                    <a href="{{$services[$i]->one_image}}"
                                                                                       data-toggle="lightbox"
                                                                                       data-title="{{$services[$i]->name}}"
                                                                                       data-gallery="gallery">
                                                                                        <img class="index_image"
                                                                                             src="{{$services[$i]->one_image}}"
                                                                                             onerror="this.src='{{asset('uploads/default_image.png')}}'"
                                                                                             alt="logo">
                                                                                    </a>
                                                                                @endif
                                                                            </td>

                                                                            <td>{{$services[$i]->name}}</td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number"
                                                                                           name="service_specific_number[{{$i}}]"
                                                                                           min="1" {{$discount_card->status != 'not_started' ? 'disabled' : ''}}
                                                                                           class="form-control @error('service_specific_number.'.$i) is-invalid @enderror"
                                                                                           value="{{ old('service_specific_number',$services[$i]->get_offer($discount_card->id) ? $services[$i]->get_offer($discount_card->id)->specific_number : '') }}"
                                                                                           placeholder="{{__('words.specific_number')}}">
                                                                                    @error('service_specific_number.'.$i)
                                                                                    <span class="invalid-feedback"
                                                                                          role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <select {{$discount_card->status != 'not_started' ? 'disabled' : ''}}
                                                                                            name="service_discount_type[{{$i}}]"
                                                                                            class="form-control @error('service_discount_type') is-invalid @enderror">
                                                                                        <option value="" selected>{{__('words.choose')}}</option>
                                                                                        <option value="percentage"
                                                                                            {{old('service_discount_type',$services[$i]->get_offer($discount_card->id) != null ? $services[$i]->get_offer($discount_card->id)->discount_type : '') == "percentage"  ? "selected" : ""}}
                                                                                        >{{__('words.percentage')}}</option>

                                                                                        <option value="amount"
                                                                                            {{old('service_discount_type',$services[$i]->get_offer($discount_card->id) != null ? $services[$i]->get_offer($discount_card->id)->discount_type : '') == "amount"  ? "selected" : ""}}
                                                                                        >{{__('words.amount')}}</option>
                                                                                    </select>
                                                                                    @error('service_discount_type.'.$i)
                                                                                    <span class="invalid-feedback d-block"
                                                                                          role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="number"
                                                                                           name="service_discount_value[{{$i}}]"
                                                                                           step="0.01"
                                                                                           min="0"  {{$discount_card->status != 'not_started' ? 'disabled' : ''}}
                                                                                           class="form-control @error('service_discount_value.'.$i) is-invalid @enderror"
                                                                                           value="{{ old('service_discount_value',$services[$i]->get_offer($discount_card->id) ? $services[$i]->get_offer($discount_card->id)->discount_value : '')}}"
                                                                                           placeholder="{{__('words.discount_value')}}">
                                                                                    @error('service_discount_value.'.$i)
                                                                                    <span class="invalid-feedback"
                                                                                          role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" {{$discount_card->status != 'not_started' ? 'disabled' : ''}}
                                                                                    name="service_notes[{{$i}}]"
                                                                                           min="1"
                                                                                           class="form-control @error('service_notes.'.$i) is-invalid @enderror"
                                                                                           value="{{ old('service_notes',$services[$i]->get_offer($discount_card->id) ? $services[$i]->get_offer($discount_card->id)->notes : '') }}"
                                                                                           placeholder="{{__('words.notes')}}">
                                                                                    @error('service_notes.'.$i)
                                                                                    <span class="invalid-feedback"
                                                                                          role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endfor
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                        <!-- /.card -->
                                                    </div>
                                                </div>
                                            @endif

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
