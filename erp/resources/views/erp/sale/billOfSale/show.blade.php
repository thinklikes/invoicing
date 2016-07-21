@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('OrderCalculator', 'App\Presenters\OrderCalculator')

@section('content')
        {{ $OrderCalculator->setOrderMaster($billOfSaleMaster) }}
        {{ $OrderCalculator->setOrderDetail($billOfSaleDetail) }}
        {{ $OrderCalculator->calculate() }}
        <table id="master" width="100%">
            <tr>
                <td>銷貨日期</td>
                <td>{{ $PublicPresenter->getFormatDate($billOfSaleMaster->created_at) }}</td>
                <td>銷貨單號</td>
                <td>{{ $billOfSaleMaster->code }}</td>
                <td>發票號碼</td>
                <td>{{ $billOfSaleMaster->invoice_code }}</td>
            </tr>
            <tr>
                <th>客戶</th>
                <td colspan="5">
                    {{-- $billOfSaleMaster->company_code --}}
                    {{ $billOfSaleMaster->company_name }}
                </td>
            </tr>
            <tr>
                <th>銷貨單備註</th>
                <td colspan="5">
                    {{ $billOfSaleMaster->note }}
                </td>
            </tr>
            <tr>
                <th>銷貨倉庫</th>
                <td colspan="5">
                    {{ $billOfSaleMaster->warehouse->name }}
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

    @foreach($billOfSaleDetail as $i => $value)
                <tr>
                    <td>{{ $billOfSaleDetail[$i]['stock_code'] }}</td>
                    <td>{{ $billOfSaleDetail[$i]['stock_name'] }}</td>
                    <td align="right">{{ $billOfSaleDetail[$i]['quantity'] }}</td>
                    <td>{{ $billOfSaleDetail[$i]['unit'] }}</td>
                    <td align="right">{{ $billOfSaleDetail[$i]['no_tax_price'] }}</td>
                    <td align="right">{{ $OrderCalculator->getNoTaxAmount($i) }}</td>
                </tr>
    @endforeach

            </tbody>
        </table>
        <hr>
        <div style="width:50%;">
            <p>
                營業稅 {{ $PublicPresenter->getTaxComment($billOfSaleMaster->tax_rate_code) }}
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
                    <td>已收款：</td>
                    <td align="right">{{ $billOfSaleMaster['received_amount'] }}</td>
                </tr>
                <tr>
                    <td>未收款：</td>
                    <td align="right">{{ $OrderCalculator->getTotalAmount() - $billOfSaleMaster['received_amount'] }}</td>
                </tr>
            </table>
        </div>
    @if ($billOfSaleMaster['received_amount'] == 0)
        <a href="{{ url("/billOfSale/{$billOfSaleMaster->code}/edit") }}">維護銷貨單</a>
        <form action="{{ url("/billOfSale/{$billOfSaleMaster->code}") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除銷貨單</button>
        </form>
    @endif
        <br>
        <a href="{{ url("/billOfSale/{$billOfSaleMaster->code}/print") }}" target="_blank">列印銷貨單</a>
@endsection
