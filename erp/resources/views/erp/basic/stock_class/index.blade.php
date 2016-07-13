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
                    <th>料品類別代號</th>
                    <th>料品類別說明</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($stock_classes as $stock_class)
                <tr>
                    <td><a href="{{ url("/stock_class/$stock_class->id") }}">{{ $stock_class->code }}</a></td>
                    <td>{{ $stock_class->comment }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $stock_classes->render() !!}</div>
        <br>
        <a href="{{ url('/stock_class/create') }}">新增料品類別</a>
@endsection