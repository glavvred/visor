@extends ('voyager::master')

<head>
    <title>Просмотр и выгрузка отчётов</title>
    <link href="https://unpkg.com/bootstrap-table@1.18.1/dist/bootstrap-table.min.css" rel="stylesheet">

    {{--   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"> --}}

    <link rel="stylesheet" href="https://visor.fancydraft.design/custom.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.3.2/jquery-migrate.min.js"
            integrity="sha512-3fMsI1vtU2e/tVxZORSEeuMhXnT9By80xlmXlsOku7hNwZSHJjwcOBpmy+uu+fyWwGCLkMvdVbHkeoXdAzBv+w=="
            crossorigin="anonymous"></script>
    {{--	<script src="https://visor.fancydraft.design/custom.js"></script> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
          integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>--}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
            integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
            crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.1/dist/bootstrap-table.min.js"></script>
    <script
        src="https://unpkg.com/bootstrap-table@1.18.1/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
    <script src="https://rawgit.com/eternicode/bootstrap-datepicker/master/js/bootstrap-datepicker.js"></script>
    {{-- <script src="https://visor.fancydraft.design/bootstrap-table-ru-RU.js"</script> --}}
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.1/dist/extensions/export/bootstrap-table-export.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css">
    <script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>
    <script src="https://visor.fancydraft.design/xcal.js"></script>
</head>


@section('content')
    <style>body {
            font-family: monospace !important;
        }</style>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive">
                    <button id="chartrefresh" class="btn btn-lg btn-primary clearfix">Перестроить графики</button>
                    <table id="table"
                           data-filter-control="true"
                           data-show-search-clear-button="true"
                           data-pagination-pre-text="Предыдущая"
                           data-pagination-next-text="Следующая"
                           data-pagination="true"
                           data-side-pagination="server"
                           data-id-field="id"
                           data-page-list="[50, 100, 100]"
                           data-show-footer="true"
                           data-total-field="count"
                           data-data-field="items"
                           data-show-export="true"
                           data-export-data-type="all"
                           data-export-types="['excel']"
                           data-query-params="queryParams"
                           data-page-size="50">
                        <thead>
                        <tr>
                            <th id="theme" data-id="theme" data-field="tema_v_otcete" data-filter-control="select" data-filter-data="url:https://visor.fancydraft.design/admin/json_themes_list">Тема в отчёте</th>
                            <th data-field="subjekt"  data-filter-control="select" data-filter-data="url:https://visor.fancydraft.design/admin/json_subjects_list"></th>
                            <th data-field="date_with_time" >
                                <label for="startdate">От</label>
                                <input id="startdate" onClick="xCal(this, {delim: '/', fn: 'selectStart'})" onKeyUp="xCal()" style="width: 80px;"><br/>
                                <label for="enddate">До</label>
                                <input id="enddate" onClick="xCal(this, {delim: '/', fn: 'selectEnd'})" onKeyUp="xCal()" style="width: 80px;">
                            </th>
                            <th data-field="istocnik" data-filter-control="select"  data-filter-data="url:https://visor.fancydraft.design/admin/json_sources_list">Источник</th>
                            <th data-field="url_post" data-formatter="linkFormat">Url пост</th>
                            <th data-field="url_kommentarii" data-formatter="linkFormat">Url комментарий</th>
                            <th data-field="avtor" data-filter-control="select"  data-filter-data="url:https://visor.fancydraft.design/admin/json_authors_list">Автор</th>
                            <th data-field="kolicestvo_podpiscikov" data-sortable="true" data-width="100">Подписчики</th>
                            <th data-field="gorod" data-filter-control="select">Город</th>
                            <th data-field="raion" data-filter-control="select">Район</th>
                            <th data-field="ocenka_krai" data-filter-control="select">Оценка край</th>
                            <th data-field="ocenka_glava" data-filter-control="select">Оценка главы</th>
                            <th data-field="krai_glava" data-filter-control="select">Край-глава</th>
                            <th data-field="vovlechennost" data-sortable="true">Вовлеченность</th>
                            <th data-field="kommentarii" data-sortable="true">Комментарии</th>
                            <th data-field="laiki" data-sortable="true">Лайки</th>
                            <th data-field="reposti" data-sortable="true">Репосты</th>
                            <th data-field="prosmotri" data-sortable="true">Просмотры</th>
                            <th data-field="ssilka_na_profil" data-formatter="linkFormat">Ссылка на профиль</th>
                        </tr>
                        </thead>
                    </table>
                    <div id="chart" class="col-sm-12 col-lg-4" style="height: 400px;"></div>
                    <div id="chart2" class="col-sm-12 col-lg-8" style="height: 400px;"></div>
                    <div id="chart3" class="col-sm-12 col-lg-6" style="height: 400px;"></div>
                    <div id="chart4" class="col-sm-12 col-lg-6" style="height: 400px;"></div>
                    <script src="https://unpkg.com/echarts/dist/echarts.js"></script>
                    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
                    <script>
                        const chart = new Chartisan({
                            el: '#chart',
                            url: "@chart('sample_chart')",
                            hooks: new ChartisanHooks()
                                .tooltip(false)
                                .axis(false)
                                .datasets([
                                    {
                                        top: '0%',
                                        left: '40%',
                                        bottom: '5%',
                                        type: 'pie',
                                        roseType: 'angle',
                                        center: ['25%', '50%'],
                                        radius: ['20%', '50%'],
                                        avoidLabelOverlap: false,
                                        labelLine: {length: '5'},
                                    }
                                ]),

                        });
                        const chart2 = new Chartisan({
                            el: '#chart2',
                            url: "@chart('region_chart')",
                            hooks: new ChartisanHooks()
                                .axis(true)
                                .datasets([
                                    {
                                        type: 'bar',
                                        smooth: true,
                                        bottom: '35%',
                                        lineStyle: {width: 3},
                                        symbolSize: 3,
                                        animationEasing: 'cubicInOut',
                                        barWidth: '40',
                                        barCategoryGap: '0',
                                        avoidLabelOverlap: false,
                                    },
                                ])
                                .options({
                                    xAxis: {
                                        display: false,
                                        axisLine: {show: false},
                                        axisTick: {show: false},
                                        axisPointer: {type: 'none'},
                                    },
                                    yAxis: {
                                        display: false,
                                        axisLine: {show: false},
                                        axisTick: {show: false},
                                        splitLine: {lineStyle: {type: 'dashed'}},
                                    },
                                }),
                        });
                        const chart3 = new Chartisan({
                            el: '#chart3',
                            url: "@chart('positive')",
                            hooks: new ChartisanHooks()
                                .legend({bottom: 0})
                                .tooltip()
                                .datasets([
                                    {
                                        type: 'pie',
                                        smooth: true,
                                        bottom: '10%',
                                        lineStyle: {width: 5},
                                        symbolSize: 4,
                                        animationEasing: 'cubicInOut',
                                        barWidth: '40',
                                        barCategoryGap: '40',
                                    },
                                    'bar',
                                ])
                                .options({
                                    yAxis: {
                                        axisLine: {show: false},
                                        axisTick: {show: false},
                                        splitLine: {lineStyle: {type: 'dashed'}},
                                    },
                                    xAxis: {
                                        axisLine: {show: false},
                                        axisTick: {show: false},
                                        axisPointer: {type: 'none'},
                                    },
                                }),
                        });
                        const chart4 = new Chartisan({
                            el: '#chart4',
                            url: "@chart('sources')",
                            hooks: new ChartisanHooks()
                                .title({
                                    textAlign: 'center',
                                    left: '50%',
                                    text: 'Источники',
                                    subtext: '',
                                })
                                .tooltip()
                                .legend({bottom: 0})
                                .colors()
                                .datasets([
                                    {
                                        type: 'pie',
                                        smooth: true,
                                        bottom: '5%',
                                        lineStyle: {width: 5},
                                        symbolSize: 4,
                                        animationEasing: 'cubicInOut',
                                        barWidth: '40',
                                        barCategoryGap: '40',
                                    },
                                    'bar',
                                ])
                                .options({
                                    yAxis: {
                                        axisLine: {show: false},
                                        axisTick: {show: false},
                                        splitLine: {lineStyle: {type: 'dashed'}},
                                    },
                                    xAxis: {
                                        axisLine: {show: false},
                                        axisTick: {show: false},
                                        axisPointer: {type: 'none'},
                                    },
                                }),
                        });
                    </script>

                    <script>
                        function dateFormat(value, row, index) {
                            // console.log(value);
                            return moment(value, 'YYYY-MM-DD HH:MM:SS').format('DD/MM/YYYY HH:MM');
                        }

                        function linkFormat(value, row, index) {
                            if (value != null) {
                                return '<a href="' + value + '">Ссылка</a>';
                            }
                            return '';
                        }

                        var $table = $('#table');

                        $(function () {

                            $table.bootstrapTable({
                                url: 'https://visor.fancydraft.design/admin/json_search',
                                paginationParts: ['pageInfo', 'pageList'],
                                onColumnSearch: function (data, status, jqXHR) {
                                    console.log(data, status);
                                }
                            })
                        });

                        function queryParams(params) {
                            var options = $table.bootstrapTable('getOptions');
                            if (!options.pagination) {
                                params.limit = options.totalRows
                            }
                            return params
                        }

                        function getTableFilters() {
                            var opts = $table.bootstrapTable('getOptions');
                            var chartParams = '';
                            if (opts.valuesFilterControl) {
                                if (opts.valuesFilterControl.length) {
                                    opts.valuesFilterControl.forEach(o => {
                                        if (o.value) {
                                            chartParams += o.field + '=' + encodeURI(o.value) + '&';
                                        }
                                    })
                                }
                            }
                            console.log(chartParams);
                            chartParams = chartParams.slice(0, -1) + ($('#startdate').val() ? '&startdate=' + encodeURI($('#startdate').val()) : '') + ($('#enddate').val() ? '&enddate=' + encodeURI($('#enddate').val()) : '');
                            return chartParams;
                        }

                        function chartRefresh() {
                            // var $table = $('#table');
                            // console.log($table);
                            console.log(JSON.stringify($table.bootstrapTable('getOptions')));
                            chart.update(JSON.stringify($table.bootstrapTable('getData')))
                        }

                        function selectStart(date) {
                            if (date) {
                                var queryString = getTableFilters();
                                var endDate = $('#enddate').val();
                                $table.bootstrapTable('refreshOptions', {
                                    url: 'https://visor.fancydraft.design/admin/json_search?' + queryString
                                })
                                $('#startdate').val(date);
                                $('#enddate').val(endDate);
                            }                            
                        }

                        function selectEnd(date) {
                            if (date) {
                                var queryString = getTableFilters();
                                var startDate = $('#startdate').val();
                                $table.bootstrapTable('refreshOptions', {
                                    url: 'https://visor.fancydraft.design/admin/json_search?' + queryString
                                })
                                $('#enddate').val(date);
                                $('#startdate').val(startDate);
                            }                             
                        }

                        var $button = $('#chartrefresh')

                        $(function () {
                            $button.click(function () {
                                var queryString = getTableFilters();
                                chart.update({url: '@chart('sample_chart')' + ((queryString) ? '/?' + queryString : '')});
                                chart2.update({url: '@chart('region_chart')' + ((queryString) ? '/?' + queryString : '')});
                                chart3.update({url: '@chart('positive')' + ((queryString) ? '/?' + queryString : '')});
                                chart4.update({url: '@chart('sources')' + ((queryString) ? '/?' + queryString : '')});
                            })
                        })


                    </script>

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
