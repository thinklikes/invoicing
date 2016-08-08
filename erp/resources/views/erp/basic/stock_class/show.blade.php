@extends('layouts.app')

@include('erp.show_button_group', [
    'print_enabled' => false,
    'delete_enabled' => true,
    'edit_enabled'   => true,
    'chname'         => '料品類別',
    'route_name'     => 'stock_class',
    'code'           => $stock_class->id
])

@section('content')

        <table width="100%" class="table">
            <tr>
                <th>料品類別代號</th>
                <td>{{ $stock_class->code }}</td>
            </tr>
            <tr>
                <th>料品類別說明</th>
                <td>{{ $stock_class->comment }}</td>
            </tr>
        </table>
    {{-- 資料檢視頁的按鈕群組 --}}
    @yield('show_button_group')
@endsection