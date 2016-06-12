@extends('layouts.app')

@section('content')

        <form action="{{ url("/stocks") }}" method="POST">
            {{ csrf_field() }}
            <table width="100%">
                <tr>
                    <th>料品代號</th>
                    <td><input type="text" name="stock[code]" id="code" value="{{ $stock['code'] }}"></td>
                </tr>
                <tr>
                    <th>料品名稱</th>
                    <td><input type="text" name="stock[name]" id="name" value="{{ $stock['name'] }}"></td>
                </tr>
                <tr>
                    <th>淨重</th>
                    <td><input type="text" name="stock[net_weight]" id="net_weight" value="{{ $stock['net_weight'] }}"></td>
                </tr>
                <tr>
                    <th>毛重</th>
                    <td><input type="text" name="stock[gross_weight]" id="gross_weight" value="{{ $stock['gross_weight'] }}"></td>
                </tr>
                <tr>
                    <th>料品類別</th>
                    <td>
                        <select name="stock[stock_class_id]" id="stock_class_id">
                            <option></option>
                            @foreach($stock_classes as $stock_class_id => $comment)
                            <option value="{{ $stock_class_id }}" {{ $stock_class_id == $stock['stock_class_id'] ? "selected" : ""}}>{{ $comment }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>料品單位</th>
                    <td>
                        <select name="stock[unit_id]" id="unit_id">
                            <option></option>
                            @foreach($units as $unit_id => $comment)
                            <option value="{{ $unit_id }}" {{ $unit_id == $stock['unit_id'] ? "selected" : ""}}>{{ $comment }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>進貨價格</th>
                    <td><input type="text" name="stock[no_tax_price_of_purchased]" id="no_tax_price_of_purchased" value="{{ $stock['no_tax_price_of_purchased'] }}"></td>
                </tr>
                <tr>
                    <th>銷貨價格</th>
                    <td><input type="text" name="stock[no_tax_price_of_sold]" id="no_tax_price_of_sold" value="{{ $stock['no_tax_price_of_sold'] }}"></td>
                </tr>
            </table>
            <button>確認送出</button>
        </form>

@endsection