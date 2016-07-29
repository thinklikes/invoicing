{{-- 注入庫存異動報表的presenter --}}
@inject('presenter', 'Statement\StatementPresenter')
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
                    <td colspan="2">對帳單</td>
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
    <table id="master">
        <tr>
            <th>客戶編號</th>
            <td>{{ $company->company_code }}</td>
            <th>客戶名稱</th>
            <td>{{ $company->company_name }}</td>
            <th></th>
            <td></td>
        </tr>
        <tr>
            <th>統一編號</th>
            <td>
                {{ $company->VTA_NO }}
            </td>
            <th>電話</th>
            <td>
                {{ $company->company_tel }}
            </td>
            <th>地址</th>
            <td>{{ $company->company_add }}</td>
        </tr>
    </table>
    <hr>
    <table width="100%">
        <thead>
            <tr>
                <th class="string">日期</th>
                <th class="string">單據號碼</th>
                <th class="string">發票號碼</th>
                <th class="numeric">未稅金額</th>
                <th class="numeric">營業稅</th>
                <th class="numeric">已收金額</th>
                <th class="numeric">應收金額</th>
            </tr>
        </thead>
@if(count($data) > 0)
        <tbody>
    @foreach($data as $key => $value)
            <tr>
                <td class="string">{{ $value->created_at->format('Y-m-d') }}</td>
                <td class="string">
                    {{ $presenter->getOrderLocalNameByOrderType(
                        class_basename($value))
                    }}
                    {{ $value->code }}
                </td>
                <td class="string">{{ $value->invoice_code }}</td>
                <td class="string">{{ $value->total_no_tax_amount }}</td>
                <td class="string">{{ $value->tax }}</td>
                <td class="string">{{ $value->received_amount }}</td>
                <td class="numeric">{{ $value->total_amount -  $value->received_amount}}</td>
            </tr>
    @endforeach
@endif
        </tbody>
        <tfoot>
            <tr>
                <td class="numeric" colspan="6">小計</td>
                <td class="numeric">
                    {{
                        //計算小計
                        $data->sum(function ($item) {
                            return $item->total_amount - $item->received_amount;
                        })
                    }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>

