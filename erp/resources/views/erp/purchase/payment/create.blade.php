@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@section('content')
        <script type="text/javascript" src="{{ asset('assets/js/purchase/bindSupplierAutocomplete.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bindDatePicker.js') }}"></script>
        <script type="text/javascript">
            //供應商自動完成所需資訊
            var supplier_url = '/supplier/json';
            var triggered_by = {
                autocomplete: 'input.supplier_autocomplete',
                scan: 'input.supplier_code'
            };
            var auto_fill = {
                id: 'input.supplier_id',
                code :'input.supplier_code',
                name : 'input.supplier_autocomplete'
            };
            var after_triggering = {
                scan: function () {
                    if ($('input.stock_code:first').length > 0) {
                        $('input.stock_code:first').focus();
                    }
                }
            };
            var supplierAutocompleter = new SupplierAutocompleter(supplier_url, triggered_by, auto_fill, after_triggering);
            $(function () {
                supplierAutocompleter.eventBind();
            });
        </script>
        <form action=" {{ url("/payment") }}" method="POST">
            {{ csrf_field() }}
            <table id="master" width="100%">
                <tr>
                    <td>建立日期</td>
                    <td>{{ $PublicPresenter->getNewDate() }}</td>
                    <td>付款日期</td>
                    <td><input type="text" name="payment[pay_date]" class="datepicker" size="10" value="{{ $payment['pay_date'] }}"></td>
                    <td>付款單號</td>
                    <td><input type="text" id="code" value="{{ $new_master_code }}" readonly=""></td>
                </tr>
                <tr>
                    <th>供應商</th>
                    <td colspan="5">
                        <input type="hidden" name="payment[supplier_id]" class="supplier_id" value="{{ $payment['supplier_id'] }}"  size="10">
                        <input type="text" name="payment[supplier_code]" class="supplier_code" value="{{ $payment['supplier_code'] }}"  size="10">
                        <input type="text" name="payment[supplier_name]" class="supplier_autocomplete" value="{{ $payment['supplier_name'] }}">
                    </td>
                </tr>
                <tr>
                    <th>付款方式</th>
                    <td colspan="5">
                        <input type="radio" name="payment[type]" value="cash"
                            onclick="$('div#check_contents').find('input').attr('disabled', true);"
                            {{ $payment['type'] == "cash" || $payment['type'] == '' ? 'checked=""' : ''}}>現金
                        <input type="radio" name="payment[type]" value="check"
                            onclick="$('div#check_contents').find('input').attr('disabled', false);"
                            {{ $payment['type'] == "check" ? 'checked=""' : ''}}>票據
                    </td>
                </tr>
                <tr>
                    <th>付款單備註</th>
                    <td colspan="5">
                        <input type="text" name="payment[note]" id="master_note" value="{{ $payment['note'] }}" size="50">
                    </td>
                </tr>
            </table>
            <hr>
            <div id="check_contents">
                <table width="100%">
                    <tr>
                        <td>票據號碼</td>
                        <td>
                            <input type="text" name="payment[check_code]"
                                {{ $payment['type'] == "cash" || $payment['type'] == '' ? 'disabled=""' : ''}}
                                value="{{ isset($payment['check_code']) ? $payment['check_code'] : '' }}">
                        </td>
                    </tr>
                    <tr>
                        <td>到期日</td>
                        <td>
                            <input type="text" class="datepicker" name="payment[expiry_date]" size="10"
                                {{ $payment['type'] == "cash" || $payment['type'] == '' ? 'disabled=""' : ''}}
                                value="{{ isset($payment['expiry_date']) ? $payment['expiry_date'] : '' }}">
                        </td>
                    </tr>
                    <tr>
                        <td>銀行帳號</td>
                        <td>
                            <input type="text" name="payment[bank_account]"
                                {{ $payment['type'] == "cash" || $payment['type'] == '' ? 'disabled=""' : '' }}
                                value="{{ isset($payment['bank_account']) ? $payment['bank_account'] : '' }}">
                        </td>
                    </tr>
                </table>
            </div>
            <div>
                <table width="100%">
                    <tr>
                        <td>付款金額</td>
                        <td>
                            <input type="text" name="payment[amount]" style="text-align:right;"
                                value="{{ $payment['amount'] }}">
                        </td>
                    </tr>
                </table>
            </div>
            <hr>
            <button type="submit">確認送出</button>
        </form>

@endsection