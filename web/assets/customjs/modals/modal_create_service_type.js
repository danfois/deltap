var ServiceTypeForm = function () {
    var i;
    var e;
    var t = $('#form_service_type');

    return {
        init: function () {
            var r;
            i = t.validate({
                ignore: ":hidden",
                rules:
                    {
                        'create_service_type[service_name]': { required: !0, maxlength:24 }
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
                    success: function (url) {
                        mApp.unprogress(r);
                        swal({
                            title: "",
                            text: "Tipo Servizio creato con successo!",
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        });
                        updateServiceTypeSelect();
                        t[0].reset();
                        mApp.unblockPage();
                    },
                    error: function(e) {
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
};


var findMaxServiceTypeValue = function (element) {
    var maxValue = 0;
    $('option', element).each(function () {
        var val = $(this).attr('value');
        val = parseInt(val, 10);
        if (maxValue === undefined || maxValue < val) {
            maxValue = val;
        }
    });
    return maxValue;
};

var updateServiceTypeSelect = function () {
    var serviceTypeNameField = $('#create_service_type_service_name');
    var serviceTypeSelects = $('.service_type_select');

    serviceTypeSelects.each(function() {
        var maxValue = findMaxServiceValue(this);
        var currentValue;

        if (isNaN(maxValue) || maxValue === 0 || maxValue === undefined) {
            currentValue = 1;
        } else {
            currentValue = maxValue + 1;
        }

        $(this).append($('<option>', {
            value: currentValue,
            text: serviceTypeNameField.val()
        }));
        console.log(this);
    });
};


jQuery(document).ready(function () {
    ServiceTypeForm().init();
});
