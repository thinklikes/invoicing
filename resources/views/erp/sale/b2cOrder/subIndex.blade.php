@extends('layouts.app')

@section('content')
    <table class="table" width="100%">
        <thead>
            <tr>
                <td></td>
                <td>上傳時間</td>
                <td>訂單數量</td>
                <td>商品總數<br>EXCEL</td>
                <td>超商<br>EXCEL</td>
                <td>宅配一般件<br>EXCEL</td>
                <td>宅配冷藏件<br>EXCEL</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $key => $value)
            <tr>
                <td width="25px">{{ ++$i }}</td>
                <td>
                    <a href="{{ url('/b2cOrder/detail/'.$platform.'?upload_time='.$value['upload_time']) }}">
                        {{ $value['upload_time'] }}
                    </a>
                </td>
                <td>{{ $value['count'] }}</td>
                <td align="center">
                    <button class="glyphicon glyphicon-arrow-down"
                        onclick="window.open('{{ url('/b2cOrder/export/'.$platform.'?upload_time='.$value['upload_time']) }}')">
                    </button>
                </td>
                <td align="center">
                    <button class="glyphicon glyphicon-arrow-down"
                            onclick="window.open('{{ url('/b2cOrder/exportSuperMarket/'.$platform.'?upload_time='.$value['upload_time']) }}')">
                    </button>
                </td>
                <td align="center">
                    <button class="glyphicon glyphicon-arrow-down"
                        onclick="window.open('{{ url('/b2cOrder/exportBlackCat/'.$platform.'?upload_time='.$value['upload_time'].'&isCool=0' ) }}')">
                    </button>
                </td>
                <td align="center">
                    <button class="glyphicon glyphicon-arrow-down"
                        onclick="window.open('{{ url('/b2cOrder/exportBlackCat/'.$platform.'?upload_time='.$value['upload_time'].'&isCool=1') }}')">
                    </button>
                </td>
                <td>
                    <form action="{{ url("/b2cOrder/deleteOrders/".$platform) }}"
                          class="form_of_delete" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="upload_time" value="{{ $value['upload_time'] }}">
                        <button onclick="return confirm('確認刪除訂單??');">
                            刪除
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        @if (count($data) == 0)
            <td>
                <td colspan="5">尚無資料</td>
            </td>
        @endif
        </tbody>
    </table>
@endsection