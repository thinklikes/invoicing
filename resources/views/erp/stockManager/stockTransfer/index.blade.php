@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="100%">
            <thead>
                <tr>
                    <th>開單日期</th>
                    <th>轉倉單代號</th>
                    <th>調出倉庫</th>
                    <th>調入倉庫</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($orders as $order)
                <tr>
                    <td>{{ $PublicPresenter->getFormatDate($order->created_at) }}</td>
                    <td><a href="{{ url("/stockTransfer/$order->code") }}">{{ $order->code }}</a></td>
                    <td>{{ $order->from_warehouse->name }}</td>
                    <td>{{ $order->to_warehouse->name }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $orders->render() !!}</div>
        <br>
        <a href="{{ url('/stockTransfer/create') }}" class="btn btn-default">新增轉倉單</a>
@endsection