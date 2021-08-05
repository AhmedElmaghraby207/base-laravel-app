@extends('dashboard.layout.app')

@section('title') @lang('patient.title_show') @endsection

@section('content_header')
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">@lang('patient.title_show')
            <a class="btn btn-sm btn-warning" href="{{ route('patient.edit', $patient->id) }}">
                <i class='la la-edit'></i> @lang('main.edit_button')
            </a>
        </h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <p>{{ Breadcrumbs::render('patients-show', $patient->id) }}</p>
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content collpase show">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                {{--FirstName--}}
                                <div class="form-group">
                                    <span class="text-primary"><i class="la la-user"></i> @lang('patient.first_name'):&nbsp;&nbsp; </span>
                                    <span>{{isset($patient) && $patient->first_name ? $patient->first_name : '----'}}</span>
                                </div>
                                <hr>
                                {{--LastName--}}
                                <div class="form-group">
                                    <span class="text-primary"><i class="la la-user"></i> @lang('patient.last_name'):&nbsp;&nbsp; </span>
                                    <span>{{isset($patient) && $patient->last_name ? $patient->last_name : '----'}}</span>
                                </div>
                                <hr>
                                {{--email--}}
                                <div class="form-group">
                                    <span class="text-primary"><i class="la la-envelope"></i> @lang('patient.email'):&nbsp;&nbsp; </span>
                                    <span>{{isset($patient) && $patient->email ? $patient->email : '----'}}</span>
                                    @if($patient->email_verified_at)
                                        <span class="badge badge-success"> @lang('main.verified')</span>
                                    @else
                                        <span class="badge badge-warning"> @lang('main.not_verified')</span>
                                    @endif
                                </div>
                                <hr>
                                {{--phone--}}
                                <div class="form-group">
                                    <span class="text-primary"><i class="la la-phone"></i> @lang('patient.phone'):&nbsp;&nbsp; </span>
                                    <span>{{isset($patient) && $patient->phone ? $patient->phone : '----'}}</span>
                                    @if($patient->phone_verified_at)
                                        <span class="badge badge-success"> @lang('main.verified')</span>
                                    @else
                                        <span class="badge badge-warning"> @lang('main.not_verified')</span>
                                    @endif
                                </div>
                                <hr>
                                {{--status--}}
{{--                                <div class="form-group">--}}
{{--                                    <span class="text-primary"><i class="fa fa-shield-alt"></i> @lang('patient.status'):&nbsp;&nbsp; </span>--}}
{{--                                    <span>{{isset($patient) && $patient->is_active == 1 ? trans('patient.active') : '----'}}</span>--}}
{{--                                </div>--}}
{{--                                <hr>--}}
                                {{--birth_date--}}
                                <div class="form-group">
                                    <span class="text-primary"><i class="fa fa-id-badge"></i> @lang('patient.birth_date'):&nbsp;&nbsp; </span>
                                    <span>{{isset($patient) && $patient->birth_date ? $patient->birth_date : '----'}}</span>
                                </div>
                                <hr>
                                {{--gender--}}
                                <div class="form-group">
                                    <span class="text-primary"><i class="fa fa-venus-mars"></i> @lang('patient.gender'):&nbsp;&nbsp; </span>
                                    <span>{{isset($patient) && $patient->gender == 1 ? trans('patient.gender_male') : trans('patient.gender_female')}}</span>
                                </div>
                                <hr>
                                {{--address--}}
                                <div class="form-group">
                                    <span class="text-primary"><i class="fa fa-map-marked-alt"></i> @lang('patient.address'):&nbsp;&nbsp; </span>
                                    <span>{{isset($patient) && $patient->address ? $patient->address : '----'}}</span>
                                </div>
                            </div>

                            {{--Spliter div--}}
                            <div class="col-md-1 ml-auto mr-auto">
                                <div style="background-color: #e9e9e9; width: 2%; height: 100%; margin: auto">
                                </div>
                            </div>
                            {{--Image--}}
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="mb-1">
                                        <img id="image" style="height: 250px; width: 250px"
                                             src="{{isset($patient) && $patient->image ? url($patient->image) : url('/app-assets/images/portrait/medium/avatar-m-4.png')}}"
                                             class="rounded-circle" alt="@lang('patient.image')">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
