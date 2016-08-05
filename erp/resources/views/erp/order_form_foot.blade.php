@section('form_foot')
    @if ($tax_enabled)
            <div style="width:100%;">
                <p>
                    營業稅
                    <input type="radio" class="tax_rate_code" value="A"
                        name="{{ $headName }}[tax_rate_code]"
                        {{
                            (${$headName}['tax_rate_code'] == "A" ||
                                ${$headName}['tax_rate_code'] == '')
                                ? 'checked=""' : ''
                        }}>稅外加
                    <input type="radio" class="tax_rate_code" value="I"
                        name="{{ $headName }}[tax_rate_code]"
                        {{
                            (${$headName}['tax_rate_code'] == "I")
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
                            value="{{ ${$headName}['total_no_tax_amount']}}">
                    </div>
                </div>
                <div class="tr">
                    <div class="td">營業稅：</div>
                    <div class="td">
                        <input type="text" readonly=""
                            class="tax numeric"
                            value="{{ ${$headName}['tax'] }}">
                    </div>
                </div>
                <div class="tr">
                    <div class="td">金額總計：</div>
                    <div class="td">
                        <input type="text" readonly=""
                             class="total_amount numeric"
                             value="{{ ${$headName}['total_amount'] }}">
                    </div>
                </div>
            </div>
    @else
            <div class="custom-table">
                <div class="tr">
                    <div class="td">金額總計：</div>
                    <div class="td">
                        <input type="text" readonly=""
                             class="total_no_tax_amount numeric"
                             value="{{ ${$headName}['total_no_tax_amount'] }}">
                    </div>
                </div>
            </div>
    @endif
@endsection