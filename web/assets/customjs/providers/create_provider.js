var ProviderForm = function () {
    var i;
    var e;
    var t = $('#form_provider');

    return {
        init: function () {
            var r;
            i = t.validate({
                ignore: ":hidden",
                rules: {
                    'provider[business_name]': {required: !0, maxlength: 160},
                    'provider[phone]': {maxlength: 12},
                    'provider[mobile]': {maxlength: 12},
                    'provider[fax]': {maxlength: 12},
                    'provider[email]': {required: !0, maxlength: 128, email: true},
                    'provider[vat]': {maxlength: 12},
                    'provider[cf]': {maxlength: 16},
                    'provider[website]': {maxlength: 255},
                    'provider[category]': {required: !0},
                    'provider[cuu]': {maxlength: 32},
                    'provider[tags]': {maxlength: 255},
                    'provider[fullAddress][address]': {required: !0, maxlength: 200},
                    'provider[fullAddress][zone]': {maxlength: 120},
                    'provider[fullAddress][cap]': {required: !0, maxlength: 6},
                    'provider[fullAddress][city]': {required: !0, maxlength: 32},
                    'provider[fullAddress][region]': {required: !0, maxlength: 2},
                    'provider[fullAddress][country]': {required: !0, maxlength: 32},
                },
                messages: {},
                invalidHandler: function (e, r) {
                    mUtil.scrollTop();
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
                    success: function (data) {
                        mApp.unprogress(r);
                        swal({
                            title: "",
                            html: data,
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        });
                        mApp.unblockPage();
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
};

var Typeahead = function () {
    return {
        init: function () {
            var n;
            n = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace("comune"),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: "/json-places"
            });
            $("#provider_fullAddress_city").typeahead(null, {
                name: "citta",
                display: "comune",
                source: n,
                templates: {
                    empty: ['<div class="empty-message" style="padding: 5px 15px; text-align: center;">', "Nessun suggerimento disponibile", "</div>"].join("\n"),
                    suggestion: Handlebars.compile("<div><strong>{{comune}}</strong> – {{provincia}}, {{cap}}</div>")
                }
            }).on('typeahead:selected', function (ev, data) {
                $('#provider_fullAddress_cap').val(data.cap);
                $('#provider_fullAddress_region').val(data.provincia);
                $('#provider_fullAddress_country').val('Italia');
            })
        }
    }
}();

jQuery(document).ready(function () {
    ProviderForm().init();
    Typeahead.init();
});
