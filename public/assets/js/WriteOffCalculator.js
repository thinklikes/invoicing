function WriteOffCalculator(
    cCheckboxClass, cAmountClass, cTotalAmountClass,
    dCheckboxClass, dAmountClass, dTotalAmountClass)
{
    MyObj=this;

    var class_name = {};
    class_name.credit = {};
    class_name.debit  = {};

    class_name.credit.checkbox_class     = cCheckboxClass;
    class_name.credit.amount_class       = cAmountClass;
    class_name.total_credit_amount_class = cTotalAmountClass;
    class_name.debit.checkbox_class      = dCheckboxClass;
    class_name.debit.amount_class        = dAmountClass;
    class_name.total_debit_amount_class  = dTotalAmountClass;

    function pull()
    {
        var data = {};
        //開始抓出貸方資訊
        //參考用的元素
        var rClass = class_name.credit.checkbox_class;

        var length = document.getElementsByClassName(rClass).length;

        for (key in class_name.credit) {
            thisClass = class_name.credit[key];

            data[thisClass] = [];

            for (i = 0; i < length; i++) {
                if (key == 'checkbox_class') {
                    data[thisClass][i] = document.getElementsByClassName(thisClass)[i].checked;
                } else {
                    data[thisClass][i] = document.getElementsByClassName(thisClass)[i].value * 1;
                }
            }
        }
        //開始抓出借方資訊
        //參考用的元素
        var rClass = class_name.debit.checkbox_class;

        var length = document.getElementsByClassName(rClass).length;

        for (key in class_name.debit) {
            thisClass = class_name.debit[key];

            data[thisClass] = [];

            for (i = 0; i < length; i++) {
                if (key == 'checkbox_class') {
                    data[thisClass][i] = document.getElementsByClassName(thisClass)[i].checked;
                } else {
                    data[thisClass][i] = document.getElementsByClassName(thisClass)[i].value * 1;
                }
            }
        }

        return data;
    }
    function push(param)
    {
        for (key in param) {
            thisClass = key;
            document.getElementsByClassName(thisClass)[0].value = param[key];
        }

    }
    MyObj.calculate = function ()
    {
        var data = pull();
        var total_credit_amount = 0;
        var total_debit_amount = 0;

        for (i = 0; i < data[class_name.credit.checkbox_class].length; i ++) {
            if (data[class_name.credit.checkbox_class][i]) {
                total_credit_amount += data[class_name.credit.amount_class][i];
            }
        }

        for (i = 0; i < data[class_name.debit.amount_class].length; i ++) {
            if (data[class_name.debit.checkbox_class][i]) {
                total_debit_amount += data[class_name.debit.amount_class][i];
            }
        }

        var push_elements = {};

        push_elements[class_name.total_credit_amount_class] = total_credit_amount;

        push_elements[class_name.total_debit_amount_class] = total_debit_amount;

        push(push_elements);
    }
}
