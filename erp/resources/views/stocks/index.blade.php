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
                    <td><input type="text" name="search[code]" size="15"></td>
                </tr>
                <tr>
                    <td>料品名稱</td>
                </tr>
                <tr>
                    <td><input type="text" name="search[name]" size="15"></td>
                </tr>
            </table>
            <button>搜尋</button>
        </form>
    </div>
</div>

@endsection

@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="100%">
            <thead>
                <tr>
                    <th>料品代號</th>
                    <th>料品名稱</th>
                    <th>淨重</th>
                    <th>毛重</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($stocks as $stock)
                <tr>
                    <td><a href="{{ url("/stocks/$stock->id") }}">{{ $stock->code }}</a></td>
                    <td>{{ $stock->name }}</td>
                    <td>{{ $stock->netWeight }}</td>
                    <td>{{ $stock->grossWeight }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $stocks->render() !!}</div>
        <br>
        <a href="{{ url('/stocks/create') }}">新增料品</a>
@endsection