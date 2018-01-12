@extends('layouts.app')

@section('content')

        <form action="{{ url("/supplier/$id") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table width="100%" class="table">
                <tr>
                    <th>供應商編號</th>
                    <td><input type="text" name="supplier[code]" id="code" value="{{ $supplier['code'] }}"></td>
                </tr>
                <tr>
                    <th>供應商名稱</th>
                    <td><input type="text" name="supplier[name]" id="name" value="{{ $supplier['name'] }}"></td>
                </tr>
                <tr>
                    <th>供應商品</th>
                    <td><input type="text" name="supplier[shortName]" id="shortName" value="{{ $supplier['shortName'] }}"></td>
                </tr>
                <tr>
                    <th>負責人</th>
                    <td><input type="text" name="supplier[boss]" id="boss" value="{{ $supplier['boss'] }}"></td>
                </tr>
                <tr>
                    <th>聯絡人</th>
                    <td><input type="text" name="supplier[contactPerson]" id="contactPerson" value="{{ $supplier['contactPerson'] }}"></td>
                </tr>
                <tr>
                    <th>郵遞區號</th>
                    <td>
                        <input type="text" size="5" name="supplier[zip]" id="zip" value="{{ $supplier['zip'] }}">
                    </td>
                </tr>
                <tr>
                    <th>地址</th>
                    <td>
                        <input type="text" name="supplier[address]" id="address" value="{{ $supplier['address'] }}">
                    </td>
                </tr>
                <tr>
                    <th>電子郵件</th>
                    <td><input type="text" name="supplier[email]" id="email" value="{{ $supplier['email'] }}"></td>
                </tr>
                <tr>
                    <th>電話號碼</th>
                    <td><input type="text" name="supplier[telphone]" id="telphone" value="{{ $supplier['telphone'] }}"></td>
                </tr>
                <tr>
                    <th>行動電話號碼</th>
                    <td><input type="text" name="supplier[cellphone]" id="cellphone" value="{{ $supplier['cellphone'] }}"></td>
                </tr>
                <tr>
                    <th>傳真號碼</th>
                    <td><input type="text" name="supplier[fax]" id="fax" value="{{ $supplier['fax'] }}"></td>
                </tr>
                <tr>
                    <th>統一編號</th>
                    <td><input type="text" name="supplier[taxNumber]" id="taxNumber" value="{{ $supplier['taxNumber'] }}"></td>
                </tr>
                <tr>
                    <th>匯款戶名</th>
                    <td><input type="text" name="supplier[remName]" id="taxNumber" value="{{ $supplier['remName'] }}"></td>
                </tr>
                <tr>
                    <th>匯款局號</th>
                    <td><input type="text" name="supplier[remBureau]" id="taxNumber" value="{{ $supplier['remBureau'] }}"></td>
                </tr>
                <tr>
                    <th>匯款帳號</th>
                    <td><input type="text" name="supplier[remAccount]" id="taxNumber" value="{{ $supplier['remAccount'] }}"></td>
                </tr>
            </table>
            <button class="btn btn-default">確認送出</button>
        </form>

@endsection