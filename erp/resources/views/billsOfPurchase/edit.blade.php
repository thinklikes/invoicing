@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('OrderCalculator', 'App\Presenters\OrderCalculator')
@inject('WarehousePresenter', 'App\Presenters\WarehousePresenter')

@section('content')
        {{ $OrderCalculator->setOrderMaster($billOfPurchaseMaster) }}
        {{ $OrderCalculator->setOrderDetail($billOfPurchaseDetail) }}
        {{ $OrderCalculator->calculate() }}
        <script type="text/javascript">
            var supplier_url = '{{ url("/suppliers/json") }}';
            var stock_url    = '{{ url("/stocks/json") }}';
            var app_name     = 'billOfPurchase';

            var _tax_rate       = {{ $settings->purchase_tax_rate }};
            var _quantity_round_off      = {{ $settings->quantity_round_off }};
            var _no_tax_price_round_off  = {{ $settings->no_tax_price_round_off }};
            var _no_tax_amount_round_off = {{ $settings->no_tax_amount_round_off }};
            var _tax_round_off           = {{ $settings->tax_round_off }};
            var _total_amount_round_off  = {{ $settings->total_amount_round_off }};
        </script>
        <script type="text/javascript" src="{{ asset('assets/js/OrderCalculator.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/purchase.js') }}"></script>
        <form action="{{ url("/billsOfPurchase/".$billOfPurchaseMaster['code']) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table id="master" width="100%">
                <tr>
                    <td>進貨日期</td>
                    <td>{{ $PublicPresenter->getFormatDate($billOfPurchaseMaster['created_at']) }}</td>
                    <td>進貨單號</td>
                    <td><input type="text" id="master_code" value="{{ $billOfPurchaseMaster['code']}}" readonly=""></td>
                    <td>發票號碼</td>
                    <td><input type="text" name="billOfPurchaseMaster[invoice_code]" id="master_invoice_code" value="{{ $billOfPurchaseMaster['invoice_code'] }}"></td>
                </tr>
                <tr>
                    <th>供應商</th>
                    <td colspan="5">
                        <input type="hidden" name="billOfPurchaseMaster[supplier_id]" id="master_supplier_id" value="{{ $billOfPurchaseMaster['supplier_id'] }}"  size="10">
                        <input type="text" name="billOfPurchaseMaster[supplier_code]" id="master_supplier_code" value="{{ $billOfPurchaseMaster['supplier_code'] }}"  size="10">
                        <input type="text" name="billOfPurchaseMaster[supplier_name]" id="master_supplier_name" value="{{ $billOfPurchaseMaster['supplier_name'] }}">
                    </td>
                </tr>
                <tr>
                    <th>進貨單備註</th>
                    <td colspan="5">
                        <input type="text" name="billOfPurchaseMaster[note]" id="master_note" value="{{ $billOfPurchaseMaster['note'] }}" size="50">
                    </td>
                </tr>
               <tr>
                    <th>進貨倉庫</th>
                    <td colspan="5">
                        <select name="billOfPurchaseMaster[warehouse_id]" id="master_warehouse_id">
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
    @if(count($billOfPurchaseDetail) > 0)
        @foreach($billOfPurchaseDetail as $i => $value)
                    <tr>
                        <td>
                            <button type="button" id="detail_remove_{{ $i }}"><i class="fa fa-remove"></i></button>
                        </td>
                        <td>
                            <input type="text" id="detail_stock_code_{{ $i }}" name="billOfPurchaseDetail[{{ $i }}][stock_code]" value="{{ $billOfPurchaseDetail[$i]['stock_code'] }}" size="10">
                            <input type="hidden" id="detail_stock_id_{{ $i }}" name="billOfPurchaseDetail[{{ $i }}][stock_id]" value="{{ $billOfPurchaseDetail[$i]['stock_id'] }}">
                        </td>
                        <td>
                            <input type="text" id="detail_stock_name_{{ $i }}" name="billOfPurchaseDetail[{{ $i }}][stock_name]" value="{{ $billOfPurchaseDetail[$i]['stock_name'] }}">
                        </td>
                        <td><input type="text" id="detail_quantity_{{ $i }}" name="billOfPurchaseDetail[{{ $i }}][quantity]" value="{{ $billOfPurchaseDetail[$i]['quantity'] }}" style="text-align:right;" size="5"></td>
                        <td><input type="text" id="detail_unit_{{ $i }}" name="billOfPurchaseDetail[{{ $i }}][unit]" value="{{ $billOfPurchaseDetail[$i]['unit'] }}" readonly="" size="5"></td>
                        <td><input type="text" id="detail_no_tax_price_{{ $i }}" name="billOfPurchaseDetail[{{ $i }}][no_tax_price]" value="{{ $billOfPurchaseDetail[$i]['no_tax_price'] }}" style="text-align:right;" size="10"></td>
                        <td><input type="text" id="detail_no_tax_amount_{{ $i }}" style="text-align:right;" size="10" value="{{ $OrderCalculator->getNoTaxAmount($i) }}"></td>
                    </tr>
        @endforeach
    @else
        @for($i = 0; $i < 5; $i ++)
                    <tr>
                        <td>
                            <button type="button" id="detail_remove_{{ $i }}"><i class="fa fa-remove"></i></button>
                        </td>
                        <td>
                            <input type="text" id="detail_stock_code_{{ $i }}" name="billOfPurchaseDetail[{{ $i }}][stock_code]" value="" size="10">
                            <input type="hidden" id="detail_stock_id_{{ $i }}" name="billOfPurchaseDetail[{{ $i }}][stock_id]" value="">
                        </td>
                        <td>
                            <input type="text" id="detail_stock_name_{{ $i }}" name="billOfPurchaseDetail[{{ $i }}][stock_name]" value="">
                        </td>
                        <td><input type="text" id="detail_quantity_{{ $i }}" name="billOfPurchaseDetail[{{ $i }}][quantity]" value="" style="text-align:right;" size="5"></td>
                        <td><input type="text" id="detail_unit_{{ $i }}" name="billOfPurchaseDetail[{{ $i }}][unit]" value="" readonly="" size="5"></td>
                        <td><input type="text" id="detail_no_tax_price_{{ $i }}" name="billOfPurchaseDetail[{{ $i }}][no_tax_price]" value="" style="text-align:right;" size="10"></td>
                        <td><input type="text" id="detail_no_tax_amount_{{ $i }}" style="text-align:right;" size="10"></td>
                    </tr>
        @endfor
    @endif
                </tbody>
            </table>
            <hr>
            <div style="width:50%;"">
                <p>
                    營業稅
                    <input type="radio" id="tax_rate_code_A"  name="billOfPurchaseMaster[tax_rate_code]" value="A" checked="">稅外加
                    <input type="radio" id="tax_rate_code_I"  name="billOfPurchaseMaster[tax_rate_code]" value="I">稅內含
                </p>
            </div>
            <div style="width:50%;height:100px;float:left;">
                <table>
                    <tr>
                        <td>稅前合計：</td>
                        <td><input type="text" id="total_no_tax_amount" value="{{ $OrderCalculator->getTotalNoTaxAmount() }}" readonly=""></td>
                    </tr>
                    <tr>
                        <td>營業稅：</td>
                        <td><input type="text" id="tax" value="{{ $OrderCalculator->getTax() }}" readonly=""></td>
                    </tr>
                    <tr>
                        <td>應付總計：</td>
                        <td><input type="text" id="total_amount" value="{{ $OrderCalculator->getTotalAmount() }}" readonly=""></td>
                    </tr>
                </table>
            </div>
            <div style="width:50%;height:100px;float:left;">
                <!-- <table>
                    <tr>
                        <td>稅前合計：</td>
                        <td><input type="text" id="total_no_tax_amount" value="{{ $OrderCalculator->getTotalNoTaxAmount() }}" readonly=""></td>
                    </tr>
                    <tr>
                        <td>營業稅：</td>
                        <td><input type="text" id="tax" value="{{ $OrderCalculator->getTax() }}" readonly=""></td>
                    </tr>
                    <tr>
                        <td>應付總計：</td>
                        <td><input type="text" id="total_amount" value="{{ $OrderCalculator->getTotalAmount() }}" readonly=""></td>
                    </tr>
                </table> -->
            </div>
            <button type="submit">確認送出</button>
        </form>

@endsection