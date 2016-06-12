@extends('layouts.app')

@inject('BarcodeGenerator', 'Picqer\Barcode\BarcodeGeneratorJPG');
{{--
@section('sidebar')

<div class="panel panel-default">
    <div class="panel-heading">條碼</div>

    <div class="panel-body">
    </div>
</div>

@endsection
--}}
@section('content')
        <div style="float:right;">
            <img src="data:image/png;base64, {{ base64_encode($BarcodeGenerator->getBarcode($supplier->code, $BarcodeGenerator::TYPE_CODE_128)) }}">
        </div>
        <table width="100%">
            <tr>
                <th>供應商編號</th>
                <td>{{ $supplier->code }}</td>
            </tr>
            <tr>
                <th>供應商名稱</th>
                <td>{{ $supplier->name }}</td>
            </tr>
            <tr>
                <th>供應商簡稱</th>
                <td>{{ $supplier->shortName }}</td>
            </tr>
            <tr>
                <th>負責人</th>
                <td>{{ $supplier->boss }}</td>
            </tr>
            <tr>
                <th>聯絡人</th>
                <td>{{ $supplier->contactPerson }}</td>
            </tr>
            <tr>
                <th>郵遞區號</th>
                <td>{{ $supplier->zip }}</td>
            </tr>
            <tr>
                <th>地址</th>
                <td>{{ $supplier->address }}</td>
            </tr>
            <tr>
                <th>電子郵件</th>
                <td>{{ $supplier->email }}</td>
            </tr>
            <tr>
                <th>電話號碼</th>
                <td>{{ $supplier->telphone }}</td>
            </tr>
            <tr>
                <th>行動電話號碼</th>
                <td>{{ $supplier->cellphone }}</td>
            </tr>
            <tr>
                <th>傳真號碼</th>
                <td>{{ $supplier->fax }}</td>
            </tr>
            <tr>
                <th>統一編號</th>
                <td>{{ $supplier->taxNumber }}</td>
            </tr>
        </table>
        <a href="{{ url("/suppliers/$id/edit") }}">維護供應商資料</a>
        <form action="{{ url("/suppliers/$id") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除供應商</button>
        </form>
@endsection