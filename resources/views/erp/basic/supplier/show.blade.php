@extends('layouts.app')

@inject('BarcodeGenerator', 'Picqer\Barcode\BarcodeGeneratorJPG')

@include('erp.show_button_group', [
    'printBarcode_enabled' => true,
    'print_enabled'        => false,
    'delete_enabled'       => true,
    'edit_enabled'         => true,
    'chname'               => '供應商',
    'route_name'           => 'supplier',
    'code'                 => $supplier->id
])

@section('content')
        <div style="float:right; margin-bottom:10px;">
            <img class="barcode" src="data:image/png;base64, {{
                base64_encode(
                    $BarcodeGenerator->getBarcode(
                        $supplier->code, $BarcodeGenerator::TYPE_CODE_128))
            }}">
        </div>
        <table width="100%" class="table">
            <tr>
                <th>供應商編號</th>
                <td>{{ $supplier->code }}</td>
            </tr>
            <tr>
                <th>供應商名稱</th>
                <td>{{ $supplier->name }}</td>
            </tr>
            <tr>
                <th>供應商品</th>
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
            <tr>
                <th>匯款戶名</th>
                <td>{{ $supplier->remName }}</td>
            </tr>
            <tr>
                <th>匯款局號</th>
                <td>{{ $supplier->remBureau }}</td>
            </tr>
            <tr>
                <th>匯款帳號</th>
                <td>{{ $supplier->remAccount }}</td>
            </tr>
        </table>
    {{-- 資料檢視頁的按鈕群組 --}}
    @yield('show_button_group')
@endsection