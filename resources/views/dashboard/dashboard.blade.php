@extends('dashboard.layout.app')

@section('title') Home @endsection

@section('styles')
{{--    @if(App::isLocale('en'))--}}
{{--        <link rel="stylesheet" type="text/css" href="{{url('/app-assets/css/pages/dashboard-ecommerce.css')}}">--}}
{{--    @elseif(App::isLocale('ar'))--}}
{{--        <link rel="stylesheet" type="text/css" href="{{url('/app-assets/css-rtl/pages/dashboard-ecommerce.css')}}">--}}
{{--    @endif--}}

    <link rel="stylesheet" type="text/css" href="{{url('/app-assets/vendors/css/charts/chartist.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{url('/app-assets/vendors/css/charts/chartist-plugin-tooltip.css')}}">
@endsection

@section('content_header')@endsection

@section('content')
    <!-- statistics -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h2 class="success">{{$patients_count}}</h2>
                                <h6>@lang('patient.title_list')</h6>
                            </div>
                            <div>
                                <i class="fa fa-4x fa-user-tie success"></i>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <a href="{{ route('patient.index') }}" target="_blank"
                               class="btn btn-sm btn-success">@lang('dashboard.show_all_btn')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h2 class="success">{{$patients_count}}</h2>
                                <h6>@lang('patient.title_list')</h6>
                            </div>
                            <div>
                                <i class="fa fa-map-marker-alt fa-4x info"></i>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <a href="{{ route('patient.index') }}" target="_blank"
                               class="btn btn-sm btn-success">@lang('dashboard.show_all_btn')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h2 class="success">{{$patients_count}}</h2>
                                <h6>@lang('patient.title_list')</h6>
                            </div>
                            <div>
                                <i class="fa fa-envelope fa-4x warning"></i>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <a href="{{ route('patient.index') }}" target="_blank"
                               class="btn btn-sm btn-success">@lang('dashboard.show_all_btn')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h2 class="success">{{$patients_count}}</h2>
                                <h6>@lang('patient.title_list')</h6>
                            </div>
                            <div>
                                <i class="fa fa-question fa-4x danger"></i>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <a href="{{ route('patient.index') }}" target="_blank"
                               class="btn btn-sm btn-success">@lang('dashboard.show_all_btn')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row match-height">
        <div class="col-xl-8 col-12" id="ecommerceChartView">
            <div class="card card-shadow">
                <div class="card-header card-header-transparent py-20">
                    <div class="btn-group dropdown">
                        <h5>@lang('dashboard.patients_chart')</h5>
                    </div>
                    <ul class="nav nav-pills nav-pills-rounded chart-action float-right btn-group"
                        role="group">
                        <li class="nav-item"><a class="active nav-link" data-toggle="tab"
                                                href="#scoreLineToDay">@lang('dashboard.chart_day')</a></li>
                        {{--<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#scoreLineToWeek">Week</a>--}}
                        {{--</li>--}}
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#scoreLineToMonth">@lang('dashboard.chart_month')</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#scoreLineToYear">@lang('dashboard.chart_year')</a>
                        </li>
                    </ul>
                </div>
                <div class="widget-content tab-content bg-white p-20">
                    <div class="ct-chart tab-pane active scoreLineShadow" id="scoreLineToDay"></div>
{{--                    <div class="ct-chart tab-pane scoreLineShadow" id="scoreLineToWeek"></div>--}}
                    <div class="ct-chart tab-pane scoreLineShadow" id="scoreLineToMonth"></div>
                    <div class="ct-chart tab-pane scoreLineShadow" id="scoreLineToYear"></div>
                </div>
            </div>
        </div>

        {{-- latest patients table --}}
        <div class="col-xl-4 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('dashboard.new_patients')</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content">
                    <div id="new-orders" class="media-list position-relative">
                        <div class="table-responsive">
                            <table id="new-orders-table" class="table table-hover table-xl mb-0">
                                <thead>
                                <tr>
                                    <th class="border-top-0">@lang('patient.first_name')</th>
                                    <th class="border-top-0">@lang('patient.email')</th>
                                    <th class="border-top-0">@lang('dashboard.show_item_btn')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($latest_patients as $patient)
                                    <tr>
                                        <td class="text-truncate">{{$patient->first_name}}</td>
                                        <td class="text-truncate">{{$patient->email}}</td>
                                        <td class="text-truncate">
                                            <a href="{{ route('patient.show', $patient->id) }}" target="_blank"
                                               class="btn btn-sm btn-success">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('/app-assets/vendors/js/charts/chartist.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/app-assets/vendors/js/charts/chartist-plugin-tooltip.min.js')}}"
            type="text/javascript"></script>

    <script>
        /*************************************************
         *               Score Chart                      *
         *************************************************/
        (function () {
            var scoreChart = function scoreChart(id, labelList, series1List) {
                var scoreChart = new Chartist.Line('#' + id, {
                    labels: labelList,
                    series: [series1List]
                }, {
                    lineSmooth: Chartist.Interpolation.simple({
                        divisor: 2
                    }),
                    fullWidth: true,
                    chartPadding: {
                        right: 25
                    },
                    series: {
                        "series-1": {
                            showArea: false
                        }
                    },
                    axisX: {
                        showGrid: false,
                    },
                    axisY: {
                        labelInterpolationFnc: function labelInterpolationFnc(value) {
                            return value / 1;
                        },
                        scaleMinSpace: 50,
                    },
                    plugins: [Chartist.plugins.tooltip()],
                    low: 0,
                    showPoint: false,
                    height: 300
                });

                scoreChart.on('created', function (data) {
                    var defs = data.svg.querySelector('defs') || data.svg.elem('defs');
                    var width = data.svg.width();
                    var height = data.svg.height();

                    var filter = defs.elem('filter', {
                        x: 0,
                        y: "-10%",
                        id: 'shadow' + id
                    }, '', true);

                    filter.elem('feGaussianBlur', {
                        in: "SourceAlpha",
                        stdDeviation: "24",
                        result: 'offsetBlur'
                    });
                    filter.elem('feOffset', {
                        dx: "0",
                        dy: "32"
                    });

                    filter.elem('feBlend', {
                        in: "SourceGraphic",
                        mode: "multiply"
                    });

                    defs.elem('linearGradient', {
                        id: id + '-gradient',
                        x1: 0,
                        y1: 0,
                        x2: 1,
                        y2: 0
                    }).elem('stop', {
                        offset: 0,
                        'stop-color': 'rgba(22, 141, 238, 1)'
                    }).parent().elem('stop', {
                        offset: 1,
                        'stop-color': 'rgba(98, 188, 246, 1)'
                    });

                    return defs;
                }).on('draw', function (data) {
                    if (data.type === 'line') {
                        data.element.attr({
                            filter: 'url(#shadow' + id + ')'
                        });
                    } else if (data.type === 'point') {

                        var parent = new Chartist.Svg(data.element._node.parentNode);
                        parent.elem('line', {
                            x1: data.x,
                            y1: data.y,
                            x2: data.x + 0.01,
                            y2: data.y,
                            "class": 'ct-point-content'
                        });
                    }
                    if (data.type === 'line' || data.type === 'area') {
                        data.element.animate({
                            d: {
                                begin: 1000 * data.index,
                                dur: 1000,
                                from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                                to: data.path.clone().stringify(),
                                easing: Chartist.Svg.Easing.easeOutQuint
                            }
                        });
                    }
                });
            };

            //patients per day
            var DayLabelList = [];
            var DayData = [];
            @foreach($patients_per_day as $day_arr)
            DayLabelList.push('{{Carbon\Carbon::parse($day_arr->day)->format('d - M')}}')
            DayData.push('{{$day_arr->patients}}')
            @endforeach
            var DaySeries1List = {
                name: "series-1",
                data: DayData
            };

            //patients per week
            {{--var WeekLabelList = [];--}}
            {{--var WeekData = [];--}}
            {{--@foreach($patients_per_week as $week_arr)--}}
            {{--WeekLabelList.push('{{Carbon\Carbon::parse($week_arr->week)->format('d - M')}}')--}}
            {{--WeekData.push('{{$week_arr->patients}}')--}}
            {{--@endforeach--}}
            {{--var WeekSeries1List = {--}}
            {{--    name: "series-1",--}}
            {{--    data: WeekData--}}
            {{--};--}}

            //patients per month
            var MonthLabelList = [];
            var MonthData = [];
            @foreach($patients_per_month as $month_arr)
            MonthLabelList.push('{{date("F", mktime(0, 0, 0, $month_arr->month, 1))}}')
            MonthData.push('{{$month_arr->patients}}')
            @endforeach
            var MonthSeries1List = {
                name: "series-1",
                data: MonthData
            };

            //patients per year
            var YearLabelList = [];
            var YearData = [];
            @foreach($patients_per_year as $year_arr)
            YearLabelList.push('{{$year_arr->year}}')
            YearData.push('{{$year_arr->patients}}')
            @endforeach
            var YearSeries1List = {
                name: "series-1",
                data: YearData
            };


            var createChart = function createChart(button) {
                var btn = button || $("#ecommerceChartView .chart-action").find(".active");

                var chartId = btn.attr("href");
                switch (chartId) {
                    case "#scoreLineToDay":
                        scoreChart("scoreLineToDay", DayLabelList, DaySeries1List);
                        break;
                    // case "#scoreLineToWeek":
                    //     scoreChart("scoreLineToWeek", WeekLabelList, WeekSeries1List);
                    //     break;
                    case "#scoreLineToMonth":
                        scoreChart("scoreLineToMonth", MonthLabelList, MonthSeries1List);
                        break;
                    case "#scoreLineToYear":
                        scoreChart("scoreLineToYear", YearLabelList, YearSeries1List);
                        break;
                }
            };

            createChart();
            $(".chart-action li a").on("click", function () {
                createChart($(this));
            });
        })();
    </script>
@endsection
