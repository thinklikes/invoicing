@extends('layouts.app')

@section('content')
        <script type="text/javascript" src="{{ asset('assets/js/bindSupplierAutocomplete.js') }}"></script>
        <form action=" {{ url("/payableWriteOff/create") }}" method="GET">
            {{ csrf_field() }}
            <table id="master" width="100%">
                <tr>
                    <th>供應商</th>
                    <td colspan="3">
                        <input type="hidden" name="master[supplier_id]" class="supplier_id" value="{{ $master['supplier_id'] }}"  size="10">
                        <input type="text" name="master[supplier_code]" class="supplier_code" value="{{ $master['supplier_code'] }}"  size="10">
                        <input type="text" name="master[supplier_name]" class="supplier_autocomplete" value="{{ $master['supplier_name'] }}">
                    </td>
                </tr>
            </table>
        </form>
@endsection