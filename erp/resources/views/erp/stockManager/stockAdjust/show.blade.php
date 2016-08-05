@extends('layouts.app')
@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@include('erp.show_button_group', [
    'print_enabled' => false,
    'delete_enabled' => true,
    'edit_enabled'   => true,
    'chname'         => '調整單',
    'route_name'     => 'stockAdjust',
    'code'           => $stockAdjustMaster->code
])

@section('content')
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
                    <th>料品編號</th>
                    <th>料品名稱</th>
                    <th class="numeric">料品數量</th>
                    <th class="string">料品單位</th>
                    <th class="numeric">未稅單價</th>
                    <th class="numeric">金額總計</th>
                </tr>
            </thead>
            <tbody>

    @foreach($stockAdjustDetail as $i => $value)
                <tr>
                    <td class="string">{{ $stockAdjustDetail[$i]['stock']->code }}</td>
                    <td class="string">{{ $stockAdjustDetail[$i]['stock']->name }}</td>
                    <td class="numeric">{{ $stockAdjustDetail[$i]['quantity'] }}</td>
                    <td class="string">{{ $stockAdjustDetail[$i]['stock']->unit->comment }}</td>
                    <td class="numeric">{{ $stockAdjustDetail[$i]['no_tax_price'] }}</td>
                    <td class="numeric">{{ $stockAdjustDetail[$i]['no_tax_amount'] }}</td>
                </tr>
    @endforeach

            </tbody>
        </table>
        <hr>
        <div>
            <table>
                <tr>
                    <th>金額總計：</th>
                    <td>{{ $stockAdjustMaster->total_no_tax_amount }}</td>
                </tr>
            </table>
        </div>

        @yield('show_button_group')
@endsection
