<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            {{--Key--}}
            <div class="form-group">
                <label for="key">@lang('setting.key')</label>
                <input type="text" id="key" class="form-control"
                       placeholder="@lang('setting.key')" name="key" readonly
                       value="{{ old('key', isset($setting) ? $setting->key : '')}}">
                @if ($errors->has('key'))
                    <div class="error" style="color: red">
                        <i class="fa fa-sm fa-times-circle"></i>
                        {{ $errors->first('key') }}
                    </div>
                @endif
            </div>
            {{--Value--}}
            @if($setting->type == 'text')
            <div class="form-group">
                <label for="value">@lang('setting.value')</label>
                <textarea id="value" rows="3" class="form-control" name="value"
                          placeholder="@lang('setting.value')">{{ old('value', isset($setting) ? $setting->value : '')}}</textarea>
                @if ($errors->has('value'))
                    <div class="error" style="color: red">
                        <i class="fa fa-sm fa-times-circle"></i>
                        {{ $errors->first('value') }}
                    </div>
                @endif
            </div>
            @elseif($setting->type == 'file')
                <fieldset class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="value" id="value">
                        <label class="custom-file-label"
                               for="value">@lang('setting.value')</label>
                    </div>
                    @if ($errors->has('value'))
                        <div class="error" style="color: red">
                            <i class="fa fa-sm fa-times-circle"></i>
                            {{ $errors->first('value') }}
                        </div>
                    @endif
                </fieldset>
            @endif
            {{--Description--}}
            <div class="form-group">
                <label for="description">@lang('setting.description')</label>
                <textarea id="description" rows="5" class="form-control" name="description"
                          placeholder="@lang('setting.description')">{{ old('description', isset($setting) ? $setting->description : '')}}</textarea>
                @if ($errors->has('description'))
                    <div class="error" style="color: red">
                        <i class="fa fa-sm fa-times-circle"></i>
                        {{ $errors->first('description') }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
