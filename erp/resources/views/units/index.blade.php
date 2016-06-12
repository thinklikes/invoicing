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
                    <th>料品單位代號</th>
                    <th>料品單位說明</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($units as $unit)
                <tr>
                    <td><a href="{{ url("/units/$unit->id") }}">{{ $unit->code }}</a></td>
                    <td>{{ $unit->comment }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $units->render() !!}</div>
        <br>
        <a href="{{ url('/units/create') }}">新增料品單位</a>
@endsection