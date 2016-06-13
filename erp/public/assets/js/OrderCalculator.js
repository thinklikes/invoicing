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
    MyObj.pull = function (id_list) {
        var data = {};
        for (key in id_list['master']) {
            id = id_list['master'][key];
            data[id] = document.getElementById(id).value * 1;
        }
        for (key in id_list['detail']) {
            for (key2 in id_list['detail'][key]) {
                id = id_list['detail'][key][key2];
                data[id] = document.getElementById(id).value * 1;
            }
        }
        return data;
    }
}

// /**
//  {{Javascript Class}}
//  * push數值放回html元素
//  */
function ValuePusherByHtmlId() {
    // 因為 this 容易產生誤解，所以指定為 oComponent
    MyObj = this;
    /**
     * 依據data提供的id把數值push回去
     * @param  {object} data 放置數值的陣列
     * @return {void}
     */
    MyObj.push = function (data) {
        for(key in data) {
            id = key;
            document.getElementById(id).value = data[id];
        }
    }
}


function OrderCalculator() {
    MyObj=this;
    //constructor
    var id_list      = null;
    var tax_type     = '';
    var old_tax_type = 'A';
    var puller       = null;
    var pusher       = null;
    var data         = null;

    var pull = function (id_list) {
        puller = null;
        puller = new ValuePullerByHtmlId()
        return puller.pull(id_list);
    }

    var push = function (data) {
        puller = null;
        pusher = new ValuePusherByHtmlId();
        pusher.push(data);
    }

    MyObj.setIdList = function (id_list_input) {
        id_list = id_list_input;
    }

    MyObj.setTaxType = function (tax_type_input) {
        old_tax_type = tax_type;
        tax_type     = tax_type_input;
    }

    MyObj.calculate = function () {
        var total_no_tax_amount = 0;
        var tax                 = 0;
        var total_amount        = 0;
        var push_data           = [];
        //開始自html文件中取出資料
        data = pull(id_list);

        //開始計算金額
        for (key in id_list['detail']) {
            var quantity_id      = id_list['detail'][key]['quantity'];
            var no_tax_price_id  = id_list['detail'][key]['no_tax_price'];
            var no_tax_amount_id = id_list['detail'][key]['no_tax_amount'];

            if (old_tax_type == 'A' && tax_type == 'I') {
                data[no_tax_price_id] = data[no_tax_price_id] / (1 + _tax_rate);
            } else if (old_tax_type == 'I' && tax_type == 'A') {
                data[no_tax_price_id] = data[no_tax_price_id] * (1 + _tax_rate);
            } else {
                data[no_tax_price_id] = data[no_tax_price_id];
            }

            //單價四捨五入至指定的小數位數
            var rf = _no_tax_price_round_off;
            data[no_tax_price_id] = Math.round(data[no_tax_price_id] * Math.pow(10, rf));
            data[no_tax_price_id] = data[no_tax_price_id] / Math.pow(10, rf);

            data[quantity_id]      = data[quantity_id];
            data[no_tax_amount_id] = data[quantity_id] * data[no_tax_price_id];

            //小計四捨五入至指定的小數位數
            var rf = _no_tax_price_round_off;
            data[no_tax_amount_id] = Math.round(data[no_tax_amount_id] * Math.pow(10, rf));
            data[no_tax_amount_id] = data[no_tax_amount_id] / Math.pow(10, rf);

            push_data[no_tax_price_id]  = data[no_tax_price_id];
            push_data[no_tax_amount_id] = data[no_tax_amount_id];

            total_no_tax_amount += data[no_tax_amount_id];
        }

        var total_no_tax_amount_id = id_list['master']['total_no_tax_amount'];
        var tax_id                 = id_list['master']['tax'];
        var total_amount_id        = id_list['master']['total_amount'];

        //稅前合計四捨五入至指定的小數位數
        data[total_no_tax_amount_id] = total_no_tax_amount;
        var rf                       = _total_amount_round_off;
        data[total_no_tax_amount_id] = Math.round(data[total_no_tax_amount_id] * Math.pow(10, rf));
        data[total_no_tax_amount_id] = data[total_no_tax_amount_id] / Math.pow(10, rf);

        //稅額四捨五入至指定的小數位數
        data[tax_id] = total_no_tax_amount * _tax_rate;
        var rf       = _tax_round_off;
        data[tax_id] = Math.round(data[tax_id] * Math.pow(10, rf));
        data[tax_id] = data[tax_id] / Math.pow(10, rf);

        //總計金額四捨五入至指定的小數位數
        data[total_amount_id]       = data[total_no_tax_amount_id] + data[tax_id]
        var rf                      = _total_amount_round_off;
        data[total_amount_id] = Math.round(data[total_amount_id] * Math.pow(10, rf));
        data[total_amount_id] = data[total_amount_id] / Math.pow(10, rf);

        push_data[total_no_tax_amount_id] = data[total_no_tax_amount_id];
        push_data[tax_id]                 = data[tax_id];
        push_data[total_amount_id]        = data[total_amount_id];

        //開始把資料拋回html文件
        push(push_data);
    }
}