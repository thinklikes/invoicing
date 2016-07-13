@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@section('content')
            <table id="master" width="100%">
                <tr>
                    <td>建立日期</td>
                    <td>{{ $PublicPresenter->getFormatDate($payableWriteOff->created_at) }}</td>
                    <td>沖銷單號</td>
                    <td>{{ $payableWriteOff->code }}</td>
                </tr>
                <tr>
                    <th>供應商</th>
                    <td colspan="3">
                        {{ $payableWriteOff->supplier->code }}
                        {{ $payableWriteOff->supplier->name }}
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
                                {{ $value->payment->pay_date }}
                            </td>
                            <td>
                                {{ $value->credit_code }}
                            </td>
                            <td>
                                {{ $value->payment->type == 'cash' ? '現金' : '票據' }}
                            </td>
                            <td>
                                {{ $value->payment->check_code ?
                                    $value->payment->check_code : '--'}}
                            </td>
                            <td class="numeric">
                                {{ $value->credit_amount }}
                            </td>
                        </tr>
    @endforeach
@endif
                    </tbody>
                    <tfoot>
                        <tr><td colspan="5">　</td></tr>
                        <tr>
                            <td colspan="4" style="text-align:center">
                                <label>付款沖銷總額</label>
                            </td>
                            <td class="numeric">
                                {{ $payableWriteOffCredit->sum('credit_amount') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <hr>
            <div>
                <h3>應付帳款</h3>
                <table class="payable" width="100%">
                    <thead>
                        <tr>
                            <th>開單日期</th>
                            <th>單號</th>
                            <th>發票號碼</th>
                            <th>單據總金額</th>
                            <th>未付清金額</th>
                            <th>沖銷金額</th>
                        </tr>
                    </thead>
                    <tbody>
@if (count($payableWriteOffDebit) > 0)
    @foreach ($payableWriteOffDebit as $i => $value)
                        <tr>
                            <td>
                                {{ $PublicPresenter->getFormatDate($value->{$value->debit_type}->created_at) }}
                            </td>
                            <td>
                                {{ $value->debit_type == "billsOfPurchase" ? '進' : '退' }}
                                {{ $value->debit_code }}
                            </td>
                            <td>
                                {{ $value->{$value->debit_type}->invoice_code }}
                            </td>
                            <td class="numeric">{{ $value->{$value->debit_type}->total_amount }}</td>
                            <td class="numeric">
                                {{ $value->{$value->debit_type}->total_amount - $value->{$value->debit_type}->paid_amount }}
                            </td>
                            <td class="numeric">
                                {{ $value->debit_amount }}
                            </td>
                        </tr>
    @endforeach
@endif
                    </tbody>
                    <tfoot>
                        <tr><td colspan="6">　</td></tr>
                        <tr>
                            <td colspan="5" style="text-align:center">
                                <label>應付帳款沖銷總額</label>
                            </td>
                            <td class="numeric">
                                {{ $payableWriteOffDebit->sum('debit_amount') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        {{-- <a href="{{ url("/payableWriteOff/{$payableWriteOff->code}/edit") }}">維護應付帳款沖銷單</a> --}}
        <form action="{{ url("/payableWriteOff/{$payableWriteOff->code}") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除應付帳款沖銷單</button>
        </form>

@endsection
