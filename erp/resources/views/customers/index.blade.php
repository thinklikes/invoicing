@extends('layouts.app')

@section('sidebar')

<div class="panel panel-default">
    <div class="panel-heading">搜尋</div>

    <div class="panel-body">
        <form action="" method="GET">
            <table>
                <tr>
                    <td>公司名稱</td>
                </tr>
                <tr>
                    <td><input type="text" name="name" size="15"></td>
                </tr>
                <tr>
                    <td>地址</td>
                <tr>
                    <td><input type="text" name="address" size="15"></td>
                </tr>
            </table>
            <button>搜尋</button>
        </form>
    </div>
</div>

@endsection

@section('content')

    <!-- Bootstrap 樣板... -->
<table width="100%">
    <thead>
        <tr>
            <th>公司名稱</th>
            <th>負責人</th>
            <th>聯絡人</th>
            <th>電話</th>
            <th>地址</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
        <tr>
            <td><a href="{{ url("/customers/".$customer->id) }}">{{ $customer->name }}</a></td>
            <td>{{ $customer->boss }}</td>
            <td>{{ $customer->contactPerson }}</td>
            <td>{{ $customer->telphone }}</td>
            <td>{{ $customer->address }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div align="center">{!! $customers->render() !!}</div>
<br>
<a href="customers/create">新增客戶</a>
@endsection