@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@section('content')

        <script type="text/javascript" src="{{ asset('assets/js/AjaxCombobox.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/WriteOffCalculator.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/sale/receivableWriteOff.js') }}"></script>
        <form action="{{ url("/receivableWriteOff/".$receivableWriteOff->code) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table id="master" width="100%">
                <tr>
                    <td>建立日期</td>
                    <td>{{ $PublicPresenter->getFormatDate($receivableWriteOff['created_at']) }}</td>
                    <td>沖銷單號</td>
                    <td>{{ $receivableWriteOff->code }}</td>
                </tr>
                <tr>
                    <th>客戶</th>
                    <td colspan="3">
                        <input type="hidden" name="receivableWriteOff[company_id]" class="company_id" value="{{ $receivableWriteOff['company_id'] }}"  size="10">
                        <input type="text" name="receivableWriteOff[company_code]" class="company_code" value="{{ $receivableWriteOff['company_code'] }}"  size="10" readonly="">
                        <input type="text" name="receivableWriteOff[company_name]" class="company_autocomplete" value="{{ $receivableWriteOff['company_name'] }}" readonly="">
                    </td>
                </tr>
                <tr>
                    <th>備註</th>
                    <td colspan="3">
                        <input type="text" name="receivableWriteOff[note]" value="{{ $receivableWriteOff['note'] }}" size="50">
                    </td>
                </tr>
            </table>
            <hr>
            <div>
                <h3>收款清單</h3>
                <table class="payment" width="100%">
                    <thead>
                        <tr>
                            <th>是否沖銷</th>
                            <th>收款日期</th>
                            <th>收款單號</th>
                            <th>收款方式</th>
                            <th>票據號碼</th>
                            <th>收款金額</th>
                        </tr>
                    </thead>
                    <tbody>
@if (count($receivableWriteOffCredit) > 0)
    @foreach ($receivableWriteOffCredit as $i => $value)
                        <tr>
                            <td>
                                <input class="credit_checked" type="checkbox"
                                    name="receivableWriteOffCredit[{{ $i }}][credit_checked]" value="1"
                                    onclick="writeOffCalculator.calculate();"
                                    {{ isset($receivableWriteOffCredit[$i]['credit_checked'])
                                        && $receivableWriteOffCredit[$i]['credit_checked'] == 1 ? 'checked' : ''}}>
                            </td>
                            <td>
                                {{ $receivableWriteOffCredit[$i]['credit_pay_date'] }}
                                <input type="hidden" name="receivableWriteOffCredit[{{ $i }}][credit_pay_date]"
                                    value="{{ $receivableWriteOffCredit[$i]['credit_pay_date'] }}">
                            </td>
                            <td>
                                {{ $receivableWriteOffCredit[$i]['credit_code'] }}
                                <input class="credit_code" type="hidden"
                                    name="receivableWriteOffCredit[{{ $i }}][credit_code]"
                                    value="{{ $receivableWriteOffCredit[$i]['credit_code'] }}">
                            </td>
                            <td>
                                {{ $receivableWriteOffCredit[$i]['credit_type'] == 'cash' ? '現金' : '票據'}}
                                <input type="hidden" name="receivableWriteOffCredit[{{ $i }}][credit_type]"
                                    value="{{ $receivableWriteOffCredit[$i]['credit_type'] }}">
                            </td>
                            <td>
                                {{ $receivableWriteOffCredit[$i]['credit_check_code'] ?
                                    $receivableWriteOffCredit[$i]['credit_check_code'] : '--'}}
                                <input type="hidden" name="receivableWriteOffCredit[{{ $i }}][credit_check_code]"
                                    value="{{ $receivableWriteOffCredit[$i]['credit_check_code'] }}">
                            </td>
                            <td class="numeric">
                                {{ $receivableWriteOffCredit[$i]['credit_amount'] }}
                                <input class="credit_amount" type="hidden"
                                    name="receivableWriteOffCredit[{{ $i }}][credit_amount]"
                                    value="{{ $receivableWriteOffCredit[$i]['credit_amount'] }}">
                            </td>
                        </tr>
    @endforeach
@endif
                    </tbody>
                    <tfoot>
                        <tr><td colspan="6">　</td></tr>
                        <tr>
                            <th colspan="5">
                                收款沖銷總額
                            </td>
                            <td>
                                <input type="text" class="total_credit_amount numeric"
                                    name="receivableWriteOff[total_credit_amount]" readonly="" size="10"
                                    value="{{
                                        //有被選取的才要計算沖銷總額
                                        $receivableWriteOffCredit->sum(function ($item){
                                            if (isset($item['credit_checked'])
                                                && $item['credit_checked'] == 1) {
                                                    return $item['credit_amount'];
                                            }
                                        })
                                    }}">
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!--<button class="autoWriteOff">自動沖帳</button>-->
            </div>
            <hr>
            <div>
                <h3>應收帳款</h3>
                <table class="receivable" width="100%">
                    <thead>
                        <tr>
                            <th>是否沖銷</th>
                            <th>開單日期</th>
                            <th>單號</th>
                            <th>發票號碼</th>
                            <th>單據總金額</th>
                            <th>未收款金額</th>
                            <th>沖銷金額</th>
                        </tr>
                    </thead>
                    <tbody>
@if (count($receivableWriteOffDebit) > 0)
    @foreach ($receivableWriteOffDebit as $i => $value)
                        <tr>
                            <td>
                                <input class="debit_checked" type="checkbox"
                                    onclick="fill_amount({{ $i }});writeOffCalculator.calculate();"
                                    name="receivableWriteOffDebit[{{ $i }}][debit_checked]" value="1"
                                    {{ isset($receivableWriteOffDebit[$i]['debit_checked'])
                                        && $receivableWriteOffDebit[$i]['debit_checked'] == 1 ? 'checked' : ''}}>
                            </td>
                            <td>
                                {{ $PublicPresenter->getFormatDate($receivableWriteOffDebit[$i]['debit_date']) }}
                                <input class="debit_type" type="hidden"
                                    name="receivableWriteOffDebit[{{ $i }}][debit_date]"
                                    value="{{ $PublicPresenter->getFormatDate($receivableWriteOffDebit[$i]['debit_date']) }}">
                            </td>
                            <td>
                                {{ $receivableWriteOffDebit[$i]['debit_type'] == "billsOfPurchase" ? '進' : '退' }}
                                {{ $receivableWriteOffDebit[$i]['debit_code'] }}
                                <input class="debit_type" type="hidden"
                                    name="receivableWriteOffDebit[{{ $i }}][debit_type]"
                                    value="{{ $receivableWriteOffDebit[$i]['debit_type'] }}">
                                <input class="debit_code" type="hidden"
                                    name="receivableWriteOffDebit[{{ $i }}][debit_code]"
                                    value="{{ $receivableWriteOffDebit[$i]['debit_code'] }}">
                            </td>
                            <td>
                                {{ $receivableWriteOffDebit[$i]['debit_invoice_code'] }}
                                <input type="hidden"
                                    name="receivableWriteOffDebit[{{ $i }}][debit_invoice_code]"
                                    value="{{ $receivableWriteOffDebit[$i]['debit_invoice_code'] }}">
                            </td>
                            <td class="numeric">{{ $receivableWriteOffDebit[$i]['debit_order_amount'] }}</td>
                            <td class="numeric">
                                {{ $receivableWriteOffDebit[$i]['debit_order_amount'] - $receivableWriteOffDebit[$i]['debit_paid_amount'] }}
                                <input type="hidden" class="debit_order_amount"
                                    name="receivableWriteOffDebit[{{ $i }}][debit_order_amount]"
                                    value="{{ $receivableWriteOffDebit[$i]['debit_order_amount'] }}">
                                <input type="hidden" class="debit_paid_amount"
                                    name="receivableWriteOffDebit[{{ $i }}][debit_paid_amount]"
                                    value="{{ $receivableWriteOffDebit[$i]['debit_paid_amount'] }}">
                            </td>
                            <td>
                                <input type="text" class="debit_amount numeric"
                                    onkeyup="writeOffCalculator.calculate();"
                                    name="receivableWriteOffDebit[{{ $i }}][debit_amount]" size="10"
                                    value="{{ $receivableWriteOffDebit[$i]['debit_amount'] }}">
                            </td>
                        </tr>
    @endforeach
@endif
                    </tbody>
                    <tfoot>
                        <tr><td colspan="7">　</td></tr>
                        <tr>
                            <th colspan="6">
                                應收帳款沖銷總額
                            </th>
                            <td>
                                <input type="text" class="total_debit_amount numeric"
                                    name="receivableWriteOff[total_debit_amount]" readonly="" size="10"
                                    value="{{
                                        //有被選取的才要計算沖銷總額
                                        $receivableWriteOffDebit->sum(function ($item){
                                            if (isset($item['debit_checked'])
                                                && $item['debit_checked'] == 1) {
                                                    return $item['debit_amount'];
                                            }
                                        })
                                    }}">
                            </td>
                        </tr>

                    </tfoot>
                </table>

            </div>
            <hr>
            <button type="submit" class="btn btn-default">確認送出</button>
        </form>

@endsection