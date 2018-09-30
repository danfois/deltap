var InvoiceForm = function () {
    var i;
    var e;
    var t = $('#form_invoice');

    return {
        init: function () {
            var r;
            i = t.validate({
                ignore: ":hidden",
                rules:
                    {
                        'issued_invoice[causal]' : { required : !0, maxlength : 255},
                        'issued_invoice[invoiceNumber]' : { required : !0, maxlength : 11},
                        'issued_invoice[paInvoiceNumber]' : { maxlength : 11}
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

jQuery(document).ready(function () {
    InvoiceForm().init();

    $(document).on('change',"input", function(){calculateTotal()});

    $('.repeater').repeater({
        initEmpty: false,
        show: function () {
            $(this).slideDown();
            initializeWidgets();
        },
        hide: function (deleteElement) {
            if(confirm('Sicuro di voler rimuovere questo elemento?')) {
                $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: true
    });

    initializeWidgets();

});
