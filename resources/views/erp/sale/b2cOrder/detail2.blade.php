@extends('layouts.app2')

@section('sidebar')
    <div class="panel panel-default">
        <div class="panel-heading">搜尋</div>

        <div class="panel-body">
            <form action="{{ url('/b2cOrder/detail/'.$platform) }}" method="GET">
                <input type="hidden" name="upload_time" value="{{ $upload_time }}">
                <div class="form-group">
                    <label>訂單編號</label>
                    <input type="text" class="form-control"
                        name="search[platform_code]"
                        value="{{ $search['platform_code'] or null }}">
                </div>
                <div class="form-group">
                    <label>購買人</label>
                    <input type="text" class="form-control"
                        name="search[customer_name]"
                        value="{{ $search['customer_name'] or null }}">
                </div>
                <div class="form-group">
                    <label>購買人電話</label>
                    <input type="text" class="form-control"
                        name="search[customer_tel]"
                        value="{{ $search['customer_tel'] or null }}">
                </div>
                <div class="form-group">
                    <label>收件人</label>
                    <input type="text" class="form-control"
                        name="search[recipient]"
                        value="{{ $search['recipient'] or null }}">
                </div>
                <div class="form-group">
                    <label>收件人電話</label>
                    <input type="text" class="form-control"
                        name="search[recipient_tel]"
                        value="{{ $search['recipient_tel'] or null }}">
                </div>
                <div class="form-group">
                    <label>訂購商品</label>
                    <input type="text" class="form-control"
                        name="search[item]"
                        value="{{ $search['item'] or null }}">
                </div>
                <div class="form-group">
                    <label>付款狀態</label>
                    <select name="search[pay_status]" class="form-control">
                        <option value="">請選擇</option>
                        <option {{ (isset($search['pay_status']) && $search['pay_status'] == "未付款")
                            ? 'selected' : '' }} value="未付款">未付款</option>
                        <option {{ (isset($search['pay_status']) && $search['pay_status'] == "已付款")
                            ? 'selected' : '' }} value="已付款">已付款</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>付款方式</label>
                    <select name="search[payway]" class="form-control">
                        <option value="">請選擇</option>
                        @foreach($payways as $payway)
                            <option {{ (isset($search['payway']) && $search['payway'] == $payway)
                                ? 'selected' : '' }} value="{{ $payway }}">{{ $payway }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>配送方式</label>
                    <select name="search[delivery_method]" class="form-control">
                        <option value="">請選擇</option>
                        <option {{ (isset($search['delivery_method']) && $search['delivery_method'] == "超商")
                            ? 'selected' : '' }} value="超商">超商</option>
                        <option {{ (isset($search['delivery_method']) && $search['delivery_method'] == "宅配")
                            ? 'selected' : '' }} value="宅配">宅配</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="search[isRepeated]" id="isRepeated"
                            {{ (isset($search['isRepeated']) && $search['isRepeated'] == 1)
                            ? 'checked' : '' }} value="1">
                    <label for="isRepeated">重複購買</label>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="search[island]" id="island"
                           {{ (isset($search['island']) && $search['island'] == 1)
                           ? 'checked' : '' }} value="1">
                    <label for="island">外島寄件</label>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="search[isCool]" id="isCool"
                           {{ (isset($search['isCool']) && $search['isCool'] == 1)
                           ? 'checked' : '' }} value="1">
                    <label for="isCool">冷藏件</label>
                </div>
                <button type="submit" class="btn btn-info">送出</button>
            </form>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">訂單小計</div>
        <div class="panel-body">
            <table class="table">
                <tr>
                    <th>訂單總數</th><td class="cell" align="right">{{ $counts['total'] }}</td>
                </tr>
                <tr>
                    <th>未付訂單數</th><td class="cell" align="right">{{ $counts['not_payed'] }}</td>
                </tr>
                <tr>
                    <th>已付訂單數</th><td class="cell" align="right">{{ $counts['payed'] }}</td>
                </tr>
                <tr>
                    <th>黑貓訂單數</th><td class="cell" align="right">{{ $counts['blackCat'] }}</td>
                </tr>
                <tr>
                    <th>超商訂單數</th><td class="cell" align="right">{{ $counts['superMarket'] }}</td>
                </tr>
                <tr>
                    <th>訂單總金額</th><td class="cell" align="right">{{ number_format($counts['total_amount']) }}</td>
                </tr>
                <tr>
                    <th>未付總金額</th><td class="cell" align="right">{{ number_format($counts['not_payed_amount']) }}</td>
                </tr>
                <tr>
                    <th>已付總金額</th><td class="cell" align="right">{{ number_format($counts['payed_amount']) }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection

@section('content')
    <script>
        $(function () {
            @if (isset($id))
                // 跳到上次儲存的地方
                location.hash = 'order_{{ $id }}';

            @endif
            bindRemove();
            bindChange();
            $('.add_button').click(function () {
                var empty_td_counts = 16;

                //var key = $(this).parents('tbody').attr('id').match(/\d+/g)[0];
                var last_row = $(this).parents('tbody').find('tr.body:last');
                //取得最後一列tr的index
                if (last_row.length > 0) {
                    var new_id = last_row.find('input:text:first').attr('name').match(/\d+/g)[0];
                    console.log(last_row.find('input:text:first'));
                    new_id = parseInt(new_id) + 1;
                } else {
                    new_id = 0;
                }
                //增加商品與刪除商品的td
                var button_cell = $('<td class="cell"></td>')
                    .addClass('td')
                    .prop('style', 'text-align: right;')
//                    .append(
//                        $('<button></button>')
//                            .prop('type', 'button')
//                            .addClass('add_button btn btn-info')
//                            .append('增加商品')
//                    )
//                    .append('\n')
                    .append(
                        $('<button></button>')
                            .prop('type', 'button')
                            .addClass('remove_button btn btn-danger')
                            .append('刪除商品')
                    );

                //品名
                var stock_name_cell = $('<td class="cell"></td>')
                    .append(
                        $('<input>')
                            .prop('type', 'text')
                            .prop('size', '10')
                            .prop('name', 'order[detail][' + new_id + '][item]')
                    );

                //數量
                var stock_quantity_cell = $('<td class="cell"></td>')
                    .append(
                        $('<input>')
                            .prop('type', 'text')
                            .prop('style', "text-align:right;")
                            .prop('size', '5')
                            .prop('name', 'order[detail][' + new_id + '][quantity]')
                            .addClass('quantity')
                    );

                //單價
                var stock_price_cell = $('<td class="cell"></td>')
                    .append(
                        $('<input>')
                            .prop('type', 'text')
                            .prop('style', "text-align:right;")
                            .prop('size', '8')
                            .prop('name', 'order[detail][' + new_id + '][price]')
                            .addClass('price')
                    );

                //小計
                var stock_subTotal_cell = $('<td class="cell"></td>')
                    .append(
                        $('<input>')
                            .prop('type', 'text')
                            .prop('style', "text-align:right;")
                            .prop('size', '8')
                            .prop('readonly', 'readonly')
                            .prop('class', 'subTotal')
                    );
                var tr = $('<tr></tr>')
                    .prop('class', last_row.prop('class'));

                for(i = 0; i < empty_td_counts; i++) {
                    tr.append('<td class="cell"></td>');
                }

                tr.append(
                    button_cell,
                    stock_name_cell,
                    stock_quantity_cell,
                    stock_price_cell,
                    stock_subTotal_cell
                )

                $(this).parents('tbody').append(tr);
                bindRemove();
                bindChange();
            });

            $('.save').click(function () {
                $(this).parents('form[id^=order_]').find('form:eq(0)').submit();
            });

            function bindRemove() {
                $('.remove_button').unbind();
                $('.remove_button').click(function () {
                    var key = $(this).parents('tbody').attr('id').match(/\d+/g)[0];
                    $(this).parents('tr').remove();

                    calculate(key);
                });
            }

            function bindChange() {
                $('.price, .quantity').unbind();
                $('.price, .quantity').change(function () {
                    var key = $(this).parents('tbody').attr('id').match(/\d+/g)[0];

                    calculate(key);
                });
            }

            function calculate(key) {
                var order = $('tbody#order_' + key);
                var this_rows = order.find('.body');
                var length = this_rows.length;

                var total = 0;
                for (i = 0; i < length; i ++) {
                    subTotal = 0;

                    quantity = $(this_rows[i]).find('.quantity').val();
                    price = $(this_rows[i]).find('.price').val();

                    if (parseInt(quantity) && parseInt(price)) {
                        subTotal += parseInt(quantity) * parseInt(price);
                    }

                    $(this_rows[i]).find('.subTotal').val(subTotal);

                    total += subTotal;
                }

                order.find('.total').val(total);
            }
        });
    </script>
    <style type="text/CSS">
        .order td {
            padding:3px;
        }
        .order {
            width:3200px;
            border: 1px solid lightgray; border-collapse: collapse;
        }
        .order tr, .order td, .order th {
            border: 1px solid lightgray;
        }
        .odd {
            background-color: #5599FF;
        }

        tr .cell:nth-child(1) {width:170px;}
        tr .cell:nth-child(2) {width:30px;}
        tr .cell:nth-child(3) {width:100px;}
        tr .cell:nth-child(4) {width:110px;}
        tr .cell:nth-child(5) {width:110px;}
        tr .cell:nth-child(6) {width:120px;}
        tr .cell:nth-child(7) {width:110px;}
        tr .cell:nth-child(8) {width:120px;}
        tr .cell:nth-child(9) {width:110px;}
        tr .cell:nth-child(10) {width:350px;}
        tr .cell:nth-child(11) {width:90px;}
        tr .cell:nth-child(12) {width:90px;}
        tr .cell:nth-child(13) {width:200px;}
        tr .cell:nth-child(14) {width:90px;}
        tr .cell:nth-child(15) {width:205px;}
        tr .cell:nth-child(16) {width:205px;}
        tr .cell:nth-child(17) {width:450px;}
        tr .cell:nth-child(18) {width:150px;}
        tr .cell:nth-child(19) {width:60px;}
        tr .cell:nth-child(20) {width:60px;}
        tr .cell:nth-child(21) {width:60px;}
        tr .cell:nth-child(22) {width:60px;}
    </style>
{{ $data->links() }}
    @foreach ($data as $key => $order)
        <form action="{{ url('/b2cOrder/'.$platform.'/'.$order['id']) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <input type="hidden" name="upload_time" value="{{ $upload_time }}">
            <input type="hidden" name="page" value="{{ $page or null }}">
            @if ($search)
                @foreach ($search as $name => $value)
                    <input type="hidden" name="search[{{ $name }}]" value="{{ $value }}">
                @endforeach
            @endif
            <table class="order">
                @if ($key % 20 == 0)
                <thead>
                <tr>
                    <th class="cell">【{{ $platform }}】</th>
                    <th class="cell">冷藏</th>
                    <th class="cell">訂單編號</th>
                    <th class="cell">購買日期</th>
                    <th class="cell">購買人</th>
                    <th class="cell">購買人電話</th>
                    <th class="cell">收件人</th>
                    <th class="cell">收件人電話</th>
                    <th class="cell">縣市/店到店編號</th>
                    <th class="cell">收件地址</th>
                    <th class="cell">付款方式</th>
                    <th class="cell">付款狀態</th>
                    <th class="cell">匯款後5碼</th>
                    <th class="cell">配送方式</th>
                    <th class="cell">希望送達日期</th>
                    <th class="cell">希望送達時段</th>
                    <th class="cell">訂單備註</th>
                    <th class="cell">訂購商品</th>
                    <th class="cell">商品數量</th>
                    <th class="cell">單價</th>
                    <th class="cell">小計</th>
                    <th class="cell">總金額</th>
                </tr>
                </thead>
                @endif
            <tbody id="order_{{ $order->id }}">
                {{--<form id="delete_{{ $order->id }}" action="{{ url("/b2cOrder/".$platform.'/'.$order['id']) }}"--}}
                      {{--class="form_of_delete" method="POST">--}}
                    {{--{{ csrf_field() }}--}}
                    {{--{{ method_field('DELETE') }}--}}
                    {{--<input type="hidden" name="upload_time" value="{{ $upload_time }}">--}}
                {{--</form>--}}
                <tr class="{{ $key % 2 == 0 ? 'even' : 'odd' }} head">
                    <td class="cell">

                        <button type="button" class="btn btn-danger delete" style="display: inline-block;"
                                onclick="if (confirm('確定刪除??')) {$('#delete_{{ $order->id }}').submit();}">刪除</button>
                        <button type="submit" class="btn btn-default save" style="display: inline-block;">儲存</button>

                    </td>
                    <td class="cell">
                        <input type="checkbox" name="order[master][isCool]"
                               {{ ($order['isCool'] == "1")
                               ? 'checked' : '' }} value="1">
                    </td>
                    <td class="cell">{{ $order['platform_code'] }}</td>
                    <td class="cell">{{
                        intval($order['date_of_buying']->format('Y')) > 0
                            ? $order['date_of_buying']->format('Y-m-d')
                            : ''
                     }}</td>
                    <td class="cell">
                        <input type="text" name="order[master][customer_name]" size="8" value="{{ $order['customer_name'] }}">
                    </td>
                    <td class="cell">
                        <input type="text" name="order[master][customer_tel]" size="11" value="{{ $order['customer_tel'] }}">
                    </td>
                    <td class="cell">
                        <input type="text" name="order[master][recipient]" size="8"  value="{{ $order['recipient'] }}">
                    </td>
                    <td class="cell">
                        <input type="text" name="order[master][recipient_tel]" size="11"  value="{{ $order['recipient_tel'] }}">
                    </td>
                    <td class="cell">
                        <input type="text" name="order[master][city]" size="8" value="{{ $order['city'] }}"><br>
                    </td>
                    <td class="cell">
                        <input type="text" name="order[master][address]" size="40" value="{{ $order['address'] }}">
                    </td>
                    <td class="cell">
                        <select name="order[master][payway]">
                            <option value="">請選擇</option>
                            @foreach($payways as $payway)
                                <option {{ ($order['payway'] == $payway) ? 'selected' : '' }} value="{{ $payway }}">{{ $payway }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="cell">
                        <select name="order[master][pay_status]">
                            <option value="">請選擇</option>
                            <option {{ ($order['pay_status'] == "未付款") ? 'selected' : '' }} value="未付款">未付款</option>
                            <option {{ ($order['pay_status'] == "已付款") ? 'selected' : '' }} value="已付款">已付款</option>
                        </select>
                    </td>
                    <td class="cell">
                        <input type="text" name="order[master][transfer_code]" value="{{ $order['transfer_code'] }}">
                    </td>
                    <td class="cell">
                        <select name="order[master][delivery_method]">
                            <option value="">請選擇</option>
                            <option {{ (strpos($order['delivery_method'], '超商') !== false) ? 'selected' : '' }} value="超商">超商</option>
                            <option {{ (strpos($order['delivery_method'], '宅配') !== false) ? 'selected' : '' }} value="宅配">宅配</option>
                        </select>
                    </td>
                    <td class="cell">
                        <input type="text" name="order[master][delivery_date]"
                            value="{{
                                $order['delivery_date']
                                ? (
                                    $order['delivery_date']->format('Y') > 0
                                    ? $order['delivery_date']->format('Y-m-d')
                                    : ''
                                )
                                : ''
                             }}" class="datepicker">
                    </td>
                    <td class="cell">
                        <select name="order[master][delivery_time]">
                            <option value="" {{ $order['delivery_time'] == "" ? 'selected' : "" }}>任何時段皆可</option>
                            <option value="1" {{ $order['delivery_time'] == "1" ? 'selected' : "" }}>中午前</option>
                            <option value="2" {{ $order['delivery_time'] == "2" ? 'selected' : "" }}>下午：12：00 ~ 17：00</option>
                            <option value="3" {{ $order['delivery_time'] == "3" ? 'selected' : "" }}>晚上：17時 - 20時</option>
                        </select>
                    </td>
                    <td class="cell">
                        <input name="order[master][note]" size="50" value="{{ $order['note'] }}">
                    </td>
                    <td class="cell">
                        <button type="button" class="add_button btn btn-info">增加商品</button>
                    </td>
                    <td class="cell"></td>
                    <td class="cell"></td>
                    <td class="cell"></td>
                    <td class="cell">
                        <input style="text-align:right;" type="text" size="8" readonly
                               class="total" value="{{
                                    $order->detail->sum(function ($item) {
                                        return $item['quantity'] * $item['price'];
                                    })
                                }}">
                    </td>
                </tr>
                    @foreach ($order->detail as $key2 => $item)
                        <tr class="{{ $key % 2 == 0 ? 'even' : 'odd' }} body">
                            <td class="cell"></td>
                            <td class="cell"></td>
                            <td class="cell"></td>
                            <td class="cell"></td>
                            <td class="cell"></td>
                            <td class="cell"></td>
                            <td class="cell"></td>
                            <td class="cell"></td>
                            <td class="cell"></td>
                            <td class="cell"></td>
                            <td class="cell"></td>
                            <td class="cell"></td>
                            <td class="cell"></td>
                            <td class="cell"></td>
                            <td class="cell"></td>
                            <td class="cell"></td>
                            <td class="cell" style="text-align: right;">
                                <button type="button" class="remove_button btn btn-danger">刪除商品</button>
                            </td>
                            <td class="cell">
                                <input type="text" name="order[detail][{{ $key2 }}][item]" size="10" value="{{ $order->detail[$key2]['item'] }}">
                            </td>
                            <td class="cell">
                                <input style="text-align:right;" type="text" size="5" class="quantity"
                                       name="order[detail][{{ $key2 }}][quantity]" value="{{ $order->detail[$key2]['quantity'] }}">
                            </td>
                            <td class="cell">
                                <input style="text-align:right;" type="text" size="8" class="price"
                                       name="order[detail][{{ $key2 }}][price]" value="{{ $order->detail[$key2]['price'] }}">
                            </td>
                            <td class="cell">
                                <input style="text-align:right;" type="text" size="8" readonly
                                       class="subTotal" value="{{
                                        $order->detail[$key2]['quantity'] *
                                        $order->detail[$key2]['price']
                                    }}">

                            </td>
                            <td class="cell"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    @endforeach


{{ $data->links() }}

@if (count($data) == 0)
    查無資料
@endif
{{-- <button class="btn btn-default" type="submit">確認送出</button> --}}
<br>
<a class="btn btn-default" onclick="history.back();">回上一頁</a>

@endsection
