@extends('layouts.app')
{{--
@section('sidebar')
    @parent

    <p>這邊會附加在主要的側邊欄。</p>
@endsection
--}}
@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="100%" class="table">
            <thead>
                <tr>
                    <th class="string">料品單位代號</th>
                    <th class="string">料品單位說明</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($units as $unit)
                <tr>
                    <td class="string"><a href="{{ url("/unit/$unit->id") }}">{{ $unit->code }}</a></td>
                    <td class="string">{{ $unit->comment }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $units->render() !!}</div>
        <br>
        <a href="{{ url('/unit/create') }}" class="btn btn-default">新增料品單位</a>
@endsection