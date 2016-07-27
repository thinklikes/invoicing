@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('WarehousePresenter', 'Warehouse\WarehousePresenter')
@section('content')
        <script type="text/javascript">
            var app_name     = 'billOfSale';

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
        <script type="text/javascript" src="{{ asset('assets/js/sale/sale.js') }}"></script>
        <form action=" {{ url("/billOfSale") }}" method="POST">
            {{ csrf_field() }}
            <table id="master" width="100%">
                <tr>
                    <td>銷貨日期</td>
                    <td>{{ $PublicPresenter->getNewDate() }}</td>
                    <td>銷貨單號</td>
                    <td><input type="text" id="master_code" value="{{ $new_master_code }}" readonly=""></td>
                    <td>發票號碼</td>
                    <td><input type="text" name="billOfSaleMaster[invoice_code]" value="{{ $billOfSaleMaster['invoice_code'] }}"></td>
                </tr>
                <tr>
                    <th>客戶</th>
                    <td colspan="5">
                        <input type="hidden" name="billOfSaleMaster[company_id]" class="company_id" value="{{ $billOfSaleMaster['company_id'] }}"  size="10">
                        {{-- <input type="text" name="billOfSaleMaster[company_code]" class="company_code" value="{{ $billOfSaleMaster['company_code'] }}"  size="10"> --}}
                        <input type="text" name="billOfSaleMaster[company_name]" class="company_autocomplete" value="{{ $billOfSaleMaster['company_name'] }}">
                    </td>
                </tr>
                <tr>
                    <th>銷貨單備註</th>
                    <td colspan="5">
                        <input type="text" name="billOfSaleMaster[note]" id="master_note" value="{{ $billOfSaleMaster['note'] }}" size="50">
                    </td>
                </tr>
               <tr>
                    <th>銷貨倉庫</th>
                    <td colspan="5">
                        <select name="billOfSaleMaster[warehouse_id]">
                            <option></option>
                            {!! $WarehousePresenter->renderOptions($billOfSaleMaster['warehouse_id']) !!}
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
                        <th>稅前單價</th>
                        <th>小計</th>
                    </tr>
                </thead>
                <tbody>
    @if (count($billOfSaleDetail) > 0)
        @foreach ($billOfSaleDetail as $i => $value)
                    <tr>
                        <td>
                            <button type="button" class="remove_button"><i class="fa fa-remove"></i></button>
                        </td>
                        <td>
                            <input type="text" class="stock_code" name="billOfSaleDetail[{{ $i }}][stock_code]" value="{{ $billOfSaleDetail[$i]['stock_code'] }}" size="10">
                            <input type="hidden" class="stock_id" name="billOfSaleDetail[{{ $i }}][stock_id]" value="{{ $billOfSaleDetail[$i]['stock_id'] }}">
                        </td>
                        <td>
                            <input type="text" class="stock_autocomplete" name="billOfSaleDetail[{{ $i }}][stock_name]" value="{{ $billOfSaleDetail[$i]['stock_name'] }}">
                        </td>
                        <td><input type="text" class="stock_quantity" name="billOfSaleDetail[{{ $i }}][quantity]" onkeyup="calculator.calculate();" value="{{ $billOfSaleDetail[$i]['quantity'] }}" style="text-align:right;" size="5"></td>
                        <td><input type="text" class="stock_unit" name="billOfSaleDetail[{{ $i }}][unit]" value="{{ $billOfSaleDetail[$i]['unit'] }}" readonly="" size="5"></td>
                        <td><input type="text" class="stock_no_tax_price" name="billOfSaleDetail[{{ $i }}][no_tax_price]" onkeyup="calculator.calculate();" value="{{ $billOfSaleDetail[$i]['no_tax_price'] }}" style="text-align:right;" size="10"></td>
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
                            <input type="text" class="stock_code" name="billOfSaleDetail[{{ $i }}][stock_code]" value="" size="10">
                            <input type="hidden" class="stock_id" name="billOfSaleDetail[{{ $i }}][stock_id]" value="">
                        </td>
                        <td>
                            <input type="text" class="stock_autocomplete" name="billOfSaleDetail[{{ $i }}][stock_name]" value="">
                        </td>
                        <td><input type="text" class="stock_quantity" name="billOfSaleDetail[{{ $i }}][quantity]" onkeyup="calculator.calculate();" value="" style="text-align:right;" size="5"></td>
                        <td><input type="text" class="stock_unit" name="billOfSaleDetail[{{ $i }}][unit]" value="" readonly="" size="5"></td>
                        <td><input type="text" class="stock_no_tax_price" name="billOfSaleDetail[{{ $i }}][no_tax_price]" onkeyup="calculator.calculate();" value="" style="text-align:right;" size="10"></td>
                        <td><input type="text" class="stock_no_tax_amount" style="text-align:right;" size="10"></td>
                    </tr>
        @endfor
    @endif
                </tbody>
            </table>
            <hr>
            <div style="width:100%;">
                <p>
                    營業稅
                    <input type="radio" class="tax_rate_code" onclick="calculator.calculate();"
                        name="billOfSaleMaster[tax_rate_code]" value="A"
                        {{ $billOfSaleMaster['tax_rate_code'] == "A" || $billOfSaleMaster['tax_rate_code'] == '' ? 'checked=""' : ''}}>稅外加
                    <input type="radio" class="tax_rate_code" onclick="calculator.calculate();"
                        name="billOfSaleMaster[tax_rate_code]" value="I"
                        {{ $billOfSaleMaster['tax_rate_code'] == "I" ? 'checked=""' : ''}}>稅內含
                </p>
            </div>
            <div style="width:50%;height:100px;float:left;">
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
            <button type="submit">確認送出</button>
        </form>

@endsection