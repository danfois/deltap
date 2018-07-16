var UserForm = function () {
    var i;
    var e;
    var t = $('#form_user');

    return {
        init: function () {
            var r;
            i = t.validate({
                ignore: ":hidden",
                rules:
                    {
                        'create_user[username]': { required: !0, minlength:4 },
                        'create_user[password]': { required: !0, minlength:4 },
                        'create_user[roles][]'   : { required: !0 }
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
                i.form() && (mApp.progress(r), t.ajaxSubmit({
                    success: function () {
                        mApp.unprogress(r);
                        swal({
                            title: "",
                            text: "Il Prodotto è stato creato con successo!",
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        })
                    },
                    error: function(e) {
                        mApp.unprogress(r);
                        swal({
                            title: "",
                            text: e.responseText,
                            type: "error",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        })
                    }
                }))
            })
        }
    }
};

jQuery(document).ready(function () {
    UserForm();
    $('#create_user_roles').removeAttr('multiple');
});
