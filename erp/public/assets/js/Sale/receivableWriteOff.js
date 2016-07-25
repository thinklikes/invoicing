var index = 0;

var writeOffCalculator = new WriteOffCalculator(
    'credit_checked', 'credit_amount', 'total_credit_amount',
    'debit_checked', 'debit_amount', 'total_debit_amount');

$(function () {
    /**
     * 綁定客戶名稱自動完成的事件
     * @type {AjaxCombobox}
     */
    $('.company_autocomplete').AjaxCombobox({
        url: '/company/json',
        afterSelect : function (ecent, ui) {
            $('input.company_id').val(ui.item.id);

            getReceivableByCompanyId(ui.item.id);

            setTimeout('', 100);

            getReceiptByCompanyId(ui.item.id);

            setTimeout('', 100);
        },
        response : function (item) {
            return {
                label: item.company_abb + ' - ' + item.company_name,
                value: item.company_name,
                id   : item.auto_id,
                //code   : item.code,
            }
        }
    });
});

function fill_amount(index) {
    if ($('.credit_checked:eq(' + index + ')').prop('checked')) {
        var order_amount = $('.credit_order_amount:eq(' + index + ')').val() * 1;
        var received_amount = $('.credit_received_amount:eq(' + index + ')').val() * 1;

        $('.credit_amount:eq(' + index + ')').val(order_amount - received_amount);
    } else {
        $('.credit_amount:eq(' + index + ')').val('');
    }
}

/**
 * 透過ajax抓出銷貨單的應收帳款
 * 1. 先清除界面上應收帳款所有的項目
 * 2. request
 * 3. 把資料填入
 * @param  {string} company_id 供應商的id
 * @return {void}
 */
function getReceivableByCompanyId(company_id)
{
    clearReceivableHtml();

    $.ajax({
        method: "POST",
        url: '/billOfSale/json/getReceivableByCompanyId/' + company_id,
        dataType: "json",
        data: {
            'company_id' : company_id,
        },
        success: function( data ) {
            renderReceivableHtml(data, 'billOfSale');
        }
    });

    //抓出銷貨退回單的應收帳款
    $.ajax({
        method: "POST",
        url: '/returnOfSale/json/getReceivableByCompanyId/' + company_id,
        dataType: "json",
        data: {
            'company_id' : company_id,
        },
        success: function( data ) {
            renderReceivableHtml(data, 'returnOfSale');
        }
    });
}

/**
 * 清除界面上應收帳款所有的項目
 * @return {void}
 */
function clearReceivableHtml()
{
    $('table.receivable tbody tr').remove();
}

/**
 * 資料填入應收帳款區塊
 * @param  {json} data Json格式的應收帳款資料
 * @param  {string} type 辨別是銷貨單還是銷貨退回單參數
 * @return {void}
 */
function renderReceivableHtml(data, type)
{
    var content;
    var prefix = (type == 'billOfSale') ? '銷' : '退';
    var positive = (type == 'billOfSale') ? 1 : -1;
    for (key in data) {
        var date = new Date(data[key]['created_at']);
        date = date.toISOString().substring(0, 10);
        content += '<tr>\
                        <td>\
                            <input class="credit_checked" type="checkbox" name="receivableWriteOffCredit['+index+'][credit_checked]" onclick="fill_amount('+index+');writeOffCalculator.calculate();" value="1">\
                        </td>\
                        <td>\
                            ' + date + '\
                            <input class="credit_type" type="hidden" name="receivableWriteOffCredit['+index+'][credit_date]" value="' + date + '">\
                        </td>\
                        <td>\
                            ' + prefix + data[key]['code'] + '\
                            <input class="credit_type" type="hidden" name="receivableWriteOffCredit['+index+'][credit_type]" value="' + type + '">\
                            <input class="credit_code" type="hidden" name="receivableWriteOffCredit['+index+'][credit_code]" value="' + data[key]['code'] + '">\
                        </td>\
                        <td>\
                            ' + data[key]['invoice_code'] + '\
                            <input type="hidden" name="receivableWriteOffCredit['+index+'][credit_invoice_code]" value="' + data[key]['invoice_code'] + '">\
                        </td>\
                        <td class="numeric">' + (data[key]['total_amount'] * positive) + '</td>\
                        <td class="numeric">\
                            ' + (data[key]['total_amount'] * positive - data[key]['received_amount'] * positive) + '\
                            <input type="hidden" class="credit_order_amount" name="receivableWriteOffCredit['+index+'][credit_order_amount]" value="' + (data[key]['total_amount'] * positive) + '">\
                            <input type="hidden" class="credit_received_amount" name="receivableWriteOffCredit['+index+'][credit_received_amount]" value="' + (data[key]['received_amount'] * positive) + '">\
                        </td>\
                        <td><input type="text" class="credit_amount numeric" name="receivableWriteOffCredit['+index+'][credit_amount]" onkeyup="writeOffCalculator.calculate();" size="10"></td>\
                    </tr>';
        index ++;
    }
    $('table.receivable tbody').append(content);
}

/**
 * 清除界面上收款清單所有的項目
 * @return {void}
 */
function clearReceiptHtml()
{
    $('table.receipt tbody tr').remove();
}

/**
 * 透過ajax抓出收款清單
 * 1. 先清除界面上收款清單所有的項目
 * 2. request
 * 3. 把資料填入
 * @param  {string} company_id 供應商的id
 * @return {void}
 */
function getReceiptByCompanyId(company_id)
{
    //抓出銷貨單的應收帳款
    clearReceiptHtml();

    $.ajax({
        method: "POST",
        url: '/receipt/json/getReceiptByCompanyId/' + company_id,
        dataType: "json",
        data: {
            'company_id' : company_id,
        },
        success: function( data ) {
            renderReceiptHtml(data);
        }
    });
}

/**
 * 資料填入收款清單區塊
 * @param  {json} data Json格式的收款清單資料
 * @return {void}
 */
function renderReceiptHtml(data)
{
    var content;
    var i = 0;
    for (key in data) {
        content += '<tr>\
                        <td>\
                            <input class="debit_checked" type="checkbox" name="receivableWriteOffDebit['+i+'][debit_checked]"  onclick="writeOffCalculator.calculate();" value="1">\
                        </td>\
                        <td>\
                            ' + data[key]['receive_date'] + '\
                            <input type="hidden" name="receivableWriteOffDebit['+i+'][debit_receive_date]" value="' + data[key]['receive_date'] + '">\
                        </td>\
                        <td>\
                            ' + data[key]['code'] + '\
                            <input class="debit_code" type="hidden" name="receivableWriteOffDebit['+i+'][debit_code]" value="' + data[key]['code'] + '">\
                        </td>\
                        <td>\
                            ' + (data[key]['type'] == 'cash' ? '現金' : '票據') + '\
                            <input type="hidden" name="receivableWriteOffDebit['+i+'][debit_type]" value="' + data[key]['type'] + '">\
                        </td>\
                        <td>\
                            ' + (data[key]['check_code'] ? data[key]['check_code'] : '--') + '\
                            <input type="hidden" name="receivableWriteOffDebit['+i+'][debit_check_code]" value="' + data[key]['check_code'] + '">\
                        </td>\
                        <td class="numeric">\
                            ' + data[key]['amount'] + '\
                            <input class="debit_amount" type="hidden" name="receivableWriteOffDebit['+i+'][debit_amount]" value="' + data[key]['amount'] + '">\
                        </td>\
                    </tr>';
        i ++;
    }
    //console.log($('table.receipt').length);
    $('table.receipt tbody').append(content);
}