var ReportForm = function () {
    var i;
    var e;
    var t = $('#form_report');

    return {
        init: function () {
            var r;
            i = t.validate({
                ignore: ":hidden",
                rules:
                    {
                        //todo: eventualmente aggiungere delle cose per la validazione
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
                            html: response,
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        });
                        mApp.unblockPage();
                        //todo: inserire il redirect alla lista dopo averlo modificato
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

var calculateTotalKm = function() {
    var startKm = $('#report_startKm').val();
    var endKm = $('#report_endKm').val();

    if(startKm != 0 && endKm != 0) {
        $('#report_totalKm').val(Math.round((endKm - startKm) * 100) / 100);
    }

};

jQuery(document).ready(function () {
    ReportForm().init();
    initializeWidgets();

    $('#report_startKm').on('focusout', function() {
        calculateTotalKm();
    });

    $('#report_endKm').on('focusout', function() {
        calculateTotalKm();
    })
});
