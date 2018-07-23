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
    CategoryForm().init();
});