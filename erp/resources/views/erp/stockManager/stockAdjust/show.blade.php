@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('OrderCalculator', 'App\Presenters\OrderCalculator')

@section('content')
        {{ $OrderCalculator->setOrderMaster($stockAdjustMaster) }}
        {{ $OrderCalculator->setOrderDetail($stockAdjustDetail) }}
        {{ $OrderCalculator->calculate() }}
        <table id="master" width="100%">
            <tr>
                <td>調整日期</td>
                <td>{{ $PublicPresenter->getFormatDate($stockAdjustMaster->created_at) }}</td>
                <td>調整單號</td>
                <td>{{ $stockAdjustMaster->code }}</td>
            </tr>
            <tr>
                <th>調整單備註</th>
                <td colspan="3">
                    {{ $stockAdjustMaster->note }}
                </td>
            </tr>
            <tr>
                <th>調整倉庫</th>
                <td colspan="3">
                    {{ $stockAdjustMaster->warehouse->name }}
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

    @foreach($stockAdjustDetail as $i => $value)
                <tr>
                    <td class="string">{{ $stockAdjustDetail[$i]['stock_code'] }}</td>
                    <td class="string">{{ $stockAdjustDetail[$i]['stock_name'] }}</td>
                    <td class="numeric">{{ $stockAdjustDetail[$i]['quantity'] }}</td>
                    <td class="string">{{ $stockAdjustDetail[$i]['unit'] }}</td>
                    <td class="numeric">{{ $stockAdjustDetail[$i]['no_tax_price'] }}</td>
                    <td class="numeric">{{ $OrderCalculator->getNoTaxAmount($i) }}</td>
                </tr>
    @endforeach

            </tbody>
        </table>
        <hr>
{{--         <div style="width:50%;">
            <p>
                營業稅 {{ $PublicPresenter->getTaxComment($stockAdjustMaster->tax_rate_code) }}
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
                    <td align="right">{{ $stockAdjustMaster->paid_amount }}</td>
                </tr>
                <tr>
                    <td>未付款：</td>
                    <td align="right">{{ $OrderCalculator->getTotalAmount() - $stockAdjustMaster->paid_amount }}</td>
                </tr>
            </table> --}}
        </div>
        <a href="{{ url("/stockAdjust/{$stockAdjustMaster->code}/printing") }}" target="_blank" class="btn btn-default">列印調整單</a>
        <a href="{{ url("/stockAdjust/{$stockAdjustMaster->code}/edit") }}" class="btn btn-default">維護調整單</a>
        <form action="{{ url("/stockAdjust/{$stockAdjustMaster->code}") }}" class="form_of_delete" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button class="btn btn-danger">刪除調整單</button>
        </form>
@endsection
