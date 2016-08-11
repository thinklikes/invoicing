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
                code : item.company_code,
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
});
