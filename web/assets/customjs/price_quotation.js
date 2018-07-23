var PriceQuotation = function () {
    var i;
    var e;
    var n = $("#m_wizard");
    var t = $("#price_quotation_form");
    return {
        init: function () {
            var r;
            n = $("#m_wizard");
            t = $("#price_quotation_form"),


                (e = n.mWizard({startStep: 1})).on("beforeNext", function () {
                    if (!0 !== i.form()) return !1
                }),

                e.on("change", function () {
                    mApp.scrollTop();
                }),

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
            (r = t.find('[data-wizard-action="submit"]')).on("click", function (e) {
                e.preventDefault();
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "info",
                    message: "Caricamento..."
                });
                i.form() && (mApp.progress(r), t.ajaxSubmit({
                    success: function (data) {
                        mApp.unprogress(r);
                        swal({
                            title: "",
                            text: "Preventivo Salvato con Successo",
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        });
                        mApp.unblockPage();
                    },
                    error: function (e) {
                        mApp.unprogress(r);
                        swal({
                            title: "",
                            text: e.responseText,
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


function createValidationObjects() {
    var ValidationObject = {
        'price_quotation[quotation_code]': {required: !0, maxlength: 12},
        'price_quotation[quotation_date]': {required: !0},
        'price_quotation[customer]': {required: !0, maxlength: 255},
        'price_quotation[receiver_mail]': {required: !0, maxlength: 64, email: true},
        'price_quotation[sender_mail]': {required: !0, maxlength: 64, email: true},
        'price_quotation[service_code]': {required: !0},
        'price_quotation[status]': {required: !0},
        'price_quotation[letter][status]': {required: !0}
    };

    for (var i = 0; i < 10; i++) {
        ValidationObject['price_quotation[quotationDetails][' + i + '][departure]'] = {required: !0, maxlength: 120};
        ValidationObject['price_quotation[quotationDetails][' + i + '][arrival]'] = {required: !0, maxlength: 120};
        ValidationObject['price_quotation[quotationDetails][' + i + '][description]'] = {required: !0};
        ValidationObject['price_quotation[quotationDetails][' + i + '][departure_date]'] = {required: !0};
        ValidationObject['price_quotation[quotationDetails][' + i + '][arrival_date]'] = {required: !0};
        ValidationObject['price_quotation[quotationDetails][' + i + '][bus_number]'] = {required: !0, maxlength: 2};
        ValidationObject['price_quotation[quotationDetails][' + i + '][passengers]'] = {required: !0, maxlength: 3};
        ValidationObject['price_quotation[quotationDetails][' + i + '][estimated_km]'] = {maxlength: 12};
        ValidationObject['price_quotation[quotationDetails][' + i + '][estimated_time]'] = {maxlength: 12};
        ValidationObject['price_quotation[quotationDetails][' + i + '][price]'] = {required: !0, maxlength: 12};
        ValidationObject['price_quotation[quotationDetails][' + i + '][vat]'] = {required: !0, maxlength: 5};
        ValidationObject['price_quotation[quotationDetails][' + i + '][status]'] = {required: !0};
        ValidationObject['price_quotation[quotationDetails][' + i + '][vat_type]'] = {required: !0};
        ValidationObject['price_quotation[quotationDetails][' + i + '][service_type]'] = {required: !0};
        ValidationObject['price_quotation[quotationDetails][' + i + '][service_code]'] = {required: !0};
    }

    return ValidationObject;
}


jQuery(document).ready(function () {
    PriceQuotation.init();
    $('#users_roles').removeAttr('multiple');
    $(".tspin").TouchSpin({
        buttondown_class: "btn btn-secondary",
        buttonup_class: "btn btn-secondary",
        min: 0,
        max: 99,
        step: 1,
        decimals: 0,
        boostat: 5,
        maxboostedstep: 10,
        prefix: "%"
    });
});


jQuery(document).ready(function () {
    $(".quantita_prodotto_field").TouchSpin({
        buttondown_class: "btn btn-secondary",
        buttonup_class: "btn btn-secondary",
        min: 0,
        max: $(this).attr('data-max'),
        step: 1,
        decimals: 0,
        boostat: 5,
        maxboostedstep: 10
    });
});