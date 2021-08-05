<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            {{--name--}}
            <div class="form-group">
                <label for="name">@lang('notification_template.name')</label>
                <input type="text" id="name" class="form-control"
                       placeholder="@lang('notification_template.name')" name="name" readonly
                       value="{{ old('name', isset($notification_template) ? $notification_template->name : '')}}">
                @if ($errors->has('name'))
                    <div class="error" style="color: red">
                        <i class="fa fa-sm fa-times-circle"></i>
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            {{--subject_en--}}
            <div class="form-group">
                <label for="subject_en">@lang('notification_template.subject_en')</label>
                <textarea id="subject_en" rows="3" class="form-control" name="subject_en"
                          placeholder="@lang('notification_template.subject_en')">{{ old('subject_en', isset($notification_template) ? $notification_template->subject_en : '')}}</textarea>
                @if ($errors->has('subject_en'))
                    <div class="error" style="color: red">
                        <i class="fa fa-sm fa-times-circle"></i>
                        {{ $errors->first('subject_en') }}
                    </div>
                @endif
            </div>
            {{--subject_ar--}}
            <div class="form-group">
                <label for="subject_ar">@lang('notification_template.subject_ar')</label>
                <textarea id="subject_ar" rows="3" class="form-control" name="subject_ar"
                          placeholder="@lang('notification_template.subject_ar')">{{ old('subject_ar', isset($notification_template) ? $notification_template->subject_ar : '')}}</textarea>
                @if ($errors->has('subject_ar'))
                    <div class="error" style="color: red">
                        <i class="fa fa-sm fa-times-circle"></i>
                        {{ $errors->first('subject_ar') }}
                    </div>
                @endif
            </div>
            {{--template_en--}}
            <div class="form-group">
                <label for="template_en">@lang('notification_template.template_en')</label>
                <textarea id="template_en" rows="5" class="form-control" name="template_en"
                          placeholder="@lang('notification_template.template_en')">{{ old('template_en', isset($notification_template) ? $notification_template->template_en : '')}}</textarea>
                @if ($errors->has('template_en'))
                    <div class="error" style="color: red">
                        <i class="fa fa-sm fa-times-circle"></i>
                        {{ $errors->first('template_en') }}
                    </div>
                @endif
            </div>
            {{--template_ar--}}
            <div class="form-group">
                <label for="template_ar">@lang('notification_template.template_ar')</label>
                <textarea id="template_ar" rows="5" class="form-control" name="template_ar"
                          placeholder="@lang('notification_template.template_ar')">{{ old('template_ar', isset($notification_template) ? $notification_template->template_ar : '')}}</textarea>
                @if ($errors->has('template_ar'))
                    <div class="error" style="color: red">
                        <i class="fa fa-sm fa-times-circle"></i>
                        {{ $errors->first('template_ar') }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
