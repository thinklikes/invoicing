@extends('layouts.app')
{{--
@section('sidebar')
    @parent
    <p>這邊會附加在主要的側邊欄。</p>
@endsection
--}}
@section('content')

        <table width="100%">
            <tr>
                <th>公司名稱</th>
                <td>{{ $customer->name }}</td>
            </tr>
            <tr>
                <th>公司簡稱</th>
                <td>{{ $customer->shortName }}</td>
            </tr>
            <tr>
                <th>負責人</th>
                <td>{{ $customer->boss }}</td>
            </tr>
            <tr>
                <th>聯絡人</th>
                <td>{{ $customer->contactPerson }}</td>
            </tr>
            <tr>
                <th>郵遞區號</th>
                <td>{{ $customer->zip }}</td>
            </tr>
            <tr>
                <th>地址</th>
                <td>{{ $customer->address }}</td>
            </tr>
            <tr>
                <th>電子郵件</th>
                <td>{{ $customer->email }}</td>
            </tr>
            <tr>
                <th>電話號碼</th>
                <td>{{ $customer->telphone }}</td>
            </tr>
            <tr>
                <th>行動電話號碼</th>
                <td>{{ $customer->cellphone }}</td>
            </tr>
            <tr>
                <th>傳真號碼</th>
                <td>{{ $customer->fax }}</td>
            </tr>
            <tr>
                <th>統一編號</th>
                <td>{{ $customer->taxNumber }}</td>
            </tr>
            <tr>
                <th>稅別</th>
                <td>
                {{ $customer->tax_rate_id != "" ? $tax_rates[$customer->tax_rate_id] : "" }}</td>
            </tr>
            <tr>
                <th>付款方式</th>
                <td>
                {{ $customer->pay_way_id != "" ? $pay_ways[$customer->pay_way_id] : "" }}</td>
            </tr>
        </table>
        <a href="{{ url("/customers/".$id."/edit") }}">維護客戶資料</a>
        <form action="{{ url("/customers/".$id) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除客戶</button>
        </form>
@endsection