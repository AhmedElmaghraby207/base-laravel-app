@extends('dashboard.layout.app')

@section('title') @lang('patient.title_list') @endsection

@section('content_header')
    <div class="content-header-left col-md-6 col-12">
        <h3 class="content-header-title">@lang('patient.title_list')</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <p>{{ Breadcrumbs::render('patients') }}</p>
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
                            <form method="get" id="form_patients_search">
                                <div class="row">

                                    {{--First Name search field--}}
                                    <div class="col-lg-4 col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label for="first_name">@lang('patient.first_name')</label>
                                            <input type="text" id="first_name" name="first_name"
                                                   class="form-control font-size-small"
                                                   placeholder="@lang('patient.first_name')">
                                        </div>
                                    </div>
                                    {{--Last Name search field--}}
                                    <div class="col-lg-4 col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label for="last_name">@lang('patient.last_name')</label>
                                            <input type="text" id="last_name" name="last_name"
                                                   class="form-control font-size-small"
                                                   placeholder="@lang('patient.last_name')">
                                        </div>
                                    </div>
                                    {{--Email search field--}}
                                    <div class="col-lg-4 col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label for="email">@lang('patient.email')</label>
                                            <input type="email" id="email" name="email"
                                                   class="form-control font-size-small"
                                                   placeholder="@lang('patient.email')">
                                        </div>
                                    </div>
                                    {{--Status search field--}}
                                    <div class="col-lg-4 col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label for="status">@lang('patient.status')</label>
                                            <select id="status" name="status" class="select2 form-control">
                                                <option value="">@lang('patient.all')</option>
                                                <option value="1">@lang('patient.active')</option>
                                                <option value="0">@lang('patient.inactive')</option>
                                            </select>
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
                        @if(session()->get('user_admin')->can('patient-create'))
                            <a class="btn add-btn btn-sm btn-success" href="{{ route('patient.create') }}">
                                <i class="fa fa-plus"></i> @lang('main.add_button')
                            </a>
                        @endif
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload" id="reload_data_btn"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="mb-1 pt-0">
                            <table class="table table-striped table-bordered file-export" id="patientsTable"
                                   style="width: 100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('patient.image')</th>
                                    <th>@lang('patient.first_name')</th>
                                    <th>@lang('patient.last_name')</th>
                                    <th>@lang('patient.email')</th>
{{--                                    <th>@lang('patient.status')</th>--}}
                                    @if(session()->get('user_admin')->can('patient-edit') || session()->get('user_admin')->can('patient-delete'))
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

        let first_name_field = $('#first_name');
        let last_name_field = $('#last_name');
        let email_field = $('#email');
        let status_field = $('#status');
        let form_patients_search = $('#form_patients_search');
        let clear_button = $('#clear_button');
        let reload_data_btn = $('#reload_data_btn');

        $(document).ready(function () {

            // Draw table after Filter
            form_patients_search.on('submit', function (e) {
                e.preventDefault();
                patientsDatatable();
            });

            // Draw table after click reload btn
            reload_data_btn.click(patientsDatatable);

            // Draw table after Clear
            clear_button.on('click', function (e) {
                first_name_field.val("");
                last_name_field.val("");
                email_field.val("");
                status_field.prop('selectedIndex', 0);
                status_field.select2();
                form_patients_search.submit();
                check_inputs();
            });

            first_name_field.add(last_name_field).add(email_field).add(status_field).bind("keyup change", function () {
                check_inputs();
            });

            check_inputs();
            patientsDatatable();
        });

        function patientsDatatable() {
            $('#patientsTable').DataTable({
                "bDestroy": true,
                processing: true,
                serverSide: true,
                searching: false,
                "order": [[0, "asc"]],
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                sPaginationType: "full_numbers",
                "bStateSave": true,
                "fnStateSave": function (oSettings, oData) {
                    localStorage.setItem('patientsDataTables', JSON.stringify(oData));
                },
                "fnStateLoad": function (oSettings) {
                    return JSON.parse(localStorage.getItem('patientsDataTables'));
                },
                @if(App::isLocale('ar'))
                language: dataTablesArabicLocalization,
                @endif
                ajax: {
                    url: "{{ route('patient.list') }}",
                    method: 'POST',
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (d) {
                        //for search
                        d.first_name = first_name_field.val();
                        d.last_name = last_name_field.val();
                        d.email = email_field.val();
                        d.status = status_field.val();
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
                        data: 'image', name: 'image',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                '<a href="{{url('/dashboard/patient')}}' + '/' + oData.id + '/show' + ' ">' +
                                '<img style="width: 36px; height: 36px" src="' + oData.image + '" data-id="' + oData.id + '" class="img-fluid img-thumbnail">' +
                                '</a>'
                            );
                        }
                    },
                    {
                        data: 'first_name', name: 'first_name',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                '<a href="{{url('/dashboard/patient')}}' + '/' + oData.id + '/show' + ' ">' + oData.first_name + '</a>'
                            );
                        }
                    },
                    {
                        data: 'last_name', name: 'last_name',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if (oData.last_name) {
                                $(nTd).html(
                                    '<a href="{{url('/dashboard/patient')}}' + '/' + oData.id + '/show' + ' ">' + oData.last_name + '</a>'
                                );
                            } else {
                                $(nTd).html('----');
                            }
                        }
                    },
                    {
                        data: 'email', name: 'email',
                        "searchable": true,
                        "sortable": true,
                    },
                    {{--{--}}
                    {{--    data: 'is_active', name: 'is_active',--}}
                    {{--    "searchable": true,--}}
                    {{--    "sortable": true,--}}
                    {{--    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {--}}
                    {{--        if (oData.is_active == 1) {--}}
                    {{--            $(nTd).html(--}}
                    {{--                '<span class="text-success"><i class="fa fa-user-check"></i> @lang('patient.active')</span>'--}}
                    {{--            );--}}
                    {{--        } else if (oData.is_active == 0) {--}}
                    {{--            $(nTd).html(--}}
                    {{--                '<span class="text-warning"><i class="fa fa-user-times"></i> @lang('patient.inactive')</span>'--}}
                    {{--            );--}}
                    {{--        }--}}
                    {{--    }--}}
                    {{--},--}}
                        @if(session()->get('user_admin')->can('patient-edit') || session()->get('user_admin')->can('patient-delete'))
                    {
                        "data": "id",
                        "searchable": false,
                        "sortable": false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html('')
                            @if(session()->get('user_admin')->can('patient-edit'))
                            {{--if (oData.is_active == 1) {--}}
                            {{--    $(nTd).append(--}}
                            {{--        "<a href='javascript:' url='{{url('/dashboard/patient/')}}/" + oData.id + "/deactivate' class='btn btn-warning btn-sm' " +--}}
                            {{--        "title='@lang('patient.deactivate')' onclick='deactivate(" + oData.id + ")' id='deactivate_" + oData.id + "' style='margin-top:5px'>" +--}}
                            {{--        "<i class='fa fa-user-times'></i>" +--}}
                            {{--        "</a> "--}}
                            {{--    );--}}
                            {{--} else if (oData.is_active == 0) {--}}
                            {{--    $(nTd).append(--}}
                            {{--        "<a href='javascript:' url='{{url('/dashboard/patient/')}}/" + oData.id + "/activate' class='btn btn-success btn-sm' " +--}}
                            {{--        "title='@lang('patient.activate')' onclick='activate(" + oData.id + ")' id='activate_" + oData.id + "' style='margin-top:5px'>" +--}}
                            {{--        "<i class='fa fa-user-check'></i>" +--}}
                            {{--        "</a> "--}}
                            {{--    );--}}
                            {{--}--}}
                            $(nTd).append(
                                "<a href='{{url('/dashboard/patient/')}}/" + oData.id + "/edit' class='btn btn-warning btn-sm' title='@lang('main.edit_button')' style='margin-top:5px'><i class='fa fa-edit'></i></a> "
                            );
                            @endif
                            @if(session()->get('user_admin')->can('patient-delete'))
                            $(nTd).append(
                                "<a href='javascript:' url='{{url('/dashboard/patient/')}}/" + oData.id + "/delete' onclick='destroy(" + oData.id + ")' id='delete_" + oData.id + "' " +
                                "class='btn btn-danger btn-sm' title='@lang('main.delete_button')' style='margin-top:5px'><i class='fa fa-trash-alt'></i></a>"
                            );
                            @endif
                        }
                    }
                    @endif
                ]
            });
        }

        function check_inputs() {
            if (first_name_field.val().length > 0 || last_name_field.val().length > 0 || email_field.val().length > 0 || status_field.val().length > 0) {
                clear_button.attr('hidden', false)
            } else {
                clear_button.attr('hidden', true)
            }
        }

        function activate(id) {
            swal({
                title: "@lang('main.confirm_activate_question')",
                text: "@lang('main.confirm_activate_message')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#f2af4e",
                confirmButtonText: "@lang('main.button_activate_yes')",
                cancelButtonText: "@lang('main.button_activate_no')",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: 'GET',
                        url: $('#activate_' + id).attr('url'),
                        data: {},
                        success: function (response) {
                            if (response.status === 'success') {
                                swal("@lang('main.activate_success_title')", "@lang('main.activate_success_content')", "success");
                                patientsDatatable();
                            } else if (response.status === 'fail') {
                                swal("@lang('main.activate_fail_title')", "@lang('main.activate_fail_content')", "error");
                            }
                        },
                        error: function (xhr, status, error) {
                            alert('Sorry, Server error happened!');
                            console.log(error);
                        }
                    });
                } else {
                    swal.close();
                }
            });
        }

        function deactivate(id) {
            swal({
                title: "@lang('main.confirm_deactivate_question')",
                text: "@lang('main.confirm_deactivate_message')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#f2af4e",
                confirmButtonText: "@lang('main.button_deactivate_yes')",
                cancelButtonText: "@lang('main.button_deactivate_no')",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: 'GET',
                        url: $('#deactivate_' + id).attr('url'),
                        data: {},
                        success: function (response) {
                            if (response.status === 'success') {
                                swal("@lang('main.deactivate_success_title')", "@lang('main.deactivate_success_content')", "success");
                                patientsDatatable();
                            } else if (response.status === 'fail') {
                                swal("@lang('main.deactivate_fail_title')", "@lang('main.deactivate_fail_content')", "error");
                            }
                        },
                        error: function (xhr, status, error) {
                            alert('Sorry, Server error happened!');
                            console.log(error);
                        }
                    });
                } else {
                    swal.close();
                }
            });
        }

        function destroy(id) {
            swal({
                title: "@lang('main.confirm_delete_question')",
                text: "@lang('main.confirm_delete_message')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#f2af4e",
                confirmButtonText: "@lang('main.button_delete_yes')",
                cancelButtonText: "@lang('main.button_delete_no')",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: 'GET',
                        url: $('#delete_' + id).attr('url'),
                        data: {},
                        success: function (response) {
                            if (response.status === 'success') {
                                swal("@lang('main.delete_success_title')", "@lang('main.delete_success_content')", "success");
                                patientsDatatable();
                            } else if (response.status === 'fail') {
                                swal("@lang('main.delete_fail_title')", "@lang('main.delete_fail_content')", "error");
                            }
                        },
                        error: function (xhr, status, error) {
                            alert('Sorry, Server error happened!');
                            console.log(error);
                        }
                    });
                } else {
                    swal.close();
                }
            });
        }
    </script>

@endsection
