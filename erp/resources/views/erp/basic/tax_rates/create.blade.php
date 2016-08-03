@extends('layouts.app')

@section('content')

        <form action="{{ url("/tax_rates") }}" method="POST">
            {{ csrf_field() }}
            <table width="100%" class="table">
                <tr>
                    <th>稅別代號</th>
                    <td><input type="text" name="tax_rate[code]" id="code" value="{{ $tax_rate['code'] }}"></td>
                </tr>
                <tr>
                    <th>稅別說明</th>
                    <td><input type="text" name="tax_rate[comment]" id="comment" value="{{ $tax_rate['comment'] }}"></td>
                </tr>
                <tr>
                    <th>稅率</th>
                    <td><input type="text" name="tax_rate[rate]" id="rate" value="{{ $tax_rate['rate'] }}"></td>
                </tr>
            </table>
            <button class="btn btn-default">確認送出</button>
        </form>

@endsection