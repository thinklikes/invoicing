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
                    <th class="string">付款方式代號</th>
                    <th class="string">付款方式說明</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($pay_ways as $pay_way)
                <tr>
                    <td class="string"><a href="{{ url("/pay_way/".$pay_way->id) }}">{{ $pay_way->code }}</a></td>
                    <td class="string">{{ $pay_way->comment }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $pay_ways->render() !!}</div>
        <br>
        <a href="{{ url('/pay_way/create') }}" class="btn btn-default">新增付款方式</a>
@endsection