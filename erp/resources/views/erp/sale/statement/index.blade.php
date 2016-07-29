@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('WarehousePresenter', 'Warehouse\WarehousePresenter')
@section('content')
        <script type="text/javascript" src="{{ asset('assets/js/AjaxCombobox.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/AjaxFetchDataByField.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bindDatePicker.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/sale/statement.js') }}"></script>
        <form action=" {{ url("/statement/printing") }}" method="GET">
            {{ csrf_field() }}
            <table id="master" width="100%">
                <tr>
                    <th>開始日期</th>
                    <td><input type="text" class="start_date datepicker" name="statement[start_date]"
                            value="{{ $statement['start_date'] }}" size="10"></td>
                </tr>
                <tr>
                    <th>結束日期</th>
                    <td><input type="text" class="end_date datepicker" name="statement[end_date]"
                            value="{{ $statement['end_date'] }}" size="10"></td>
                </tr>
                <tr>
                    <th>客戶</th>
                    <td>
                        <input type="text" class="company_code" name="statement[company_code]" value="" size="10">
                        <input type="hidden" class="company_id" name="statement[company_id]" value="">
                        <input type="text" class="company_autocomplete" name="statement[company_name]" value="">
                    </td>
                </tr>
            </table>
            <button type="submit">確認送出</button>
        </form>

@endsection