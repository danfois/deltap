var UnavailabilityForm = function () {
    var i;
    var e;
    var t = $('#form_unavailability');

    return {
        init: function () {
            var r;
            i = t.validate({
                ignore: ":hidden",
                rules:
                    {
                    },
                messages: {},
                invalidHandler: function (e, r) {
                    mApp.scrollTop();
                    swal({
                        title: "",
                        text: "Ci sono errori nel form, per favore correggili.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    });
                    mApp.unblockPage();
                },
                submitHandler: function (e) {
                }
            });
            (r = t.find(':submit')).on("click", function (e) {
                e.preventDefault();
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "info",
                    message: "Caricamento..."
                });
                i.form() && (mApp.progress(r), t.ajaxSubmit({
                    success: function (response) {
                        mApp.unprogress(r);
                        swal({
                            title: "",
                            text: "Indisponibilità creata con successo!",
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        });
                        t[0].reset();
                        mApp.unblockPage();
                    },
                    error: function(e) {
                        mApp.unprogress(r);
                        swal({
                            title: "",
                            html: e.responseText,
                            type: "error",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        });
                        mApp.unblockPage();
                    }
                }))
            })
        }
    }
};


var initializeWidgets = function () {
    $(".date_picker").datepicker({
        todayHighlight: !0,
        orientation: "bottom right",
        templates: {leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>'},
        format: 'dd/mm/yyyy'
    });

    $(".time_picker").timepicker({
        minuteStep: 1,
        defaultTime: "",
        showSeconds: 0,
        showMeridian: !1,
        snapToStep: !0
    });

    $(".touch_spin").TouchSpin({
        buttondown_class: "btn btn-secondary",
        buttonup_class: "btn btn-secondary",
        min: 0,
        max: 999999,
        step: .01,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10
    });

    $(".int_touch_spin").TouchSpin({
        buttondown_class: "btn btn-secondary",
        buttonup_class: "btn btn-secondary",
        min: 0,
        max: 999999,
        step: 1,
        decimals: 0,
        boostat: 5,
        maxboostedstep: 10
    });
};

jQuery(document).ready(function () {
    UnavailabilityForm().init();
    initializeWidgets();
});
