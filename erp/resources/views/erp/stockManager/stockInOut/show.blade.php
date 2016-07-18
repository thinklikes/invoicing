@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('OrderCalculator', 'App\Presenters\OrderCalculator')

@section('content')
        {{ $OrderCalculator->setOrderMaster($stockInOutMaster) }}
        {{ $OrderCalculator->setOrderDetail($stockInOutDetail) }}
        {{ $OrderCalculator->calculate() }}
        <table id="master" width="100%">
            <tr>
                <td>調整日期</td>
                <td>{{ $PublicPresenter->getFormatDate($stockInOutMaster->created_at) }}</td>
                <td>調整單號</td>
                <td>{{ $stockInOutMaster->code }}</td>
            </tr>
            <tr>
                <th>調整單備註</th>
                <td colspan="3">
                    {{ $stockInOutMaster->note }}
                </td>
            </tr>
            <tr>
                <th>調整倉庫</th>
                <td colspan="3">
                    {{ $stockInOutMaster->warehouse->name }}
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
                    <th>成本</th>
                    <th>金額</th>
                </tr>
            </thead>
            <tbody>

    @foreach($stockInOutDetail as $i => $value)
                <tr>
                    <td>{{ $stockInOutDetail[$i]['stock_code'] }}</td>
                    <td>{{ $stockInOutDetail[$i]['stock_name'] }}</td>
                    <td align="right">{{ $stockInOutDetail[$i]['quantity'] }}</td>
                    <td>{{ $stockInOutDetail[$i]['unit'] }}</td>
                    <td align="right">{{ $stockInOutDetail[$i]['no_tax_price'] }}</td>
                    <td align="right">{{ $OrderCalculator->getNoTaxAmount($i) }}</td>
                </tr>
    @endforeach

            </tbody>
        </table>
        <hr>
{{--         <div style="width:50%;">
            <p>
                營業稅 {{ $PublicPresenter->getTaxComment($stockInOutMaster->tax_rate_code) }}
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
                    <td align="right">{{ $stockInOutMaster->paid_amount }}</td>
                </tr>
                <tr>
                    <td>未付款：</td>
                    <td align="right">{{ $OrderCalculator->getTotalAmount() - $stockInOutMaster->paid_amount }}</td>
                </tr>
            </table> --}}
        </div>
        <a href="{{ url("/stockInOut/{$stockInOutMaster->code}/edit") }}">維護調整單</a>
        <form action="{{ url("/stockInOut/{$stockInOutMaster->code}") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除調整單</button>
        </form>
@endsection
