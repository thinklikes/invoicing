/**
 * 單據計算機的class
 * string (A, I) old_tax_type 記憶上一次的稅別
 * array         old_discount 記憶上一次各個品項的折扣
 * Object        puller       資料抓取器
 * Object        pusher       資料發佈器
 * Object        data         資料的暫存器
 * function      pull         抓取資料
 * function      push         發佈資料
 * function      createWidgets 把各個元素建立成widget
 * function      calculate    計算各項資料
 * boolean       taxEnable    是否開啟稅
 * boolean       discountEnable    是否開折扣
 */
function OrderCalculator(options, puller = new Puller(), pusher = new Pusher()) {
    MyObj=this;

    options        = options
    old_tax_type   = 'A';
    old_discount   = ['', '', '', '', ''];
    puller         = puller;
    pusher         = pusher;
    data           = null;
    taxEnable      = options.taxEnable;
    discountEnable = options.discountEnable;

    var pull = function () {
        return puller.pullByClassName({
            taxEnable: taxEnable,
            discountEnable: discountEnable
        });
    }

    var push = function (data) {
        pusher.pushByClassName(data, {
            taxEnable: taxEnable,
            discountEnable: discountEnable
        });
    }
    //建立widgets
    MyObj.reCreateWidgets = function () {
        $('.' + options.class_name.quantity).each(function (index, ele) {
            if ($(this).quantity("instance")) {
                $(this).quantity("destroy")
            }
            $(this).quantity({
                blur:function () {
                    MyObj.calculate();
                },
                keyup:function () {
                    MyObj.calculate();
                },
            });
        });


        $('.' + options.class_name.discount).each(function (index, ele) {
            if ($(this).discount("instance")) {
                $(this).discount("destroy")
            }
            $(this).discount({
                keyup:function () {
                    MyObj.calculate();
                },
            });
        });

        $('.' + options.class_name.no_tax_price).each(function (index, ele) {
            if ($(this).no_tax_price("instance")) {
                $(this).no_tax_price("destroy")
            }
            $(this).no_tax_price({
                blur:function () {
                    MyObj.calculate();
                },
                keyup:function () {
                    MyObj.calculate();
                },
            });
        });

        $('.' + options.class_name.subtotal).each(function (index, ele) {
            if ($(this).subtotal("instance")) {
                $(this).subtotal("destroy")
            }
            $(this).subtotal({});
        });

        if ($('.' + options.class_name.tax_or_not).tax_or_not("instance")) {
            $('.' + options.class_name.tax_or_not).tax_or_not("destroy");
        }
        $('.' + options.class_name.tax_or_not).tax_or_not({
            change:function () {
                MyObj.calculate();
            },
            click:function () {
                MyObj.calculate();
            },
        });

        if ($('.' + options.class_name.total_no_tax_amount)
            .total_no_tax_amount("instance")) {

            $('.' + options.class_name.total_no_tax_amount)
                .total_no_tax_amount("destroy");
        }
        $('.' + options.class_name.total_no_tax_amount)
            .total_no_tax_amount({});

        if ($('.' + options.class_name.tax).tax("instance")) {
            $('.' + options.class_name.tax).tax("destroy");
        }
        $('.' + options.class_name.tax).tax({});

        if ($('.' + options.class_name.total_amount).total_amount("instance")) {
            $('.' + options.class_name.total_amount).total_amount("destroy");
        }
        $('.' + options.class_name.total_amount)
            .total_amount({});
    }

    MyObj.calculate = function () {
        var total_no_tax_amount = 0;
        var tax                 = 0;
        var total_amount        = 0;
        var push_data           = [];
        //開始自html文件中取出資料
        data = pull();

        //開始計算金額
        for (key in data['custom-quantity']) {
            var quantity      = data['custom-quantity'][key] * 1;
            var no_tax_price  = data['custom-no-tax-price'][key] * 1;
            var no_tax_amount = 0;

            if (!quantity && !no_tax_price) {
                continue;
            }

            //==========先還原單價=================開始
            //先復原折扣
            if (discountEnable) {
                if (typeof old_discount[key] != 'undefined') {
                    var discount = old_discount[key];
                } else {
                    var discount = 100;
                }
                try {
                    // 需要測試的語句
                    if (discount == '') {
                        throw "no discount";
                    }
                    no_tax_price = no_tax_price / (discount / 100);
                }
                catch (e) {
                    no_tax_price = no_tax_price / (100 / 100);
                }
            }
            //再復原稅別
            if (taxEnable) {
                if (old_tax_type == 'A' || old_tax_type == 'N') {
                    //將原始的稅錢單價倒推為稅內含
                    no_tax_price = no_tax_price / (1 + _tax_rate);
                } else {
                    no_tax_price = no_tax_price;
                }
            }
            //console.log("2@" + no_tax_price);
            //==========先還原單價=================結束

            //==========計算單價===================開始
            if (taxEnable) {
                if (data['custom-tax-or-not'] == 'A' || data['custom-tax-or-not'] == 'N') {
                    //稅外加以及免稅額，都使用原始的稅前單價
                    no_tax_price = no_tax_price * (1 + _tax_rate);
                } else {
                    no_tax_price = no_tax_price;
                }
            }
            //console.log("3@" + no_tax_price);
            if (discountEnable) {
                var discount = data['custom-discount'][key] * 1;

                try {
                    // 需要測試的語句
                    if (discount == '') {
                        throw "no discount";
                    }
                    no_tax_price = no_tax_price * (discount / 100);
                }
                catch (e) {
                    no_tax_price = no_tax_price / (100 / 100);
                }

                //將本次使用的discount記錄起來
                old_discount[key] = discount;
            }
            //console.log("4@" + no_tax_price);
            //==========計算單價===================結束


            //單價四捨五入至指定的小數位數
            var rf = _no_tax_price_round_off;
            no_tax_price = Math.round(no_tax_price * Math.pow(10, rf));
            no_tax_price = no_tax_price / Math.pow(10, rf);
            no_tax_amount = quantity * no_tax_price;

            //小計四捨五入至指定的小數位數
            var rf = _no_tax_price_round_off;
            no_tax_amount = Math.round(no_tax_amount * Math.pow(10, rf));
            no_tax_amount = no_tax_amount / Math.pow(10, rf);

            data['custom-no-tax-price'][key] = no_tax_price;
            data['custom-subtotal'][key] = no_tax_amount;

            total_no_tax_amount += no_tax_amount;
        }

        //稅前合計四捨五入至指定的小數位數
        var rf = _total_amount_round_off;
        total_no_tax_amount = Math.round(total_no_tax_amount * Math.pow(10, rf));
        total_no_tax_amount = total_no_tax_amount / Math.pow(10, rf);

        //稅額四捨五入至指定的小數位數
        tax = total_no_tax_amount * _tax_rate;
        if (data['custom-tax-or-not'] == 'N') {
            tax = 0;
        }
        var rf = _tax_round_off;
        tax = Math.round(tax * Math.pow(10, rf));
        tax = tax / Math.pow(10, rf);

        //總計金額四捨五入至指定的小數位數
        total_amount = total_no_tax_amount + tax
        var rf = _total_amount_round_off;
        total_amount = Math.round(total_amount * Math.pow(10, rf));
        total_amount = total_amount / Math.pow(10, rf);

        data['custom-total-no-tax-amount'] = total_no_tax_amount;
        data['custom-tax']                 = tax;
        data['custom-total-amount']        = total_amount;

        if (taxEnable) {
            old_tax_type = data['custom-tax-or-not'];
        }
        //開始把資料拋回html文件
        push(data);
    }
    //在編輯畫面時，可以設定折扣
    MyObj.setDiscountByIndex = function (index, value) {
        old_discount[index] = value;
        $('.custom-discount').eq(index).val(value);
    }
}

function Puller() {
    MyObj = this;

    /**
     * 依據id_list提供的id抓出數值
     * 並且回傳data
     * @return {object} data
     */
    MyObj.pullByClassName = function (enables) {
        var data = {};
        //抓出表頭項目
        data['custom-total-no-tax-amount'] = $('.custom-total-no-tax-amount').eq(0).val();
        data['custom-tax'] = $('.custom-tax').eq(0).val();
        data['custom-total-amount'] = $('.custom-total-amount').eq(0).val();

        //抓出表身項目
        //數量
        data['custom-quantity'] = [];
        i = 0;
        $('.custom-quantity').each(function (index, ele) {
            data['custom-quantity'][i] = ele.value;
            i ++;
        });
        //折扣
        data['custom-discount'] = [];
        i = 0;
        $('.custom-discount').each(function (index, ele) {
            data['custom-discount'][i] = ele.value;
            i ++;
        });
        //單價
        data['custom-no-tax-price'] = [];
        i = 0;
        $('.custom-no-tax-price').each(function (index, ele) {
            data['custom-no-tax-price'][i] = ele.value;
            i ++;
        });
        //小計
        data['custom-subtotal'] = [];
        i = 0;
        $('.custom-subtotal').each(function (index, ele) {
            data['custom-subtotal'][i] = ele.value;
            i ++;
        });

        //抓出稅別

        data['custom-tax-or-not'] = $('.custom-tax-or-not:checked').val();

        return data;
    }
}

/**
 {{Javascript Class}}
 * push數值放回html元素
 */
function Pusher() {
    // 因為 this 容易產生誤解，所以指定為 oComponent
    MyObj = this;
    /**
     * 依據data提供的id把數值push回去
     * @param  {object} data 放置數值的陣列
     * @return {void}
     */
    MyObj.pushByClassName = function (data, enables) {
        $('.custom-total-no-tax-amount').eq(0).val(data['custom-total-no-tax-amount']);
        $('.custom-tax').eq(0).val(data['custom-tax']);
        $('.custom-total-amount').eq(0).val(data['custom-total-amount']);

        $('.custom-quantity').each(function (index, ele) {
            ele.value = data['custom-quantity'][index];
        });

        $('.custom-no-tax-price').each(function (index, ele) {
            ele.value = data['custom-no-tax-price'][index];
        });

        $('.custom-subtotal').each(function (index, ele) {
            ele.value = data['custom-subtotal'][index];
        });
    }
}

$.widget('custom.quantity', {
    defaultElement: "<input>",
    options: {
        //delay: 300,

        // Callbacks
        keyup: null,
        blur: null,
    },
    _create: function () {
        //console.log(this.options.keyup);
        this.element
            .addClass('custom-quantity');

        //綁定事件
        this._on( this.element, {
            // blur: function() {
            //     this.options.blur();
            // },
            keyup: function() {
                this.options.keyup();
            },
        });
    },
    _destroy: function() {
        this.element.unbind();
        this.element
            .removeClass('custom-quantity');
    },
});

$.widget('custom.discount', {
    defaultElement: "<input>",
    options: {
        //delay: 300,
        keyup: null,
    },
    _create: function () {
        //console.log(this.options.keyup);
        this.element
            .addClass('custom-discount');

        //綁定事件
        this._on( this.element, {
            keyup: function() {
                this.options.keyup();
            },
        });
    },
    _destroy: function() {
        this.element.unbind();
        this.element
            .removeClass('custom-discount');
    },
});

$.widget('custom.no_tax_price', {
    defaultElement: "<input>",
    options: {
        //delay: 300,

        // Callbacks
        keyup: null,
        blur: null,
    },
    _create: function () {
        //console.log(this.options.keyup);
        this.element
            .addClass('custom-no-tax-price');

        //綁定事件
        this._on( this.element, {
            // blur: function() {
            //     this.options.blur();
            // },
            keyup: function() {
                this.options.keyup();
            },
        });
    },
    _destroy: function() {
        this.element.unbind();
        this.element
            .removeClass('custom-quantity');
    },
});

$.widget('custom.subtotal', {
    defaultElement: "<input>",
    _create: function () {
        this.element
            .addClass('custom-subtotal');
    },
    _destroy: function() {
        this.element
            .removeClass('custom-quantity');
    },
});

$.widget('custom.tax_or_not', {
    defaultElement: "<input>",
    options: {
        //delay: 300,

        // Callbacks
        change: null,
        click: null,
    },
    _create: function () {
        //console.log(this.options.keyup);
        this.element
            .addClass('custom-tax-or-not');

        //綁定事件
        this._on( this.element, {
            change: function() {
                this.options.change();
            },
            click: function() {
                this.options.click();
            },
        });
    },
    _destroy: function() {
        this.element.unbind();
        this.element
            .removeClass('custom-quantity');
    },
});

$.widget("custom.total_no_tax_amount", {
    defaultElement: "<input>",
    _create: function () {
        this.element
            .addClass('custom-total-no-tax-amount');
    },
    _destroy: function() {
        this.element
            .removeClass('custom-quantity');
    },
});

$.widget("custom.tax", {
    defaultElement: "<input>",
    _create: function () {
        this.element
            .addClass('custom-tax');
    },
    _destroy: function() {
        this.element
            .removeClass('custom-quantity');
    },
});

$.widget("custom.total_amount", {
    defaultElement: "<input>",
    _create: function () {
        this.element
            .addClass('custom-total-amount');
    },
    _destroy: function() {
        this.element
            .removeClass('custom-quantity');
    },
});