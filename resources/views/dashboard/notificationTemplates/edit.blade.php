@extends('dashboard.layout.app')

@section('title') @lang('notification_template.title_edit') @endsection

@section('content_header')
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">@lang('notification_template.title_edit')</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <p>{{ Breadcrumbs::render('notification_template-edit', $notification_template->id) }}</p>
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
                        <form class="form form-horizontal" method="POST" id="update_form"
                              action="{{ route('notification_template.update', $notification_template->id) }}" enctype="multipart/form-data">
                            @csrf
                            @include('dashboard.notificationTemplates.fields')
                            <div class="form-actions right">
                                <a href="{{route('notification_template.index')}}" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> @lang('main.cancel_button')
                                </a>
                                <button type="submit" class="btn btn-primary" style="height: 40px" id="update_btn">
                                    <i class="la la-check-square-o"></i> @lang('main.save_button')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
