<!DOCTYPE html>
<html>
 <head>
  <title>Загрузка статистики отчётов в Excel</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
	<div role="navigation" class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
            <span class="sr-only">Навигация</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active">Главная</li>           
          </ul>         
        </div>
      </div>
    </div>
  <br />  
  <div class="container">
   <h2>Загрузить файл отчёта в Excel</h2>
    <br />
   @if(count($errors) > 0)
    <div class="alert alert-danger">
     Ошибка валидации файла<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif
   @if($message = Session::get('success'))
   <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
           <strong>{{ $message }}</strong>
   </div>
   @endif
   <form method="post" enctype="multipart/form-data" action="{{ route('excel.import') }}">
    {{ csrf_field() }}
    <div class="form-group">
     <table class="table">
      <tr>
       <td width="40%" align="right"><label>Выбрать файл</label></td>
       <td width="30">
        <input type="file" name="select_file" />
       </td>
       <td width="30%" align="left">
        <input type="submit" name="upload" class="btn btn-primary" value="Загрузить">
       </td>
      </tr>
      <tr>
       <td width="40%" align="right"></td>
       <td width="30"><span class="text-muted">.xls, .xslx</span></td>
       <td width="30%" align="left"></td>
      </tr>
     </table>
    </div>
   </form>   
   <br />
   <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title">Отчёт</h3>
    </div>
    <div class="panel-body">
     <div class="table-responsive">
      <table class="table table-bordered table-striped">
       <tr>
    <th>Тема в отчёте</th>
    <th>Субъект</th>        
    <th>Источник</th>       
    <th>Url пост</th>
	<th>Url комментарий</th>
	<th>Автор</th>
	<th>Количество подписчиков</th>
	<th>Цитата</th>
	<th>Город</th>
	<th>Район</th>
	<th>Оценка край</th>
	<th>Край/Глава</th>
	<th>Оценка главы</th>
	<th>Комментарии</th>
	<th>Лайки</th>
	<th>Репосты</th>
	<th>Просмотры</th>
	<th>Ссылка на профиль</th>
       </tr>
      @foreach($excel_table as $excel_table)
       <tr>
        <td>{{ $excel_table->tema_v_otcete }}</td>
        <td>{{ $excel_table->subjekt }}</td>        
        <td>{{ $excel_table->data }}</td>       
        <td>{{ $excel_table->time }}</td>
        <td>{{ $excel_table->istocnik }}</td>
        <td>{{ $excel_table->url_post }}</td>
		<td>{{ $excel_table->url_kommentarii }}</td>
		<td>{{ $excel_table->avtor }}</td>
		<td>{{ $excel_table->kolicestvo_podpiscikov }}</td>
		<td>{{ $excel_table->citata }}</td>
		<td>{{ $excel_table->gorod }}</td>       
	    <td>{{ $excel_table->raion }}</td>
	    <td>{{ $excel_table->ocenka_krai }}</td>
	    <td>{{ $excel_table->ocenka_glavi }}</td>  
		<td>{{ $excel_table->kommentarii }}</td>  
		<td>{{ $excel_table->laiki}}</td>  
		<td>{{ $excel_table->reposti }}</td>  
		<td>{{ $excel_table->prosmotri }}</td>       
		<td>{{ $excel_table->ssilka_na_profil }}</td>    
     </tr>
       @endforeach
      </table>
     </div>
    </div>
   </div>
  </div>
 </body>
</html>