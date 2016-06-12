@extends('layouts.app')

@section('content')
        <script type="text/javascript">
            var supplier_url = '{{ url("/suppliers/json") }}';
            var stock_url    = '{{ url("/stocks/json") }}';

            var _tax_rate       = {{ $settings->purchase_tax_rate }};
            var _quantity_round_off      = {{ $settings->quantity_round_off }};
            var _no_tax_price_round_off  = {{ $settings->no_tax_price_round_off }};
            var _no_tax_amount_round_off = {{ $settings->no_tax_amount_round_off }};
            var _tax_round_off           = {{ $settings->tax_round_off }};
            var _total_amount_round_off  = {{ $settings->total_amount_round_off }};
        </script>
        <script type="text/javascript" src="{{ asset('assets/js/OrderCalculator.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/purchase.js') }}"></script>
        <form action=" {{ url("/purchase_orders") }}" method="POST">
            {{ csrf_field() }}
            <table id="master" width="100%">
                <tr>
                    <td>採購日期</td>
                    <td>{{ date('Y-m-d') }}</td>
                    <td>採購單號</td>
                    <td><input type="text" name="purchase_order_master[code]" id="master_code" value="{{ $purchase_order_master['code'] != "" ? $purchase_order_master['code'] : $new_master_code }}" readonly=""></td>
                    <td>交貨日期</td>
                    <td><input type="text" name="purchase_order_master[delivery_date]" id="master_delivery_date" value="{{ $purchase_order_master['delivery_date'] }}"></td>
                </tr>
                <tr>
                    <th>供應商</th>
                    <td colspan="5">
                        <input type="text" name="purchase_order_master[supplier_code]" id="master_supplier_code" value="{{ $purchase_order_master['supplier_code'] }}"  size="10">
                        <input type="text" name="purchase_order_master[supplier_name]" id="master_supplier_name" value="{{ $purchase_order_master['supplier_name'] }}">
                    </td>
                </tr>
                <tr>
                    <th>採購單備註</th>
                    <td colspan="5">
                        <input type="text" name="purchase_order_master[note]" id="master_note" value="{{ $purchase_order_master['note'] }}" size="50">
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
    @if(count($purchase_order_detail) > 0)
        @foreach($purchase_order_detail as $i => $value)
                    <tr>
                        <td>
                            <button type="button" id="detail_remove_{{ $i }}"><i class="fa fa-remove"></i></button>
                        </td>
                        <td>
                            <input type="text" id="detail_stock_code_{{ $i }}" name="purchase_order_detail[{{ $i }}][stock_code]" value="{{ $purchase_order_detail[$i]['stock_code'] }}" size="10">
                            <input type="hidden" id="detail_stock_id_{{ $i }}" name="purchase_order_detail[{{ $i }}][stock_id]" value="{{ $purchase_order_detail[$i]['stock_id'] }}">
                        </td>
                        <td>
                            <input type="text" id="detail_stock_name_{{ $i }}" name="purchase_order_detail[{{ $i }}][stock_name]" value="{{ $purchase_order_detail[$i]['stock_name'] }}">
                        </td>
                        <td><input type="text" id="detail_quantity_{{ $i }}" name="purchase_order_detail[{{ $i }}][quantity]" value="{{ $purchase_order_detail[$i]['quantity'] }}" style="text-align:right;" size="5"></td>
                        <td><input type="text" id="detail_unit_{{ $i }}" name="purchase_order_detail[{{ $i }}][unit]" value="{{ $purchase_order_detail[$i]['unit'] }}" readonly="" size="5"></td>
                        <td><input type="text" id="detail_no_tax_price_{{ $i }}" name="purchase_order_detail[{{ $i }}][no_tax_price]" value="{{ $purchase_order_detail[$i]['no_tax_price'] }}" style="text-align:right;" size="10"></td>
                        <td><input type="text" id="detail_no_tax_amount_{{ $i }}" style="text-align:right;" size="10"></td>
                    </tr>
        @endforeach
    @else
        @for($i = 0; $i < 5; $i ++)
                    <tr>
                        <td>
                            <button type="button" id="detail_remove_{{ $i }}"><i class="fa fa-remove"></i></button>
                        </td>
                        <td>
                            <input type="text" id="detail_stock_code_{{ $i }}" name="purchase_order_detail[{{ $i }}][stock_code]" value="" size="10">
                            <input type="hidden" id="detail_stock_id_{{ $i }}" name="purchase_order_detail[{{ $i }}][stock_id]" value="">
                        </td>
                        <td>
                            <input type="text" id="detail_stock_name_{{ $i }}" name="purchase_order_detail[{{ $i }}][stock_name]" value="">
                        </td>
                        <td><input type="text" id="detail_quantity_{{ $i }}" name="purchase_order_detail[{{ $i }}][quantity]" value="" style="text-align:right;" size="5"></td>
                        <td><input type="text" id="detail_unit_{{ $i }}" name="purchase_order_detail[{{ $i }}][unit]" value="" readonly="" size="5"></td>
                        <td><input type="text" id="detail_no_tax_price_{{ $i }}" name="purchase_order_detail[{{ $i }}][no_tax_price]" value="" style="text-align:right;" size="10"></td>
                        <td><input type="text" id="detail_no_tax_amount_{{ $i }}" style="text-align:right;" size="10"></td>
                    </tr>
        @endfor
    @endif
                </tbody>
            </table>
            <hr>
            <div style="width:50%;height:100px;float:left;">
                <table>
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
            </div>
            <div style="width:50%;height:100px;float:right;">
                營業稅
                <div><input type="radio" name="purchase_order_master[tax_rate_code]" value="A" checked="">稅外加</div>
                <div><input type="radio" name="purchase_order_master[tax_rate_code]" value="I">稅內含</div>
            </div>
            <button type="submit">確認送出</button>
        </form>

@endsection