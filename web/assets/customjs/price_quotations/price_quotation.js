var PriceQuotation = function () {
    var i;
    var e;
    var t = $("#form_price_quotation");
    return {
        init: function () {
            var r;
            t = $("#form_price_quotation");
            i = t.validate({
                ignore: ":hidden",
                rules: createValidationObjects(),
                messages: {},
                invalidHandler: function (e, r) {
                    mApp.scrollTop();
                    swal({
                        title: "",
                        text: "Ci sono alcuni errori nel form.",
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

                //I need this function because jQuery Repeater is setting wrong names on repeated fields
                adjustRepeatedForms();

                i.form() && (mApp.progress(r), t.ajaxSubmit({
                    success: function (response) {
                        mApp.unprogress(r);
                        swal({
                            title: "",
                            html: response,
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        });
                        mApp.unblockPage();
                        $('.m_datatable').mDatatable('reload');
                    },
                    error: function (e) {
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
}();

var PriceQuotationFormRepeater = {
    init: function () {
        $(".repeater").repeater({
            initEmpty: !1,
            defaultValues: {"text-input": "foo"},
            show: function () {
                $(this).slideDown();
            }
        });
    }
};

var generateLetter = function () {
    return {
        init: function () {
            var $form = $('#price_quotation_form');
            $('#generate_letter').on("click", function () {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "info",
                    message: "Generando la Lettera..."
                });
                $.ajax({
                    url: window.location.protocol + "//" + window.location.host + '/generate-letter',
                    type: 'POST',
                    data: $form.serialize(),
                    success: function (data) {
                        $('.note-editable').html(data);
                        mApp.unblockPage();
                    },
                    error: function (err) {
                        $('.note-editable').html(err);
                        mApp.unblockPage();
                    }
                });
            });
        }
    };
}();

function createValidationObjects() {
    return {
        'price_quotation[code]': {required: !0, maxlength: 12},
        'price_quotation[quotationDate]': {required: !0},
        'price_quotation[customer]': {required: !0, maxlength: 255},
        'price_quotation[recipientEmail]': {required: !0, maxlength: 64, email: true},
        'price_quotation[senderMail]': {required: !0, maxlength: 64, email: true},
        'price_quotation[serviceCode]': {required: !0},
        'price_quotation[status]': {required: !0}
    };
}

var initializeWidgets = function () {
    $(".date_picker").datepicker({
        todayHighlight: !0,
        orientation: "top right",
        format: 'dd/mm/yyyy',
        templates: {leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>'}
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

function adjustRepeatedForms() {
    $('*[id*=priceQuotationDetails]').each(function () {
        $(this).attr('name', function (i, o) {
            return o.slice(0, -3);
        })
    });
};

jQuery(document).ready(function () {
    PriceQuotation.init();
    PriceQuotationFormRepeater.init();
    generateLetter.init();
    initializeWidgets();
});
