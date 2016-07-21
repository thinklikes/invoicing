@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('OrderCalculator', 'App\Presenters\OrderCalculator')
        {{ $OrderCalculator->setOrderMaster($stockAdjustMaster) }}
        {{ $OrderCalculator->setOrderDetail($stockAdjustDetail) }}
        {{ $OrderCalculator->calculate() }}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/print.css') }}">
<div class="main_page">
    <div class="information_container">
        <div class="company_information">
            <table>
                <tr><td>{{ config("system_configs.company_name") }}</td></tr>
                <tr><td>{{ config("system_configs.company_address") }}</td></tr>
                <tr><td>{{ config("system_configs.company_phone_number") }}</td></tr>
            </table>
        </div>
        <div class="order_information">
            <table>
                <tr>
                    <td><u>調整單</u></td>
                </tr>
            </table>
        </div>
    </div>
        <table id="master">
            <tr>
                <th>調整日期</th>
                <td>{{ $PublicPresenter->getFormatDate($stockAdjustMaster->created_at) }}</td>
                <th>調整單號</th>
                <td>{{ $stockAdjustMaster->code }}</td>
            </tr>
            <tr>
                <th>調整倉庫</th>
                <td colspan="3">
                    {{ $stockAdjustMaster->warehouse->name }}
                </td>
            </tr>
            <tr>
                <th>調整單備註</th>
                <td colspan="3">
                    {{ $stockAdjustMaster->note }}
                </td>
            </tr>
        </table>
        <hr>
        <table id="detail">
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

    @foreach($stockAdjustDetail as $i => $value)
                <tr>
                    <td class="string">{{ $stockAdjustDetail[$i]->stock->code }}</td>
                    <td class="string">{{ $stockAdjustDetail[$i]->stock->name }}</td>
                    <td class="numeric">{{ $stockAdjustDetail[$i]['quantity'] }}</td>
                    <td class="string">{{ $stockAdjustDetail[$i]->stock->unit->comment }}</td>
                    <td class="numeric">{{ $stockAdjustDetail[$i]['no_tax_price'] }}</td>
                    <td class="numeric">{{ $OrderCalculator->getNoTaxAmount($i) }}</td>
                </tr>
    @endforeach

            </tbody>
        </table>
        <hr>
        <div class="subTotal">
            <table>
                <tr>
                    <td>稅前合計：</td>
                    <td>{{ $OrderCalculator->getTotalNoTaxAmount() }}</td>
                    <td>營業稅：</td>
                    <td>{{ $OrderCalculator->getTax() }}</td>
                    <td>應付總計：</td>
                    <td>{{ $OrderCalculator->getTotalAmount() }}</td>
                </tr>
            </table>
        </div>
        <hr>
        <div class="signOn">
            <table>
                <tr>
                    <td>審核：</td>
                    <td></td>
                    <td>經辦：</td>
                    <td></td>
                    <td>會計：</td>
                    <td></td>
                    <td>業務：</td>
                    <td></td>
                    <td>簽收：</td>
                    <td></td>
                </tr>
            </table>
        </div>
</div>
<script type="text/javascript">window.print();</script>