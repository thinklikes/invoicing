/**
 * 客戶名稱的AjaxCombobox元件
 * 可以輸入或按下按鈕show出客戶
 */

$.widget( "custom.AjaxCombobox", {
    /**
     * 本元件建立時觸發的method
     * @return {void}
     */
    _create: function() {
        //設定一個全域物件為this
        MyObj = this;
        //設定ajax使用的token
        if (typeof $.ajaxSetup().headers == 'undefined') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
        //設定一個物件是外包裝提供使用者操作的
        // MyObj.wrapper = $( "<span>" )
        //     .addClass( "custom-company-combobox" )
        //     .insertAfter( MyObj.element );

        MyObj.input = MyObj.element;

        MyObj._createAutocomplete();

        MyObj._createShowAllButton();

        MyObj._createMessageBox();
    },
    /**
     * 建立autocomplete事件
     * @return {void} 不回傳任何值
     */
    _createAutocomplete: function() {
        //綁定autocomplete事件
        MyObj.input
            .prop('size', 40)
            //.attr( "title", "" )
            //.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
            .autocomplete({
                delay: 300,
                minLength: 2,
                source: $.proxy( MyObj, "_source" ),
            });
        //綁定autocomplete選取的事件
        MyObj._on( MyObj.input, {
            autocompleteselect: "_autocompleteselect"
        });
    },
    /**
     * 建立show出所有項目的按鈕
     * @return {void} 不回傳任何值
     */
    _createShowAllButton: function() {
        var input = MyObj.input;

        wasOpen = false;

        MyObj.button = $( "<button>" )
            .attr( "tabIndex", -1 )
            .attr( "title", "列出所有資料" )
            .attr( "type", "button" )
            .tooltip()
            .insertAfter( MyObj.input )
            .removeClass( "ui-corner-all" )
            .addClass( "custom-combobox-toggle ui-corner-right" )
            .append('<i class="fa fa-btn fa-caret-down"></i>')
            .on( "mousedown", function() {
                wasOpen = input.autocomplete( "widget" ).is( ":visible" );
            })
            .on( "click", function() {
                input.trigger( "focus" );

                // Close if already visible
                if ( wasOpen ) {
                    return;
                }
                var toSearch = (MyObj.input.val() != "") ? MyObj.input.val() : "  ";
                // Pass empty string as value to search for, displaying all results
                input.autocomplete( "search", toSearch );
            });
    },
    /**
     * 建立訊息盒子，提供錯誤資訊的顯示
     * @return {void} 不回傳任何值
     */
    _createMessageBox: function () {
        MyObj.messageBox = $("<span>")
            .css("color", "red")
            .insertAfter( MyObj.button );
    },
    /**
     * autocomplete的資料來源
     * @param  {object} request  請求的物件
     * @param  {response} response 回應的物件
     * @return {void}          不回傳任何值
     */
    _source: function (request, response) {
        $.ajax({
            method: "POST",
            url: MyObj.options.url,
            dataType: "json",
            data: {
                'name': request.term,
            },
            success: function( data ) {
                if (data.length > 0) {
                    response( $.map( data, function( item ) {
                        return {
                            label: item.company_abb + ' - ' + item.company_name,
                            value: item.company_name,
                            id   : item.auto_id,
                            //code   : item.code,
                        }
                    }));
                } else {
                    MyObj._removeIfInvalid();
                }
            }
        });
    },
    /**
     * 觸發menu項目選取的事件後，要做的事情
     * @param  {object} event 事件本體物件
     * @param  {object} ui    選擇項目的物件
     * @return {void}       不回傳任何值
     */
    _autocompleteselect: function ( event, ui ) {
        MyObj.options.afterSelect(ui);
    },
    /**
     * 顯示搜尋不到的訊息
     * @return {void} 不回傳任何值
     */
    _removeIfInvalid: function() {

        // Remove invalid value
        MyObj.messageBox.text( "找不到搜尋的資料：" + MyObj.input.val() );

        MyObj.input.val("");

        MyObj._delay(function() {
            MyObj.messageBox.text( "" );
        }, 2500 );

        MyObj.input.autocomplete( "instance" ).term = "";
    },
    /**
     * 移除這個UI工具
     * @return {void} 不回傳任何值
     */
    _destroy: function() {
        MyObj.wrapper.remove();
        MyObj.element.show();
    }
});