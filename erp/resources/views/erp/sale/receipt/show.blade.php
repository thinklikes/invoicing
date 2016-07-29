@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@section('content')
        <table id="master" width="100%">
            <tr>
                <th>建立日期</th>
                <td>{{ $PublicPresenter->getFormatDate($receipt->created_at) }}</td>
                <th>收款日期</th>
                <td>{{ $receipt->receive_date }}</td>
            </tr>
            <tr>
                <th>是否沖銷</th>
                <td>{{ $receipt->isWrittenOff == 1 ? '是' : '否' }}</td>
                <th>收款單號</th>
                <td>{{ $receipt->code }}</td>
            </tr>
            <tr>
                <th>客戶</th>
                <td colspan="5">
                    {{ $receipt->company->company_code }}
                    {{ $receipt->company->company_name }}
                </td>
            </tr>
            <tr>
                <th>收款方式</th>
                <td colspan="5">
                    {{ $receipt->type == "cash" ? "現金" : "票據" }}
                </td>
            </tr>
            <tr>
                <th>收款單備註</th>
                <td colspan="5">
                    {{ $receipt->note }}
                </td>
            </tr>
        </table>
        <hr>
        <div id="check_contents">
            <table width="100%">
                <tr>
                    <td>票據號碼</td>
                    <td>{{ $receipt['type'] == "cash" ? '--' : $receipt['check_code']}}</td>
                </tr>
                <tr>
                    <td>到期日</td>
                    <td>{{ $receipt['type'] == "cash" ? '--' : $receipt['expiry_date']}}</td>
                </tr>
                <tr>
                    <td>銀行帳號</td>
                    <td>{{ $receipt['type'] == "cash" ? '--' : $receipt['bank_account']}}</td>
                </tr>
            </table>
        </div>
        <div>
            <table width="100%">
                <tr>
                    <td>收款金額</td>
                    <td>{{ $receipt['amount'] }}</td>
                </tr>
            </table>
        </div>
        <hr>
    @if ($receipt->isWrittenOff == 0)
        <a href="{{ url("/receipt/{$receipt->code}/edit") }}">維護收款單</a>
        <form action="{{ url("/receipt/{$receipt->code}") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除收款單</button>
        </form>
    @endif
@endsection
