function appendItem (discount_enabled = false)
{

    //console.log($('table#detail tbody tr:last').find('button:first').attr('id'));
    if ($('#detail_table .tbody .tr').length > 0) {
        var new_id = $('#detail_table .tbody .tr:last').find('input:first').attr('name').match(/\d+/g)[0];
    } else {
        new_id = 0;
    }

    new_id = parseInt(new_id) + 1;

    var tr = $('<div></div>')
        .addClass('tr');

    //刪除按鈕的td
    var delete_cell = $('<div></div>')
        .addClass('td')
        .append(
            $('<button></button>')
                .prop('type', 'button')
                .addClass('btn btn-danger remove_button')
                .append('<i class="fa fa-remove"></i>')
        );

    //料品編號
    var stock_code_cell = $('<div></div>')
        .addClass('td')
        .prop('data-title', '料品編號')
        .append(
            $('<input>')
                .prop('type', 'text')
                .prop('size', '10')
                .prop('name', app_name + 'Detail[' + new_id + '][stock_code]')
                .addClass('stock_code'),
            $('<input>')
                .prop('type', 'hidden')
                .prop('name', app_name + 'Detail[' + new_id + '][stock_id]')
                .addClass('stock_id')
        );

    //料品名稱
    var stock_name_cell = $('<div></div>')
        .addClass('td')
        .prop('data-title', '料品名稱')
        .append(
            $('<input>')
                .prop('type', 'text')
                .prop('name', app_name + 'Detail[' + new_id + '][stock_name]')
                .addClass('stock_autocomplete')
        );

    if (discount_enabled) {
        //優惠折扣
        var discount_cell = $('<div></div>')
            .addClass('td')
            .prop('data-title', '優惠折扣')
            .append(
                $('<input>')
                    .prop('type', 'text')
                    .prop('size', '5')
                    .prop('name', app_name + 'Detail[' + new_id + '][discount]')
                    .addClass('discount numeric'),
                '％'
            );
    } else {
        var discount_cell = null;
    }


    //料品數量
    var stock_quantity_cell = $('<div></div>')
        .addClass('td')
        .prop('data-title', '料品數量')
        .append(
            $('<input>')
                .prop('type', 'text')
                .prop('size', '5')
                .prop('name', app_name + 'Detail[' + new_id + '][quantity]')
                .addClass('stock_quantity numeric')
        );

    //料品單位
    var stock_unit_cell = $('<div></div>')
        .addClass('td')
        .prop('data-title', '料品單位')
        .append(
            $('<input>')
                .prop('type', 'text')
                .prop('size', '5')
                .prop('name', app_name + 'Detail[' + new_id + '][unit]')
                .prop('readonly', true)
                .addClass('stock_unit')
        );

    //稅前單價
    var stock_no_tax_price_cell = $('<div></div>')
        .addClass('td')
        .prop('data-title', '稅前單價')
        .append(
            $('<input>')
                .prop('type', 'text')
                .prop('size', '10')
                .prop('name', app_name + 'Detail[' + new_id + '][no_tax_price]')
                .addClass('stock_no_tax_price numeric')
        );

    //未稅金額
    var stock_no_tax_amount_cell = $('<div></div>')
        .addClass('td')
        .prop('data-title', '未稅金額')
        .append(
            $('<input>')
                .prop('type', 'text')
                .prop('size', '10')
                .addClass('stock_no_tax_amount numeric')
        );

    tr.append(
        delete_cell,
        stock_code_cell,
        stock_name_cell,
        discount_cell,
        stock_quantity_cell,
        stock_unit_cell,
        stock_no_tax_price_cell,
        stock_no_tax_amount_cell
    )

    $('#detail_table .tbody').append(tr);
}
