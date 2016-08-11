@extends('layouts.app')

@section('content')

        <form action="{{ url("/warehouse/$id") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table width="100%" class="table">
                <tr>
                    <th>倉庫代號</th>
                    <td><input type="text" name="warehouse[code]" id="code" value="{{ $warehouse['code'] }}"></td>
                </tr>
                <tr>
                    <th>倉庫名稱</th>
                    <td><input type="text" name="warehouse[name]" id="name" value="{{ $warehouse['name'] }}"></td>
                </tr>
            </table>
            <button class="btn btn-default">確認送出</button>
        </form>

@endsection