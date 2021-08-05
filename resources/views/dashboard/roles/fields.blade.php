<div class="form-body">
    {{--Name--}}
    <div class="form-group">
        <label class="label-control" for="name">@lang('role.name')</label>
        <input type="text" id="name" class="form-control"
               placeholder="@lang('role.name')" name="name"
               value="{{ old('name', isset($role) ? $role->name : '')}}">
        @if ($errors->has('name'))
            <div class="error" style="color: red">
                <i class="fa fa-sm fa-times-circle"></i>
                {{ $errors->first('name') }}
            </div>
        @endif
    </div>
    <div class="form-group row">
        @foreach($permissions as $permission)
            <div class="col-md-3">
                <fieldset>
                    <input type="checkbox" name="permissions[]" value="{{$permission->id}}"
                           id="permission_{{$permission->id}}"
                           @if(isset($rolePermissions) && count($rolePermissions) > 0)
                           @foreach($rolePermissions as $r_p)
                           @if($r_p == $permission->id) checked @endif
                        @endforeach
                        @endif
                    >
                    <label for="permission_{{$permission->id}}">{{$permission->name}}</label>
                </fieldset>
            </div>
        @endforeach
        @if ($errors->has('permissions'))
            <div class="error" style="color: red; margin: 0 15px">
                <i class="fa fa-sm fa-times-circle"></i>
                {{ $errors->first('permissions') }}
            </div>
        @endif
    </div>
</div>
