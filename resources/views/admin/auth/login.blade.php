<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title',__('words.admin_dashboard'))</title>
    <link rel="icon" href="{{ URL::asset('logo.png') }}" type="image/x-icon" sizes="32x32"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@if(App::isLocale('ar'))
    <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('dashboard/plugins/fontawesome-free/css/allAr.min.css')}}">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{asset('dashboard/plugins/icheck-bootstrap/icheck-bootstrapAr.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('dashboard/dist/css/adminlteAr.css')}}">
        <link rel="stylesheet" href="{{asset('dashboard/custom/styleAr.css')}}">
        <style>
            body {
                font-family: 'Cairo', sans-serif;
            }
        </style>
@else
    <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('dashboard/plugins/fontawesome-free/css/all.min.css')}}">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{asset('dashboard/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('dashboard/dist/css/adminlte.min.css')}}">
        <link rel="stylesheet" href="{{asset('dashboard/custom/style.css')}}">
    @endif
    @yield('styles')
    @yield('head')
</head>

<body dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}" class="hold-transition login-page">
<div class="wrapper">

    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-danger">
            <div class="card-header text-center">
                <img src="{{asset('mowater.png')}}" class="mowater" alt="Mowater Logo">
            </div>
            @include('admin.includes.alerts.success')
            @include('admin.includes.alerts.errors')
            <div class="card-body">
                <p class="login-box-msg">{{__('words.admin_sig_in')}}</p>
                <form action="{{route('authenticate')}}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{__('words.email')}}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{__('words.password')}}">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-6">
                            <button type="submit" class="btn btn-danger btn-block">{{__('words.sign_in')}}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>


    <!-- jQuery -->
    <script src="{{asset('dashboard/plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery -->
    <script src="{{asset('dashboard/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dashboard/dist/js/adminlte.min.js')}}"></script>
</div>
</body>
</html>

