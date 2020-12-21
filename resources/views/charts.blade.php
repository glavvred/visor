@extends ('voyager::master')

<head>
    <title>Просмотр и выгрузка отчётов</title>
    <link href="https://unpkg.com/bootstrap-table@1.18.1/dist/bootstrap-table.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://visor.fancydraft.design/custom.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.3.2/jquery-migrate.min.js"
            integrity="sha512-3fMsI1vtU2e/tVxZORSEeuMhXnT9By80xlmXlsOku7hNwZSHJjwcOBpmy+uu+fyWwGCLkMvdVbHkeoXdAzBv+w=="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
          integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
            integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
            crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.1/dist/bootstrap-table.min.js"></script>
    <script
        src="https://unpkg.com/bootstrap-table@1.18.1/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
    <script src="https://rawgit.com/eternicode/bootstrap-datepicker/master/js/bootstrap-datepicker.js"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.1/dist/extensions/export/bootstrap-table-export.min.js"></script>

    {{-- <link rel="stylesheet" href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css">
    <script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script> --}}
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
                    <div class="filter-panel" id="filter-panel">
                        <div class="filter-panel__toggle" onClick="togglePanel()">
                            <div class="filter-panel__toggle--inner"></div>
                        </div>
                        <div class="filter-panel__inner">
                            <select name="filter_themes[]" multiple="miltiple" class="filter-item" id="filter-theme"></select>
                            <select name="filter_subjects[]" multiple="miltiple" class="filter-item" id="filter-subject"></select>
                            <select name="filter_sources[]" multiple="miltiple" class="filter-item" id="filter-source"></select>
                            <select name="filter_authors[]" multiple="miltiple" class="filter-item" id="filter-author"></select>
                            <select name="filter_cities[]" multiple="miltiple" class="filter-item" id="filter-city"></select>
                            <select name="filter_regions[]" multiple="miltiple" class="filter-item" id="filter-region"></select>
                            <select name="filter_krai[]" multiple="multiple" class="filter-item" id="filter-krai">
                                <option value="позитив">позитив</option>
                                <option value="негатив">негатив</option>
                                <option value="нейтрально">нейтрально</option>
                            </select>
                            <select name="filter_krai_glava" class="filter-item" id="filter-krai-glava">
                                <option value="">Не выбрано</option>
                                <option value="Край">Край</option>
                                <option value="Глава">Глава</option>
                            </select>
                            <div class="filter-item">
                                <label for="startdate">От</label>
                                <input id="startdate" onClick="xCal(this, {delim: '/'})" onKeyUp="xCal()"><br/>
                                <label for="enddate">До</label>
                                <input id="enddate" onClick="xCal(this, {delim: '/'})" onKeyUp="xCal()">
                            </div>                            
                        </div>
                        <div class="filter-panel__btns">
                            <button class="btn btn-lg btn-primary clearfix" onClick="filterTable()">Обновить таблицу и графики</button>
                        </div>
                    </div>
                    <!-- data-filter-control="true"
                           data-show-search-clear-button="true" -->
                    <table id="table"
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
                                <th id="theme" data-id="theme" data-field="tema_v_otcete" data-filter-control="select" multiple="multiple"  data-filter-data="url:https://visor.fancydraft.design/admin/json_themes_list">
                                    Тема в отчёте
                                </th>
                                <th data-field="subjekt"  data-filter-control="select" data-filter-data="url:https://visor.fancydraft.design/admin/json_subjects_list"></th>
                                <th data-field="date_with_time" data-formatter="dateFormat">Дата</th>
                                <th data-field="istocnik" data-filter-control="select" data-filter-data="url:https://visor.fancydraft.design/admin/json_sources_list">Источник</th>
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
                    <div id="chart" style="width: 500px; height: 500px; float: left;"></div>
                    <div id="chart2" style="width: 1200px; height: 500px; float: left; "></div>
                    <div id="chart3" style="width: 500px; height: 500px; float: left;"></div>
                    <div id="chart4" style="width: 500px; height: 500px; float: left;"></div>
                    <script src="https://unpkg.com/echarts/dist/echarts.js"></script>
                    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
                    <script>
                        const chart = new Chartisan({
                            el: '#chart',
                            url: "@chart('sample_chart')",
                            hooks: new ChartisanHooks()
                                .title({
                                    textAlign: 'center',
                                    left: '50%',
                                    text: 'Темы',
                                    subtext: 'группировка по количеству сообщений',
                                })
                                .legend({bottom: '25%'})
                                .tooltip(false)
                                .colors()
                                .axis(false)
                                .datasets([
                                    {
                                        top: '0%',
                                        left: '40%',
                                        bottom: '35%',
                                        type: 'pie',
                                        roseType: 'angle',
                                        center: ['25%', '50%'],
                                        radius: ['20%', '50%'],
                                        avoidLabelOverlap: false,
                                        labelLine: {length: '14'},
                                    },
                                    {
                                        top: '5%',
                                        bottom: '25%',
                                        type: 'pie',
                                        center: ['75%', '50%'],
                                        radius: ['50%', '100%'],
                                        avoidLabelOverlap: false,
                                    },
                                ]),

                        });
                        const chart2 = new Chartisan({
                            el: '#chart2',
                            url: "@chart('region_chart')",
                            hooks: new ChartisanHooks()
                                .title({
                                    textAlign: 'center',
                                    left: '50%',
                                    text: 'Города',
                                    subtext: '',
                                })
                                .legend({bottom: 0})
                                .tooltip()
                                .colors(['#ECC94B'])
                                .datasets([
                                    {
                                        type: 'bar',
                                        smooth: true,
                                        bottom: '35%',
                                        lineStyle: {width: 5},
                                        symbolSize: 4,
                                        animationEasing: 'cubicInOut',
                                        barWidth: '100',
                                        barCategoryGap: '40',
                                    },
                                ])
                                .options({
                                    type: 'horizontalBar',
                                    xAxis: {
                                        axisLine: {show: false},
                                        axisTick: {show: false},
                                        axisPointer: {type: 'none'},
                                    },
                                    yAxis: {
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
                                .title({
                                    textAlign: 'center',
                                    left: '50%',
                                    text: 'Тональность',
                                    subtext: '',
                                })
                                .legend({bottom: 0})
                                .tooltip()
                                .colors()
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
                            return moment(value, 'YYYY-MM-DD 0:00:00').format('DD/MM/YYYY');
                        }

                        function timeFormat(value, row, index) {
                            return moment(value, '1970-01-01 HH:mm:00').format('HH:mm');
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

                        function togglePanel() {
                            let panel = $('#filter-panel');
                            if (panel.hasClass('collapsed')) {
                                panel.removeClass('collapsed');
                            } else {
                                panel.addClass('collapsed');
                            }
                        }

                        function queryParams(params) {
                            var options = $table.bootstrapTable('getOptions');
                            if (!options.pagination) {
                                params.limit = options.totalRows
                            }
                            return params
                        }

                        function loadFilter(obj, url, str) {
                            obj.select2({
                                placeholder: str,
                                allowClear: true
                            });
                            $.ajax({
                                type: 'GET',
                                url: url
                            }).then(function (data){
                                for (let key in data) {
                                    if (data[key]) {
                                        let newOption = new Option(data[key], key, false, false);
                                        obj.append(newOption);
                                    }
                                }                                
                            })
                        }

                        function getSelectedItems(obj, str) {
                            let items = obj.select2('data');
                            let arr = [];
                            let queryStr = '';
                            if (items.length) {
                                items.forEach(item => {
                                    if (item.text != 'Не выбрано') {
                                        arr.push(item.text);
                                    }
                                })
                                if (arr.length) {
                                    queryStr += '&' + str + '=' + encodeURI(arr.join(','));
                                }                                
                            }
                            return queryStr;
                        }

                        function filterTable() {
                            let allFilters = getSelectedItems($('#filter-theme'), 'tema_v_otcete');
                            allFilters += getSelectedItems($('#filter-subject'), 'subjekt');
                            allFilters += getSelectedItems($('#filter-source'), 'istocnik');
                            allFilters += getSelectedItems($('#filter-author'), 'avtor');
                            allFilters += getSelectedItems($('#filter-city'), 'gorod');
                            allFilters += getSelectedItems($('#filter-region'), 'raion');
                            allFilters += getSelectedItems($('#filter-krai'), 'ocenka_krai');
                            allFilters += getSelectedItems($('#filter-krai-glava'), 'krai_glava');
                            if ($('#startdate').val()) {
                                allFilters += '&startdate=' + $('#startdate').val();
                            }
                            if ($('#enddate').val()) {
                                allFilters += '&enddate=' + $('#enddate').val();
                            }
                            allFilters = allFilters.substring(1);
                            
                            $table.bootstrapTable('refreshOptions', {
                                url: 'https://visor.fancydraft.design/admin/json_search?' + allFilters
                            })
                            chart.update({url: '@chart('sample_chart')' + ((allFilters) ? '/?' + allFilters : '')});
                            chart2.update({url: '@chart('region_chart')' + ((allFilters) ? '/?' + allFilters : '')});
                            chart3.update({url: '@chart('positive')' + ((allFilters) ? '/?' + allFilters : '')});
                            chart4.update({url: '@chart('sources')' + ((allFilters) ? '/?' + allFilters : '')});
                        }

                        function loadList(obj, parent, data, str, url, plh) {
                            // let data = e.params.data;
                            obj.html('');
                            if (data && data.text) {
                                let allFilters = getSelectedItems(parent, str);
                                allFilters = allFilters.substring(1);
                                loadFilter(obj, url + allFilters, plh);                                
                            }
                        }

                        $(function () {
                            loadFilter($('#filter-theme'), 'https://visor.fancydraft.design/admin/json_themes_list', 'Выбрать тему');
                            // loadFilter($('#filter-subject'), 'https://visor.fancydraft.design/admin/json_subjects_list', 'Выбрать субъект');
                            loadFilter($('#filter-source'), 'https://visor.fancydraft.design/admin/json_sources_list', 'Выбрать источник');
                            loadFilter($('#filter-author'), 'https://visor.fancydraft.design/admin/json_authors_list', 'Выбрать автора');
                            loadFilter($('#filter-city'), 'https://visor.fancydraft.design/admin/json_cities_list', 'Выбрать город');
                            loadFilter($('#filter-region'), 'https://visor.fancydraft.design/admin/json_regions_list', 'Выбрать регион');
                            $('#filter-krai').select2({
                                placeholder: 'Выбрать оценку',
                                allowClear: true
                            });
                            $('#filter-krai-glava').select2({
                                minimumResultsForSearch: Infinity
                            });
                            $('#filter-subject').select2({
                                placeholder: 'Выбрать субъект',
                                allowClear: true
                            });
                            // $('#filter-region').select2({
                            //     placeholder: 'Выбрать регион',
                            //     allowClear: true
                            // })

                            $('#filter-theme').on('select2:select', function (e) {
                                loadList($('#filter-subject'), $('#filter-theme'), e.params.data, 'theme', 'https://visor.fancydraft.design/admin/json_subjects_list?', 'Выбрать субъект');
                            });

                            $('#filter-theme').on('select2:unselect', function (e) {
                                loadList($('#filter-subject'), $('#filter-theme'), e.params.data, 'theme', 'https://visor.fancydraft.design/admin/json_subjects_list?', 'Выбрать субъект');
                            });

                            $('#filter-theme').on('select2:clear', function (e) {
                                $('#filter-subject').html('');
                                $('#filter-subject').select2({
                                    placeholder: 'Выбрать субъект',
                                    allowClear: true
                                })                                
                            });

                            $('#filter-city').on('select2:select', function (e) {
                                loadList($('#filter-region'), $('#filter-city'), e.params.data, 'city', 'https://visor.fancydraft.design/admin/json_regions_list?', 'Выбрать регион');
                            })

                            $('#filter-city').on('select2:unselect', function (e) {
                                loadList($('#filter-region'), $('#filter-city'), e.params.data, 'city', 'https://visor.fancydraft.design/admin/json_regions_list?', 'Выбрать регион');
                            })

                            $('#filter-city').on('select2:clear', function (e) {
                                $('#filter-region').html('');
                                loadFilter($('#filter-region'), 'https://visor.fancydraft.design/admin/json_regions_list', 'Выбрать регион');
                            })
                        })


                    </script>

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
