@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('WarehousePresenter', 'Warehouse\WarehousePresenter')
@section('content')
        <script type="text/javascript">
            var app_name     = 'stockTransfer';

            var _tax_rate       = {{ Config::get('system_configs')['purchase_tax_rate'] }};
            var _quantity_round_off      = {{ Config::get('system_configs')['quantity_round_off'] }};
            var _no_tax_price_round_off  = {{ Config::get('system_configs')['no_tax_price_round_off'] }};
            var _no_tax_amount_round_off = {{ Config::get('system_configs')['no_tax_amount_round_off'] }};
            var _tax_round_off           = {{ Config::get('system_configs')['tax_round_off'] }};
            var _total_amount_round_off  = {{ Config::get('system_configs')['total_amount_round_off'] }};
        </script>
        <script type="text/javascript" src="{{ asset('assets/js/OrderCalculator.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/AjaxCombobox.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/AjaxFetchDataByField.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/stockManager/stockTransfer.js') }}"></script>
        <form action=" {{ url("/stockTransfer") }}" method="POST">
            {{ csrf_field() }}
            <table id="master" width="100%">
                <tr>
                    <td>轉倉日期</td>
                    <td>{{ $PublicPresenter->getNewDate() }}</td>
                    <td>轉倉單號</td>
                    <td><input type="text" id="master_code" value="{{ $new_master_code }}" readonly=""></td>
                </tr>
                <tr>
                    <th>轉倉單備註</th>
                    <td colspan="3">
                        <input type="text" name="stockTransferMaster[note]" id="master_note" value="{{ $stockTransferMaster['note'] }}" size="50">
                    </td>
                </tr>
               <tr>
                    <th>調出倉庫</th>
                    <td>
                        <select name="stockTransferMaster[from_warehouse_id]">
                            <option></option>
                            {!! $WarehousePresenter->renderOptions($stockTransferMaster['from_warehouse_id']) !!}
                        </select>
                    </td>
                    <th>調入倉庫</th>
                    <td>
                        <select name="stockTransferMaster[to_warehouse_id]">
                            <option></option>
                            {!! $WarehousePresenter->renderOptions($stockTransferMaster['to_warehouse_id']) !!}
                        </select>
                    </td>
                </tr>
            </table>
            <hr>
            <button type="button" id="add_a_row">增加一列</button>
            <table id="detail" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>料品編號</th>
                        <th>品名</th>
                        <th>數量</th>
                        <th>單位</th>
                        <th>成本</th>
                        <th>金額</th>
                    </tr>
                </thead>
                <tbody>
    @if (count($stockTransferDetail) > 0)
        @foreach ($stockTransferDetail as $i => $value)
                    <tr>
                        <td>
                            <button type="button" class="remove_button"><i class="fa fa-remove"></i></button>
                        </td>
                        <td>
                            <input type="text" class="stock_code" name="stockTransferDetail[{{ $i }}][stock_code]" value="{{ $stockTransferDetail[$i]['stock_code'] }}" size="10">
                            <input type="hidden" class="stock_id" name="stockTransferDetail[{{ $i }}][stock_id]" value="{{ $stockTransferDetail[$i]['stock_id'] }}">
                        </td>
                        <td>
                            <input type="text" class="stock_autocomplete" name="stockTransferDetail[{{ $i }}][stock_name]" value="{{ $stockTransferDetail[$i]['stock_name'] }}">
                        </td>
                        <td><input type="text" class="stock_quantity" name="stockTransferDetail[{{ $i }}][quantity]" onkeyup="calculator.calculate();" value="{{ $stockTransferDetail[$i]['quantity'] }}" style="text-align:right;" size="5"></td>
                        <td><input type="text" class="stock_unit" name="stockTransferDetail[{{ $i }}][unit]" value="{{ $stockTransferDetail[$i]['unit'] }}" readonly="" size="5"></td>
                        <td><input type="text" class="stock_no_tax_price" name="stockTransferDetail[{{ $i }}][no_tax_price]" onkeyup="calculator.calculate();" value="{{ $stockTransferDetail[$i]['no_tax_price'] }}" style="text-align:right;" size="10"></td>
                        <td><input type="text" class="stock_no_tax_amount" style="text-align:right;" size="10"></td>
                    </tr>
        @endforeach
    @else
        @for ($i = 0; $i < 5; $i ++)
                    <tr>
                        <td>
                            <button type="button" class="remove_button"><i class="fa fa-remove"></i></button>
                        </td>
                        <td>
                            <input type="text" class="stock_code" name="stockTransferDetail[{{ $i }}][stock_code]" value="" size="10">
                            <input type="hidden" class="stock_id" name="stockTransferDetail[{{ $i }}][stock_id]" value="">
                        </td>
                        <td>
                            <input type="text" class="stock_autocomplete" name="stockTransferDetail[{{ $i }}][stock_name]" value="">
                        </td>
                        <td><input type="text" class="stock_quantity" name="stockTransferDetail[{{ $i }}][quantity]" onkeyup="calculator.calculate();" value="" style="text-align:right;" size="5"></td>
                        <td><input type="text" class="stock_unit" name="stockTransferDetail[{{ $i }}][unit]" value="" readonly="" size="5"></td>
                        <td><input type="text" class="stock_no_tax_price" name="stockTransferDetail[{{ $i }}][no_tax_price]" onkeyup="calculator.calculate();" value="" style="text-align:right;" size="10"></td>
                        <td><input type="text" class="stock_no_tax_amount" style="text-align:right;" size="10"></td>
                    </tr>
        @endfor
    @endif
                </tbody>
            </table>
            <hr>
{{--
            <div style="width:100%;">
                <p>
                    營業稅
                    <input type="radio" class="tax_rate_code" onclick="calculator.calculate();"
                        name="stockTransferMaster[tax_rate_code]" value="A"
                        {{ $stockTransferMaster['tax_rate_code'] == "A" || $stockTransferMaster['tax_rate_code'] == '' ? 'checked=""' : ''}}>稅外加
                    <input type="radio" class="tax_rate_code" onclick="calculator.calculate();"
                        name="stockTransferMaster[tax_rate_code]" value="I"
                        {{ $stockTransferMaster['tax_rate_code'] == "I" ? 'checked=""' : ''}}>稅內含
                </p>
            </div>
--}}
            <div style="width:50%;height:100px;float:left;">
                <table>
                    <tr>
                        <th>小計</th>
                        <td><input type="text" class="total_no_tax_amount" style="text-align:right;" readonly=""></td>
                    </tr>
                </table>
{{--
                <table>
                    <tr>
                        <td>稅前合計：</td>
                        <td><input type="text" class="total_no_tax_amount" style="text-align:right;" readonly=""></td>
                    </tr>
                    <tr>
                        <td>營業稅：</td>
                        <td><input type="text" class="tax" style="text-align:right;" readonly=""></td>
                    </tr>
                    <tr>
                        <td>應付總計：</td>
                        <td><input type="text" class="total_amount" style="text-align:right;" readonly=""></td>
                    </tr>
                </table>
--}}
            </div>
            <div style="width:50%;height:100px;float:right;">
                {{--<table>
                    <tr>
                        <td>稅前合計：</td>
                        <td><input type="text" id="total_no_tax_amount" readonly=""></td>
                    </tr>
                    <tr>
                        <td>營業稅：</td>
                        <td><input type="text" id="tax" readonly=""></td>
                    </tr>
                    <tr>
                        <td>應付總計：</td>
                        <td><input type="text" id="total_amount" readonly=""></td>
                    </tr>
                </table>
                --}}
            </div>
            <button type="submit" class="btn btn-default">確認送出</button>
        </form>

@endsection