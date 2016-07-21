@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('OrderCalculator', 'App\Presenters\OrderCalculator')

@section('content')
        {{ $OrderCalculator->setOrderMaster($returnOfSaleMaster) }}
        {{ $OrderCalculator->setOrderDetail($returnOfSaleDetail) }}
        {{ $OrderCalculator->calculate() }}
        <table id="master" width="100%">
            <tr>
                <td>銷貨退回日期</td>
                <td>{{ $PublicPresenter->getFormatDate($returnOfSaleMaster->created_at) }}</td>
                <td>銷貨退回單號</td>
                <td>{{ $returnOfSaleMaster->code }}</td>
                <td>發票號碼</td>
                <td>{{ $returnOfSaleMaster->invoice_code }}</td>
            </tr>
            <tr>
                <th>客戶</th>
                <td colspan="5">
                    {{ $returnOfSaleMaster->company_code }}
                    {{ $returnOfSaleMaster->company_name }}
                </td>
            </tr>
            <tr>
                <th>銷貨退回單備註</th>
                <td colspan="5">
                    {{ $returnOfSaleMaster->note }}
                </td>
            </tr>
            <tr>
                <th>銷貨退回倉庫</th>
                <td colspan="5">
                    {{ $returnOfSaleMaster->warehouse->name }}
                </td>
            </tr>
        </table>
        <hr>
        <table id="detail" width="100%">
            <thead>
                <tr>
                    <th>料品編號</th>
                    <th>品名</th>
                    <th>數量</th>
                    <th>單位</th>
                    <th>稅前單價</th>
                    <th>小計</th>
                </tr>
            </thead>
            <tbody>

    @foreach($returnOfSaleDetail as $i => $value)
                <tr>
                    <td>{{ $returnOfSaleDetail[$i]['stock_code'] }}</td>
                    <td>{{ $returnOfSaleDetail[$i]['stock_name'] }}</td>
                    <td align="right">{{ $returnOfSaleDetail[$i]['quantity'] }}</td>
                    <td>{{ $returnOfSaleDetail[$i]['unit'] }}</td>
                    <td align="right">{{ $returnOfSaleDetail[$i]['no_tax_price'] }}</td>
                    <td align="right">{{ $OrderCalculator->getNoTaxAmount($i) }}</td>
                </tr>
    @endforeach

            </tbody>
        </table>
        <hr>
        <div style="width:50%;">
            <p>
                營業稅 {{ $PublicPresenter->getTaxComment($returnOfSaleMaster->tax_rate_code) }}
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
                    <td align="right">{{ $returnOfSaleMaster['received_amount'] }}</td>
                </tr>
                <tr>
                    <td>未付款：</td>
                    <td align="right">{{ $OrderCalculator->getTotalAmount() - $returnOfSaleMaster['received_amount'] }}</td>
                </tr>
            </table>
        </div>
    @if ($returnOfSaleMaster['received_amount'] == 0)
        <a href="{{ url("/returnOfSale/{$returnOfSaleMaster->code}/edit") }}">維護銷貨退回單</a>
        <form action="{{ url("/returnOfSale/{$returnOfSaleMaster->code}") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除銷貨退回單</button>
        </form>
    @endif
        <br>
        <a href="{{ url("/returnOfSale/{$returnOfSaleMaster->code}/print") }}" target="_blank">列印銷貨退回單</a>
@endsection
