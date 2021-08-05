@extends('dashboard.layout.app')

@section('title')
    @if(session()->get('user_admin')->id == $admin->id)
        @lang('admin.title_profile')
    @else
        @lang('admin.title_show')
    @endif
@endsection

@section('content_header')
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">
            @if(session()->get('user_admin')->id == $admin->id)
                @lang('admin.title_profile')
            @else
                @lang('admin.title_show')
            @endif
            <a class="btn btn-sm btn-warning" href="{{ route('admin.edit', $admin->id) }}">
                <i class='la la-edit'></i> @lang('main.edit_button')
            </a>
        </h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <p>{{ Breadcrumbs::render('admins-show', $admin->id) }}</p>
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
                                {{--Name--}}
                                <div class="form-group">
                                    <span class="text-primary"><i class="la la-user-shield"></i> @lang('admin.name'):&nbsp;&nbsp; </span>
                                    <span>{{isset($admin) && $admin->name ? $admin->name : '----'}}</span>
                                </div>
                                <hr>
                                {{--email--}}
                                <div class="form-group">
                                    <span class="text-primary"><i class="la la-envelope"></i> @lang('admin.email'):&nbsp;&nbsp; </span>
                                    <span>{{isset($admin) && $admin->email ? $admin->email : '----'}}</span>
                                    @if($admin->email_verified_at)
                                        <span class="badge badge-success"> @lang('main.verified')</span>
                                    @else
                                        <span class="badge badge-warning"> @lang('main.not_verified')</span>
                                    @endif
                                </div>
                                <hr>
                                {{--roles--}}
                                <div class="form-group">
                                    <span class="text-primary"><i class="la la-envelope"></i> @lang('admin.roles'):&nbsp;&nbsp; </span>
                                    @foreach($admin->roles as $role)
                                        <span class="badge badge-success">{{$role->name}}</span>
                                    @endforeach
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
                                             src="{{isset($admin) && $admin->image ? url($admin->image) : url('/app-assets/images/portrait/medium/avatar-m-4.png')}}"
                                             class="rounded-circle" alt="@lang('admin.image')">
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
