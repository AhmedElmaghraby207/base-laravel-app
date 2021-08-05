@extends('dashboard.layout.auth')
@section('title') @lang('auth.reset_password_title') @endsection
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
                                            <img src="{{url('/app-assets/images/logo/logo-dark.png')}}"
                                                 alt="branding logo">
                                        </div>
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                        <span>@lang('auth.reset_password_header')</span>
                                    </h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form-horizontal form-simple" method="post"
                                              action="{{url('patient/password/reset')}}">
                                            @csrf
                                            <input type="hidden" name="token" value="{{$token}}">
                                            @if(session()->has('error') || ($errors!= null && $errors->all() != null))
                                                @include('partials/alert_message', ['type' => 'danger',
                                                'message' => session('error'),
                                                'errors' =>$errors->all()
                                                ])
                                            @endif
                                            @if(session()->has('success'))
                                                @include('partials/alert_message', ['type' => 'success', 'message' => session('success')])
                                                <div class="text-center">
                                                    <img src='{{ url("/assets/images/success.png")}}'
                                                         alt="Success" width="100"
                                                         style="margin-top: 15px"/>
                                                </div>
                                            @endif
                                            @if(!session()->has('success'))
                                                {{--Password field--}}
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="password" class="form-control form-control-lg input-lg"
                                                           id="user-password" name="password"
                                                           placeholder="Enter Password" required>
                                                    <div class="form-control-position">
                                                        <i class="la la-key"></i>
                                                    </div>
                                                </fieldset>
                                                {{--Confirm Password field--}}
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="password" class="form-control form-control-lg input-lg"
                                                           id="confirm-password" name="password_confirmation"
                                                           placeholder="Confirm Password" required>
                                                    <div class="form-control-position">
                                                        <i class="la la-key"></i>
                                                    </div>
                                                </fieldset>
                                                {{--Reset password field--}}
                                                <button type="submit" class="btn btn-info btn-lg btn-block"><i
                                                        class="ft-unlock"></i> @lang('auth.reset_submit_button')
                                                </button>
                                            @endif
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
