@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@section('content')

        <script type="text/javascript" src="{{ asset('assets/js/AjaxCombobox.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/AjaxFetchDataByField.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bindDatePicker.js') }}"></script>
        <script type="text/javascript">
            $(function () {
                /**
                 * 綁定供應商名稱的自動完成
                 * @type {AjaxCombobox}
                 */

                $('.supplier_autocomplete').AjaxCombobox({
                    url: '/supplier/json',
                    afterSelect : function (event, ui) {
                        $('input.supplier_id').val(ui.item.id);
                        $('input.supplier_code').val(ui.item.code);
                    },
                    response : function (item) {
                        return {
                            label: item.shortName + ' - ' + item.name,
                            value: item.name,
                            id   : item.id,
                            code   : item.code,
                        }
                    }
                });
                $('.supplier_code').AjaxFetchDataByField({
                    url: '/supplier/json',
                    field_name : 'code',
                    triggered_by : $('.supplier_code'),
                    afterFetch : function (event, data) {
                        $('input.supplier_id').val(data[0].id);
                        $('input.supplier_autocomplete').val(data[0].name);
                    },
                    removeIfInvalid : function () {
                        $('input.supplier_id').val('');
                        $('input.supplier_autocomplete').val('');
                    }
                });
            });
        </script>
        <form action="{{ url("/payment/".$payment['code']) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
           <table id="master" width="100%">
                <tr>
                    <th>建立日期</th>
                    <td>{{ $PublicPresenter->getNewDate() }}</td>
                    <th>付款日期</th>
                    <td><input type="text" name="payment[pay_date]" class="datepicker" size="10" value="{{ $payment['pay_date'] }}"></td>
                </tr>
                <tr>
                    <th>是否沖銷</th>
                    <td>{{ $payment->isWrittenOff == 1 ? '是' : '否' }}</td>
                    <th>付款單號</th>
                    <td><input type="text" id="code" value="{{ $payment['code'] }}" readonly=""></td>

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
    @if ($payment->isWrittenOff == 0)
            <button type="submit" class="btn btn-default">確認送出</button>
        </form>
    @endif
@endsection