@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('WarehousePresenter', 'Warehouse\WarehousePresenter')
@section('content')
        <script type="text/javascript" src="{{ asset('assets/js/stockManager/stockInOutReport.js') }}"></script>
        <form action=" {{ url("/stockInOutReport/printing") }}" method="GET" target="_blank">
            {{ csrf_field() }}
            <table id="master" width="100%">
                <tr>
                    <th>開始日期</th>
                    <td><input type="text" class="start_date datepicker" name="stockInOutReport[start_date]" 
                            value="{{ $stockInOutReport['start_date'] }}" size="10"></td>
                </tr>
                <tr>
                    <th>結束日期</th>
                    <td><input type="text" class="start_date datepicker" name="stockInOutReport[end_date]" 
                            value="{{ $stockInOutReport['end_date'] }}" size="10"></td>
                </tr>
                <tr>
                    <th>倉庫</th>
                    <td colspan="3">
                        <select name="stockInOutReport[warehouse_id]">
                            <option></option>
                            {!! $WarehousePresenter->renderOptions($stockInOutReport['warehouse_id']) !!}
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>品名</th>
                    <td>
                        <input type="text" class="stock_code" name="stockInOutReport[stock_code]" value="" size="10">
                        <input type="hidden" class="stock_id" name="stockInOutReport[stock_id]" value="">
                        <input type="text" class="stock_autocomplete" name="stockInOutReport[stock_name]" value="">
                    </td>
                </tr>
            </table>
            <button type="submit" class="btn btn-default">確認送出</button>
        </form>

@endsection