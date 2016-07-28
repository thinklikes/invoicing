@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('OrderCalculator', 'App\Presenters\OrderCalculator')

@section('content')
        {{ $OrderCalculator->setOrderMaster($stockTransferMaster) }}
        {{ $OrderCalculator->setOrderDetail($stockTransferDetail) }}
        {{ $OrderCalculator->calculate() }}
        <table id="master" width="100%">
            <tr>
                <td>轉倉日期</td>
                <td>{{ $PublicPresenter->getFormatDate($stockTransferMaster->created_at) }}</td>
                <td>轉倉單號</td>
                <td>{{ $stockTransferMaster->code }}</td>
            </tr>
            <tr>
                <th>轉倉單備註</th>
                <td colspan="3">
                    {{ $stockTransferMaster->note }}
                </td>
            </tr>
            <tr>
                <th>調出倉庫</th>
                <td>
                    {{ $stockTransferMaster->from_warehouse->name }}
                </td>
                <th>調入倉庫</th>
                <td>
                    {{ $stockTransferMaster->to_warehouse->name }}
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
                    <th class="numeric">成本</th>
                    <th class="numeric">金額</th>
                </tr>
            </thead>
            <tbody>

    @foreach($stockTransferDetail as $i => $value)
                <tr>
                    <td class="string">{{ $stockTransferDetail[$i]['stock_code'] }}</td>
                    <td class="string">{{ $stockTransferDetail[$i]['stock_name'] }}</td>
                    <td class="numeric">{{ $stockTransferDetail[$i]['quantity'] }}</td>
                    <td class="string">{{ $stockTransferDetail[$i]['unit'] }}</td>
                    <td class="numeric">{{ $stockTransferDetail[$i]['no_tax_price'] }}</td>
                    <td class="numeric">{{ $OrderCalculator->getNoTaxAmount($i) }}</td>
                </tr>
    @endforeach

            </tbody>
        </table>
        <hr>
{{--         <div style="width:50%;">
            <p>
                營業稅 {{ $PublicPresenter->getTaxComment($stockTransferMaster->tax_rate_code) }}
            </p>
        </div> --}}
        <div style="width:50%;height:100px;float:left;">
            <table>
                <tr>
                    <th>小計：</th>
                    <td>{{ $OrderCalculator->getTotalNoTaxAmount() }}</td>
                </tr>
            </table>
{{--             <table>
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
            </table> --}}
        </div>
        <div style="width:50%;height:100px;float:left;">
{{--             <table>
                <tr>
                    <td>已付款：</td>
                    <td align="right">{{ $stockTransferMaster->paid_amount }}</td>
                </tr>
                <tr>
                    <td>未付款：</td>
                    <td align="right">{{ $OrderCalculator->getTotalAmount() - $stockTransferMaster->paid_amount }}</td>
                </tr>
            </table> --}}
        </div>
        <a href="{{ url("/stockTransfer/{$stockTransferMaster->code}/edit") }}">維護轉倉單</a>
        <form action="{{ url("/stockTransfer/{$stockTransferMaster->code}") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除轉倉單</button>
        </form>
        <br>
        <a href="{{ url("/stockTransfer/{$stockTransferMaster->code}/printing") }}" target="_blank">列印轉倉單</a>
@endsection
