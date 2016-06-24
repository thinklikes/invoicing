$(function() {
    //要加這一段ajax才能生效
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var supplier_url = '/suppliers/json';
    //綁定供應商名稱自動完成的事件
    $( "input.supplier_autocomplete" ).autocomplete({
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
            if ($('input.supplier_code').length > 0) {
                $('input.supplier_code').val(ui.item.code);
            }
            if ($('input.supplier_id').length > 0) {
                $('input.supplier_id').val(ui.item.id);
            }
        },
        minLength: 2
    });
    //綁定掃描供應商條碼的事件
    $( "input.supplier_code" ).blur(function () {
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
                if ($('input.supplier_id"]').length > 0) {
                    $('input.supplier_id"]').val(data[0].id);
                }
                if ($('input.supplier_name"]').length > 0) {
                    $('input.supplier_name').val(data[0].name);
                }
                if ($('input.stock_code:first').length > 0) {
                    $('input.stock_code:first').focus();
                }
            }
        });
    });
});