var calculator = new OrderCalculator({
    taxEnable:true,
    discountEnable:false,
    class_name: {
        quantity: 'stock_quantity',
        discount: 'discount',
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
     * 綁定供應商名稱的自動完成
     * @type {AjaxCombobox}
     */
    $('.supplier_autocomplete').AjaxCombobox({
        url: '/supplier/json',
        afterSelect : function (event, ui) {
            $('input.supplier_id').val(ui.item.id);
            $('input.supplier_code').val(ui.item.code);
        },
        response : function (item) {
            return {
                label: item.shortName + ' - ' + item.name,
                value: item.name,
                id   : item.id,
                code   : item.code,
            }
        }
    });

    $('.supplier_code').AjaxFetchDataByField({
        url: '/supplier/json',
        field_name : 'code',
        triggered_by : $('.supplier_code'),
        afterFetch : function (event, data) {
            $('input.supplier_id').val(data[0].id);
            $('input.supplier_autocomplete').val(data[0].name);
        },
        removeIfInvalid : function () {
            $('input.supplier_id').val('');
            $('input.supplier_autocomplete').val('');
        }
    });
    //將表單元素綁定到單據計算機的內部
    calculator.reCreateWidgets();
    //綁定料品品名自動完成的事件
    rebindStockCombobox();
    //rebindQuantityBlur();
    rebindDeleteButton();

    $('#add_a_row').click(function () {
        appendItem();
        calculator.reCreateWidgets();
        rebindStockCombobox();
        //rebindQuantityBlur();
        rebindDeleteButton();
    });

});

function rebindStockCombobox() {
    $( "input.stock_autocomplete" ).each(function () {
        if ($(this).AjaxCombobox("instance")) {
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

                calculator.calculate();
            },
            response : function (item) {
                return {
                    label: item.code + ' - ' + item.name,
                    value: item.name,
                    id   : item.id,
                    code : item.code,
                    price : item.no_tax_price_of_purchased,
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
                $('input.stock_no_tax_price').eq(index).val(data[0].no_tax_price_of_purchased);
                $('input.stock_unit').eq(index).val(data[0].unit.comment);

                calculator.calculate();
            },
            removeIfInvalid : function () {
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
