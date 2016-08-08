@extends('layouts.app')

@include('erp.show_button_group', [
    'print_enabled' => false,
    'delete_enabled' => true,
    'edit_enabled'   => true,
    'chname'         => '稅別',
    'route_name'     => 'tax_rate',
    'code'           => $tax_rate->id
])

@section('content')

        <table width="100%">
            <tr>
                <th>稅別代號</th>
                <td>{{ $tax_rate->code }}</td>
            </tr>
            <tr>
                <th>稅別說明</th>
                <td>{{ $tax_rate->comment }}</td>
            </tr>
            <tr>
                <th>稅率 %</th>
                <td>{{ $tax_rate->rate }}</td>
            </tr>
        </table>
    {{-- 資料檢視頁的按鈕群組 --}}
    @yield('show_button_group')
@endsection