@extends('layouts.app')

@include('erp.show_button_group', [
    'print_enabled' => false,
    'delete_enabled' => true,
    'edit_enabled'   => true,
    'chname'         => '倉庫',
    'route_name'     => 'warehouse',
    'code'           => $warehouse->id
])

@section('content')

        <table width="100%">
            <tr>
                <th>倉庫代號</th>
                <td>{{ $warehouse->code }}</td>
            </tr>
            <tr>
                <th>倉庫名稱</th>
                <td>{{ $warehouse->name }}</td>
            </tr>
        </table>
    {{-- 資料檢視頁的按鈕群組 --}}
    @yield('show_button_group')
@endsection