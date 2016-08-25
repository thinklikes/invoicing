//借方項目的index
var index = 0;

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
    scan: function (supplier_id)
    {
        if ($('input.stock_code:first').length > 0) {
            $('input.stock_code:first').focus();
        }

        index = 0;

        getPayableBySupplierId(supplier_id);

        setTimeout('', 100);

        getPaymentBySupplierId(supplier_id);

        setTimeout('', 100);
    }
};

var writeOffCalculator = new WriteOffCalculator(
    'credit_checked', 'credit_amount', 'total_credit_amount',
    'debit_checked', 'debit_amount', 'total_debit_amount');

$(function () {
    /**
     * 綁定供應商名稱的自動完成
     * @type {AjaxCombobox}
     */

    $('.supplier_autocomplete').AjaxCombobox({
        url: supplier_json_url,
        afterSelect : function (event, ui) {
            $('input.supplier_id').val(ui.item.id);
            $('input.supplier_code').val(ui.item.code);

            index = 0;

            getPayableBySupplierId(ui.item.id);

            setTimeout('', 100);

            getPaymentBySupplierId(ui.item.id);

            setTimeout('', 100);
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
        url: supplier_json_url,
        field_name : 'code',
        triggered_by : $('.supplier_code'),
        afterFetch : function (event, data) {
            $('input.supplier_id').val(data[0].id);
            $('input.supplier_autocomplete').val(data[0].name);
            index = 0;

            getPayableBySupplierId(data[0].id);

            setTimeout('', 100);

            getPaymentBySupplierId(data[0].id);

            setTimeout('', 100);
        },
        removeIfInvalid : function () {
            $('input.supplier_id').val('');
            $('input.supplier_autocomplete').val('');
        }
    });
});

function fill_amount(index) {
    if ($('.debit_checked:eq(' + index + ')').prop('checked')) {
        var order_amount = $('.debit_order_amount:eq(' + index + ')').val() * 1;
        var paid_amount = $('.debit_paid_amount:eq(' + index + ')').val() * 1;

        $('.debit_amount:eq(' + index + ')').val(order_amount - paid_amount);
    } else {
        $('.debit_amount:eq(' + index + ')').val('');
    }
}

/**
 * 透過ajax抓出進貨單的應付帳款
 * 1. 先清除界面上應付帳款所有的項目
 * 2. request
 * 3. 把資料填入
 * @param  {string} supplier_id 供應商的id
 * @return {void}
 */
function getPayableBySupplierId(supplier_id)
{
    clearPayableHtml();

    $.ajax({
        method: "POST",
        url: billOfPurchase_json_url,
        dataType: "json",
        data: {
            'supplier_id' : supplier_id,
        },
        success: function( data ) {
            renderPayableHtml(data, 'billOfPurchase');
        }
    });

    //抓出進貨退回單的應付帳款
    $.ajax({
        method: "POST",
        url: returnOfPurchase_json_url,
        dataType: "json",
        data: {
            'supplier_id' : supplier_id,
        },
        success: function( data ) {
            renderPayableHtml(data, 'returnOfPurchase');
        }
    });
}

/**
 * 清除界面上應付帳款所有的項目
 * @return {void}
 */
function clearPayableHtml()
{
    $('table.payable tbody tr').remove();
}

/**
 * 資料填入應付帳款區塊
 * @param  {json} data Json格式的應付帳款資料
 * @param  {string} type 辨別是進貨單還是進貨退回單參數
 * @return {void}
 */
function renderPayableHtml(data, type)
{
    var content;
    var prefix = (type == 'billOfPurchase') ? '進' : '退';
    var positive = (type == 'billOfPurchase') ? 1 : -1;
    for (key in data) {
        var date = new Date(data[key]['created_at']);
        date = date.toISOString().substring(0, 10);
        content += '<tr>\
                        <td>\
                            <input class="debit_checked" type="checkbox" name="payableWriteOffDebit['+index+'][debit_checked]" onclick="fill_amount('+index+');writeOffCalculator.calculate();" value="1">\
                        </td>\
                        <td>\
                            ' + date + '\
                            <input class="debit_type" type="hidden" name="payableWriteOffDebit['+index+'][debit_date]" value="' + date + '">\
                        </td>\
                        <td>\
                            ' + prefix + data[key]['code'] + '\
                            <input class="debit_type" type="hidden" name="payableWriteOffDebit['+index+'][debit_type]" value="' + type + '">\
                            <input class="debit_code" type="hidden" name="payableWriteOffDebit['+index+'][debit_code]" value="' + data[key]['code'] + '">\
                        </td>\
                        <td>\
                            ' + data[key]['invoice_code'] + '\
                            <input type="hidden" name="payableWriteOffDebit['+index+'][debit_invoice_code]" value="' + data[key]['invoice_code'] + '">\
                        </td>\
                        <td class="numeric">' + (data[key]['total_amount'] * positive) + '</td>\
                        <td class="numeric">\
                            ' + (data[key]['total_amount'] * positive - data[key]['paid_amount'] * positive) + '\
                            <input type="hidden" class="debit_order_amount" name="payableWriteOffDebit['+index+'][debit_order_amount]" value="' + (data[key]['total_amount'] * positive) + '">\
                            <input type="hidden" class="debit_paid_amount" name="payableWriteOffDebit['+index+'][debit_paid_amount]" value="' + (data[key]['paid_amount'] * positive) + '">\
                        </td>\
                        <td><input type="text" class="debit_amount numeric" name="payableWriteOffDebit['+index+'][debit_amount]" onkeyup="writeOffCalculator.calculate();" size="10"></td>\
                    </tr>';
        index ++;
    }
    $('table.payable tbody').append(content);
}

/**
 * 清除界面上付款清單所有的項目
 * @return {void}
 */
function clearPaymentHtml()
{
    $('table.payment tbody tr').remove();
}

/**
 * 透過ajax抓出付款清單
 * 1. 先清除界面上付款清單所有的項目
 * 2. request
 * 3. 把資料填入
 * @param  {string} supplier_id 供應商的id
 * @return {void}
 */
function getPaymentBySupplierId(supplier_id)
{
    //抓出進貨單的應付帳款
    clearPaymentHtml();
    $.ajax({
        method: "POST",
        url: payment_json_url,
        dataType: "json",
        data: {
            'supplier_id' : supplier_id,
        },
        success: function( data ) {
            renderPaymentHtml(data);
        }
    });
}

/**
 * 資料填入付款清單區塊
 * @param  {json} data Json格式的付款清單資料
 * @return {void}
 */
function renderPaymentHtml(data)
{
    var content;
    var i = 0;
    for (key in data) {
        content += '<tr>\
                        <td>\
                            <input class="credit_checked" type="checkbox" name="payableWriteOffCredit['+i+'][credit_checked]"  onclick="writeOffCalculator.calculate();" value="1">\
                        </td>\
                        <td>\
                            ' + data[key]['pay_date'] + '\
                            <input type="hidden" name="payableWriteOffCredit['+i+'][credit_pay_date]" value="' + data[key]['pay_date'] + '">\
                        </td>\
                        <td>\
                            ' + data[key]['code'] + '\
                            <input class="credit_code" type="hidden" name="payableWriteOffCredit['+i+'][credit_code]" value="' + data[key]['code'] + '">\
                        </td>\
                        <td>\
                            ' + (data[key]['type'] == 'cash' ? '現金' : '票據') + '\
                            <input type="hidden" name="payableWriteOffCredit['+i+'][credit_type]" value="' + data[key]['type'] + '">\
                        </td>\
                        <td>\
                            ' + (data[key]['check_code'] ? data[key]['check_code'] : '--') + '\
                            <input type="hidden" name="payableWriteOffCredit['+i+'][credit_check_code]" value="' + data[key]['check_code'] + '">\
                        </td>\
                        <td class="numeric">\
                            ' + data[key]['amount'] + '\
                            <input class="credit_amount" type="hidden" name="payableWriteOffCredit['+i+'][credit_amount]" value="' + data[key]['amount'] + '">\
                        </td>\
                    </tr>';
        i ++;
    }
    //console.log($('table.payment').length);
    $('table.payment tbody').append(content);
}