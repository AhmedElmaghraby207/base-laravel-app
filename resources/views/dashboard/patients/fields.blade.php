<div class="form-body">
    <div class="row">
        <div class="col-md-8">
            {{--First name & Last name--}}
            <div class="row">
                {{--First Name--}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label-control" for="first_name">@lang('patient.first_name')</label>
                        <input type="text" id="first_name" class="form-control"
                               placeholder="@lang('patient.first_name')" name="first_name"
                               value="{{ old('first_name', isset($patient) ? $patient->first_name : '')}}">
                        @if ($errors->has('first_name'))
                            <div class="error" style="color: red">
                                <i class="fa fa-sm fa-times-circle"></i>
                                {{ $errors->first('first_name') }}
                            </div>
                        @endif
                    </div>
                </div>
                {{--Last Name--}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label-control" for="last_name">@lang('patient.last_name')</label>
                        <input type="text" id="last_name" class="form-control"
                               placeholder="@lang('patient.last_name')" name="last_name"
                               value="{{ old('last_name', isset($patient) ? $patient->last_name : '')}}">
                        @if ($errors->has('last_name'))
                            <div class="error" style="color: red">
                                <i class="fa fa-sm fa-times-circle"></i>
                                {{ $errors->first('last_name') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            {{--Email--}}
            <div class="form-group">
                <label class="label-control" for="email">@lang('patient.email')</label>
                <input type="email" id="email" class="form-control"
                       placeholder="@lang('patient.email')" name="email"
                       value="{{ old('email', isset($patient) ? $patient->email : '')}}">
                @if ($errors->has('email'))
                    <div class="error" style="color: red">
                        <i class="fa fa-sm fa-times-circle"></i>
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
            {{--Phone--}}
            <div class="form-group">
                <label class="label-control" for="phone">@lang('patient.phone')</label>
                <input type="text" id="phone" class="form-control"
                       placeholder="@lang('patient.phone')" name="phone"
                       value="{{ old('phone', isset($patient) ? $patient->phone : '')}}">
                @if ($errors->has('phone'))
                    <div class="error" style="color: red">
                        <i class="fa fa-sm fa-times-circle"></i>
                        {{ $errors->first('phone') }}
                    </div>
                @endif
            </div>
            {{--Password & Confirm password--}}
            <div class="row">
                {{--Password--}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label-control" for="password">@lang('patient.password')</label>
                        <input type="password" id="password" class="form-control"
                               placeholder="@lang('patient.password')" name="password">
                        @if ($errors->has('password'))
                            <div class="error" style="color: red">
                                <i class="fa fa-sm fa-times-circle"></i>
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                </div>
                {{--Confirm password--}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label-control"
                               for="password_confirmation">@lang('patient.password_confirm')</label>
                        <input type="password" id="password_confirmation" class="form-control"
                               placeholder="@lang('patient.password_confirm')" name="password_confirmation">
                        @if ($errors->has('password_confirmation'))
                            <div class="error" style="color: red">
                                <i class="fa fa-sm fa-times-circle"></i>
                                {{ $errors->first('password_confirmation') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            {{--Gender--}}
            <div class="form-group">
                <label for="gender">@lang('patient.gender')</label>
                <select id="gender" name="gender" class="select2 form-control">
                    <option value="1"
                            @if(isset($patient) && $patient->gender == 1) selected @endif>@lang('patient.gender_male')</option>
                    <option value="0"
                            @if(isset($patient) && $patient->gender == 0) selected @endif>@lang('patient.gender_female')</option>
                </select>
            </div>
            {{--birth date--}}
            <div class="form-group">
                <label for="birth_date">@lang('patient.birth_date')</label>
                <div class="position-relative has-icon-left">
                    <input type="date" id="birth_date" class="form-control" name="birth_date"
                           value="{{ old('birth_date', isset($patient) ? Carbon\Carbon::parse($patient->birth_date)->format('Y-m-d') : '')}}">
                    <div class="form-control-position">
                        <i class="ft-message-square"></i>
                    </div>
                </div>
            </div>
            {{--Address--}}
            <div class="form-group">
                <label for="address">@lang('patient.address')</label>
                <textarea id="address" rows="5" class="form-control" name="address"
                          placeholder="@lang('patient.address')">{{ old('address', isset($patient) ? $patient->address : '')}}</textarea>
                @if ($errors->has('address'))
                    <div class="error" style="color: red">
                        <i class="fa fa-sm fa-times-circle"></i>
                        {{ $errors->first('address') }}
                    </div>
                @endif
            </div>
        </div>
        {{--Spliter div--}}
        <div class="col-md-1 ml-auto mr-auto">
            <div style="background-color: #e9e9e9; width: 2%; height: 100%; margin: auto">
            </div>
        </div>
        {{--Image--}}
        <div class="col-md-3">
            <div class="text-center mt-5 mb-2">
                <img id="image_preview" style="height: 250px; width: 250px"
                     src="{{isset($patient) && $patient->image ? url($patient->image) : url('/app-assets/images/portrait/medium/avatar-m-4.png')}}"
                     class="rounded-circle" alt="Card image">
            </div>
            <fieldset class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="image"
                           id="image_to_preview">
                    <label class="custom-file-label"
                           for="image">@lang('patient.image')</label>
                </div>
            </fieldset>
        </div>
    </div>
</div>
