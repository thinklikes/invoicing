@extends('layouts.app')

@section('content')

        <form action="{{ url("/stock_class/$id") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table width="100%" class="table">
                <tr>
                    <th>單位代號</th>
                    <td><input type="text" name="stock_class[code]" id="code" value="{{ $stock_class['code'] }}"></td>
                </tr>
                <tr>
                    <th>單位說明</th>
                    <td><input type="text" name="stock_class[comment]" id="comment" value="{{ $stock_class['comment'] }}"></td>
                </tr>
            </table>
            <button class="btn btn-default">確認送出</button>
        </form>

@endsection