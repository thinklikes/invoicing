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
                <th>料品類別代號</th>
                <td>{{ $stock_class->code }}</td>
            </tr>
            <tr>
                <th>料品類別說明</th>
                <td>{{ $stock_class->comment }}</td>
            </tr>
        </table>
        <a href="{{ url("/stock_classes/$id/edit") }}">維護料品類別</a>
        <form action="{{ url("/stock_classes/$id") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除料品類別</button>
        </form>
@endsection