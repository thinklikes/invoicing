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
        @foreach ($billsOfPurchase as $billOfPurchase)
                <tr>
                    <td>{{ $PublicPresenter->getFormatDate($billOfPurchase->created_at) }}</td>
                    <td><a href="{{ url("/billsOfPurchase/$billOfPurchase->code") }}">{{ $billOfPurchase->code }}</a></td>
                    <td>{{ $billOfPurchase->supplier->code }}</td>
                    <td>{{ $billOfPurchase->supplier->name }}</td>
                    <td>{{ $billOfPurchase->supplier->delivery_date }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $billsOfPurchase->render() !!}</div>
        <br>
        <a href="{{ url('/billsOfPurchase/create') }}">新增進貨單</a>
@endsection