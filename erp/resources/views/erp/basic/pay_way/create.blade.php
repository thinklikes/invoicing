@extends('layouts.app')

@section('content')

        <form action="{{ url("/pay_way") }}" method="POST">
            {{ csrf_field() }}
            <table width="100%">
                <tr>
                    <th>單位代號</th>
                    <td><input type="text" name="pay_way[code]" id="code" value="{{ $pay_way['code'] }}"></td>
                </tr>
                <tr>
                    <th>單位說明</th>
                    <td><input type="text" name="pay_way[comment]" id="comment" value="{{ $pay_way['comment'] }}"></td>
                </tr>
            </table>
            <button>確認送出</button>
        </form>

@endsection