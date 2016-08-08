@extends('layouts.app')
@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@include('erp.show_button_group', [
    'print_enabled' => true,
    'delete_enabled' => $returnOfSaleMaster['received_amount'] == 0,
    'edit_enabled'   => $returnOfSaleMaster['received_amount'] == 0,
    'chname'         => '銷貨退回單',
    'route_name'     => 'returnOfSale',
    'code'           => $returnOfSaleMaster->code
])

@section('content')
        <table id="master" width="100%">
            <tr>
                <td>開單日期</td>
                <td>{{ $returnOfSaleMaster->date }}</td>
                <td>銷貨退回單號</td>
                <td>{{ $returnOfSaleMaster->code }}</td>
                <td>發票號碼</td>
                <td>{{ $returnOfSaleMaster->invoice_code }}</td>
            </tr>
            <tr>
                <th>客戶</th>
                <td colspan="5">
                    {{ $returnOfSaleMaster->company->company_code }}
                    {{ $returnOfSaleMaster->company->company_name }}
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
                    <th class="string">料品編號</th>
                    <th class="string">料品名稱</th>
                    <th class="numeric">料品數量</th>
                    <th class="string">料品單位</th>
                    <th class="numeric">稅前單價</th>
                    <th class="numeric">未稅金額</th>
                </tr>
            </thead>
            <tbody>

    @foreach($returnOfSaleDetail as $i => $value)
                <tr>
                    <td class="string">{{ $returnOfSaleDetail[$i]['stock']->code }}</td>
                    <td class="string">{{ $returnOfSaleDetail[$i]['stock']->name }}</td>
                    <td class="numeric">{{ $returnOfSaleDetail[$i]['quantity'] }}</td>
                    <td class="string">{{ $returnOfSaleDetail[$i]['stock']->unit->comment }}</td>
                    <td class="numeric">{{ $returnOfSaleDetail[$i]['no_tax_price'] }}</td>
                    <td class="numeric">{{ $returnOfSaleDetail[$i]['no_tax_amount'] }}</td>
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
                    <td align="right">{{ $returnOfSaleMaster['total_no_tax_amount'] }}</td>
                </tr>
                <tr>
                    <td>營業稅：</td>
                    <td align="right">{{ $returnOfSaleMaster['tax'] }}</td>
                </tr>
                <tr>
                    <td>金額總計：</td>
                    <td align="right">{{ $returnOfSaleMaster['total_amount'] }}</td>
                </tr>
            </table>
        </div>
        <div style="width:50%;height:100px;float:left;">
            <table>
                <tr>
                    <td>已收款：</td>
                    <td align="right">{{ $returnOfSaleMaster['received_amount'] }}</td>
                </tr>
                <tr>
                    <td>未收款：</td>
                    <td align="right">{{ $returnOfSaleMaster['total_amount']
                        - $returnOfSaleMaster['received_amount'] }}</td>
                </tr>
            </table>
        </div>
    {{-- 資料檢視頁的按鈕群組 --}}
    @yield('show_button_group')
@endsection
