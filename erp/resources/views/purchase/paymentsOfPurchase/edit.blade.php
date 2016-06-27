@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@section('content')

        <script type="text/javascript" src="{{ asset('assets/js/bindSupplierAutocomplete.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bindDatePicker.js') }}"></script>
        <form action="{{ url("/paymentsOfPurchase/".$paymentOfPurchase['code']) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
           <table id="master" width="100%">
                <tr>
                    <td>建立日期</td>
                    <td>{{ $PublicPresenter->getNewDate() }}</td>
                    <td>付款日期</td>
                    <td><input type="text" name="paymentOfPurchase[pay_date]" class="datepicker" size="10" value="{{ $paymentOfPurchase['pay_date'] }}"></td>
                    <td>付款單號</td>
                    <td><input type="text" id="code" value="{{ $paymentOfPurchase['code'] }}" readonly=""></td>
                </tr>
                <tr>
                    <th>供應商</th>
                    <td colspan="5">
                        <input type="hidden" name="paymentOfPurchase[supplier_id]" class="supplier_id" value="{{ $paymentOfPurchase['supplier_id'] }}"  size="10">
                        <input type="text" name="paymentOfPurchase[supplier_code]" class="supplier_code" value="{{ $paymentOfPurchase['supplier_code'] }}"  size="10">
                        <input type="text" name="paymentOfPurchase[supplier_name]" class="supplier_autocomplete" value="{{ $paymentOfPurchase['supplier_name'] }}">
                    </td>
                </tr>
                <tr>
                    <th>付款方式</th>
                    <td colspan="5">
                        <input type="radio" name="paymentOfPurchase[type]" value="cash"
                            onclick="$('div#check_contents').find('input').attr('disabled', true);"
                            {{ $paymentOfPurchase['type'] == "cash" || $paymentOfPurchase['type'] == '' ? 'checked=""' : ''}}>現金
                        <input type="radio" name="paymentOfPurchase[type]" value="check"
                            onclick="$('div#check_contents').find('input').attr('disabled', false);"
                            {{ $paymentOfPurchase['type'] == "check" ? 'checked=""' : ''}}>票據
                    </td>
                </tr>
                <tr>
                    <th>付款單備註</th>
                    <td colspan="5">
                        <input type="text" name="paymentOfPurchase[note]" id="master_note" value="{{ $paymentOfPurchase['note'] }}" size="50">
                    </td>
                </tr>
            </table>
            <hr>
            <div id="check_contents">
                <table width="100%">
                    <tr>
                        <td>票據號碼</td>
                        <td>
                            <input type="text" name="paymentOfPurchase[check_code]"
                                {{ $paymentOfPurchase['type'] == "cash" || $paymentOfPurchase['type'] == '' ? 'disabled=""' : ''}}
                                value="{{ isset($paymentOfPurchase['check_code']) ? $paymentOfPurchase['check_code'] : '' }}">
                        </td>
                    </tr>
                    <tr>
                        <td>到期日</td>
                        <td>
                            <input type="text" class="datepicker" name="paymentOfPurchase[expiry_date]" size="10"
                                {{ $paymentOfPurchase['type'] == "cash" || $paymentOfPurchase['type'] == '' ? 'disabled=""' : ''}}
                                value="{{ isset($paymentOfPurchase['expiry_date']) ? $paymentOfPurchase['expiry_date'] : '' }}">
                        </td>
                    </tr>
                    <tr>
                        <td>銀行帳號</td>
                        <td>
                            <input type="text" name="paymentOfPurchase[bank_account]"
                                {{ $paymentOfPurchase['type'] == "cash" || $paymentOfPurchase['type'] == '' ? 'disabled=""' : '' }}
                                value="{{ isset($paymentOfPurchase['bank_account']) ? $paymentOfPurchase['bank_account'] : '' }}">
                        </td>
                    </tr>
                </table>
            </div>
            <div>
                <table width="100%">
                    <tr>
                        <td>付款金額</td>
                        <td>
                            <input type="text" name="paymentOfPurchase[amount]" style="text-align:right;"
                                value="{{ $paymentOfPurchase['amount'] }}">
                        </td>
                    </tr>
                </table>
            </div>
            <hr>
            <button type="submit">確認送出</button>
        </form>

@endsection