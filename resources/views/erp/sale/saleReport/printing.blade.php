{{-- 注入庫存異動報表的presenter --}}
@inject('presenter', 'SaleReport\SaleReportPresenter')
@inject('public', 'App\Presenters\PublicPresenter')
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
                    <td colspan="2">銷退貨明細日報表</td>
                </tr>
                <tr>
                    <td>製表日期：</td>
                    <td>{{ Carbon\Carbon::today()->format('Y-m-d') }}</td>
                </tr>
                <tr>
                    <td>資料區間：</td>
                    <td>{{ $start_date."~".$end_date }}</td>
                </tr>
            </table>
        </div>
    </div>
@if(count($data) > 0)
    @foreach($keys as $company_id)
    <div class="reportPerPage">
        <div class="clear"></div>
        <hr />
        <div class="imformation">
            <table class="width_01">
                <tr>
                    <th>客戶名稱：</th>
                    <td>{{ $data[$company_id][0]->company->company_name }}</td>
                    <th>客戶編號</th>
                    <td>{{ $data[$company_id][0]->company->company_code }}</td>
                </tr>
                <tr>
                    <th>統一編號：</th>
                    <td>{{ $data[$company_id][0]->company->VTA_NO }}</td>
                    <th>電話：</th>
                    <td>{{ $data[$company_id][0]->company->company_tel }}</td>
                </tr>
                <tr>
                    <th>聯絡地址：</th>
                    <td colspan="3">{{ $data[$company_id][0]->company->company_add }}</td>
                </tr>
            </table>
        </div>
        @foreach($data[$company_id] as $key => $value)
        <div class="head">
            <table class="width_01">
                <thead>
                    <tr>
                        <th class="string" width="20%">日期</th>
                        <th class="string" width="25%">單據號碼</th>
                        <th class="string" width="15%">倉庫名稱</th>
                        <th class="numeric" width="10%">稅前合計</th>
                        <th class="string" width="10%">稅別</th>
                        <th class="numeric" width="10%">營業稅</th>
                        <th class="numeric" width="10%">金額總計</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="string">{{ $value->date }}</td>
                        <td class="string">
                            {{
                                $presenter->getOrderLocalNameByOrderType(
                                class_basename($value)) }}
                            {{ $value->code}}
                        </td>
                        <td class="string">
                            {{ $value->warehouse->name }}
                        </td>
                        <td class="numeric">
                            {{ number_format($value->total_no_tax_amount) }}
                        </td>
                        <td class="string">
                            {{
                                $public->getTaxComment($value->tax_rate_code)
                            }}
                        </td>
                        <td class="numeric">
                            {{ number_format($value->tax) }}
                        </td>
                        <td class="numeric">
                            {{ number_format($value->total_amount) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="body">
            <table>
                <thead>
                    <tr>
                        <th class="string">料品編號</th>
                        <th class="string">料品名稱</th>
                        <th class="numeric">料品數量</th>
                        <th class="string">料品單位</th>
                        <th class="numeric">稅前單價</th>
                        <th class="numeric">未稅金額</th>
                    </tr>
                </thead>
            <tbody>
            @foreach($value->orderDetail as $key2 => $value2)
                <tr>
                    <td class="string">{{ $value2->stock->code }}</td>
                    <td class="string">{{ $value2->stock->name }}</td>
                    <td class="numeric">{{ $value2->quantity }}</td>
                    <td class="string">{{ $value2->stock->unit->comment }}</td>
                    <td class="numeric">{{ $value2->no_tax_price }}</td>
                    <td class="numeric">
                        {{ number_format($value2->subTotal) }}
                    </td>
                </tr>
            @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
        <div class="foot">
            <table>
                <tr>
                    <th class="string" colspan="3" width="60%">合計</th>
                    <td class="numeric" width="10%">
                        {{
                            //計算稅前合計的合計
                            number_format(
                                $data[$company_id]->sum(function ($item) {
                                    return $item->total_no_tax_amount;
                                })
                            )
                        }}
                    </td>
                    <td width="10%"></td>
                    <td class="numeric" width="10%">
                        {{
                            //計算營業稅的合計
                            number_format(
                                $data[$company_id]->sum(function ($item) {
                                    return $item->tax;
                                })
                            )
                        }}
                    </td>
                    <td class="numeric" width="10%">
                        {{
                            //計算小計
                            number_format(
                                $data[$company_id]->sum(function ($item) {
                                    return $item->total_amount;
                                })
                            )
                        }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @endforeach
@endif

</div>

