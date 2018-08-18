var editUnavailability = function (id) {
    mApp.blockPage({
        overlayColor: "#000000",
        type: "loader",
        state: "info",
        message: "Caricamento..."
    });

    $.ajax({
        method: 'GET',
        url: 'edit-unavailability-' + id,
        data: {'id': id},
        dataType: 'html',
        success: function (response) {
            $('#modal_ajax_content').html(response);
            UnavailabilityEditForm().init();
            initializeWidgets();
            $('#edit_unavailability_modal').modal();
            mApp.unblockPage();
        },
        error: function (e) {
            swal({
                title: "",
                html: e.responseText,
                type: "error",
                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
            });
            mApp.unblockPage();
        }
    })
};

var UnavailabilityEditForm = function () {
    var i;
    var e;
    var t = $('#form_unavailability_edit');

    return {
        init: function () {
            var r;
            i = t.validate({
                ignore: ":hidden",
                rules:
                    {
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
                    message: "Modifico indisponibilità..."
                });
                i.form() && (mApp.progress(r), t.ajaxSubmit({
                    success: function (response) {
                        mApp.unprogress(r);
                        swal({
                            title: "",
                            text: "Indisponibilità modificata con successo!",
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        });
                        mApp.unblockPage();
                        $('#edit_unavailability_modal').modal('hide');
                        $('.m_datatable').mDatatable('reload');
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
