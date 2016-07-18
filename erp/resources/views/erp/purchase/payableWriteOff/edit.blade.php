@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@section('content')

        <script type="text/javascript" src="{{ asset('assets/js/purchase/bindSupplierAutocomplete.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/WriteOffCalculator.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/purchase/payableWriteOff.js') }}"></script>
        <form action="{{ url("/payableWriteOff/".$payableWriteOff->code) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table id="master" width="100%">
                <tr>
                    <td>建立日期</td>
                    <td>{{ $PublicPresenter->getFormatDate($payableWriteOff['created_at']) }}</td>
                    <td>沖銷單號</td>
                    <td>{{ $payableWriteOff->code }}</td>
                </tr>
                <tr>
                    <th>供應商</th>
                    <td colspan="3">
                        <input type="hidden" name="payableWriteOff[supplier_id]" class="supplier_id" value="{{ $payableWriteOff['supplier_id'] }}"  size="10">
                        <input type="text" name="payableWriteOff[supplier_code]" class="supplier_code" value="{{ $payableWriteOff['supplier_code'] }}"  size="10" readonly="">
                        <input type="text" name="payableWriteOff[supplier_name]" class="supplier_autocomplete" value="{{ $payableWriteOff['supplier_name'] }}" readonly="">
                    </td>
                </tr>
                <tr>
                    <th>備註</th>
                    <td colspan="3">
                        <input type="text" name="payableWriteOff[note]" value="{{ $payableWriteOff['note'] }}" size="50">
                    </td>
                </tr>
            </table>
            <hr>
            <div>
                <h3>付款清單</h3>
                <table class="payment" width="100%">
                    <thead>
                        <tr>
                            <th>是否沖銷</th>
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
                                <input class="credit_checked" type="checkbox"
                                    name="payableWriteOffCredit[{{ $i }}][credit_checked]" value="1"
                                    onclick="writeOffCalculator.calculate();"
                                    {{ isset($payableWriteOffCredit[$i]['credit_checked'])
                                        && $payableWriteOffCredit[$i]['credit_checked'] == 1 ? 'checked' : ''}}>
                            </td>
                            <td>
                                {{ $payableWriteOffCredit[$i]['credit_pay_date'] }}
                                <input type="hidden" name="payableWriteOffCredit[{{ $i }}][credit_pay_date]"
                                    value="{{ $payableWriteOffCredit[$i]['credit_pay_date'] }}">
                            </td>
                            <td>
                                {{ $payableWriteOffCredit[$i]['credit_code'] }}
                                <input class="credit_code" type="hidden"
                                    name="payableWriteOffCredit[{{ $i }}][credit_code]"
                                    value="{{ $payableWriteOffCredit[$i]['credit_code'] }}">
                            </td>
                            <td>
                                {{ $payableWriteOffCredit[$i]['credit_type'] == 'cash' ? '現金' : '票據'}}
                                <input type="hidden" name="payableWriteOffCredit[{{ $i }}][credit_type]"
                                    value="{{ $payableWriteOffCredit[$i]['credit_type'] }}">
                            </td>
                            <td>
                                {{ $payableWriteOffCredit[$i]['credit_check_code'] ?
                                    $payableWriteOffCredit[$i]['credit_check_code'] : '--'}}
                                <input type="hidden" name="payableWriteOffCredit[{{ $i }}][credit_check_code]"
                                    value="{{ $payableWriteOffCredit[$i]['credit_check_code'] }}">
                            </td>
                            <td class="numeric">
                                {{ $payableWriteOffCredit[$i]['credit_amount'] }}
                                <input class="credit_amount" type="hidden"
                                    name="payableWriteOffCredit[{{ $i }}][credit_amount]"
                                    value="{{ $payableWriteOffCredit[$i]['credit_amount'] }}">
                            </td>
                        </tr>
    @endforeach
@endif
                    </tbody>
                    <tfoot>
                        <tr><td colspan="6">　</td></tr>
                        <tr>
                            <th colspan="5">
                                付款沖銷總額
                            </td>
                            <td>
                                <input type="text" class="total_credit_amount numeric"
                                    name="payableWriteOff[total_credit_amount]" readonly="" size="10"
                                    value="{{
                                        //有被選取的才要計算沖銷總額
                                        $payableWriteOffCredit->sum(function ($item){
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
                <h3>應付帳款</h3>
                <table class="payable" width="100%">
                    <thead>
                        <tr>
                            <th>是否沖銷</th>
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
                                <input class="debit_checked" type="checkbox"
                                    onclick="fill_amount({{ $i }});writeOffCalculator.calculate();"
                                    name="payableWriteOffDebit[{{ $i }}][debit_checked]" value="1"
                                    {{ isset($payableWriteOffDebit[$i]['debit_checked'])
                                        && $payableWriteOffDebit[$i]['debit_checked'] == 1 ? 'checked' : ''}}>
                            </td>
                            <td>
                                {{ $PublicPresenter->getFormatDate($payableWriteOffDebit[$i]['debit_date']) }}
                                <input class="debit_type" type="hidden"
                                    name="payableWriteOffDebit[{{ $i }}][debit_date]"
                                    value="{{ $PublicPresenter->getFormatDate($payableWriteOffDebit[$i]['debit_date']) }}">
                            </td>
                            <td>
                                {{ $payableWriteOffDebit[$i]['debit_type'] == "billOfPurchase" ? '進' : '退' }}
                                {{ $payableWriteOffDebit[$i]['debit_code'] }}
                                <input class="debit_type" type="hidden"
                                    name="payableWriteOffDebit[{{ $i }}][debit_type]"
                                    value="{{ $payableWriteOffDebit[$i]['debit_type'] }}">
                                <input class="debit_code" type="hidden"
                                    name="payableWriteOffDebit[{{ $i }}][debit_code]"
                                    value="{{ $payableWriteOffDebit[$i]['debit_code'] }}">
                            </td>
                            <td>
                                {{ $payableWriteOffDebit[$i]['debit_invoice_code'] }}
                                <input type="hidden"
                                    name="payableWriteOffDebit[{{ $i }}][debit_invoice_code]"
                                    value="{{ $payableWriteOffDebit[$i]['debit_invoice_code'] }}">
                            </td>
                            <td class="numeric">{{ $payableWriteOffDebit[$i]['debit_order_amount'] }}</td>
                            <td class="numeric">
                                {{ $payableWriteOffDebit[$i]['debit_order_amount'] - $payableWriteOffDebit[$i]['debit_paid_amount'] }}
                                <input type="hidden" class="debit_order_amount"
                                    name="payableWriteOffDebit[{{ $i }}][debit_order_amount]"
                                    value="{{ $payableWriteOffDebit[$i]['debit_order_amount'] }}">
                                <input type="hidden" class="debit_paid_amount"
                                    name="payableWriteOffDebit[{{ $i }}][debit_paid_amount]"
                                    value="{{ $payableWriteOffDebit[$i]['debit_paid_amount'] }}">
                            </td>
                            <td>
                                <input type="text" class="debit_amount numeric"
                                    onkeyup="writeOffCalculator.calculate();"
                                    name="payableWriteOffDebit[{{ $i }}][debit_amount]" size="10"
                                    value="{{ $payableWriteOffDebit[$i]['debit_amount'] }}">
                            </td>
                        </tr>
    @endforeach
@endif
                    </tbody>
                    <tfoot>
                        <tr><td colspan="7">　</td></tr>
                        <tr>
                            <th colspan="6">
                                應付帳款沖銷總額
                            </th>
                            <td>
                                <input type="text" class="total_debit_amount numeric"
                                    name="payableWriteOff[total_debit_amount]" readonly="" size="10"
                                    value="{{
                                        //有被選取的才要計算沖銷總額
                                        $payableWriteOffDebit->sum(function ($item){
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
            <button type="submit">確認送出</button>
        </form>

@endsection