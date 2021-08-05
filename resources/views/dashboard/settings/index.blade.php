@extends('dashboard.layout.app')

@section('title') @lang('setting.title_list') @endsection

@section('content_header')
    <div class="content-header-left col-md-6 col-12">
        <h3 class="content-header-title">@lang('setting.title_list')</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <p>{{ Breadcrumbs::render('settings') }}</p>
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css"
          href="{{url('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection

@section('content')
    <section id="search">
        <div class="row">
            <div class="col-12">
                <div class="card" style="margin-bottom: 15px">
                    <div class="card-header">
                        <h4 class="card-title">@lang('main.title_search')</h4>
                        <a class="heading-elements-toggle"><i
                                class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard" style="padding: 0 1.5rem;">
                            <form method="get" id="form_settings_search">
                                <div class="row">

                                    {{--Key search field--}}
                                    <div class="col-lg-4 col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label for="key">@lang('setting.key')</label>
                                            <input type="text" id="key" name="key"
                                                   class="form-control font-size-small"
                                                   placeholder="@lang('setting.key')">
                                        </div>
                                    </div>
                                    {{--Value search field--}}
                                    <div class="col-lg-4 col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label for="value">@lang('setting.value')</label>
                                            <input type="text" id="value" name="value"
                                                   class="form-control font-size-small"
                                                   placeholder="@lang('setting.value')">
                                        </div>
                                    </div>
                                    {{--Filter & clrear buttons--}}
                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group" style="margin-top: 35px">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fa fa-filter"></i> @lang('main.filter_button')
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" id="clear_button" hidden>
                                            <i class="fa fa-times"></i> @lang('main.clear_button')
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="data">
        <div class="row">
            <div class="col-12">
                <div class="card mb-0">
                    <div class="card-header">
                        <h4 class="card-title display-inline">@lang('main.title_data')</h4>&ensp;&ensp;&ensp;
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload" id="reload_data_btn"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard pt-0">
                            <table class="table table-striped table-bordered file-export" id="settingsTable"
                                   style="width: 100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('setting.key')</th>
                                    <th>@lang('setting.value')</th>
                                    <th>@lang('setting.description')</th>
                                    @if(session()->get('user_admin')->can('setting-edit'))
                                        <th>@lang('main.table_actions')</th>
                                    @endif
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{url('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js')}}"
            type="text/javascript"></script>
    <script src="{{url('/app-assets/js/scripts/tables/datatables/datatable-advanced.js')}}"
            type="text/javascript"></script>

    <script>

        let key_field = $('#key');
        let value_field = $('#value');
        let form_settings_search = $('#form_settings_search');
        let clear_button = $('#clear_button');
        let reload_data_btn = $('#reload_data_btn');

        $(document).ready(function () {

            // Draw table after Filter
            form_settings_search.on('submit', function (e) {
                e.preventDefault();
                SettingsDatatable();
            });

            // Draw table after click reload btn
            reload_data_btn.click(SettingsDatatable);

            // Draw table after Clear
            clear_button.on('click', function (e) {
                key_field.val("");
                value_field.val("");
                form_settings_search.submit();
                check_inputs();
            });

            key_field.add(value_field).bind("keyup change", function () {
                check_inputs();
            });

            check_inputs();
            SettingsDatatable();
        });

        function SettingsDatatable() {
            $('#settingsTable').DataTable({
                "bDestroy": true,
                processing: true,
                serverSide: true,
                searching: false,
                "order": [[0, "asc"]],
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                sPaginationType: "full_numbers",
                "bStateSave": true,
                "fnStateSave": function (oSettings, oData) {
                    localStorage.setItem('settingsDataTables', JSON.stringify(oData));
                },
                "fnStateLoad": function (oSettings) {
                    return JSON.parse(localStorage.getItem('settingsDataTables'));
                },
                @if(App::isLocale('ar'))
                language: dataTablesArabicLocalization,
                @endif
                ajax: {
                    url: "{{ route('setting.list') }}",
                    method: 'POST',
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (d) {
                        //for search
                        d.key = key_field.val();
                        d.value = value_field.val();
                    }
                },
                type: 'GET',
                columns: [
                    {
                        data: 'id', name: 'id',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(oData.id);
                        }
                    },
                    {
                        data: 'key', name: 'key',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(oData.key);
                        }
                    },
                    {
                        data: 'value', name: 'value',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if (oData.type === 'text') {
                                $(nTd).html(oData.value);
                            } else if (oData.type === 'file') {
                                $(nTd).html('<a href="{{url('')}}/' + oData.value + '" target="_blank">{{url('')}}/' + oData.value + '</a>');
                            } else {
                                $(nTd).html('----');
                            }
                        }
                    },
                    {
                        data: 'description', name: 'description',
                        "searchable": true,
                        "sortable": true,
                    },
                        @if(session()->get('user_admin')->can('setting-edit'))
                    {
                        "data": "id",
                        "searchable": false,
                        "sortable": false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                "<a href='{{url('/dashboard/setting/')}}/" + oData.id + "/edit' class='btn btn-warning btn-sm' title='@lang('main.edit_button')'><i class='fa fa-edit'></i></a>"
                            );
                        }
                    }
                    @endif
                ]
            });
        }

        function check_inputs() {
            if (key_field.val().length > 0 || value_field.val().length > 0) {
                clear_button.attr('hidden', false)
            } else {
                clear_button.attr('hidden', true)
            }
        }

    </script>

@endsection
