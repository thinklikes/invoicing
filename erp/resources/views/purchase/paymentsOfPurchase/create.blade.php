@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('WarehousePresenter', 'App\Presenters\WarehousePresenter')
@section('content')
        <script type="text/javascript">
            var stock_url    = '{{ url("/stocks/json") }}';
            var app_name     = 'returnOfPurchase';

            var _tax_rate       = {{ Config::get('system_configs')['purchase_tax_rate'] }};
            var _quantity_round_off      = {{ Config::get('system_configs')['quantity_round_off'] }};
            var _no_tax_price_round_off  = {{ Config::get('system_configs')['no_tax_price_round_off'] }};
            var _no_tax_amount_round_off = {{ Config::get('system_configs')['no_tax_amount_round_off'] }};
            var _tax_round_off           = {{ Config::get('system_configs')['tax_round_off'] }};
            var _total_amount_round_off  = {{ Config::get('system_configs')['total_amount_round_off'] }};
        </script>
<!--         <script type="text/javascript" src="{{ asset('assets/js/OrderCalculator.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/purchase.js') }}"></script> -->
        <script type="text/javascript" src="{{ asset('assets/js/bindSupplierAutocomplete.js') }}"></script>
        <form action=" {{ url("/returnsOfPurchase") }}" method="POST">
            {{ csrf_field() }}
            <table id="master" width="100%">
                <tr>
                    <td>付款日期</td>
                    <td>{{ $PublicPresenter->getNewDate() }}</td>
                    <td>付款單號</td>
                    <td><input type="text" name="paymentOfPurchase[code]" id="code" value="{{ $paymentOfPurchase['code'] != "" ? $paymentOfPurchase['code'] : $new_master_code }}" readonly=""></td>
                </tr>
                <tr>
                    <th>供應商</th>
                    <td colspan="5">
                        <input type="hidden" name="paymentOfPurchase[supplier_id]" class="supplier_id" value="{{ $paymentOfPurchase['supplier_id'] }}"  size="10">
                        <input type="text" name="paymentOfPurchase[supplier_code]" class="supplier_code" value="{{ $paymentOfPurchase['supplier_code'] }}"  size="10">
                        <input type="text" name="paymentOfPurchase[supplier_name]" class="supplier_autocomplete" value="{{ $paymentOfPurchase['supplier_name'] }}">
                    </td>
                </tr>
                <tr>
                    <th>付款單備註</th>
                    <td colspan="5">
                        <input type="text" name="paymentOfPurchase[note]" id="master_note" value="{{ $paymentOfPurchase['note'] }}" size="50">
                    </td>
                </tr>
            </table>
            <hr>
            <div style="width:100%;">
                <p>
                    營業稅
                    <input type="radio" id="tax_rate_code_A" name="paymentOfPurchase[tax_rate_code]" value="A" checked="">稅外加
                    <input type="radio" id="tax_rate_code_I" name="paymentOfPurchase[tax_rate_code]" value="I">稅內含
                </p>
            </div>
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