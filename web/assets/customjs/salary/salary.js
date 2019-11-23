var SalaryForm = function () {
    var i;
    var e;
    var t = $('#form_salary');

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
                // correctSalaryForm();s
                // t = $('#form_salary');
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "info",
                    message: "Caricamento..."
                });
                i.form() && (mApp.progress(r), t.ajaxSubmit({
                    success: function (response) {
                        mApp.unprogress(r);
                        swal({
                            title: "",
                            html: response,
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        });
                        if($('.m-portlet__head-text').text().indexOf('Modifica') !== -1) {

                        } else {
                            t.resetForm();
                        }
                        mApp.unblockPage();
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

function correctSalaryForm() {
    var sdInputs = $('input[name*="salaryDetails"], select[name*="salaryDetails"]');
    sdInputs.each(function() {
       if($(this).attr('name').indexOf('payment') !== -1) return;
       var currentName = $(this).attr('name');
       var splittedName = currentName.split("]");
       var newName = splittedName[0] + "]" + splittedName[1] + "]" + "[payment]" + splittedName[2] + "]";
       $(this).attr('name', newName);
       console.log(newName);
    });
}

jQuery(document).ready(function () {
    SalaryForm().init();

    $(document).on('change',"input", function(){calculateTotal()});

    $('.repeater').repeater({
        initEmpty: false,
        show: function () {
            $(this).slideDown();
            initializeWidgets();
        },
        hide: function (deleteElement) {
            if(confirm('Sicuro di voler rimuovere questo elemento?')) {
                $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: false
    });


    initializeWidgets();

    $('select').select2({
        placeholder: "Nessuno/a"
    });

});
