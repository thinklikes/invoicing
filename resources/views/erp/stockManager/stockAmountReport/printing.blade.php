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
                    <td colspan="2">庫存總表</td>
                </tr>
                <tr>
                    <td>製表日期：</td>
                    <td>{{ Carbon\Carbon::today()->format('Y-m-d') }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
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
                    <td>{{ $data[$stock_id][0]->stock->name or null }}</td>
                    <th>料品單位</th>
                    <td>{{ $data[$stock_id][0]->stock->unit->comment or null }}</td>
                </tr>
                <tr>
                    <th>料品代號：</th>
                    <td>{{ $data[$stock_id][0]->stock->code or null }}</td>
                    <th>料品類別</th>
                    <td>{{ $data[$stock_id][0]->stock->stock_class->comment or null }}</td>
                </tr>
            </table>
        </div>
        <div class="head">
            <table>
                <thead>
                    <tr>
                        <th class="string">倉庫</th>
                        <th class="numeric">數量</th>
                        <th class="numeric">進貨價格</th>
                        <th class="numeric">小計</th>
                    </tr>
                </thead>
                <tbody>
        @foreach($data[$stock_id] as $key => $value)
                    <tr>
                        <td class="string">{{ $value->warehouse->name or null }}</td>
                        <td class="numeric">
                            {{ number_format($value->inventory) }}
                        </td>
                        <td class="numeric">
                            {{ $value->stock->no_tax_price_of_purchased or null }}
                        </td>
                        <td class="numeric">
                            {{
                                number_format($value->stock->no_tax_price_of_purchased
                                    * $value->inventory)
                            }}
                        </td>
                    </tr>
        @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"><hr></td>
                    </tr>
                    <tr>
                        <td class="string">合計</td>
                        <td class="numeric">
                            {{
                                //計算小計
                                number_format(
                                    $data[$stock_id]->sum(function ($item) {
                                        return $item->inventory;
                                    })
                                )
                            }}
                        </td>
                        <td></td>
                        <td class="numeric">
                            {{
                                //計算小計
                                number_format(
                                    $data[$stock_id]->sum(function ($item) {
                                        return $item->inventory
                                            * $item->stock->no_tax_price_of_purchased;
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
    <div class="clear"></div>
    <hr />
    <div class="reportPerPage">
        <div class="total">
            <table>
                <tr>
                    <th class="string" colspan="3" width="60%">總計</th>
                    <td class="numeric">
                        {{
                            //計算稅前合計的合計
                            number_format(
                                collect($data)->sum(function ($item) {
                                    return $item->sum(function ($item) {
                                        return $item->inventory
                                            * $item->stock->no_tax_price_of_purchased;
                                    });
                                })
                            )
                        }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endif
@yield('print_button_group')
</div>
@endsection