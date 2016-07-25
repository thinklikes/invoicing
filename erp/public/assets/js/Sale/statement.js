$(function() {

    /**
     * 綁定客戶名稱自動完成的事件
     * @type {AjaxCombobox}
     */
    $('.company_autocomplete').AjaxCombobox({
        url: '/company/json',
        afterSelect : function (event, ui) {
            $('input.company_id').val(ui.item.id)
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
    // var autocompleter = new CompanyAutocompleter({
    //     request_url : '/company/json',
    //     triggered_by_class : 'input.company_autocomplete',

    //     after_triggering : {}
    // });


    // var scaner = new Scaner({
    //     request_url : '/company/json',
    //     triggered_by_class : 'input.company_code',
    //     auto_fill_by_id : {
    //         id: 'input.company_id',
    //         //code :'input.company_code',
    //         name : 'input.company_autocomplete'
    //     },
    //     after_triggering : function () {
    //         if ($('input.stock_code:first').length > 0) {
    //             $('input.stock_code:first').focus();
    //         }
    //     }
    // });

});
