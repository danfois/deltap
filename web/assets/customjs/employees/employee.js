var EmployeeForm = function () {
    var i;
    var e;
    var t = $('#form_employee');

    return {
        init: function () {
            var r;
            i = t.validate({
                ignore: ":hidden",
                rules: {
                    'employee[name]': {required: !0, maxlength: 64},
                    'employee[surname]': {required: !0, maxlength: 64},
                    'employee[phone]': {maxlength: 12},
                    'employee[mobile]': {maxlength: 12},
                    'employee[fax]': {maxlength: 12},
                    'employee[email]': {required: !0, maxlength: 32, email: true},
                    'employee[cf]': {maxlength: 16},
                    'employee[fullAddress][address]': {required: !0, maxlength: 200},
                    'employee[fullAddress][zone]': {maxlength: 120},
                    'employee[fullAddress][cap]': {required: !0, maxlength: 6},
                    'employee[fullAddress][city]': {required: !0, maxlength: 32},
                    'employee[fullAddress][region]': {required: !0, maxlength: 2},
                    'employee[fullAddress][country]': {required: !0, maxlength: 32},
                    'employee[employeeCode]':{required : !0, maxlength : 11},
                    'employee[admission]':{required : !0},
                    'employee[payGrade]':{required : !0, maxlength : 64}
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
            $("#employee_fullAddress_city").typeahead(null, {
                name: "citta",
                display: "comune",
                source: n,
                templates: {
                    empty: ['<div class="empty-message" style="padding: 5px 15px; text-align: center;">', "Nessun suggerimento disponibile", "</div>"].join("\n"),
                    suggestion: Handlebars.compile("<div><strong>{{comune}}</strong> – {{provincia}}, {{cap}}</div>")
                }
            }).on('typeahead:selected', function (ev, data) {
                $('#employee_fullAddress_cap').val(data.cap);
                $('#employee_fullAddress_region').val(data.provincia);
                $('#employee_fullAddress_country').val('Italia');
            })
        }
    }
}();

jQuery(document).ready(function () {
    EmployeeForm().init();
    Typeahead.init();
    initializeWidgets();
});
