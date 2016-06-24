$(function() {
    //綁定日期選取的事件
    $( "input.datepicker" ).datepicker({
        buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        showOn: 'button',
        dateFormat: "yy-mm-dd",
    });
});