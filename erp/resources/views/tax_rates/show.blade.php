@extends('layouts.app')
{{--
@section('sidebar')
    @parent

    <p>這邊會附加在主要的側邊欄。</p>
@endsection
--}}
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
        <a href="{{ url("/tax_rates/$id/edit") }}">維護稅別資料</a>
        <form action="{{ url("/tax_rates/$id") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button>刪除稅別</button>
        </form>
@endsection