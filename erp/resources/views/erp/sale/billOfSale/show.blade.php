@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('discount', 'Sale\Discount\DiscountPresenter')

@include('erp.show_button_group', [
    'print_enabled' => true,
    'delete_enabled' => $billOfSaleMaster['received_amount'] == 0,
    'edit_enabled'   => $billOfSaleMaster['received_amount'] == 0,
    'chname'         => '銷貨單',
    'route_name'     => 'billOfSale',
    'code'           => $billOfSaleMaster->code
])

@section('content')
        <table id="master" width="100%" class="table">
            <tr>
                <td>開單日期</td>
                <td>{{ $billOfSaleMaster->date }}</td>
                <td>銷貨單號</td>
                <td>{{ $billOfSaleMaster->code }}</td>
                <td>發票號碼</td>
                <td>{{ $billOfSaleMaster->invoice_code }}</td>
            </tr>
            <tr>
                <th>客戶</th>
                <td colspan="5">
                    {{ $billOfSaleMaster->company->company_code }}
                    {{ $billOfSaleMaster->company->company_name }}
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
        <table id="detail" width="100%" class="table">
            <thead>
                <tr>
                    <th class="string">料品編號</th>
                    <th class="string">料品名稱</th>
                    <th class="string">優惠折扣</th>
                    <th class="numeric">料品數量</th>
                    <th class="string">料品單位</th>
                    <th class="numeric">稅前單價</th>
                    <th class="numeric">未稅金額</th>
                </tr>
            </thead>
            <tbody>

    @foreach($billOfSaleDetail as $i => $value)
                <tr>
                    <td class="string">{{ $billOfSaleDetail[$i]['stock']->code }}</td>
                    <td class="string">{{ $billOfSaleDetail[$i]['stock']->name }}</td>
                    <td class="string">
                        {{
                            $discount->generateDiscountComment(
                                $billOfSaleDetail[$i]['discount'])
                        }}
                    </td>
                    <td class="numeric">{{ $billOfSaleDetail[$i]['quantity'] }}</td>
                    <td class="string">{{ $billOfSaleDetail[$i]['stock']->unit->comment }}</td>
                    <td class="numeric">{{ $billOfSaleDetail[$i]['no_tax_price'] }}</td>
                    <td class="numeric">{{ $billOfSaleDetail[$i]['no_tax_amount'] }}</td>
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
            <table class="table">
                <tr>
                    <td>稅前合計：</td>
                    <td align="right">{{ $billOfSaleMaster['total_no_tax_amount'] }}</td>
                </tr>
                <tr>
                    <td>營業稅：</td>
                    <td align="right">{{ $billOfSaleMaster['tax'] }}</td>
                </tr>
                <tr>
                    <td>金額總計：</td>
                    <td align="right">{{ $billOfSaleMaster['total_amount'] }}</td>
                </tr>
            </table>
        </div>
        <div style="width:50%;height:100px;float:left;">
            <table class="table">
                <tr>
                    <td>已收款：</td>
                    <td align="right">{{ $billOfSaleMaster['received_amount'] }}</td>
                </tr>
                <tr>
                    <td>未收款：</td>
                    <td align="right">{{ $billOfSaleMaster['total_amount'] - $billOfSaleMaster['received_amount'] }}</td>
                </tr>
            </table>
        </div>
    @yield('show_button_group')
@endsection
