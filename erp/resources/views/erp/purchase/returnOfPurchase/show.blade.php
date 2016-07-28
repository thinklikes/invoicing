@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('OrderCalculator', 'App\Presenters\OrderCalculator')

@section('content')
        {{ $OrderCalculator->setOrderMaster($returnOfPurchaseMaster) }}
        {{ $OrderCalculator->setOrderDetail($returnOfPurchaseDetail) }}
        {{ $OrderCalculator->calculate() }}
        <table id="master" width="100%">
            <tr>
                <td>進貨退回日期</td>
                <td>{{ $PublicPresenter->getFormatDate($returnOfPurchaseMaster->created_at) }}</td>
                <td>進貨退回單號</td>
                <td>{{ $returnOfPurchaseMaster->code }}</td>
                <td>發票號碼</td>
                <td>{{ $returnOfPurchaseMaster->invoice_code }}</td>
            </tr>
            <tr>
                <th>供應商</th>
                <td colspan="5">
                    {{ $returnOfPurchaseMaster->supplier_code }}
                    {{ $returnOfPurchaseMaster->supplier_name }}
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
                    <th class="string">料品編號</th>
                    <th class="string">品名</th>
                    <th class="numeric">數量</th>
                    <th class="string">單位</th>
                    <th class="numeric">稅前單價</th>
                    <th class="numeric">小計</th>
                </tr>
            </thead>
            <tbody>

    @foreach($returnOfPurchaseDetail as $i => $value)
                <tr>
                    <td class="string">{{ $returnOfPurchaseDetail[$i]['stock_code'] }}</td>
                    <td class="string">{{ $returnOfPurchaseDetail[$i]['stock_name'] }}</td>
                    <td class="numeric">{{ $returnOfPurchaseDetail[$i]['quantity'] }}</td>
                    <td class="string">{{ $returnOfPurchaseDetail[$i]['unit'] }}</td>
                    <td class="numeric">{{ $returnOfPurchaseDetail[$i]['no_tax_price'] }}</td>
                    <td class="numeric">{{ $OrderCalculator->getNoTaxAmount($i) }}</td>
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
                    <td align="right">{{ $returnOfPurchaseMaster->paid_amount }}</td>
                </tr>
                <tr>
                    <td>未付款：</td>
                    <td align="right">{{ $OrderCalculator->getTotalAmount() - $returnOfPurchaseMaster->paid_amount }}</td>
                </tr>
            </table>
        </div>
    @if ($returnOfPurchaseMaster->paid_amount == 0)
        <a href="{{ url("/returnOfPurchase/{$returnOfPurchaseMaster->code}/edit") }}">維護進貨退回單</a>
        <form action="{{ url("/returnOfPurchase/{$returnOfPurchaseMaster->code}") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除進貨退回單</button>
        </form>
    @endif
        <br>
        <a href="{{ url("/returnOfPurchase/{$returnOfPurchaseMaster->code}/printing") }}" target="_blank">列印進貨退回單</a>
@endsection
