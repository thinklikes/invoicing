@extends('layouts.app')
{{--
@section('sidebar')
    @parent

    <p>這邊會附加在主要的側邊欄。</p>
@endsection
--}}
@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="100%">
            <thead>
                <tr>
                    <th>倉庫代號</th>
                    <th>倉庫說明</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($warehouses as $warehouse)
                <tr>
                    <td><a href="{{ url("/warehouse/$warehouse->id") }}">{{ $warehouse->code }}</a></td>
                    <td>{{ $warehouse->comment }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $warehouses->render() !!}</div>
        <br>
        <a href="{{ url('/warehouse/create') }}">新增倉庫</a>
@endsection