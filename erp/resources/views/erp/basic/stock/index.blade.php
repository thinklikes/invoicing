@extends('layouts.app')

@section('sidebar')

<div class="panel panel-default">
    <div class="panel-heading">搜尋</div>

    <div class="panel-body">
        <form action="" method="GET">
            <table>
                <tr>
                    <td>料品代號</td>
                </tr>
                <tr>
                    <td><input type="text" name="code" size="15" value="{{ $code }}"></td>
                </tr>
                <tr>
                    <td>料品名稱</td>
                </tr>
                <tr>
                    <td><input type="text" name="name" size="15" value="{{ $name }}"></td>
                </tr>
            </table>
            <button>搜尋</button>
        </form>
        <br>
        <a href="/stock/printBarcode" target="_blank">條碼列印</a>
    </div>
</div>

@endsection

@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="100%">
            <thead>
                <tr>
                    <th class="string">料品代號</th>
                    <th class="string">料品名稱</th>
                    <th class="numeric">淨重</th>
                    <th class="numeric">毛重</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($stocks as $stock)
                <tr>
                    <td class="string"><a href="{{ url("/stock/$stock->id") }}">{{ $stock->code }}</a></td>
                    <td class="string">{{ $stock->name }}</td>
                    <td class="numeric">{{ $stock->net_weight }}</td>
                    <td class="numeric">{{ $stock->gross_weight }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $stocks->render() !!}</div>
        <br>
        <a href="{{ url('/stock/create') }}">新增料品</a>
@endsection