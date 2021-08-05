@extends('dashboard.layout.auth')
@section('title') @lang('auth.forgot_password_title') @endsection
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
                                            <img src="{{url(App\Setting::where('key', 'logo_image')->first()->value)}}"
                                                 width="55" style="border-radius: 5px"
                                                 alt="branding logo">
                                        </div>
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                        <span>@lang('auth.forgot_password_header')</span>
                                    </h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form-horizontal form-simple"
                                              action="{{ route('admin.post_forgot') }}"
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
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="email" class="form-control form-control-lg input-lg"
                                                       id="email" name="email" placeholder="Your Email"
                                                       required>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>
                                            <button type="submit" class="btn btn-info btn-lg btn-block"><i
                                                    class="ft-unlock"></i> @lang('auth.reset_password_button')
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
