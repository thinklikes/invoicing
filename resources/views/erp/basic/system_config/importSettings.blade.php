@extends('layouts.app')

@section('content')

    <!-- Bootstrap 樣板... -->
    <form method="POST" action="/system_config/import" role="form" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">自系統備份存檔還原：</div>
@foreach($files as $key => $file)
        <div class="radio">
            <label>
                <input type="radio" name="file" value="{{ $file }}">
                    {{ $key }} / {{ $file }}
            </label>
        </div>
@endforeach
        <div class="form-group">自檔案還原：</div>
        <div class="radio">
            <label>
                <input type="radio" name="file" value="from_file">
                <input type="file" name="upload_file" onfocus="$(this).prev().prop('checked', true);">
            </label>
        </div>
        <div class="form-group">
            <button class="btn btn-default"
                type="submit" onclick="return confirm('此項操作將會覆蓋資料庫，確定繼續嗎?')">
                開始匯入資料庫檔案
            </button>
        </div>
    </form>
@endsection