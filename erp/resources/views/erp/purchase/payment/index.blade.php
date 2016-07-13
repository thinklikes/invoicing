@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="100%">
            <thead>
                <tr>
                    <th>開單日期</th>
                    <th>付款單代號</th>
                    <th>供應商編號</th>
                    <th>供應商名稱</th>
                    <th>付款方式</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($orders as $order)
                <tr>
                    <td>{{ $PublicPresenter->getFormatDate($order->created_at) }}</td>
                    <td><a href="{{ url("/payment/$order->code") }}">{{ $order->code }}</a></td>
                    <td>{{ $order->supplier->code }}</td>
                    <td>{{ $order->supplier->name }}</td>
                    <td>{{ $order->type == 'cash' ? '現金' : '票據'}}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $orders->render() !!}</div>
        <br>
        <a href="{{ url('/payment/create') }}">新增付款單</a>
@endsection