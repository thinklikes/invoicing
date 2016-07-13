@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('OrderCalculator', 'App\Presenters\OrderCalculator')

@section('content')
        {{ $OrderCalculator->setOrderMaster($purchase_order_master) }}
        {{ $OrderCalculator->setOrderDetail($purchase_order_detail) }}
        {{ $OrderCalculator->calculate() }}
        <table id="master" width="100%">
            <tr>
                <td>採購日期</td>
                <td>{{ $PublicPresenter->getFormatDate($purchase_order_master->created_at) }}</td>
                <td>採購單號</td>
                <td>{{ $purchase_order_master->code }}</td>
                <td>交貨日期</td>
                <td>{{ $purchase_order_master->delivery_date }}</td>
            </tr>
            <tr>
                <th>供應商</th>
                <td colspan="5">
                    {{ $purchase_order_master->supplier_code }}
                    {{ $purchase_order_master->supplier_name }}
                </td>
            </tr>
            <tr>
                <th>採購單備註</th>
                <td colspan="5">
                    {{ $purchase_order_master->note }}
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

    @foreach($purchase_order_detail as $i => $value)
                <tr>
                    <td>{{ $purchase_order_detail[$i]['stock_code'] }}</td>
                    <td>{{ $purchase_order_detail[$i]['stock_name'] }}</td>
                    <td align="right">{{ $purchase_order_detail[$i]['quantity'] }}</td>
                    <td>{{ $purchase_order_detail[$i]['unit'] }}</td>
                    <td align="right">{{ $purchase_order_detail[$i]['no_tax_price'] }}</td>
                    <td align="right">{{ $OrderCalculator->getNoTaxAmount($i) }}</td>
                </tr>
    @endforeach

            </tbody>
        </table>
        <hr>
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
        <div style="width:50%;height:100px;float:right;">
            營業稅 {{ $PublicPresenter->getTaxComment($purchase_order_master->tax_rate_code) }}
        </div>
        <a href="{{ url("/purchase_orders/$code/edit") }}">維護採購單</a>
        <form action="{{ url("/purchase_orders/$code") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除採購單</button>
        </form>

@endsection
