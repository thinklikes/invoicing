@extends('layouts.app')
@inject('PublicPresenter', 'App\Presenters\PublicPresenter')

@include('erp.show_button_group', [
    'print_enabled' => false,
    'delete_enabled' => true,
    'edit_enabled'   => true,
    'chname'         => '轉倉單',
    'route_name'     => 'stockTransfer',
    'code'           => $stockTransferMaster->code
])

@section('content')

        <table id="master" width="100%">
            <tr>
                <td>開單日期</td>
                <td>{{ $stockTransferMaster->date }}</td>
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
                    <th>料品編號</th>
                    <th>料品名稱</th>
                    <th class="numeric">料品數量</th>
                    <th class="string">料品單位</th>
                    <th class="numeric">未稅單價</th>
                    <th class="numeric">金額總計</th>
                </tr>
            </thead>
            <tbody>

    @foreach($stockTransferDetail as $i => $value)
                <tr>
                    <td>{{ $stockTransferDetail[$i]['stock']->code }}</td>
                    <td>{{ $stockTransferDetail[$i]['stock']->name }}</td>
                    <td class="numeric">{{ $stockTransferDetail[$i]['quantity'] }}</td>
                    <td class="string">{{ $stockTransferDetail[$i]['stock']->unit->comment or null }}</td>
                    <td class="numeric">{{ $stockTransferDetail[$i]['no_tax_price'] }}</td>
                    <td class="numeric">{{ $stockTransferDetail[$i]['no_tax_amount'] }}</td>
                </tr>
    @endforeach

            </tbody>
        </table>
        <hr>
        <div>
            <table>
                <tr>
                    <th>金額總計：</th>
                    <td>{{ $stockTransferMaster->total_no_tax_amount }}</td>
                </tr>
            </table>
        </div>

    {{-- 資料檢視頁的按鈕群組 --}}
    @yield('show_button_group')
@endsection
