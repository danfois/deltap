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

var TypeAheadWidget = function () {
    var n;
    n = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("title"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: "/vehicle/brands"
    });

    var m;
    m = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("title"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: "/vehicle/models"
    });

    $("#vehicle_brand").typeahead(null, {
        name: "modello",
        display: "title",
        source: n,
        templates: {
            empty: ['<div class="empty-message" style="padding: 5px 15px; text-align: center;">', "Nessun suggerimento disponibile", "</div>"].join("\n"),
            suggestion: Handlebars.compile("<div><strong>{{title}}</strong></div>")
        }
    });

    $("#vehicle_model").typeahead(null, {
        name: "modello",
        display: "title",
        source: m,
        templates: {
            empty: ['<div class="empty-message" style="padding: 5px 15px; text-align: center;">', "Nessun suggerimento disponibile", "</div>"].join("\n"),
            suggestion: Handlebars.compile("<div><strong>{{title}}</strong></div>")
        }
    });
};

function createValidationObjects() {
    return {
        'vehicle[plate]': {required: !0, maxlength: 10},
        'vehicle[exPlate]': {maxlength: 10},
        'vehicle[carRegistrationNumber]': {maxlength: 64},
        'vehicle[brand]': {maxlength: 64},
        'vehicle[seats]': {maxlength: 3},
        'vehicle[stands]': {maxlength: 3},
        'vehicle[width]': {maxlength: 12},
        'vehicle[length]': {maxlength: 12},
        'vehicle[financing]': {maxlength: 128},
        'vehicle[useDestination]': {maxlength: 128},
        'vehicle[bodyWork]': {maxlength: 64},
        'vehicle[frame]': {maxlength: 20},
        'vehicle[tires]': {maxlength: 64},
        'vehicle[alternateTires]': {maxlength: 64},
        'vehicle[regionalAuthorization]': {maxlength: 64},
        'vehicle[areation]': {maxlength: 32},
        'vehicle[passengersSeated]': {maxlength: 12},
        'vehicle[passengersStanding]': {maxlength: 12},
        'vehicle[emergencyExits]': {maxlength: 1},
        'vehicle[engineNumber]': {maxlength: 32},
        'vehicle[omologationNumber]': {maxlength: 24},
        'vehicle[maximumLoadMass]': {maxlength: 12},
        'vehicle[category]': {maxlength: 24},
        'vehicle[axesNumber]': {maxlength: 1},
        'vehicle[engineCapacity]': {maxlength: 5},
        'vehicle[powerKw]': {maxlength: 5},
        'vehicle[notes]': {maxlength: 255}
    };
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
    TypeAheadWidget();
    initializeWidgets();
});
