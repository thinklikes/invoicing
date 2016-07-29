@extends('layouts.app')

@section('content')

        <form action="{{ url("/company") }}" method="POST">
            {{ csrf_field() }}
            <table width="100%">
                <tr>
                    <th>客戶編號</th>
                    <td><input type="text" name="company[company_code]" size="10"
                            id="company_code" value="{{ $company['company_code'] }}"></td>
                </tr>
                <tr>
                    <th>公司名稱</th>
                    <td><input type="text" name="company[company_name]"
                        id="company_name" value="{{ $company['company_name'] }}"></td>
                </tr>
                <tr>
                    <th>公司簡稱</th>
                    <td><input type="text" name="company[company_abb]"
                        id="company_abb" value="{{ $company['company_abb'] }}"></td>
                </tr>
                <tr>
                    <th>負責人</th>
                    <td><input type="text" name="company[boss]"
                        id="boss" value="{{ $company['boss'] }}"></td>
                </tr>
                <tr>
                    <th>郵遞區號</th>
                    <td><input type="text" name="company[mailbox]"
                        id="mailbox" value="{{ $company['mailbox'] }}"></td>
                </tr>
                <tr>
                    <th>公司地址</th>
                    <td><input type="text" name="company[company_add]"
                        id="company_add" value="{{ $company['company_add'] }}"></td>
                </tr>
                <tr>
                    <th>公司電話</th>
                    <td><input type="text" name="company[company_tel]"
                        id="company_tel" value="{{ $company['company_tel'] }}"></td>
                </tr>
                <tr>
                    <th>公司傳真</th>
                    <td><input type="text" name="company[company_fax]"
                        id="company_fax" value="{{ $company['company_fax'] }}"></td>
                </tr>
                <tr>
                    <th>統一編號</th>
                    <td><input type="text" name="company[VTA_NO]"
                        id="VTA_NO" value="{{ $company['VTA_NO'] }}"></td>
                </tr>
                <tr>
                    <th>聯絡人</th>
                    <td><input type="text" name="company[company_contact]"
                        id="company_contact" value="{{ $company['company_contact'] }}"></td>
                </tr>
                <tr>
                    <th>聯絡人電話</th>
                    <td><input type="text" name="company[company_con_tel]"
                        id="company_con_tel" value="{{ $company['company_con_tel'] }}"></td>
                </tr>
                <tr>
                    <th>聯絡人信箱</th>
                    <td><input type="text" name="company[company_con_email]"
                        id="company_con_email" value="{{ $company['company_con_email'] }}"></td>
                </tr>
                <tr>
                    <th>聯絡人傳真</th>
                    <td><input type="text" name="company[company_con_fax]"
                        id="company_con_fax" value="{{ $company['company_con_fax'] }}"></td>
                </tr>
{{--                 <tr>
                    <th>稅別</th>
                    <td>
                        <select name="company[tax_rate_id]" id="tax_rate_id">
                            <option></option>
                            @foreach($tax_rates as $code => $comment)
                                <option value="{{ $code }}" {{ $code == $company['tax_rate_id'] ? "selected" : "" }}>
                                    {{ $comment }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr> --}}
{{--                 <tr>
                    <th>付款方式</th>
                    <td>
                        <select name="company[pay_way_id]" id="pay_way_id">
                            <option></option>
                            @foreach($pay_ways as $code => $comment)
                                <option value="{{ $code }}" {{ $code == $company['pay_way_id'] ? "selected" : '' }}>
                                    {{ $comment }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr> --}}
            </table>
            <button>確認送出</button>
        </form>

@endsection