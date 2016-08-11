@extends('layouts.app')
@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@include('erp.show_button_group', [
    'print_enabled' => true,
    'delete_enabled' => $billOfPurchaseMaster['paid_amount'] == 0,
    'edit_enabled'   => $billOfPurchaseMaster['paid_amount'] == 0,
    'chname'         => '進貨單',
    'route_name'     => 'billOfPurchase',
    'code'           => $billOfPurchaseMaster->code
])


@section('content')
        <table id="master" width="100%">
            <tr>
                <td>開單日期</td>
                <td>{{ $billOfPurchaseMaster->date }}</td>
                <td>進貨單號</td>
                <td>{{ $billOfPurchaseMaster->code }}</td>
                <td>發票號碼</td>
                <td>{{ $billOfPurchaseMaster->invoice_code }}</td>
            </tr>
            <tr>
                <th>供應商</th>
                <td colspan="5">
                    {{ $billOfPurchaseMaster->supplier->code }}
                    {{ $billOfPurchaseMaster->supplier->name }}
                </td>
            </tr>
            <tr>
                <th>進貨單備註</th>
                <td colspan="5">
                    {{ $billOfPurchaseMaster->note }}
                </td>
            </tr>
            <tr>
                <th>進貨倉庫</th>
                <td colspan="5">
                    {{ $billOfPurchaseMaster->warehouse->name }}
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

    @foreach($billOfPurchaseDetail as $i => $value)
                <tr>
                    <td>{{ $billOfPurchaseDetail[$i]['stock']->code }}</td>
                    <td>{{ $billOfPurchaseDetail[$i]['stock']->name }}</td>
                    <td class="numeric">{{ $billOfPurchaseDetail[$i]['quantity'] }}</td>
                    <td class="string">{{ $billOfPurchaseDetail[$i]['stock']->unit->comment }}</td>
                    <td class="numeric">{{ $billOfPurchaseDetail[$i]['no_tax_price'] }}</td>
                    <td class="numeric">{{ $billOfPurchaseDetail[$i]['no_tax_amount'] }}</td>
                </tr>
    @endforeach

            </tbody>
        </table>
        <hr>
        <div style="width:50%;">
            <p>
                營業稅 {{ $PublicPresenter->getTaxComment($billOfPurchaseMaster->tax_rate_code) }}
            </p>
        </div>
        <div style="width:50%;height:100px;float:left;">
            <table>
                <tr>
                    <td>稅前合計：</td>
                    <td align="right">{{ $billOfPurchaseMaster->total_no_tax_amount }}</td>
                </tr>
                <tr>
                    <td>營業稅：</td>
                    <td align="right">{{ $billOfPurchaseMaster->tax }}</td>
                </tr>
                <tr>
                    <td>金額總計：</td>
                    <td align="right">{{ $billOfPurchaseMaster->total_amount }}</td>
                </tr>
            </table>
        </div>
        <div style="width:50%;height:100px;float:left;">
            <table>
                <tr>
                    <td>已付款：</td>
                    <td align="right">{{ $billOfPurchaseMaster->paid_amount }}</td>
                </tr>
                <tr>
                    <td>未付款：</td>
                    <td align="right">{{ $billOfPurchaseMaster->total_amount
                        - $billOfPurchaseMaster->paid_amount }}</td>
                </tr>
            </table>
        </div>
    {{-- 資料檢視頁的按鈕群組 --}}
    @yield('show_button_group')
@endsection
