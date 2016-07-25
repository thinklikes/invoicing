/**
 * 客戶名稱的AjaxCombobox元件
 * 可以輸入或按下按鈕show出客戶
 */


$.widget( "custom.AjaxCombobox", {
    /**
     * 本元件建立時觸發的method
     * @return {void}
     */
    defaultElement:"<input>",

    _create: function() {
        this.input = this.element;

        this.button = null;

        this.messageBox = null;
        //設定ajax使用的token
        if (typeof $.ajaxSetup().headers == 'undefined') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
        //設定一個物件是外包裝提供使用者操作的
        // this.wrapper = $( "<span>" )
        //     .addClass( "custom-company-combobox" )
        //     .insertAfter( this.element );

        this._createAutocomplete();

        this._createShowAllButton();

        this._createMessageBox();
    },
    /**
     * 建立autocomplete事件
     * @return {void} 不回傳任何值
     */
    _createAutocomplete: function() {
        //綁定autocomplete事件
        this.input
            //.prop('size', 40)
            //.attr( "title", "" )
            //.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
            .autocomplete({
                delay: 300,
                minLength: 2,
                source: $.proxy( this, "_source" ),
                open: function() {
                    $('.ui-autocomplete').css({
                        'max-height': '200px',
                        'overflow-y': 'auto',
                        /* prevent horizontal scrollbar */
                        'overflow-x': 'hidden',
                        'width':'500px'
                    });
                }
            });
        //綁定autocomplete選取的事件
        this._on( this.input, {
            autocompleteselect: function ( event, ui ) {
                this.options.afterSelect(event, ui);
            }
        });
    },
    /**
     * 建立show出所有項目的按鈕
     * @return {void} 不回傳任何值
     */
    _createShowAllButton: function() {
        var input = this.input;

        wasOpen = false;

        this.button = $( "<button>" )
            .attr( "tabIndex", -1 )
            .attr( "title", "列出所有資料" )
            .attr( "type", "button" )
            .tooltip()
            .insertAfter( this.input )
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
                var toSearch = (input.val() != "") ? input.val() : "  ";
                // Pass empty string as value to search for, displaying all results
                input.autocomplete( "search", toSearch );
            });
    },
    /**
     * 建立訊息盒子，提供錯誤資訊的顯示
     * @return {void} 不回傳任何值
     */
    _createMessageBox: function () {
        this.messageBox = $("<span>")
            .css("color", "red")
            .insertAfter( this.button );
    },
    /**
     * autocomplete的資料來源
     * @param  {object} request  請求的物件
     * @param  {response} response 回應的物件
     * @return {void}          不回傳任何值
     */
    _source: function (request, response) {
        options = this.options;
        $.ajax({
            method: "POST",
            url: this.options.url,
            dataType: "json",
            data: {
                'name': request.term,
            },
            success: function( data ) {
                if (data.length > 0) {
                    response(
                        $.map( data, function( item ) {
                            return options.response(item);
                        })
                    );
                } else {
                    this._removeIfInvalid();
                }
            }
        });
    },
    /**
     * 顯示搜尋不到的訊息
     * @return {void} 不回傳任何值
     */
    _removeIfInvalid: function() {

        // Remove invalid value
        this.messageBox.text( "找不到搜尋的資料：" + this.input.val() );

        this.input.val("");

        messageBox = this.messageBox;
        this._delay(function() {
            messageBox.text( "" );
        }, 2500 );

        this.input.autocomplete( "instance" ).term = "";
    },
    /**
     * 移除這個UI工具
     * @return {void} 不回傳任何值
     */
    _destroy: function() {
        this.input.autocomplete("destroy");
        this.button.remove();
        this.messageBox.remove();
    }
});