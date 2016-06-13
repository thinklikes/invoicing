var calculator = new OrderCalculator();

//要加這一段ajax才能生效
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function() {
    //綁定日期選取的事件
    $( "input[id='master_delivery_date']" ).datepicker({
        buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        showOn: 'button',
        dateFormat: "yy-mm-dd",
    });

    //綁定供應商名稱自動完成的事件
    $( "input[id='master_supplier_name']" ).autocomplete({
        source: function (request, response) {
            $.ajax({
                method: "POST",
                url: supplier_url,
                dataType: "json",
                data: {
                    'name': request.term,
                },
                success: function( data ) {
                    //console.log(data);
                    response( $.map( data, function( item ) {
                        return {
                            label: item.shortName + ' - ' + item.name,
                            value: item.name,
                            id   : item.id,
                            code   : item.code,
                        }
                    }));
                }
            });
        },
        select: function( event, ui ) {
            $('input[id="master_supplier_code"]').val(ui.item.code);
            $('input[id="master_supplier_id"]').val(ui.item.id);
        },
        minLength: 2
    });

    //綁定掃描供應商條碼的事件
    $( "input[id='master_supplier_code']" ).blur(function () {
        if ($(this).val() == "") {
            return false;
        }
        var code = $(this).val();
        $.ajax({
            method: "POST",
            url: supplier_url,
            dataType: "json",
            data: {
                'code': code
            },
            success: function( data ) {
                $('input[id="master_supplier_id"]').val(data[0].id);
                $('input[id="master_supplier_name"]').val(data[0].name);
                $('input[id^="detail_stock_code"]:first').focus();
            }
        });
    });

    //變更稅別時重新計算表單金額
    $('input[id^="tax_rate_code"]').click(function () {
        var id_list = getIdList();
        var tax_type = $('#tax_rate_code_A').is(":checked") ? "A" : "I";
        calculator.setIdList(id_list);
        calculator.setTaxType(tax_type);
        calculator.calculate();
    });

    //綁定料品品名自動完成的事件
    rebindStockAutocomplete();
    rebindDeleteButton();
    rebindCalc();

    $('#add_a_row').click(function () {
        //console.log($('table#detail tbody tr:last').find('button:first').attr('id'));
        if ($('table#detail tbody tr').length > 0) {
            var new_id = $('table#detail tbody tr:last').find('button:first').attr('id').match(/\d+/g)[0];
        } else {
            new_id = 0;
        }

        new_id = parseInt(new_id) + 1;
        var html ='\
            <tr>\
                <td>\
                    <button type="button" id="detail_remove_' + new_id + '"><i class="fa fa-remove"></i></button>\
                </td>\
                <td>\
                    <input type="text" id="detail_stock_code_' + new_id + '" name="' + order_name + 'Detail[' + new_id + '][stock_code]" size="10">\
                    <input type="hidden" id="detail_stock_id_' + new_id + '" name="' + order_name + 'Detail[' + new_id + '][stock_id]">\
                </td>\
                <td>\
                    <input type="text" id="detail_stock_name_' + new_id + '" name="' + order_name + 'Detail[' + new_id + '][stock_name]">\
                </td>\
                <td><input type="text" id="detail_quantity_' + new_id + '" name="' + order_name + 'Detail[' + new_id + '][quantity]" style="text-align:right;" size="5"></td>\
                <td><input type="text" id="detail_unit_' + new_id + '" name="' + order_name + 'Detail[' + new_id + '][unit]" readonly="" size="5"></td>\
                <td><input type="text" id="detail_no_tax_price_' + new_id + '" name="' + order_name + 'Detail[' + new_id + '][no_tax_price]" style="text-align:right;" size="10"></td>\
                <td><input type="text" id="detail_no_tax_amount_' + new_id + '" style="text-align:right;" size="10"></td>\
            </tr>';
        $('table#detail tbody').append(html);
        rebindStockAutocomplete();
        rebindDeleteButton();
        rebindCalc();
    });

});

/**
 * 重新綁定料品名稱自動完成的事件
 * @return void
*/
function rebindStockAutocomplete() {
    $( "input[id^='detail_stock_name']" ).unbind('autocomplete');
    $( "input[id^='detail_stock_name']" ).autocomplete({
        source: function (request, response) {
            $.ajax({
                method: "POST",
                url: stock_url,
                dataType: "json",
                data: {
                    'name': request.term
                },
                success: function( data ) {
                    response( $.map( data, function( item ) {
                        return {
                            label: item.code + ' - ' + item.name,
                            value: item.name,
                            id   : item.id,
                            code : item.code,
                            price : item.no_tax_price_of_purchased,
                            unit : item.unit.comment
                        }
                    }));
                }
            });
        },
        select: function( event, ui ) {
            var id = $(this).attr('id').match(/\d+/)[0];
            $('input[id="detail_stock_code_'+id+'"]').val(ui.item.code);
            $('input[id="detail_stock_id_'+id+'"]').val(ui.item.id);
            $('input[id="detail_no_tax_price_'+id+'"]').val(ui.item.price);
            $('input[id="detail_unit_'+id+'"]').val(ui.item.unit);
        },
        minLength: 2
    });

    //掃描料品代號的事件
    $( 'input[id^="detail_stock_code"]' ).unbind('blur');
    $( 'input[id^="detail_stock_code"]' ).blur(function () {
        if ($(this).val() == "") {
            return false;
        }
        var code = $(this).val();
        var id = $(this).attr('id').match(/\d+/g)[0];
        $.ajax({
            method: "POST",
            url: stock_url,
            dataType: "json",
            data: {
                'code': code
            },
            success: function( data ) {
                $('input[id="detail_stock_name_' + id + '"]').val(data[0].name);
                $('input[id="detail_stock_id_' + id + '"]').val(data[0].id);
                $('input[id="detail_no_tax_price_'+id+'"]').val(data[0].no_tax_price_of_purchased);
                $('input[id="detail_unit_'+id+'"]').val(data[0].unit.comment);
                $('input[id="detail_quantity_'+id+'"]').val(1);
                $('input[id="detail_quantity_' + id + '"]').focus();
            }
        });
    });

    //輸入完數量的事件
    $( "input[id^='detail_quantity']" ).unbind('blur');
    $( "input[id^='detail_quantity']" ).blur(function () {
        //重新計算金額
        var id_list = getIdList();
        var tax_type = $('#tax_rate_code_A').is(":checked") ? "A" : "I";
        calculator.setIdList(id_list);  //放入需要自動計算的id陣列
        calculator.setTaxType(tax_type);//放入目前稅別
        calculator.calculate();

        //將游標移動到下一個料品編號
        var id = $(this).attr('id').match(/\d+/g)[0];
        var index = $('input[id^="detail_stock_code"]').index(
            $('input[id="detail_stock_code_' + id + '"]')
        ) * 1;
        $('input[id^="detail_stock_code"]').get(
            index + 1
        ).focus();
        //$( "input[id^='detail_stock_code']" ).get(index + 1).focus();
        //console.log($('input[id="detail_stock_code_' + index + '"]').next('input[id="detail_stock_code_1"]').length);
        //$('input[id="detail_stock_code_' + index + '"]').next('input[id="detail_stock_code_1"]').focus();
        //$('input[id^="detail_quantity"]:eq(' + realy_index + ')').next().focus();
    });
}

/**
 * 重新綁定刪除按鈕的事件
 * @return {void}
 */
function rebindDeleteButton() {
    $('button[id^="detail_remove"').unbind('click');
    $('button[id^="detail_remove"').click(function () {
        $(this).parent().parent().remove();
        var id_list = getIdList();
        var tax_type = $('#tax_rate_code_A').is(":checked") ? "A" : "I";
        calculator.setIdList(id_list);  //放入需要自動計算的id陣列
        calculator.setTaxType(tax_type);//放入目前稅別
        calculator.calculate();
    });
}


/**
 * 重新綁定keyup的事件
 * @return {void}
 */
function rebindCalc() {
    $('input[id^="detail_quantity"], input[id^="detail_no_tax_price"]').unbind('keyup');
    $('input[id^="detail_quantity"], input[id^="detail_no_tax_price"]').keyup(function (){
        var id_list = getIdList();
        var tax_type = $('#tax_rate_code_A').is(":checked") ? "A" : "I";
        calculator.setIdList(id_list);  //放入需要自動計算的id陣列
        calculator.setTaxType(tax_type);//放入目前稅別
        calculator.calculate();
    });
}

function getIdList() {
    var id_list = {};
    id_list['master'] = {
        'total_no_tax_amount': 'total_no_tax_amount',
        'tax': 'tax',
        'total_amount': 'total_amount',
    };
    id_list['detail'] = [];

    var i = 0;
    $('input[id^="detail_quantity_"]').each(function () {
        var index = $(this).attr('id').match(/\d+/g)[0];
        id_list['detail'][i] = {
            'quantity':'detail_quantity_'+index,
            'no_tax_price':'detail_no_tax_price_'+index,
            'no_tax_amount':'detail_no_tax_amount_'+index,
        };
        i++;
    });
    return id_list;
}