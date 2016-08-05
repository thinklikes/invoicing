@section('form_body')
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
@if ($discount_enabled)
                        <div class="th">優惠折扣</div>
@endif
                        <div class="th">料品數量</div>
                        <div class="th">料品單位</div>
                        <div class="th">稅前單價</div>
                        <div class="th">未稅金額</div>
                    </div>
                </div>
                <div class="tbody">
    @if (count(${$bodyName}) > 0)
        @foreach (${$bodyName} as $i => $value)
                    <div class="tr">
                        <div class="td" data-title="">
                            <button type="button" class="btn btn-danger remove_button">
                                <i class="fa fa-remove"></i>
                            </button>
                        </div>
                        <div class="td" data-title="料品編號">
                            <input type="text" class="stock_code" size="10"
                                name="{{ $bodyName }}[{{ $i }}][stock_code]"
                                value="{{ $value['stock_code'] }}">
                            <input type="hidden" class="stock_id"
                                name="{{ $bodyName }}[{{ $i }}][stock_id]"
                                value="{{ $value['stock_id'] }}">
                        </div>
                        <div class="td" data-title="料品名稱">
                            <input type="text" class="stock_autocomplete"
                                name="{{ $bodyName }}[{{ $i }}][stock_name]"
                                value="{{ $value['stock_name'] }}">
                        </div>
@if ($discount_enabled)
                        <div class="td" data-title="優惠折扣">
                            <input type="text" class="discount numeric" size="5"
                                name="{{ $bodyName }}[{{ $i }}][discount]"
                                value="{{ $value['discount'] }}">％
                            <script type="text/javascript">
                                calculator.setDiscountByIndex({{ $i }}, {{ $value['discount'] }});
                            </script>
                        </div>
@endif
                        <div class="td" data-title="料品數量">
                            <input type="text" class="stock_quantity numeric" size="5"
                            name="{{ $bodyName }}[{{ $i }}][quantity]"
                            value="{{ $value['quantity'] }}">
                        </div>
                        <div class="td" data-title="料品單位">
                            <input type="text" class="stock_unit" size="5"
                            name="{{ $bodyName }}[{{ $i }}][unit]"
                            value="{{ $value['unit'] }}" readonly="">
                        </div>
                        <div class="td" data-title="稅前單價">
                            <input type="text" class="stock_no_tax_price numeric" size="10"
                            name="{{ $bodyName }}[{{ $i }}][no_tax_price]"
                            value="{{ $value['no_tax_price'] }}">
                        </div>
                        <div class="td" data-title="未稅金額">
                            <input type="text" class="stock_no_tax_amount numeric" size="10"
                            value="{{ $value['no_tax_amount'] }}">
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
                                name="{{ $bodyName }}[{{ $i }}][stock_code]"
                                value="">
                            <input type="hidden" class="stock_id"
                                name="{{ $bodyName }}[{{ $i }}][stock_id]"
                                value="">
                        </div>
                        <div class="td" data-title="料品名稱">
                            <input type="text" class="stock_autocomplete"
                                name="{{ $bodyName }}[{{ $i }}][stock_name]"
                                value="">
                        </div>
@if ($discount_enabled)
                        <div class="td" data-title="優惠折扣">
                            <input type="text" class="discount numeric" size="5"
                                name="{{ $bodyName }}[{{ $i }}][discount]"
                                value="">％
                        </div>
@endif
                        <div class="td" data-title="料品數量">
                            <input type="text" class="stock_quantity numeric" size="5"
                            name="{{ $bodyName }}[{{ $i }}][quantity]"
                            value="">
                        </div>
                        <div class="td" data-title="料品單位">
                            <input type="text" class="stock_unit" size="5"
                            name="{{ $bodyName }}[{{ $i }}][unit]"
                            value="" readonly="">
                        </div>
                        <div class="td" data-title="稅前單價">
                            <input type="text" class="stock_no_tax_price numeric" size="10"
                            name="{{ $bodyName }}[{{ $i }}][no_tax_price]"
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
@endsection