@extends('layouts.app')

@section('content')
    <form action=" {{ url('/orderUploader/save') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div id="master_table" class="custom-table">
            <div class="tbody">
                <div class="tr">
                    <div class="td">上傳日期</div>
                    <div class="td">
                        {{ date('Y-m-d') }}
                    </div>
                </div>
                <div class="tr">
                    <div class="td">訂單平台</div>
                    <div class="td">
                        <select name="orderUploader[platform_name]">
                            <option value="">請選擇</option>
                            @foreach($platforms as $platform)
                                <option value="{{ $platform->name }}">{{ $platform->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="tr">
                    <div class="td">檔案</div>
                    <div class="td">
                        <input type="file" name="orderUploader[upload_file]"
                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
                        {{-- <input type="file" name="file"
                        accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" /> --}}
                    </div>
                </div>
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-default">確認送出</button>
    </form>
@endsection