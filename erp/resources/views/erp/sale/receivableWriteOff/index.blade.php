@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="100%">
            <thead>
                <tr>
                    <th>開單日期</th>
                    <th>應收帳款沖銷單代號</th>
                    <th>客戶編號</th>
                    <th>客戶名稱</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($orders as $order)
                <tr>
                    <td>{{ $PublicPresenter->getFormatDate($order->created_at) }}</td>
                    <td><a href="{{ url("/receivableWriteOff/$order->code") }}">{{ $order->code }}</a></td>
                    <td>{{ $order->company->code }}</td>
                    <td>{{ $order->company->name }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $orders->render() !!}</div>
        <br>
        <a href="{{ url('/receivableWriteOff/create') }}" class="btn btn-default">新增應收帳款沖銷單</a>
@endsection