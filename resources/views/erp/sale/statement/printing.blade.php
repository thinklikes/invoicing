@extends('layouts.clean')
{{-- 注入庫存異動報表的presenter --}}
@inject('public', 'App\Presenters\PublicPresenter')

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
@if(count($data) > 0)
    @foreach($keys as $company_id)
    <div class="reportPerPage">
        <div class="clear"></div>
        <hr />
        <div class="imformation">
            <table class="width_01">
                <tr>
                    <th>客戶名稱：</th>
                    <td>{{ $data[$company_id][0]->company->company_name or null }}</td>
                    <th>客戶編號</th>
                    <td>{{ $data[$company_id][0]->company->company_code or null }}</td>
                </tr>
                <tr>
                    <th>統一編號：</th>
                    <td>{{ $data[$company_id][0]->company->VTA_NO or null }}</td>
                    <th>電話：</th>
                    <td>{{ $data[$company_id][0]->company->company_tel or null }}</td>
                </tr>
                <tr>
                    <th>聯絡地址：</th>
                    <td colspan="3">{{ $data[$company_id][0]->company->company_add or null }}</td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>
        <hr />
        <div class="head">
            <table class="width_01">
                <thead>
                    <tr>
                        <th class="string">日期</th>
                        <th class="string" width="150px">單據號碼</th>
                        <th class="string">發票號碼</th>
                        <th class="numeric">稅前合計</th>
                        <th class="numeric">營業稅</th>
                        <th class="numeric">已收金額</th>
                        <th class="numeric">應收金額</th>
                    </tr>
                </thead>
                <tbody>
        @foreach($data[$company_id] as $key => $value)
                    <tr>
                        <td class="string">{{ $value->date }}</td>
                        <td class="string">
                            {{ $public->getOrderLocalNameByOrderType(
                                class_basename($value))
                            }}
                            {{ $value->code }}
                        </td>
                        <td class="string">{{ $value->invoice_code }}</td>
                        <td class="string">
                            {{ number_format($value->total_no_tax_amount) }}
                        </td>
                        <td class="string">{{ number_format($value->tax) }}</td>
                        <td class="string">{{ number_format($value->received_amount) }}</td>
                        <td class="numeric">
                            {{ number_format($value->total_amount
                                - $value->received_amount)
                            }}
                        </td>
                    </tr>
        @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="numeric" colspan="7"><hr></td>
                    </tr>
                    <tr>

                        <td class="numeric" colspan="6">小計</td>
                        <td class="numeric">
                            {{
                                //計算小計
                                number_format(
                                    $data[$company_id]->sum(function ($item) {
                                        return $item->total_amount - $item->received_amount;
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
@yield('print_button_group')
</div>
@endsection