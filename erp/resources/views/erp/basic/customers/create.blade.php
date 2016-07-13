@extends('layouts.app')

@section('content')

        <form action="{{ url("/customers") }}" method="POST">
            {{ csrf_field() }}
            <table width="100%">
                <tr>
                    <th>公司名稱</th>
                    <td><input type="text" name="customer[name]" id="name" value="{{ $customer['name'] }}"></td>
                </tr>
                <tr>
                    <th>公司簡稱</th>
                    <td><input type="text" name="customer[shortName]" id="shortName" value="{{ $customer['shortName'] }}"></td>
                </tr>
                <tr>
                    <th>負責人</th>
                    <td><input type="text" name="customer[boss]" id="boss" value="{{ $customer['boss'] }}"></td>
                </tr>
                <tr>
                    <th>聯絡人</th>
                    <td><input type="text" name="customer[contactPerson]" id="contactPerson" value="{{ $customer['contactPerson'] }}"></td>
                </tr>
                <tr>
                    <th>郵遞區號</th>
                    <td>
                        <input type="text" size="5" name="customer[zip]" id="zip" value="{{ $customer['zip'] }}">
                    </td>
                </tr>
                <tr>
                    <th>地址</th>
                    <td>
                        <input type="text" name="customer[address]" id="address" value="{{ $customer['address'] }}">
                    </td>
                </tr>
                <tr>
                    <th>電子郵件</th>
                    <td><input type="text" name="customer[email]" id="email" value="{{ $customer['email'] }}"></td>
                </tr>
                <tr>
                    <th>電話號碼</th>
                    <td><input type="text" name="customer[telphone]" id="telphone" value="{{ $customer['telphone'] }}"></td>
                </tr>
                <tr>
                    <th>行動電話號碼</th>
                    <td><input type="text" name="customer[cellphone]" id="cellphone" value="{{ $customer['cellphone'] }}"></td>
                </tr>
                <tr>
                    <th>傳真號碼</th>
                    <td><input type="text" name="customer[fax]" id="fax" value="{{ $customer['fax'] }}"></td>
                </tr>
                <tr>
                    <th>統一編號</th>
                    <td><input type="text" name="customer[taxNumber]" id="taxNumber" value="{{ $customer['taxNumber'] }}"></td>
                </tr>
                <tr>
                    <th>稅別</th>
                    <td>
                        <select name="customer[tax_rate_id]" id="tax_rate_id">
                            <option></option>
                            @foreach($tax_rates as $code => $comment)
                                <option value="{{ $code }}" {{ $code == $customer['tax_rate_id'] ? "selected" : "" }}>
                                    {{ $comment }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>付款方式</th>
                    <td>
                        <select name="customer[pay_way_id]" id="pay_way_id">
                            <option></option>
                            @foreach($pay_ways as $code => $comment)
                                <option value="{{ $code }}" {{ $code == $customer['pay_way_id'] ? "selected" : '' }}>
                                    {{ $comment }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
            <button>確認送出</button>
        </form>

@endsection