@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@section('content')
            <table id="master" width="100%">
                <tr>
                    <td>建立日期</td>
                    <td>{{ $PublicPresenter->getFormatDate($payableWriteOff['created_at']) }}</td>
                    <td>沖銷單號</td>
                    <td>{{ $payableWriteOff['code'] }}</td>
                </tr>
                <tr>
                    <th>供應商</th>
                    <td colspan="3">
                        {{ $payableWriteOff['supplier_code'] }}
                        {{ $payableWriteOff['supplier_name'] }}
                    </td>
                </tr>
                <tr>
                    <th>備註</th>
                    <td colspan="3">
                        {{ $payableWriteOff['note'] }}
                    </td>
                </tr>
            </table>
            <hr>
            <div>
                <h3>付款清單</h3>
                <table class="payment" width="100%">
                    <thead>
                        <tr>
                            <th>付款日期</th>
                            <th>付款單號</th>
                            <th>付款方式</th>
                            <th>票據號碼</th>
                            <th>付款金額</th>
                        </tr>
                    </thead>
                    <tbody>
@if (count($payableWriteOffCredit) > 0)
    @foreach ($payableWriteOffCredit as $i => $value)
                        <tr>
                            <td>
                                {{ $payableWriteOffCredit[$i]->payment->pay_date }}
                            </td>
                            <td>
                                {{ $payableWriteOffCredit[$i]['credit_code'] }}
                            </td>
                            <td>
                                {{ $payableWriteOffCredit[$i]->payment->type == 'cash' ? '現金' : '票據' }}
                            </td>
                            <td>
                                {{ $payableWriteOffCredit[$i]->payment->check_code ?
                                    $payableWriteOffCredit[$i]->payment->check_code : '--'}}
                            </td>
                            <td>
                                {{ $payableWriteOffCredit[$i]['credit_amount'] }}
                            </td>
                        </tr>
    @endforeach
@endif
                    </tbody>
                </table>
            </div>
        <hr>
        <a href="{{ url("/payableWriteOffs/{$payableWriteOff->code}/edit") }}">維護付款單</a>
        <form action="{{ url("/payableWriteOffs/{$payableWriteOff->code}") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除付款單</button>
        </form>

@endsection
