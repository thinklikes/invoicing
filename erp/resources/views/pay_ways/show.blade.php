@extends('layouts.app')
{{--
@section('sidebar')
    @parent

    <p>這邊會附加在主要的側邊欄。</p>
@endsection
--}}
@section('content')

        <table width="100%">
            <tr>
                <th>付款方式代號</th>
                <td>{{ $pay_way->code }}</td>
            </tr>
            <tr>
                <th>付款方式說明</th>
                <td>{{ $pay_way->comment }}</td>
            </tr>
        </table>
        <a href="{{ url("/pay_ways/$id/edit") }}">維護付款方式資料</a>
        <form action="{{ url("/pay_ways/$id") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除付款方式</button>
        </form>
@endsection