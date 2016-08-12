@extends('layouts.app')
@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@include('erp.show_button_group', [
    'print_enabled' => true,
    'delete_enabled' => $returnOfPurchaseMaster['paid_amount'] == 0,
    'edit_enabled'   => $returnOfPurchaseMaster['paid_amount'] == 0,
    'chname'         => '進貨退回單',
    'route_name'     => 'returnOfPurchase',
    'code'           => $returnOfPurchaseMaster->code
])

@section('content')
        <table id="master" width="100%">
            <tr>
                <td>開單日期</td>
                <td>{{ $returnOfPurchaseMaster->date }}</td>
                <td>進貨退回單號</td>
                <td>{{ $returnOfPurchaseMaster->code }}</td>
                <td>發票號碼</td>
                <td>{{ $returnOfPurchaseMaster->invoice_code }}</td>
            </tr>
            <tr>
                <th>供應商</th>
                <td colspan="5">
                    {{ $returnOfPurchaseMaster->supplier->code }}
                    {{ $returnOfPurchaseMaster->supplier->name }}
                </td>
            </tr>
            <tr>
                <th>進貨退回單備註</th>
                <td colspan="5">
                    {{ $returnOfPurchaseMaster->note }}
                </td>
            </tr>
            <tr>
                <th>進貨退回倉庫</th>
                <td colspan="5">
                    {{ $returnOfPurchaseMaster->warehouse->name }}
                </td>
            </tr>
        </table>
        <hr>
        <table id="detail" width="100%">
            <thead>
                <tr>
                    <th>料品編號</th>
                    <th>料品名稱</th>
                    <th class="numeric">料品數量</th>
                    <th class="string">料品單位</th>
                    <th class="numeric">稅前單價</th>
                    <th class="numeric">未稅金額</th>
                </tr>
            </thead>
            <tbody>

    @foreach($returnOfPurchaseDetail as $i => $value)
                <tr>
                    <td>{{ $returnOfPurchaseDetail[$i]['stock']->code }}</td>
                    <td>{{ $returnOfPurchaseDetail[$i]['stock']->name }}</td>
                    <td class="numeric">{{ $returnOfPurchaseDetail[$i]['quantity'] }}</td>
                    <td class="string">{{ $returnOfPurchaseDetail[$i]['stock']->unit->comment }}</td>
                    <td class="numeric">{{ $returnOfPurchaseDetail[$i]['no_tax_price'] }}</td>
                    <td class="numeric">
                        {{
                            number_format($returnOfPurchaseDetail[$i]['no_tax_amount'],
                                config('system_configs.no_tax_amount_round_off')
                            )
                        }}
                    </td>
                </tr>
    @endforeach

            </tbody>
        </table>
        <hr>
        <div style="width:50%;">
            <p>
                營業稅 {{ $PublicPresenter->getTaxComment($returnOfPurchaseMaster->tax_rate_code) }}
            </p>
        </div>
        <div style="width:50%;height:100px;float:left;">
            <table>
                <tr>
                    <td>稅前合計：</td>
                    <td align="right">
                        {{
                            number_format($returnOfPurchaseMaster['total_no_tax_amount'],
                                config('system_configs.total_amount_round_off')
                            )
                        }}
                    </td>
                </tr>
                <tr>
                    <td>營業稅：</td>
                    <td align="right">
                        {{
                            number_format($returnOfPurchaseMaster['tax'],
                                config('system_configs.tax_round_off')
                            )
                        }}
                    </td>
                </tr>
                <tr>
                    <td>應付總計：</td>
                    <td align="right">
                        {{
                            number_format($returnOfPurchaseMaster['total_amount'],
                                config('system_configs.total_amount_round_off')
                            )
                        }}
                    </td>
                </tr>
            </table>
        </div>
        <div style="width:50%;height:100px;float:left;">
            <table>
                <tr>
                    <td>已付款：</td>
                    <td align="right">
                        {{
                            number_format($returnOfPurchaseMaster['paid_amount'],
                                config('system_configs.total_amount_round_off')
                            )
                        }}
                    </td>
                </tr>
                <tr>
                    <td>未付款：</td>
                    <td align="right">
                        {{
                            number_format($returnOfPurchaseMaster['total_amount']
                                - $returnOfPurchaseMaster['paid_amount'],
                                config('system_configs.total_amount_round_off')
                            )
                        }}
                    </td>
                </tr>
            </table>
        </div>
    {{-- 資料檢視頁的按鈕群組 --}}
    @yield('show_button_group')
@endsection
