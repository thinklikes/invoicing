@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@section('content')
        <script type="text/javascript" src="{{ asset('assets/js/AjaxCombobox.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/AjaxFetchDataByField.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bindDatePicker.js') }}"></script>
        <script type="text/javascript">
            $(function () {
                /**
                 * 綁定客戶名稱自動完成的事件
                 * @type {AjaxCombobox}
                 */
                $('.company_autocomplete').AjaxCombobox({
                    url: company_json_url,
                    afterSelect : function (event, ui) {
                        $('input.company_id').val(ui.item.id);
                        $('input.company_code').val(ui.item.code);
                    },
                    response : function (item) {
                        return {
                            label: item.company_abb + ' - ' + item.company_name,
                            value: item.company_name,
                            id   : item.auto_id,
                            code : item.company_code,
                        }
                    }
                });
                $('.company_code').AjaxFetchDataByField({
                    url: company_json_url,
                    field_name : 'code',
                    afterFetch : function (event, data) {
                        $('input.company_id').val(data[0].auto_id);
                        $('input.company_autocomplete').val(data[0].company_name);
                    },
                    removeIfInvalid : function () {
                        $('input.company_id').val('');
                        $('input.company_autocomplete').val('');
                    }
                });
            });
        </script>
        <form action=" {{ url("/receipt") }}" method="POST">
            {{ csrf_field() }}
            <table id="master" width="100%">
                <tr>
                    <td>建立日期</td>
                    <td>{{ $PublicPresenter->getNewDate() }}</td>
                    <td>收款日期</td>
                    <td><input type="text" name="receipt[receive_date]" class="datepicker" size="10" value="{{ $receipt['receive_date'] }}"></td>
                    <td>收款單號</td>
                    <td><input type="text" id="code" value="{{ $new_master_code }}" readonly=""></td>
                </tr>
                <tr>
                    <th>客戶</th>
                    <td colspan="5">
                        <input type="hidden" name="receipt[company_id]" class="company_id" value="{{ $receipt['company_id'] }}"  size="10">
                        <input type="text" name="receipt[company_code]" class="company_code" value="{{ $receipt['company_code'] }}"  size="10">
                        <input type="text" name="receipt[company_name]" class="company_autocomplete" value="{{ $receipt['company_name'] }}">
                    </td>
                </tr>
                <tr>
                    <th>收款方式</th>
                    <td colspan="5">
                        <input type="radio" name="receipt[type]" value="cash"
                            onclick="$('div#check_contents').find('input').attr('disabled', true);"
                            {{ $receipt['type'] == "cash" || $receipt['type'] == '' ? 'checked=""' : ''}}>現金
                        <input type="radio" name="receipt[type]" value="check"
                            onclick="$('div#check_contents').find('input').attr('disabled', false);"
                            {{ $receipt['type'] == "check" ? 'checked=""' : ''}}>票據
                    </td>
                </tr>
                <tr>
                    <th>收款單備註</th>
                    <td colspan="5">
                        <input type="text" name="receipt[note]" id="master_note" value="{{ $receipt['note'] }}" size="50">
                    </td>
                </tr>
            </table>
            <hr>
            <div id="check_contents">
                <table width="100%">
                    <tr>
                        <td>票據號碼</td>
                        <td>
                            <input type="text" name="receipt[check_code]"
                                {{ $receipt['type'] == "cash" || $receipt['type'] == '' ? 'disabled=""' : ''}}
                                value="{{ isset($receipt['check_code']) ? $receipt['check_code'] : '' }}">
                        </td>
                    </tr>
                    <tr>
                        <td>到期日</td>
                        <td>
                            <input type="text" class="datepicker" name="receipt[expiry_date]" size="10"
                                {{ $receipt['type'] == "cash" || $receipt['type'] == '' ? 'disabled=""' : ''}}
                                value="{{ isset($receipt['expiry_date']) ? $receipt['expiry_date'] : '' }}">
                        </td>
                    </tr>
                    <tr>
                        <td>銀行帳號</td>
                        <td>
                            <input type="text" name="receipt[bank_account]"
                                {{ $receipt['type'] == "cash" || $receipt['type'] == '' ? 'disabled=""' : '' }}
                                value="{{ isset($receipt['bank_account']) ? $receipt['bank_account'] : '' }}">
                        </td>
                    </tr>
                </table>
            </div>
            <div>
                <table width="100%">
                    <tr>
                        <td>收款金額</td>
                        <td>
                            <input type="text" name="receipt[amount]" style="text-align:right;"
                                value="{{ $receipt['amount'] }}">
                        </td>
                    </tr>
                </table>
            </div>
            <hr>
            <button type="submit" class="btn btn-default">確認送出</button>
        </form>

@endsection