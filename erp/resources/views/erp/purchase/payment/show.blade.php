@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@section('content')
        <table id="master" width="100%">
            <tr>
                <th>建立日期</th>
                <td>{{ $PublicPresenter->getFormatDate($payment->created_at) }}</td>
                <th>付款日期</th>
                <td>{{ $payment->pay_date }}</td>
            </tr>
            <tr>
                <th>是否沖銷</th>
                <td>{{ $payment->isWrittenOff == 1 ? '是' : '否' }}</td>
                <th>付款單號</th>
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
    @if ($payment->isWrittenOff == 0)
        <a href="{{ url("/payment/{$payment->code}/edit") }}" class="btn btn-default">維護付款單</a>
        <form action="{{ url("/payment/{$payment->code}") }}" class="form_of_delete" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button class="btn btn-danger">刪除付款單</button>
        </form>
    @endif
@endsection
