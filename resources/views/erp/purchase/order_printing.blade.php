@extends('layouts.clean')

@include('erp.print_button_group')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/print.css') }}">
<div class="main_page">
    <div class="information_container">
        <div class="company_information">
            <table>
                <tr><td>{{ config("system_configs.company_name") }}</td></tr>
                <tr><td>{{ config("system_configs.company_address") }}</td></tr>
                <tr><td>{{ config("system_configs.company_phone_number") }}</td></tr>
            </table>
        </div>
        <div class="order_information">
            <table>
                <tr>
                    <td><u>{{ $chname }}</u></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="clear"></div>
    <hr />
        <table id="master" class="l_move d_01">
            <tr>
                <th>供應商名稱：</th>
                <td>{{ ${$headName}->supplier->name or null }}</td>
                <th>供應商編號：</th>
                <td>
                    {{ ${$headName}->supplier->code or null }}
                </td>
            </tr>
            <tr>
                <th>統一編號：</th>
                <td>{{ ${$headName}->supplier->taxNumber or null }}</td>
                <th>電話：</th>
                <td>{{ ${$headName}->supplier->telphone or null }}</td>
            </tr>
            <tr>
                <th>聯絡地址：</th>
                <td colspan="3">{{ ${$headName}->supplier->address or null }}</td>
            </tr>
            <tr>
                <th>送貨地址：</th>
                <td colspan="3">{{ ${$headName}->supplier->address or null }}</td>
            </tr>
        </table>
        <table class="r_move">
           <tr>
             <th>開單日期：</th>
             <td>{{ ${$headName}->date }}</td>
          </tr>
           <tr>
             <th>{{ $chname }}號：</th>
             <td>{{ ${$headName}->code }}</td>
          </tr>
           <tr>
             <th>發票號碼：</th>
             <td>{{ ${$headName}->invoice_code }}</td>
          </tr>
          <tr>
             <th>倉庫：</th>
              <td colspan="3">
                 {{ ${$headName}->warehouse->name or null }}
              </td>
          </tr>
        </table>
        <div class="clear"></div>
        <hr />
        <table id="detail" class="width_01">
            <thead>
                <tr>
                    <th>料品編號</th>
                    <th>料品名稱</th>
                    <th class="numeric">料品數量</th>
                    <th class="numeric">料品單位</th>
                    <th class="numeric">稅前單價</th>
                    <th class="numeric">未稅金額</th>
                </tr>
            </thead>
            <tbody>

    @foreach(${$bodyName} as $i => $value)
                <tr>
                    <td>{{ ${$bodyName}[$i]->stock->code or null }}</td>
                    <td>{{ ${$bodyName}[$i]->stock->name or null }}</td>
                    <td class="numeric">{{ ${$bodyName}[$i]['quantity'] }}</td>
                    <td class="numeric">{{ ${$bodyName}[$i]->stock->unit->comment or null }}</td>
                    <td class="numeric">{{ ${$bodyName}[$i]['no_tax_price'] }}</td>
                    <td class="numeric">
                        {{
                            number_format(${$bodyName}[$i]['no_tax_amount'],
                                config('system_configs.no_tax_amount_round_off'))
                        }}

                    </td>
                </tr>
    @endforeach

            </tbody>
        </table>
        <hr />
        <div class="subTotal">
            <table class="width_01 d_02">
                <tr>
                    <th></th>
                    <td></td>
                    <th>稅前合計：</th>
                    <td class="numeric">
                        {{
                            number_format(${$headName}->total_no_tax_amount,
                                config('system_configs.total_amount_round_off'))
                        }}
                    </td>
                </tr>
                <tr>
                    <th>已付金額：</th>
                    <td class="numeric">
                        {{
                            number_format(${$headName}->paid_amount,
                                config('system_configs.total_amount_round_off'))
                        }}
                    </td>
                    <th>營業稅：</th>
                    <td class="numeric">
                        {{
                            number_format(${$headName}->tax,
                                config('system_configs.tax_round_off'))
                        }}
                    </td>
                </tr>
                <tr>
                    <th>應付金額：</th>
                    <td class="numeric">
                        {{
                            number_format(${$headName}->total_amount
                                - ${$headName}->paid_amount,
                                config('system_configs.total_amount_round_off'))
                        }}
                    </td>
                    <th>金額總計：</th>
                    <td class="numeric">
                        {{
                            number_format(${$headName}->total_amount,
                                config('system_configs.total_amount_round_off'))
                        }}
                    </td>
                </tr>
            </table>
        </div>
        <hr />
        <table>
           <tr>
                <th>{{ $chname }}備註：</th>
                <td colspan="3">
                    {{ ${$headName}->note }}
                </td>
            </tr>
        </table>
        <hr />
        <div class="signOn">
            <table class="width_01 d_03">
                <tr>
                    <th>審核：</th>
                    <td></td>
                    <th>經辦：</th>
                    <td></td>
                    <th>會計：</th>
                    <td></td>
                    <th>業務：</th>
                    <td></td>
                    <th>簽收：</th>
                    <td></td>
                </tr>
            </table>
        </div>
    @yield('print_button_group')
</div>
@endsection
<!--<script type="text/javascript">window.print();</script> -->