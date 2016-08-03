@extends('layouts.app')

@section('content')

        <form action=" {{ url("/warehouse") }}" method="POST">
            {{ csrf_field() }}
            <table width="100%" class="table">
                <tr>
                    <th>單位代號</th>
                    <td><input type="text" name="warehouse[code]" id="code" value="{{ $warehouse['code'] }}"></td>
                </tr>
                <tr>
                    <th>單位說明</th>
                    <td><input type="text" name="warehouse[comment]" id="comment" value="{{ $warehouse['comment'] }}"></td>
                </tr>
            </table>
            <button class="btn btn-default">確認送出</button>
        </form>

@endsection