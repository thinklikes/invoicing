@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@section('content')
        <table id="master" width="100%">
            <tr>
                <td>建立日期</td>
                <td>{{ $PublicPresenter->getFormatDate($paymentOfPurchase->created_at) }}</td>
                <td>付款日期</td>
                <td>{{ $paymentOfPurchase->pay_date }}</td>
                <td>付款單號</td>
                <td>{{ $paymentOfPurchase->code }}</td>
            </tr>
            <tr>
                <th>供應商</th>
                <td colspan="5">
                    {{ $paymentOfPurchase->supplier_code }}
                    {{ $paymentOfPurchase->supplier_name }}
                </td>
            </tr>
            <tr>
                <th>付款方式</th>
                <td colspan="5">
                    {{ $paymentOfPurchase->type == "cash" ? "現金" : "票據" }}
                </td>
            </tr>
            <tr>
                <th>付款單備註</th>
                <td colspan="5">
                    {{ $paymentOfPurchase->note }}
                </td>
            </tr>
        </table>
        <hr>
        <div id="check_contents">
            <table width="100%">
                <tr>
                    <td>票據號碼</td>
                    <td>{{ $paymentOfPurchase['type'] == "cash" ? '--' : $paymentOfPurchase['check_code']}}</td>
                </tr>
                <tr>
                    <td>到期日</td>
                    <td>{{ $paymentOfPurchase['type'] == "cash" ? '--' : $paymentOfPurchase['expiry_date']}}</td>
                </tr>
                <tr>
                    <td>銀行帳號</td>
                    <td>{{ $paymentOfPurchase['type'] == "cash" ? '--' : $paymentOfPurchase['bank_account']}}</td>
                </tr>
            </table>
        </div>
        <div>
            <table width="100%">
                <tr>
                    <td>付款金額</td>
                    <td>{{ $paymentOfPurchase['amount'] }}</td>
                </tr>
            </table>
        </div>
        <hr>
        <a href="{{ url("/paymentsOfPurchase/{$paymentOfPurchase->code}/edit") }}">維護付款單</a>
        <form action="{{ url("/paymentsOfPurchase/{$paymentOfPurchase->code}") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除付款單</button>
        </form>

@endsection
