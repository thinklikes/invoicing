/**
 * 綁定客戶名稱自動完成的程式
 * 以及掃描供應商條碼自動填入的程式
 * 本程式必須啟用Jquery
 */
/**
 * Javascript Class CompanyAutocompleter
 * @param {string} request_url      請求資料的網址
 * @param {object} triggered_by     autocomplete模組的觸發元素是input.company_autocomplete
 *                                  scan模組的觸發元素是input.company_code
 * @param {object} auto_fill        會自動填入的元素
 * @param {Object} after_triggering autocomplete觸發後要執行的方法
 */
function CompanyAutocompleter(request_url, triggered_by, auto_fill,
    after_triggering = {}) {

    MyObj = this;
    request_url = request_url;
    triggeredBySelectors = triggered_by;
    auto_fill = auto_fill;
    after_triggering = after_triggering;

    if (typeof $.ajaxSetup().headers == 'undefined') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    MyObj.eventBind = function () {
        /**
         * 透過jquery ui的autocomplete抓出供應商資料
         */
        $( triggeredBySelectors['autocomplete'] ).autocomplete({
            source: function (request, response) {
                $.ajax({
                    method: "POST",
                    url: request_url,
                    dataType: "json",
                    data: {
                        'name': request.term,
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.company_abb + ' - ' + item.company_name,
                                value: item.company_name,
                                id   : item.auto_id,
                                //code   : item.code,
                            }
                        }));
                    }
                });
            },
            select: function( event, ui ) {
                // if ($(auto_fill['code']).length > 0) {
                //     $(auto_fill['code']).val(ui.item.code);
                // }
                if ($(auto_fill['id']).length > 0) {
                    $(auto_fill['id']).val(ui.item.id);
                }
                if (typeof after_triggering['autocomplete'] == "function") {
                    after_triggering['autocomplete'](ui.item.id);
                }
            },
            minLength: 2
        });
        /**
         * 掃描時
         * 透過jquery的ajax抓出供應商資料
         */
        // $( triggeredBySelectors['scan'] ).blur(function () {
        //     if ($(this).val() == "") {
        //         return false;
        //     }
        //     var code = $(this).val();
        //     $.ajax({
        //         method: "POST",
        //         url: request_url,
        //         dataType: "json",
        //         data: {
        //             'code': code,
        //         },
        //         success: function( data ) {
        //             if ($(auto_fill['id']).length > 0) {
        //                 $(auto_fill['id']).val(data[0].id);
        //             }
        //             if ($(auto_fill['name']).length > 0) {
        //                 $(auto_fill['name']).val(data[0].name);
        //             }
        //             if (typeof after_triggering['scan'] == "function") {
        //                 after_triggering['scan'](data[0].id);
        //             }
        //         }
        //     });
        // });
    }
}