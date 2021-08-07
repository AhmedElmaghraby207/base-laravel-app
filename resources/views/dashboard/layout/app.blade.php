<!DOCTYPE html>
<html class="loading" lang="en"
      data-textdirection="@if(App::isLocale('en')) ltr @elseif(App::isLocale('ar')) rtl @endif">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') </title>

    <link rel="apple-touch-icon" href="{{App\Models\Setting::where('key', 'icon_image')->first() ? url(App\Models\Setting::where('key', 'icon_image')->first()->value) : url("assets/images/logo.png")}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{App\Models\Setting::where('key', 'icon_image')->first() ? url(App\Models\Setting::where('key', 'icon_image')->first()->value) : url("assets/images/logo.png")}}">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700">
    <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="{{url('/app-assets/fonts/simple-line-icons/style.css')}}">
    <link rel='stylesheet' type='text/css' href='{{url('/app-assets/css/fontawesome.min.css')}}'>
    <link rel="stylesheet" type="text/css" href='{{url("/app-assets/css/sweetalert/sweetalert.css")}}'>
    <link rel="stylesheet" type="text/css" href='{{url("/app-assets/vendors/css/extensions/toastr.css")}}'>
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/vendors/css/forms/selects/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/app-assets/css/plugins/forms/checkboxes-radios.css') }}">

    @if(App::isLocale('en'))
        <link rel="stylesheet" type="text/css" href="{{url('/app-assets/css/vendors.css')}}">
        <link rel="stylesheet" type="text/css" href="{{url('/app-assets/css/app.css')}}">
        <link rel="stylesheet" type="text/css"
              href="{{url('/app-assets/css/core/menu/menu-types/vertical-menu-modern.css')}}">
        <link rel="stylesheet" type="text/css" href="{{url('/app-assets/css/core/colors/palette-gradient.css')}}">
        <link rel="stylesheet" type="text/css" href="{{url('/assets/css/style.css')}}">
    @elseif(App::isLocale('ar'))
        <link rel="stylesheet" type="text/css" href="{{url('/app-assets/css-rtl/vendors.css')}}">
        <link rel="stylesheet" type="text/css" href="{{url('/app-assets/css-rtl/app.css')}}">
        <link rel="stylesheet" type="text/css" href="{{url('/app-assets/css-rtl/custom-rtl.css')}}">
        <link rel="stylesheet" type="text/css"
              href="{{url('/app-assets/css-rtl/core/menu/menu-types/vertical-menu-modern.css')}}">
        <link rel="stylesheet" type="text/css" href="{{url('/app-assets/css-rtl/core/colors/palette-gradient.css')}}">
        <link rel="stylesheet" type="text/css" href="{{url('/assets/css/style-rtl.css')}}">
    @endif

    @include('dashboard.partials.styles.other-styles')
    @yield('styles')
</head>

<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click"
      data-menu="vertical-menu-modern"
      data-col="2-columns">
<!-- fixed-top -->
<nav
    class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a
                        class="nav-link nav-menu-main menu-toggle hidden-xs"
                        href="#"><i class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="{{route('home')}}">
                        <img class="brand-logo" alt="modern admin logo" style="border-radius: 50%"
                             src="{{App\Models\Setting::where('key', 'logo_image')->first() ? url(App\Models\Setting::where('key', 'logo_image')->first()->value) : url("assets/images/logo.png")}}">
                        <h3 class="brand-text">{{App\Models\Setting::where('key', 'website_name')->first() ? App\Models\Setting::where('key', 'website_name')->first()->value : "Base App"}}</h3>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block float-right">
                    <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                        <i class="toggle-icon ft-toggle-right font-medium-3 white" data-ticon="ft-toggle-right"></i>
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile">
                        <i class="la la-ellipsis-v"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                </ul>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-language nav-item">
                        <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#"
                           data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            @if(App::isLocale('en'))
                                <i class="flag-icon flag-icon-us"></i>
                                <span class="selected-language"></span>
                            @elseif(App::isLocale('ar'))
                                <i class="flag-icon flag-icon-eg"></i>
                                <span class="selected-language"></span>
                            @endif
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                            <a class="dropdown-item" href="{{route('CHANGE_LANGUAGE','ar')}}"><i
                                    class="flag-icon flag-icon-eg"></i> العربية</a>
                            <a class="dropdown-item" href="{{route('CHANGE_LANGUAGE','en')}}"><i
                                    class="flag-icon flag-icon-us"></i> English</a>
                        </div>
                    </li>
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <span class="mr-1">
                                @lang('admin.hello_text'), <span
                                    class="user-name text-bold-700">{{App\Models\Admin::find(session()->get('user_admin')->id)->name}}</span>
                            </span>
                            <span class="avatar avatar-online">
                                <img src="{{url(App\Models\Admin::find(session()->get('user_admin')->id)->image)}}"
                                     style="height: 37px"
                                     alt="avatar"><i></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('admin.show', session()->get('user_admin')->id) }}">
                                <i class="ft-user"></i> @lang('admin.title_profile')
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}"><i
                                    class="ft-power"></i> @lang('auth.logout_button')</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- sidebar -->
@include('dashboard.layout.sidebar')
<!-- content -->
<div class="app-content content" style="margin-bottom: -12px">
    <div class="content-wrapper" style="padding: 1.5rem">
        <div class="content-header row">
            @yield('content_header')
        </div>
        <div class="content-body">
            @yield('content')
        </div>
    </div>
</div>
<!-- footer -->
<footer class="footer footer-static footer-light navbar-border navbar-shadow">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
      <span class="d-block d-md-inline-block">@lang('dashboard.copyrights_word') {{\Carbon\Carbon::now()->format('Y')}}
          <span class="text-bold-700">{{App\Models\Setting::where('key', 'website_name')->first() ? App\Models\Setting::where('key', 'website_name')->first()->value : "Base App"}}</span>@lang('dashboard.copyrights_text')
      </span>
    </p>
</footer>

<!-- BEGIN VENDOR JS-->
<script src="{{url('/app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="{{url('/app-assets/data/jvector/visitor-data.js')}}" type="text/javascript"></script>
<script src="{{ url('/app-assets/vendors/js/forms/select/select2.full.min.js') }}" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN MODERN JS-->
<script src="{{url('/app-assets/js/core/app-menu.js')}}" type="text/javascript"></script> {{-------}}
<script src="{{url('/app-assets/js/core/app.js')}}" type="text/javascript"></script> {{-------}}
<script src="{{url('/app-assets/js/scripts/customizer.js')}}" type="text/javascript"></script> {{-------}}
<script src="{{url('/app-assets/vendors/js/forms/tags/form-field.js')}}" type="text/javascript"></script>

<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src='{{url("/app-assets/js/scripts/fontawesome.min.js")}}' type='text/javascript'></script>
<script src="{{ url('/app-assets/js/scripts/moment.js')}} "></script>
<script src="{{ url('/app-assets/js/scripts/moment-timezone-with-data.js')}} "></script>
<script src='{{ url("/app-assets/js/scripts/sweetalert/sweetalert.min.js")}}'></script>
<script src='{{ url("/app-assets/js/scripts/sweetalert/jquery.sweet-alert.custom.js")}}'></script>
<script src="{{ url('/app-assets/vendors/js/extensions/toastr.min.js')}}" type="text/javascript"></script>
<script src="{{ url('/app-assets/js/scripts/forms/select/form-select2.js') }}" type="text/javascript"></script>

@include('dashboard.partials.scripts.other-scripts')
@yield('scripts')
<!-- END PAGE LEVEL JS-->
</body>

</html>
