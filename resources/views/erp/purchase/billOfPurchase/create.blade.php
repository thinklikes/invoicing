@extends('layouts.app')

{{-- 注入倉庫選項的檔案 --}}
@inject('WarehousePresenter', 'Warehouse\WarehousePresenter')

{{-- 引入表身的html 檔案 --}}
@include('erp.order_form_body', [
    'discount_enabled' => false
])

{{-- 引入表尾的html 檔案 --}}
@include('erp.order_form_foot', [
    'tax_enabled' => true
])
@section('content')
        <script type="text/javascript">
            var app_name     = 'billOfPurchase';

            var _tax_rate       = {{ Config::get('system_configs')['purchase_tax_rate'] }};
            var _quantity_round_off      = {{ Config::get('system_configs')['quantity_round_off'] }};
            var _no_tax_price_round_off  = {{ Config::get('system_configs')['no_tax_price_round_off'] }};
            var _no_tax_amount_round_off = {{ Config::get('system_configs')['no_tax_amount_round_off'] }};
            var _tax_round_off           = {{ Config::get('system_configs')['tax_round_off'] }};
            var _total_amount_round_off  = {{ Config::get('system_configs')['total_amount_round_off'] }};
        </script>
        <script type="text/javascript" src="{{ asset('assets/js/purchase/purchase.js') }}"></script>
        <form action=" {{ url("/billOfPurchase") }}" method="POST">
            {{ csrf_field() }}
            <div id="master_table" class="custom-table">
                <div class="tr">
                    <div class="td">開單日期</div>
                    <div class="td">
                            <input type="text" class="datepicker"
                                name="{{ $headName }}[date]"
                                value="{{
                                    ${$headName}['date']
                                        or Carbon\Carbon::now()->format('Y-m-d')
                                }}">
                    </div>
                </div>
                <div class="tr">
                    <div class="td">進貨單號</div>
                    <div class="td"><input type="text" id="master_code" value="{{ $new_master_code }}" readonly=""></div>
                </div>
                <div class="tr">
                    <div class="td">發票號碼</div>
                    <div class="td"><input type="text" name="{{ $headName }}[invoice_code]" value="{{ ${$headName}['invoice_code'] }}"></div>
                </div>
                <div class="tr">
                    <div class="th">供應商</div>
                    <div class="td">
                        <input type="hidden" name="{{ $headName }}[supplier_id]" class="supplier_id" value="{{ ${$headName}['supplier_id'] }}">
                        <input type="text" name="{{ $headName }}[supplier_code]" class="supplier_code" value="{{ ${$headName}['supplier_code'] }}" size="5">
                        <input type="text" name="{{ $headName }}[supplier_name]" class="supplier_autocomplete" value="{{ ${$headName}['supplier_name'] }}" size="15">
                    </div>
                </div>
                <div class="tr">
                    <div class="th">進貨單備註</div>
                    <div class="td">
                        <textarea name="{{ $headName }}[note]">{{ ${$headName}['note'] }}</textarea>
                    </div>
                </div>
               <div class="tr">
                    <div class="th">進貨倉庫</div>
                    <div class="td">
                        <select name="{{ $headName }}[warehouse_id]">
                            <option></option>
                            {!! $WarehousePresenter->renderOptions(${$headName}['warehouse_id']) !!}
                        </select>
                    </div>
                </div>
            </div>

    {{-- 置入表身項目 --}}
    @yield('form_body')
    {{-- 置入表尾項目 --}}
    @yield('form_foot')

            <button type="submit" class="btn btn-default">確認送出</button>
        </form>

@endsection