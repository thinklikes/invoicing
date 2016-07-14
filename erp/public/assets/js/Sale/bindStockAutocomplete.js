
//要加這一段ajax才能生效
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


function rebindStockAutocomplete() {
    $( "input.stock_autocomplete" ).unbind('autocomplete');
    $( "input.stock_autocomplete" ).autocomplete({
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
                            price : item.no_tax_price_of_sold,
                            unit : item.unit.comment
                        }
                    }));
                }
            });
        },
        select: function( event, ui ) {
            var index = $(this).index('input.stock_autocomplete');
            $('input.stock_code').eq(index).val(ui.item.code);
            $('input.stock_id').eq(index).val(ui.item.id);
            $('input.stock_no_tax_price').eq(index).val(ui.item.price);
            $('input.stock_unit').eq(index).val(ui.item.unit);
        },
        minLength: 2
    });

    //掃描料品代號的事件
    $('input.stock_code').unbind('blur');
    $('input.stock_code').blur(function () {
        if ($(this).val() == "") {
            return false;
        }
        var code = $(this).val();
        var index = $(this).index('input.stock_code');
        //var id = $(this).attr('id').match(/\d+/g)[0];
        $.ajax({
            method: "POST",
            url: stock_url,
            dataType: "json",
            data: {
                'code': code
            },
            success: function( data ) {
                $('input.stock_autocomplete').eq(index).val(data[0].name);
                $('input.stock_id').eq(index).val(data[0].id);
                $('input.stock_no_tax_price').eq(index).val(data[0].no_tax_price_of_sold);
                $('input.stock_unit').eq(index).val(data[0].unit.comment);
                $('input.stock_quantity').eq(index).val(1);
                $('input.stock_quantity').eq(index).focus();
                $('input.stock_quantity').eq(index).select();
            }
        });
    });
}
