@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('WarehousePresenter', 'Warehouse\WarehousePresenter')
@section('content')
        <script type="text/javascript" src="{{ asset('assets/js/AjaxCombobox.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/AjaxFetchDataByField.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bindDatePicker.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/sale/saleReport.js') }}"></script>
        <form action=" {{ url("/saleReport/printing") }}" method="GET">
            {{ csrf_field() }}
            <table id="master" width="100%">
                <tr>
                    <th>開始日期</th>
                    <td><input type="text" class="start_date datepicker" name="saleReport[start_date]"
                            value="{{ $saleReport['start_date'] }}" size="10"></td>
                </tr>
                <tr>
                    <th>結束日期</th>
                    <td><input type="text" class="end_date datepicker" name="saleReport[end_date]"
                            value="{{ $saleReport['end_date'] }}" size="10"></td>
                </tr>
                <tr>
                    <th>客戶</th>
                    <td>
                        <input type="text" class="company_code" name="saleReport[company_code]" value="" size="10">
                        <input type="hidden" class="company_id" name="saleReport[company_id]" value="">
                        <input type="text" class="company_autocomplete" name="saleReport[company_name]" value="">
                    </td>
                </tr>
                <tr>
                    <th>料品</th>
                    <td>
                        <input type="text" class="stock_code" name="saleReport[stock_code]" value="" size="10">
                        <input type="hidden" class="stock_id" name="saleReport[stock_id]" value="">
                        <input type="text" class="stock_autocomplete" name="saleReport[company_name]" value="">
                    </td>
                </tr>
            </table>
            <button type="submit" class="btn btn-default">確認送出</button>
        </form>

@endsection