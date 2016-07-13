@extends('layouts.app')

@section('content')

        <form action="{{ url("/warehouse/$id") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table width="100%">
                <tr>
                    <th>倉庫代號</th>
                    <td><input type="text" name="warehouse[code]" id="code" value="{{ $warehouse['code'] }}"></td>
                </tr>
                <tr>
                    <th>倉庫說明</th>
                    <td><input type="text" name="warehouse[comment]" id="comment" value="{{ $warehouse['comment'] }}"></td>
                </tr>
            </table>
            <button>確認送出</button>
        </form>

@endsection