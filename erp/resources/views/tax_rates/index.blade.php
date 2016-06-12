@extends('layouts.app')
{{--
@section('sidebar')
    @parent

    <p>這邊會附加在主要的側邊欄。</p>
@endsection
--}}
@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="100%">
            <thead>
                <tr>
                    <th>稅別代號</th>
                    <th>稅別說明</th>
                    <th>稅率 %</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($tax_rates as $tax_rate)
                <tr>
                    @if ($tax_rate->isDefault == 'Y')
                    <td>{{ $tax_rate->code }}</td>
                    @else
                    <td><a href="{{ url("/tax_rates/$tax_rate->id") }}">{{ $tax_rate->code }}</a></td>
                    @endif
                    <td>{{ $tax_rate->comment }}</td>
                    <td>{{ $tax_rate->rate }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $tax_rates->render() !!}</div>
        <br>
        <a href="{{ url('/tax_rates/create') }}">新增稅別</a>
@endsection