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
                rules: {
                    'users[password]': {required:!0, maxlength:16},
                    'users[roles][]' : {required:!0},
                    'users[sconto][sconto_1]': {required:!0, number : true},
                    'users[sconto][sconto_2]': {required:!0, number : true},
                    'users[sconto][sconto_3]': {required:!0, number : true},
                    'users[sconto][provvigione_1]': {required:!0, number : true},
                    'users[sconto][provvigione_2]': {required:!0, number : true},
                    'users[sconto][provvigione_3]': {required:!0, number : true},
                    'users[anagrafica][nome]' : {required:!0 },
                    'users[anagrafica][cognome]' : {required:!0 },
                    'users[anagrafica][piva]' : {required:!0, number:true, minlength: 11, maxlength:11 },
                    'users[anagrafica][email]' : {required:!0, email:true}
                },
                messages: {
                    'users[password]' : {
                        maxlength : "La password deve essere lunga la massimo 16 caratteri"
                    },
                    'users[sconto][sconto_1]' : {
                        number : "Lo Sconto deve essere un numero intero"
                    },
                    'users[sconto][sconto_2]' : {
                        number : "Lo Sconto deve essere un numero intero"
                    },
                    'users[sconto][sconto_3]' : {
                        number : "Lo Sconto deve essere un numero intero"
                    },
                    'users[sconto][provvigione_1]' : {
                        number : "Lo Sconto deve essere un numero intero"
                    },
                    'users[sconto][provvigione_2]' : {
                        number : "Lo Sconto deve essere un numero intero"
                    },
                    'users[sconto][provvigione_3]' : {
                        number : "Lo Sconto deve essere un numero intero"
                    },
                    'users[anagrafica][piva]' : {
                        minlength: "La P. Iva deve essere lunga 11 caratteri",
                        maxlength: "La P. Iva deve essere lunga 11 caratteri"
                    },
                    accept: {required: "Devi spuntare la casella di conferma!"}
                },
                invalidHandler: function (e, r) {
                    mApp.scrollTop(), swal({
                        title: "",
                        text: "Ci sono alcuni errori nel form.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    })
                },
                submitHandler: function (e) {
                }
            }), (r = t.find('[data-wizard-action="submit"]')).on("click", function (e) {
                e.preventDefault(),  mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "info",
                    message: "Caricamento..."
                }),  /*$('#users_roles').attr('multiple', 'multiple'),*/ i.form() && (mApp.progress(r), t.ajaxSubmit({
                    success: function (res) {

                            mApp.unprogress(r), swal({
                                title: "",
                                text: "Hai effettuato l'ordine con successo! Abbiamo inviato alla tua email i dati al quale effettuare il pagamento",
                                type: "success",
                                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                            })
                        mApp.unblockPage();
                        setTimeout(function() { window.location.href= '/'; } , 3000);

                    },
                    error: function(e) {
                        var errorText;
                        for(var tt in e.responseJSON) {
                            if(e.responseJSON.hasOwnProperty(tt) && tt !== undefined) {
                                errorText = (errorText || '') +  e.responseJSON[tt] + '; \n\n';
                            }
                        }
                        mApp.unprogress(r), swal({
                            title: "",
                            text: errorText,
                            type: "error",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        })
                        mApp.unblockPage()
                        console.log(e);
                    }
                }))
            })
        }
    }
}();
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



jQuery(document).ready(function() {
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