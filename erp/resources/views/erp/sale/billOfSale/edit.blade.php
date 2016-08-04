@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('calculator', 'App\Presenters\OrderCalculator')
@inject('WarehousePresenter', 'Warehouse\WarehousePresenter')
@inject('discount', 'Sale\Discount\DiscountPresenter')

@section('content')
        {{ $calculator->setOrderMaster($billOfSaleMaster) }}
        {{ $calculator->setOrderDetail($billOfSaleDetail) }}
        {{ $calculator->calculate() }}
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
        <script type="text/javascript" src="{{ asset('assets/js/sale/billOfSale.js') }}"></script>
        <form action="{{ url("/billOfSale/".$billOfSaleMaster['code']) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
           <div id="master_table" class="custom-table">
                <div class="tbody">
                    <div class="tr">
                        <div class="td">銷貨日期</div>
                        <div class="td">{{ $PublicPresenter->getFormatDate($billOfSaleMaster['created_at']) }}</div>
                    </div>
                    <div class="tr">
                        <div class="td">銷貨單號</div>
                        <div class="td">{{ $billOfSaleMaster['code'] }}</div>
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
                            <textarea name="billOfSaleMaster[note]" cols="25"
                                id="master_note">{{ $billOfSaleMaster['note'] }}</textarea>
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
            <hr>
            <button type="button" id="add_a_row" class="btn btn-default">
                增加一列
            </button>

            <div id="detail_table" class="custom-table">
                <div class="thead">
                    <div class="tr">
                        <div class="th"></div>
                        <div class="th">料品編號</div>
                        <div class="th">料品名稱</div>
                        <div class="th">優惠折扣</div>
                        <div class="th">料品數量</div>
                        <div class="th">料品單位</div>
                        <div class="th">稅前單價</div>
                        <div class="th">未稅金額</div>
                    </div>
                </div>
                <div class="tbody">
    @if (count($billOfSaleDetail) > 0)
        @foreach ($billOfSaleDetail as $i => $value)
                    <div class="tr">
                        <div class="td" data-title="">
                            <button type="button" class="btn btn-danger remove_button">
                                <i class="fa fa-remove"></i>
                            </button>
                        </div>
                        <div class="td" data-title="料品編號">
                            <input type="text" class="stock_code" size="10"
                                name="billOfSaleDetail[{{ $i }}][stock_code]"
                                value="{{ $value['stock_code'] }}">
                            <input type="hidden" class="stock_id"
                                name="billOfSaleDetail[{{ $i }}][stock_id]"
                                value="{{ $value['stock_id'] }}">
                        </div>
                        <div class="td" data-title="料品名稱">
                            <input type="text" class="stock_autocomplete"
                                name="billOfSaleDetail[{{ $i }}][stock_name]"
                                value="{{ $value['stock_name'] }}">
                        </div>
                        <div class="td" data-title="優惠折扣">
                            <input type="text" class="discount numeric" size="5"
                                name="billOfSaleDetail[{{ $i }}][discount]"
                                value="{{ $value['discount'] }}">％
                        </div>
                        <div class="td" data-title="料品數量">
                            <input type="text" class="stock_quantity numeric" size="5"
                            name="billOfSaleDetail[{{ $i }}][quantity]"
                            value="{{ $value['quantity'] }}">
                        </div>
                        <div class="td" data-title="料品單位">
                            <input type="text" class="stock_unit" size="5"
                            name="billOfSaleDetail[{{ $i }}][unit]"
                            value="{{ $value['unit'] }}" readonly="">
                        </div>
                        <div class="td" data-title="稅前單價">
                            <input type="text" class="stock_no_tax_price numeric" size="10"
                            name="billOfSaleDetail[{{ $i }}][no_tax_price]"
                            value="{{ $value['no_tax_price'] }}">
                        </div>
                        <div class="td" data-title="未稅金額">
                            <input type="text" class="stock_no_tax_amount numeric"
                                size="10" value="{{ $calculator->getNoTaxAmount($i) }}">
                        </div>
                    </div>
        @endforeach
    @else
        @for ($i = 0; $i < 5; $i ++)
                    <div class="tr">
                        <div class="td" data-title="">
                            <button type="button" class="btn btn-danger remove_button">
                                <i class="fa fa-remove"></i>
                            </button>
                        </div>
                        <div class="td" data-title="料品編號">
                            <input type="text" class="stock_code" size="10"
                                name="billOfSaleDetail[{{ $i }}][stock_code]"
                                value="">
                            <input type="hidden" class="stock_id"
                                name="billOfSaleDetail[{{ $i }}][stock_id]"
                                value="">
                        </div>
                        <div class="td" data-title="料品名稱">
                            <input type="text" class="stock_autocomplete"
                                name="billOfSaleDetail[{{ $i }}][stock_name]"
                                value="">
                        </div>
                        <div class="td" data-title="優惠折扣">
                            <input type="text" class="discount numeric" size="5"
                                name="billOfSaleDetail[{{ $i }}][discount]"
                                value="">％
                        </div>
                        <div class="td" data-title="料品數量">
                            <input type="text" class="stock_quantity numeric" size="5"
                            name="billOfSaleDetail[{{ $i }}][quantity]"
                            value="">
                        </div>
                        <div class="td" data-title="料品單位">
                            <input type="text" class="stock_unit" size="5"
                            name="billOfSaleDetail[{{ $i }}][unit]"
                            value="" readonly="">
                        </div>
                        <div class="td" data-title="稅前單價">
                            <input type="text" class="stock_no_tax_price numeric" size="10"
                            name="billOfSaleDetail[{{ $i }}][no_tax_price]"
                            value="">
                        </div>
                        <div class="td" data-title="未稅金額">
                            <input type="text" class="stock_no_tax_amount numeric"
                                size="10">
                        </div>
                    </div>
        @endfor
    @endif
                </div>
            </div>
            <hr>
            <div style="width:100%;">
                <p>
                    營業稅
                    <input type="radio" class="tax_rate_code" value="A"
                        name="billOfSaleMaster[tax_rate_code]"
                        {{
                            ($billOfSaleMaster['tax_rate_code'] == "A" ||
                                $billOfSaleMaster['tax_rate_code'] == '')
                                ? 'checked=""' : ''
                        }}>稅外加
                    <input type="radio" class="tax_rate_code" value="I"
                        name="billOfSaleMaster[tax_rate_code]"
                        {{
                            ($billOfSaleMaster['tax_rate_code'] == "I")
                            ? 'checked=""' : ''
                        }}>稅內含
                </p>
            </div>

            <div class="custom-table">
                <div class="tr">
                    <div class="td">稅前合計：</div>
                    <div class="td">
                        <input type="text" readonly=""
                            class="total_no_tax_amount numeric"
                            value="{{ $calculator->getTotalNoTaxAmount() }}">
                    </div>
                </div>
                <div class="tr">
                    <div class="td">營業稅：</div>
                    <div class="td">
                        <input type="text" readonly=""
                            class="tax numeric"
                            value="{{ $calculator->getTax() }}">
                    </div>
                </div>
                <div class="tr">
                    <div class="td">應收總計：</div>
                    <div class="td">
                        <input type="text" readonly=""
                            class="total_amount numeric"
                            value="{{ $calculator->getTotalAmount() }}">
                    </div>
                </div>
            </div>

    @if ($billOfSaleMaster['received_amount'] == 0)
            <button type="submit" class="btn btn-default">確認送出</button>
    @endif
        </form>

@endsection