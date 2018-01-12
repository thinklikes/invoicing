@extends('layouts.app')

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
                        <option {{ (isset($search['delivery_method']) && $search['delivery_method'] == "黑貓")
                            ? 'selected' : '' }} value="黑貓">黑貓</option>
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
@endsection

@section('sidebar-right')
    <div class="panel panel-default">
        <div class="panel-heading">訂單小計</div>
        <div class="panel-body">
            <table class="table">
                <tr>
                    <th>訂單總數</th><td align="right">{{ $counts['total'] }}</td>
                </tr>
                <tr>
                    <th>未付訂單數</th><td align="right">{{ $counts['not_payed'] }}</td>
                </tr>
                <tr>
                    <th>已付訂單數</th><td align="right">{{ $counts['payed'] }}</td>
                </tr>
                <tr>
                    <th>黑貓訂單數</th><td align="right">{{ $counts['blackCat'] }}</td>
                </tr>
                <tr>
                    <th>超商訂單數</th><td align="right">{{ $counts['superMarket'] }}</td>
                </tr>
                <tr>
                    <th>訂單總金額</th><td align="right">{{ number_format($counts['total_amount']) }}</td>
                </tr>
                <tr>
                    <th>未付總金額</th><td align="right">{{ number_format($counts['not_payed_amount']) }}</td>
                </tr>
                <tr>
                    <th>已付總金額</th><td align="right">{{ number_format($counts['payed_amount']) }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection

@section('content')
    <script>
        $(function () {
            bindRemove();
            bindChange();
            $('.add_row').click(function () {
                var key = $(this).attr('id').match(/\d+/)[0];
                var this_rows = $('#detail_table_' + key + ' tbody tr:last');

                //取得最後一列tr的index
                if (this_rows.length > 0) {
                    var new_id = this_rows.find('input:first').attr('name').match(/\d+/g)[0];
                    new_id = parseInt(new_id) + 1;
                } else {
                    new_id = 0;
                }
                //刪除按鈕的td
                var delete_cell = $('<td></td>')
                    .addClass('td')
                    .append(
                        $('<button></button>')
                            .prop('type', 'button')
                            .addClass('btn btn-danger remove_button')
                            .append('<i class="fa fa-remove"></i>')
                    );

                //品名
                var stock_name_cell = $('<td></td>')
                    .append(
                        $('<input>')
                            .prop('type', 'text')
                            .prop('name', 'order[detail][' + new_id + '][item]')
                    );

                //數量
                var stock_quantity_cell = $('<td></td>')
                    .append(
                        $('<input>')
                            .prop('type', 'text')
                            .prop('style', "text-align:right;")
                            .prop('size', '5')
                            .prop('name', 'order[detail][' + new_id + '][quantity]')
                            .addClass('quantity')
                    );

                //單價
                var stock_price_cell = $('<td></td>')
                    .append(
                        $('<input>')
                            .prop('type', 'text')
                            .prop('style', "text-align:right;")
                            .prop('size', '8')
                            .prop('name', 'order[detail][' + new_id + '][price]')
                            .addClass('price')
                    );

                //小計
                var stock_subTotal_cell = $('<td></td>')
                    .append(
                        $('<input>')
                            .prop('type', 'text')
                            .prop('style', "text-align:right;")
                            .prop('size', '8')
                            .prop('id', 'subTotal_' + new_id)
                    );
                var tr = $('<tr></tr>');

                tr.append(
                    delete_cell,
                    stock_name_cell,
                    stock_quantity_cell,
                    stock_price_cell,
                    stock_subTotal_cell
                )

                $('#detail_table_' + key + ' tbody').append(tr);
                bindRemove();
                bindChange();
            });
            //console.log($('table#detail tbody tr:last').find('button:first').attr('id'));

            $('.save').click(function () {
                $(this).parents('div[id^=order_]').find('form:eq(0)').submit();
            });

            function bindRemove() {
                $('.remove_button').unbind();
                $('.remove_button').click(function () {
                    var key = $(this).parents('div[id^=order_]').attr('id').match(/\d+/g)[0];
                    $(this).parents('tr').remove();

                    calculate(key);
                });
            }

            function bindChange() {
                $('.price, .quantity').unbind();
                $('.price, .quantity').change(function () {
                    var key = $(this).parents('div[id^=order_]').attr('id').match(/\d+/g)[0];

                    calculate(key);
                });
            }

            function calculate(key) {
                var table = $('#detail_table_' + key);
                var this_rows = table.find('tbody tr');
                var length = this_rows.length;

                var total = 0;
                for (i = 0; i < length; i ++) {
                    subTotal = 0;

                    quantity = $(this_rows[i]).find('.quantity').val();
                    price = $(this_rows[i]).find('.price').val();

                    if (parseInt(quantity) && parseInt(price)) {
                        subTotal += parseInt(quantity) * parseInt(price);
                    }
                    console.log(i);
                    this_rows.find('input#subTotal_' + i).val(subTotal);

                    total += subTotal;
                }

                $('input#total_' + key).val(total);
            }
        });
    </script>
{{ $data->links() }}
@foreach ($data as $key => $order)
    <div id="order_{{ $order->id }}" style="border:1px solid #ddd;margin-top:20px;">
        <div>
            <div style="float:left;">
                <h1>{{ $platform }}</h1>
                <h3>訂單編號 : {{ $order['platform_code'] }}</h3>
            </div>
        </div>
        <form action="{{ url('/b2cOrder/'.$platform.'/'.$order['id']) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <input type="hidden" name="upload_time" value="{{ $upload_time }}">
            <input type="hidden" name="page" value="{{ $page or null }}">
            <table class="table">
                <tr>
                    <th width="150px">購買日期</th>
                    <td colspan="3">
                        {{ $order['date_of_buying']}}
                    </td>
                </tr>
                <tr>
                    <th width="150px">購買人</th>
                    <td>
                        <input type="text" name="order[master][customer_name]" value="{{ $order['customer_name'] }}">
                    </td>
                    <th width="150px">購買人電話</th>
                    <td>
                        <input type="text" name="order[master][customer_tel]" value="{{ $order['customer_tel'] }}">
                    </td>
                </tr>
                <tr>
                    <th width="150px">收件人</th>
                    <td>
                        <input type="text" name="order[master][recipient]" value="{{ $order['recipient'] }}">
                    </td>
                    <th width="150px">收件人電話</th>
                    <td>
                        <input type="text" name="order[master][recipient_tel]" value="{{ $order['recipient_tel'] }}">
                    </td>
                </tr>
                <tr>
                    <th width="150px">縣市/店到店編號</th>
                    <td colspan="3">
                        <input type="text" name="order[master][city]" size="40" value="{{ $order['city'] }}"><br>
                    </td>
                </tr>
                <tr>
                    <th width="150px">收件地址</th>
                    <td colspan="3">
                        <input type="text" name="order[master][address]" size="60" value="{{ $order['address'] }}">
                    </td>
                </tr>
                <tr>
                    <th width="150px">付款方式</th>
                    <td>
                        <select name="order[master][payway]">
                            <option value="">請選擇</option>
                            @foreach($payways as $payway)
                                <option {{ ($order['payway'] == $payway) ? 'selected' : '' }} value="{{ $payway }}">{{ $payway }}</option>
                            @endforeach
                        </select>
                    </td>
                    <th width="150px">付款狀態</th>
                    <td>
                        <select name="order[master][pay_status]">
                            <option value="">請選擇</option>
                            <option {{ ($order['pay_status'] == "未付款") ? 'selected' : '' }} value="未付款">未付款</option>
                            <option {{ ($order['pay_status'] == "已付款") ? 'selected' : '' }} value="已付款">已付款</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th width="150px">匯款後5碼</th>
                    <td colspan="3">
                        <input type="text" name="order[master][transfer_code]" value="{{ $order['transfer_code'] }}">
                    </td>
                </tr>
                <tr>
                    <th width="150px">配送方式</th>
                    <td colspan="3">
                        <select name="order[master][delivery_method]">
                            <option value="">請選擇</option>
                            <option {{ (strpos($order['delivery_method'], '超商') !== false) ? 'selected' : '' }} value="超商">超商</option>
                            <option {{ (strpos($order['delivery_method'], '黑貓') !== false) ? 'selected' : '' }} value="黑貓">黑貓</option>
                            <option {{ (strpos($order['delivery_method'], '宅配') !== false) ? 'selected' : '' }} value="宅配">宅配</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th width="150px">希望送達日期</th>
                    <td>
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
                    <th width="150px">希望送達時段</th>
                    <td>
                        <select name="order[master][delivery_time]">
                            <option value="" {{ $order['delivery_time'] == "" ? 'selected' : "" }}>任何時段皆可</option>
                            <option value="1" {{ $order['delivery_time'] == "1" ? 'selected' : "" }}>中午前</option>
                            <option value="2" {{ $order['delivery_time'] == "2" ? 'selected' : "" }}>下午：12：00 ~ 17：00</option>
                            <option value="3" {{ $order['delivery_time'] == "3" ? 'selected' : "" }}>晚上：17時 - 20時</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th width="150px">給店長的話</th>
                    <td colspan="3">
                        <textarea name="order[master][words_to_boss]" id="" cols="60" rows="4">{{ $order['words_to_boss'] }}</textarea>
                    </td>
                </tr>
                <tr>
                    <th width="150px">訂單備註</th>
                    <td colspan="3">
                        <textarea name="order[master][note]" id="" cols="60" rows="4">{{ $order['note'] }}</textarea>
                    </td>
                </tr>
                <tr>
                    <th width="150px">標示為冷藏件</th>
                    <td>
                        <input type="checkbox" name="order[master][isCool]"
                           {{ ($order['isCool'] == "1")
                           ? 'checked' : '' }} value="1">
                    </td>
                </tr>
            </table>
            <button type="button" class="btn btn-default add_row" id="add_row_{{ $key }}">
                增加一列商品
            </button>
            <table class="table" id="detail_table_{{ $key }}">
                <thead>
                    <tr>
                        <th></th>
                        <th>訂購商品</th>
                        <th>商品數量</th>
                        <th>單價</th>
                        <th>小計</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->detail as $key2 => $item)
                        <tr>
                            <td>
                                <button type="button" class="btn btn-danger remove_button">
                                    <i class="fa fa-remove"></i>
                                </button>
                            </td>
                            <td>
                                <input type="text" name="order[detail][{{ $key2 }}][item]" value="{{ $item['item'] }}">
                            </td>
                            <td>
                                <input style="text-align:right;" type="text" size="5" class="quantity"
                                    name="order[detail][{{ $key2 }}][quantity]" value="{{ $item['quantity'] }}">
                            </td>
                            <td>
                                <input style="text-align:right;" type="text" size="8" class="price"
                                    name="order[detail][{{ $key2 }}][price]" value="{{ $item['price'] }}">
                            </td>
                            <td>
                                <input style="text-align:right;" type="text" size="8" readonly
                                    id="subTotal_{{ $key2 }}" value="{{
                                        $item['quantity'] *
                                        $item['price']
                                    }}">

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">總計</th>
                        <td>
                            <input style="text-align:right;" type="text" size="8" readonly
                                id="total_{{ $key }}" value="{{
                                    $order->detail->sum(function ($item) {
                                        return $item['quantity'] * $item['price'];
                                    })
                                }}">
                        </td>
                    <tr>
                </tfoot>
            </table>
        </form>
        <div style="text-align: right;">
            <button class="btn btn-default save">儲存此訂單</button>
            <form action="{{ url("/b2cOrder/".$platform.'/'.$order['id']) }}"
                  class="form_of_delete" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <input type="hidden" name="upload_time" value="{{ $upload_time }}">
                <button class="btn btn-danger" onclick="return confirm('確認刪除訂單??');">
                    刪除
                </button>
            </form>
        </div>
    </div>
@endforeach
{{ $data->links() }}

@if (count($data) == 0)
    查無資料
@endif
{{-- <button class="btn btn-default" type="submit">確認送出</button> --}}
<br>
<a class="btn btn-default" href="{{ url("/b2cOrder") }}">回上一頁</a>

@if (isset($id))
    <script>
        location.hash = 'order_{{ $id }}';
    </script>
@endif

@endsection
