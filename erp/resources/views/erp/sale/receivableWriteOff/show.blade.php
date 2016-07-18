@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@section('content')
            <table id="master" width="100%">
                <tr>
                    <td>建立日期</td>
                    <td>{{ $PublicPresenter->getFormatDate($receivableWriteOff->created_at) }}</td>
                    <td>沖銷單號</td>
                    <td>{{ $receivableWriteOff->code }}</td>
                </tr>
                <tr>
                    <th>客戶</th>
                    <td colspan="3">
                        {{-- {{ $receivableWriteOff->company->code }} --}}
                        {{ $receivableWriteOff->company->company_name }}
                    </td>
                </tr>
                <tr>
                    <th>備註</th>
                    <td colspan="3">
                        {{ $receivableWriteOff['note'] }}
                    </td>
                </tr>
            </table>
            <hr>
            <div>
                <h3>收款清單</h3>
                <table class="receipt" width="100%">
                    <thead>
                        <tr>
                            <th>收款日期</th>
                            <th>收款單號</th>
                            <th>收款方式</th>
                            <th>票據號碼</th>
                            <th>收款金額</th>
                        </tr>
                    </thead>
                    <tbody>
@if (count($receivableWriteOffDebit) > 0)
    @foreach ($receivableWriteOffDebit as $i => $value)
                        <tr>
                            <td>
                                {{ $value->receipt->receive_date }}
                            </td>
                            <td>
                                {{ $value->debit_code }}
                            </td>
                            <td>
                                {{ $value->receipt->type == 'cash' ? '現金' : '票據' }}
                            </td>
                            <td>
                                {{ $value->receipt->check_code ?
                                    $value->receipt->check_code : '--'}}
                            </td>
                            <td class="numeric">
                                {{ $value->debit_amount }}
                            </td>
                        </tr>
    @endforeach
@endif
                    </tbody>
                    <tfoot>
                        <tr><td colspan="5">　</td></tr>
                        <tr>
                            <td colspan="4" style="text-align:center">
                                <label>收款沖銷總額</label>
                            </td>
                            <td class="numeric">
                                {{ $receivableWriteOffDebit->sum('debit_amount') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <hr>
            <div>
                <h3>應收帳款</h3>
                <table class="receivable" width="100%">
                    <thead>
                        <tr>
                            <th>開單日期</th>
                            <th>單號</th>
                            <th>發票號碼</th>
                            <th>單據總金額</th>
                            <th>未收款金額</th>
                            <th>沖銷金額</th>
                        </tr>
                    </thead>
                    <tbody>
@if (count($receivableWriteOffCredit) > 0)
    @foreach ($receivableWriteOffCredit as $i => $value)
                        <tr>
                            <td>
                                {{ $PublicPresenter->getFormatDate($value->{$value->credit_type}->created_at) }}
                            </td>
                            <td>
                                {{ $value->credit_type == "billOfSale" ? '進' : '退' }}
                                {{ $value->credit_code }}
                            </td>
                            <td>
                                {{ $value->{$value->credit_type}->invoice_code }}
                            </td>
                            <td class="numeric">{{ $value->{$value->credit_type}->total_amount }}</td>
                            <td class="numeric">
                                {{ $value->{$value->credit_type}->total_amount - $value->{$value->credit_type}->received_amount }}
                            </td>
                            <td class="numeric">
                                {{ $value->credit_amount }}
                            </td>
                        </tr>
    @endforeach
@endif
                    </tbody>
                    <tfoot>
                        <tr><td colspan="6">　</td></tr>
                        <tr>
                            <td colspan="5" style="text-align:center">
                                <label>應收帳款沖銷總額</label>
                            </td>
                            <td class="numeric">
                                {{ $receivableWriteOffCredit->sum('credit_amount') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        {{-- <a href="{{ url("/receivableWriteOff/{$receivableWriteOff->code}/edit") }}">維護應收帳款沖銷單</a> --}}
        <form action="{{ url("/receivableWriteOff/{$receivableWriteOff->code}") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除應收帳款沖銷單</button>
        </form>

@endsection
