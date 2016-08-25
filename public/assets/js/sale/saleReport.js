$(function() {

    /**
     * 綁定客戶名稱自動完成的事件
     * @type {AjaxCombobox}
     */
    $('.company_autocomplete').AjaxCombobox({
        url: company_json_url,
        afterSelect : function (event, ui) {
            $('input.company_id').val(ui.item.id);
            $('input.company_code').val(ui.item.code);
        },
        response : function (item) {
            return {
                label: item.company_abb + ' - ' + item.company_name,
                value: item.company_name,
                id   : item.auto_id,
                code : item.company_code,
            }
        }
    });

    $('.company_code').AjaxFetchDataByField({
        url: company_json_url,
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
    //console.log($(this));
    $( "input.stock_autocomplete" ).AjaxCombobox({
        url: stock_json_url,
        afterSelect : function (event, ui) {
            $('input.stock_code').val(ui.item.code);
            $('input.stock_id').val(ui.item.id);
        },
        response : function (item) {
            return {
                label: item.code + ' - ' + item.name,
                value: item.name,
                id   : item.id,
                code : item.code,
            }
        }
    });

    $( "input.stock_code" ).AjaxFetchDataByField({
        url: stock_json_url,
        field_name : 'code',
        triggered_by : $('.stock_code'),
        afterFetch : function (event, data) {
            $('input.stock_autocomplete').val(data[0].name);
            $('input.stock_id').val(data[0].id);
        },
        removeIfInvalid : function () {
            $('input.stock_autocomplete').val('');
            $('input.stock_id').val('');
        }
    });


});
