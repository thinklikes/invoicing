@extends('layouts.app')

@section('sidebar')

<div class="panel panel-default">
    <div class="panel-heading">搜尋</div>

    <div class="panel-body">
        <form action="" method="GET" role="form">
            <div class="form-group">
                <label>供應商編號</label>
                <input type="text" class="form-control" name="code" value="{{ $code }}">
            </div>
            <div class="form-group">
                <label>供應商名稱</label>
                <input type="text" class="form-control" name="name" value="{{ $name }}">
            </div>
            <div class="form-group">
                <label>地址</label>
                <input type="text" class="form-control" name="address" value="{{ $address }}">
            </div>
            <button class="btn btn-info">搜尋</button>
        </form>
        <br>
        <a class="btn btn-default" href="{{ url('supplier/printBarcode') }}" target="_blank">條碼列印</a>
    </div>
</div>

@endsection

@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="100%" class="table">
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
        <a class="btn btn-default" href="{{ url('/supplier/create') }}">新增供應商</a>
@endsection