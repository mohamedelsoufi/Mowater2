@extends('admin.layouts.standard')
@section('title', __('words.edit_special_number'))
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
                                    href="{{route('special-numbers.index')}}">{{__('words.show_special_numbers')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{__('words.edit_special_number')}}</li>
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
                                <h3 class="card-title">{{__('words.edit_special_number')}}</h3>
                            </div>
                            <form method="post" action="{{route('special-numbers.update',$special_number->id)}}"
                                  autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{$special_number->id}}">
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.number')}}</label>
                                                <input type="text" name="number" id="number"
                                                       class="form-control @error('number') is-invalid @enderror"
                                                       value="{{$special_number->number}}"
                                                       placeholder="{{__('words.number')}}">

                                                @error('number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.size')}}</label>
                                                <select name="size"
                                                        class="form-control @error('size') is-invalid @enderror">
                                                    <option
                                                        value="normal_plate" {{$special_number->getRawOriginal('size') == 'normal_plate' ? 'selected' : ''}}>{{__('words.normal_plate')}}</option>
                                                    <option
                                                        value="special_plate" {{$special_number->getRawOriginal('size') == 'special_plate' ? 'selected' : ''}}>{{__('words.special_plate')}}</option>
                                                </select>
                                                @error('size')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>{{__('words.price')}}</label>
                                                <input type="number" step="0.02" min="0" name="price" id="price"
                                                       class="form-control @error('price') is-invalid @enderror"
                                                       value="{{$special_number->price}}"
                                                       placeholder="{{__('words.price')}}">
                                                @error('price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.discount_type')}}</label>
                                                <select name="discount_type"
                                                        class="form-control @error('discount_type') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    <option
                                                        value="amount" {{$special_number->discount_type === 'amount' ? 'selected' : '' }}>{{__('words.amount')}}</option>
                                                    <option
                                                        value="percentage" {{$special_number->discount_type === 'percentage' ? 'selected' : '' }}>{{__('words.percentage')}}</option>
                                                </select>
                                                @error('discount_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.discount_value')}}</label>
                                                <input type="number" step="0.02" min="0" name="discount" id="discount"
                                                       class="form-control @error('discount') is-invalid @enderror"
                                                       value="{{$special_number->discount}}"
                                                       placeholder="{{__('words.discount_value')}}">
                                                @error('discount')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>{{__('words.Include_insurance')}}</label>
                                                <select name="Include_insurance" id="Include_insurance"
                                                        class="form-control @error('Include_insurance') is-invalid @enderror">
                                                    <option
                                                        value="0" {{$special_number->Include_insurance == 0 ? 'selected' : ''}}>{{__('vehicle.no')}}</option>
                                                    <option
                                                        value="1" {{$special_number->Include_insurance == 1 ? 'selected' : ''}}>{{__('vehicle.yes')}}</option>
                                                </select>
                                                @error('Include_insurance')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.price_include_transfer')}}</label>
                                                <select name="price_include_transfer" id="price_include_transfer"
                                                        class="form-control @error('price_include_transfer') is-invalid @enderror">
                                                    <option
                                                        value="0" {{$special_number->price_include_transfer == 0 ? 'selected' : ''}}>{{__('vehicle.no')}}</option>
                                                    <option
                                                        value="1" {{$special_number->price_include_transfer == 1 ? 'selected' : ''}}>{{__('vehicle.yes')}}</option>
                                                </select>
                                                @error('price_include_transfer')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.transfer_type')}}</label>
                                                <select name="transfer_type" id="transfer_type"
                                                        class="form-control @error('transfer_type') is-invalid @enderror">
                                                    <option
                                                        value="waiver" {{$special_number->transfer_type == 'waiver' ? 'selected' : ''}}>{{__('words.waiver')}}</option>
                                                    <option
                                                        value="own" {{$special_number->transfer_type == 'own' ? 'selected' : ''}}>{{__('words.own')}}</option>
                                                </select>
                                                @error('transfer_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('words.user')}}</label>
                                                <input type="text" name="user_id" id="user_id" disabled
                                                       value="{{$special_number->user_id != null ? $special_number->user->first_name .' '. $special_number->user->last_name : ''}}"
                                                       class="form-control bg-muted">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{__('words.special_numbers_organization')}}</label>
                                                <select name="special_number_organization_id"
                                                        id="special_number_organization_id"
                                                        class="form-control @error('special_number_organization_id') is-invalid @enderror">
                                                    <option value="">{{__('words.choose')}}</option>
                                                    @foreach($special_number_organizations as $special_number_organization)
                                                        <option
                                                            value="{{$special_number_organization->id}}">{{$special_number_organization->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('special_number_organization_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>{{__('words.main_category')}}</label>
                                                <select name="category_id"
                                                        class="form-control category_id @error('category_id') is-invalid @enderror">
                                                    @foreach($categories as $key=>$value)
                                                        <option
                                                            value="{{$value->id}}" {{$special_number->category_id == $value->id ? 'selected' : ''}}>{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.special_numbers_category')}}</label>
                                                <select name="sub_category_id"
                                                        class="form-control sub_category_id @error('sub_category_id ') is-invalid @enderror">
                                                    @foreach($sub_categories as $key=>$value)
                                                        <option
                                                            value="{{$value->id}}" {{$special_number->sub_category_id == $value->id ? 'selected' : ''}}>{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('sub_category_id ')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{__('words.is_special')}}</label>
                                                <select name="is_special" id="is_special"
                                                        class="form-control @error('is_special') is-invalid @enderror">
                                                    <option
                                                        value="0" {{$special_number->is_special == 0 ? 'selected' : ''}}>{{__('vehicle.no')}}</option>
                                                    <option
                                                        value="1" {{$special_number->is_special == 1 ? 'selected' : ''}}>{{__('vehicle.yes')}}</option>
                                                </select>
                                                @error('is_special')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>{{__('words.number_of_views')}}</label>
                                                <input type="text"
                                                       class="form-control" value="{{$special_number->number_of_views}}"
                                                       disabled>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active_number_of_views"
                                                           {{$special_number->active_number_of_views == 1 ? 'checked' : ''}} value="0"
                                                           type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.active_number_of_views')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="availability"
                                                           {{$special_number->availability == 1 ? 'checked' : ''}} value="0"
                                                           type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.available_prop')}}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="active"
                                                           {{$special_number->active == 1 ? 'checked' : ''}} value="0"
                                                           type="checkbox">
                                                    <label class="form-check-label">
                                                        {{__('words.activity')}}
                                                    </label>
                                                </div>
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

@section('scripts')
    <script>
        $('.category_id').on('change', function () {
            sub_categories($(this).val());
        });
        function sub_categories(id) {
            let url = "{{route('get-sub-categories' , ':id')}}"
            url = url.replace(':id', id);

            $.ajax({
                type: "Get",
                url: url,
                datatype: 'JSON',
                success: function (data) {
                    if (data.status == true) {
                        $('.sub_category_id').empty();
                        data.data.sub_categories.forEach(function (sub_category) {
                            var option = `<option value ="${sub_category.id}">${sub_category.name}</option>`;
                            $('.sub_category_id').append(option);
                        });
                    }
                },
                error: function (reject) {
                    alert("{{__('message.something_wrong')}}");
                }
            });
        }
    </script>
@endsection
