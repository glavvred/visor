@extends ('voyager::master')

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</head>

@section('content')
    <table id="excel_data" class="display">
        <thead>
            <tr id="theme" data-id="theme" data-field="tema_v_otcete" data-filter-control="select">Тема&nbsp;в&nbsp;отчёте</tr>
            <tr data-field="subjekt" data-filter-control="select">Субъект</tr>
            <tr data-field="data" data-formatter="dateFormat" data-filter-control="datepicker"
                data-filter-datepicker-options='{"autoclose":true, "clearBtn": true, "todayHighlight": true}'>
                Дата
            </tr>
            <tr data-field="time" data-sortable="true" data-formatter="timeFormat" >Время</tr>
            <tr data-field="istocnik" data-filter-control="select">Источник</tr>
            <tr data-field="url_post" data-formatter="linkFormat">Url пост</tr>
            <tr data-field="url_kommentarii" data-formatter="linkFormat">Url комментарий</tr>
            <tr data-field="avtor" data-filter-control="select">Автор</tr>
            <tr data-field="kolicestvo_podpiscikov" data-sortable="true">Количество подписчиков</tr>
            <tr data-field="gorod" data-filter-control="select">Город</tr>
            <tr data-field="raion" data-filter-control="select">Район</tr>
            <tr data-field="ocenka_krai" data-filter-control="select">Оценка край</tr>
            <tr data-field="ocenka_glava" data-filter-control="select">Оценка главы</tr>
            <tr data-field="krai_glava" data-filter-control="select">Край-глава</tr>
            <tr data-field="kommentarii" data-sortable="true">Комментарии</tr>
            <tr data-field="laiki" data-sortable="true">Лайки</tr>
            <tr data-field="reposti" data-sortable="true">Репосты</tr>
            <tr data-field="prosmotri" data-sortable="true">Просмотры</tr>
            <tr data-field="ssilka_na_profil" data-formatter="linkFormat">Ссылка на профиль</tr>
        </thead>
        <tbody>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tbody>
    </table>
<script>
    $(document).ready(function() {
        $('#excel_data').DataTable( {

        } );
    } );
</script>

{{--    ajax: '{{ route('excel.json.search') }}',--}}
{{--    columns: [--}}
{{--    { title: "Name" },--}}
{{--    { title: "Position" },--}}
{{--    { title: "Office" },--}}
{{--    { title: "Extn." },--}}
{{--    { title: "Start date" },--}}
{{--    { title: "Salary" }--}}
{{--    ]--}}


@endsection