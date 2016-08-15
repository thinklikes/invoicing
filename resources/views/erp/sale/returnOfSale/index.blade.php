@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="100%">
            <thead>
                <tr>
                    <th class="string">開單日期</th>
                    <th class="string">銷貨退回單代號</th>
                    <th class="string">客戶代號</th>
                    <th class="string">客戶名稱</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($orders as $order)
                <tr>
                    <td class="string">{{ $PublicPresenter->getFormatDate($order->created_at) }}</td>
                    <td class="string"><a href="{{ url("/returnOfSale/$order->code") }}">{{ $order->code }}</a></td>
                    <td class="string">{{ $order->company->company_code }}</td>
                    <td class="string">{{ $order->company->company_name }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $orders->render() !!}</div>
        <br>
        <a href="{{ url('/returnOfSale/create') }}" class="btn btn-default">新增銷貨退回單</a>
@endsection