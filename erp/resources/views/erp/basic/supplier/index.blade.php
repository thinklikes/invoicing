@extends('layouts.app')

@section('sidebar')

<div class="panel panel-default">
    <div class="panel-heading">搜尋</div>

    <div class="panel-body">
        <form action="" method="GET">
            <table>
                <tr>
                    <td>供應商編號</td>
                </tr>
                <tr>
                    <td><input type="text" name="code" size="15"></td>
                </tr>
                <tr>
                    <td>供應商名稱</td>
                </tr>
                <tr>
                    <td><input type="text" name="name" size="15"></td>
                </tr>
                <tr>
                    <td>地址</td>
                <tr>
                    <td><input type="text" name="address" size="15"></td>
                </tr>
            </table>
            <button>搜尋</button>
        </form>
        <br>
        <a href="/supplier/printBarcode" target="_blank">條碼列印</a>
    </div>
</div>

@endsection

@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="100%">
            <thead>
                <tr>
                    <th class="string">供應商編號</th>
                    <th class="string">供應商名稱</th>
                    <th class="string">聯絡人</th>
                    <th class="string">電話</th>
                    <th class="string">地址</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($suppliers as $supplier)
                <tr>
                    <td class="string">{{ $supplier->code }}</td>
                    <td class="string"><a href="{{ url("/supplier/$supplier->id") }}">{{ $supplier->name }}</a></td>
                    <td class="string">{{ $supplier->contactPerson }}</td>
                    <td class="string">{{ $supplier->telphone }}</td>
                    <td class="string">{{ $supplier->address }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $suppliers->render() !!}</div>
        <br>
        <a href="{{ url('/supplier/create') }}">新增供應商</a>
@endsection