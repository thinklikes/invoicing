@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="100%">
            <thead>
                <tr>
                    <th class="string">開單日期</th>
                    <th class="string">銷貨單代號</th>
                    <th class="string">客戶編號</th>
                    <th class="string">客戶名稱</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($orders as $order)
                <tr>
                    <td class="string">{{ $order->date }}</td>
                    <td class="string"><a href="{{ url("/billOfSale/$order->code") }}">{{ $order->code }}</a></td>
                    <td class="string">{{ $order->company->company_code }}</td>
                    <td class="string">{{ $order->company->company_name }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $orders->render() !!}</div>
        <br>
        <a href="{{ url('/billOfSale/create') }}" class="btn btn-default">新增銷貨單</a>
@endsection