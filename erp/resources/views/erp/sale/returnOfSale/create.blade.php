@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('WarehousePresenter', 'Warehouse\WarehousePresenter')
@section('content')
        <script type="text/javascript">
            var app_name     = 'returnOfSale';

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
        <script type="text/javascript" src="{{ asset('assets/js/sale/returnOfSale.js') }}"></script>
        <form action=" {{ url("/returnOfSale") }}" method="POST">
            {{ csrf_field() }}
            <div id="master_table" class="custom-table">
                <div class="tbody">
                    <div class="tr">
                        <div class="td">銷貨日期</div>
                        <div class="td">{{ $PublicPresenter->getNewDate() }}</div>
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
                                size="10">
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
                            class="total_no_tax_amount numeric">
                    </div>
                </div>
                <div class="tr">
                    <div class="td">營業稅：</div>
                    <div class="td">
                        <input type="text" readonly=""
                            class="tax numeric">
                    </div>
                </div>
                <div class="tr">
                    <div class="td">應收總計：</div>
                    <div class="td">
                        <input type="text" readonly=""
                             class="total_amount numeric">
                    </div>
                </div>
            </div>
            <table id="master" width="100%">
                <tr>
                    <td>銷貨退回日期</td>
                    <td>{{ $PublicPresenter->getNewDate() }}</td>
                    <td>銷貨退回單號</td>
                    <td><input type="text" id="master_code" value="{{ $new_master_code }}" readonly=""></td>
                    <td>發票號碼</td>
                    <td><input type="text" name="returnOfSaleMaster[invoice_code]" id="master_invoice_code" value="{{ $returnOfSaleMaster['invoice_code'] }}" size="10"></td>
                </tr>
                <tr>
                    <th>客戶</th>
                    <td colspan="5">
                        <input type="hidden" name="returnOfSaleMaster[company_id]" class="company_id" value="{{ $returnOfSaleMaster['company_id'] }}"  size="10">
                        <input type="text" name="returnOfSaleMaster[company_code]" class="company_code" value="{{ $returnOfSaleMaster['company_code'] }}"  size="10">
                        <input type="text" name="returnOfSaleMaster[company_name]" class="company_autocomplete" value="{{ $returnOfSaleMaster['company_name'] }}">
                    </td>
                </tr>
                <tr>
                    <th>銷貨退回單備註</th>
                    <td colspan="5">
                        <input type="text" name="returnOfSaleMaster[note]" id="master_note" value="{{ $returnOfSaleMaster['note'] }}" size="50">
                    </td>
                </tr>
               <tr>
                    <th>銷貨退回倉庫</th>
                    <td colspan="5">
                        <select name="returnOfSaleMaster[warehouse_id]">
                            <option></option>
                            {!! $WarehousePresenter->renderOptions($returnOfSaleMaster['warehouse_id']) !!}
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
    @if (count($returnOfSaleDetail) > 0)
        @foreach ($returnOfSaleDetail as $i => $value)
                    <tr>
                        <td>
                            <button type="button" class="remove_button"><i class="fa fa-remove"></i></button>
                        </td>
                        <td>
                            <input type="text" class="stock_code" name="returnOfSaleDetail[{{ $i }}][stock_code]" value="{{ $returnOfSaleDetail[$i]['stock_code'] }}" size="10">
                            <input type="hidden" class="stock_id" name="returnOfSaleDetail[{{ $i }}][stock_id]" value="{{ $returnOfSaleDetail[$i]['stock_id'] }}">
                        </td>
                        <td>
                            <input type="text" class="stock_autocomplete" name="returnOfSaleDetail[{{ $i }}][stock_name]" value="{{ $returnOfSaleDetail[$i]['stock_name'] }}">
                        </td>
                        <td><input type="text" class="stock_quantity" name="returnOfSaleDetail[{{ $i }}][quantity]" onkeyup="calculator.calculate();" value="{{ $returnOfSaleDetail[$i]['quantity'] }}" style="text-align:right;" size="5"></td>
                        <td><input type="text" class="stockunit" name="returnOfSaleDetail[{{ $i }}][unit]" value="{{ $returnOfSaleDetail[$i]['unit'] }}" readonly="" size="5"></td>
                        <td><input type="text" class="stock_no_tax_price" name="returnOfSaleDetail[{{ $i }}][no_tax_price]" onkeyup="calculator.calculate();" value="{{ $returnOfSaleDetail[$i]['no_tax_price'] }}" style="text-align:right;" size="10"></td>
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
                            <input type="text" class="stock_code" name="returnOfSaleDetail[{{ $i }}][stock_code]" value="" size="10">
                            <input type="hidden" class="stock_id" name="returnOfSaleDetail[{{ $i }}][stock_id]" value="">
                        </td>
                        <td>
                            <input type="text" class="stock_autocomplete" name="returnOfSaleDetail[{{ $i }}][stock_name]" value="">
                        </td>
                        <td><input type="text" class="stock_quantity" name="returnOfSaleDetail[{{ $i }}][quantity]" onkeyup="calculator.calculate();" value="" style="text-align:right;" size="5"></td>
                        <td><input type="text" class="stock_unit" name="returnOfSaleDetail[{{ $i }}][unit]" value="" readonly="" size="5"></td>
                        <td><input type="text" class="stock_no_tax_price" name="returnOfSaleDetail[{{ $i }}][no_tax_price]" onkeyup="calculator.calculate();" value="" style="text-align:right;" size="10"></td>
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
                        name="returnOfSaleMaster[tax_rate_code]" value="A"
                        {{ $returnOfSaleMaster['tax_rate_code'] == "A" || $returnOfSaleMaster['tax_rate_code'] == '' ? 'checked=""' : ''}}>稅外加
                    <input type="radio" class="tax_rate_code" onclick="calculator.calculate();"
                        name="returnOfSaleMaster[tax_rate_code]" value="I"
                        {{ $returnOfSaleMaster['tax_rate_code'] == "I" ? 'checked=""' : ''}}>稅內含
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
                        <td>應收總計：</td>
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
                        <td>應收總計：</td>
                        <td><input type="text" id="total_amount" readonly=""></td>
                    </tr>
                </table>
                --}}
            </div>
            <button type="submit" class="btn btn-default">確認送出</button>
        </form>

@endsection