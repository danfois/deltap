var PriceQuotation = function () {
    var i;
    var e;
    var n = $("#m_wizard");
    var t = $("#form_price_quotation_detail");
    return {
        init: function () {
            var r;
            n = $("#m_wizard");
            t = $("#form_price_quotation_detail"),


                (e = n.mWizard({startStep: 1})).on("beforeNext", function () {
                    if (!0 !== i.form()) return !1;
                    LastStep();
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
                    success: function (response) {
                        mApp.unprogress(r);
                        swal({
                            title: "",
                            html: response,
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        });
                        mApp.unblockPage();
                        var valore = $('#price_quotation_detail_priceQuotation option:selected').text().split('-');
                        if (valore[1] === undefined) {
                            valore = $('#price_quotation_detail_edit_priceQuotation option:selected').text().split('-');
                            if (valore[0] === undefined || valore[1] === undefined) {
                                setTimeout(window.history.back, 1500)
                            }
                        }
                        setTimeout(window.location.href='price-quotations-list/' + valore[0] + '-' + valore[1] , 2500);
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


var TypeAheadPrefetch = function () {
    var n;
    n = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("comune"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: "/json-places"
    });
    return n;
};


var TypeAheadWidget = function () {
    $(".place_autocomplete").typeahead(null, {
        name: "citta",
        display: "comune",
        source: window.comuni,
        templates: {
            empty: ['<div class="empty-message" style="padding: 5px 15px; text-align: center;">', "Nessun suggerimento disponibile", "</div>"].join("\n"),
            suggestion: Handlebars.compile("<div><strong>{{comune}}</strong> – {{provincia}}, {{cap}}</div>")
        }
    });
    $('.place_autocomplete').removeClass('place_autocomplete');
};


function createValidationObjects() {
    var ValidationObject = {
        'price_quotation_detail[code]': {required: !0, maxlength: 12},
        'price_quotation_detail[priceQuotationDate]': {required: !0},
        'price_quotation_detail[customer]': {required: !0, maxlength: 255},
        'price_quotation_detail[receiver_mail]': {required: !0, maxlength: 64, email: true},
        'price_quotation_detail[sender_mail]': {required: !0, maxlength: 64, email: true},
        'price_quotation_detail[service_code]': {required: !0},
        'price_quotation_detail[status]': {required: !0},
        'accept': {required: !0}
    };

    for (var i = 0; i < 10; i++) {
        ValidationObject['price_quotation_details[stages][' + i + '][departureLocation]'] = {
            required: !0,
            maxlength: 120
        };
        ValidationObject['price_quotation_details[stages][' + i + '][arrivalLocation]'] = {
            required: !0,
            maxlength: 120
        };
        ValidationObject['price_quotation_details[stages][' + i + '][description]'] = {required: !0};
        ValidationObject['price_quotation_details[stages][' + i + '][departureDate]'] = {required: !0};
        ValidationObject['price_quotation_details[stages][' + i + '][arrivalDate]'] = {required: !0};
        ValidationObject['price_quotation_details[stages][' + i + '][busNumber]'] = {required: !0, maxlength: 2};
        ValidationObject['price_quotation_details[stages][' + i + '][passengers]'] = {required: !0, maxlength: 3};
        ValidationObject['price_quotation_details[stages][' + i + '][km]'] = {maxlength: 12};
        ValidationObject['price_quotation_details[stages][' + i + '][estimatedTime]'] = {maxlength: 12};
        ValidationObject['price_quotation_details[stages][' + i + '][price]'] = {required: !0, maxlength: 12};
        ValidationObject['price_quotation_details[stages][' + i + '][vat]'] = {required: !0, maxlength: 5};
        ValidationObject['price_quotation_details[stages][' + i + '][status]'] = {required: !0};
    }

    return ValidationObject;
}

jQuery(document).ready(function () {
    PriceQuotation.init();
    PriceQuotationFormRepeater.init();
    window.comuni = TypeAheadPrefetch();
    TypeAheadWidget();
    initializeWidgets();
});
