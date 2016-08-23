@extends('layouts.app')

@inject('PublicPresenter', 'App\Presenters\PublicPresenter')
@inject('WarehousePresenter', 'Warehouse\WarehousePresenter')
@section('content')
        <script type="text/javascript">
            $(function() {

                $( "input.stock_autocomplete" ).each(function () {
                    if (typeof $(this).AjaxCombobox("instance") != "undefined") {
                        $(this).AjaxCombobox('destroy');
                    }
                    //console.log($(this));
                    $(this).AjaxCombobox({
                        url: '/stock/json',
                        afterSelect : function (event, ui) {

                            $('input.stock_code').val(ui.item.code);
                            $('input.stock_id').val(ui.item.id);
                            $('input.stock_no_tax_price').val(ui.item.price);
                            $('input.stock_unit').val(ui.item.unit);

                        },
                        response : function (item) {
                            return {
                                label: item.code + ' - ' + item.name,
                                value: item.name,
                                id   : item.id,
                                code : item.code,
                                price : item.no_tax_price_of_sold,
                                unit : item.unit.comment
                            }
                        }
                    });
                });
                $( "input.stock_code" ).each(function () {
                    if ($(this).AjaxFetchDataByField("instance")) {
                        $(this).AjaxFetchDataByField('destroy');
                    }

                    $(this).AjaxFetchDataByField({
                        url: '/stock/json',
                        field_name : 'code',
                        triggered_by : $('.stock_code'),
                        afterFetch : function (event, data) {
                            //var index2 = event.target.name.match(/\d+/g)[0];

                            $('input.stock_autocomplete').val(data[0].name);
                            $('input.stock_id').val(data[0].id);
                            $('input.stock_no_tax_price').val(data[0].no_tax_price_of_sold);
                            $('input.stock_unit').val(data[0].unit.comment);

                        },
                        removeIfInvalid : function () {
                            console.log(index);
                            $('input.stock_autocomplete').val('');
                            $('input.stock_id').val('');
                            $('input.stock_no_tax_price').val('');
                            $('input.stock_unit').val('');
                        }
                    });
                });
            });
        </script>
        <form action=" {{ url("/$routeName/printing") }}" method="GET" target="_blank">
            {{ csrf_field() }}
            <table id="master" width="100%">
                <tr>
                    <th>倉庫</th>
                    <td colspan="3">
                        <select name="warehouse_id">
                            <option></option>
                            {!! $WarehousePresenter->renderOptions(${$app_name}['warehouse_id']) !!}
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>品名</th>
                    <td>
                        <input type="text" class="stock_code" name="stock_code" value="" size="10">
                        <input type="hidden" class="stock_id" name="stock_id" value="">
                        <input type="text" class="stock_autocomplete" name="stock_name" value="">
                    </td>
                </tr>
            </table>
            <button type="submit" class="btn btn-default">確認送出</button>
        </form>

@endsection