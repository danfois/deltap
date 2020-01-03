var CourseForm = function () {
    var i;
    var e;
    var t = $('#form_course');

    return {
        init: function () {
            var r;
            i = t.validate({
                ignore: ":hidden",
                invalidHandler: function (e, r) {
                    mUtil.scrollTop();
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
                    success: function (url) {
                        mApp.unprogress(r);
                        swal({
                            title: "",
                            text: "Corso salvato con successo",
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        });
                        t[0].reset();
                        updateCourseTable(url);
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

var updateCourseTable = function() {
    $.ajax({
        method: 'GET',
        url: '/generate-course-table',
        success: function(r) {
            $('#course_table').html(r);
        }
    })
};

jQuery(document).ready(function () {
    CourseForm().init();
    updateCourseTable();

    $('#generic_modal').on('hidden.bs.modal', updateCourseTable);
});
