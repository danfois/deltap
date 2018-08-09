var VehicleForm = function () {
    var i;
    var e;
    var t = $("#form_vehicle");
    return {
        init: function () {
            var r;
            t = $("#form_vehicle");
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
                            text: "Veicolo Salvato con Successo",
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
        'price_quotation[quotation_code]': {required: !0, maxlength: 12},
        'price_quotation[quotation_date]': {required: !0},
        'price_quotation[customer]': {required: !0, maxlength: 255},
        'price_quotation[receiver_mail]': {required: !0, maxlength: 64, email: true},
        'price_quotation[sender_mail]': {required: !0, maxlength: 64, email: true},
        'price_quotation[service_code]': {required: !0},
        'price_quotation[status]': {required: !0},
        'price_quotation[letter][status]': {required: !0},
        'accept': {required: !0}
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

var initializeWidgets = function () {
    $(".date_picker").datepicker({
        todayHighlight: !0,
        orientation: "top right",
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

jQuery(document).ready(function () {
    VehicleForm.init();
    window.comuni = TypeAheadPrefetch();
    TypeAheadWidget();
    initializeWidgets();
});
