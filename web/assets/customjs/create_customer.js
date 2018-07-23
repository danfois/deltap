var CustomerForm = function () {
    var i;
    var e;
    var t = $('#form_customer');

    return {
        init: function () {
            var r;
            i = t.validate({
                ignore: ":hidden",
                rules: {
                    'create_customer[business_name]': {required: !0, maxlength: 160},
                    'create_customer[phone]': {maxlength: 12},
                    'create_customer[mobile]': {maxlength: 12},
                    'create_customer[fax]': {maxlength: 12},
                    'create_customer[email]': {required: !0, maxlength: 32, email: true},
                    'create_customer[vat]': {maxlength: 12},
                    'create_customer[cf]': {maxlength: 16},
                    'create_customer[website]': {maxlength: 255},
                    'create_customer[category]': {required: !0},
                    'create_customer[cuu]': {maxlength: 32},
                    'create_customer[tags]': {maxlength: 255},
                    'create_customer[fullAddress][address]': {required: !0, maxlength: 200},
                    'create_customer[fullAddress][zone]': {maxlength: 120},
                    'create_customer[fullAddress][cap]': {required: !0, maxlength: 6},
                    'create_customer[fullAddress][city]': {required: !0, maxlength: 32},
                    'create_customer[fullAddress][region]': {required: !0, maxlength: 2},
                    'create_customer[fullAddress][country]': {required: !0, maxlength: 32},
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
                            text: data,
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
};


var CategoryForm = function () {
    var i;
    var e;
    var t = $('#form_category');

    return {
        init: function () {
            var r;
            i = t.validate({
                ignore: ":hidden",
                rules: {
                    'create_category[category_name]': {required: !0, maxlength: 64}
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
                            text: "Categoria creata con successo!",
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        });
                        mApp.unblockPage();
                        updateCategorySelect();
                        t[0].reset();
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
            $("#create_customer_fullAddress_city").typeahead(null, {
                name: "citta",
                display: "comune",
                source: n,
                templates: {
                    empty: ['<div class="empty-message" style="padding: 5px 15px; text-align: center;">', "Nessun suggerimento disponibile", "</div>"].join("\n"),
                    suggestion: Handlebars.compile("<div><strong>{{comune}}</strong> – {{provincia}}, {{cap}}</div>")
                }
            }).on('typeahead:selected', function (ev, data) {
                $('#create_customer_fullAddress_cap').val(data.cap);
                $('#create_customer_fullAddress_region').val(data.provincia);
                $('#create_customer_fullAddress_country').val('Italia');
            })
        }
    }
}();

var findMaxValue = function (element) {
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

var updateCategorySelect = function () {
    var categoryNamefield = $('#create_category_category_name');
    var categorySelectField = $('#create_customer_category');
    var maxValue = findMaxValue(categorySelectField);
    var currentValue;

    if (isNaN(maxValue) || maxValue === 0 || maxValue === undefined) {
        currentValue = 1;
    } else {
        currentValue = maxValue + 1;
    }

    categorySelectField.append($('<option>', {
        value: currentValue,
        text: categoryNamefield.val()
    }));
};

jQuery(document).ready(function () {
    CustomerForm().init();
    CategoryForm().init();
    Typeahead.init();
});