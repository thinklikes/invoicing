@extends('layouts.app')

@include('erp.show_button_group', [
    'print_enabled' => false,
    'delete_enabled' => true,
    'edit_enabled'   => true,
    'chname'         => '付款方式',
    'route_name'     => 'pay_way',
    'code'           => $pay_way->id
])

@section('content')

        <table width="100%" class="table">
            <tr>
                <th>付款方式代號</th>
                <td>{{ $pay_way->code }}</td>
            </tr>
            <tr>
                <th>付款方式說明</th>
                <td>{{ $pay_way->comment }}</td>
            </tr>
        </table>
    {{-- 資料檢視頁的按鈕群組 --}}
    @yield('show_button_group')
@endsection