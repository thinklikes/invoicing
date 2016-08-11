@extends('layouts.app')

@section('content')

    <!-- Bootstrap 樣板... -->
    <form method="POST" action="/system_config/export" target="_blank" role="form">
        {{ csrf_field() }}
        <div class="form-group">
            {{--
            <label>選擇下載檔案格式：</label>
            <select name="data_type">
                <option value="xls">Excel97-2003</option>
                <option value="xlsx">Exce2007</option>
                <option value="sql">資料庫檔案</option>
            </select> --}}
            <input type="hidden" name="data_type" value="sql">
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">下載資料庫檔案</button>
        </div>
    </form>
@endsection