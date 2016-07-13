@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="100%">
            <thead>
                <tr>
                    <th>開單日期</th>
                    <th>進貨單代號</th>
                    <th>供應商編號</th>
                    <th>供應商名稱</th>
                    <th>交貨日期</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($orders as $order)
                <tr>
                    <td>{{ $PublicPresenter->getFormatDate($order->created_at) }}</td>
                    <td><a href="{{ url("/billOfPurchase/$order->code") }}">{{ $order->code }}</a></td>
                    <td>{{ $order->supplier->code }}</td>
                    <td>{{ $order->supplier->name }}</td>
                    <td>{{ $order->supplier->delivery_date }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $orders->render() !!}</div>
        <br>
        <a href="{{ url('/billOfPurchase/create') }}">新增進貨單</a>
@endsection