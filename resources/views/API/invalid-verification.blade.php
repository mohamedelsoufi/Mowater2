<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Mawatery')</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('dashboard/images/favicon.png')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    @if(App::isLocale('ar'))

        <link href="{{asset('/dashboard/css/style-ar.css')}}" rel="stylesheet">
        <link href="{{asset('/dashboard/css/custom-ar.css')}}" rel="stylesheet">
    @else

        <link href="{{asset('/dashboard/css/style.css')}}" rel="stylesheet">
        <link href="{{asset('/dashboard/css/custom.css')}}" rel="stylesheet">
    @endif
    {{--  fontawesome  --}}
    <link href="{{asset('/dashboard/icons/fontawesome-free-5.15.4-web/css/all.css')}}" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Readex+Pro:wght@700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@700&display=swap');
        /* @import url('https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@600&display=swap'); */
        @import url('https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@900&display=swap');

        * {
            /*font-family: 'Readex Pro', sans-serif;*/
            /*font-family: 'IBM Plex Sans Arabic', sans-serif;*/
            font-family: 'Noto Kufi Arabic', sans-serif;
        }
    </style>
</head>

<body dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}">

<!-- Preloader start -->
<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>
<!-- Preloader end -->

<!-- Main wrapper start -->
<div id="main-wrapper">


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="text-right cross"><i class="fa fa-times"></i></div>
                <div class="card-body text-center" style="min-height: 550px;"><img style="max-height: 200px;" src="{{asset('uploads/wrong.jpg')}}">
                    <br>
                    <br>
                    <h4>{{__('words.invalid-verification')}}</h4>
{{--                    <p>{{$error_msg}}</p>--}}
{{--                    <button class="btn btn-out btn-square continue">CONTINUE</button>--}}
                </div>
            </div>

        </div>
    </div>

    <!-- Footer start -->
@include('dashboard.includes.footer')
<!-- Footer end -->
</div>

<!-- Scripts -->
<!-- Required vendors -->
<script src="{{asset('/dashboard/vendor/global/global.min.js')}}"></script>
<script src="{{asset('/dashboard/js/custom.min.js')}}"></script>

<script src="{{asset('/dashboard/js/dashboard/dashboard-1.js')}}"></script>

@yield('scripts');
</body>

</html>
