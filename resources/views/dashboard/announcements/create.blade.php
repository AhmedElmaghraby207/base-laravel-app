@extends('dashboard.layout.app')

@section('title') @lang('announcement.title_create') @endsection

@section('content_header')
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">@lang('announcement.title_create')</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <p>{{ Breadcrumbs::render('announcements-create') }}</p>
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
                        <form class="form form-horizontal" method="POST" id="add_form"
                              action="{{ route('announcement.send') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{--select patients--}}
                                        <fieldset class="mb-1">
                                            <input type="checkbox" name="specify_patients" id="specify_patients"
                                                   value="{{ old('subject', 'true')}}">
                                            <label for="specify_patients">@lang('announcement.specify_patients')</label>
                                            @if ($errors->has('patients'))
                                                <div class="error" style="color: red">
                                                    <i class="fa fa-sm fa-times-circle"></i>
                                                    {{ $errors->first('patients') }}
                                                </div>
                                            @endif
                                        </fieldset>
                                        {{--Patients--}}
                                        <div class="form-group" id="patients_div">
                                            <label for="patients">@lang('announcement.patients')</label>
                                            <select id="patients" name="patients[]" class="select2 form-control"
                                                    multiple="multiple">
                                                @foreach($patients as $patient)
                                                    <option
                                                        value="{{$patient->id}}">{{$patient->first_name}} {{$patient->last_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{--Subject_en--}}
                                        <div class="form-group">
                                            <label for="subject_en">@lang('announcement.subject_en')</label>
                                            <input type="text" id="subject_en" class="form-control"
                                                   placeholder="@lang('announcement.subject_en')" name="subject_en"
                                                   value="{{ old('subject_en')}}"
                                            >
                                            @if ($errors->has('subject_en'))
                                                <div class="error" style="color: red">
                                                    <i class="fa fa-sm fa-times-circle"></i>
                                                    {{ $errors->first('subject_en') }}
                                                </div>
                                            @endif
                                        </div>
                                        {{--Subject_ar--}}
                                        <div class="form-group">
                                            <label for="subject_ar">@lang('announcement.subject_ar')</label>
                                            <input type="text" id="subject_ar" class="form-control"
                                                   placeholder="@lang('announcement.subject_ar')" name="subject_ar"
                                                   value="{{ old('subject_ar')}}"
                                            >
                                            @if ($errors->has('subject_ar'))
                                                <div class="error" style="color: red">
                                                    <i class="fa fa-sm fa-times-circle"></i>
                                                    {{ $errors->first('subject_ar') }}
                                                </div>
                                            @endif
                                        </div>
                                        {{--message_en--}}
                                        <div class="form-group">
                                            <label for="message_en">@lang('announcement.message_en')</label>
                                            <textarea id="message_en" rows="5" class="form-control" name="message_en"
                                                      placeholder="@lang('announcement.message_en')">{{ old('message_en')}}</textarea>
                                            @if ($errors->has('message_en'))
                                                <div class="error" style="color: red">
                                                    <i class="fa fa-sm fa-times-circle"></i>
                                                    {{ $errors->first('message_en') }}
                                                </div>
                                            @endif
                                        </div>
                                        {{--message_ar--}}
                                        <div class="form-group">
                                            <label for="message_ar">@lang('announcement.message_ar')</label>
                                            <textarea id="message_ar" rows="5" class="form-control" name="message_ar"
                                                      placeholder="@lang('announcement.message_ar')">{{ old('message_ar')}}</textarea>
                                            @if ($errors->has('message_ar'))
                                                <div class="error" style="color: red">
                                                    <i class="fa fa-sm fa-times-circle"></i>
                                                    {{ $errors->first('message_ar') }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="row skin skin-flat">
                                            {{--mail_checkbox--}}
                                            <div class="col-md-3">
                                                <fieldset>
                                                    <input type="checkbox" name="mail_checkbox" id="mail_checkbox">
                                                    <label
                                                        for="mail_checkbox">@lang('announcement.mail_checkbox')</label>
                                                    @if ($errors->has('mail_checkbox'))
                                                        <div class="error" style="color: red">
                                                            <i class="fa fa-sm fa-times-circle"></i>
                                                            {{ $errors->first('mail_checkbox') }}
                                                        </div>
                                                    @endif
                                                </fieldset>
                                            </div>
                                            {{--notify_checkbox--}}
                                            <div class="col-md-3">
                                                <fieldset>
                                                    <input type="checkbox" name="notify_checkbox" id="notify_checkbox">
                                                    <label
                                                        for="notify_checkbox">@lang('announcement.notify_checkbox')</label>
                                                    @if ($errors->has('notify_checkbox'))
                                                        <div class="error" style="color: red">
                                                            <i class="fa fa-sm fa-times-circle"></i>
                                                            {{ $errors->first('notify_checkbox') }}
                                                        </div>
                                                    @endif
                                                </fieldset>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="form-actions right">
                                <a href="{{url('/dashboard')}}" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> @lang('main.cancel_button')
                                </a>
                                <button type="button" class="btn btn-primary" style="height: 40px" id="add_btn">
                                    <i class="la la-check-square-o"></i> @lang('main.add_button')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            specifyPatients();
        })

        $('#specify_patients').on('change click', specifyPatients);

        function specifyPatients() {
            if ($('#specify_patients:checkbox:checked').length > 0) {
                $('#patients_div').css('display', 'block');
            } else {
                $('#patients_div').css('display', 'none');
            }
        }
    </script>

@endsection
