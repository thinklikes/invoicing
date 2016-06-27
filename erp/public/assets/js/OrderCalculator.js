// /**
//  {{Javascript Class}}
//  * 抓出id為帶入參數的html元素之數值
//  */
function ValuePullerByHtmlId() {
    // 因為 this 容易產生誤解，所以指定為 oComponent
    MyObj = this;

    /**
     * 依據id_list提供的id抓出數值
     * 並且回傳data
     * @return {array} data
     */
    MyObj.pull = function (class_name) {
        var data = {};
        //抓出表頭項目
        for (key in class_name.master) {
            var thisClass = class_name.master[key];
            data[thisClass] = document.getElementsByClassName(thisClass)[0].value;
        }
        //抓出表身項目
        for (key in class_name.detail) {
            var thisClass = class_name.detail[key];

            data[thisClass] = [];
            var length = document.getElementsByClassName(thisClass).length;
            for (i = 0;i < length; i ++) {
                data[thisClass][i] = document.getElementsByClassName(thisClass)[i].value;
            }
        }
        //抓出稅別
        var thisClass = class_name.tax_rate_code;

        data[thisClass] = '';
        var length = document.getElementsByClassName(thisClass).length;
        for (i = 0;i < length; i ++) {
            if (document.getElementsByClassName(thisClass)[i].checked) {
                data[thisClass] = document.getElementsByClassName(thisClass)[i].value;
                break;
            }
        }
        return data;
    }
}

/**
 {{Javascript Class}}
 * push數值放回html元素
 */
function ValuePusherByHtmlId() {
    // 因為 this 容易產生誤解，所以指定為 oComponent
    MyObj = this;
    /**
     * 依據data提供的id把數值push回去
     * @param  {object} data 放置數值的陣列
     * @return {void}
     */
    MyObj.push = function (data, class_name) {
        for(key in class_name.master) {
            var thisClass = class_name.master[key];
            document.getElementsByClassName(thisClass)[0].value = data[thisClass];
        }
        for(key in class_name.detail) {
            var thisClass = class_name.detail[key];
            var length = document.getElementsByClassName(thisClass).length;
            for (i = 0;i < length; i ++) {
                document.getElementsByClassName(thisClass)[i].value = data[thisClass][i];
            }
        }
    }
}


function OrderCalculator(class_name) {
    MyObj=this;
    //constructor
    var class_name   = class_name;
    var old_tax_type = 'A';
    var puller       = null;
    var pusher       = null;
    var data         = null;

    var pull = function () {
        puller = null;
        puller = new ValuePullerByHtmlId();
        return puller.pull(class_name);
    }

    var push = function (data) {
        puller = null;
        pusher = new ValuePusherByHtmlId();
        pusher.push(data, class_name);
    }

    MyObj.calculate = function () {
        var total_no_tax_amount = 0;
        var tax                 = 0;
        var total_amount        = 0;
        var push_data           = [];
        //開始自html文件中取出資料
        data = pull();
        //console.table(data);
        // //開始計算金額
        for (key in data[class_name.detail.quantity]) {
            var quantity      = data[class_name.detail.quantity][key] * 1;
            var no_tax_price  = data[class_name.detail.no_tax_price][key] * 1;
            var no_tax_amount = 0;

            if (old_tax_type == 'A' && data[class_name.tax_rate_code] == 'I') {
                no_tax_price = no_tax_price / (1 + _tax_rate);
            } else if (old_tax_type == 'I' && data[class_name.tax_rate_code] == 'A') {
                no_tax_price = no_tax_price * (1 + _tax_rate);
            } else {
                no_tax_price = no_tax_price;
            }

            //單價四捨五入至指定的小數位數
            var rf = _no_tax_price_round_off;
            no_tax_price = Math.round(no_tax_price * Math.pow(10, rf));
            no_tax_price = no_tax_price / Math.pow(10, rf);
            no_tax_amount = quantity * no_tax_price;

            //小計四捨五入至指定的小數位數
            var rf = _no_tax_price_round_off;
            no_tax_amount = Math.round(no_tax_amount * Math.pow(10, rf));
            no_tax_amount = no_tax_amount / Math.pow(10, rf);

            data[class_name.detail.no_tax_price][key] = no_tax_price;
            data[class_name.detail.no_tax_amount][key] = no_tax_amount;

            total_no_tax_amount += no_tax_amount;
        }

        //稅前合計四捨五入至指定的小數位數
        var rf = _total_amount_round_off;
        total_no_tax_amount = Math.round(total_no_tax_amount * Math.pow(10, rf));
        total_no_tax_amount = total_no_tax_amount / Math.pow(10, rf);

        //稅額四捨五入至指定的小數位數
        tax = total_no_tax_amount * _tax_rate;
        var rf = _tax_round_off;
        tax = Math.round(tax * Math.pow(10, rf));
        tax = tax / Math.pow(10, rf);

        //總計金額四捨五入至指定的小數位數
        total_amount = total_no_tax_amount + tax
        var rf = _total_amount_round_off;
        total_amount = Math.round(total_amount * Math.pow(10, rf));
        total_amount = total_amount / Math.pow(10, rf);

        data[class_name.master.total_no_tax_amount] = total_no_tax_amount;
        data[class_name.master.tax]                 = tax;
        data[class_name.master.total_amount]        = total_amount;

        old_tax_type = data[class_name.tax_rate_code];
        //開始把資料拋回html文件

        push(data);
    }
}