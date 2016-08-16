@extends('layouts.app')

@section('sidebar')

<div class="panel panel-default">
    <div class="panel-heading">搜尋</div>

    <div class="panel-body">
        <form action="" method="GET" role="form">
            <div class="form-group">
                <label>客戶編號</label>
                <input type="text" class="form-control" name="code" value="{{ $code }}">
            </div>
            <div class="form-group">
                <label>公司名稱</label>
                <input type="text" class="form-control" name="name" value="{{ $name }}">
            </div>
            <div class="form-group">
                <label>地址</label>
                <input type="text" class="form-control" name="address" value="{{ $address }}">
            </div>
            <button class="btn btn-info">搜尋</button>
        </form>
        <br>
        <a class="btn btn-default" href="{{ url('company/printBarcode') }}" target="_blank">條碼列印</a>
    </div>
</div>

@endsection

@section('content')

    <!-- Bootstrap 樣板... -->
<table width="100%" class="table">
    <thead>
        <tr>
            <th>客戶編號</th>
            <th>公司名稱</th>
            <th>聯絡人</th>
            <th>電話</th>
            <th>地址</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($company as $value)
        <tr>
            <td>{{ $value->company_code }}</td>
            <td><a href="{{ url("/company/".$value->auto_id) }}">{{ $value->company_name }}</a></td>
            <td>{{ $value->company_contact }}</td>
            <td>{{ $value->company_tel }}</td>
            <td>{{ $value->company_add }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div align="center">{!! $company->render() !!}</div>
<br>
<a class="btn btn-default" href="company/create">新增客戶</a>
@endsection