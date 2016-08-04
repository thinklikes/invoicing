@extends('layouts.app')

{{-- 引入倉庫選項的檔案 --}}
@inject('WarehousePresenter', 'Warehouse\WarehousePresenter')

{{-- 引入表身的html 檔案 --}}
@include('erp.order_body', [
    'app_name' => 'billOfSaleDetail',
    'discount_enabled' => true
])

{{-- 引入表尾的html 檔案 --}}
@include('erp.sale.order_foot', [
    'app_name' => 'billOfSaleMaster'])

{{-- 主要html的區塊 --}}
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
        <script type="text/javascript" src="{{ asset('assets/js/sale/billOfSale.js') }}"></script>
        <form action=" {{ url("/billOfSale") }}" method="POST">
            {{ csrf_field() }}
            <div id="master_table" class="custom-table">
                <div class="tbody">
                    <div class="tr">
                        <div class="td">開單日期</div>
                        <div class="td">
                            <input type="text" class="datepicker"
                                name="billOfSaleMaster[date]"
                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td">銷貨單號</div>
                        <div class="td">
                            <input type="text" id="master_code" value="{{ $new_master_code }}"
                                readonly="">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td">發票號碼</div>
                        <div class="td">
                            <input type="text" name="billOfSaleMaster[invoice_code]"
                                value="{{ $billOfSaleMaster['invoice_code'] }}">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td">客戶</div>
                        <div class="td">
                            <input type="hidden" name="billOfSaleMaster[company_id]"
                                class="company_id"
                                value="{{ $billOfSaleMaster['company_id'] }}">
                            <input type="text" name="billOfSaleMaster[company_code]"
                                class="company_code" size="5"
                                value="{{ $billOfSaleMaster['company_code'] }}">
                            <input type="text" name="billOfSaleMaster[company_name]"
                                class="company_autocomplete" size="15"
                                value="{{ $billOfSaleMaster['company_name'] }}">
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td">銷貨單備註</div>
                        <div class="td">
                            <textarea name="billOfSaleMaster[note]"
                                cols="25" id="master_note">{{ $billOfSaleMaster['note'] }}</textarea>
                        </div>
                    </div>
                   <div class="tr">
                        <div class="td">銷貨倉庫</div>
                        <div class="td">
                            <select name="billOfSaleMaster[warehouse_id]">
                                <option></option>
                                {!! $WarehousePresenter->renderOptions($billOfSaleMaster['warehouse_id']) !!}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
{{-- 置入表身項目 --}}
@yield('order_body')
{{-- 置入表尾項目 --}}
@yield('order_foot')

            <button type="submit" class="btn btn-default">確認送出</button>
        </form>

@endsection