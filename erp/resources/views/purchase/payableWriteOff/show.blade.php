@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@section('content')
        <table id="master" width="100%">
            <tr>
                <td>建立日期</td>
                <td>{{ $PublicPresenter->getFormatDate($payment->created_at) }}</td>
                <td>付款日期</td>
                <td>{{ $payment->pay_date }}</td>
                <td>付款單號</td>
                <td>{{ $payment->code }}</td>
            </tr>
            <tr>
                <th>供應商</th>
                <td colspan="5">
                    {{ $payment->supplier_code }}
                    {{ $payment->supplier_name }}
                </td>
            </tr>
            <tr>
                <th>付款方式</th>
                <td colspan="5">
                    {{ $payment->type == "cash" ? "現金" : "票據" }}
                </td>
            </tr>
            <tr>
                <th>付款單備註</th>
                <td colspan="5">
                    {{ $payment->note }}
                </td>
            </tr>
        </table>
        <hr>
        <div id="check_contents">
            <table width="100%">
                <tr>
                    <td>票據號碼</td>
                    <td>{{ $payment['type'] == "cash" ? '--' : $payment['check_code']}}</td>
                </tr>
                <tr>
                    <td>到期日</td>
                    <td>{{ $payment['type'] == "cash" ? '--' : $payment['expiry_date']}}</td>
                </tr>
                <tr>
                    <td>銀行帳號</td>
                    <td>{{ $payment['type'] == "cash" ? '--' : $payment['bank_account']}}</td>
                </tr>
            </table>
        </div>
        <div>
            <table width="100%">
                <tr>
                    <td>付款金額</td>
                    <td>{{ $payment['amount'] }}</td>
                </tr>
            </table>
        </div>
        <hr>
        <a href="{{ url("/payments/{$payment->code}/edit") }}">維護付款單</a>
        <form action="{{ url("/payments/{$payment->code}") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除付款單</button>
        </form>

@endsection
