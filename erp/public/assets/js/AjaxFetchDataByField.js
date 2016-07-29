/**
 * 客戶代碼欄位的元件
 * 可以輸入或按下按鈕show出客戶
 *   這是用以觸發options的事件
 *   if ( false !== this._trigger( "select", event, { item: item } ) ) {
 *          this._value( item.value );
 *   }
 */


$.widget( "custom.AjaxFetchDataByField", {
    /**
     * 本元件建立時觸發的method
     * @return {void}
     */
    defaultElement:"<input>",
    option: {
        url: '',
        afterFetch: null,
        field_name: '',
        removeIfInvalid: null
    },
    _create: function() {
        this._afterFetch = this.options.afterFetch;
        this._url = this.options.url;
        this._field_name = this.options.field_name;
        this.input = this.element;

        //console.log(typeof this._afterFetch);
        //設定ajax使用的token
        if (typeof $.ajaxSetup().headers == 'undefined') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        this._createAjax();

        //this._createMessageBox();
    },
    /**
     * 建立autocomplete事件
     * @return {void} 不回傳任何值
     */
    _createAjax: function() {
        var MyObj = this;

        var funcAfterFetch = MyObj._afterFetch;

        var funcRemoveIfInvalid = MyObj._removeIfInvalid;

        var field_name = MyObj._field_name;

        //綁定autocomplete選取的事件
        this._on( this.input, {
            blur: function (event, ui) {
                if (MyObj.element.value == '') {
                    return false;
                }
                var data_to_send = {};

                data_to_send[field_name] = MyObj.element[0].value;

                $.ajax({
                    method: "POST",
                    url: MyObj._url,
                    dataType: "json",
                    data: data_to_send,
                    success: function( data ) {
                        if (data.length > 0) {
                            funcAfterFetch(event, data);
                        } else {
                            funcRemoveIfInvalid(MyObj);

                        }
                    }
                });
            }
        });
    },
    /**
     * 建立訊息盒子，提供錯誤資訊的顯示
     * @return {void} 不回傳任何值
     */
    // _createMessageBox: function () {
    //     this.messageBox = $("<div></div>")
    //         .css("color", "red")
    //         //.css("float", "right")
    //         .appendTo( 'body' );
    // },
    /**
     * 移除這個UI工具
     * @return {void} 不回傳任何值
     */
    _destroy: function() {
        this.input.unbind("blur");
    },
    _removeIfInvalid : function(MyObj) {
        // Remove invalid value
        MyObj.input.val( "找不到" + MyObj.input.val() );

        MyObj._delay(function() {
            MyObj.input.val("");
        }, 2500 );

        MyObj.options.removeIfInvalid();
    }
});