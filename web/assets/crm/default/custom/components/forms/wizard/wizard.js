var WizardDemo = function () {
    var i, e, n = $("#m_wizard"), t = $("#m_form");
    return {
        init: function () {
            var r;
            n = $("#m_wizard"), t = $("#m_form"), (e = n.mWizard({startStep: 1})).on("beforeNext", function (e) {
                if (!0 !== i.form())return !1
            }), e.on("change", function (e) {
                mUtil.scrollTop();
                //inserire qua il corpo della funzione onchange aggiuntivo
                $("#ic_username").html($("#users_username").val());
                $("#ic_password").html($("#users_password").val());
                $("#ic_roles").html($("#users_roles").val());
                $("#ic_status").html($("#users_status").val());
                $("#ic_conc_ass").html($("#users_id_conc_ass option:selected").text());
                $("#ic_distr_ass").html($("#users_id_distr_ass option:selected").text());
                $("#ic_ag_ass").html($("#users_id_ag_ass option:selected").text());
                $("#ic_nome").html($("#users_anagrafica_nome").val());
                $("#ic_cognome").html($("#users_anagrafica_cognome").val());
                $("#ic_piva").html($("#users_anagrafica_piva").val());
                $("#ic_ragione_sociale").html($("#users_anagrafica_ragione_sociale").val());
                $("#ic_sede_legale").html($("#users_anagrafica_sede_legale").val());
                $("#ic_telefono").html($("#users_anagrafica_telefono").val());
                $("#ic_email").html($("#users_anagrafica_email").val());
                $("#ic_website").html($("#users_anagrafica_website").val());
            }), i = t.validate({
                ignore: ":hidden",
                rules: {
                    name: {required: !0},
                    email: {required: !0, email: !0},
                    phone: {required: !0, phoneUS: !0},
                    address1: {required: !0},
                    city: {required: !0},
                    state: {required: !0},
                    city: {required: !0},
                    country: {required: !0},
                    account_url: {required: !0, url: !0},
                    account_username: {required: !0, minlength: 4},
                    account_password: {required: !0, minlength: 6},
                    account_group: {required: !0},
                    "account_communication[]": {required: !0},
                    billing_card_name: {required: !0},
                    billing_card_number: {required: !0, creditcard: !0},
                    billing_card_exp_month: {required: !0},
                    billing_card_exp_year: {required: !0},
                    billing_card_cvv: {required: !0, minlength: 2, maxlength: 3},
                    billing_address_1: {required: !0},
                    billing_address_2: {},
                    billing_city: {required: !0},
                    billing_state: {required: !0},
                    billing_zip: {required: !0, number: !0},
                    billing_delivery: {required: !0},
                    accept: {required: !0}
                },
                messages: {
                    "account_communication[]": {required: "You must select at least one communication option"},
                    accept: {required: "Devi spuntare la casella di conferma!"}
                },
                invalidHandler: function (e, r) {
                    mUtil.scrollTop(), swal({
                        title: "",
                        text: "Ci sono alcuni errori nel form.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    })
                },
                submitHandler: function (e) {
                }
            }), (r = t.find('[data-wizard-action="submit"]')).on("click", function (e) {
                e.preventDefault(), i.form() && (mApp.progress(r), t.ajaxSubmit({
                    success: function () {
                        mApp.unprogress(r), swal({
                            title: "",
                            text: "L'account è stato creato con successo!",
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        })
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
                        console.log(e);
                    }
                }))
            })
        }
    }
}();
jQuery(document).ready(function () {
    WizardDemo.init()
});