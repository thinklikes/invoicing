//供應商自動完成所需資訊
var stock_url    = '/stock/json';
var supplier_url = '/supplier/json';
var triggered_by = {
    autocomplete: 'input.supplier_autocomplete',
    scan: 'input.supplier_code'
};
var auto_fill = {
    id: 'input.supplier_id',
    code :'input.supplier_code',
    name : 'input.supplier_autocomplete'
};
var after_triggering = {
    scan: function () {
        if ($('input.stock_code:first').length > 0) {
            $('input.stock_code:first').focus();
        }
    }
};

var supplierAutocompleter = new SupplierAutocompleter(supplier_url, triggered_by, auto_fill, after_triggering);

//表單計算機所需資訊
var class_name = {
    master: {
        total_no_tax_amount : 'total_no_tax_amount',
        tax : 'tax',
        total_amount : 'total_amount'
    },
    detail: {
        quantity : 'stock_quantity',
        no_tax_price : 'stock_no_tax_price',
        no_tax_amount : 'stock_no_tax_amount'
    },
    tax_rate_code : 'tax_rate_code'
}

var calculator = new OrderCalculator(class_name);

$(function() {
    //綁定供應商名稱的自動完成
    supplierAutocompleter.eventBind();

    //綁定料品品名自動完成的事件
    rebindStockAutocomplete();
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
                <td><input type="text" class="stock_quantity" name="' + app_name + 'Detail[' + new_id + '][quantity]" onkeyup="calculator.calculate();" style="text-align:right;" size="5"></td>\
                <td><input type="text" class="stock_unit" name="' + app_name + 'Detail[' + new_id + '][unit]" readonly="" size="5"></td>\
                <td><input type="text" class="stock_no_tax_price" name="' + app_name + 'Detail[' + new_id + '][no_tax_price]" style="text-align:right;" size="10"></td>\
                <td><input type="text" class="stock_no_tax_amount" style="text-align:right;" size="10"></td>\
            </tr>';
        $('table#detail tbody').append(html);
        rebindStockAutocomplete();
        //rebindQuantityBlur();
        rebindDeleteButton();
    });

});

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
