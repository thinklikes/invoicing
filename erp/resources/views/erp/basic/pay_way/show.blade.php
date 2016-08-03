@extends('layouts.app')
{{--
@section('sidebar')
    @parent

    <p>這邊會附加在主要的側邊欄。</p>
@endsection
--}}
@section('content')

        <table width="100%" class="table">
            <tr>
                <th>付款方式代號</th>
                <td>{{ $pay_way->code }}</td>
            </tr>
            <tr>
                <th>付款方式說明</th>
                <td>{{ $pay_way->comment }}</td>
            </tr>
        </table>
        <a href="{{ url("/pay_way/$id/edit") }}" class="btn btn-default">維護付款方式資料</a>
        <form action="{{ url("/pay_way/$id") }}" class="form_of_delete" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button class="btn btn-danger">刪除付款方式</button>
        </form>
@endsection