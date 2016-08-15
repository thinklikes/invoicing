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
@if(count($data) > 0)
    @foreach($keys as $stock_id)
    <div class="reportPerPage">
        <div class="clear"></div>
        <hr />
        <div class="imformation">
            <table class="width_01">
                <tr>
                    <th>料品名稱：</th>
                    <td>{{ $data[$stock_id][0]->stock->name }}</td>
                    <th>料品單位</th>
                    <td>{{ $data[$stock_id][0]->stock->unit->comment }}</td>
                </tr>
                <tr>
                    <th>料品代號：</th>
                    <td>{{ $data[$stock_id][0]->stock->code }}</td>
                    <th>料品類別</th>
                    <td>{{ $data[$stock_id][0]->stock->stock_class->comment }}</td>
                </tr>
            </table>
        </div>
        <div class="head">
            <table>
                <thead>
                    <tr>
                        <th class="string">日期</th>
                        <th class="string">單據號碼</th>
                        <th class="string">倉庫</th>
                        <th class="numeric">數量</th>
                    </tr>
                </thead>
                <tbody>
        @foreach($data[$stock_id] as $key => $value)
                    <tr>
                        <td class="string">{{ $value->created_at->format('Y-m-d') }}</td>
                        <td class="string">
                            {{ $presenter->getOrderLocalNameByOrderType(
                                $value->order_type, class_basename($value))
                            }}
                            {{ $value->order_code }}
                        </td>
                        <td class="string">{{ $value->warehouse->name }}</td>
                        <td class="numeric">
                            {{ number_format($value->quantity) }}
                        </td>
                    </tr>
        @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"><hr></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td class="string">小計</td>
                        <td class="numeric">
                            {{
                                //計算小計
                                number_format(
                                    $data[$stock_id]->sum(function ($item) {
                                        return $item->quantity;
                                    })
                                )
                            }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endforeach
@endif
</div>