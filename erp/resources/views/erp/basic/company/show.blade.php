@extends('layouts.app')

@inject('BarcodeGenerator', 'Picqer\Barcode\BarcodeGeneratorJPG')

@include('erp.show_button_group', [
    'print_enabled' => false,
    'delete_enabled' => true,
    'edit_enabled'   => true,
    'chname'         => '客戶',
    'route_name'     => 'company',
    'code'           => $company->auto_id
])

@section('content')
        <div style="float:right; margin-bottom:10px;">
            <img src="data:image/png;base64,
                {{
                    base64_encode(
                        $BarcodeGenerator->getBarcode(
                            $company->company_code,
                            $BarcodeGenerator::TYPE_CODE_128
                        )
                    )
                }}">
        </div>
        <table width="100%"  class="table">
            <tr>
                <th>客戶編號</th>
                <td>{{ $company->company_code }}</td>
            </tr>
            <tr>
                <th>公司名稱</th>
                <td>{{ $company->company_name }}</td>
            </tr>
            <tr>
                <th>公司簡稱</th>
                <td>{{ $company->company_abb }}</td>
            </tr>
            <tr>
                <th>負責人</th>
                <td>{{ $company->boss }}</td>
            </tr>
            <tr>
                <th>郵遞區號</th>
                <td>{{ $company->mailbox }}</td>
            </tr>
            <tr>
                <th>公司地址</th>
                <td>{{ $company->company_add }}</td>
            </tr>
            <tr>
                <th>公司電話</th>
                <td>{{ $company->company_tel }}</td>
            </tr>
            <tr>
                <th>公司傳真</th>
                <td>{{ $company->company_fax }}</td>
            </tr>
            <tr>
                <th>統一編號</th>
                <td>{{ $company->VTA_NO }}</td>
            </tr>
            <tr>
                <th>聯絡人</th>
                <td>{{ $company->company_contact }}</td>
            </tr>
            <tr>
                <th>聯絡人電話</th>
                <td>{{ $company->company_con_tel }}</td>
            </tr>
            <tr>
                <th>聯絡人信箱</th>
                <td>{{ $company->company_con_email }}</td>
            </tr>
            <tr>
                <th>聯絡人傳真</th>
                <td>{{ $company->company_con_fax }}</td>
            </tr>
{{--             <tr>
                <th>稅別</th>
                <td>
                {{ $company->tax_rate_id != "" ? $tax_rates[$company->tax_rate_id] : "" }}</td>
            </tr>
            <tr>
                <th>付款方式</th>
                <td>
                {{ $company->pay_way_id != "" ? $pay_ways[$company->pay_way_id] : "" }}</td>
            </tr> --}}
        </table>
    {{-- 資料檢視頁的按鈕群組 --}}
    @yield('show_button_group')
@endsection