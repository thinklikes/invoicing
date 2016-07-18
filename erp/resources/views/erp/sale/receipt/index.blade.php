@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="100%">
            <thead>
                <tr>
                    <th>開單日期</th>
                    <th>收款單代號</th>
                    <th>客戶編號</th>
                    <th>客戶名稱</th>
                    <th>收款方式</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($orders as $order)
                <tr>
                    <td>{{ $PublicPresenter->getFormatDate($order->created_at) }}</td>
                    <td><a href="{{ url("/receipt/$order->code") }}">{{ $order->code }}</a></td>
                    <td>{{ $order->company->code }}</td>
                    <td>{{ $order->company->name }}</td>
                    <td>{{ $order->type == 'cash' ? '現金' : '票據'}}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $orders->render() !!}</div>
        <br>
        <a href="{{ url('/receipt/create') }}">新增收款單</a>
@endsection