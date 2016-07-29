@extends('layouts.app')

@inject('BarcodeGenerator', 'Picqer\Barcode\BarcodeGeneratorJPG')
{{--
@section('sidebar')
    @parent
    <p>這邊會附加在主要的側邊欄。</p>
@endsection
--}}
@section('content')
        <div style="float:right;">
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
        <table width="100%">
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
        <a href="{{ url("/company/".$company->auto_id."/edit") }}">維護客戶資料</a>
        <form action="{{ url("/company/".$company->auto_id) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除客戶</button>
        </form>
@endsection