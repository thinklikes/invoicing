@extends('layouts.app')

@section('sidebar')

<div class="panel panel-default">
    <div class="panel-heading">搜尋</div>

    <div class="panel-body">
        <form action="" method="GET">
            <table>
                <tr>
                    <td>供應商編號</td>
                </tr>
                <tr>
                    <td><input type="text" name="code" size="15"></td>
                </tr>
                <tr>
                    <td>供應商名稱</td>
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
                    <th>供應商編號</th>
                    <th>供應商名稱</th>
                    <th>負責人</th>
                    <th>聯絡人</th>
                    <th>電話</th>
                    <th>地址</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->code }}</td>
                    <td><a href="{{ url("/supplier/$supplier->id") }}">{{ $supplier->name }}</a></td>
                    <td>{{ $supplier->boss }}</td>
                    <td>{{ $supplier->contactPerson }}</td>
                    <td>{{ $supplier->telphone }}</td>
                    <td>{{ $supplier->address }}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
        <div align="center">{!! $suppliers->render() !!}</div>
        <br>
        <a href="{{ url('/suppliers/create') }}">新增供應商</a>
@endsection