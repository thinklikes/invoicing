@extends('layouts.app')

@section('content')

        <form action="{{ url("/pay_way/$id") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table width="100%" class="table">
                <tr>
                    <th>單位代號</th>
                    <td><input type="text" name="pay_way[code]" id="code" value="{{ $pay_way['code'] }}"></td>
                </tr>
                <tr>
                    <th>單位說明</th>
                    <td><input type="text" name="pay_way[comment]" id="comment" value="{{ $pay_way['comment'] }}"></td>
                </tr>
            </table>
            <button class="btn btn-default">確認送出</button>
        </form>

@endsection