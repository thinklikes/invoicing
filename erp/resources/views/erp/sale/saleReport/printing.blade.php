{{-- 注入庫存異動報表的presenter --}}
@inject('presenter', 'SaleReport\SaleReportPresenter')
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
@foreach($data as $key => $value)
    <table width="100%" style="border-top:solid 1px black;">
        <thead>
            <tr>
                <th class="string">客戶名稱</th>
                <th class="string">日期</th>
                <th class="string">單據號碼</th>
                <th class="string">倉庫名稱</th>
                <th class="numeric">未稅金額</th>
                <th class="string">稅別</th>
                <th class="numeric">稅額</th>
                <th class="numeric">合計金額</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="string">{{ $value->company->company_name }}</td>
                <td class="string">{{ $value->created_at->format('Y-m-d') }}</td>
                <td class="string">
                    {{
                        $presenter->getOrderLocalNameByOrderType(
                        class_basename($value)) }}
                    {{ $value->code}}
                </td>
                <td class="string">{{ $value->warehouse->name }}</td>
                <td class="numeric">{{ $value->total_no_tax_amount }}</td>
                <td class="string">{{ $value->tax_rate_code }}</td>
                <td class="numeric">{{ $value->tax }}</td>
                <td class="numeric">{{ $value->total_amount }}</td>
            </tr>
        </tbody>
    </table>
    <div>
    {!! $presenter->makeTableBody($value) !!}
    </div>
@endforeach
    <table width="100%" style="border-top:solid 1px black;">
        <tr>
            <th class="string">合計</th>
            <td class="numeric">
                {{
                    //計算小計
                    $data->sum(function ($item) {
                        return $item->total_no_tax_amount;
                    })
                }}
            </td>
            <td class="numeric">
                {{
                    //計算小計
                    $data->sum(function ($item) {
                        return $item->tax;
                    })
                }}
            </td>
            <td class="numeric">
                {{
                    //計算小計
                    $data->sum(function ($item) {
                        return $item->total_amount;
                    })
                }}
            </td>
        </tr>
    </table>
</div>

