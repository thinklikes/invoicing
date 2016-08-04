var calculator = new OrderCalculator({
    taxEnable:true,
    discountEnable:false,
    class_name: {
        quantity: 'stock_quantity',
        //discount: 'discount',
        no_tax_price: 'stock_no_tax_price',
        subtotal: 'stock_no_tax_amount',
        tax_or_not: 'tax_rate_code',
        total_no_tax_amount: 'total_no_tax_amount',
        tax: 'tax',
        total_amount: 'total_amount'
    }
});

$(function() {
    /**
     * 綁定客戶名稱自動完成的事件
     * @type {AjaxCombobox}
     */

    $('.company_autocomplete').AjaxCombobox({
        url: '/company/json',
        afterSelect : function (event, ui) {
            $('input.company_id').val(ui.item.id);
            $('input.company_code').val(ui.item.code);
        },
        response : function (item) {
            return {
                label: item.company_abb + ' - ' + item.company_name,
                value: item.company_name,
                id   : item.auto_id,
                code   : item.company_code,
            }
        }
    });

    $('.company_code').AjaxFetchDataByField({
        url: '/company/json',
        field_name : 'code',
        afterFetch : function (event, data) {
            $('input.company_id').val(data[0].auto_id);
            $('input.company_autocomplete').val(data[0].company_name);
        },
        removeIfInvalid : function () {
            $('input.company_id').val('');
            $('input.company_autocomplete').val('');
        }
    });
    //將表單元素綁定到單據計算機的內部
    calculator.reCreateWidgets();
    //綁定料品品名自動完成的事件
    rebindStockCombobox();
    //rebindQuantityBlur();
    rebindDeleteButton();

    $('#add_a_row').click(function () {
        //console.log($('table#detail tbody tr:last').find('button:first').attr('id'));
        if ($('table#detail tbody tr').length > 0) {
            var new_id = $('table#detail tbody tr:last').find('input:first').attr('name').match(/\d+/g)[0];
        } else {
            new_id = 0;
        }

        new_id = parseInt(new_id) + 1;
        var html ='\
            <tr>\
                <td>\
                    <button type="button" class="remove_button"><i class="fa fa-remove"></i></button>\
                </td>\
                <td>\
                    <input type="text" class="stock_code" name="' + app_name + 'Detail[' + new_id + '][stock_code]" size="10">\
                    <input type="hidden" class="stock_id" name="' + app_name + 'Detail[' + new_id + '][stock_id]">\
                </td>\
                <td>\
                    <input type="text" class="stock_autocomplete" name="' + app_name + 'Detail[' + new_id + '][stock_name]">\
                </td>\
                <td>\
                    <select name="' + app_name + 'Detail[' + new_id + '][discount]" class="discount">\
                        <option value="1">不打折</option>\
                        <option value="0.9">9折</option>\
                        <option value="0.8">8折</option>\
                        <option value="0.7">7折</option>\
                        <option value="0.6">6折</option>\
                        <option value="0.5">5折</option>\
                    </select>\
                </td>\
                <td><input type="text" class="stock_quantity" name="' + app_name + 'Detail[' + new_id + '][quantity]" style="text-align:right;" size="5"></td>\
                <td><input type="text" class="stock_unit" name="' + app_name + 'Detail[' + new_id + '][unit]" readonly="" size="5"></td>\
                <td><input type="text" class="stock_no_tax_price" name="' + app_name + 'Detail[' + new_id + '][no_tax_price]" style="text-align:right;" size="10"></td>\
                <td><input type="text" class="stock_no_tax_amount" style="text-align:right;" size="10"></td>\
            </tr>';
        $('table#detail tbody').append(html);
        calculator.reCreateWidgets();
        rebindStockCombobox();
        //rebindQuantityBlur();
        rebindDeleteButton();
    });

});

function rebindStockCombobox() {
    $( "input.stock_autocomplete" ).each(function () {
        if (typeof $(this).AjaxCombobox("instance") != "undefined") {
            $(this).AjaxCombobox('destroy');
        }
        //console.log($(this));
        $(this).AjaxCombobox({
            url: '/stock/json',
            afterSelect : function (event, ui) {

                var index = event.target.name.match(/\d+/g)[0];

                $('input.stock_code:eq('+index+')').val(ui.item.code);
                $('input.stock_id').eq(index).val(ui.item.id);
                $('input.stock_no_tax_price').eq(index).val(ui.item.price);
                $('input.stock_unit').eq(index).val(ui.item.unit);

                //calculator.setDiscountByIndex(index, 1);
                calculator.calculate();
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
        var index = $(this).index(".stock_code");
        $(this).AjaxFetchDataByField({
            url: '/stock/json',
            field_name : 'code',
            triggered_by : $('.stock_code').eq(index),
            afterFetch : function (event, data) {
                //var index2 = event.target.name.match(/\d+/g)[0];

                $('input.stock_autocomplete').eq(index).val(data[0].name);
                $('input.stock_id').eq(index).val(data[0].id);
                $('input.stock_no_tax_price').eq(index).val(data[0].no_tax_price_of_sold);
                $('input.stock_unit').eq(index).val(data[0].unit.comment);
                //calculator.setDiscountByIndex(index, 1);
                calculator.calculate();
            },
            removeIfInvalid : function () {
                console.log(index);
                $('input.stock_autocomplete').eq(index).val('');
                $('input.stock_id').eq(index).val('');
                $('input.stock_no_tax_price').eq(index).val('');
                $('input.stock_unit').eq(index).val('');
            }
        });
    });
}
/**
 * 重新綁定料品名稱自動完成的事件
 * @return void
*/
// function rebindQuantityBlur() {
//     //輸入完數量的事件
//     $( 'input[id^="detail_quantity"], input[id^="detail_no_tax_price"]' ).unbind('blur');
//     $( 'input[id^="detail_quantity"], input[id^="detail_no_tax_price"]' ).blur(function () {
//         //重新計算金額
//         calculator.calculate();

//         //將游標移動到下一個料品編號
//         var id = $(this).attr('id').match(/\d+/g)[0];
//         var index = $('input[id^="detail_stock_code"]').index(
//             $('input[id="detail_stock_code_' + id + '"]')
//         ) * 1;
//         $('input[id^="detail_stock_code"]').get(
//             index + 1
//         ).focus();
//         //$( "input[id^='detail_stock_code']" ).get(index + 1).focus();
//         //console.log($('input[id="detail_stock_code_' + index + '"]').next('input[id="detail_stock_code_1"]').length);
//         //$('input[id="detail_stock_code_' + index + '"]').next('input[id="detail_stock_code_1"]').focus();
//         //$('input[id^="detail_quantity"]:eq(' + realy_index + ')').next().focus();
//     });
// }

/**
 * 重新綁定刪除按鈕的事件
 * @return {void}
 */
function rebindDeleteButton() {
    $('button.remove_button').unbind('click');
    $('button.remove_button').click(function () {
        $(this).parent().parent().remove();
        calculator.calculate();
    });
}
