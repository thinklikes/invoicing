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
                <th>料品單位代號</th>
                <td>{{ $unit->code }}</td>
            </tr>
            <tr>
                <th>料品單位說明</th>
                <td>{{ $unit->comment }}</td>
            </tr>
        </table>
        <a href="{{ url("/unit/$id/edit") }}" class="btn btn-default">維護料品單位資料</a>
        <form action="{{ url("/units/$id") }}" class="form_of_delete" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button class="btn btn-danger">刪除料品單位</button>
        </form>
@endsection