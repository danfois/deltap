var SnippetLogin = function() {
    var s = $("#m_login"),
        n = function(e, i, a) {
            var r = $('<div class="m-alert m-alert--outline alert alert-' + i + ' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
            e.find(".alert").remove(), r.prependTo(e), r.animateClass("fadeIn animated"), r.find("span").html(a)
        },
        o = function() { s.removeClass("m-login--forget-password"), s.removeClass("m-login--signup"), s.addClass("m-login--signin"), s.find(".m-login__signin").animateClass("flipInX animated") },
        e = function() { $("#m_login_forget_password").click(function(e) { e.preventDefault(), s.removeClass("m-login--signin"), s.removeClass("m-login--signup"), s.addClass("m-login--forget-password"), s.find(".m-login__forget-password").animateClass("flipInX animated") }), $("#m_login_forget_password_cancel").click(function(e) { e.preventDefault(), o() }), $("#m_login_signup").click(function(e) { e.preventDefault(), s.removeClass("m-login--forget-password"), s.removeClass("m-login--signin"), s.addClass("m-login--signup"), s.find(".m-login__signup").animateClass("flipInX animated") }), $("#m_login_signup_cancel").click(function(e) { e.preventDefault(), o() }) };
    return {
        init: function() {
            e(), /*$("#m_login_signin_submit").click(function(e) {
                e.preventDefault();
                var l = $(this),
                    t = $(this).closest("form");
                t.validate({ rules: { email: { required: !0, email: !0 }, password: { required: !0 } } }), t.valid() && (l.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), t.ajaxSubmit({ url: "", success: function(e, i, a, r) { setTimeout(function() { l.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1), n(t, "danger", "Incorrect username or password. Please try again.") }, 2e3) } }))
            }),*/ $("#m_login_signup_submit").click(function(e) {
                e.preventDefault();
                var l = $(this),
                    t = $(this).closest("form");
                t.validate({ rules: { fullname: { required: !0 }, email: { required: !0, email: !0 }, password: { required: !0 }, rpassword: { required: !0 }, agree: { required: !0 } } }), t.valid() && (l.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), t.ajaxSubmit({
                    url: "",
                    success: function(e, i, a, r) {
                        setTimeout(function() {
                            l.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1), t.clearForm(), t.validate().resetForm(), o();
                            var e = s.find(".m-login__signin form");
                            e.clearForm(), e.validate().resetForm(), n(e, "success", "Thank you. To complete your registration please check your email.")
                        }, 2e3)
                    }
                }))
            }), $("#m_login_forget_password_submit").click(function(e) {
                e.preventDefault();
                var l = $(this),
                    t = $(this).closest("form");
                t.validate({ rules: { email: { required: !0, email: !0 } } }), t.valid() && (l.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), t.ajaxSubmit({
                    url: "",
                    success: function(e, i, a, r) {
                        setTimeout(function() {
                            l.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1), t.clearForm(), t.validate().resetForm(), o();
                            var e = s.find(".m-login__signin form");
                            e.clearForm(), e.validate().resetForm(), n(e, "success", "Cool! Password recovery instruction has been sent to your email.")
                        }, 2e3)
                    }
                }))
            })
        }
    }
}();
jQuery(document).ready(function() { SnippetLogin.init() });