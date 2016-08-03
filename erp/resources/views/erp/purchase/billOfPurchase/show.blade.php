@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('OrderCalculator', 'App\Presenters\OrderCalculator')

@section('content')
        {{ $OrderCalculator->setOrderMaster($billOfPurchaseMaster) }}
        {{ $OrderCalculator->setOrderDetail($billOfPurchaseDetail) }}
        {{ $OrderCalculator->calculate() }}
        <table id="master" width="100%">
            <tr>
                <td>進貨日期</td>
                <td>{{ $PublicPresenter->getFormatDate($billOfPurchaseMaster->created_at) }}</td>
                <td>進貨單號</td>
                <td>{{ $billOfPurchaseMaster->code }}</td>
                <td>發票號碼</td>
                <td>{{ $billOfPurchaseMaster->invoice_code }}</td>
            </tr>
            <tr>
                <th>供應商</th>
                <td colspan="5">
                    {{ $billOfPurchaseMaster->supplier_code }}
                    {{ $billOfPurchaseMaster->supplier_name }}
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
                    <th class="string">料品編號</th>
                    <th class="string">品名</th>
                    <th class="numeric">數量</th>
                    <th class="string">單位</th>
                    <th class="numeric">稅前單價</th>
                    <th class="numeric">小計</th>
                </tr>
            </thead>
            <tbody>

    @foreach($billOfPurchaseDetail as $i => $value)
                <tr>
                    <td class="string">{{ $billOfPurchaseDetail[$i]['stock_code'] }}</td>
                    <td class="string">{{ $billOfPurchaseDetail[$i]['stock_name'] }}</td>
                    <td class="numeric">{{ $billOfPurchaseDetail[$i]['quantity'] }}</td>
                    <td class="string">{{ $billOfPurchaseDetail[$i]['unit'] }}</td>
                    <td class="numeric">{{ $billOfPurchaseDetail[$i]['no_tax_price'] }}</td>
                    <td class="numeric">{{ $OrderCalculator->getNoTaxAmount($i) }}</td>
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
                    <td align="right">{{ $OrderCalculator->getTotalNoTaxAmount() }}</td>
                </tr>
                <tr>
                    <td>營業稅：</td>
                    <td align="right">{{ $OrderCalculator->getTax() }}</td>
                </tr>
                <tr>
                    <td>應付總計：</td>
                    <td align="right">{{ $OrderCalculator->getTotalAmount() }}</td>
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
                    <td align="right">{{ $OrderCalculator->getTotalAmount() - $billOfPurchaseMaster->paid_amount }}</td>
                </tr>
            </table>
        </div>
        <a href="{{ url("/billOfPurchase/{$billOfPurchaseMaster->code}/printing") }}" target="_blank" class="btn btn-default">列印進貨單</a>
    @if ($billOfPurchaseMaster->paid_amount == 0)
        <a href="{{ url("/billOfPurchase/{$billOfPurchaseMaster->code}/edit") }}" class="btn btn-default">維護進貨單</a>
        <form action="{{ url("/billOfPurchase/{$billOfPurchaseMaster->code}") }}" class="form_of_delete" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button class="btn btn-danger">刪除進貨單</button>
        </form>
    @endif
@endsection
