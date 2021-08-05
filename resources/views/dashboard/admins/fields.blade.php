<div class="form-body">
    <div class="row">
        <div class="col-md-8">
            {{--Name--}}
            <div class="form-group row">
                <label class="col-md-2 label-control" for="name">@lang('admin.name')</label>
                <div class="col-md-10">
                    <input type="text" id="name" class="form-control"
                           placeholder="@lang('admin.name')" name="name"
                           value="{{ old('name', isset($admin) ? $admin->name : '')}}">
                    @if ($errors->has('name'))
                        <div class="error" style="color: red">
                            <i class="fa fa-sm fa-times-circle"></i>
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
            </div>
            {{--Email--}}
            <div class="form-group row">
                <label class="col-md-2 label-control"
                       for="email">@lang('admin.email')</label>
                <div class="col-md-10">
                    <input type="email" id="email" class="form-control"
                           placeholder="@lang('admin.email')" name="email"
                           value="{{ old('email', isset($admin) ? $admin->email : '')}}">
                    @if ($errors->has('email'))
                        <div class="error" style="color: red">
                            <i class="fa fa-sm fa-times-circle"></i>
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
            </div>
            {{--Password--}}
            <div class="form-group row">
                <label class="col-md-2 label-control"
                       for="password">@lang('admin.password')</label>
                <div class="col-md-10">
                    <input type="password" id="password" class="form-control"
                           placeholder="@lang('admin.password')"
                           name="password">
                    @if ($errors->has('password'))
                        <div class="error" style="color: red">
                            <i class="fa fa-sm fa-times-circle"></i>
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
            </div>
            {{--Confirm password--}}
            <div class="form-group row">
                <label class="col-md-2 label-control"
                       for="password_confirmation">@lang('admin.password_confirm')</label>
                <div class="col-md-10">
                    <input type="password" id="password_confirmation" class="form-control"
                           placeholder="@lang('admin.password_confirm')"
                           name="password_confirmation">
                    @if ($errors->has('password_confirmation'))
                        <div class="error" style="color: red">
                            <i class="fa fa-sm fa-times-circle"></i>
                            {{ $errors->first('password_confirmation') }}
                        </div>
                    @endif
                </div>
            </div>
            {{--roles--}}
            <div class="form-group row">
                <label class="col-md-2 label-control" for="roles">@lang('admin.roles')</label>
                <div class="col-md-10">
                    <select id="roles" name="roles[]" class="select2 form-control"
                            multiple="multiple">
                        @foreach($roles as $role)
                            <option
                                value="{{$role->id}}"
                                @if(isset($adminRoles) && count($adminRoles) > 0)
                                @foreach($adminRoles as $a_r)
                                @if($a_r->id == $role->id) selected @endif
                                @endforeach
                                @endif
                            >{{$role->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('roles'))
                        <div class="error" style="color: red">
                            <i class="fa fa-sm fa-times-circle"></i>
                            {{ $errors->first('roles') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{--Spliter div--}}
        <div class="col-md-1 ml-auto mr-auto">
            <div style="background-color: #e9e9e9; width: 2%; height: 90%; margin: auto">
            </div>
        </div>
        {{--Image--}}
        <div class="col-md-3">
            <div class="text-center mb-2">
                <img id="image_preview" style="height: 160px; width: 160px"
                     src="{{isset($admin) && $admin->image ? url($admin->image) : url('/app-assets/images/portrait/medium/avatar-m-4.png')}}"
                     class="rounded-circle" alt="Card image">
            </div>
            <fieldset class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="image"
                           id="image_to_preview">
                    <label class="custom-file-label"
                           for="image">@lang('admin.image')</label>
                </div>
            </fieldset>
        </div>
    </div>
</div>
