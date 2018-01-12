@extends('layouts.app')

@section('content')
    <form action=" {{ url('/itemMappingEditor') }}" method="POST">
        {{ csrf_field() }}
        <div id="master_table" class="custom-table">
            <div class="tbody">
                <div class="tr">
                    <div class="td"><h1>{{ $platform }} 品名</h1></div>
                </div>
                <div class="tr">
                    <div class="td">
                        <textarea name="content" id="" cols="90" rows="20">{{ $content or null }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <input type="hidden" name="platform" value="{{ $platform }}">
        <button type="submit" class="btn btn-default">確認送出</button>
    </form>
@endsection