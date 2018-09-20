var ServiceOrderForm = function () {
    var i;
    var e;
    var t = $('#form_service_order');

    return {
        init: function () {
            var r;
            i = t.validate({
                ignore: ":hidden",
                rules:
                    {
                        'create_category[category_name]': { required: !0, maxlength:64 }
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
                            html: r,
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

jQuery(document).ready(function () {
    ServiceOrderForm().init();
});
