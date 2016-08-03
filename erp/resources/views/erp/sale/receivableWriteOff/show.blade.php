@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@section('content')
            <table id="master" width="100%">
                <tr>
                    <th>建立日期</th>
                    <td>{{ $PublicPresenter->getFormatDate($receivableWriteOff->created_at) }}</td>
                    <th>沖銷單號</th>
                    <td>{{ $receivableWriteOff->code }}</td>
                </tr>
                <tr>
                    <th>客戶</th>
                    <td colspan="3">
                        {{ $receivableWriteOff->company->company_code }}
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
                            <th class="string">收款日期</th>
                            <th class="string">收款單號</th>
                            <th class="string">收款方式</th>
                            <th class="string">票據號碼</th>
                            <th class="numeric">收款金額</th>
                        </tr>
                    </thead>
                    <tbody>
@if (count($receivableWriteOffDebit) > 0)
    @foreach ($receivableWriteOffDebit as $i => $value)
                        <tr>
                            <td class="string">
                                {{ $value->receipt->receive_date }}
                            </td>
                            <td class="string">
                                {{ $value->debit_code }}
                            </td>
                            <td class="string">
                                {{ $value->receipt->type == 'cash' ? '現金' : '票據' }}
                            </td>
                            <td class="string">
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
                            <th class="string">開單日期</th>
                            <th class="string">單號</th>
                            <th class="string">發票號碼</th>
                            <th class="numeric">單據總金額</th>
                            <th class="numeric">未收款金額</th>
                            <th class="numeric">沖銷金額</th>
                        </tr>
                    </thead>
                    <tbody>
@if (count($receivableWriteOffCredit) > 0)
    @foreach ($receivableWriteOffCredit as $i => $value)
                        <tr>
                            <td class="string">
                                {{ $PublicPresenter->getFormatDate($value->{$value->credit_type}->created_at) }}
                            </td>
                            <td class="string">
                                {{ $value->credit_type == "billOfSale" ? '進' : '退' }}
                                {{ $value->credit_code }}
                            </td>
                            <td class="string">
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
        {{-- <a href="{{ url("/receivableWriteOff/{$receivableWriteOff->code}/edit") }}" class="btn btn-default">維護應收帳款沖銷單</a> --}}
        <form action="{{ url("/receivableWriteOff/{$receivableWriteOff->code}") }}" class="form_of_delete" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button class="btn btn-danger">刪除應收帳款沖銷單</button>
        </form>

@endsection
