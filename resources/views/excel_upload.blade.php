@extends ('voyager::master')


<title>Загрузка статистики отчётов в Excel</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

@section('content')
    <div class="container">
        <h2>Загрузить файл отчёта в Excel</h2>
        <br/>
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
        <form method="post" enctype="multipart/form-data" action="{{ route('excel.upload') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <table class="table">
                    <tr>
                        <td width="40%" align="right"><label>Выбрать файл</label></td>
                        <td width="30">
                            <input type="file" name="excel_uploaded_file"/>
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
        <br/>
    </div>
@endsection