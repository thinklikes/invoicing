@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="100%">
            <thead>
                <tr>
                    <th>開單日期</th>
                    <th>採購單代號</th>
                    <th>供應商編號</th>
                    <th>供應商名稱</th>
                    <th>交貨日期</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($purchase_orders as $purchase_order)
                <tr>
                    <td>{{ $PublicPresenter->getFormatDate($purchase_order->created_at) }}</td>
                    <td><a href="{{ url("/purchase_orders/$purchase_order->code") }}">{{ $purchase_order->code }}</a></td>
                    <td>{{ $purchase_order->supplier->code }}</td>
                    <td>{{ $purchase_order->supplier->name }}</td>
                    <td>{{ $purchase_order->supplier->delivery_date }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $purchase_orders->render() !!}</div>
        <br>
        <a href="{{ url('/purchase_orders/create') }}" class="btn btn-default">新增採購單</a>
@endsection