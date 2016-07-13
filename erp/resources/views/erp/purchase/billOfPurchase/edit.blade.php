@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('OrderCalculator', 'App\Presenters\OrderCalculator')
@inject('WarehousePresenter', 'Warehouse\WarehousePresenter')

@section('content')
        {{ $OrderCalculator->setOrderMaster($billOfPurchaseMaster) }}
        {{ $OrderCalculator->setOrderDetail($billOfPurchaseDetail) }}
        {{ $OrderCalculator->calculate() }}
        <script type="text/javascript">
            var app_name     = 'billOfPurchase';

            var _tax_rate       = {{ Config::get('system_configs')['purchase_tax_rate'] }};
            var _quantity_round_off      = {{ Config::get('system_configs')['quantity_round_off'] }};
            var _no_tax_price_round_off  = {{ Config::get('system_configs')['no_tax_price_round_off'] }};
            var _no_tax_amount_round_off = {{ Config::get('system_configs')['no_tax_amount_round_off'] }};
            var _tax_round_off           = {{ Config::get('system_configs')['tax_round_off'] }};
            var _total_amount_round_off  = {{ Config::get('system_configs')['total_amount_round_off'] }};
        </script>
        <script type="text/javascript" src="{{ asset('assets/js/OrderCalculator.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bindSupplierAutocomplete.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/purchase.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bindStockAutocomplete.js') }}"></script>
        <form action="{{ url("/billOfPurchase/".$billOfPurchaseMaster['code']) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table id="master" width="100%">
                <tr>
                    <td>進貨日期</td>
                    <td>{{ $PublicPresenter->getFormatDate($billOfPurchaseMaster['created_at']) }}</td>
                    <td>進貨單號</td>
                    <td><input type="text" value="{{ $billOfPurchaseMaster['code'] }}" readonly=""></td>
                    <td>發票號碼</td>
                    <td><input type="text" name="billOfPurchaseMaster[invoice_code]" value="{{ $billOfPurchaseMaster['invoice_code'] }}"></td>
                </tr>
                <tr>
                    <th>供應商</th>
                    <td colspan="5">
                        <input type="hidden" name="billOfPurchaseMaster[supplier_id]" class="supplier_id" value="{{ $billOfPurchaseMaster['supplier_id'] }}"  size="10">
                        <input type="text" name="billOfPurchaseMaster[supplier_code]" class="supplier_code" value="{{ $billOfPurchaseMaster['supplier_code'] }}"  size="10">
                        <input type="text" name="billOfPurchaseMaster[supplier_name]" class="supplier_autocomplete" value="{{ $billOfPurchaseMaster['supplier_name'] }}">
                    </td>
                </tr>
                <tr>
                    <th>進貨單備註</th>
                    <td colspan="5">
                        <input type="text" name="billOfPurchaseMaster[note]" value="{{ $billOfPurchaseMaster['note'] }}" size="50">
                    </td>
                </tr>
               <tr>
                    <th>進貨倉庫</th>
                    <td colspan="5">
                        <select name="billOfPurchaseMaster[warehouse_id]">
                            <option></option>
                            {!! $WarehousePresenter->renderOptions($billOfPurchaseMaster['warehouse_id']) !!}
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
    @if (count($billOfPurchaseDetail) > 0)
        @foreach ($billOfPurchaseDetail as $i => $value)
                    <tr>
                        <td>
                            <button type="button" class="remove_button"><i class="fa fa-remove"></i></button>
                        </td>
                        <td>
                            <input type="text" class="stock_code" name="billOfPurchaseDetail[{{ $i }}][stock_code]" value="{{ $billOfPurchaseDetail[$i]['stock_code'] }}" size="10">
                            <input type="hidden" class="stock_id" name="billOfPurchaseDetail[{{ $i }}][stock_id]" value="{{ $billOfPurchaseDetail[$i]['stock_id'] }}">
                        </td>
                        <td>
                            <input type="text" class="stock_autocomplete" name="billOfPurchaseDetail[{{ $i }}][stock_name]" value="{{ $billOfPurchaseDetail[$i]['stock_name'] }}">
                        </td>
                        <td><input type="text" class="stock_quantity" name="billOfPurchaseDetail[{{ $i }}][quantity]" onkeyup="calculator.calculate();" value="{{ $billOfPurchaseDetail[$i]['quantity'] }}" style="text-align:right;" size="5"></td>
                        <td><input type="text" class="stock_unit" name="billOfPurchaseDetail[{{ $i }}][unit]" value="{{ $billOfPurchaseDetail[$i]['unit'] }}" readonly="" size="5"></td>
                        <td><input type="text" class="stock_no_tax_price" name="billOfPurchaseDetail[{{ $i }}][no_tax_price]" onkeyup="calculator.calculate();" value="{{ $billOfPurchaseDetail[$i]['no_tax_price'] }}" style="text-align:right;" size="10"></td>
                        <td><input type="text" class="stock_no_tax_amount" style="text-align:right;" value="{{ $OrderCalculator->getNoTaxAmount($i) }}" size="10"></td>
                    </tr>
        @endforeach
    @else
        @for ($i = 0; $i < 5; $i ++)
                    <tr>
                        <td>
                            <button type="button" class="remove_button"><i class="fa fa-remove"></i></button>
                        </td>
                        <td>
                            <input type="text" class="stock_code" name="billOfPurchaseDetail[{{ $i }}][stock_code]" value="" size="10">
                            <input type="hidden" class="stock_id" name="billOfPurchaseDetail[{{ $i }}][stock_id]" value="">
                        </td>
                        <td>
                            <input type="text" class="stock_autocomplete" name="billOfPurchaseDetail[{{ $i }}][stock_name]" value="">
                        </td>
                        <td><input type="text" class="stock_quantity" name="billOfPurchaseDetail[{{ $i }}][quantity]" onkeyup="calculator.calculate();" value="" style="text-align:right;" size="5"></td>
                        <td><input type="text" class="stock_unit" name="billOfPurchaseDetail[{{ $i }}][unit]" value="" readonly="" size="5"></td>
                        <td><input type="text" class="stock_no_tax_price" name="billOfPurchaseDetail[{{ $i }}][no_tax_price]" onkeyup="calculator.calculate();" value="" style="text-align:right;" size="10"></td>
                        <td><input type="text" class="stock_no_tax_amount" style="text-align:right;" size="10"></td>
                    </tr>
        @endfor
    @endif
                </tbody>
            </table>
            <hr>
            <div style="width:50%;"">
                <p>
                    營業稅
                    <input type="radio" class="tax_rate_code" onclick="calculator.calculate();"
                        name="billOfPurchaseMaster[tax_rate_code]" value="A"
                        {{ $billOfPurchaseMaster['tax_rate_code'] == "A" || $billOfPurchaseMaster['tax_rate_code'] == '' ? 'checked=""' : ''}}>稅外加
                    <input type="radio" class="tax_rate_code" onclick="calculator.calculate();"
                        name="billOfPurchaseMaster[tax_rate_code]" value="I"
                        {{ $billOfPurchaseMaster['tax_rate_code'] == "I" ? 'checked=""' : ''}}>稅內含
                </p>
            </div>
            <div style="width:50%;height:100px;float:left;">
                <table>
                    <tr>
                        <td>稅前合計：</td>
                        <td><input type="text" class="total_no_tax_amount" style="text-align:right;" value="{{ $OrderCalculator->getTotalNoTaxAmount() }}" readonly=""></td>
                    </tr>
                    <tr>
                        <td>營業稅：</td>
                        <td><input type="text" class="tax" style="text-align:right;" value="{{ $OrderCalculator->getTax() }}" readonly=""></td>
                    </tr>
                    <tr>
                        <td>應付總計：</td>
                        <td><input type="text" class="total_amount" style="text-align:right;" value="{{ $OrderCalculator->getTotalAmount() }}" readonly=""></td>
                    </tr>
                </table>
            </div>
            <div style="width:50%;height:100px;float:left;">
                <table>
                    <tr>
                        <td>已付款：</td>
                        <td align="right">{{ $billOfPurchaseMaster->paid_amount }}</td>
                    </tr>
                    <tr>
                        <td>未付款：</td>
                        <td align="right">{{ $OrderCalculator->getTotalAmount() - $billOfPurchaseMaster->paid_amount }}</td>
                    </tr>
                </table>
            </div>
    @if ($billOfPurchaseMaster->paid_amount == 0)
            <button type="submit">確認送出</button>
    @endif
        </form>

@endsection