<!DOCTYPE html>
<html>
<head>
    <title>Загрузка статистики отчётов в Excel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://visor.fancydraft.design/custom.css"/>
    <script src="https://visor.fancydraft.design/custom.js"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.js"></script>
    <script
        src="https://unpkg.com/bootstrap-table@1.18.0/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>

    <link rel="stylesheet" type="text/css"
          href="https://www.shieldui.com/shared/components/latest/css/light/all.min.css"/>
    <script type="text/javascript"
            src="https://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
    <script type="text/javascript" src="https://www.shieldui.com/shared/components/latest/js/jszip.min.js"></script>
</head>
<body>
<div class="container">
    <br/>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Отчёт</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <button id="exportButton" class="btn btn-lg btn-danger clearfix"><span
                        class="fa fa-file-excel-o"></span>Экспорт в Excel
                </button>
                <table id="table"
                       data-filter-control="true"
                       data-show-search-clear-button="true"
                       data-pagination-pre-text="Предыдущая"
                       data-pagination-next-text="Следующая"
                       data-pagination="true"
                       data-side-pagination="server">

                    <thead>
                    <tr>
                        <th id="theme" data-id="theme" data-field="tema_v_otcete" data-filter-control="select">Тема в
                            отчёте
                        </th>
                        <th data-field="subjekt" data-filter-control="select">Субъект</th>
                        <th data-field="data" data-sortable="true">Дата</th>
                        <th data-field="time" data-sortable="true">Время</th>
                        <th data-field="istocnik">Источник</th>
                        <th data-field="url_post">Url пост</th>
                        <th data-field="url_kommentarii">Url комментарий</th>
                        <th data-field="avtor">Автор</th>
                        <th data-field="kolicestvo_podpiscikov" data-sortable="true">Количество подписчиков</th>
                        <th data-field="citata">Цитата</th>
                        <th data-field="gorod" data-filter-control="select">Город</th>
                        <th data-field="raion" data-filter-control="select">Район</th>
                        <th data-field="ocenka_krai" data-filter-control="select">Оценка край</th>
                        <th data-field="krai_glava" data-filter-control="select">Оценка главы</th>
                        <th data-field="kommentarii" data-sortable="true">Комментарии</th>
                        <th data-field="laiki" data-sortable="true">Лайки</th>
                        <th data-field="reposti" data-sortable="true">Репосты</th>
                        <th data-field="prosmotri" data-sortable="true">Просмотры</th>
                        <th data-field="ssilka_na_profil">Ссылка на профиль</th>
                    </tr>
                    </thead>
                </table>

                <script>
                    var $table = $('#table');

                    $(function () {
                        $table.bootstrapTable({url: 'https://visor.fancydraft.design/admin/json_search'})
                    })

                </script>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
