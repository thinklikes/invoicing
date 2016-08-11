@extends('layouts.app')

@include('erp.show_button_group', [
    'print_enabled' => false,
    'delete_enabled' => true,
    'edit_enabled'   => true,
    'chname'         => '料品單位',
    'route_name'     => 'unit',
    'code'           => $unit->id
])

@section('content')

        <table width="100%" class="table">
            <tr>
                <th>料品單位代號</th>
                <td>{{ $unit->code }}</td>
            </tr>
            <tr>
                <th>料品單位說明</th>
                <td>{{ $unit->comment }}</td>
            </tr>
        </table>
    {{-- 資料檢視頁的按鈕群組 --}}
    @yield('show_button_group')
@endsection