@extends('dashboard.layout.auth')
@section('title') @lang('auth.login_title') @endsection
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-4 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <div class="p-1">
                                            <img src="{{url(App\Models\Setting::where('key', 'logo_image')->first() ? App\Models\Setting::where('key', 'logo_image')->first()->value : url("assets/images/logo.png"))}}"
                                                 alt="branding logo" width="55" style="border-radius: 5px">
                                        </div>
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                        <span>@lang('auth.login_header')</span>
                                    </h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form-horizontal form-simple" id="loginform"
                                              action="{{ route('admin.post_login') }}?return_url={{Request::get('return_url')}}"
                                              method="post" novalidate>
                                            {{ csrf_field() }}
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul style="margin-bottom: 0">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            @if(isset($status) && $status == 'success'))
                                            <div class="alert alert-success">
                                                <ul style="margin-bottom: 0">
                                                    <li>{{ $message }}</li>
                                                </ul>
                                            </div>
                                            @endif
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="email" class="form-control form-control-lg input-lg"
                                                       id="email" name="email" placeholder="Your Email"
                                                       required>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control form-control-lg input-lg"
                                                       id="user-password" name="password"
                                                       placeholder="Enter Password" required>
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>
                                            </fieldset>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-12 text-center text-md-left">
                                                    <fieldset>
                                                        <input type="checkbox" id="remember-me" name="remember_me"
                                                               class="chk-remember">
                                                        <label for="remember-me"> @lang('auth.remember_me')</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-6 col-12 text-center text-md-right">
                                                    <a href="{{ route('admin.get_forgot') }}"
                                                       class="card-link">@lang('auth.forgot_password_button')</a>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-info btn-lg btn-block"><i
                                                    class="ft-unlock"></i> @lang('auth.login_button')
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
