var initializeWidgets = function () {
    $(".date_picker").datepicker({
        todayHighlight: !0,
        orientation: "bottom right",
        format: 'dd/mm/yyyy',
        templates: {leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>'}
    });

    $(".date_time_picker").datetimepicker({
        todayHighlight: !0,
        autoclose: !0,
        format: "dd/mm/yyyy hh:ii"
    });

    $(".time_picker").timepicker({
        minuteStep: 1,
        defaultTime: "",
        showSeconds: 0,
        showMeridian: !1,
        snapToStep: !0
    });

    $('.time_picker').timepicker().on('changeTime.timepicker', function(e) {
        var timePicked = $('.time_picker').val();

        if(timePicked.length < 5)
            $(this).val("0" + timePicked);
    });

    $(".touch_spin").TouchSpin({
        buttondown_class: "btn btn-secondary",
        buttonup_class: "btn btn-secondary",
        min: 0,
        max: 99999999,
        step: .01,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10
    });

    $(".int_touch_spin").TouchSpin({
        buttondown_class: "btn btn-secondary",
        buttonup_class: "btn btn-secondary",
        min: 0,
        max: 99999999,
        step: 1,
        decimals: 0,
        boostat: 5,
        maxboostedstep: 10
    });

    $('.time_picker').on('click', function() {
        $(this).val('');
    });
};

