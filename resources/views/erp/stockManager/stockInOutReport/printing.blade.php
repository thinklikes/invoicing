{{-- 注入庫存異動報表的presenter --}}
@inject('presenter', 'StockInOutReport\StockInOutReportPresenter')
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
                    <td colspan="2">庫存異動表</td>
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
    <table width="100%">
        <thead>
            <tr>
                <th class="string">日期</th>
                <th class="string">單據號碼</th>
                <th class="string">倉庫</th>
                <th class="string">料品代號</th>
                <th class="string">料品名稱</th>
                <th class="numeric">數量</th>
            </tr>
        </thead>
@if(count($data) > 0)
        <tbody>
    @foreach($data as $key => $value)
            <tr>
                <td class="string">{{ $value->created_at->format('Y-m-d') }}</td>
                <td class="string">
                    {{ $presenter->getOrderLocalNameByOrderType(
                        $value->order_type, class_basename($value))
                    }}
                    {{ $value->order_code }}
                </td>
                <td class="string">{{ $value->warehouse->name }}</td>
                <td class="string">{{ $value->stock->code }}</td>
                <td class="string">{{ $value->stock->name }}</td>
                <td class="numeric">{{ $value->quantity }}</td>
            </tr>
    @endforeach
@endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"></td>
                <td class="string">小計</td>
                <td class="numeric">
                    {{
                        //計算小計
                        $data->sum(function ($item) {
                            return $item->quantity;
                        })
                    }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>

