var ServiceForm = function () {
    var i;
    var e;
    var t = $('#form_service');

    return {
        init: function () {
            var r;
            i = t.validate({
                ignore: ":hidden",
                rules:
                    {
                        'create_service[service]': { required: !0, maxlength:120 },
                        'create_service[service_code]': { required: !0, maxlength:5 }
                    },
                messages: {},
                invalidHandler: function (e, r) {
                    mApp.scrollTop();
                    swal({
                        title: "",
                        text: "Ci sono errori nel form, per favore correggili.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    })
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
                            text: "Servizio creato con successo!",
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        });
                        mApp.unblockPage();
                        updateServiceSelect();
                        t[0].reset();
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


var findMaxServiceValue = function (element) {
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

var updateServiceSelect = function () {
    var serviceNameField = $('#create_service_service');
    var serviceSelects = $('.service_select');

    serviceSelects.each(function() {
        var maxValue = findMaxServiceValue(this);
        var currentValue;

        if (isNaN(maxValue) || maxValue === 0 || maxValue === undefined) {
            currentValue = 1;
        } else {
            currentValue = maxValue + 1;
        }

        $(this).append($('<option>', {
            value: currentValue,
            text: serviceNameField.val()
        }));
        console.log(this);
    });
};


jQuery(document).ready(function () {
    ServiceForm().init();
});
